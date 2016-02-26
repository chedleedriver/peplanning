<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
// Define the Project base path
defined('APPLICATION_BASE')
    || define('APPLICATION_BASE', dirname(dirname(__FILE__)));
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', APPLICATION_BASE . '/application');
// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
//Define application host
defined('APPLICATION_HOST')
    || define('APPLICATION_HOST', (getenv('APPLICATION_HOST') ? getenv('APPLICATION_HOST') : $_SERVER['HTTP_HOST']));
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_BASE . '/library'),
    realpath(APPLICATION_BASE . '/library/simplesamlphp/lib'),
//    realpath(APPLICATION_PATH . '/forms'),
//    realpath(APPLICATION_PATH . '/models'),
//    realpath(APPLICATION_PATH . '/models/DbTable'),
    get_include_path(),
)));
$inc_path = get_include_path();
/** Zend_Application */
require_once 'Application.php';
// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();
