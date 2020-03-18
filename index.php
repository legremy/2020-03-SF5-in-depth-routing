<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

use App\Controller\HelloController;
use App\Controller\TaskController;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

require 'vendor/autoload.php';

$listRoute = new Route('/', ['_controller' => 'task@index']);
$showRoute = new Route('/show/{id}', ['_controller' => 'task@show'], ['id' => '\d+']);
$createRoute = new Route('/create',  ['_controller' => 'task@create'], [], [], '', [], ['GET', 'POST']);

$helloRoute = new Route('/hello/{name}', ['name' => 'World',  '_controller' => 'hello@sayHello']);

$routes = new RouteCollection();

$routes->add('list', $listRoute);
$routes->add('show', $showRoute);
$routes->add('create', $createRoute);

$routes->add('hello', $helloRoute);

$matcher = new UrlMatcher($routes, new RequestContext('', $_SERVER['REQUEST_METHOD']));
$generator = new UrlGenerator($routes, new RequestContext());

$pathinfo = $_SERVER['PATH_INFO'] ?? '/';

try {
    $currentRoute = $matcher->match($pathinfo);
} catch (ResourceNotFoundException $e) {
    require 'pages/404.html.php';
    return;
}

$controller = 'App\Controller\\' . ucfirst(explode('@', $currentRoute['_controller'])[0]) . "Controller";
$method = explode('@', $currentRoute['_controller'])[1];
call_user_func([new $controller($currentRoute, $generator), $method]);
