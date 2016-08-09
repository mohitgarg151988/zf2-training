<?php
namespace Login;

use Zend\Crypt\PublicKey\Rsa\PublicKey;

use Zend\Mvc\MvcEvent;
use zend\mvc\ModuleRouteListener;
use Zend\Db\Adapter\Adapter;

class Module
{
	
	public function onBootstrap(MvcEvent $e)
	{		
		$eventManager        = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);
		$eventManager->attach(MvcEvent::EVENT_DISPATCH,array($this,'onDispatch'));
	}
	
	public function onDispatch(MvcEvent $e) {
		$userName = '';
		$sessionContainer = new \Zend\Session\Container('application');
		if (isset($sessionContainer->userData->loginId)) {
			$userName = $sessionContainer->userData->loginName;
		}
		$viewModel = $e->getViewModel();
		$viewModel->setVariable('userName', $userName);
	}
	
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

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
}
