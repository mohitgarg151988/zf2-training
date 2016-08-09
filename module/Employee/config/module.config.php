<?php
/**
 * @author created by Mohit
 * @date 18-07-2016
 */

namespace Employee;

return array(
    'router' => array(
        'routes' => array(            
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /employee/:controller/:action
            'employee' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/employee',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Employee\Controller',
                        'controller'    => 'Employee',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array('type' => 'Segment', 
                        'options' => array(
                            'route' => '/[:controller[/:action[/:id[/:page]]]]', 
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*', 
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*', 
                        		'id' => '[0-9]*',
                    			'page' => '[0-9]*'
                            ),
                            'defaults' => array()
                        )
                    ),
                	'list' => array('type' => 'Segment',
                		'options' => array(
                			'route' => '/[:controller[/:action[/:page]]]',
                			'constraints' => array(
                				'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                				'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                				'page' => '[0-9]*'
                			),
                			'defaults' => array()
                		)
                	),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'factories' => array(
            'translator' => 'Zend\Mvc\Service\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Employee\Controller\Employee' => 'Employee\Controller\EmployeeController'
        ),
    ),
    'view_manager' => array(
    	'template_map' => array(
    		'employee/home_layout' => __DIR__ . '/../view/layout/home_layout.phtml',
    	),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
