<?php

namespace API\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UsersController extends AbstractActionController
{
	protected $viewModel;

    public function indexAction()
    {
		$users = [
			['nom' => 'Suraski', 'prenom' => 'Zeev'],
			['nom' => 'Gutmans', 'prenom' => 'Andi']
		];

        $this->viewModel = new ViewModel(array('users' => $users));

        return $this->viewModel;
    }


}

