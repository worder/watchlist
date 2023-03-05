<?php

use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use Wl\Controller\Api\Asset\ProxyController;
use Wl\Controller\Api\Consts\ConstsController;
use Wl\Controller\Api\ListEntry\ListController;
use Wl\Controller\Api\ListEntry\UserListsController;
use Wl\Controller\Api\ListItems\ListItemsController;
use Wl\Controller\Api\Media\MediaController;
use Wl\Controller\Api\Search\SearchController;
use Wl\Controller\Api\TestController;
use Wl\Controller\Api\User\InfoController;
use Wl\Controller\Api\User\SignInController;
use Wl\Controller\Api\User\SignoutController;
use Wl\Controller\Api\ListItems\IndexListItemsController;
use Wl\Controller\IndexController;
use Wl\Mvc\MvcDispatcher;
use Wl\Mvc\Result\ErrorResult;
use Wl\Mvc\ResultToResponse;

error_reporting(E_ALL);
ini_set('display_errors', '1');

register_shutdown_function(function () {
    $last_error = error_get_last();
    if ($last_error && in_array($last_error['type'], [E_ERROR, E_PARSE, E_COMPILE_ERROR, E_CORE_ERROR]))
        header('HTTP/1.1 500 Internal Server Error', TRUE, 500);
});

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
            $r->addRoute(['POST'], '/signin', SignInController::class);
            $r->addRoute(['GET'], '/signout', SignoutController::class);
            $r->addRoute(['GET'], '/info', InfoController::class);
        });

        $r->addRoute(['GET'], '/search', SearchController::class);

        $r->addRoute(['GET'], '/media', MediaController::class);
        $r->addRoute(['PUT', 'PATCH', 'DELETE'], '/list', ListController::class);
        $r->addRoute(['GET'], '/user-lists/{userId:\d+}', UserListsController::class);
        $r->addRoute(['GET', 'PUT'], '/list-items/{listId:\d+}', ListItemsController::class);
        $r->addRoute(["GET"], "/index-list-items/{page:\d+}", IndexListItemsController::class);

        $r->addGroup('/asset', function (RouteCollector $r) {
            $r->addRoute(['GET'], '/proxy/{data}', ProxyController::class);
        });
        $r->addRoute('GET', '/consts', ConstsController::class);
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
        // case FastRoute\Dispatcher::NOT_FOUND:
        //     $result = new ErrorResult(null, 404);
        //     break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $result = new ErrorResult(null, 405);
        break;
    case FastRoute\Dispatcher::NOT_FOUND:
        if (stripos($uri, '/api') === 0) {
            $result = new ErrorResult(null, 404);
            break;
        }
        // 404 outside of api path will be handled at client side
        $handler = IndexController::class;
        $vars = [];
        try {
            $result = $mvcDispatcher->dispatchController($handler, $httpMethod, $vars);
        } catch (\Exception $e) {
            // internal error
            // $result = new ErrorResult(null, 502); // prod
            $result = new ErrorResult($e->getMessage(), 200); // debug
        }
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        try {
            $result = $mvcDispatcher->dispatchController($handler, $httpMethod, $vars);
        } catch (\Exception $e) {
            // internal error
            // $result = new ErrorResult(null, 502); // prod
            $result = new ErrorResult($e->getMessage(), 502); // debug
        }
}

$rtr->getResponse($result)->render();
