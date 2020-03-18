<?php

namespace App\Controller;

use Symfony\Component\Routing\Generator\UrlGenerator;

class HelloController extends Controller
{
    public function sayHello()
    {
        $this->render(['name' => $this->currentRoute['name']]);
    }
}
