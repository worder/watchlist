<?php

namespace Wl\Mvc;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use Wl\Mvc\Exception\ControllerException;
use Wl\Mvc\Exception\ControllerNotFoundException;
use Wl\Mvc\Exception\MethodNotFoundException;

class MvcDispatcher
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    function dispatchController($classname, $method, $vars)
    {
        if (class_exists($classname)) {

            $controllerMethod = strtolower($method);

            $rc = new ReflectionClass($classname);

            if (!$rc->hasMethod($controllerMethod)) {
                if ($rc->hasMethod('default')) {
                    $controllerMethod = 'default';
                } else {
                    throw new MethodNotFoundException('Controller "' . $classname . '" does not support "' . $controllerMethod . '" method');
                }
            }

            $controllerInstance = $this->container->get($classname);
            try {
                $result = $controllerInstance->$controllerMethod($vars);
            } catch (ControllerException $e) { 
                // only ControllerException should be provided to frontend, any other exception should be considered as internal error
                $result = $e;
            } 
            return $result;
        } else {
            throw new ControllerNotFoundException('Controller "' . $classname . '" does not exists');
        }
    }
}
