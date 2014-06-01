<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Codereview;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Codereview\Model\Codereview;
use Codereview\Model\CodereviewTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;


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
                 'Codereview\Model\CodereviewTable' =>  function($sm) {
                     $tableGateway = $sm->get('CodereviewTableGateway');
                     $table = new CodereviewTable($tableGateway);
                     return $table;
                 },
                 'CodereviewTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Codereview());
                     return new TableGateway('codereview', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

}
