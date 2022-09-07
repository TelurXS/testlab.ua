<?php

namespace View;

class View 
{
    public static function Render($view, $page)
    {
        require $view;
    }
}