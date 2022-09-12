<?php

namespace Config;

use Utils\ClassLoader;

const TITLE = "Title";

const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASSWORD = '';
const DB_NAME = 'simpledb';

const ABSOLUTE_PATH = __DIR__."/";

require_once "Source/Utils/ClassLoader.php";

const DIRECTIRIES = 
[
    "",
    "Utils/",
    "DataBase/",
    "DataBase/Tables/",
    "Core/",
    "Core/Pages/",
    "View/",
    "View/Fabrics/",
];

ClassLoader::IncludeDirectories(DIRECTIRIES);

?>