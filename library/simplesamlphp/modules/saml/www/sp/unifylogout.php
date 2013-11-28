<?php

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH','/var/www/html/peplanning/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

//Define application host
defined('APPLICATION_HOST')
    || define('APPLICATION_HOST', (getenv('APPLICATION_HOST') ? getenv('APPLICATION_HOST') : $_SERVER['HTTP_HOST']));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH . '/../library/simplesamlphp/lib'),
//    realpath(APPLICATION_PATH . '/forms'),
//    realpath(APPLICATION_PATH . '/models'),
//    realpath(APPLICATION_PATH . '/models/DbTable'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
   '/var/www/html/peplanning/application/configs/application.ini'
);
 $mysession = new Zend_Session_Namespace('mysession');
       $id=$mysession->id;
       $username=$mysession->username;
       $users  = new Application_Model_DbTable_Users();
       if ($mysession->unifyuser) $response['unify']=1; else $response['unify']=0;
       $this->_helper->layout()->disableLayout();
       $this->_helper->viewRenderer->setNoRender();
       Zend_Auth::getInstance()->clearIdentity();
       Zend_Session::destroy();
       if(!Zend_Auth::getInstance()->hasIdentity())
       {    
            $active_users = new Application_Model_DbTable_ActiveUsers;
            $active_row = $active_users->fetchRow("id = $id");
            if ($active_row) $deactive = $active_row->delete();
       }

?>