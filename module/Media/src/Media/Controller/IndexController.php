<?php

namespace Media\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator\File\Size;

use Media\Form\FileForm;
use Media\Model\File;
use Media\Model\Type;

class IndexController extends AbstractActionController
{

    protected $fileTable;

    public function getFileTable()
    {
        if (!$this->fileTable) {
            $sm = $this->getServiceLocator();
            $this->fileTable = $sm->get('Media\Model\FileTable');
        }
        return $this->fileTable;
    }

    public function indexAction()
    {
        return new ViewModel(array(
            'files' => $this->getFileTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new FileForm();
        $request = $this->getRequest();
        if ($request->isPost()) {

            $file = new File();
            // On vérifie la validité des champs
            $form->setInputFilter($file->getInputFilter());

            $nonFile = $request->getPost()->toArray();
            $params    = $this->params()->fromFiles('link');
            // On récupère l'extension du fichier
            $ext = new \Zend\File\PhpClassFile($params['name']);
            $ext = $ext->getExtension();
            // recherche de la catégorie
            $musique = array('mp3', 'flac', 'aac', 'wav');
            $video = array('mp4', 'avi', 'wmv', 'mov');
            $document = array('pdf', 'txt', 'ppt', 'pptx', 'xls', 'xlsx', 'doc', 'docx');
            $image = array('jpg', 'jpeg', 'gif', 'png');
            $cat = '';
            if(in_array($ext, $musique))
                $cat = 'musique';
            else if(in_array($ext, $video))
                $cat = 'video';
            else if(in_array($ext, $document))
                $cat = 'document';
            else if(in_array($ext, $image))
                $cat = 'image';

            $date = date('Y-m-d H:i:s');
            if($params['size'] < 100000)
                $size = round($params['size']/1000, 2) . ' Ko';
            else
                $size = round($params['size']/1000000, 2) . ' Mo';

            // renommage du fichier
            $newName = 'file'.time().'.'.$ext;

            // if you're using ZF >= 2.1.1
            $data    = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                array('link'=> $newName,
                    'size' => $size,
                    'extension' => $ext,
                    'category' => $cat,
                    'uploaded' => $date,
                    'updated' => $date)
            );

            $form->setData($data);
            $adapter = new \Zend\File\Transfer\Adapter\Http();
            // Liste d'extensions valides
            $listExt = Array();
            $types = array_merge_recursive($musique, $video, $document, $image);
            $extensionvalidator = new \Zend\Validator\File\Extension(array('extension'=>$listExt));
            $adapter->setValidators(array($extensionvalidator), $params['name']);

            // Taille maximum du fichier
            $maxSize = new Size(array('max'=>300000000)); //maximum bytes filesize
            $adapter->setValidators(array($maxSize), $params['name']);

            if (!$adapter->isValid()){
                $dataError = $adapter->getMessages();
                $error = array();
                foreach($dataError as $key=>$row)
                {
                    $error[] = $row;
                } //set formElementErrors
                $form->setMessages(array('link'=>$error ));
            } else {
                if ($form->isValid()) {
                    $adapter->addFilter('Rename', dirname(__DIR__).'/upload/'.$newName);
                    //$adapter->setDestination(dirname(__DIR__).'/upload');
                    if ($adapter->receive($params['name'])) {
                        $file->exchangeArray($form->getData());
                    }
                    $file->exchangeArray($form->getData());
                    $this->getFileTable()->saveFile($file);

                    return $this->redirect()->toRoute('media');
                }
            }
        }
        return new ViewModel(array('form' => $form));
    }

    public function deleteAction(){
        $this->getFileTable()->deleteFile($this->params('id'));

        return $this->redirect()->toRoute('media');
    }

    public function downloadAction(){
        $file = getcwd(). '/module/media/src/media/upload/' .$this->params('file');

        $response = new \Zend\Http\Response\Stream();
        $response->setStream(fopen($file, 'r'));
        $response->setStatusCode(200);
        $response->setStreamName(basename($file));
        $headers = new \Zend\Http\Headers();
        $headers->addHeaders(array(
            'Content-Disposition' => 'attachment; filename="' . basename($file) .'"',
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => filesize($file),
            'Expires' => '@0', // @0, because zf2 parses date as string to \DateTime() object
            'Cache-Control' => 'must-revalidate',
            'Pragma' => 'public'
        ));
        $response->setHeaders($headers);
        return $response;
    }
}

