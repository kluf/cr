<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Schedule;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
 use Schedule\Model\Schedule;
 use Schedule\Model\ScheduleMapper;


class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
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
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'ScheduleMapper' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $mapper = new ScheduleMapper($dbAdapter);
                    return $mapper;
                }
            ),
        );
    }
//     {
//         return array(
//             'factories' => array(
//                 'Schedule\Model\ScheduleTable' =>  function($sm) {
//                     $tableGateway = $sm->get('ScheduleTableGateway');
//                     $table = new ScheduleTable($tableGateway);
//                     return $table;
//                 },
//                 'ScheduleTableGateway' => function ($sm) {
//                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
//                     $resultSetPrototype = new ResultSet();
//                     $resultSetPrototype->setArrayObjectPrototype(new Schedule());
//                     return new TableGateway('schedule', $dbAdapter, null, $resultSetPrototype);
//                 },
//             ),
//         );
//     }

}
