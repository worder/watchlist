<?php

namespace Wl\Mvc;

use Psr\Container\ContainerInterface;
use ReflectionClass;
use Wl\Mvc\Exception\ControllerNotFoundException;
use Wl\Mvc\Exception\MethodNotFoundException;

class MvcService
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
            return $controllerInstance->$controllerMethod($vars);
        } else {
            throw new ControllerNotFoundException('Controller "' . $classname . '" does not exists');
        }
    }
}
