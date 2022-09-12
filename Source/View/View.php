<?php

namespace View;

class View 
{
    public static function Render($view, $page)
    {
        require $view;
    }
}

const HEADER = "Resources/View/header.php";
const NAVIGATION = "Resources/View/navigation.php";
const FOOTER = "Resources/View/footer.php";

const DEFAULT_VIEW = "Resources/View/view.php";