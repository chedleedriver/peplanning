<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
            $mysession = new Zend_Session_Namespace('mysession');        
            $active_users = new Application_Model_DbTable_ActiveUsers;
            $active_guests = new Application_Model_DbTable_ActiveGuests;
            $active_users->removeIdleUser();
            $active_guests->removeIdleUser();
            if ($mysession->userlevel == '0') $active_guests->updateUser('timestamp',time(),'id',$mysession->id);
            else $active_users->updateUser('timestamp',time(),'id',$mysession->id);
            
    }

    public function indexAction()
    {
        //$this->_redirect('auth/login'); 
    }


}

