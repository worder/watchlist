<?php

use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use Wl\Controller\Api\Search\OptionsController;
use Wl\Controller\Api\User\AuthController;
use Wl\Controller\Api\Search\SearchController;
use Wl\Controller\Api\TestController;
use Wl\Controller\Api\User\InfoController;
use Wl\Controller\IndexController;
use Wl\Mvc\MvcDispatcher;
use Wl\Mvc\Result\ErrorResult;
use Wl\Mvc\ResultToResponse;

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
    $r->addRoute('GET', '/', IndexController::class);
    $r->addGroup('/api', function (RouteCollector $r) {
        $r->addGroup('/user', function (RouteCollector $r) {
            $r->addRoute(['POST'], '/auth', AuthController::class);
            $r->addRoute(['GET'], '/info', InfoController::class);
        });
        $r->addGroup('/search', function (RouteCollector $r) {
            $r->addRoute(['GET'], '/term/{term}', SearchController::class);
            $r->addRoute(['GET'], '/options', OptionsController::class);
        });
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
$mvcDispatcher = new MvcDispatcher($container);
$rtr = new ResultToResponse();
$result = null;

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        $result = new ErrorResult(null, 404);
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $result = new ErrorResult(null, 405);
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        try {
            $result = $mvcDispatcher->dispatchController($handler, $httpMethod, $vars);
        } catch (\Exception $e) {
            // internal error
            // $result = new ErrorResult(null, 502); // prod
            $result = new ErrorResult($e->getMessage(), 200); // debug
        }
}

$rtr->getResponse($result)->render();
