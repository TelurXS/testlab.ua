<?php

namespace Pages;

use View\View;
use const View\DEFAULT_VIEW;

class NewsPage extends Page 
{
    public function index()
    {
        View::Render(DEFAULT_VIEW, Page("news"));
    }
}