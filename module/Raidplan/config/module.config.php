<?php
return array(
    'router' => array(
        'routes' => array(
            'root' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/',
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
            'events' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/events',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'raidplan',
                        'action'        => 'calendar',
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
            'login' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'Raidplan',
                        'action'        => 'login',
                    ),
                ),
            ),
            'editevent' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/editevent[/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'Raidplan',
                        'action'        => 'edit',
                    ),
                ),
            ),
            'viewevent' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/viewevent[/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'Raidplan',
                        'action'        => 'viewEvent',
                    ),
                ),
            ),
            'addevent' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/addevent',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'Raidplan',
                        'action'        => 'add',
                    ),
                ),
            ),
            'saveevent' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/saveevent',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'Raidplan',
                        'action'        => 'ajaxsaveevent',
                    ),
                ),
            ),
            'ajaxgetevents' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/ajaxgetevents',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'Raidplan',
                        'action'        => 'ajaxGetEvents',
                    ),
                ),
            ),
            'ajaxlogin' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/ajaxlogin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'Raidplan',
                        'action'        => 'ajaxLogin',
                    ),
                ),
            ),
            'ajaxedit' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/ajaxedit',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'Raidplan',
                        'action'        => 'ajaxedit',
                    ),
                ),
            ),
            'ajaxdeleteevent' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/ajaxdeleteevent[/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'Raidplan',
                        'action'        => 'ajaxdelete',
                    ),
                ),
            ),
            'logout' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'Raidplan',
                        'action'        => 'logout',
                    ),
                ),
            ),
            'deleteevent' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/deleteevent[/:id]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Raidplan\Controller',
                        'controller'    => 'Raidplan',
                        'action'        => 'delete',
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
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/listeventsjson'           => __DIR__ . '/../view/layout/withoutlayout.phtml',
            'layout/saveevent'           => __DIR__ . '/../view/layout/withoutlayout.phtml',
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
            'root' => 'layout/events',
            'events' => 'layout/events',
            'saveevent' => 'layout/layout/saveevent',
        ),
    ),
);

