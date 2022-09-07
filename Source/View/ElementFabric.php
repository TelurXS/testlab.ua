<?php

namespace Fabrics;

abstract class ElementFabric 
{
    public abstract function Button($title);

    public abstract function NavigationElement($title, $href);

    public abstract function NavigationDropdown($title, $childs);
}