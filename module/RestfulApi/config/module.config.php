<?php
return array(    
    'router' => array(
        'routes' => array(
            'restfulapi' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/restfulapi',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'RestfulApi\Controller',
                        'controller'    => 'Index',
                    ),
                ),
                 
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:id]]',
                            'constraints' => array(
                            	'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'RestfulApi\Controller\Index',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
	'view_manager' => array(
		'strategies' => array(
			'ViewJsonStrategy',
		),
	),
	'controllers' => array(
		'invokables' => array(
			'RestfulApi\Controller\Index' => 'RestfulApi\Controller\IndexController',
		),
	),
);