<?php

/**
 * Manage change password validations
 * @author Osscube(Mohit Kumar Gupta)
 */
namespace Login\Model;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Used by ResultSet to pass each database row to the entity
 *
 * @author osscube(Mohit Kumar Gupta)
 *         Used by database row, form filter validation
 */
class Login implements InputFilterAwareInterface
{   
    /**
     *
     * @var InputFilterInterface
     */
    protected $_inputFilter;
	public $password;
	public $userId;
	
	public function exchangeArray($data)
	{
		$this->userId = (!empty($data['userId'])) ? $data['userId'] : null;
		$this->password = (!empty($data['userPass'])) ? new \Zend\Db\Sql\Expression('md5("'.$data['userPass'].'")') : null;
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
            
			$inputFilter->add(
				array(
					'name' => 'userId',
					'required' => true,
					'filters' => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
					),
					'validators' => array(
						array(
							'name' => 'NotEmpty',
							'options' => array(
                            	'messages' => array($isEmpty => 'User name can not be empty')
							)
						)
					)
				)
			);
			
			$inputFilter->add(
				array(
					'name' => 'userPass',
					'required' => true,
					'filters' => array(
						array('name' => 'StripTags'),
						array('name' => 'StringTrim'),
					),
					'validators' => array(						
						array(
							'name' => 'NotEmpty',
							'options' => array(
								'messages' => array($isEmpty => 'Password  can not be empty')
							),
							'break_chain_on_failure' => true
						)
					)
				)
			);					
				
            $this->_inputFilter = $inputFilter;
        }        
        return $this->_inputFilter;
    }
}