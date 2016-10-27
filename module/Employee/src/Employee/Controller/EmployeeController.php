<?php

namespace Employee\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Employee\Model\Employee;
use Employee\Form\AddForm;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Session\Container;

class EmployeeController extends AbstractActionController
{
	protected $userId;
	
	/**
	 * default constructor
	 */
	public function __construct() {
		$sessionContainer = new Container('application');
		if (isset($sessionContainer->userData->loginId) && !empty($sessionContainer->userData->loginId)) {
			$this->userId = $sessionContainer->userData->loginId;
		} 
	}

	/**
	 * function to list all employee record
	 * @see Zend\Mvc\Controller.AbstractActionController::indexAction()
	 */
    public function indexAction()
    {
    	if (!isset($this->userId)) {
    		$this->redirect()->toRoute('login/default',array('controller' => 'index', 'action' => 'logout'));
    	}
    	
    	$paginator = $this->getTableObject('Employee\Model\EmployeeTable')->fetchAll(TRUE);
    	$configData = $this->getServiceLocator()->get('config');
    	$listPerPage = $configData['settings']['listPerPage'];
    	$listDateFormat = $configData['settings']['listDateFormat'];
    	$pageNumber = 1;
    	$pageQuery = (int) $this->params()->fromQuery('page', '');
    	$pageRoute = (int) $this->params()->fromRoute('page', '');
    	if (!empty($pageQuery)) {
    		$pageNumber = $pageQuery;
    	} elseif (!empty($pageRoute)) {
    		$pageNumber = $pageRoute;
    	}
    	$paginator->setCurrentPageNumber($pageNumber);
    	// set the number of items per page
    	$paginator->setItemCountPerPage($listPerPage);
    	$this->layout()->setTemplate('employee/home_layout');
        return new ViewModel(
        	array(
        		'paginator' => $paginator,
        		'pagenumber' => $pageNumber,
        		'listDateFormat' => $listDateFormat
        	)
        );
    }
    /**
     * function to add/edit the employee record
     */
    public function addAction()
    {
    	$viewModel = new ViewModel();
    	$formRequest = $this->getRequest();   
    	$allData = $this->params()->fromQuery();    	
    	$id = $this->params()->fromRoute('id', '');
    	$id = $this->params()->fromPost('id', $id);
    	
    	$pageNumber = $this->params()->fromRoute('page', 1);
    	$pageNumber = $this->params()->fromPost('page', $pageNumber);
    	
    	if (isset($allData['id'])){
    		$id = (int) $allData['id'];
    	}
    	    	
    	if (isset($allData['page'])) {
    		$pageNumber = $allData['page'];
    	}
    	
    	$formName = 'add';
    	    	
    	if (empty($id) && !isset($this->userId)) {     
    		//case of add without login
    		$this->layout()->setTemplate('login/layout');
    	} elseif (empty($id) && isset($this->userId)){
    		//case of add with login
    		$this->layout()->setTemplate('employee/home_layout');
    	} elseif (!empty($id) && !isset($this->userId)){
    		//case of edit without login
    		$this->layout()->setTemplate('login/layout');    		
    		//redirect to login page
    		$this->redirect()->toRoute('login/default',array('controller' => 'index', 'action' => 'logout'));
    	} else {
    		//case of edit with login
    		$this->layout()->setTemplate('employee/home_layout');
    		$formName = 'edit';
    	}
    	//echo $formName;die;
    	$registerForm = new AddForm($formName);    	
    	//echo $id.'------------>'.$pageNumber.'---------------->'.$formName;die;
    	
    	$messages = array();
    	$empData = array();
    	if ($formRequest->isPost()){
    		$employee = new Employee($formName);
    		$registerForm->setInputFilter($employee->getInputFilter());
    		$registerForm->setData($formRequest->getPost());
    		if ($registerForm->isValid()) {
    			$employee->exchangeArray($registerForm->getData());
    			if ($formName == 'add'){
    				$lastInsertId = $this->getTableObject('Employee\Model\EmployeeTable')->saveEmployee($employee);
    				$this->flashMessenger()->addMessage('The record has been created');
    				return $this->redirect()->toRoute('login/default',array('controller' => 'index', 'action' => 'login'));
    			} else {    				
    				$lastInsertId = $this->getTableObject('Employee\Model\EmployeeTable')->updateEmployee($employee);
    				$this->flashMessenger()->addMessage('The record has been updated');
    				return new JsonModel(array(
    						'success'=> true,
    				));
    				//return $this->redirect()->toRoute('employee/list',array('controller' => 'employee', 'action' => 'index','page' => $pageNumber));
    			}
    			
    		} else {
   				$empData['pageNumber'] = $pageNumber;
    			$registerForm->setData($empData);
    			$messages = $registerForm->getMessages();    			
    		}
    	} else {
    		if ($formName == 'add'){
    			$registerForm->get('submitbutton')->setAttribute('value','Add');
    		} else {
    			$registerForm->get('submitbutton')->setAttribute('value','Update');    			
    			if (!empty($id)) {
    				$empData = $this->getTableObject('Employee\Model\EmployeeTable')->getEmployeeData($id);
    				$empData['pageNumber'] = $pageNumber;
    			}
    			$registerForm->setData($empData);
    		}
    		$this->flashMessenger()->clearCurrentMessages();
    	}
    	$viewModel->setVariables(
    		array(
    			'form' => $registerForm,
    			'messages' => $messages,
    			'id' => $id,
    			'pageNumber' => $pageNumber,	
    			'formName' => $formName,
    			'flashMessages' => $this->flashMessenger()->getMessages()
    		)
    	);
    	
    	if ($formName=='edit')
    		$viewModel->setTerminal(true);
    	
    	return $viewModel;
    }    
    
    /**
     * function to delete the employee record
     */
    public function deleteAction()
    {
    	if (!isset($this->userId)) {
    		$this->redirect()->toRoute('login/default',array('controller' => 'index', 'action' => 'logout'));
    	}
    	$viewModel = new ViewModel();
    	$viewModel->setTerminal(true);
    	$id = $this->params()->fromRoute('id', '');
    	$pageNumber = $this->params()->fromRoute('page', 1);
    	if (!empty($id)) {
    		$this->getTableObject('Employee\Model\EmployeeTable')->deleteEmployee($id);
    		$this->flashMessenger()->addMessage('The record has been deleted');
    	}
    	return $this->redirect()->toRoute('employee/list',array('controller' => 'employee', 'action' => 'index', 'page'=> $pageNumber));
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

