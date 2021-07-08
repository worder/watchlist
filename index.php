<?php

use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use Wl\Config\ConfigService;
use Wl\Controller\Api\User\AuthController;
use Wl\Controller\Api\Search\SearchController;
use Wl\Controller\Api\TestController;
use Wl\Db\Pdo\Manipulator;
use Wl\Mvc\MvcService;

error_reporting(E_ALL);
ini_set('display_errors', '1');

require "app/vendor/autoload.php";

// init DI container
$builder = new ContainerBuilder();
$builder->useAnnotations(true); // use annotation-based injection in controllers as recomended in php-di docs
$builder->addDefinitions("app/config/di.php");

$container = $builder->build();


// init router
$dispatcher = FastRoute\simpleDispatcher(function (RouteCollector $r) {
    $r->addGroup('/api', function (RouteCollector $r) {
        $r->addGroup('/user', function(RouteCollector $r){
            $r->addRoute('GET', '/auth', AuthController::class);
        });
        $r->addRoute('GET', '/search/{term}', SearchController::class);
        $r->addRoute('GET', '/test[/opt]', TestController::class);
    });
});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

// dispatch router
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

// dispatch controler
$mvcService = new MvcService($container);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $mvcService->dispatchController($handler, $httpMethod, $vars);
}
