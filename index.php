<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;

require 'vendor/autoload.php';

$loader = new PhpFileLoader(new FileLocator(__DIR__ . '/config'));
$routes = $loader->load("routes.php");

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
