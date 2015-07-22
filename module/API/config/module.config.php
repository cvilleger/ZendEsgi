<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'API\Controller\Users' => 'API\Controller\UsersController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'api' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/api',
                    'defaults' => array(
                    	'__NAMESPACE__' => 'API\Controller',
                        'controller' => 'Users',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'users' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/get-users',
                    'defaults' => array(
                    	'__NAMESPACE__' => 'API\Controller',
                        'controller' => 'Users',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
);