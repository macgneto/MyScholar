<?php

spl_autoload_register(function ($class) {
    require dirname(__DIR__) . "/classes/{$class}.php";
});

define('basedir', 'http://myscholar.ddns.net/main/');
// define("ROOT", __DIR__ ."/");
//
//
//
//
// define('basedir', $_SERVER['DOCUMENT_ROOT']);
// define("ROOT", __DIR__ ."/");
//
//
//
//
// define('BASE_PATH', str_replace('/includes', '', dirname(__FILE__)));
// define('BASE_PATH', dirname(__FILE__));

// define("BASE_URL","/");
// define("ROOT_PATH",$_SERVER["DOCUMENT_ROOT"] . "/");

session_start();
