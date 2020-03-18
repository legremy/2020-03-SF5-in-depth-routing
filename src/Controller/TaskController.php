<?php

namespace App\Controller;

class TaskController
{
    public function index(array $route)
    {
        $generator = $route['generator'];
        require "pages/{$route['_route']}.php";
    }

    public function show(array $route)
    {
        $generator = $route['generator'];
        require "pages/{$route['_route']}.php";
    }

    public function create(array $route)
    {
        $generator = $route['generator'];
        require "pages/{$route['_route']}.php";
    }
}
