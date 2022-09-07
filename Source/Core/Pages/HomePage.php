<?php

namespace Pages;

use View\View;
use const Config\VIEW;

class HomePage extends Page 
{
    public function index()
    {
        View::Render(VIEW, Page("main"));
    }
}