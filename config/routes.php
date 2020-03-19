<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $configurator) {
    $configurator
        ->add('list', '/')
        ->defaults(['_controller' => 'task@index'])

        ->add('show', '/show/{id}')
        ->defaults(['_controller' => 'task@show'])
        ->requirements(['id' => '\d+'])

        ->add('create', '/create')
        ->defaults(['_controller' => 'task@create'], [], [], '', [], ['GET', 'POST'])

        ->add('hello', '/hello/{name}')
        ->defaults(['name' => 'World',  '_controller' => 'hello@sayHello']);
};
