<?php
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
   get_include_path(),
)));
$inc_path = get_include_path();
?>