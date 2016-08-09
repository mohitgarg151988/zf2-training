<?php

namespace RestfulApi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
use Employee\Model\EmployeeTable;
use Employee\Form\AddForm;
use Employee\Model\Employee;

class IndexController extends AbstractRestfulController
{    
	public function get($id)
	{
		//Action used for GET requests with resource Id
		$data = $this->getTableObject('Employee\Model\EmployeeTable')->getEmployeeData($id);
		return new JsonModel(	
            array(
            	'data' => $data
            )
        );
	}
	 
	public function getList()
	{
		$data = $this->getTableObject('Employee\Model\EmployeeTable')->fetchAll(FALSE);
		// Action used for GET requests without resource Id		
		return new JsonModel(	
            array(
            	'data' => $data
            )
        );
	}
	 
	public function create($data)
	{
		$id = 0;
		if (!empty($data)){
			$addForm = new AddForm('add');
			$employee = new Employee('add');
			$addForm->setInputFilter($employee->getInputFilter());
			$addForm->setData($data);
			if ($addForm->isValid()) {
				$employee->exchangeArray($addForm->getData());
				$id = $this->getTableObject('Employee\Model\EmployeeTable')->saveEmployee($employee);
			}
			// Action used for POST requests
			$dataArray = array(
        		'data' => $this->getTableObject('Employee\Model\EmployeeTable')->getEmployeeData($id),
				'error' => ''
        	);
		} else {
			$dataArray = array(
					'data' => array(),
					'error' => 'Please provide employee data to add'
			);
		}
		
        return new JsonModel($dataArray);
	}
	 
	public function update($id, $data)
	{
		$dataArray = array('No record found');
		if (isset($id)) {
			$data['id'] = $id;
			$EmployeeData = $this->getTableObject('Employee\Model\EmployeeTable')->getEmployeeData($id);
			$employee = new Employee('update');
			$form  = new AddForm('update');
			$form->setData($EmployeeData);
			$form->setInputFilter($employee->getInputFilter());
			$form->setData($data);
			if ($form->isValid()) {
				$employee->exchangeArray($form->getData());
				$id = $this->getTableObject('Employee\Model\EmployeeTable')->updateEmployee($employee);
			}			
			$dataArray = $this->getTableObject('Employee\Model\EmployeeTable')->getEmployeeData($id);
		}
		
		// Action used for PUT requests
        return new JsonModel(
        	array(
        		'data' => $dataArray
        	)
        );
	}
	 
	public function delete($id)
	{
		$message = 'Please provide employee Id';
		if (isset($id)){
			$this->getTableObject('Employee\Model\EmployeeTable')->deleteEmployee($id);
			$message = 'Employee data has been deleted for the id = '.$id;		
		}
		// Action used for DELETE requests
        return new JsonModel(
        	array(
        		'data' => $message
        	)
        );
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
