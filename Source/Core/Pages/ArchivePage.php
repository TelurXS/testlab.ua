<?php

namespace Pages;

use View\View;
use const View\DEFAULT_VIEW;

class ArchivePage extends Page 
{
    public function index()
    {
        View::Render(DEFAULT_VIEW, Page("archive"));
    }
}