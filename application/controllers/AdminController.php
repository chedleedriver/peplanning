<?php

class AdminController extends Zend_Controller_Action
{

    public function init()
    {
        $mysession = new Zend_Session_Namespace('mysession'); 
        $id = $mysession->id;
        $my_level = $mysession->userlevel;
		if($my_level!=9) $this->_helper->redirector('index','staffroom');
		else $this->_helper->layout()->setLayout('layout');
    }

    public function indexAction()
    {
        // action body
    }
    
    
    public function saveUser($values,$activation_key)
    {
        if(($values['name_subscribe'])&&($values['email_subscribe'])&&($values['password_subscribe'])&&($values['role_subscribe'])){
        $register_user = new Application_Model_DbTable_Users();
        $add_user=$register_user->createRow();
        $add_user->name=$values['name_subscribe'];
        $add_user->username=$values['email_subscribe'];
        $add_user->email=$values['email_subscribe'];
        $add_user->password=md5($values['password_subscribe']);
        //$add_user->activation=$activation_key;
        $add_user->what=$values['role_subscribe'];
        $add_user->userlevel='4';
        $add_user->timestamp=time();
        $add_user->subscribed=time();
        $add_user->num_logins=0;
        return $add_user->save();
        }
        else return 0;
    }
    public function createEmail($values,$activation_key)
    {
        $subscribe_body="Subscription Details\n\n";
        foreach($values as $key=>$data)
        {
            $subscribe_body.=$key." - ".$data."<br>";
        }
        $password_len=strlen($values['password_subscribe']);
		$password_out=$this->String2Stars($values['password_subscribe'],0,$password_len-3,'*');
		if($this->sendEmailDetails($subscribe_body,$subscribe_body,'subscribe@peplanning.org.uk','info@peplanning.org.uk','Subscribe',$sendfileaswell=0))
            {
                $mail_body_text="Welcome ".$values['name_subscribe']."\n\n"
                        ."You have just subscribed at www.peplanning.org.uk "
                        ."with the following information:\n\n"
                        ."Username: <b>".$values['email_subscribe']."</b>\n"
                        ."Password: <b>".$password_out."</b>\n\n"
                        ."Click the link below to login to your new PEplanning account:\n\n"
                        ."<a href='http://".$_SERVER['HTTP_HOST']."/auth/login'>LOGIN NOW</a>\n\n";
                $this->view->template_type='subscribe';
                $this->view->name=$values['name_subscribe'];
                $this->view->password=$password_out;
                $this->view->username=$values['email_subscribe'];
                $this->view->activation=$activation_key;
				$this->view->email=$values['email_subscribe'];
                $mail_body_html = $this->view->render('auth/template.phtml');
                return $this->sendEmailDetails($mail_body_text,$mail_body_html,'info@peplanning.org.uk',$values['email_subscribe'],'Welcome to PE Planning',$sendfileaswell=0);
             }
    }
    public function listusersAction()
    {
       //$this->_helper->layout()->disableLayout();
	   $users  = new Application_Model_DbTable_Users(); 
       $mysession = new Zend_Session_Namespace('mysession');
       $my_id = $mysession->id;
	   $this->view->where = $_GET['search_for'] ? "%".$_GET['search_for']."%" : "%";
	   $this->view->u_level = $_GET['u_level'] ? $_GET['u_level'] : "1";
	   $this->view->sort_by = $_GET['sort_by'] ? $_GET['sort_by'] : "id";
	   $this->view->direction = $_GET['direction'] ? $_GET['direction'] : "asc";
       $this->view->user_list=$users->getUserList($this->view->u_level,$this->view->sort_by,$this->view->direction,$this->view->where)->toArray();
       return $this->view;
    }
    public function listschoolusersAction()
    {
       //$this->_helper->layout()->disableLayout();
	   $users  = new Application_Model_DbTable_Users(); 
       $mysession = new Zend_Session_Namespace('mysession');
       $my_id = $mysession->id;
	   $this->view->where = $_GET['school_id'] ? $_GET['school_id'] : "%";
	   $this->view->sort_by = $_GET['sort_by'] ? $_GET['sort_by'] : "id";
	   $this->view->direction = $_GET['direction'] ? $_GET['direction'] : "asc";
       $this->view->user_list=$users->getSchoolUserList($this->view->sort_by,$this->view->direction,$this->view->where)->toArray();
       return $this->view;
    }
	public function editschoolusers($school_id,$user_level)
    {
       //$this->_helper->layout()->disableLayout();
	   $users  = new Application_Model_DbTable_Users(); 
       $mysession = new Zend_Session_Namespace('mysession');
       $my_id = $mysession->id;
	   $school_users=$users->getSchoolUserIdList($school_id)->toArray();
	   foreach($school_users as $school_user)
	   {
		   $users->updateUser('userlevel',$user_level,'id',$school_user['id']);
	   }
    }
    public function edituserAction()
    {
       $mysession = new Zend_Session_Namespace('mysession');
	   $my_id = $mysession->id;
       if ($this->getRequest()->isPost()) {
		    $ro_fields=array('idXadminedit','timestampXadminedit');
            $users  = new Application_Model_DbTable_Users(); 
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $data = $_POST['data'];
            $dataArray = explode("&", $data);
            $response['result']=0;
            $response['detail']='No Change';
            foreach ($dataArray as $dataSet) {
               $nameAndValue = explode("=", $dataSet);
			   if($nameAndValue[0]=="idXadminedit") $user_id=$nameAndValue[1];
                if(!in_array($nameAndValue[0],$ro_fields)){
				 if($nameAndValue[1]){
					if($nameAndValue[0]=="subscribedXadminedit") {
						$date_elements = explode("-",$nameAndValue[1]);
						$nameAndValue[1] = mktime(0,0,0,$date_elements[1],$date_elements[0], $date_elements[2]); }
						$field_name = explode("X",$nameAndValue[0]);
						if($nameAndValue[1]!=$field_name[0]) {
							if($nameAndValue[0]=="passwordXadminedit") {
								$nameAndValue[1] = md5($nameAndValue[1]); }
							if($users->updateUser($field_name[0],  urldecode($nameAndValue[1]),'id',$user_id)){
								$response[$nameAndValue[0]]['result']=1;
								$response[$nameAndValue[0]]['detail']='Details Updated';
								$response['result']=1;
							}
                    }
					
                    
                }
                else {
                    
                }
                
               }
               else {
                   
               }
           }
    	$response['referrer'] = $mysession->referrer; 
        return $this->_helper->json($response);
          
       }
           else {
       $edit_user_form = new Application_Form_AdminedituserForm();
       $users  = new Application_Model_DbTable_Users(); 
	   $this->view->user_id = $_GET['user_id'] ? $_GET['user_id'] : "";
	   $mysession->referrer = $_SERVER['HTTP_REFERER'];
       $user_stuff=$users->getAdminUserDetails($this->view->user_id)->toArray();
        $edit_user_form->setvars($user_stuff);
        $edit_user_form->startform();
        return $this->view->form = $edit_user_form;
       }
    }
	public function createuserAction()
    {
       $create_user_form = new Application_Form_AdmincreateuserForm();
       $users  = new Application_Model_DbTable_Users(); 
       $mysession = new Zend_Session_Namespace('mysession');
	   $my_id = $mysession->id;
       if ($this->getRequest()->isPost()) {
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $data = $_POST['data'];
            $dataArray = explode("&", $data);
			$param_string="";
			$lastElement = end($dataArray);
			foreach ($dataArray as $dataSet) {
               $nameAndValue = explode("=", $dataSet);
			   $user_values[$nameAndValue[0]]=urldecode($nameAndValue[1]);
			}
			if($users->createUser($user_values)) $response['result']=1;
			else $response['result']=0;
		$response['referrer'] = $mysession->referrer;	
        return $this->_helper->json($response);
          
       }
           else {
		$mysession->referrer = $_SERVER['HTTP_REFERER'];	   
        $create_user_form->startform();
        return $this->view->form = $create_user_form;
       }
    }
	public function deleteuserAction()
	{
		$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		$users  = new Application_Model_DbTable_Users(); 
		$mysession = new Zend_Session_Namespace('mysession');
	   	$u_id = $_GET['user_id'];
		if($users->deleteUser($u_id))
			{ $response['result'] = 1;
			  $response['referrer'] = $mysession->referrer;  }
			  else 
			{  
			  $response['result'] = 0;
			  $response['detail'] = "Didn't delete user with id ".$u_id;
			}
		return $this->_helper->json($response);
	}
    public function listschoolsAction()
    {
       //$this->_helper->layout()->disableLayout();
	   $schools  = new Application_Model_DbTable_School(); 
       $mysession = new Zend_Session_Namespace('mysession');
       $my_id = $mysession->id;
	   $this->view->where = $_GET['search_for'] ? "%".$_GET['search_for']."%" : "%";
       $this->view->sort_by = $_GET['sort_by'] ? $_GET['sort_by'] : "id";
	   $this->view->direction = $_GET['direction'] ? $_GET['direction'] : "asc";
       $this->view->school_list=$schools->getSchoolList($this->view->sort_by,$this->view->direction,$this->view->where)->toArray();
       return $this->view;
    }
	public function editschoolAction()
    {
       $mysession = new Zend_Session_Namespace('mysession');
	   $my_id = $mysession->id;
	   
       if ($this->getRequest()->isPost()) {
		    $ro_fields=array('idXschooledit');
            $school  = new Application_Model_DbTable_School(); 
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $data = $_POST['data'];
            $dataArray = explode("&", $data);
            $response['result']=0;
            $response['detail']='No Change';
            foreach ($dataArray as $dataSet) {
               $nameAndValue = explode("=", $dataSet);
			   if($nameAndValue[0]=="idXschooledit") $school_id=$nameAndValue[1];
                if(!in_array($nameAndValue[0],$ro_fields)){
				 if($nameAndValue[1]){
					if(($nameAndValue[0]=="subfromXschooledit")||($nameAndValue[0]=="subtoXschooledit")) {
						$date_elements = explode("-",$nameAndValue[1]);
						$nameAndValue[1] = mktime(0,0,0,$date_elements[1],$date_elements[0], $date_elements[2]); }
						$field_name = explode("X",$nameAndValue[0]);
						if($nameAndValue[1]!=$field_name[0]) {
							if($school->updateSchool($field_name[0],  urldecode($nameAndValue[1]),'id',$school_id)){
								$response[$nameAndValue[0]]['result']=1;
								$response[$nameAndValue[0]]['detail']='Details Updated';
								$response['result']=1;
							}
							if($nameAndValue[0]=="approvedXschooledit")
							{
								if(strtoupper($nameAndValue[1])=="Y") $this->editschoolusers($school_id,5);
								if(strtoupper($nameAndValue[1])=="N") $this->editschoolusers($school_id,1);
							}
                    }
					
                    
                }
                else {
                    
                }
                
               }
               else {
                   
               }
           }
		$response['referrer'] = $mysession->referrer;   
        return $this->_helper->json($response);
          
       }
           else {
       $edit_school_form = new Application_Form_AdmineditschoolForm();
       $schools  = new Application_Model_DbTable_School();
	   $mysession->referrer = $_SERVER['HTTP_REFERER']; 
	   $this->view->school_id = $_GET['school_id'] ? $_GET['school_id'] : "";
       $school_stuff=$schools->getAdminSchoolDetails($this->view->school_id)->toArray();
        $edit_school_form->setvars($school_stuff);
        $edit_school_form->startform();
        return $this->view->form = $edit_school_form;
       }
    }
    public function createschoolAction()
    {
       $create_school_form = new Application_Form_AdmincreateschoolForm();
       $school  = new Application_Model_DbTable_School(); 
       $mysession = new Zend_Session_Namespace('mysession');
	   $my_id = $mysession->id;
       if ($this->getRequest()->isPost()) 
	   {
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $data = $_POST['data'];
            $dataArray = explode("&", $data);
			$lastElement = end($dataArray);
			foreach ($dataArray as $dataSet) 
			{
               $nameAndValue = explode("=", $dataSet);
			   $school_values[$nameAndValue[0]]=urldecode($nameAndValue[1]);
			}
			$school_id=$school->admincreateSchool($school_values);
			if(!$school_id) $response['result']=0;
			else 
			{
				$response['result']=1;
				$response['school_id']=$school_id;
				$response['class_num']=$school_values['classnumXschooledit'];
			}
		$response['referrer'] = $mysession->referrer;
        return $this->_helper->json($response);
          
       }
       else 
	   {
		   $mysession->referrer = $_SERVER['HTTP_REFERER'];
		   $create_school_form->startform();
		   return $this->view->form = $create_school_form;
       }
    }
	public function addschooluserAction()
    {
       $users  = new Application_Model_DbTable_Users(); 
       $mysession = new Zend_Session_Namespace('mysession');
	   $my_id = $mysession->id;
       if ($this->getRequest()->isPost()) {
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $data = $_POST['data'];
            $dataArray = explode("&", $data);
			$lastElement = end($dataArray);
			foreach ($dataArray as $dataSet) {
               $nameAndValue = explode("=", $dataSet);
			   $school_user_values[$nameAndValue[0]]=urldecode($nameAndValue[1]);
			}
			if($users->admincreateschoolUsers($school_user_values)) $response['result']=1;
			else $response['result']=0;
		$response['referrer'] = $mysession->referrer;
        return $this->_helper->json($response);
          
       }
	   else {
	    $mysession->referrer = $_SERVER['HTTP_REFERER'];
		$this->view->school_id = $_GET['school_id'];
		$this->view->class_num = $_GET['class_num'];
		$school = new Application_Model_DbTable_School();
		$school_details=$school->getAdminSchoolDetails($this->view->school_id)->toArray();
		$this->view->school = $school_details['school'];
		$school_parts = explode(' ',$school_details['school']);
		foreach($school_parts as $pass_part){
			$pass_suggest=$pass_suggest.$pass_part;}
		$this->view->password_suggestion = strtolower($pass_suggest);
		$this->view->postcode = $school_details['postcode'];
		$email_parts = explode('@',$school_details['email']);
		$this->view->email_domain = $email_parts[1];
		$this->view->telephone = $school_details['telephone'];
        $this->view->subfrom = $school_details['subfrom'];
		return $this->view;
       }
	}
	public function createschoolusersAction()
    {
       $users  = new Application_Model_DbTable_Users(); 
       $mysession = new Zend_Session_Namespace('mysession');
	   $my_id = $mysession->id;
       if ($this->getRequest()->isPost()) {
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $school_user_values = $_POST;
            //$dataArray = explode("&", $data);
			//$lastElement = end($dataArray);
			//foreach ($dataArray as $dataSet) {
            //   $nameAndValue = explode("=", $dataSet);
			//   $school_user_values[$nameAndValue[0]]=urldecode($nameAndValue[1]);
			//}
			if($users->admincreateschoolUsers($school_user_values)) $response['result']=1;
			else $response['result']=0;
		$response['referrer'] = $mysession->referrer;
        return $this->_helper->json($response);
          
       }
           else {
	    $mysession->referrer = $_SERVER['HTTP_REFERER'];
		$this->view->school_id = $_GET['school_id'];
		$this->view->class_num = $_GET['class_num'];
		$school = new Application_Model_DbTable_School();
		$school_details=$school->getAdminSchoolDetails($this->view->school_id)->toArray();
		$this->view->school = $school_details['school'];
		$school_parts = explode(' ',$school_details['school']);
		foreach($school_parts as $pass_part){
			$pass_suggest=$pass_suggest.$pass_part;}
		$this->view->password_suggestion = strtolower($pass_suggest);
		$this->view->postcode = $school_details['postcode'];
		$email_parts = explode('@',$school_details['email']);
		$this->view->email_domain = $email_parts[1];
		$this->view->telephone = $school_details['telephone'];
        $this->view->subfrom = $school_details['subfrom'];
		return $this->view;
       }
    }
	public function deleteschoolAction()
	{
		$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		$school  = new Application_Model_DbTable_School(); 
		$mysession = new Zend_Session_Namespace('mysession');
	   	$s_id = $_GET['school_id'];
		if($school->deleteSchool($s_id))
			{ $response['result'] = 1;
			  $response['referrer'] = $mysession->referrer;  }
			  else 
			{  
			  $response['result'] = 0;
			  $response['detail'] = "Didn't delete school with id ".$s_id;
			}
		return $this->_helper->json($response);
	}
    public function checkActive($values)
    {
        $users  = new Application_Model_DbTable_Users();
        $is_email = new Zend_Validate_EmailAddress();
        if($is_email->isValid(urldecode($values['userName']))) {
                $result = $users->activatedUser(urldecode($values['userName']),'email');
                }
        else {
                $result = $users->activatedUser(urldecode($values['userName']),'username');
                }
        
        return $result;
    }
    public function checkAuth($values)
    {
        $users  = new Application_Model_DbTable_Users();
        $active = $this->checkActive($values);
        if($active)
        {
            $auth = Zend_Auth::getInstance();
            $authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter());
            $authAdapter->setTableName('users');
            $is_email = new Zend_Validate_EmailAddress();
            if($is_email->isValid(urldecode($values['userName']))) {
                $authAdapter->setIdentityColumn('email');
                }
            else $authAdapter->setIdentityColumn('username');
            $authAdapter->setIdentity(urldecode($values['userName']));
            $authAdapter->setCredentialColumn('password');
            $authAdapter->setCredential(md5($values['password']));
            try {
                $result['valid'] = $auth->authenticate($authAdapter);
                } 
                catch (Zend_Exception $e) {
                        $result['valid'] = $e->getMessage() . "<br>";
                    }
                if($result['valid']->isValid()) $result['data']=$authAdapter->getResultRowObject();
                else $result['data']="Invalid username or password try again";
            }
            else 
                {
                    $result['valid']=0;    
                    $result['data'] = "Inactive or Unsubscribed User Account. Please check your email to activate your account<br>To subscribe to PEplanning visit <a href='/auth/subscribe'>this page</a>";
                    }
        return $result;
    }
    public function getNumplans($id)
    {
        $units = new Application_Model_DbTable_UnitOfWork();
        $my_units = $units->fetchAll($units->select()->where('teacher_id = ?', $id)->order(array('id DESC')));
        return sizeof($my_units);
    }
    public function updateUserTables($id,$guest_id)
    {
        $active_users = new Application_Model_DbTable_ActiveUsers;
        $active_guests = new Application_Model_DbTable_ActiveGuests;
        $users = new Application_Model_DbTable_Users;
        $login_details = $users->getLoginDetails($id)->toArray();
        $num_login = $login_details['num_logins'] + 1;
        $active_update = $active_users->updateUser('timestamp',time(),'id',$id);
        $user_update = $users->updateUser('timestamp',time(),'id',$id);
        $guest_update = $active_guests->removeUser('id',$guest_id);
        $login_count = $users->updateUser('num_logins',$num_login,'id',$id);
        if ($active_update)
            return 1;
        else
            return 0;
            break;
        if ($user_update)
            return 1;
        else 
            return 0;
    }    
    public function clearSessionAction()
    {
        Zend_Session::destroy();
    }
    public function generateRandID()
    {
      return md5($this->generateRandStr(16));
    }
    public function generateLicenceKey()
    {
       return $this->generateRandStr(8);
    }
    public function generateRandStr($length)
    {
      $randstr = "";
      for($i=0; $i<$length; $i++){
         $randnum = mt_rand(0,61);
         if($randnum < 10){
            $randstr .= chr($randnum+48);
         }else if($randnum < 36){
            $randstr .= chr($randnum+55);
         }else{
            $randstr .= chr($randnum+61);
         }
      }
      return $randstr;
    }
    public function sendEmailDetails($mail_body_text,$mail_body_html,$sent_from,$send_to,$subject,$sendfileaswell)
    {
        $transport = new Zend_Mail_Transport_Smtp('localhost');
		//Zend_Mail::setDefaultTransport($transport);
        $send = new Zend_Mail();
        if($sendfileaswell){
            $fileContents = file_get_contents(APPLICATION_BASE.'/public/resource-downloads/Subscription Order Form.doc');
            $file = $send->createAttachment($fileContents);
            $file->filename = "Subscription Order Form.doc";}
        $send->setBodyText($mail_body_text);
        $send->setBodyHtml($mail_body_html);
        $send->setFrom($sent_from);
        $send->addTo($send_to);
        $send->setSubject($subject);
        if ($send->send($transport)) return 1;
        else return 0;
        
    }
    public function createSchool($values)
    {
      $create_school = new Application_Model_DbTable_School();
      if(!$create_school->checkSchool($values['school_payment']))
      {
        $licence = $this->generateLicenceKey();
        if($create_school->createSchool($values,$licence)) return 1;
        else return 0;
      }
      else
      {
        return 2;
      }
    }
    public function String2Stars($string='',$first=0,$last=0,$rep='*'){
  	$begin  = substr($string,0,$first);
  	$middle = str_repeat($rep,strlen(substr($string,$first,$last)));
  	$end    = substr($string,$last);
  	$stars  = $begin.$middle.$end;
 	return $stars;
	}
	
}



