<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Users\Form\RegisterForm;
use Users\Form\LoginForm;

class RegisterController extends AbstractActionController
{

    public function indexAction()
    {
    	$form = new LoginForm();

        return new ViewModel(array('form' => $form));
    }


}

