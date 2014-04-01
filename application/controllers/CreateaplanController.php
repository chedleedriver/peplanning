<?php

class CreateaplanController extends Zend_Controller_Action
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
        $mysession = new Zend_Session_Namespace('mysession'); 
        $teacher_id = $mysession->id;
        $user_level = $mysession->userlevel;
        return $this->view->userlevel = $user_level;
    }
    
    public function getTopicsAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $_GET['level_id'] = (isset($_GET['level_id']) ? $_GET['level_id'] : 'not_set');
        if($_GET['level_id']!='not_set') {
        $level = $_GET['level_id'];}
        $_GET['plan_type'] = (isset($_GET['plan_type']) ? $_GET['plan_type'] : 'not_set');
        if($_GET['plan_type']!='not_set') {
        $plan_type = $_GET['plan_type'];}
        $topics=new Application_Model_DbTable_Topic();
        $topic_list = $topics->getTopicList($level,$plan_type);
	$topic_array=$topic_list->toArray();
        return $this->_helper->json($topic_array);
    }
    public function createPlanAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $mysession = new Zend_Session_Namespace('mysession'); 
        $teacher_id = $mysession->id;
        $user_level = $mysession->userlevel;
        $topics=new Application_Model_DbTable_Topic();
        $topic_details = $topics->getTopicStatus($_POST['sel_topic']);
        $topic_details_arr = $topic_details->toArray();
        $plan_type=$_POST['plan_type'];
        if($topic_details_arr['status']=="P")
        {
           $response['result']=1;
           $response['detail']='pdf';
           $response['more']=strtolower($topic_details_arr['name']);
        }
        elseif(!isset($mysession->create_limit)){
            if($plan_type=='setplan'){
                $set_plan_lessons = new Application_Model_DbTable_SetPlanLessons();
                $level=$_POST['sel_level'];
                $topic_id=$_POST['sel_topic'];
                $num_lessons=$_POST['sel_num_lessons'];
                $title=$_POST['title'];
                $set_plan_exists = $set_plan_lessons->checkSetPlan($topic_id,$level,$num_lessons);
                if(sizeof($set_plan_exists)>0)
                {
                $create_plan = new Application_Model_DbTable_StoredProcedures();
                if($user_level==0) {
                    if ($create_plan->CreateGuestPlan($teacher_id,$topic_id,'topic',$level,$title,$num_lessons,$plan_type)){
                    $response['result']=1;
                    $response['detail']='setplan';
                    if($user_level==0)$mysession->create_limit = 1;
                    }
                    else {
                    throw new CreatePlanProblem('setplan');
                    $response['result']=0;
                    $response['detail']='problem with creation';
                    }
                }
                else {
                    if ($create_plan->CreatePlan($teacher_id,$topic_id,'topic',$level,$title,$num_lessons,$plan_type)){
                    $response['result']=1;
                    $response['detail']='setplan';
                    $response['more']=$set_plan_exists;
                    }
                    else {
                    throw new CreatePlanProblem('guestplan');
                    $response['result']=0;
                    $response['detail']='problem with creation';
                    }
                }
                }
                else {
            $response['result']=0;
            $response['detail']='tryagain';
            $response['more']='Sorry, but there are no set plans available for your selections<br>This is usually because you chose too few lessons<br>please try again';
            
        }
                
            }
            elseif(($plan_type=='unsetplan')&&($user_level>=1)){
                $level=$_POST['own_sel_level'];
                $topic_id=$_POST['own_sel_topic'];
                $num_lessons=$_POST['own_sel_num_lessons'];
                $title=$_POST['own_title'];
                if(($level!=99)&&($topic_id!=0)&&($num_lessons!=0)&&($title!='Give your Unit a Title')){
                $create_plan = new Application_Model_DbTable_UnitOfWork();
                $unit_id=$create_plan->CreateUnit($teacher_id,$topic_id,'topic',$level,$title,$num_lessons,$plan_type);
                        if($unit_id!=0){
                            $create_lesson = new Application_Model_DbTable_Lesson();
                            for($i=1;$i<=$num_lessons;$i++){
                                $lesson_id = $create_lesson->createLesson($unit_id,$i);
                                if($lesson_id!=0) $response['result']=1;
                                else {$response['result']=0;
                                      $response['detail']='problem with creation';
                                }
                            }
                            if($response['result']==1) $response['detail']=$unit_id;
                            else $response['detail']='Cannot create all the lessons';
                        }
                        else {
                            //throw new CreatePlanProblem('unsetplan');
                            $response['result']=0;
                            $response['detail']='problem with creation';
                        }
                }
                else {
                    //throw new CreatePlanProblem('unsetplan');
                            $response['result']=0;
                            $response['detail']='You have not completed all the required fields correctly';
                }
            }
            else {
                $response['result']=0;
                $response['detail']=$user_level;
                $response['more']='plans';
            }
            
        
        }
        else {
            
            $response['result']=0;
            $response['detail']=$user_level;
            $response['more']='plans';
            
        }
        
        return $this->_helper->json($response);
    }
    public function unsetplanAction()
    {
        $this->_helper->layout()->disableLayout();
        //$this->_helper->viewRenderer->setNoRender();
        $planform = new Application_Form_UnsetplanForm();
        return $this->view->form = $planform;
    }
    public function checkSetPlanAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $level=$_GET['sel_level'];
        $topic_id=$_GET['sel_topic'];
        $num_lessons=$_GET['sel_num_lessons'];
        $set_plan_lessons = new Application_Model_DbTable_SetPlanLessons();
        $set_plan_exists = $set_plan_lessons->checkSetPlan($topic_id,$level,$num_lessons);
        $set_plan_array=$set_plan_exists->toArray();
        print_r($set_plan_array);
    }

}

