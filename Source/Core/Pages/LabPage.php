<?php

namespace Pages;

use View\View;
use const Config\VIEW;

class LabPage extends Page 
{
    public function index()
    {
        View::Render(VIEW, Page("lab"));
    }

    public function RecieveValues()
    {
        View::Render(VIEW, Page("lab"));
    }
}