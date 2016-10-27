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
			'attributes' => array(
				'id' => 'id'
			)
		));
		
		$this->add(array(
			'name' => 'pageNumber',
			'type' => 'Hidden',
			'attributes' => array(
				'id' => 'pageNumber'
			)
		));
		
		$this->add(
			array(		
				'name' => 'empId',
				'type' => 'text',
				'options' => array(
					'label' => 'Employee name',
				),
				'attributes' => array(
					'id' => 'empId'
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
				),
				'attributes' => array(
					'id' => 'empEmail'
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
				),
				'attributes' => array(
					'id' => 'empRole'
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
		if ($name == 'edit') {
			$this->add(
				array(
					'name' => 'submitbutton',
					'type' => 'Button',
					'options' => array(
						'label' => 'Update'
					),
					'attributes' => array(
						'id' => 'submitbutton',
						'value' => 'Update',
						'class' => 'btn btn-success',
						'onclick' => ' return customSave()'
					)
				)
			);
		} else {
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
}