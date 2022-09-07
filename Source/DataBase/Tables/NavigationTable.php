<?php

namespace DataBase;

class NavigationTable extends DataBaseTable
{
    public function __construct($connection)
    {
        parent::__construct("navigation", $connection);
    }

    public function GetOptions()
    {
        $rawData = $this->GetRows();
        $temp = [];
    
        for ($i=0; $i < count($rawData); $i++) 
        { 
            $element = $rawData[$i];

            if(is_null($element["parent"]))
            {
                array_push($temp, $this->CreateNavigationObject($element));
            }
            else
            {
                $parent = &GetElementById($temp, $element["parent"]);
            
                if(!is_null($parent))
                {
                    if(is_null($parent["childs"])) { $parent["childs"] = []; }
                
                    array_push($parent["childs"], $this->CreateNavigationObject($element));
                }
            }
        }
    
        return $temp;
    }

    protected function CreateNavigationObject($element)
    {
        return
        [ 
            "Id" => $element["Id"],
            "title" => $element["title"],
            "href" => $element["href"],
            "childs" => null
        ];
    }
}

?>