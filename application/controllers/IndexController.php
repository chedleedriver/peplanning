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
			$this->_helper->layout()->setLayout('homelayout');
            
    }

    public function indexAction()
    {
//		if(($_COOKIE['site-pref']=='old')||($_COOKIE['site-pref']=='')) $site_action='/index/oldindex';
//		if($_COOKIE['site-pref']=='new') $site_action='/index/newindex';; 
//		$this->_redirect($site_action);
    }
	public function newindexAction()
	{
		$this->_helper->layout()->setLayout('homelayout');
		$this->view->render();
	}
	public function oldindexAction()
	{
		$this->_helper->layout()->setLayout('layout');
		$this->view->render();
	}
    public function sendMessageAction()
    {
		include("recaptchalib.php");
		$privatekey = "6LdQmPESAAAAAIYhvd1X3piy5s06tifVD2Ds0ROt";
      //$this->_helper->layout()->disableLayout();
      //$this->_helper->viewRenderer->setNoRender();
      if ($this->getRequest()->isPost()) 
        {
        $values = $this->_request->getPost();
        $contact_body="Contact Details\n\n";
        $contact_body.="Name - ".$values['contact-name']."<br>";
		$contact_body.="Name - ".$values['contact-email']."<br>";
		$contact_body.="Name - ".$values['contact-message']."<br>";
                $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $values["recaptcha_challenge_field"],
                                $values["recaptcha_response_field"]);
                if($resp->is_valid)
                {
                  if($this->sendEmailDetails($contact_body,$contact_body,'contact@peplanning.org.uk','info@peplanning.org.uk','contact'))
                    { 
                        // sent the contact form to PE planing ok, create a confirmation
                    $this->view->template_type='form_sendmessage';
                    $this->view->name=$values['contact-name'];
                    $mail_body_html = $this->view->render('auth/template.phtml');
                        $mail_body_text=$values['contact-name']."/n/n"
                        ."Thank you for your interest in PE Planning "
                        ."A representative from PE Planning will be in touch in the next few days to to deal with your request\n\n"
                        ."\n\n"
                        ."With thanks\n\n"
                        ."info@peplanning.org.uk";
                        
                        if($this->sendEmailDetails($mail_body_text,$mail_body_html,'donotreply@peplanning.org.uk',$values['contact-email'],'Thank you for your request'))
                            {
                                // all emails sent ok let them know what happens next
                                $response['result']='1';
                                $response['detail']="<div class='response response-success'><h1>Thank you for your enquiry.</h1></div>";//<br><br>A copy has been sent to ".$values['email_contact'];
                            }
                        else 
                            {
                                // couldn't send confirmation to the enquirer
                                $response['result']='0';
                                $response['detail']="<div class='response response-failure'><h1>We have been unable to fulfill your request at this time, please check your details and try again later</h1></div>";
                            }
                    }
                  else 
                    {
                        // couldn't send the contact form to PE planning
                        $response['result']='0';
                        $response['detail']="<div class='response response-failure'><h1>We have been unable to fulfill your request at this time, please check your details and try again later</h1></div>";
                    }
                }
                else
                {
                     $response['result']='0';
                     $response['detail']="<div class='response response-failure'><h1>You entered an incorrect value for Captcha box</h1></div>";
                }
		
           return $this->view->response = $response['detail'];
        }
      else 
            {
               //echo $this->view; // if the form hasn't been submitted display the form
               
            }
			$this->_helper->layout()->setLayout('homelayout');
			$this->view->render(); 
    }
	public function sendEmailDetails($mail_body_text,$mail_body_html,$sent_from,$send_to,$subject)
    {
        $transport = new Zend_Mail_Transport_Smtp('localhost');
		//Zend_Mail::setDefaultTransport($transport);
        $send = new Zend_Mail();
        $send->setBodyText($mail_body_text);
        $send->setBodyHtml($mail_body_html);
        $send->setFrom($sent_from);
        $send->addTo($send_to);
        $send->setSubject($subject);
        if ($send->send($transport)) return 1;
        else return 0;
        
    }

}

