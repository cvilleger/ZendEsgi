<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Media\Controller\Index' => 'Media\Controller\IndexController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'media' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/media',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Media\Controller',
                        'controller' => 'Index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'add' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/add-media',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Media\Controller',
                        'controller' => 'Index',
                        'action'     => 'add',
                    ),
                ),
            ),
            'delete' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/delete-media/:id[/]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Media\Controller\Index',
                        'action' => 'delete'
                    ),
                ),
            ),
            'download' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/download-media/:file[/]',
                    'defaults' => array(
                        'controller' => 'Media\Controller\Index',
                        'action' => 'download'
                    ),
                ),
            ),
        ),
    ),
);