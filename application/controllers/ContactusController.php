<?php

class ContactusController extends Zend_Controller_Action
{

    public function init()
    {
            $this->_helper->layout()->setLayout('layout');
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
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 2;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'faqs',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'freetrial',2=>'faqs',3=>'social');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 2;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'subscribe',2=>'video');
            $this->view->left_box_title = array(1=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 1;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'video');
            $this->view->left_box_title = array(1=>'faqs');
        }
    }


}

