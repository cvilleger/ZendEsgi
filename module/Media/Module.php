<?php
namespace Media;

use Media\Model\File;
use Media\Model\FileTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

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
                'Media\Model\FileTable' =>  function($sm) {
                    $fileGateway = $sm->get('FileTableGateway');
                    $file = new FileTable($fileGateway);
                    return $file;
                },
                'FileTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new File());
                    return new TableGateway('file', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
