<?php
session_start();

// database config
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'crud_estudo');
define('DB_USER', 'root');
define('DB_PASS', '');

// define secret to remember-me option
define('TOKEN_SECRET', '8Tt389v9DwnUGhc6QVo');

// auto loader classes
function appAutoLoad($class)
{
    $class = str_replace('\\', '/', $class);
    if (file_exists('src/classes/' . $class . '.php')) {
        require_once('src/classes/' . $class . '.php');
    }
}

spl_autoload_register('appAutoLoad');

require_once('src/utils/encrypt.php');