<?php

/**
 * Manage change password validations
 * @author Osscube(Mohit Kumar Gupta)
 */
namespace Employee\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Used by ResultSet to pass each database row to the entity
 *
 * @author osscube(Mohit Kumar Gupta)
 *         Used by database row, form filter validation
 */
class Employee implements InputFilterAwareInterface
{   
    /**
     *
     * @var InputFilterInterface
     */
    protected $_inputFilter;
    public $empId;
    public $id;
	public $password;
	public $empEmail;
	public $empRole;
	public $formName;
	public $dateCreated;
	
	public function __construct($formName = null) {
		$this->formName = $formName;
	} 
	
	public function exchangeArray($data)
	{
		$this->id = (!empty($data['id'])) ? $data['id'] : null;
		$this->empId = (!empty($data['empId'])) ? $data['empId'] : null;
		$this->password = (!empty($data['empPass'])) ? $data['empPass'] : null;
		$this->empEmail = (!empty($data['empEmail'])) ? $data['empEmail'] : null;
		$this->empRole = (!empty($data['empRole'])) ? $data['empRole'] : null;
		$this->dateCreated = (!empty($data['dateCreated'])) ? $data['dateCreated'] : null;
	}
    /**
     * Gets the properties of the given object
     *
     * @return associative array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    /**
     * use for interface
     *
     * @param InputFilterInterface $inputFilter
     *            (use for interface)
     *            
     * @throws \Exception
     * @return void
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used $inputFilter");
    }
    
    /**
     * use to validate form fields
     *
     * @return InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->_inputFilter) {
            $inputFilter = new InputFilter();
            $isEmpty = \Zend\Validator\NotEmpty::IS_EMPTY;
            $invalid = \Zend\Validator\EmailAddress::INVALID;
            $notSame = \Zend\Validator\Identical::NOT_SAME;
            
			$inputFilter->add(
				array(
					'name' => 'empId',
					'required' => true,
					'filters' => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
					),
					'validators' => array(
						array(
							'name' => 'NotEmpty',
							'options' => array(
                            	'messages' => array($isEmpty => 'Employee name can not be empty')
							)
						)
					)
				)
			);
			if ($this->formName == 'add'){
				$inputFilter->add(
					array(
						'name' => 'empPass',
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
									'min' => 5,
									'max' => 20
								),
								'break_chain_on_failure' => true
							),
							array(
								'name' => 'NotEmpty',
								'options' => array(
									'messages' => array($isEmpty => 'Employee password  can not be empty')
								),
								'break_chain_on_failure' => true
							)
						)
					)
				);
				
				$inputFilter->add(
					array(
						'name' => 'empConfirmPass',
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
										'min' => 5,
										'max' => 20
								),
								'break_chain_on_failure' => true
							),
							array(
								'name' => 'NotEmpty',
								'options' => array(
										'messages' => array($isEmpty => 'Confirm Password  can not be empty')
								),
								'break_chain_on_failure' => true
							),
							array(
								'name' => 'Identical',
								'options' => array(
									'token' => 'empPass', // name of first password field
									'messages' => array($notSame => 'Confirm password and password must be same')
								),
								'break_chain_on_failure' => true
							),
						)
					)
				);
			}
			
			$inputFilter->add(
				array(
					'name' => 'empEmail',
					'required' => true,
					'filters' => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
					),
					'validators' => array(
						array(
							'name' => 'NotEmpty',
							'options' => array(
								'messages' => array($isEmpty => 'Employee email can not be empty')
							),
							'break_chain_on_failure' => true
						),
						array(
							'name' => 'EmailAddress',
							'options' => array(
								'messages' => array($invalid => 'Please enter valid email address')
							),
							'break_chain_on_failure' => true
						)
					)
				)
			);
			
			$inputFilter->add(
				array(
					'name' => 'empRole',
					'required' => true,					
					'validators' => array(
						array(
							'name' => 'NotEmpty',
							'options' => array(
								'messages' => array($isEmpty => 'Employee role can not be empty')
							)
						)
					)
				)
			);
				
            $this->_inputFilter = $inputFilter;
        }        
        return $this->_inputFilter;
    }
}