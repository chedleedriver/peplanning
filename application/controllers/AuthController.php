<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout()->setLayout('layout');
				
    }

    public function indexAction()
    {
        // action body
    }
    
	
    
    public function loginAction()
    {
       /**$form = new Application_Form_LoginForm();
       $mysession = new Zend_Session_Namespace('mysession');
       if ($this->getRequest()->isPost()) {
           $this->_helper->layout()->disableLayout();
           $this->_helper->viewRenderer->setNoRender();
           $dataArray = explode("&", $_POST['data']);
           foreach ($dataArray as $dataSet) {
               $nameAndValue = explode("=", $dataSet);
               $values[$nameAndValue[0]] = $nameAndValue[1];
           }
        if ($form->isValid($values)) { //is the form valid?
           $result=$this->checkAuth($values);   
           if ($result['valid']!=0) {
           if ($result['valid']->isValid()) { //correct username and password ?
                 $mysession = new Zend_Session_Namespace('mysession');
                 $guest_id = $mysession->id;
                 Zend_Session::namespaceUnset('mysession');
                 $data=$result['data'];
                 $_SESSION['id'] = $mysession->id = $data->id;
                 $mysession->username = $data->username;
                 $_SESSION['userlevel'] = $mysession->userlevel = $data->userlevel;
                 $mysession->email = $data->email;
                 $mysession->num_logins = $data->num_logins + 1;
                 $mysession->last_login = $data->timestamp;
                 $mysession->subscribed = $data->subscribed;
                 if($mysession->userlevel==4) { //are they fully subscribed
                        $num_of_plans = $this->getNumplans($mysession->id);
                        if($num_of_plans<10) { //is the number of plans ok?
                            $elapsed=time()-$data->subscribed;
                            if(($data->subscribed+2592000>=time())||($mysession->userlevel>=5)) { //some sort of test as to when they subscribed
                                $active = $this->updateUserTables($mysession->id,$guest_id);
                                if($active){
                                    $response['result']='1';
                                    $response['detail']=$mysession->num_logins;
                                    } else {
                                        echo $active;
                                        $response['result']='0';
                                        $response['detail']="Can't update database. Check <a href='javascript:void(0)' onclick='javascript:shutMeAndTakeMeHere(\"/learn/faqs?a=register_a4\")'>here</a> for what to do";
                                    }
                                } else {
                                    $response['result']='2';
                                    $response['detail']=$elapsed;
                                }   
                                
                            } else {
                                $mysession->create_limit = 10;
                                $response['result']='3';
                                $response['detail']='plans';
                            }
                                
                    } else {
                        $active = $this->updateUserTables($mysession->id,$guest_id);
                                if($active){
                                    if($mysession->userlevel==1){
                                            $response['result']='1';
                                            $response['detail']='registered';
                                            }
                                    else {
                                            $response['result']='1';
                                            $response['detail']=$mysession->num_logins;
                                            }
                                    } else {
                                        echo $active;
                                        $response['result']='0';
                                        $response['detail']="Can't update database. Check <a href='javascript:void(0)' onclick='javascript:shutMeAndTakeMeHere(\"/learn/faqs?a=register_a4\")'>here</a> for what to do";
                                    }
                        }
                
            } else {
                $response['result']='0';
                $response['detail']=$result['data'];
            }
            }
            else {
                //active check
                $response['result']='0';
                $response['detail']=$result['data'];
            }
            //valid form test
        }
        else {
           $response['result']='0';
           $response['detail']="Please complete all the fields on the login form"; 
        }
       return $this->_helper->json($response);
       }// check that the form has been submitted
       else {
        //$this->_helper->layout()->disableLayout();
        if($_GET['fail']) $this->view->fail=$_GET['fail'];
        $loginform = new Application_Form_LoginForm();
        return $this->view->form = $loginform;
       }**/
	   $this->redirect('/auth/signup?process=0');
    }
    public function logoutAction()
    {
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
            $response['result']='1';
            $response['detail']='logged out'; }
            else{
               $response['result']='0';
               $response['detail']='not logged out'; 
            }
       return $this->_helper->json($response);
    }
    public function unifylogoutAction()
    {
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
       
    }

    public function subscribeAction()
    {
       /**include("recaptchalib.php");
       $privatekey = "6LdQmPESAAAAAIYhvd1X3piy5s06tifVD2Ds0ROt";
	   $mysession = new Zend_Session_Namespace('mysession'); 
       $form = new Application_Form_SubscribeForm();
       if ($this->getRequest()->isPost()) {
           //set up validation for email addresses
            $isEmail=new Zend_Validate_EmailAddress(
				array(
        			'allow' => Zend_Validate_Hostname::ALLOW_DNS,
        			'useMxCheck'    => true,
        			'useDeepMxCheck'  => true
    				)
			);
           //Don't display anything yet
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            //Get the form data
            $data = $_POST['data'];
            //Explode the array into pairs of item/value
            $dataArray = explode("&", $data);
                foreach ($dataArray as $dataSet) {
                    $nameAndValue = explode("=", $dataSet);
                    $values[$nameAndValue[0]] = urldecode($nameAndValue[1]);
                }
			$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $values["recaptcha_challenge_field"],
                                $values["recaptcha_response_field"]);
            //Validate the information on the form
			if($resp->is_valid)
                {
				  if ($form->isValid($values)) {
				  $response['result']=1;
				  $enquiry_body="Enquiry Details\n\n";
				  foreach($values as $key=>$data)
					  {
					  $response[$key]='';
						  
						  if(substr($key,-14)!="_subscribe_msg")
						  {
							  if($key=="email_subscribe") {
								  $email_val=$data;    
								  if($isEmail->isValid($data)){
									  $response['result']=1;
								  }
								  else {
									  $response['result']=4;
									  $response[$key]="Email address invalid";
								  }
							  }
							  if($key==$data."_subscribe"){
							  $response['result']=4;
							  $response[$key]="You must enter ".$data;
							  }
							  if($key=="password_subscribe"){
								  if($data==""){
									  $response['result']=4;
									  $response[$key]="You must enter a password";
								  }
								  elseif(($data=="password")||(strlen($data)<=5)){
									  $response['result']=4;
									  $response[$key]="Password too simple (must be greater than 5 chars)";
								  }
								  else {
									  //$response['result']=1;
								  }
							  }
							  if(($key=="email_confirm_subscribe")&&($data!=$email_val)){
							  $response['result']=4;
							  $response[$key]="Email addresses must match";
							  }
							  if(($key=="role_subscribe")&&($data==0)){
							  $response['result']=4;
							  $response[$key]="You must select a role in school";
							  }
						  }
					   }
					   if($response['result']!=4)
						  {
							  //Successfully passed the validation
							  //Now we need to subscribe them and send the emails
							  //first we create an sctivation key
							  $activation_key=md5(uniqid(rand(), true));
							  if ($this->checkUser($values['email_subscribe']))
								  {
									  $response['result']=0;
									  $response['detail']="You are already subscribed to PEplanning<br>If you have forgotten your password <a href='https://".$_SERVER['HTTP_HOST']."/auth/forgot-password?email=".$values['email_subscribe']."'>click here</a><br>To reactivate your account go to <a href='https://".$_SERVER['HTTP_HOST']."/auth/reactivate?email=".$values['email_subscribe']."'>this page</a>";
								  }
							  elseif ($this->saveUser($values,$activation_key))
								  {
									  if($this->createEmail($values,$activation_key))
											  {
												  $response['result']=1;
												  $response['detail']="Subscribed";
												  $this->loginSubscribedUser($values['email_subscribe']);
											  }
									  else
										  {
											  $response['result']=0;
											  $response['detail']="Subscription failed. Unable to complete your subscription at this time please try later";
										  }
								  }
							  else 
								  {
									  $response['result']=0;
									  $response['detail']="Unknown Error";
								  }
						  }
				  }
				  else 
				  {
					  //failed the validation, send the reasons back to the browser
					  $messages = $form->getMessages();
					  $response['result']='0';
					  $response['detail']=$this->_helper->json($messages);
				  }
				  }
			 else
                {
                     $response['result']='0';
                     $response['detail']="Invalid Captcha Entry, please re-type the letters in the box";
                }
				  //Send result of the subscription attempt back to the browser
			return $this->_helper->json($response);
			 
	   }
       else {
            
           //Display the form with the boxes left and right and the reason for showing it
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
           if($_GET['reason']) $this->view->reason=$_GET['reason'];
		   $this->view->form = $form;
       }**/
	   $this->redirect('/auth/signup?process=1');
    }
	public function orderAction()
	{
		$form = new Application_Form_OrderForm();
		$mysession = new Zend_Session_Namespace('mysession');
		if ($this->getRequest()->isPost()) 
		{
			//Form is filled in, process the details
		}
		else
		{
			//Form not yet completed
			if($mysession->userlevel!=0)
			{
				//Not a guest user - get details to populate the form
				$users = new Application_Model_DbTable_Users();
				$user_details = $users->getAdminUserDetails($mysession->id)->toArray();
				$form->setvars($user_details);
			}
			$this->view->form = $form;
		}
	}
    public function paymentAction()
    {
       /**$mysession = new Zend_Session_Namespace('mysession'); 
       $payment_form = new Application_Form_PaymentForm();
       if ($this->getRequest()->isPost()) {
           //set up validation for email addresses
            $isEmail=new Zend_Validate_EmailAddress();
           //Don't display anything yet
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            //Get the form data
            $data = $_POST['data'];
            //Explode the array into pairs of item/value
            $dataArray = explode("&", $data);
                foreach ($dataArray as $dataSet) {
                    $nameAndValue = explode("=", $dataSet);
                    $values[$nameAndValue[0]] = urldecode($nameAndValue[1]);
                }
            //Validate the information on the form
            if ($payment_form->isValid($values)) {
            $response['result']=1;
            $enquiry_body="Enquiry Details\n\n";
            foreach($values as $key=>$data)
                {
                $response[$key]='';
                    
                    if(substr($key,-12)!="_payment_msg")
                    {
                        if($key=="email_payment") {
                            $email_val=$data;    
                            if($isEmail->isValid($data)){
                                $response['result']=1;
                            }
                            else {
                                $response['result']=4;
                                $response[$key]="Email address invalid";
                            }
                        }
                        if($key=="email_confirm_payment") {
                            if($isEmail->isValid($data)){
                                $response['result']=1;
                            }
                            else {
                                $response['result']=4;
                                $response[$key]="Email address invalid";
                            }
                        }
                        if(($key=="email_confirm_payment")&&($data!=$email_val)){
                        $response['result']=4;
                        $response[$key]="Email addresses must match";
                        }
                        if($key==$data."_payment"){
                        $response['result']=4;
                        $response[$key]="You must enter ".$data;
                        }
                        
                        
                    }
                 }
                 
            }
            else 
            {
                //failed the validation, send the reasons back to the browser
                $messages = $form->getMessages();
                $response['result']='0';
                $response['detail']=$this->_helper->json($messages);
            }
            if($response['result']==1)
                {
                $subscribe_body="Subscription Details\n\n";
                foreach($values as $key=>$data)
                    {
                    if(substr($key,-12)!="_payment_msg") $subscribe_body.=$key." - ".$data."<br>";
                    }
                $school_check=$this->createSchool($values);
                if($school_check==1)
                { 
                  if($this->sendEmailDetails($subscribe_body,$subscribe_body,'subscribe@peplanning.org.uk','matt@peplanning.org.uk','Subscribe',$sendfileaswell=0))
                        {
                            $mail_body_text=$values['name_payment']."/n/n"
                            ."Thank you for subscribing to PEplanning. "
                            ."We have received your details and a representative from PEplanning will contact you shortly to process your subscription.\n\n"
                            ."\n\n"
                            ."With thanks\n\n"
                            ."Matthew Dykes\n"
                            ."matt@peplanning.org.uk";
                            $this->view->template_type='payment';
                            $this->view->name=$values['name_payment'];
                            $mail_body_html = $this->viewRenderer->render('auth/template.phtml');
                        
                        if($this->sendEmailDetails($mail_body_text,$mail_body_html,'donotreply@peplanning.org.uk',$values['email_payment'],'PEplanning - Purchase Information',$sendfileaswell=1))
                            {
                                // all emails sent ok let them know what happens next
                                $response['result']='1';
                                $response['detail']="Thank you for your subscription application. A representative of PEplanning will be in touch to arrange payment";
                            }
                        else 
                            {
                                // couldn't send confirmation to the enquirer
                                $response['result']='0';
                                $response['detail']="We have been unable to fulfill your request at this time, please check your details and try again later";
                            }
                        }
                  else
                    {
                        $response['result']=0;
                        $response[$key]="Email not sent to admin@PEplanning.org";
                    }
                  }
               else
                  {
                    if($school_check==0)
                    {
                        $response['result']=0;
                        $response[$key]="School not created";
                    }
                    elseif($school_check==2)
                    {
                        $response['result']=0;
                        $response[$key]="School already exists";
                    }
                  }
            }
            return $this->_helper->json($response);
       }
       else 
       {
                    
                $my_id = $mysession->id;
                $my_level = $mysession->userlevel;
                if($my_level==0){
                    $this->view->num_right_boxes = 2;
                    $this->view->num_left_boxes = 1;
                    $this->view->right_box_title = array(1=>'planalesson',2=>'freetrial',3=>'video');
                    $this->view->left_box_title = array(1=>'endorsements',2=>'endorsements',3=>'faqs');
                }
                elseif($my_level==1){
                    $this->view->num_right_boxes = 1;
                    $this->view->num_left_boxes = 1;
                    $this->view->right_box_title = array(1=>'planalesson',2=>'subscribe',3=>'planalesson');
                    $this->view->left_box_title = array(1=>'endorsements',2=>'endorsements',3=>'faqs');
                }
                elseif($my_level==4){
                    $this->view->num_right_boxes = 1;
                    $this->view->num_left_boxes = 1;
                    $this->view->right_box_title = array(1=>'faqs',2=>'subscribe',3=>'planalesson');
                    $this->view->left_box_title = array(1=>'endorsements',2=>'',3=>'faqs');
                }
                else {
                    $this->view->num_right_boxes = 1;
                    $this->view->num_left_boxes = 1;
                    $this->view->right_box_title = array(1=>'staffroom',2=>'planalesson',3=>'planalesson');
                    $this->view->left_box_title = array(1=>'endorsements',2=>'social',3=>'faqs');
                }
                $payment_form->setvars($user_stuff);
                $payment_form->startform();
                return $this->view->form = $payment_form;
         }**/
		 $this->redirect('/auth/schoolsignup');
    }
    public function checkUser($user)
    {
        if($user){
        $register_user = new Application_Model_DbTable_Users();
        return $register_user->alreadyRegistered($user);
        }
        else return 0;
               
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
	public function saveSignedUpUser($values)
    {
        if(($values['name_signedup'])&&($values['email_signedup'])&&($values['password_signedup'])&&($values['role_signedup'])&&($values['school_signedup'])){
        $register_user = new Application_Model_DbTable_Users();
        $add_user=$register_user->createRow();
        $add_user->name=$values['name_signedup'];
        $add_user->username=$values['email_signedup'];
        $add_user->email=$values['email_signedup'];
        $add_user->password=md5($values['password_signedup']);
        $add_user->school=$values['school_signedup'];
        $add_user->what=$values['role_signedup'];
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
	public function createSignedUpEmail($values)
	{
        $subscribe_body="Subscription Details\n\n";
        foreach($values as $key=>$data)
        {
            $subscribe_body.=$key." - ".$data."<br>";
        }
        $password_len=strlen($values['password_signedup']);
		$password_out=$this->String2Stars($values['password_signedup'],0,$password_len-3,'*');
		if($this->sendEmailDetails($subscribe_body,$subscribe_body,'subscribe@peplanning.org.uk','info@peplanning.org.uk','Subscribe',$sendfileaswell=0))
            {
                $mail_body_text="Welcome ".$values['name_signedup']."\n\n"
                        ."You have just subscribed at www.peplanning.org.uk "
                        ."with the following information:\n\n"
                        ."Username: <b>".$values['email_signedup']."</b>\n"
                        ."Password: <b>".$password_out."</b>\n\n"
                        ."Click the link below to login to your new PEplanning account:\n\n"
                        ."<a href='http://".$_SERVER['HTTP_HOST']."/auth/login'>LOGIN NOW</a>\n\n";
                $this->view->template_type='signup';
                $this->view->name=$values['name_signedup'];
                $this->view->password=$password_out;
                $this->view->username=$values['email_signedup'];
                $this->view->activation=$activation_key;
				$this->view->email=$values['email_signedup'];
                $mail_body_html = $this->view->render('auth/newtemplate.phtml');
                return $this->sendEmailDetails($mail_body_text,$mail_body_html,'info@peplanning.org.uk',$values['email_signedup'],'Welcome to PE Planning',$sendfileaswell=0);
             }
    }
    public function activateAction()
    {
        //$this->_helper->layout()->disableLayout();
        $this->view->num_right_boxes = 3;
        $this->view->num_left_boxes = 3;
        $this->view->right_box_title = array(1=>'register',2=>'video',3=>'planalesson');
        $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        $this->_helper->layout()->setLayout('infolayout');
        $_GET['email_address'] = (isset($_GET['email_address']) ? $_GET['email_address'] : 0);
        $_GET['key'] = (isset($_GET['key']) ? $_GET['key'] : 0);
        $mysession = new Zend_Session_Namespace('mysession');
        $my_id = $mysession->id;
        $this->view->email_address = $_GET['email_address'] ;
        $users = new Application_Model_DbTable_Users();
        if($_GET['email_address']){
        if ($activate = $users->activateUser($_GET['email_address'] ,$_GET['key'])) $this->view->activated=1;
        elseif($activated = $users->activatedUser($_GET['email_address'],'email' )) $this->view->activated=1;
        else $this->view->activated=0;
        }
        elseif($my_id>=9000001){
            $this->view->activated=2;
        }
        else {
            $this->view->activated=3;
        }
        if($this->loginActivatedUser($_GET['email_address'])) $this->view->loggedIn=1;
    }
    
	public function newsAction()
	{
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender();
        $feedUrl = "http://www.blogger.com/feeds/658039257594037392/posts/default";
 
		// Lets import the feed
		try {
     		$feed   =   Zend_Feed_Reader::import($feedUrl);
				}   catch (Zend_Feed_Exception $e) {
     				echo 'Exception found: '.$e->getMessage();
			}
		$i=1;
		foreach($feed as $item) {
			if($i==4) break;
			echo "<h3 style='color: #808386'>".$item->getTitle() ."</h3>";
			echo "<p style='color: #808386;text-align: left;'>".substr(strip_tags($item->getContent()),0,196)."....".
			"<a href='/learn/news?item_num=".$i."' style='color: #0181bd;font-size: 12px;'>read more</a></p>";
			$i++;
		}
		echo "<p><a href='/learn/news' style='color: #0181bd;'><i><b>see all news</b></i></a></p>";
	}
	
	    
    public function contactAction()
    {
      include("recaptchalib.php");
      $privatekey = "6LdQmPESAAAAAIYhvd1X3piy5s06tifVD2Ds0ROt";
      $form = new Application_Form_ContactForm();
      if ($this->getRequest()->isPost()) 
        {
        $this->_helper->layout()->disableLayout();
        //$this->_helper->viewRenderer->setNoRender();
        $values = $this->_request->getPost();
        if ($form->isValid($values)) 
            {
                $contact_body="Contact Details\n\n";
                foreach($values as $key=>$data)
                    {
                    $contact_body.=$key." - ".$data."<br>";
                    }
                $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $values["recaptcha_challenge_field"],
                                $values["recaptcha_response_field"]);
                if($resp->is_valid)
                {
                  if($this->sendEmailDetails($contact_body,$contact_body,'contact@peplanning.org.uk','info@peplanning.org.uk','contact',$sendfileaswell=0))
                    { 
                        // sent the contact form to PE planing ok, create a confirmation
                    $this->view->template_type='form_getintouch';
                    $this->view->name=$values['name_contact'];
                    $mail_body_html = $this->viewRenderer->render('auth/template.phtml');
                        $mail_body_text=$values['name_contact']."/n/n"
                        ."Thank you for your interest in PE Planning "
                        ."A representative from PE Planning will be in touch in the next few days to to deal with your request\n\n"
                        ."\n\n"
                        ."With thanks\n\n"
                        ."info@peplanning.org.uk";
                        
                        if($this->sendEmailDetails($mail_body_text,$mail_body_html,'donotreply@peplanning.org.uk',$values['email_contact'],'Thank you for your request',$sendfileaswell=0))
                            {
                                // all emails sent ok let them know what happens next
                                $response['result']='1';
                                $response['detail']="Thank you for your enquiry.";//<br><br>A copy has been sent to ".$values['email_contact'];
                            }
                        else 
                            {
                                // couldn't send confirmation to the enquirer
                                $response['result']='0';
                                $response['detail']="We have been unable to fulfill your request at this time, please check your details and try again later";
                            }
                    }
                  else 
                    {
                        // couldn't send the contact form to PE planning
                        $response['result']='0';
                        $response['detail']="We have been unable to fulfill your request at this time, please check your details and try again later";
                    }
                }
                else
                {
                     $response['result']='0';
                     $response['detail']="Invalid Captcha Entry";
                }
            }
        else 
            {
                // problems with the form let them know the problems
                $messages = $form->getMessages();
                $response['result']='0';
                $response['detail']=$this->_helper->json($messages);
            }
           // done processing let them know what happened
           return $this->_helper->json($response);
        }
      else 
            {
                // if the form hasn't been submitted display the form
                $this->_helper->layout()->disableLayout();
                $this->view->publickey = "6LdQmPESAAAAAGut3CzRGz62cEZ1T4yysnWCftml";
                return $this->view->form = $form;
            }
    }

public function forgotPasswordAction()
    {
        $this->view->num_right_boxes = 3;
        $this->view->num_left_boxes = 3;
        $this->view->right_box_title = array(1=>'register',2=>'video',3=>'planalesson');
        $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        $this->_helper->layout()->setLayout('layout');
        $email = $_GET['email'];
        $new_password = $this->generateRandStr(10);
        $users  = new Application_Model_DbTable_Users(); 
        if($users->updateUser('password',md5($new_password),'email',$email))
        	{
            $this->view->template_type='passwordreset';
            $this->view->name=$email;
            $this->view->user_password=$new_password;
            $admin_body_html = $this->viewRenderer->render('auth/template.phtml');
        	$admin_body="A password reset has been requested for this account at www.peplanning.org.uk\n\n"
                        ."Your new password is $new_password\n\n"
                        ."Please go to http://www.peplanning.org.uk now and set your password\n\n"
                        ."If you did not make any such request please ignore this email\n\n";
			  if($this->sendEmailDetails($admin_body,$admin_body_html,'admin@peplanning.org.uk',$email,'Password Reset Request',$sendfileaswell=0))
			  {
				  $this->view->result=1;
				  $this->view->detail="Thank you for your request.<br><br>You will receive a new password soon";
			  }
			  else
			  {
				  $this->view->result=0;
				  $this->view->detail="Sorry unable to process your request.<br><br>Please go to <a href='/contactus'> this page</a> for further advice";
			  }
			}
        else{
            $this->view->result=0;
            $this->view->detail="Sorry unable to update your details.<br><br>Please go to <a href='/contactus'> this page</a> for further advice";
            }
        return $this->view;
    }
    public function reactivateAction()
    {
        $this->view->num_right_boxes = 3;
        $this->view->num_left_boxes = 3;
        $this->view->right_box_title = array(1=>'register',2=>'video',3=>'planalesson');
        $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        $this->_helper->layout()->setLayout('infolayout');
        $email = $_GET['email_address'];
        $activation_key=md5(uniqid(rand(), true));
        $users  = new Application_Model_DbTable_Users(); 
        if($users->updateUser('activation',$activation_key,'email',$email))
        {
            $mail_body_text="You have just requested a reactivation of your account at www.peplanning.org.uk "
                        ."Click the link below to reactivate your PEplanning account:\n\n"
                        ."<a href='https://".$_SERVER['HTTP_HOST']."/auth/activate?email_address=" . urldecode($email) . "&key=$activation_key'>ACTIVATE ACCOUNT NOW</a>\n\n";
                        $this->view->template_type='reactivate';
                        $this->view->username=$email;
                        $this->view->activation=$activation_key;
                        $mail_body_html = $this->viewRenderer->render('auth/template.phtml');
                        if($this->sendEmailDetails($mail_body_text,$mail_body_html,'info@peplanning.org.uk',$email,'Re-activate Account',$sendfileaswell=0))
                   {
                        $this->view->result=1;
                        $this->view->detail="To re-activate your account please check your email and click the confirmation link";}
                        else {
                            $this->view->result=0;
                            $this->view->detail="Re-activation failed. Unable to send email confirmation";
                        }
        }
        else{
            $this->view->result=0;
            $this->view->detail="Sorry unable to process your request.<br><br>Please go to <a href='http://".$_SERVER['HTTP_HOST']."/contactus'> this page</a> for further advice";
            
        }
        return $this->view;
    }

    public function listusersAction()
    {
       //$this->_helper->layout()->disableLayout();
	   $users  = new Application_Model_DbTable_Users(); 
       $mysession = new Zend_Session_Namespace('mysession');
       $my_id = $mysession->id;
       $this->view->user_list=$users->getUserList()->toArray();
       return $this->view;
    }
    
    public function edituserAction()
    {
       $edit_user_form = new Application_Form_EdituserForm();
       $users  = new Application_Model_DbTable_Users(); 
       $mysession = new Zend_Session_Namespace('mysession');
       $my_id = $mysession->id;
       $user_stuff=$users->getUserDetails($my_id)->toArray();
       if ($this->getRequest()->isPost()) {
            $msg_fields=array('name_msg','school_msg','postcode_msg');
            $def_values=array('name','school','postcode');
            $users  = new Application_Model_DbTable_Users(); 
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $data = $_POST['data'];
            $dataArray = explode("&", $data);
            $response['result']=0;
            $response['detail']='No Change';
            foreach ($dataArray as $dataSet) {
               $nameAndValue = explode("=", $dataSet);
               if(!in_array($nameAndValue[0],$msg_fields)){
                if($nameAndValue[1]){
                    if($users->updateUser($nameAndValue[0],  urldecode($nameAndValue[1]),'id',$my_id)){
                        $response[$nameAndValue[0]]['result']=1;
                        $response[$nameAndValue[0]]['detail']='Details Updated';
                        $response['result']=1;
                    }
                    
                }
                else {
                    
                }
                
               }
               else {
                   
               }
           }
        return $this->_helper->json($response);
          
       }
           else {
        $edit_user_form->setvars($user_stuff);
        $edit_user_form->startform();
        return $this->view->form = $edit_user_form;
       }
    }
    public function passwordAction()
    {
       $form = new Application_Form_PasswordForm();
       $mysession = new Zend_Session_Namespace('mysession');
       $my_id = $mysession->id;
       if ($this->getRequest()->isPost()) {
           $this->_helper->layout()->disableLayout();
           $this->_helper->viewRenderer->setNoRender();
           $data = $_POST['data'];
           $dataArray = explode("&", $data);
           foreach ($dataArray as $dataSet) {
               $nameAndValue = explode("=", $dataSet);
               $values[$nameAndValue[0]] = $nameAndValue[1];
           }
           if ($form->isValid($values)) {
               $users  = new Application_Model_DbTable_Users(); 
               $current_password=md5($values['password_change']);
               $user_info=$users->getPasswordForChange($my_id);
               $stored_password=$user_info->password;
               if($current_password==$stored_password)
               {
                   if($values['new_password_change']==$values['confirm_password_change'])
                   {
                       if($users->updateUser('password',md5($values['new_password_change']),'id',$my_id))
                       {
                           $response['result']=1;
                           $response['detail']='Password changed successfully';
                           $response['more']='';
                       }
                       else
                       {
                            $response['result']=0;
                            $response['detail']='Unable to complete request';
                            $response['more']=''; 
                       }
                   }
                   else
                   {
                   $response['result']=0;
                   $response['detail']='New passwords are not the same';
                   $response['more']=$values['confirm_password_change']; 
                   }
               }
               else 
               {
                   $response['result']=0;
                   $response['detail']='Incorrect pasword entered';
                   $response['more']=$my_id;
               }
           }
           else {
               $response['result']=0;
               $response['detail']='You have not completed all the required fields';
               $response['more']='';
           }
           return $this->_helper->json($response);
       }
       else {
        $this->view->prevResult=($_GET['prev'] ? $_GET['prev'] : '' );
        $change_password_form = new Application_Form_PasswordForm();
        return $this->view->form = $change_password_form;
       }
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
    public function loginActivatedUser($userName)
    {
        $users  = new Application_Model_DbTable_Users();
        $auth = Zend_Auth::getInstance();
        $authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter());
        $is_email = new Zend_Validate_EmailAddress();
        if($is_email->isValid(urldecode($userName))) {
                $authAdapter->setIdentityColumn('email');
                $user_info = $users->getPassword($userName,'email')->toArray();
                }
        else {
                $authAdapter->setIdentityColumn('username');
                $user_info = $users->getPassword($userName,'username')->toArray();
                }
        foreach($user_info as $user){
        $password = $user['password'];}
        $authAdapter->setTableName('users');
        $authAdapter->setIdentity(urldecode($userName));
        $authAdapter->setCredentialColumn('password');
        $authAdapter->setCredential($password);
        try {
            $result['valid'] = $auth->authenticate($authAdapter);
            } 
            catch (Zend_Exception $e) {
                    $result['valid'] = $e->getMessage() . "<br>";
                 }
        if($result['valid']){         
            if($result['valid']->isValid()) $result['data']=$authAdapter->getResultRowObject();
            $mysession = new Zend_Session_Namespace('mysession');
            $guest_id = $mysession->id;
                    $data=$result['data'];
                    $mysession->id = $data->id;
                    $mysession->username = $data->username;
                    $_SESSION['userlevel'] = $mysession->userlevel = $data->userlevel;
                    $mysession->email = $data->email;
                    $mysession->num_logins = $data->num_logins + 1;
                    $mysession->last_login = $data->timestamp;
                    $mysession->subscribed = $data->subscribed;
                    $active = $this->updateUserTables($mysession->id,$guest_id);}
        else {return 0;}
    }
	public function loginSubscribedUser($userName)
    {
        $users  = new Application_Model_DbTable_Users();
        $auth = Zend_Auth::getInstance();
        $authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter());
        $is_email = new Zend_Validate_EmailAddress();
        if($is_email->isValid(urldecode($userName))) {
                $authAdapter->setIdentityColumn('email');
                $user_info = $users->getPassword($userName,'email')->toArray();
                }
        else {
                $authAdapter->setIdentityColumn('username');
                $user_info = $users->getPassword($userName,'username')->toArray();
                }
        foreach($user_info as $user){
        $password = $user['password'];}
        $authAdapter->setTableName('users');
        $authAdapter->setIdentity(urldecode($userName));
        $authAdapter->setCredentialColumn('password');
        $authAdapter->setCredential($password);
        try {
            $result['valid'] = $auth->authenticate($authAdapter);
            } 
            catch (Zend_Exception $e) {
                    $result['valid'] = $e->getMessage() . "<br>";
                 }
        if($result['valid']){         
            if($result['valid']->isValid()) $result['data']=$authAdapter->getResultRowObject();
            $mysession = new Zend_Session_Namespace('mysession');
            $guest_id = $mysession->id;
                    $data=$result['data'];
                    $mysession->id = $data->id;
                    $mysession->username = $data->username;
                    $_SESSION['userlevel'] = $mysession->userlevel = $data->userlevel;
                    $mysession->email = $data->email;
                    $mysession->num_logins = $data->num_logins + 1;
                    $mysession->last_login = $data->timestamp;
                    $mysession->subscribed = $data->subscribed;
                    $active = $this->updateUserTables($mysession->id,$guest_id);}
        else {return 0;}
    }
	public function loginSignedUpUser($userName)
    {
        $users  = new Application_Model_DbTable_Users();
        $auth = Zend_Auth::getInstance();
        $authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter());
        $authAdapter->setIdentityColumn('email');
        $user_info = $users->getPassword($userName,'email')->toArray();
        foreach($user_info as $user){
        $password = $user['password'];}
        $authAdapter->setTableName('users');
        $authAdapter->setIdentity(urldecode($userName));
        $authAdapter->setCredentialColumn('password');
        $authAdapter->setCredential($password);
        try {
            $result['valid'] = $auth->authenticate($authAdapter);
            } 
            catch (Zend_Exception $e) {
                    $result['valid'] = $e->getMessage() . "<br>";
                 }
        if($result['valid']){         
            if($result['valid']->isValid()) $result['data']=$authAdapter->getResultRowObject();
            $mysession = new Zend_Session_Namespace('mysession');
            $guest_id = $mysession->id;
                    $data=$result['data'];
                    $mysession->id = $data->id;
                    $mysession->username = $data->username;
                    $_SESSION['userlevel'] = $mysession->userlevel = $data->userlevel;
                    $mysession->email = $data->email;
                    $mysession->num_logins = $data->num_logins + 1;
                    $mysession->last_login = $data->timestamp;
                    $mysession->subscribed = $data->subscribed;
                    $active = $this->updateUserTables($mysession->id,$guest_id);}
        else {return 0;}
    }
    public function unifyAction()
    {
        try {
            // Autoload simplesamlphp classes.
            if(!file_exists("simplesamlphp/lib/_autoload.php")) {
            throw(new Exception("simpleSAMLphp lib loader file does not exist: ".
            "simplesamlphp/lib/_autoload.php"));
            }
 
            include_once("simplesamlphp/lib/_autoload.php");
            $as = new SimpleSAML_Auth_Simple('rm');
 
            // Take the user to IdP and authenticate.
            $as->requireAuth();
            $valid_saml_session = $as->isAuthenticated();
 
            } catch (Exception $e) {
            // SimpleSAMLphp is not configured correctly.
            throw(new Exception("SSO authentication failed: ". $e->getMessage()));
            return;
            }
 
                if (!$valid_saml_session) {
                // Not valid session. Redirect a user to Identity Provider
                 try {
                $as = new SimpleSAML_Auth_Simple('rm');
                $as->requireAuth();
                } catch (Exception $e) {
                // SimpleSAMLphp is not configured correctly.
                throw(new Exception("SSO authentication failed: ". $e->getMessage()));
                return;
                 }
                }
            // Get the information from RM
            $attributes = $as->getAttributes();
            $name = $attributes['urn:oid:2.16.840.1.113730.3.1.241'][0];
            $username = $attributes['urn:oid:1.3.6.1.4.1.5923.1.1.1.10'][0];
            $school = $attributes['http://schemas.rm.com/identity/claims/organisationCode'][0];
            $email = $attributes['urn:oid:1.3.6.1.4.1.5923.1.1.1.9'][0];
            $password=$this->generateRandID();
            $coded_username = base64_encode($username);
            $users  = new Application_Model_DbTable_Users();
            // Check if the user is on the database, if not create them
            if (!$users->checkUnifyUser($username)) 
            {
              if($_GET['link']!='no')
                {
                  $this->_helper->redirector('usercheck','auth',null,array('userid'=>"$coded_username"));
                }
              else 
                {
                $users->createUnifyUser($username,$name,$school,$email,$password);
                $new_user=1;
                }
            }
            //log them in
            $auth = Zend_Auth::getInstance();
            $authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter());
            $authAdapter->setIdentityColumn('userid');
            $user_info = $users->getUnifyPassword($username);
            $unify_password=$user_info->password;
            $authAdapter->setTableName('users');
            $authAdapter->setIdentity(urldecode($username));
            $authAdapter->setCredentialColumn('password');
            $authAdapter->setCredential($unify_password);
            try {
            $result['valid'] = $auth->authenticate($authAdapter);
            } 
            catch (Zend_Exception $e) {
                    $result['valid'] = $e->getMessage() . "<br>";
                 }
            if($result['valid']){         
            if($result['valid']->isValid()) $result['data']=$authAdapter->getResultRowObject();
            $mysession = new Zend_Session_Namespace('mysession');
            $guest_id = $mysession->id;
                    $data=$result['data'];
                    $mysession->id = $data->id;
                    $mysession->username = $data->username;
                    $mysession->unifyuser = 1;
                    $mysession->display_name = $name;
                    $_SESSION['userlevel'] = $mysession->userlevel = $data->userlevel;
                    $mysession->email = $data->email;
                    $mysession->num_logins = $data->num_logins + 1;
                    $mysession->last_login = $data->timestamp;
                    $mysession->subscribed = $data->subscribed;
                    $active = $this->updateUserTables($mysession->id,$guest_id);
                    $this->view->sso=1;
                    $this->view->num_logins=$mysession->num_logins;
                    if($new_user) return $this->view;
                    else $this->_helper->redirector('index','staffroom');
            }
        else {$this->view->sso=0;
        return $this->view;
        }
        
    }
    public function usercheckAction()
    {
       $form = new Application_Form_UsercheckForm();
       if ($this->getRequest()->isPost()) 
       {
           $this->_helper->layout()->disableLayout();
           $this->_helper->viewRenderer->setNoRender();
           $data = $_POST['data'];
           $dataArray = explode("&", $data);
           foreach ($dataArray as $dataSet) 
           {
               $nameAndValue = explode("=", $dataSet);
               $values[$nameAndValue[0]] = $nameAndValue[1];
           }
           if ($form->isValid($values)) 
           {
               $users  = new Application_Model_DbTable_Users();
               if($users->checkForLink(urldecode($values['userName'])))
               { 
                 $current_password=md5($values['password']);
                 $user_info=$users->getPassword(urldecode($values['userName']),'username')->toArray();
                   foreach($user_info as $user){
                   $stored_password = $user['password'];}
                 if($current_password==$stored_password)
                 {
                  if($users->updateUser('userid',urldecode($values['userid']),'username',urldecode($values['userName'])))
                    {
                        $response['result']=1;
                        $response['detail']='Accounts linked successfully';
                        $response['more']='';
                    }
                    else
                    {
                         $response['result']=0;
                         $response['detail']='Unable to link accounts';
                         $response['more']=urldecode($values['userid']); 
                    }
                 }
                 else 
                 {
                   $response['result']=0;
                   $response['detail']='Incorrect pasword entered';
                   $response['more']=urldecode($values['userid']);
                 }
               }
               else
               {
                  $response['result']=0;
                   $response['detail']='Username not found';
                   $response['more']=urldecode($values['userid']); 
               }
           }
           else 
           {
               $response['result']=0;
               $response['detail']='You have not completed all the required fields';
               $response['more']=urldecode($values['userid']);
           }
           return $this->_helper->json($response);
       }
       else 
       {
        $check_user_form = new Application_Form_UsercheckForm(array('userid' => urldecode(base64_decode($this->_getParam('userid')))));
         if($_GET['reason']) $this->view->reason=$_GET['reason'];
        return $this->view->form = $check_user_form;
       }
    }

    public function checkAuth($values)
    {
        $users  = new Application_Model_DbTable_Users();
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
    public function getUserLevelAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $mysession = new Zend_Session_Namespace('mysession');
        $my_level = $mysession->userlevel;
        echo "hey your level is ".$my_level;    
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
        $send->setFrom($sent_from,"PE Planning");
        $send->addTo($send_to);
        $send->setSubject($subject);
        if ($send->send($transport)) return 1;
        else return 0;
        
    }
	public function weeklyBatchAction()
	{
		$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        include "clean-database.php";
	}
    public function nightlyBatchAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->cleanUpGuestPlans();
    }
	public function dailyBatchAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->getTrialUsers();
    }
	public function getTrialUsers()
    {
        $users = new Application_Model_DbTable_Users;
        $trialists = $users->getTrialUserDetails()->toArray();
		$posttrialists = $users->getPostTrialUserDetails()->toArray();
        $sent_from = "admin@peplanning.org.uk";
        
        foreach($trialists as $trialist)
            {
              $send_mail = 0;
              if(!is_null($trialist['subscribed']))
			  {
                $trial_days = (time() - $trialist['subscribed'])/86400;
                if ($trial_days > 15)
                    {
                        $reset_userlevel = $users->updateUser('userlevel',1,'id',$trialist['id']);
                    }
                elseif (($trial_days >= 1)&&($trial_days <= 2)&&($send_mail==0)) //Is it the first day of their subscription
                    {
						$subject = "Welcome to our team";
						$send_to = $trialist['email'];
						$this->view->template_type='batch_1';
						$this->view->name=$trialist['name'];
						$this->view->email=$trialist['email'];
						$send_mail = 1;
                    }
				elseif (($trial_days >= 4)&&($trial_days <= 5)&&($send_mail==0)) //Is it the first day of their subscription
                    {
						$subject = "How's your PE going so far?";
						$send_to = $trialist['email'];
						$this->view->template_type='batch_4';
						$this->view->name=$trialist['name'];
						$this->view->email=$trialist['email'];
						$send_mail = 1;
                    }
                elseif (($trial_days >= 7)&&($trial_days <= 8)&&($send_mail==0)) //I it the first week of the subscription
                    {
                        $subject = "You are halfway through your FREE trial";
                        $send_to = $trialist['email'];
                        $this->view->template_type='batch_7';
                        $this->view->name=$trialist['name'];
                        $this->view->email=$trialist['email'];
						$this->view->role=$trialist['what'];
                        $send_mail = 1;
                    }
                elseif (($trial_days >= 11)&&($trial_days <= 12)&&($send_mail==0)) //I it the first week of the subscription
                    {
                        $subject = "Just three more days";
                        $send_to = $trialist['email'];
                        $this->view->template_type='batch_11';
                        $this->view->name=$trialist['name'];
                        $this->view->email=$trialist['email'];
						$this->view->role=$trialist['what'];
                        $send_mail = 1;
                    }
                elseif (($trial_days >= 14)&&($trial_days <= 15)&&($send_mail==0)) //Is it the end of the subscription
                    {
                        $subject = "Your free trial ends today";
						$send_to = $trialist['email'];
                        $this->view->template_type='batch_14';
                        $this->view->name=$trialist['name'];
                        $this->view->email=$trialist['email'];
						$this->view->role=$trialist['what'];
                        $send_mail = 1;
                    }
				
                if($send_mail) {    
                $mail_body_html = $this->view->render('auth/newtemplate.phtml');
                $this->sendEmailDetails($admin_body,$mail_body_html,$sent_from,$send_to,$subject,$sendfileaswell=0);
				echo $send_to."\n";
                }
              }
            }
			foreach($posttrialists as $posttrialist)
            {
				$send_mail = 0;
				if(!is_null($posttrialist['subscribed']))
			  		{
               			$trial_days = (time() - $posttrialist['subscribed'])/86400;
						if (($trial_days >= 20)&&($trial_days <= 21)&&($send_mail==0))
                    	{
							$subject = "We're sorry you didn't sign up";
                        	$send_to = $posttrialist['email'];
                        	$this->view->template_type='batch_21';
                        	$this->view->name=$posttrialist['name'];
                        	$this->view->email=$posttrialist['email'];
                        	$send_mail = 1;
                    	}
						if($send_mail) {    
                			$mail_body_html = $this->view->render('auth/newtemplate.phtml');
               				$this->sendEmailDetails($admin_body,$mail_body_html,$sent_from,$send_to,$subject,$sendfileaswell=0);
							echo $send_to."\n";
                			}
					}
			}
	}
    public function cleanUpGuestPlans()
    {
        $units = new Application_Model_DbTable_UnitOfWork();
		$clean_lessons = $units->getGuestUnits()->toArray();
		$lessons = new Application_Model_DbTable_Lesson();
		foreach($clean_lessons as $unit_to_clean){
                    $lesson_where = 'uow_id = '.$unit_to_clean['id'];
                    $lessons->delete($lesson_where);
					echo $unit_to_clean['id']."<br>";
		}
        $clean_up = $units->deleteGuestUnits();
    }
    public function feedbackAction()
    {
       $feedback_form = new Application_Form_FeedbackForm();
       $users  = new Application_Model_DbTable_Users(); 
       $mysession = new Zend_Session_Namespace('mysession');
       $my_id = $mysession->id;
       $user_stuff=$users->getUserDetails($my_id);
       if ($this->getRequest()->isPost()) {
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $data = $_POST['data'];
            $dataArray = explode("&", $data);
            $dataArray = explode("&", $data);
            foreach ($dataArray as $dataSet) {
               $nameAndValue = explode("=", $dataSet);
               $values[$nameAndValue[0]] = urldecode($nameAndValue[1]);
            }
            $feedback_body="Feedback Details\n\n";
            foreach($values as $key=>$data)
                    {
                    $feedback_body.=$key." - ".$data."<br>";
                    }
            if ($this->sendEmailDetails($feedback_body,$feedback_body,'feedback@peplanning.org.uk','info@peplanning.org.uk','Feedback',$sendfileaswell=0))
                    {
                        $response['result']=1;
                        $response['detail']='Thanks';
                        $response['more']='';
                        }
            else 
                {
                    $response['result']=0;
                    $response['detail']="Couldn't send it";
                    $response['more']='';
                    }
            return $this->_helper->json($response);
          
            }
            else {
                    $feedback_form->setvars($user_stuff);
                    $feedback_form->startform();
                    return $this->view->form = $feedback_form;
            }
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
	public function signupcreateSchool($values_0,$values_1,$values_2)
    {
      $values = array_merge($values_0,$values_1,$values_2);
	  $create_school = new Application_Model_DbTable_School();
	  $create_school_users = new Application_Model_DbTable_Users();
	  $school_id=$create_school->signupcreateSchool($values);
      if($school_id!=0) 
	  {
		 for($i=1;$i<=$values['school_signup_num_accounts'];$i++)
		 {
			 $create_values['school_user_name']=$values["school_signup_teacher_name_".$i];
			 $create_values['school_user_email']=$values["school_signup_teacher_email_".$i];
			 $create_values['school_user_password']=$values["school_signup_teacher_password_".$i];
			 $create_values['school_id']=$school_id;
			 $create_values['school_user_password']=$values["school_signup_teacher_password_".$i];
			 $create_values['school_user_school']=$values['school_signup_school_name'];
			 $create_values['school_user_start']=$values['school_signup_school_startdate'];
			 if(!$create_school_users->signupcreateschoolUsers($create_values))
			 {
				 return 0;
			 }
			 
		 }
		 return 1;
	  }
      else return 0;
      
    }
	public function unsubscribeAction()
	{
		$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $users = new Application_Model_DbTable_Users();
		if($users->emailSubscriptionStatus($_GET['email'])==1) header('Location: http://' . $_SERVER['HTTP_HOST'] . '/staffroom?reason=alreadyemailunsubscribed');
		else {
			$stop_email = $users->updateUser('newsletter',1,'email',$_GET['email']);
			if($stop_email) header('Location: http://' . $_SERVER['HTTP_HOST'] . '/staffroom?reason=emailunsubscribed');
			else header('Location: http://' . $_SERVER['HTTP_HOST'] . '/staffroom?reason=emailnotunsubscribed');
		}
	}
	
	public function passwordResetAction()
	{
		$response['result']=1;
		$mysession = new Zend_Session_Namespace('mysession');
		if ($this->getRequest()->isPost()) 
		{
			$this->view->values=$_POST;
           	$this->_helper->layout()->disableLayout();
           	$this->_helper->viewRenderer->setNoRender();
		   	if(($_POST['signup']=='Reset')||($_POST['signup']=='Try Again'))
		   	{
				if(($_POST['signup_email']!='email address')&&($_POST['signup_email_confirm']!='confirm email address'))	
				{
					if($this->checkEmail($_POST['signup_email']))
					{
						  if($_POST['signup_email']==$_POST['signup_email_confirm'])
						  {
							  	$email = $_POST['signup_email'];
							  	$new_password = $this->generateRandStr(10);
							  	$users  = new Application_Model_DbTable_Users(); 
								if($users->alreadyRegistered($email))
								{
									if($users->updateUser('password',md5($new_password),'email',$email))
									{
									  $this->view->template_type='passwordreset';
									  $this->view->name=$email;
									  $this->view->user_password=$new_password;
									  $admin_body_html = $this->view->render('auth/template.phtml');
									  $admin_body="A password reset has been requested for this account at www.peplanning.org.uk\n\n"
												  ."Your new password is $new_password\n\n"
												  ."Please go to http://www.peplanning.org.uk now and set your password\n\n"
												  ."If you did not make any such request please ignore this email\n\n";
										if($this->sendEmailDetails($admin_body,$admin_body_html,'admin@peplanning.org.uk',$email,'Password Reset Request',$sendfileaswell=0))
										{
											$this->view->result=1;
											$this->view->detail="Thank you for your request.<br><br>You will receive a new password soon";
										}
										else
										{
											$this->view->result=0;
											$this->view->detail="Sorry unable to process your request.<br><br>Please go to <a href='/index/index#contact'> this page</a> for further advice";
										}
									}
									else
									{
									  $this->view->result=0;
									  $this->view->detail="Sorry unable to update your details.<br><br>Please go to <a href='/index/index#contact'> this page</a> for further advice";
									}
								}
								else
								{
									$response['result']=13;
							  		$response['detail']='Email address not found please <a href="/index/index#contact">contact us</a>';
								}
						  }
						  else
						  {
							  $response['result']=11;
							  $response['detail']='Email addresses do not match';
						  }
					}
					else
					{
						 $response['result']=12;
					     $response['detail']='Not a valid email address';
					}
				}
				else
				{
					$response['result']=10;
					$response['detail']='You need to fill in the form';
				}
			 if($response['result']==1) header('Location: http://' . $_SERVER['HTTP_HOST'] . '/auth/signup');
			}
			
		}
		$this->view->response=$response;
		$this->_helper->layout()->setLayout('signuplayout');
		$this->_helper->viewRenderer->render();
	}
	
	public function signupAction()
	{	
		$response = array();
		$response['result']='1';
		if($_GET['process']) $process=$_GET['process'];
		$mysession = new Zend_Session_Namespace('mysession');
       	if ($this->getRequest()->isPost()) 
		{
		   $this->view->values=$_POST;
           $this->_helper->layout()->disableLayout();
           $this->_helper->viewRenderer->setNoRender();
		   if(($_POST['signup']=='Login')||($_POST['signup']=='Try Again'))
		   {
			   $process='0';
			   if(($_POST['signup_email']!='')&&($_POST['signup_password']!=''))
			   
			   {
			   
				   if(($this->checkEmail($_POST['signup_email']))||((!$this->checkEmail($_POST['signup_email']))&&($_POST['signup']=='Try Again')))
				   {
					 $result=$this->checkSignon($_POST['signup_email'],$_POST['signup_password']);   
					 if ($result['valid']->isValid()) 
					 { //correct username and password ?
					   $mysession = new Zend_Session_Namespace('mysession');
					   $guest_id = $mysession->id;
					   Zend_Session::namespaceUnset('mysession');
					   $data=$result['data'];
					   $_SESSION['id'] = $mysession->id = $data->id;
					   $mysession->username = $data->username;
					   $_SESSION['userlevel'] = $mysession->userlevel = $data->userlevel;
					   $mysession->email = $data->email;
					   $mysession->num_logins = $data->num_logins + 1;
					   $mysession->last_login = $data->timestamp;
					   $mysession->subscribed = $data->subscribed;
						 if($mysession->userlevel==4) 
						 { //are they fully subscribed
								$num_of_plans = $this->getNumplans($mysession->id);
								if($num_of_plans<10) 
								{ //is the number of plans ok?
									$elapsed=time()-$data->subscribed;
									if(($data->subscribed+1209600>=time())||($mysession->userlevel>=5)) { //some sort of test as to when they subscribed
										$active = $this->updateUserTables($mysession->id,$guest_id);
										if($active){
											$response['result']='1';
											$response['detail']=$mysession->num_logins;
											} else {
												echo $active;
												$response['result']='0';
												$response['detail']="Can't update database. Check <a href='javascript:void(0)' onclick='javascript:shutMeAndTakeMeHere(\"/learn/faqs?a=register_a4\")'>here</a> for what to do";
											}
										} else {
											$response['result']='13';
											$response['detail']=$elapsed;
										}   
										
								} 
								else 
								{
										$mysession->create_limit = 10;
										$response['result']='14';
										$response['detail']='plans';
								}
										
						 } 
						 else 
						 {
								$active = $this->updateUserTables($mysession->id,$guest_id);
										if($active){
											if($mysession->userlevel==1){
													$response['result']='1';
													$response['detail']='registered';
													}
											else {
													$response['result']='1';
													$response['detail']=$mysession->num_logins;
													}
											} else {
												echo $active;
												$response['result']='0';
												$response['detail']="Can't update database. Check <a href='javascript:void(0)' onclick='javascript:shutMeAndTakeMeHere(\"/learn/faqs?a=register_a4\")'>here</a> for what to do";
											}
						  }
						
					 } 
					 else 
					 {
							  $response['result']='11';
							  $response['detail']=$result['data'];
					 }
						//valid form test
				   }
				   else 
				   {
				   $response['result']='12';
				   $response['detail']="email warning"; 
					}
		   		}
				else
				{
					$response['result']='10';
				  	$response['detail']="Please correctly complete all the fields";
				}
			   if($response['result']==1) header('Location: http://' . $_SERVER['HTTP_HOST'] . '/staffroom?reason=signedon');
			   /*else {
						$this->view->response=$response;
						$this->_helper->layout()->setLayout('homelayout');
						$this->_helper->viewRenderer->render();
					}*/
		  }// Check for signon or signup
		  elseif($_POST['signup']=='Sign Up')
		  {
				//The first part of the sign up process
				$process='1';
				if(($this->checkEmail($_POST['signup_email']))&&($_POST['signup_1_password']!='')&&($_POST['signup_name']!=''))
				   {
					   if($this->checkUser($_POST['signup_email']))
					   {
						 //check whether the username already exists 
						 	$response['result']=21;
							$response['detail']="A user with that email already exists";
					   }
					   else
					   {
						    $response['result']=1;
							$mysession->email = $_POST['signup_email'];
							$mysession->password = $_POST['signup_1_password'];
							$mysession->name = $_POST['signup_name'];
					   }
					   
				   }
				else {
				   $response['result']='20';
				   $response['detail']="Please correctly complete all the fields"; 
					}
				
				if($response['result']==1) $confirm='y';
		   }
		   else 
		   {
				$process='1';
				$confirm='y';
				if(($_POST['signup_school']!='')&&($_POST['signup_role']!=0))
				{
				  include_once("recaptchalib.php");
      			  $privatekey = "6LdQmPESAAAAAIYhvd1X3piy5s06tifVD2Ds0ROt";
				  $resp = recaptcha_check_answer ($privatekey,
								  $_SERVER["REMOTE_ADDR"],
								  $_POST["recaptcha_challenge_field"],
								  $_POST["recaptcha_response_field"]);
				  if($resp->is_valid)  
				  {
					  $signedup_values['name_signedup']=$mysession->name;
					  $signedup_values['email_signedup']=$mysession->email;
					  $signedup_values['password_signedup']=$mysession->password;
					  $signedup_values['role_signedup']=$_POST['signup_role'];
					  $signedup_values['school_signedup']=$_POST['signup_school'];
					  if ($this->saveSignedUpUser($signedup_values))
					  {
						  if($this->createSignedUpEmail($signedup_values))
								  {
									  $response['result']=1;
									  $response['detail']="Signed On";
									  $this->loginSignedUpUser($signedup_values['email_signedup']);
								  }
						  else
							  {
								  $response['result']=0;
								  $response['detail']="Subscription failed. Unable to complete your subscription at this time please try later";
							  }
					  }
					  else 
					  {
						  $response['result']=0;
						  $response['detail']="Unknown Error";
					  }
					  
				  }
				  else
				  {
					$response['result']='21';
				    $response['detail']="Re-enter the captcha text"; 
					  
				  }
				}
				else
				{
					$response['result']='20';
				    $response['detail']="Please correctly complete all the fields"; 
				}
				if($response['result']==1) header('Location: http://' . $_SERVER['HTTP_HOST'] . '/staffroom?reason=signedup');
		   }
		}// check that the form has been submitted
		$this->view->process=$process;
		$this->view->confirm=$confirm;
		$this->view->response=$response;
		$this->_helper->layout()->setLayout('signuplayout');
		$this->_helper->viewRenderer->render();
 	}
	
	public function checkEmail($email)
	{
		$is_email = new Zend_Validate_EmailAddress();
        if($is_email->isValid(urldecode($email))) return 1;
		else return 0;
		
    }
	public function checkSignon($username,$password)
    {
        $users  = new Application_Model_DbTable_Users();
        $auth = Zend_Auth::getInstance();
		$authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter());
		$authAdapter->setTableName('users');
		$is_email = new Zend_Validate_EmailAddress();
            if($is_email->isValid(urldecode($username)))	 {
                $authAdapter->setIdentityColumn('email');
                }
            else $authAdapter->setIdentityColumn('username');
		$authAdapter->setIdentity(urldecode($username));
		$authAdapter->setCredentialColumn('password');
		$authAdapter->setCredential(md5($password));
            try {
                $result['valid'] = $auth->authenticate($authAdapter);
                } 
                catch (Zend_Exception $e) {
                        $result['valid'] = $e->getMessage() . "<br>";
                    }
                if($result['valid']->isValid()) $result['data']=$authAdapter->getResultRowObject();
				else $result['data']="Invalid username or password try again";
            
        return $result;
    }
	public function schoolsignupAction()
	{
		$response = array();
		$response['result']='1';
		$mysession = new Zend_Session_Namespace('mysession');
       	if ($this->getRequest()->isPost()) 
		{
		   $this->_helper->layout()->disableLayout();
           $this->_helper->viewRenderer->setNoRender();
		   if(($_POST['school-signup-submit-1']=='Next')||($_POST['school-signup-submit-1']=='Try Again'))
		   {
			 //check which form it is
			 $process='0';
			 $this->view->values_0=$_POST;
			 if((($_POST['school_signup_school_name'])&&($_POST['school_signup_school_name']!="school name"))
			   &&(($_POST['school_signup_school_address_1'])&&($_POST['school_signup_school_address_1']!="school address"))
			   &&(($_POST['school_signup_school_address_2'])&&($_POST['school_signup_school_address_2']!="school address"))
			   &&(($_POST['school_signup_school_postcode'])&&($_POST['school_signup_school_postcode']!="school postcode")))
			 {
				//check that the form is fully filled in
				if($this->checkSchoolName($_POST['school_signup_school_name']))
				{
					//check if the school is already on the system
					$response['result']=1;
					$response['detail']="Ok to Proceed";
					$mysession->school_signup_school_name=$_POST['school_signup_school_name'];
					$mysession->school_signup_school_address_1=$_POST['school_signup_school_address_1'];
					$mysession->school_signup_school_address_2=$_POST['school_signup_school_address_2'];
					$mysession->school_signup_school_postcode=$_POST['school_signup_school_postcode'];
					
				}
				else
				{
					$response['result']='11';
					$response['detail']='School Name already in use';
				}
			 }
			 else 
			 {
				 $response['result']='10';
				 $response['detail']="Please correctly complete all the fields";
			 }
			 if($response['result']==1) $mysession->process = 1;
			 $mysession->values_0=$this->view->values_0;
		   }
		   if(($_POST['school-signup-submit-2']=='Next')||($_POST['school-signup-submit-2']=='Try Again'))
		   {
			 //check which form it is
			 $process='1';
			 $this->view->values_1=$_POST;
			 if((($_POST['school_signup_contact_name'])&&($_POST['school_signup_contact_name']!="contact name"))
			 	&&(($_POST['school_signup_contact_email'])&&($_POST['school_signup_contact_email']!="contact email"))
				&&(($_POST['school_signup_num_accounts'])&&($_POST['school_signup_num_accounts']!="number of accounts"))
				&&(($_POST['school_signup_school_startdate'])&&($_POST['school_signup_school_startdate']!="start date (dd-mm-yy)")))
			{
				//check that the form is fully filled in
				if($this->checkEmail($_POST['school_signup_contact_email']))
				{
					if($this->checkSchoolContactEmail($_POST['school_signup_contact_email']))
					{
						//check if the school is already on the system
						$response['result']=1;
						$response['detail']="Ok to Proceed";
						$mysession->school_signup_contact_name=$_POST['school_signup_contact_name'];
						$mysession->school_signup_contact_email=$_POST['school_signup_contact_email'];
						$mysession->school_signup_num_accounts=$_POST['school_signup_num_accounts'];
						$mysession->school_signup_school_startdate=$_POST['school_signup_school_startdate'];
						$domain_parts = explode('@',$_POST['school_signup_contact_email']);
						$mysession->school_domain=$domain_parts[1];
						$school_parts = explode(' ',$mysession->school_signup_school_name);
							foreach($school_parts as $pass_part){
								$pass_suggest=$pass_suggest.$pass_part;}
						$mysession->password_suggestion = strtolower($pass_suggest);
						$this->view->school_domain = $mysession->school_domain;
						$this->view->password_suggestion = $mysession->password_suggestion;
						$this->view->num_teachers = $mysession->school_signup_num_accounts;
						
					}
					else
					{
						$response['result']='21';
						$response['detail']='School contact email already registered';
					}
				}
				else
				{
					$response['result']='21';
					$response['detail']='Invalid email address';
				}
			 }
			 else 
			 {
				 $response['result']='20';
				 $response['detail']="Please correctly complete all the fields";
			 }
			 if($response['result']==1) $mysession->process = 2;
			 $mysession->values_1=$this->view->values_1;
		   }
		   if(($_POST['school-signup-submit-3']=='Next')||($_POST['school-signup-submit-3']=='Try Again'))
		   {
			 //check which form it is
			 $process='2';
			 $this->view->values_2=$_POST;
			 for($i=1; $i<=$mysession->school_signup_num_accounts; $i++)
			 {
				 if((($_POST["school_signup_teacher_name_".$i])&&($_POST["school_signup_teacher_name_".$i]!="teacher ".$i." name"))
					&&(($_POST["school_signup_teacher_email_".$i])&&($_POST["school_signup_teacher_email_".$i]!="teacher ".$i." email")))
				 {
					//check that the form is fully filled in
					if($this->checkEmail($_POST["school_signup_teacher_email_".$i]))
					{
						if($this->checkTeacherEmail($_POST["school_signup_teacher_email_".$i]))
						{
							//check if the school is already on the system
							$response['result']=1;
							$response['detail']="Ok to Proceed";
							$mysession->school_signup_teacher_name[$i]=$_POST["school_signup_teacher_name_".$i];
							$mysession->school_signup_teacher_email[$i]=$_POST["school_signup_teacher_email_".$i];
						}
						else
						{
						$response['result']=30+$i;
						$response['detail']='Email address already in use';
						break;
						}
					}
					else
					{
						$response['result']=30+$i;
						$response['detail']='Invalid email address';
						break;
					}
				 }
				 else 
				 {
					 $response['result']='30';
					 $response['detail']="Please correctly complete all the fields";
					 $response['content']=$i;
					 $this->view->school_domain = $mysession->school_domain;
					 $this->view->password_suggestion = $mysession->password_suggestion;
					 $this->view->num_teachers = $mysession->school_signup_num_accounts;
				 }
			 }
			 if($response['result']==1) $mysession->process = 3;
			 $mysession->values_2=$this->view->values_2;
		   }
		   if($_POST['school-signup-submit-4']=='Sign up')
		   {
			   if($this->signupcreateSchool($mysession->values_0,$mysession->values_1,$mysession->values_2))
			   {
				   
				   if($this->createSchoolSignedUpEmail($mysession->values_0,$mysession->values_1,$mysession->values_2))
				   {
				   		header('Location: http://' . $_SERVER['HTTP_HOST'] . '/auth/signupsuccess?process=school');
				   }
				   else
				   {
					   $response['result']='50';
				 	   $response['detail']="Problem with confirmation - please contact us";
				   }
			   }
			   else
			   {
				 $response['result']='40';
				 $response['detail']="Problem signing you up please contact us";
			   }
			   
		   }
		   if($_POST['school-signup-cancel']=='Go back')
		   {
			   $mysession->process = $mysession->process - 1;
		   }
		} // check to see if a form has been submitted
		if($mysession->values_0) $this->view->values_0=$mysession->values_0;
		if($mysession->values_1) $this->view->values_1=$mysession->values_1;
		if($mysession->values_2) $this->view->values_2=$mysession->values_2;
		$this->view->school_domain = $mysession->school_domain;
		$this->view->password_suggestion = $mysession->password_suggestion;
		$this->view->num_teachers = $mysession->school_signup_num_accounts;
		$this->view->process=$mysession->process;
		$this->view->response=$response;
		$this->_helper->layout()->setLayout('signuplayout');
		$this->_helper->viewRenderer->render();
		
	}
	public function createSchoolSignedUpEmail($values_0,$values_1,$values_2)
	{
        $values = array_merge($values_0,$values_1,$values_2);
		$subscribe_body="School Subscription Details\n\n";
        foreach($values as $key=>$data)
        {
            $subscribe_body.=$key." - ".$data."<br>";
        }
        if($this->sendEmailDetails($subscribe_body,$subscribe_body,'subscribe@peplanning.org.uk','info@peplanning.org.uk','School Subscription',$sendfileaswell=0))
            {
                $mail_body_text="You have now subscribed to PE Planning for one whole year, One year of awsome, structured, varied and, most importantly, fun PE lessons for your pupils.\n\n"
				."We have received your details and we will shortly approve the school personnel to start using the planner. Their log in details will be sent out to the emails you registered them with\n\n"
				."In the next 48 hours we will invoice the school and that's it. All that's left to do is to start planning\n\n"
				."Welcome to the community!";
                $this->view->template_type='schoolsignup-ack';
                $mail_body_html = $this->view->render('auth/newtemplate.phtml');
                return $this->sendEmailDetails($mail_body_text,$mail_body_html,'info@peplanning.org.uk',$values['school_signup_contact_email'],'Welcome to PE Planning',$sendfileaswell=0);
             }
			 
    }

	public function signupsuccessAction()
	{
		$mysession = new Zend_Session_Namespace('mysession');
		if($_GET['process']=='school')
		{
			$this->view->process=$_GET['process'];
			$values = array_merge($mysession->values_0,$mysession->values_1,$mysession->values_2);
			$this->view->session_values=$values;
			$this->_helper->layout()->setLayout('signuplayout');
			$this->_helper->viewRenderer->render();
		}
	}
	public function checkSchoolName($school_name)
	{
		$school  = new Application_Model_DbTable_School(); 
       	if($school->checkSchool($school_name)) return 0;
		else return 1;
	}
	public function checkSchoolContactEmail($school_contact)
	{
		$users = new Application_Model_DbTable_Users();
		if($users->alreadyRegistered($school_contact)) return 0;
		else return 1;
	}
	public function checkTeacherEmail($teacher_email)
	{
		$users = new Application_Model_DbTable_Users();
		if($users->alreadyRegistered($teacher_email)) return 0;
		else return 1;
	}
	public function startagainAction()
	{
		$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		if($_GET['process']=='schoolsignup')
		{
			Zend_Session::namespaceUnset('mysession');
			header('Location: http://' . $_SERVER['HTTP_HOST'] . '/auth/schoolsignup');
		}
	}
	public function sitePrefAction()
	{
		$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
		if(!$_COOKIE['site-pref']) setcookie('site-pref',$_GET['site'],time() + (86400),'/');
		$site_action='/index/'.$_COOKIE['site-pref'].'index';
		$this->_redirect($site_action);
	}
	public function signupinfoAction()
	{
		$this->_helper->layout()->setLayout('signuplayout');
		$this->_helper->viewRenderer->render();
	}
	public function changecredentialsAction()
	{
		$response = array();
		$response['result']='1';
		if($_GET['process']) $process=$_GET['process'];
		$mysession = new Zend_Session_Namespace('mysession');
		if ($this->getRequest()->isPost()) 
		{
		   $users  = new Application_Model_DbTable_Users(); 
		   $user_info = $users->getEmail($_POST['signup_name']);
		   $email_address = $user_info->email;
		   $this->view->values=$_POST;
           $this->_helper->layout()->disableLayout();
           $this->_helper->viewRenderer->setNoRender();
		   if($_POST['changing']=='password')
		   {
			   $process=0;
			   if(($_POST['signup_name']!='')&&($_POST['signup_0_password']!='')&&($_POST['signup_1_password']!='')&&($_POST['signup_2_password']!=''))
			   {
				   if($_POST['signup_1_password']==$_POST['signup_2_password'])
				   {
						$result=$this->checkSignon($_POST['signup_name'],$_POST['signup_0_password']);   
						if ($result['valid']->isValid()) 
						{ //correct username and password ?
							//Update the password
						   	if($users->updateUser('password',md5($_POST['signup_1_password']),'username',$_POST['signup_name']))
							{
								$mail_body_text="You have just requested a ".$_POST['changing']." change for ".$email_address." at PE Planning.\n\n"
												."This change will take effect immediately so remember to use your new credentials when signing in.\n\n"
												."IIf you did not request this change then please contact us at info@peplanning.org.uk\n\n";
                				$this->view->template_type='credentials-change';
                				$mail_body_html = $this->view->render('auth/newtemplate.phtml');
                				if($this->sendEmailDetails($mail_body_text,$mail_body_html,'info@peplanning.org.uk',$email_address,'Account details change for PE Planning',$sendfileaswell=0))
								{
									$mysession->change = $_POST['changing'];
									$mysession->email_address = $email_address;
									header('Location: http://' . $_SERVER['HTTP_HOST'] . '/auth/credentialchangesuccess');
								}
							}
							else
							{
								$response['result']='13';
								$response['detail']='Unable to change the Password, please try again';
							}
						} 
						else 
						{
							$response['result']='11';
							$response['detail']=$result['data'];
						 }
				   }
				   else
				   {
					   	$response['result']='12';
						$response['detail']="New Passwords must match";
				   }
				//valid form test
				}
				else
				{
					$response['result']='10';
				  	$response['detail']="Please correctly complete all the fields";
				}
		  }// Check for signon or signup
		  elseif($_POST['changing']=='username')
		  {
			$process=1;
			if(($_POST['signup_name']!='')&&($_POST['signup_3_password']!='')&&($_POST['signup_email']!=''))
			   {
				   if($this->checkEmail($_POST['signup_email']))
				   {
						$result=$this->checkSignon($_POST['signup_name'],$_POST['signup_3_password']);   
						if ($result['valid']->isValid()) 
						{ //correct username and password ?
							//Update the password
						   	$users  = new Application_Model_DbTable_Users(); 
			   				if($users->updateUser('username',$_POST['signup_email'],'username',$_POST['signup_name']))
							{
								$mail_body_text="You have just requested a ".$_POST['changing']." change for ".$email_address." at PE Planning.\n\n"
												."This change will take effect immediately so remember to use your new credentials when signing in.\n\n"
												."IIf you did not request this change then please contact us at matt@peplanning.org.uk\n\n";
                				$this->view->template_type='credentials-change';
                				$mail_body_html = $this->view->render('auth/newtemplate.phtml');
                				if($this->sendEmailDetails($mail_body_text,$mail_body_html,'matt@peplanning.org.uk',$email_address,'Account details change for PE Planning',$sendfileaswell=0))
								{
									$mysession->change = $_POST['changing'];
									$mysession->email_address = $email_address;
									header('Location: http://' . $_SERVER['HTTP_HOST'] . '/auth/credentialchangesuccess');
								}
							}
							else
							{
								$response['result']='23';
								$response['detail']='Unable to change the Username, please try again';
							}
						} 
						else 
						{
							$response['result']='21';
							$response['detail']=$result['data'];
						 }
				   }
				   else
				   {
					   	$response['result']='22';
						$response['detail']="Not a valid email address";
				   }
				//valid form test
				}
				else
				{
					$response['result']='20';
				  	$response['detail']="Please correctly complete all the fields";
				}	
			}
			 //success ful change go to an information screen and email confirmation
			 
		}// check that the form has been submitted
		$this->view->process=$process;
		$this->view->response=$response;
		$this->_helper->layout()->setLayout('signuplayout');
		$this->_helper->viewRenderer->render();
	}
	public function credentialchangesuccessAction()
	{
		$mysession = new Zend_Session_Namespace('mysession');
		$this->view->email_address=$mysession->email_address;
		$this->view->change=$mysession->change;
		$this->_helper->layout()->setLayout('signuplayout');
		$this->_helper->viewRenderer->render();
	}
}

