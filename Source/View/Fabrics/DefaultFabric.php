<?php

namespace Fabrics;

class DefaultFabric extends ElementFabric 
{
    public function Button($title)
    {
        echo "<button>$title</button>";
    }

    public function NavigationElement($title, $href) 
    {
        echo 
        "<a href='$href' class='item'>
            <div class='label'>$title</div>
        </a>";
    }
    
    public function NavigationDropdown($title, $childs) 
    {
        $element = 
        "<div class='dropdown'>
        <button class='drop-button'>$title</button>
        <div class='dropdown-content'>";

        foreach ($childs as $child) 
        {
            $title = $child["title"];
            $href = $child["href"];

            $element = $element."<a href=$href>$title</a>";
        }

        $element .= "</div></div>";
    
        echo $element;
    }
}