<?php
namespace Login\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
	public function __construct($name=null){
		parent::__construct($name);
		
		/*$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
		));
		*/
		$this->add(
			array(		
				'name' => 'userId',
				'type' => 'text',
				'options' => array(
					'label' => 'User Name',
				)
			)									
		);
		$this->add(
			array(
				'name' => 'userPass',
				'type' => 'password',
				'options' => array(
					'label' => 'User Password',
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
					'value' => 'Login'	
				)
			)
		);
	}		
}