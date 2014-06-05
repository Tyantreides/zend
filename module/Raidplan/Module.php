<?php
namespace Raidplan;

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
                'Raidplan\Model\RaidplanTable' =>  function($sm) {
                        $tableGateway = $sm->get('RaidplanTableGateway');
                        $table = new RaidplanTable($tableGateway);
                        return $table;
                    },
                'RaidplanTableGateway' => function ($sm) {
                        $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                        $resultSetPrototype = new ResultSet();
                        $resultSetPrototype->setArrayObjectPrototype(new Raidplan());
                        return new TableGateway('raidplan', $dbAdapter, null, $resultSetPrototype);
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
