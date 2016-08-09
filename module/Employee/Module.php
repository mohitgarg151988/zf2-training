<?php
namespace Employee;
use Employee\Model\Employee;
use Employee\Model\EmployeeTable;
use Zend\ModuleManager\ModuleManager;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    /*public function init(ModuleManager $mm)
    {
    	$mm->getEventManager()->getSharedManager()->attach(
    			__NAMESPACE__,
    			'dispatch',
    			function($e) {
    		$e->getTarget()->layout('employee/home_layout');
    	}
    	);
    }*/

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig() {
    	return array(
    		'factories'	=>  array(
    			'Employee\Model\EmployeeTable' => function ($serviceManager)
    			{
    				$dbAdapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
    				$table = new EmployeeTable($dbAdapter);
    				return $table;
    			}
    		)
    	);    					 
    }
}
