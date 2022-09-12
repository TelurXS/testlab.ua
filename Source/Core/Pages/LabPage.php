<?php

namespace Pages;

use View\View;
use const View\DEFAULT_VIEW;

class LabPage extends Page 
{
    public function index()
    {
        View::Render(DEFAULT_VIEW, Page("lab"));
    }

    public function form()
    {
        View::Render(DEFAULT_VIEW, Page("empty"));
    }
}