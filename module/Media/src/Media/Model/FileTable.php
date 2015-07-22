<?php
namespace Media\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class FileTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select(function (Select $select) {
            $select->order('category ASC');
        });
        return $resultSet;
    }

    public function getFile($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveFile(File $file)
    {
        $data = array(
            'title'  => $file->getTitle(),
            'description'  => $file->getDescription(),
            'link'  => $file->getLink(),
            'size'  => $file->getSize(),
            'extension'  => $file->getExtension(),
            'category'  => $file->getCategory(),
            'uploaded'  => $file->getUploaded(),
            'updated'  => date('Y-m-d H:i:s')
        );

        $id = (int)$file->getId();
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getFile($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteFile($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}