<div class="navigation-bar">
<?php

use DataBase\DataBaseConnector;
use DataBase\NavigationTable;
use Fabrics\DefaultFabric;


$table = new NavigationTable(DataBaseConnector::Default());
$fabric = new DefaultFabric();

$navigations = $table->GetOptions();

foreach ($navigations as $navigation) 
{
    if(is_null($navigation["childs"]))
    {
        $fabric->NavigationElement($navigation["title"], $navigation["href"]);
    }
    else
    {
        $fabric->NavigationDropdown($navigation["title"], $navigation["childs"]);
    }
}

?>
</div>