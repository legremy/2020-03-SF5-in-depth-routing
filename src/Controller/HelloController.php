<?php

namespace App\Controller;

class HelloController
{
    public function sayHello(array $route)
    {
        $name = $route['name'];
        require "pages/{$route['_route']}.php";
    }
}
