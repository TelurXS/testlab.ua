<?php

namespace Utils;

use const Config\ABSOLUTE_PATH;

const EXT = '.php';

class ClassLoader 
{
    public static function ToDirectory($location)
    {
        return ABSOLUTE_PATH."Source/".$location;
    }

    public static function IncludeDirectories($directories)
    {
        foreach ($directories as $directory)
        {
            self::IncludeDirectory($directory);
        }
    }

    public static function IncludeDirectory($directory)
    {
        foreach ( glob(self::ToDirectory($directory). '*' . EXT) as $file ) 
        {
            require_once $file;
        }
    }
}