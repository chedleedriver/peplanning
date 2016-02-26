<?php

class EditplanController extends Zend_Controller_Action
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
            $this->_helper->layout()->setLayout('tilelayout');
            
    }

    public function indexAction()
    {
        
    }
	
	public function planner1Action()
	{
		$mysession = new Zend_Session_Namespace('mysession');
		if($mysession->planYear) {$this->view->planYear = $mysession->planYear;$num_selections = 1;}
		if($mysession->planTopic) {$this->view->planTopic = $this->gettopicname($mysession->planTopic);$num_selections = 1 + $num_selections;}
		if($mysession->planTheme) {$this->view->planTheme = ucfirst($mysession->planTheme);$num_selections = 1 + $num_selections;}
		if($num_selections==1)$mysession->planStatus='Steady';
		if($num_selections==2)$mysession->planStatus='Go!';
		if($mysession->planStatus) $this->view->planStatus=$mysession->planStatus;
		$this->view->num_selections = $num_selections;
		$this->view->topics = $this->gettopics();
	}
	
	public function planner2Action()
	{
		$mysession = new Zend_Session_Namespace('mysession');
	}
	
	public function setplanoptionAction()
	{
		$num_selections = 0;
		$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $mysession = new Zend_Session_Namespace('mysession');
		$plan_option_var="plan".$_GET['plan_option_type'];
		if($_GET['plan_option_type']=="Topic") 
			{
				$plan_option = $this->gettopicname($_GET['plan_option']);
				unset($mysession->planTheme);
				} 
		elseif($_GET['plan_option_type']=="Theme") {unset($mysession->planTopic);$plan_option = $_GET['plan_option'];}
		else $plan_option = $_GET['plan_option'];
		$mysession->$plan_option_var = $_GET['plan_option'];
		if($_GET['plan_option_type']!="Year") $this->codeToSend = "<div id=$plan_option_var><p>".ucfirst($plan_option)."</p></div>"; else $this->codeToSend = "<div id=$plan_option_var><p>Year ".$plan_option."</p></div>";
		if($mysession->planYear) $num_selections = 1;
		if($mysession->planTopic) $num_selections = 1 + $num_selections;
		if($mysession->planTheme) $num_selections = 1 + $num_selections;
		if($num_selections==1)$mysession->planStatus='Steady';
		if($num_selections==2)$mysession->planStatus='Go!';
		$response['num_selections'] = $num_selections;
		$response['code'] = $this->codeToSend;
		return $this->_helper->json($response);
		
	}
	public function makeplanAction()
	{
		$mysession = new Zend_Session_Namespace('mysession');
		$response['year'] = $mysession->planYear;
		if($mysession->planTopic) $response['topic'] =  $mysession->planTopic; 
		if($mysession->planTheme) $response['theme'] =  ucfirst($mysession->planTheme); 
		return $this->_helper->json($response);	
	}
	public function gettopicname($topic_id)
	{
		$topics=new Application_Model_DbTable_Topic();
		$topic_arr = $topics->getTopicName($topic_id)->toArray();
		if(is_array($topic_arr)) return $topic_arr['name'];
	}
	public function gettopics()
	{
		$topics=new Application_Model_DbTable_Topic();
		return $topic_list = $topics->getPlannerTopicList()->toArray();
	}
	public function checkplan($for_what)
	{
		switch($for_what){
			case 0: //check if they exceed their creation limits
			if($this->too_many_plans()) return 0;
			else return 1;
			exit;
			case 1: //chack if a set plan exists
			if($this->is_there_a_plan()) return 1;
			else return 0;
			exit;
		}
	}
	
	public function too_many_plans()
	{
		
	}
}
