<?php

namespace Pages;

use View\View;
use const Config\VIEW;

class NewsPage extends Page 
{
    public function index()
    {
        View::Render(VIEW, Page("news"));
    }
}