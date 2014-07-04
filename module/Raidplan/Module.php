<?php
namespace Raidplan;

use Raidplan\Model\Events;
use Raidplan\Model\EventsTable;
//require_once('module/Raidplan/src/Raidplan/Model/EventsTable.php');
use Raidplan\Model\Jobs;
use Raidplan\Model\JobsTable;
use Raidplan\Model\Players;
use Raidplan\Model\PlayersTable;
use Raidplan\Model\Roles;
use Raidplan\Model\RolesTable;
use Raidplan\Model\UsersTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


class Module
{
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

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                //playerstable
                'Raidplan\Model\PlayersTable' =>  function($sm) {
                        $playersDefaultDbAdapter = $sm->get('defaultAdapter');
                        //$playersTableGateway = $sm->get('PlayersTableGateway');
                        $playersTable = new PlayersTable($playersDefaultDbAdapter);
                        return $playersTable;
                    },
                'Raidplan\Model\UsersTable' =>  function($sm) {
                        $usersDefaultDbAdapter = $sm->get('smfAdapter');
                        //$playersTableGateway = $sm->get('PlayersTableGateway');
                        $usersTable = new UsersTable($usersDefaultDbAdapter);
                        return $usersTable;
                    },
                'PlayersTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Players());
                        return new TableGateway('ep_players', $dbAdapter, null, $resultSetPrototype);
                    },
                'defaultAdapter' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        return $dbAdapter;
                    },
                'smfAdapter' => function ($sm) {
                        $dbAdapter = $sm->get('smfdb');
                        return $dbAdapter;
                    },
                'Raidplan\Model\EventsTable' =>  function($sm) {
                        $tableGateway = $sm->get('EventsTableGateway');
                        $eventsDefaultDbAdapter = $sm->get('defaultAdapter');
                        $table = new EventsTable($tableGateway, $eventsDefaultDbAdapter);
                        return $table;
                    },
                'EventsTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Events());
                        return new TableGateway('ep_events', $dbAdapter, null, $resultSetPrototype);
                    },

                'Raidplan\Model\JobsTable' =>  function($sm) {
                        $tableGateway = $sm->get('JobsTableGateway');
                        $table = new JobsTable($tableGateway);
                        return $table;
                    },
                'JobsTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Jobs());
                        return new TableGateway('ep_jobs', $dbAdapter, null, $resultSetPrototype);
                    },
                'Raidplan\Model\RolesTable' =>  function($sm) {
                        $tableGateway = $sm->get('RolesTableGateway');
                        $table = new RolesTable($tableGateway);
                        return $table;
                    },
                'RolesTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Roles());
                        return new TableGateway('ep_roles', $dbAdapter, null, $resultSetPrototype);
                    },
            ),
        );
    }
    
//    public function onBootstrap($e)
//    {
//        $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) {
//            $controller      = $e->getTarget();
//            $controllerClass = get_class($controller);
//            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
//            $config          = $e->getApplication()->getServiceManager()->get('config');
//
//            $routeMatch = $e->getRouteMatch();
//            $actionName = strtolower($routeMatch->getParam('action', 'not-found')); // get the action name
//
//            if (isset($config['module_layouts'][$moduleNamespace][$actionName])) {
//                $controller->layout($config['module_layouts'][$moduleNamespace][$actionName]);
//            }elseif(isset($config['module_layouts'][$moduleNamespace]['default'])) {
//                $controller->layout($config['module_layouts'][$moduleNamespace]['default']);
//            }
//
//        }, 100);
//    }
}
