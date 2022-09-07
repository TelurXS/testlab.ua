<?php

namespace Pages;

use View\View;
use const Config\VIEW;

class ArchivePage extends Page 
{
    public function index()
    {
        View::Render(VIEW, Page("archive"));
    }
}