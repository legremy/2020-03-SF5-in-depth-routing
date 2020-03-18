<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

require 'vendor/autoload.php';
$listRoute = new Route('/');
// Remarque, le ["id" => 100] ci-dessous n'est ici que pour l'exemple
$showRoute = new Route('/show/{id}', ["id" => 100], ['id' => '\d+']); // Alt. Syntax : $showRoute = new Route('/show/{id<\d+>?100}');
$createRoute = new Route('/create', [], [], [], '', [], ['GET', 'POST']);

$helloRoute = new Route('/hello/{name}', ['name' => 'World']);

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
    require 'pages/404.php';
    return;
}

require_once "pages/{$currentRoute['_route']}.php";
