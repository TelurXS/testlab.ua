<?php
    function Dump($object)
    {
        echo "<pre>";
        echo var_dump($object);
        echo "</pre>";
    }

    function &GetElementById(&$array, $id)
    {
        for ($i=0; $i < count($array); $i++) 
        { 
            if ($array[$i]["Id"] == $id)
            {
                return $array[$i];
            }
        }
        return null;
    }

    function Page($name)
    {
        return "Resources/Pages/".$name.".php";
    }

    function Css($name) 
    {
        return "Resources/Css/".$name.".css";
    }

    function Script($name) 
    {
        return "Resources/Js/".$name.".js";
    }
    
?>