<?php

namespace App;

use Pages\LabPage;
use Pages\HomePage;
use Pages\NewsPage;
use Pages\ErrorPage;
use Pages\ArchivePage;

class Kernel 
{
    public static $router = null;

    public static function Init()
    {
        self::$router = new Router(new HomePage(), new ErrorPage());

        new NewsPage();

        self::$router->Bind("news", new NewsPage());
        self::$router->Bind("archive", new ArchivePage());
        self::$router->Bind("lab", new LabPage());

        self::$router->TryEnter($_SERVER["REQUEST_URI"]);
    }
}