<?php

namespace Login\Controller;

use Zend\Form\Annotation\Object;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Login\Form\LoginForm;
use Login\Model\Login;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Employee\Model\Employee;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{

    public function indexAction()
    {    	
        return new ViewModel(
        	array(
        		'flashMessages' => $this->flashMessenger()->getMessages()
        	)		
        );
    }
    
    public function loginAction()
    {
    	$messages = array();
    	$loginForm = new LoginForm('LoginForm');
    	$formRequest = $this->getRequest();
    	
    	if ($formRequest->isPost()){
    		$login = new Login();    		
    		$loginForm->setInputFilter($login->getInputFilter());
    		$loginForm->setData($formRequest->getPost());
    		if ($loginForm->isValid()) {
    			$login->exchangeArray($loginForm->getData());
    			$loginData = $this->getTableObject('Employee\Model\EmployeeTable')->getUserLoginData($login);    			
    			if (!empty($loginData->id)){
    				$sessionContainer = new Container('application');
    				$sessionArray = array('loginId' => $loginData->id,'loginName' => $loginData->empId);
    				$sessionContainer->userData = (Object) $sessionArray;    				
    				$this->flashMessenger()->addMessage('User has been logged in');
    				return $this->redirect()->toRoute('application/default',array('controller' => 'index', 'action' => 'index'));
    			} else {
    				$this->flashMessenger()->addMessage('User does not exists, please enter valid details');
    				return $this->redirect()->toRoute('login/default',array('controller' => 'index', 'action' => 'login'));
    			}
    		} else {
    			$messages = $loginForm->getMessages();
    			$this->flashMessenger()->clearCurrentMessages();
    		}
    	}
    	
    	return new ViewModel(
    		array(
    			'form' => $loginForm,
    			'messages' => $messages,
    			'flashMessages' => $this->flashMessenger()->getMessages()
    		)
    	);
    }
    
    /**
     * It destroy session and logout from AMI.
     *
     * @method logoutAction
     * @return Redirect
     */
    public function logoutAction()
    {
    	$viewModel = new ViewModel();
    	$viewModel->setTerminal(true);
    	$sessionContainer = new \Zend\Session\Container('application');
    	$sessionContainer->getManager()->destroy();
    	return $this->redirect()->toRoute('login/default',array('controller' => 'index', 'action' => 'login'));
    }

    public function getTableObject($tablePath)
    {
    	$table = '';
    
    	if ($tablePath != '') {
    		$serviceLocator = $this->getServiceLocator();
    		$table = $serviceLocator->get($tablePath);
    	}
    
    	return $table;
    }
}

