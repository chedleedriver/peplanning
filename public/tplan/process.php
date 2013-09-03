<?

include("/var/www/html/public/tplan/code/session.php");

class Process
{
   /* Class constructor */
   function Process(){
      global $session;
      /* User submitted login form */
      if(isset($_POST['sublogin'])){
         $this->procLogin();
      }
      /* User submitted registration form */
      else if(isset($_POST['subjoin'])){
         $this->procRegister();
      }
      /* User submitted forgot password form */
      else if(isset($_POST['subforgot'])){
         $this->procForgotPass();
      }
      /* User submitted edit account form */
      else if(isset($_POST['subedit'])){
         $this->procEditAccount();
      }
      else if(isset($_POST['subotheredit'])){
         $this->procEditOtherAccount();
      }
      else if(isset($_POST['subusercreate'])){
         $this->procCreateUser();
      }
      else if(isset($_POST['subschoolcreate'])){
         $this->procCreateSchool();
      }
      else if(isset($_POST['subpassreset'])){
          $this->procPasswordReset();
      }
      else if(isset($_POST['subscribe'])){
          $this->procSubscribe();
      }
      else if(isset($_POST['subscribe_teacher'])){
          $this->procSubscribeTeacher();
      }
     else if(isset($_POST['subscribe_coach'])){
          $this->procSubscribeCoach();
      }
     else if(isset($_GET['reactivate'])){
          $this->procReactivate($_GET['reactivate']);
      }
     /**
       * The only other reason user should be directed here
       * is if he wants to logout, which means user is
       * logged in currently.
       */
      else if($session->logged_in){
         $this->procLogout();
      }
      /**
       * Should not get here, which means user is viewing this page
       * by mistake and therefore is redirected.
       */
       else{
          header("Location: index.php");
          //echo('user is here by mistake');
          //print_r($_POST);
       }
   }

   /**
    * procLogin - Processes the user submitted login form, if errors
    * are found, the user is redirected to correct the information,
    * if not, the user is effectively logged in to the system.
    */
   function procLogin(){
      global $session, $form;
      /* Login attempt */
      $retval = $session->login($_POST['username'], $_POST['password'], isset($_POST['remember']));
      /* Login successful */
      if($retval==0){
        header("Location: http://".$_SERVER['HTTP_HOST']."/tplan/createplan.php");
      }
      /* Login failed */
      else{
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         if ($_SESSION['error_array']['user']) $location="https://".$_SERVER['HTTP_HOST']."/tplan/login.php?error=".base64_encode($_SESSION['error_array']['user']);
         if ($_SESSION['error_array']['pass']) $location="https://".$_SERVER['HTTP_HOST']."/tplan/login.php?error=".base64_encode($_SESSION['error_array']['pass']);
	header("Location: ".$location);
         // print_r($_SESSION['error_array']);
                 
      }
   }
   
   /**
    * procLogout - Simply attempts to log the user out of the system
    * given that there is no logout form to process.
    */
   function procLogout(){
      global $session;
      $retval = $session->logout();
      header("Location: http://".$_SERVER['HTTP_HOST']."/tplan/index.php");
      /*echo "<form id=\"login_form\" style=\"display:none;\" method=\"post\" action=''>
                    <table width=\"450\">
                        <tr>
                            <td >
                                <input type=\"text\" name=\"userlog\" id=\"userlog\" size=\"12\" value=\"username\" onfocus=\"this.value='';this.style.color='#829f5e'\" style=\"font-family:arial;font-size:12px;color:#b7cc99\"/>
                            </td>
                            <td >
                                <input type=\"text\" name=\"passlog\" id=\"passlog\" size=\"12\" value=\"password\"  onfocus=\"this.value='';this.type='password';this.style.color='#829f5e'\" style=\"font-family:arial;font-size:12px;color:#b7cc99\" />
                            </td>
                            <td>
                                <a href=\"#\" style=\"font-family:arial;font-size:12px\" class=\"buttonlog\">sign in&nbsp;|</a><a href=\"#\" onclick=\"javascript:register()\" style=\"font-family:arial;font-size:12px\">&nbsp;register&nbsp;|</a><a href=\"#\" style=\"font-family:arial;font-size:12px\" onclick=\"javascript: forgotPassword()\">&nbsp;forgot password</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label class=\"errorlog\" for=\"userlog\" id=\"userlog_error\">This field is required.</label>
                                <label class=\"errorlog\" for=\"userlog\" id=\"userlog_error2\">username incorrect or</label>
                            </td>
                            <td colspan=\"2\">
                                <label class=\"errorlog\" for=\"passlog\" id=\"passlog_error\">This field is required.</label>
                                <label class=\"errorlog\" for=\"passlog\" id=\"passlog_error2\">password incorrect.</label>
                            </td>
                        </tr>
                   </table>
               </form>";*/
   }
   
   /**
    * procRegister - Processes the user submitted registration form,
    * if errors are found, the user is redirected to correct the
    * information, if not, the user is effectively registered with
    * the system and an email is (optionally) sent to the newly
    * created user.
    */
   function procRegister(){
      global $session, $form;
		 $_SESSION['current_dialog'] = '#registerDialog';
      /* Convert username to all lowercase (by option) */
      if(ALL_LOWERCASE){
         $_POST['user'] = strtolower($_POST['user']);
      }
      /* Generate activation code*/
       $activation = md5(uniqid(rand(), true));
      /* Registration attempt */
      $retval = $session->register($_POST['name'],$_POST['user'], $_POST['password'], $_POST['email'], $_POST['school'], $_POST['postcode'], $_POST['send_email_newsletter'], $_POST['how-button'], $_POST['what-button'], $activation);
      /* Registration Successful */
      if($retval == 0){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = true;
         unset($_SESSION['form_errors']);
         unset($_SESSION['form_values']);
         $location="Location: http://".$_SERVER['SERVER_NAME']."/tplan/register-confirm.php";
         header($location);
         
        echo($retval);
      }
      
      /* Registration attempt failed */
      else if($retval > 0){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = false;
        
        $_SESSION['form_errors']=$form->errors;
        $_SESSION['form_values']=$_POST;
        header("Location:register.php");
        }
   }
   function procReactivate($username){
       global $session, $form;
       //$username=base64_decode($username);
       $retval = $session->reactivate($username);
       if ($retval==0){
         unset($_SESSION['form_errors']);
         unset($_SESSION['form_values']);
         header("Location:reactivate-confirm.php");
       }
      else if($retval > 0){
        $_SESSION['form_errors']=$form->errors;
        //$_SESSION['form_values']=$_POST;
        if ($_SESSION['form_errors']['user']) $location="login.php?error=".base64_encode($_SESSION['form_errors']['user']);
        header("Location:".$location);
        }
   }
   function procSubscribe(){
      global $session, $form;/*
      *  Convert username to all lowercase (by option) */
      if(ALL_LOWERCASE){
         $_POST['user'] = strtolower($_POST['user']);
      }
      /* Generate activation code*/
       $licence = $session->generateLicenceKey();
      /* Registration attempt */
      $retval = $session->subscribe($_POST['school'], $_POST['address-1'], $_POST['address-2'], $_POST['address-3'], $_POST['email'], $_POST['telephone'], $_POST['postcode'], $_POST['name'], $_POST['total_cost'], $_POST['class-num'], $_POST['sub-from'], $_POST['sub-to'], $licence);
      /* Registration Successful */
      if($retval == 0){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = true;
         unset($_SESSION['form_errors']);
         unset($_SESSION['form_values']);
         header("Location:subscribe-confirm.php");

        echo($retval);
      }

      /* Registration attempt failed */
      else if($retval > 0){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = false;

        $_SESSION['form_errors']=$form->errors;
        $_SESSION['form_values']=$_POST;
        header("Location:subscribe_school.php");
        }
   }
   function procCreateSchool(){
      global $session, $form;/*

       * I have reversed the success return to accomodate a school id for next part of the process
       *   *  Convert username to all lowercase (by option) */
      if(ALL_LOWERCASE){
         $_POST['user'] = strtolower($_POST['user']);
      }
      /* Generate activation code*/
       $licence = $session->generateLicenceKey();
      /* Registration attempt */
      $retval = $session->createSchool($_POST['school'], $_POST['address1'], $_POST['address2'], $_POST['address3'], $_POST['email'], $_POST['telephone'], $_POST['postcode'], $_POST['contact'], $_POST['total_cost'], $_POST['classnum'], $_POST['sub-from'], $_POST['sub-to'], $licence);
      /* Registration Successful */
      if($retval != 0){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = true;
         unset($_SESSION['form_errors']);
         unset($_SESSION['form_values']);
         header("Location:admin/create_user.php?school_id=$retval");
         echo($retval);
      }

      /* Registration attempt failed */
      else if($retval == 0){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = false;

        $_SESSION['form_errors']=$form->errors;
        $_SESSION['form_values']=$_POST;
        header("Location:admin/create_school.php");
        }
   }
   function procSubscribeTeacher(){
      global $session, $form;/*
      *  Convert username to all lowercase (by option) */
      if(ALL_LOWERCASE){
         $_POST['user'] = strtolower($_POST['user']);
      }
      /* Generate activation code*/
       $licence = $session->generateLicenceKey();
      /* Registration attempt */
      $retval = $session->subscribe_teacher($_POST['school'], $_POST['address-1'], $_POST['address-2'], $_POST['address-3'], $_POST['email'], $_POST['telephone'], $_POST['postcode'], $_POST['name'], $_POST['totalcost'], $_POST['subfrom'], $_POST['subto'], $licence);
      /* Registration Successful */
      if($retval == 0){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = true;
         unset($_SESSION['form_errors']);
         unset($_SESSION['form_values']);
         header("Location:subscribe-confirm.php");

        echo($retval);
      }

      /* Registration attempt failed */
      else if($retval > 0){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = false;

        $_SESSION['form_errors']=$form->errors;
        $_SESSION['form_values']=$_POST;
        header("Location:subscribe_teacher.php");
        }
   }
   function procSubscribeCoach(){
      global $session, $form;/*
      *  Convert username to all lowercase (by option) */
      if(ALL_LOWERCASE){
         $_POST['user'] = strtolower($_POST['user']);
      }
      /* Generate activation code*/
       $licence = $session->generateLicenceKey();
      /* Registration attempt */
      $retval = $session->subscribe_coach($_POST['school'], $_POST['address-1'], $_POST['address-2'], $_POST['address-3'], $_POST['email'], $_POST['telephone'], $_POST['postcode'], $_POST['name'],$_POST['sub-from'], $_POST['sub-to'], $licence);
      /* Registration Successful */
      if($retval == 0){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = true;
         unset($_SESSION['form_errors']);
         unset($_SESSION['form_values']);
         header("Location:subscribe-confirm.php");

        echo($retval);
      }

      /* Registration attempt failed */
      else if($retval > 0){
         $_SESSION['reguname'] = $_POST['user'];
         $_SESSION['regsuccess'] = false;

        $_SESSION['form_errors']=$form->errors;
        $_SESSION['form_values']=$_POST;
        header("Location:subscribe_coach.php");
        }
   }
   /**
    * procForgotPass - Validates the given username then if
    * everything is fine, a new password is generated and
    * emailed to the address the user gave on sign up.
    */
   function procForgotPass(){
      global $database, $session, $mailer, $form;
	 /* Username error checking */
      $subuser = $_POST['username'];
      $field = "username";
      if(!$subuser || strlen($subuser = trim($subuser)) == 0){
         $form->setError($field, "Username not entered");
      }
      else {
      $subemail = $_POST['email'];
      $field = "email";  
      if(!$subemail || strlen($subemail = trim($subemail)) == 0){
         $form->setError($field, "Email not entered");
      }
      else{
         /* Make sure username is in database */
         $subemail = stripslashes($subemail);
         if (!$database->emailOnDatabase($subemail,$subuser)){
            $form->setError($field, "Email address not in our database");
         }
      }
      }
      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         $_SESSION['form_values'] = $_POST;
         $_SESSION['form_errors'] = $form->getErrorArray();
        
        $location="https://".$_SERVER['SERVER_NAME']."/tplan/resend-password.php?change=no";
      }
      /* Generate new password and email it to user */
      else{
         /* Generate new password */
         $newpass = $session->generateRandStr(8);
         
         /* Get email of user */
         //$usrinf = $database->getUserInfobyEmail($subemail);
         //$subuser  = $usrinf['username'];
         
         /* Attempt to send the email with new password */
         if($mailer->sendNewPass($subuser,$subemail,$newpass)){
            /* Email sent, update database */
            $database->updateUserField($subuser, "password", md5($newpass));
            unset($_SESSION['form_errors']);
            unset($_SESSION['form_values']);
            $_SESSION['forgotpass'] = true;
            $location="https://".$_SERVER['SERVER_NAME']."/tplan/resend-password.php?change=yes";
         }
         /* Email failure, do not change password */
         else{
            $_SESSION['forgotpass'] = false;
            //print_r($_SESSION);
            $location="https://".$_SERVER['SERVER_NAME']."/tplan/resend-password.php?change=no";
          }
      }
      //echo $location;
      header("Location:".$location);
   }
   
   /**
    * procEditAccount - Attempts to edit the user's account
    * information, including the password, which must be verified
    * before a change is made.
    */
   function procEditAccount(){
      global $session, $form;
	  $_SESSION['current_dialog'] = '#accountDialog';
      /* Account edit attempt */
      $retval = $session->editAccount($_POST['email'], $_POST['name'], $_POST['school'], $_POST['postcode'], $_POST['send_email_newsletter']);
      /* Account edit successful */
      if($retval){
         $_SESSION['useredit'] = true;
         //echo "success";
        header("Location: account.php");
      }
      /* Error found with form */
      else{
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         if ($_SESSION['error_array']['email']) $location="account.php?error=".base64_encode($_SESSION['error_array']['email']);
         header("Location: ".$location);
      }
   }
   function procEditOtherAccount(){
      global $session, $form;
	  $_SESSION['current_dialog'] = '#accountDialog';
      /* Account edit attempt */
      $retval = $session->editOtherAccount($_POST['username'],$_POST['curpass'], $_POST['newpass'], $_POST['email'], $_POST['name'], $_POST['telephone'], $_POST['school'], $_POST['postcode'], $_POST['newsletter'], $_POST['userlevel'],$_POST['activation']);
      /* Account edit successful */
      if($retval){
         $_SESSION['useredit'] = true;
         //echo "success";
         header("Location: admin/admin.php");
      }
      /* Error found with form */
      else{
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         //echo "failure";
         header("Location: admin/admin.php");
      }
   }
   function procCreateUser(){
      global $session, $form;
	 // $_SESSION['current_dialog'] = '#accountDialog';
      /* Account edit attempt */
      if (is_array($_POST['username'])){
      $i=0;
      foreach($_POST['username'] as $username) {
      $retval = $session->createUserAccount($username, md5($_POST['password'][$i]),$_POST['email'], $_POST['name'][$i], $_POST['telephone'], $_POST['school'], $_POST['postcode'], $_POST['userlevel']);
      $i++;
      }}
      else{
       $retval = $session->createUserAccount($_POST['username'], md5($_POST['password']),$_POST['email'], $_POST['name'], $_POST['telephone'], $_POST['school'], $_POST['postcode'], $_POST['userlevel']);
      }
      if($retval){
         $_SESSION['usercreate'] = true;
         //echo "success";
         header("Location: admin/admin.php");
      }
      /* Error found with form */
      else{
         $_SESSION['value_array'] = $_POST;
         $_SESSION['error_array'] = $form->getErrorArray();
         //echo "failure";
         header("Location: admin/admin.php");
      }
   }
   function procPasswordReset(){
       global $session, $form;
       $retval = $session->changePassword($_POST['current_password'],$_POST['user_password']);
       if ($retval){
           $_SESSION['password_change'] = true;
           header("Location: main.php");
       }
       else {
           $_SESSION['value_array'] = $_POST;
           $_SESSION['error_array'] = $form->getErrorArray();
           //print_r( $_SESSION['error_array']);
          if ($_SESSION['error_array']['curpass']) $location="code/password.php?error=".base64_encode($_SESSION['error_array']['curpass']);
         if ($_SESSION['error_array']['newpass']) $location="code/password.php?error=".base64_encode($_SESSION['error_array']['newpass']);
         header("Location:".$location);
       }
   }
};

/* Initialize process */
$process = new Process;

?>
