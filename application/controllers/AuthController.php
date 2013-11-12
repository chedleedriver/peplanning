<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        $this->_helper->layout()->setLayout('authlayout');
            
    }

    public function indexAction()
    {
        // action body
    }
    
    
    public function loginAction()
    {
       $form = new Application_Form_LoginForm();
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
                 $mysession->id = $data->id;
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
       }
    }
    public function logoutAction()
    {
       $mysession = new Zend_Session_Namespace('mysession');
       $id=$mysession->id;
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

    public function subscribeAction()
    {
       $mysession = new Zend_Session_Namespace('mysession'); 
       $form = new Application_Form_SubscribeForm();
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
                        }if(($key=="email_confirm_subscribe")&&($data!=$email_val)){
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
       }
    }
    public function paymentAction()
    {
       $mysession = new Zend_Session_Namespace('mysession'); 
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
                            $mail_body_html = $this->view->render('auth/template.phtml');
                        
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
            return $this->_helper->json($response);
       }
       else {
                    
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
           }
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
        if($values){
        $register_user = new Application_Model_DbTable_Users();
        $add_user=$register_user->createRow();
        $add_user->name=$values['name_subscribe'];
        $add_user->username=$values['email_subscribe'];
        $add_user->email=$values['email_subscribe'];
        $add_user->password=md5($values['password_subscribe']);
        $add_user->activation=$activation_key;
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
        if($this->sendEmailDetails($subscribe_body,$subscribe_body,'subscribe@peplanning.org.uk','matt@peplanning.org.uk','Subscribe',$sendfileaswell=0))
            {
                $mail_body_text="Welcome ".$values['name_subscribe']."\n\n"
                        ."You have just subscribed at www.peplanning.org.uk "
                        ."with the following information:\n\n"
                        ."Username: <b>".$values['email_subscribe']."</b>\n"
                        ."Password: <b>".$values['password_subscribe']."</b>\n\n"
                        ."Click the link below to activate your PEplanning account:\n\n"
                        ."<a href='http://".$_SERVER['HTTP_HOST']."/auth/activate?email_address=" . urldecode($values['email_subscribe']) . "&key=$activation_key'>ACTIVATE ACCOUNT NOW</a>\n\n";
                $this->view->template_type='register';
                $this->view->name=$values['name_subscribe'];
                $this->view->password=$values['password_subscribe'];
                $this->view->username=$values['email_subscribe'];
                $this->view->activation=$activation_key;
                $mail_body_html = $this->view->render('auth/template.phtml');
                return $this->sendEmailDetails($mail_body_text,$mail_body_html,'matt@peplanning.org.uk',$values['email_subscribe'],'Welcome to PE Planning',$sendfileaswell=0);
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
    
    
    public function contactAction()
    {
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
                if($this->sendEmailDetails($contact_body,$contact_body,'contact@peplanning.org.uk','matt@peplanning.org.uk','contact',$sendfileaswell=0))
                    { 
                        // sent the contact form to PE planing ok, create a confirmation
                    $this->view->template_type='form_getintouch';
                    $this->view->name=$values['name_contact'];
                    $mail_body_html = $this->view->render('auth/template.phtml');
                        $mail_body_text=$values['name_contact']."/n/n"
                        ."Thank you for your interest in PE Planning "
                        ."A representative from PE Planning will be in touch in the next few days to to deal with your request\n\n"
                        ."\n\n"
                        ."With thanks\n\n"
                        ."Matthew Dykes\n"
                        ."matt@peplanning.org.uk";
                        
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
                return $this->view->form = $form;
            }
    }
    public function forgotPasswordAction()
    {
        $this->view->num_right_boxes = 3;
        $this->view->num_left_boxes = 3;
        $this->view->right_box_title = array(1=>'register',2=>'video',3=>'planalesson');
        $this->view->left_box_title = array(1=>'peschool',2=>'faqs',3=>'social');
        $this->_helper->layout()->setLayout('infolayout');
        $email = $_GET['email'];
        $new_password = $this->generateRandStr(10);
        $users  = new Application_Model_DbTable_Users(); 
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
            $this->view->detail="Sorry unable to process your request.<br><br>Please go to <a href='/contactus'> this page</a> for further advice";
        }
        }
        else{
            $this->view->result=0;
            $this->view->detail="Sorry unable to process your request.<br><br>Please go to <a href='/contactus'> this page</a> for further advice";
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
                        $mail_body_html = $this->view->render('auth/template.phtml');
                        if($this->sendEmailDetails($mail_body_text,$mail_body_html,'matt@peplanning.org.uk',$email,'Re-activate Account',$sendfileaswell=0))
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
    public function unifyAction()
    {
        try {
            // Autoload simplesamlphp classes.
            if(!file_exists("/var/www/html/peplanning/library/simplesamlphp/lib/_autoload.php")) {
            throw(new Exception("simpleSAMLphp lib loader file does not exist: ".
            "/var/www/html/peplanning/library/simplesamlphp/lib/_autoload.php"));
            }
 
            include_once("/var/www/html/peplanning/library/simplesamlphp/lib/_autoload.php");
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
            $users  = new Application_Model_DbTable_Users();
            // Check if the user is on the database, if not create them
            if (!$users->checkUnifyUser($username)) {
              if($_GET['link]'!='no') $this->usercheck();
              else {
                $users->createUnifyUser($username,$name,$school,$email,$password);
                $new_user=1;
              }
            }
            //log them in
            $auth = Zend_Auth::getInstance();
            $authAdapter = new Zend_Auth_Adapter_DbTable($users->getAdapter());
            $authAdapter->setIdentityColumn('username');
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
               if($this->check_user($values['username']))
               { 
                 $current_password=md5($values['password']);
                 $user_info=$users->getPassword($values['username'],'username');
                 $stored_password=$user_info->password;
                 if($current_password==$stored_password)
                 {
                  if($users->updateUser('userid',$values['username'],'username',$values['username']))
                    {
                        $response['result']=1;
                        $response['detail']='Accounts linked successfully';
                        $response['more']='';
                    }
                    else
                    {
                         $response['result']=0;
                         $response['detail']='Unable to link accounts';
                         $response['more']=''; 
                    }
                 }
                 else 
                 {
                   $response['result']=0;
                   $response['detail']='Incorrect pasword entered';
                   $response['more']=$my_id;
                 }
               }
               else
               {
                  $response['result']=0;
                   $response['detail']='Username not found';
                   $response['more']=$values['username']; 
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
        $check_user_form = new Application_Form_UsercheckForm();
        return $this->view->form = $check_user_form;
       }
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
        $send = new Zend_Mail();
        if($sendfileaswell){
            $fileContents = file_get_contents('/var/www/html/peplanning/public/resource-downloads/Subscription Form.doc');
            $file = $send->createAttachment($fileContents);
            $file->filename = "Subscription Form.doc";}
        $send->setBodyText($mail_body_text);
        $send->setBodyHtml($mail_body_html);
        $send->setFrom($sent_from);
        $send->addTo($send_to);
        $send->setSubject($subject);
        if ($send->send()) return 1;
        else return 0;
        
    }
    public function batchAction()
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $this->getTrialUsers();
        $this->cleanUpGuestPlans();
        //if ($send->send()) echo 1;
        //else echo 0;
        
    }
    public function getTrialUsers()
    {
        $users = new Application_Model_DbTable_Users;
        $trialists = $users->getTrialUserDetails()->toArray();
        $sent_from = "admin@peplanning.org.uk";
        
        foreach($trialists as $trialist)
            {
                $send_mail = 0;
                if(!is_null($trialist['subscribed'])){
                $trial_days = (time() - $trialist['subscribed'])/86400;
                if ($trial_days > 30)
                    {
                        $reset_userlevel = $users->updateUser('userlevel',1,'id',$trialist['id']);
                    }
                elseif (($trialist['num_logins']<=1)&&($send_mail==0)) //Have they logged in yet?
                    {
                        if($this->getNumPlans($trialist['id'])==0) //Have they created any plans yet?
                            {
                                if ($trial_days <= 7) // is it the first week of their subscription?
                                    {
                                        $subject = "PEplanning - is everything ok?";
                                        $send_to = $trialist['email'];
                                        $this->view->template_type='subscription_nologin';
                                        $this->view->name=$trialist['name'];
                                        $this->view->email=$trialist['email'];
                                        $send_mail = 1;
                                    }
                            }
                    }
                elseif (($trial_days >= 1)&&($trial_days <= 2)&&($send_mail==0)) //Is it the first day of their subscription
                    {
                        if($this->getNumPlans($trialist['id'])==0) //Have they done any planning?
                            {
                                $subject = "PEplanning - is everything ok?";
                                $send_to = $trialist['email'];
                                $this->view->template_type='subscription_noplan';
                                $this->view->name=$trialist['name'];
                                $this->view->email=$trialist['email'];
                                $send_mail = 1;
                            }
                    }
                elseif (($trial_days >= 7)&&($trial_days <= 8)&&($send_mail==0)) //I it the first week of the subscription
                    {
                        $subject = "PEplanning - how are you finding the service?";
                        $send_to = $trialist['email'];
                        $this->view->template_type='subscription_7';
                        $this->view->name=$trialist['name'];
                        $this->view->email=$trialist['email'];
                        $send_mail = 1;
                    }
                elseif (($trial_days >= 15)&&($trial_days <= 16)&&($send_mail==0)) //Is it halfway through the subscription
                    {
                        $subject = "Are you getting the most out of PEplanning?";
                        $send_to = $trialist['email'];
                        $this->view->template_type='subscription_15';
                        $this->view->name=$trialist['name'];
                        $this->view->email=$trialist['email'];
                        $send_mail = 1;
                    }
                elseif (($trial_days >= 29)&&($trial_days <= 30)&&($send_mail==0)) // Is it the last day of the subscription
                    {
                        $subject = "PEplanning - your free subscription is coming to an end...";
                        $send_to = $trialist['email'];
                        $this->view->template_type='subscription_29';
                        $this->view->name=$trialist['name'];
                        $this->view->email=$trialist['email'];
                        $send_mail = 1;
                    }
                if($send_mail) {    
                $mail_body_html = $this->view->render('auth/template.phtml');
                $this->sendEmailDetails($admin_body,$mail_body_html,$sent_from,$send_to,$subject,$sendfileaswell=0);
                }
            }
            }
    }
    public function cleanUpGuestPlans()
    {
        $units = new Application_Model_DbTable_UnitOfWork();
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
            if ($this->sendEmailDetails($feedback_body,$feedback_body,'feedback@peplanning.org.uk','matt@peplanning.org.uk','Feedback',$sendfileaswell=0))
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
    
}



