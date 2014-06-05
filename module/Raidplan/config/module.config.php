<?php
return array(
    'router' => array(
        'routes' => array(
            'events' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/events',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'raidplan',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action][/:id]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            'listeventsjson' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/raidplan/listeventsjson',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'raidplan',
                        'action'        => 'listEventsJson',
                    ),
                ),
                'may_terminate' => true,
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
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Raidplan\Controller\Raidplan' => 'Raidplan\Controller\RaidplanController'
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            //'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/listeventsjson'           => __DIR__ . '/../view/layout/withoutlayout.phtml',
            'layout/events'           => __DIR__ . '/../view/layout/layout.phtml',
            'raidplan/raidplan/listeventsjson' => __DIR__ . '/../view/raidplan/raidplan/rawjson.phtml',
        ),
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
    'module_layouts' => array(
        'Raidplan' => array(
            'listeventsjson' => 'layout/listeventsjson',
            'events' => 'layout/events',
        ),
    ),
);