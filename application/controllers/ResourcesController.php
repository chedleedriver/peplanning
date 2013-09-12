<?php

class ResourcesController extends Zend_Controller_Action
{

    public function init()
    {
            $mysession = new Zend_Session_Namespace('mysession');
            $id = $mysession->id;
            $my_level = $mysession->userlevel;
            $my_name = $mysession->username;
            $this->view->username = $my_name;
            $this->view->id = $id;
            $this->view->level = $my_level;
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
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }

    public function longTermGuidanceAction()
    {
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }
    public function dinnertimeDelightersAction()
    {
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }

    
    public function dinnertimeDelightersKs2Action()
    {
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }

    
    public function dinnertimeDelightersKs1Action()
    {
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }

    
    public function dinnertimeDelightersFoundationAction()
    {
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }

    
    public function sportsDayGuidanceAction()
    {
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }

    public function sportsFestivalPlansAction()
    {
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }
    
    public function gymResourceCardsAction()
    {
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }
    public function additionalLessonPlansAction()
    {
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }
    public function basketballAction()
    {
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }
    public function volleyballAction()
    {
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }
    public function netballAction()
    {
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'createyourown');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'social',3=>'createyourown');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }
    
    public function downloadAction()
    {
        $this->view->download = base64_decode($_GET['d']);
    }

}







