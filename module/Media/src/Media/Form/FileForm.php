<?php 

namespace Media\Form;
 
use Zend\Form\Form;
 
class FileForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('file');
        $this->setAttribute('method', 'post');
        $this->setAttribute('enctype','multipart/form-data');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Titre du fichier',
            ),
        ));

        $this->add(array(
            'name' => 'desc',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Description',
            ),
        ));


        $this->add(array(
            'name' => 'link',
            'attributes' => array(
                'type'  => 'file',
            ),
            'options' => array(
                'label' => 'Fichier à uploader',
            ),
        ));

         
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Uploader'
            ),
        ));
    }
}