<?php

class LearnController extends Zend_Controller_Action
{

    public function init()
    {
            $this->_helper->layout()->setLayout('infolayout');
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
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'freetrial',2=>'',3=>'planalesson');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'subscribe',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social'); 
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'staffroom',2=>'',3=>'planalesson');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        }
    }

    public function slide1Action()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'social');
            $this->view->left_box_title = array(1=>'peschool',2=>'endorsements',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 2;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'planalesson');
            $this->view->left_box_title = array(1=>'endorsements',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 2;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'staffroom',2=>'planalesson');
            $this->view->left_box_title = array(1=>'endorsements',2=>'social',3=>'faqs');
        }
    }

    public function slide2Action()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 2;
            $this->view->num_left_boxes = 2;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'video');
            $this->view->left_box_title = array(1=>'endorsements',2=>'faqs',3=>'endorsements');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 2;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'planalesson');
            $this->view->left_box_title = array(1=>'endorsements',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 2;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'staffroom',2=>'planalesson',3=>'video');
            $this->view->left_box_title = array(1=>'endorsements',2=>'social',3=>'faqs');
        }
    }

    public function slide3Action()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 1;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'planalesson',2=>'planalesson',3=>'video');
            $this->view->left_box_title = array(1=>'endorsements',2=>'endorsements',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 1;
            $this->view->num_left_boxes = 2;
            $this->view->right_box_title = array(1=>'planalesson',2=>'subscribe',3=>'planalesson');
            $this->view->left_box_title = array(1=>'subscribe',2=>'endorsements',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 1;
            $this->view->num_left_boxes = 2;
            $this->view->right_box_title = array(1=>'staffroom',2=>'planalesson',3=>'planalesson');
            $this->view->left_box_title = array(1=>'endorsements',2=>'social',3=>'faqs');
        }
    }

    public function peschoolAction()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'planalesson',2=>'register',3=>'faqs');
            $this->view->left_box_title = array(1=>'endorsements',2=>'peteacher',3=>'pecoach');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'faqs');
            $this->view->left_box_title = array(1=>'endorsements',2=>'peteacher',3=>'pecoach');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'staffroom',2=>'planalesson',3=>'social');
            $this->view->left_box_title = array(1=>'endorsements',2=>'peteacher',3=>'pecoach');
        }
    }

    public function pecoachAction()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'faqs');
            $this->view->left_box_title = array(1=>'endorsements',2=>'peschool',3=>'peteacher');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'faqs');
            $this->view->left_box_title = array(1=>'endorsements',2=>'peteacher',3=>'peschool');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'staffroom',2=>'planalesson',3=>'social');
            $this->view->left_box_title = array(1=>'endorsements',2=>'peteacher',3=>'peschool');
        }
    }

    public function peteacherAction()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'faqs');
            $this->view->left_box_title = array(1=>'endorsements',2=>'peschool',3=>'pecoach');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'faqs');
            $this->view->left_box_title = array(1=>'endorsements',2=>'peschool',3=>'pecoach');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'staffroom',2=>'planalesson',3=>'social');
            $this->view->left_box_title = array(1=>'endorsements',2=>'peschool',3=>'pecoach');
        }
    }

    public function faqsAction()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 2;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'userguide');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 2;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'userguide');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 2;
            $this->view->right_box_title = array(1=>'staffroom',2=>'planalesson',3=>'userguide');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
    }

    public function partnersAction()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 2;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'planalesson');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 2;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'planalesson');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        }
        else {
            $this->view->num_right_boxes = 2;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'staffroom',2=>'planalesson',3=>'planalesson');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        }
    }

    public function endorsementsAction()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 1;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'freetrial',2=>'freetrial',3=>'planalesson');
            $this->view->left_box_title = array(1=>'planalesson',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 1;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'video');
            $this->view->left_box_title = array(1=>'planalesson',2=>'social',3=>'faqs');
        }
        else {
            $this->view->num_right_boxes = 1;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'video');
            $this->view->left_box_title = array(1=>'planalesson',2=>'social',3=>'faqs');
        }
    }
    
    public function assessmentAction()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'freetrial',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'subscribe',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'staffroom',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        }
    }
    
    public function staffroomAction()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'freetrial',2=>'planalesson',3=>'userguide');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'subscribe',2=>'planalesson',3=>'userguide');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        elseif($my_level==4){
            $this->view->num_right_boxes = 2;
            $this->view->num_left_boxes = 2;
            $this->view->right_box_title = array(1=>'planalesson',2=>'userguide',3=>'userguide');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
        else {
            $this->view->num_right_boxes = 2;
            $this->view->num_left_boxes = 2;
            $this->view->right_box_title = array(1=>'planalesson',2=>'userguide',3=>'planalesson');
            $this->view->left_box_title = array(1=>'social',2=>'faqs',3=>'social');
        }
    }
    public function restrictionsAction()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'freetrial',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'subscribe',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        }
        else {
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 3;
            $this->view->right_box_title = array(1=>'staffroom',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        }
    }
    public function legacyAction()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 0;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'freetrial',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'endorsements',2=>'faqs',3=>'social');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 0;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'subscribe',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'endorsements',2=>'faqs',3=>'social');
        }
        else {
            $this->view->num_right_boxes = 0;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'staffroom',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'endorsements',2=>'faqs',3=>'social');
        }
    }
     public function videoAction()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        if($my_level==0){
            $this->view->num_right_boxes = 0;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'freetrial',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'endorsements',2=>'faqs',3=>'social');
        }
        elseif($my_level==1){
            $this->view->num_right_boxes = 0;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'subscribe',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'endorsements',2=>'faqs',3=>'social');
        }
        else {
            $this->view->num_right_boxes = 0;
            $this->view->num_left_boxes = 1;
            $this->view->right_box_title = array(1=>'staffroom',2=>'video',3=>'planalesson');
            $this->view->left_box_title = array(1=>'endorsements',2=>'faqs',3=>'social');
        }
    }
}



















