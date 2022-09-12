<div class="in-center">Test Lab</div>

<div class="in-center">
<?php

    use DataBase\DataBaseConnector;
    use DataBase\NavigationTable;
    use DataBase\QueryGenerator;

    $table = new NavigationTable(DataBaseConnector::Default());

    $query = (new QueryGenerator)->Select(["Id"])->From("navigation")->Result();

    Dump($table->Execute($query));
?>
</div>