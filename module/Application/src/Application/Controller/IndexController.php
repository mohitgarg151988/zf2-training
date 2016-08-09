<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\Plugin\FlashMessenger;
use Zend\Session\Container;

class IndexController extends AbstractActionController
{	
	protected $userId;
	
	public function __construct() {
		$sessionContainer = new Container('application');
		if (isset($sessionContainer->userData->loginId) && !empty($sessionContainer->userData->loginId)) {
			$this->userId = $sessionContainer->userData->loginId;
		} 
	}
	
    public function indexAction()
    { 
    	$viewModel = new ViewModel();
    	$viewModel->setTerminal(true);
    	if (!isset($this->userId)) {
    		$this->redirect()->toRoute('login/default',array('controller' => 'index', 'action' => 'logout'));
    	}   	    	
        $this->redirect()->toRoute('application/default',array('controller' => 'index', 'action' => 'welcome-page'));
    }
    
    public function welcomePageAction()
    {
    	$service  = $this->getServiceLocator()->get('translator')->setLocale('fr_FR');
    	if (!isset($this->userId)) {
    		$this->redirect()->toRoute('login/default',array('controller' => 'index', 'action' => 'logout'));
    	}
    	return new ViewModel(
    		array(
    				'flashMessages' => $this->flashMessenger()->getMessages()
    		)
    	);
    }
}
