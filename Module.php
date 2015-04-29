<?php

/**
 * Created by PhpStorm.
 * User: lars
 * Date: 18.03.15
 * Time: 19:52.
 */
namespace BrlReCaptcha;

class Module
{
    public function getConfig()
    {
        return include __DIR__.'/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__.DIRECTORY_SEPARATOR.'autoload_classmap.php',
             ),
         );
    }
}
