<?php
namespace Media\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class File
{
    protected $id;
    protected $title;
    protected $description;
    protected $link;
    protected $size;
    protected $extension;
    protected $category;
    protected $uploaded;
    protected $updated;
    protected $inputFilter;

    public function setTitle($title){
        $this->title = $title;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function setLink($link){
        $this->link = $link;
    }

    public function setSize($size){
        $this->size = $size;
    }

    public function setExtension($extension){
        $this->extension = $extension;
    }

    public function setCategory($category){
        $this->category = $category;
    }

    public function setUploaded($uploaded){
        $this->uploaded = $uploaded;
    }

    public function setUpdated($updated){
        $this->updated = $updated;
    }

    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getLink(){
        return $this->link;
    }

    public function getSize(){
        return $this->size;
    }

    public function getExtension(){
        return $this->extension;
    }

    public function getCategory(){
        return $this->category;
    }

    public function getUploaded(){
        return $this->uploaded;
    }

    public function getUpdated(){
        return $this->updated;
    }

    public function exchangeArray($data)
    {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->title  = (isset($data['title'])) ? $data['title'] : null;
        $this->description  = (isset($data['description'])) ? $data['description'] : null;
        $this->link  = (isset($data['link'])) ? $data['link'] : null;
        $this->size  = (isset($data['size'])) ? $data['size'] : null;
        $this->extension  = (isset($data['extension'])) ? $data['extension'] : null;
        $this->category  = (isset($data['category'])) ? $data['category'] : null;
        $this->uploaded  = (isset($data['uploaded'])) ? $data['uploaded'] : null;
        $this->updated  = (isset($data['updated'])) ? $data['updated'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name' => 'id',
                'required' => true,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'title',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 100,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'description',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 0,
                            'max' => 255,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'link',
                'required' => true,
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'size',
                'required' => true,
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'extension',
                'required' => true,
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'category',
                'required' => true,
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'uploaded',
                'required' => true,
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'updated',
                'required' => true,
            )));

            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}