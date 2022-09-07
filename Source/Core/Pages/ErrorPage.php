<?php

namespace Pages;

use View\View;
use const Config\VIEW;

class ErrorPage extends Page 
{
    public function index()
    {
        View::Render(VIEW, Page("error"));
    }
}