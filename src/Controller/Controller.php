<?php

namespace App\Controller;

use Symfony\Component\Routing\Generator\UrlGenerator;

class Controller
{
    public $currentRoute = null;
    public $generator = null;

    public function __construct(array $currentRoute, UrlGenerator $generator)
    {
        $this->currentRoute = $currentRoute;
        $this->generator = $generator;
    }

    protected function render(array $arguments = [])
    {
        extract($arguments);
        require_once "pages/{$this->currentRoute['_route']}.html.php";
    }
}
