<?php

namespace App;

use Pages\Page;

class Router
{
    private $_routes = [];

    private $_defaultPage = null;
    private $_errorPage = null;

    public function __construct($defaultPage, $errorPage)
    {
        $this->_defaultPage = $defaultPage;
        $this->_errorPage = $errorPage;
    }

    public function Bind(string $rout, Page $page) 
    {
        $this->_routes[$rout] = $page;
    }

    public function TryEnter($uri)
    {
        $route = explode('?', $uri)[0];
        $routes = explode('/', $route);

        if (empty($routes[1])) 
        {
            $this->_defaultPage->index();
        }
        else
        {
            $action = "index";

            if(!empty($routes[2]))
            {
                $action = $routes[2];
            }

            $this->Enter($routes[1], $action);
        }
    }

    public function Enter(string $enterRout, string $action = "index")
    {
        foreach ($this->_routes as $rout => $page) 
        {
            if ($rout == $enterRout)
            {
                if(method_exists($page, $action))
                {
                    $page->$action();
                    exit();
                }
            }
        }

        $this->_errorPage->index();
    }
}