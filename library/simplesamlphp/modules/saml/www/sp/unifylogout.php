<?php

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
   'production',
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