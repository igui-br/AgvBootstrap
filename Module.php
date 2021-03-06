<?php

namespace AgvBootstrap;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface, DependencyIndicatorInterface
{

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function preDispatch($e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $helper = $sm->get('viewhelpermanager')->get('map');
        $helper->setServiceLocator($sm);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getModuleDependencies()
    {
        return array('ZfSnapGeoip');
    }

}