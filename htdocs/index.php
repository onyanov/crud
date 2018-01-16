<?php
$debug = true;

if ($debug) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ERROR);
    ini_set('display_errors', 0);
}

defined('PUBLIC_PATH') || define('PUBLIC_PATH', realpath(dirname(__FILE__)));
defined('APPLICATION_PATH') || define('APPLICATION_PATH', PUBLIC_PATH . '/../app/');
defined('LIBRARY_PATH') || define('LIBRARY_PATH', APPLICATION_PATH . '../library/');

require_once APPLICATION_PATH . 'config.php';
require_once APPLICATION_PATH . 'RealtyApp.php';
$application = new RealtyApp();
$application->bootstrap()->run();
