<?php

class StaffroomController extends Zend_Controller_Action
{

    public function init()
    {
            $mysession = new Zend_Session_Namespace('mysession'); 
            $id = $mysession->id;
            $my_level = $mysession->userlevel;
            $my_logins = $mysession->num_logins;
            $my_last_login = $mysession->last_login;
            $my_subscription = $mysession->subscribed;
            if($mysession->unifyuser) $my_name = $mysession->display_name;
            else $my_name = $mysession->username;
            $this->view->username = $my_name;
            $this->view->id = $id;
            $this->view->level = $my_level;
            $this->view->num_logins = $my_logins;
            $this->view->last_login = $my_last_login;
            $this->view->subscription = $my_subscription;
            $active_users = new Application_Model_DbTable_ActiveUsers;
            $active_guests = new Application_Model_DbTable_ActiveGuests;
            $active_users->removeIdleUser();
            $active_guests->removeIdleUser();
            if ($mysession->userlevel == '0') $active_guests->updateUser('timestamp',time(),'id',$mysession->id);
            else $active_users->updateUser('timestamp',time(),'id',$mysession->id);
    }

    public function indexAction()
    {
            $units = new Application_Model_DbTable_UnitOfWork();
            $mysession = new Zend_Session_Namespace('mysession'); 
            $id = $mysession->id;
            $my_level = $mysession->userlevel;
            $my_name = $mysession->username;
            $my_units = $units->fetchAll($units->select()->where('teacher_id = ?', $id)->order(array('id DESC')));
            $this->view->unit_count = sizeof($my_units);
            if ($my_level==4)//free subscription users can only plan 10 lessons. they may delete them though
                {
                    if (sizeof($my_units)<10) unset($mysession->create_limit);
                    else $mysession->create_limit = 10;
                }
            if($_GET['reason']) $this->view->reason=$_GET['reason'];
        if($my_level==0){
            $id_array=array($id,1);
            $this->view->units = $units->fetchAll($units->select()->where('teacher_id IN (?)', $id_array)->order(array('id DESC')));
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'freetrial',2=>'staffroom',3=>'additionalresources');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        }
        elseif($my_level==1){
            $id_array=array($id,1);
            $this->view->units = $units->fetchAll($units->select()->where('teacher_id IN (?)', $id_array)->order(array('id DESC')));
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'planalesson',2=>'staffroom',3=>'additionalresources');
            $this->view->left_box_title = array(1=>'peschool',2=>'social',3=>'faqs');
        }
        else {
            $id_array=array($id,1);
            $this->view->units = $units->fetchAll($units->select()->where('teacher_id IN (?)', $id_array)->order(array('id DESC')))->toArray();
            $this->view->num_right_boxes = 3;
            $this->view->num_left_boxes = 0;
            $this->view->right_box_title = array(1=>'createyourown',2=>'staffroom',3=>'additionalresources');
            $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        }
    }

    public function showLessonsAction()
    {        
        $this->_helper->layout()->disableLayout();
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        //print_r($this->_request->getParam);
        $_GET['unit_id'] = (isset($_GET['unit_id']) ? $_GET['unit_id'] : $this->_request->getParam('unit_id'));
        if($_GET['unit_id']!='not_set') {
        $id = $_GET['unit_id'];}
        $_GET['unit_description'] = (isset($_GET['unit_description']) ? $_GET['unit_description'] : $this->_request->getParam('unit_description'));
        if($_GET['unit_description']!='not_set') {
        $desc = $_GET['unit_description'];}
        $_GET['unit_level'] = (isset($_GET['unit_level']) ? $_GET['unit_level'] : $this->_request->getParam('unit_level'));
        if($_GET['unit_level']!='not_set') {
        $unit_level = $_GET['unit_level'];}
        $_GET['unit_topic'] = (isset($_GET['unit_topic']) ? $_GET['unit_topic'] : $this->_request->getParam('unit_topic'));
        if($_GET['unit_topic']!='not_set') {
        $unit_topic = $_GET['unit_topic'];}
        $_GET['unit_numlessons'] = (isset($_GET['unit_numlessons']) ? $_GET['unit_numlessons'] : $this->_request->getParam('unit_numlessons'));
        if($_GET['unit_numlessons']!='not_set') {
        $unit_numlessons = $_GET['unit_numlessons'];}
        $lessons = new Application_Model_DbTable_Lesson();
        $unit_lessons=$lessons->getUnitLessons($id,$my_id,$my_level);
        $lesson_array=$unit_lessons->toArray();
        $resources = new Application_Model_DbTable_ContentResources();
        $lesson_resources=$resources->getLessonResources($lesson_array[0]['id']);
        $this->view->resources = $lesson_resources;
        $this->view->unit_id = $id;
        $this->view->unit_description = $desc;
        $this->view->unit_level = $unit_level;
        $this->view->unit_topic = $unit_topic;
        $this->view->unit_numlessons = $unit_numlessons;
        $this->view->lessons_arr = $lesson_array;
        return $this->view->lessons = $unit_lessons;
                
    }
    public function showLessonDetailsAction()
    {
        $this->_helper->layout()->disableLayout();
        $topic_id=$_GET['topic_id'];
        $level_id=$_GET['level_id'];
        $theme_id=$_GET['theme_id'];
        $this->view->lessonNum=$_GET['lesson_num'];
        $this->view->unitId=$_GET['unit_id'];
        $lesson_id=$_GET['lesson_id'];
        $themes = new Application_Model_DbTable_Theme();
        $lesson_description=$themes->getLessonTheme($topic_id,$level_id,$theme_id);
        $resources = new Application_Model_DbTable_ContentResources();
        $lesson_resources=$resources->getLessonResources($lesson_id);
        $this->view->resources = $lesson_resources;
        return $this->view->themes = $lesson_description;
    }
    public function editLessonAction()
    {
        $this->_helper->layout()->disableLayout();
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        $unit_id=$_GET['unit_id'];
        $lesson_num=$_GET['lesson_num'];
        $plan_type=$_GET['plan_type'];
        if((($my_level==1)||($my_level==0))&&($lesson_num!=1)){
            $response['result']=0;
            if ($my_level==1) $response['detail']='1';
            if ($my_level==0) $response['detail']='0';
            $response['more']='edit_lesson_limit';
        }
        elseif(isset($mysession->edit_limit)){
            $response['result']=0;
            if ($my_level==1) $response['detail']='1';
            if ($my_level==0) $response['detail']='0';
            $response['more']='edit_lesson_limit';
        } 
        else {
            $this->_helper->viewRenderer->setNoRender();
            $urlParams['unit_id']=$unit_id;
            $urlParams['lesson_num']=$lesson_num;
            $urlParams['plan_type']='newPlan';
            $urlParams['my_id']=$my_id;
            if($my_level==0) 
                {$mysession->edit_limit=1;
                 $my_level=1;}
            $urlParams['my_level']=$my_level;
            $urlParamsEnc=base64_encode(serialize($urlParams));
            $response['result']=1;
            $response['detail']="location.href=('/tplan/Lessons_2.php?p=".$urlParamsEnc."')";
            
        }
        return $this->_helper->json($response);
    }
    public function printLessonAction()
    {
        $this->_helper->layout()->disableLayout();
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        $unit_id=$_GET['unit_id'];
        $lesson_num=$_GET['lesson_num'];
        if((($my_level==1)||($my_level==0))&&($lesson_num!=1)){
            $response['result']=0;
            if ($my_level==1) $response['detail']='1';
            if ($my_level==0) $response['detail']='0';
            $response['more']='print_lesson_limit';
        }
        elseif($mysession->print_limit==2){
            $response['result']=0;
            if ($my_level==1) $response['detail']='1';
            if ($my_level==0) $response['detail']='0';
            $response['more']='print_lesson_limit';
        }
        else {
            $this->_helper->viewRenderer->setNoRender();
            $urlParams['unit_id']=$unit_id;
            $urlParams['lesson_num']=$lesson_num;
            if($my_level==0) 
                {$mysession->print_limit=$mysession->print_limit+1;
                 $my_level=1;}
            $urlParamsEnc=base64_encode(serialize($urlParams));
            $response['result']=1;
            $response['detail']='/tplan/code/main_plan_print_2.php?p='.$urlParamsEnc;
        }
        return $this->_helper->json($response);
     }
    public function newprintLessonAction()
    {
        $this->_helper->layout()->disableLayout();
        $mysession = new Zend_Session_Namespace('mysession'); 
        $my_id = $mysession->id;
        $my_level = $mysession->userlevel;
        $unit_id=$_GET['unit_id'];
        $lesson_num=$_GET['lesson_num'];
        if((($my_level==1)||($my_level==0))&&($lesson_num!=1)){
            $response['result']=0;
            if ($my_level==1) $response['detail']='Subscribe';
            if ($my_level==0) $response['detail']='Register';
            $response['more']='print_lesson_limit';
        }
        elseif($mysession->print_limit==2){
            $response['result']=0;
            $response['detail']='Register';
            $response['more']='print_limit';
        }
        else {
            $unit = new Application_Model_DbTable_UnitOfWork();
            $unit_details = $unit->getUnitdetails($unit_id);
            $this->view->title_detail = $unit_details->toArray();
            $lesson = new Application_Model_DbTable_Lesson();
            $lesson_details_objectives = $lesson->getLessonDetails($unit_id,$lesson_num,'id','objectives','objective','objective_id');
            $lesson_details_keywords = $lesson->getLessonDetails($unit_id,$lesson_num,'id','keywords','keyword','keyword_id');
            $lesson_details_icts = $lesson->getLessonDetails($unit_id,$lesson_num,'id','ICT','description','ict_id');
            $lesson_details_citizenships = $lesson->getLessonDetails($unit_id,$lesson_num,'id','citizenship','description','citizenship_id');
            $lesson_details_numeracys = $lesson->getLessonDetails($unit_id,$lesson_num,'id','numeracy','description','numeracy_id');
            $lesson_details_risk_assessments = $lesson->getLessonDetails($unit_id,$lesson_num,'id','risk_assessment','description','ra_id');
            //$this->view->query = $lesson_details_objectives;
            $this->view->lesson_detail_objectives = $lesson_details_objectives->toArray();
            $this->view->lesson_detail_keywords = $lesson_details_keywords->toArray();
            $this->view->lesson_detail_icts = $lesson_details_icts->toArray();
            $this->view->lesson_detail_citizenships = $lesson_details_citizenships->toArray();
            $this->view->lesson_detail_numeracys = $lesson_details_numeracys->toArray();
            $this->view->lesson_detail_risk_assessments = $lesson_details_risk_assessments->toArray();
            return $this->view;
        }
        return $this->_helper->json($response);
     }
     public function renameUnitAction()
     {
            $units = new Application_Model_DbTable_UnitOfWork();
            $mysession = new Zend_Session_Namespace('mysession'); 
            $my_id = $mysession->id;
            $my_level = $mysession->userlevel;
            $unit_id = $_GET['unit_id'];
            $name = $_GET['name'];
            $unit_data = array('description' => $name);
            $unit_where = 'id = '.$unit_id;
            $owners = $units->getOwner($unit_id);
            foreach ($owners as $owner)
            {
                $teacher_id=$owner->teacher_id;
            }
            if($teacher_id==$my_id){
            if($my_level==0){
                $response['result']=0;
                $response['detail']='Register';
                $response['more']='rename_lesson_limit';
                }
            else {
                if ($units->update($unit_data,$unit_where))
                {
                    $response['result']=1;
                }
                else {
                    $response['result']=0;
                    $response['detail']="could not rename, try again later";
                    $response['more']='rename_lesson_limit';
                }
            }
            } else {
                $response['result']=0;
                $response['detail']="Unit cannot be renamed";
                $response['more']='Sorry but you do not have sufficient privileges to rename this unit';
            }
            return $this->_helper->json($response);
     }
     public function deleteUnitAction()
     {
            $mysession = new Zend_Session_Namespace('mysession'); 
            $my_id = $mysession->id;
            $my_level = $mysession->userlevel;
            $units = new Application_Model_DbTable_UnitOfWork();
            $unit_id = $_GET['unit_id'];
            $unit_where = 'id = '.$unit_id;
            $owners = $units->getOwner($unit_id);
            foreach ($owners as $owner)
            {
                $teacher_id=$owner->teacher_id;
            }
            if($teacher_id==$my_id){
            if($my_level==0){
                $response['result']=0;
                $response['detail']='Register';
                $response['more']='delete_lesson_limit';
                }
            else {
                if ($units->delete($unit_where))
                {
                    $lessons = new Application_Model_DbTable_Lesson();
                    $lesson_where = 'uow_id = '.$unit_id;
                    $lessons->delete($lesson_where);
            
                    $response['result']=1;
                }
                else {
                    $response['result']=0;
                    $response['detail']="could not delete, try again later";
                    $response['more']='delete_lesson_limit';
                }
            }
            }
            else {
                    $response['result']=0;
                    $response['detail']="Unit Cannot be Deleted";
                    $response['more']="You do not have sufficient privileges to delete this unit";
            }
            return $this->_helper->json($response);
      }
}



