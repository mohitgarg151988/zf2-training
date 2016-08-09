<?php
namespace Employee\Form;

use Zend\Form\Element;

use Zend\Form\Form;

class AddForm extends Form
{
	public function __construct($name=null){
		parent::__construct($name);
		
		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		
		$this->add(
			array(		
				'name' => 'empId',
				'type' => 'text',
				'options' => array(
					'label' => 'Employee name',
				)
			)									
		);
		
		if ($name == 'add') {
			$this->add(
				array(
					'name' => 'empPass',
					'type' => 'password',
					'options' => array(
						'label' => 'Employee Password',
					)
				)
			);
				
			$this->add(
				array(
					'name' => 'empConfirmPass',
					'type' => 'password',
					'options' => array(
						'label' => 'Confirm Password',
					)
				)
			);
		}
				
		$this->add(
			array(
				'name' => 'empEmail',
				'type' => 'text',
				'options' => array(
					'label' => 'Employee Email',
				)
			)
		);
		$this->add(
			array(
				'name' => 'empRole',
				'type' => 'Zend\Form\Element\Select',
				'options' => array(
					'label' => 'Employee Role',
					'options' => array(
						'' => '',
						'SE' => 'SE',
						'SSE' => 'SSE',
						'TL' => 'TL',
						'PL' => 'PL',
						'PM' => 'PM'
					)
				)
			)		
		);
		/*$this->add(
			array(
				'name' => 'security',						
				'type' => 'Zend\Form\Element\Csrf',
				'options' => array(
					'csrf_options' => array('timeout' => 3600)
				)
			)
		);*/
		$this->add(
			array(
				'name' => 'submitbutton',
				'type' => 'submit',
				'attributes' => array(
					'id' => 'submitbutton',
					'value' => 'Add'	
				)
			)
		);
	}		
}