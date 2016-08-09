<?php
/**
 * Class UserTable use for user.
 *
 */
namespace Employee\Model;

use Login\Model\Login;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Employee\Model\Employee;

/**
 * Class UserTable use for news chain request.
 *        
 */
class EmployeeTable extends AbstractTableGateway
{
    /**
     * Constructor
     *
     * @param Zend\Db\Adapter $adapter
     *            instance of Adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
        $this->table = 'tblEmployeeData';
        $this->initialize();
    }
    
    /**
     * fetch all record of defined table
     *
     * @return result set
     */
    public function fetchAll($paginated = FALSE)
    {
    	if ($paginated){
    		// create a new Select object for the table album
    		$select = new \Zend\Db\Sql\Select('tblEmployeeData');
    		// create a new result set based on the Employee entity
    		$resultSetPrototype = new ResultSet();
    		$resultSetPrototype->setArrayObjectPrototype(new Employee());
    		// create a new pagination adapter object
    		$paginatorAdapter = new DbSelect(
    			// our configured select object
    			$select,
    			// the adapter to run it against
    			$this->getAdapter(),
    			// the result set to hydrate
    			$resultSetPrototype
    		);
    		$paginator = new Paginator($paginatorAdapter);
    		return $paginator;
    	}
        $resultSet = $this->select();
        $data = array();
        foreach($resultSet as $result) {
        	$data[] = $result;
        }
        return $data;
    }
    
    /**
     * fetch record corresponding to id from defined table  
     * @return ArrayObject
     */
    public function getUserLoginData(Login $login)
    {
    	if (!empty($login)) {
	        $rowset = $this->select(array('empId' => $login->userId, 'password' => $login->password));
	        $row = $rowset->current();
	        if (!$row) {
	            return null;
	        }
	        return $row;
    	} else {
    		throw new \Exception("Could not find employee data");
    	}
        
    }
    
    /**
     * fetch record corresponding to id from defined table
     * @return ArrayObject
     */
    function getEmployeeData($empId) {
    	if (!empty($empId)) {
    		$rowset = $this->select(array('id' => $empId));
    		$row = $rowset->current();
    		if (!$row) {
    			return array();
    		}
    		return (array)$row;
    	} else {
    		throw new \Exception("Could not find employee data");
    	}
    }
    
    /**
     * insert record to tblUserData table correspond to $empId in defined table
     *
     * @param User $user
     *            instance of Employee
     *            
     * @return string
     * @throws \Exception
     */
    public function saveEmployee(Employee $employee)
    {
    	$empId = 0;
    	if (!empty($employee)) {
    		$data = array(
    			'empId' => $employee->empId,  
    			'password' => new \Zend\Db\Sql\Expression('md5("'.$employee->password.'")'),
    			'empEmail' => $employee->empEmail, 
    			'empRole' => $employee->empRole,
            	'dateCreated' => date("Y-m-d H:i:s")
    		);
    		$this->insert($data);
    		$empId = $this->getLastInsertValue();
    	}
    	return $empId;    	        
    }
    
    /**
     * insert record to tblUserData table correspond to $empId in defined table
     *
     * @param User $user
     *            instance of Employee
     *
     * @return string
     * @throws \Exception
     */
    public function updateEmployee(Employee $employee)
    {
    	$empId = 0;    	
    	if (!empty($employee) && isset($employee->id)) {
    		$data = array(
    			'empId' => $employee->empId,
    			'empEmail' => $employee->empEmail,
    			'empRole' => $employee->empRole    				
    		);
    		//echo "<pre>";print_r($data);die;
    		$this->update($data, array('id' => $employee->id));
    		$empId = $employee->id;
    	}
    	return $empId;
    }
    
    /**
     * Delete news to tblUserData table correspond to $empId in defined table
     *
     * @param Custody $empId
     *            id of the employee
     *            
     * @return int
     */
    public function deleteEmployee($empId)
    {
        $this->delete(array('id' => $empId));
        return $empId;
    }
    /**
     * Delete fetch to tblUserData table correspond to $data
     *
     * @param array $data
     *            columns data array
     *            
     * @return row array
     */
    public function fetchData($data)
    {
        $rowset = $this->select($data);
        $row = $rowset->current();
        
        return $row;
    }
}
