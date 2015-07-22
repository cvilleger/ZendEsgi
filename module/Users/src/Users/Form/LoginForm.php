<?php
namespace Users\Form;

use Zend\Form\Form;

	class LoginForm extends Form
	{
	    public function __construct() {
	        parent::__construct('LoginForm');
	        $this->setAttribute('method', 'post');
	        $this->setAttribute('enctype', 'multipart/form-data');
	        $this->add([
	        	'name' => 'email', 
	        	'attributes' => [
	        		'type' => 'text',
	        		'required' => 'required',
	        	],
	        	'options' => [
	        		'label' => 'Adresse mail',
	        	]
	        ]);
	        $this->add([
	        	'name' => 'password', 
	        	'attributes' => [
	        		'type' => 'password',
	        		'required' => 'required',
	        	],
	        	'options' => [
	        		'label' => 'Mot de passe',
	        	]
	        ]);
	        $this->add([
	        	'name' => 'confPassword', 
	        	'attributes' => [
	        		'type' => 'password',
	        		'required' => 'required',
	        	],
	        	'options' => [
	        		'label' => 'Confirmation du mot de passe',
	        	]
	        ]);
	        $this->add([
	        	'name' => 'save', 
	        	'attributes' => [
	        		'type' => 'submit',
	        		'value' => 'Enregistrer'
	        	]
	        ]);
	    }
	}