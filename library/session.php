<?php
/**
 * Session.php
 * 
 * The Session class is meant to simplify the task of keeping
 * track of logged in users and also guests.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 */
include_once($_SERVER["DOCUMENT_ROOT"] . '/../library/tplan_config.php'); 
include("database.php");
include("mailer.php");
include("form.php");
include("config.php");

class Session
{
   var $username;     //Username given on sign-up
   var $userid;       //Random value generated on current login
   var $userlevel;    //The level to which the user pertains
   var $time;         //Time user was last active (page loaded)
   var $logged_in;    //True if user is logged in, false otherwise
   var $userinfo = array();  //The array holding all user info
   var $url;          //The page url current being viewed
   var $referrer;     //Last recorded site page viewed
   /**
    * Note: referrer should really only be considered the actual
    * page referrer in process.php, any other time it may be
    * inaccurate.
    */

   /* Class constructor */
   function Session(){
      $this->time = time();
      $this->startSession();
   }

   /**
    * startSession - Performs all the actions necessary to 
    * initialize this session object. Tries to determine if the
    * the user has logged in already, and sets the variables 
    * accordingly. Also takes advantage of this page load to
    * update the active visitors tables.
    */
   function startSession(){
      global $database;  //The database connection
      if (session_id() == "") session_start();   //Tell PHP to start the session

      /* Determine if user is logged in */
      $this->logged_in = $this->checkLogin();
      /**
       * Set guest value to users not logged in, and update
       * active guests table accordingly.
       */
      if(!$this->logged_in){
         $this->username = $_SESSION['username'] = GUEST_NAME;
         $this->userlevel = GUEST_LEVEL;
         $database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
      }
      /* Update users last active timestamp */
      else{
         $database->addActiveUser($this->username, $this->time);
      }
      
      /* Remove inactive visitors from database */
      $database->removeInactiveUsers();
      $database->removeInactiveGuests();
      
      /* Set referrer page */
      if(isset($_SESSION['url'])){
         $this->referrer = $_SESSION['url'];
      }else{
         $this->referrer = "/";
      }

      /* Set current url */
      $this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
   }

   /**
    * checkLogin - Checks if the user has already previously
    * logged in, and a session with the user has already been
    * established. Also checks to see if user has been remembered.
    * If so, the database is queried to make sure of the user's 
    * authenticity. Returns true if the user has logged in.
    */
   function checkLogin(){
      global $database;  //The database connection
      /* Check if user has been remembered */
      if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
         $this->username = $_SESSION['username'] = $_COOKIE['cookname'];
         $this->userid   = $_SESSION['userid']   = $_COOKIE['cookid'];
      }
      /* Username and userid have been set and not guest */
      if(isset($_SESSION['username']) && isset($_SESSION['userid']) &&
         $_SESSION['username'] != GUEST_NAME){
         /* Confirm that username and userid are valid */
         if($database->confirmUserID($_SESSION['username'], $_SESSION['userid']) != 0){
            /* Variables are incorrect, user not logged in */
            unset($_SESSION['username']);
            unset($_SESSION['userid']);
            unset($_SESSION['theme']);
            unset($_SESSION['id']);
            return false;
         }

         /* User is logged in, set class variables */
         $this->userinfo  = $database->getUserInfo($_SESSION['username']);
         $this->username  = $this->userinfo['username'];
         $this->userid    = $this->userinfo['userid'];
         $this->userlevel = $_SESSION['userlevel'] = $this->userinfo['userlevel'];
		 $this->name = $this->userinfo['name'];
		 $this->telephone = $this->userinfo['telephone'];
 		 $this->newsletter = $this->userinfo['newsletter'];
		 $this->id = $_SESSION['id'] = $this->userinfo['id'];
        return true;
      }
      /* User not logged in */
      else{
         return false;
      }
   }

   /**
    * login - The user has submitted his username and password
    * through the login form, this function checks the authenticity
    * of that information in the database and creates the session.
    * Effectively logging in the user if all goes well.
    */
   function login($subuser, $subpass, $subremember){
      global $database, $form;  //The database and form object
      /* Username error checking */
      $field = "user";  //Use field name for username
      if(!$subuser || strlen($subuser = trim($subuser)) == 0){
         $form->setError($field, "* Username not entered");
      }
      else{
         /* Check if username is not alphanumeric 
         if(!eregi("^([0-9a-z.])*$", $subuser)){
            $form->setError($field, "* Username not alphanumeric");
         }*/
      }
      /* Password error checking */
      $field = "pass";  //Use field name for password
      if(!$subpass){
         $form->setError($field, "* Password not entered");
      }
      
      /* Return if form errors exist */
      if($form->num_errors > 0){
         return 1;
      }

      /* Checks that username is in database and password is correct */
      $subuser = stripslashes($subuser);
      $result = $database->confirmUserPass($subuser, md5($subpass));
      /* Check error codes */
      if($result == 1){
         $field = "user";
         $form->setError($field, "* Username or Password invalid");
         return 1;
      }
      else if($result == 2){
         $field = "pass";
         //$subuser=base64_encode($subuser);
         $field_url=htmlspecialchars(HOME_URL."tplan/process.php?reactivate=".$subuser);
         $field_error="Your Account has not been activated. <br>Click <a href='".$field_url."'>here to resend</a> your activation email";
         $form->setError($field,$field_error);
         return 1;
      }
      else {
      /* Username and password correct, register session variables */
      $this->userinfo  = $database->getUserInfo($subuser);
      $this->username  = $_SESSION['username'] = $this->userinfo['username'];
      $this->userid    = $_SESSION['userid']   = $this->generateRandID();
      $this->userlevel = $_SESSION['userlevel'] = $this->userinfo['userlevel'];
       
      /* Insert userid into database and update active users table */
      $database->updateUserField($this->username, "userid", $this->userid);
      $database->addActiveUser($this->username, $this->time);
      $database->removeActiveGuest($_SERVER['REMOTE_ADDR']);

      /**
       * This is the cool part: the user has requested that we remember that
       * he's logged in, so we set two cookies. One to hold his username,
       * and one to hold his random value userid. It expires by the time
       * specified in constants.php. Now, next time he comes to our site, we will
       * log him in automatically, but only if he didn't log out before he left.
       */
      
         setcookie("cookname", $this->username, time()+COOKIE_EXPIRE, COOKIE_PATH);
         setcookie("cookid",   $this->userid,   time()+COOKIE_EXPIRE, COOKIE_PATH);
         setcookie("cooklevel",   $this->userlevel,   time()+COOKIE_EXPIRE, COOKIE_PATH);
      

      /* Login completed successfully */
      return 0;
      }
   }
function activate_and_login($subuser, $subpass, $subremember){
      global $database, $form;  //The database and form object

      /* Checks that username is in database and password is correct */
      $subuser = stripslashes($subuser);
      $result = $database->confirmUserPass($subuser, $subpass);
      /* Check error codes */
      if($result == 1){
         $field = "user";
         $form->setError($field, "* Username or Password invalid");
         return 1;
      }

      else {
      /* Username and password correct, register session variables */
      $this->userinfo  = $database->getUserInfo($subuser);
      $this->username  = $_SESSION['username'] = $this->userinfo['username'];
      $this->userid    = $_SESSION['userid']   = $this->generateRandID();
      $this->userlevel = $_SESSION['userlevel'] = $this->userinfo['userlevel'];

      /* Insert userid into database and update active users table */
      $database->updateUserField($this->username, "userid", $this->userid);
      $database->addActiveUser($this->username, $this->time);
      $database->removeActiveGuest($_SERVER['REMOTE_ADDR']);

      /**
       * This is the cool part: the user has requested that we remember that
       * he's logged in, so we set two cookies. One to hold his username,
       * and one to hold his random value userid. It expires by the time
       * specified in constants.php. Now, next time he comes to our site, we will
       * log him in automatically, but only if he didn't log out before he left.
       */

         setcookie("cookname", $this->username, time()+COOKIE_EXPIRE, COOKIE_PATH);
         setcookie("cookid",   $this->userid,   time()+COOKIE_EXPIRE, COOKIE_PATH);
         setcookie("cooklevel",   $this->userlevel,   time()+COOKIE_EXPIRE, COOKIE_PATH);


      /* Login completed successfully */
      return 0;
      }
   }


   /**
    * logout - Gets called when the user wants to be logged out of the
    * website. It deletes any cookies that were stored on the users
    * computer as a result of him wanting to be remembered, and also
    * unsets session variables and demotes his user level to guest.
    */
   function logout(){
      global $database;  //The database connection
      /**
       * Delete cookies - the time must be in the past,
       * so just negate what you added when creating the
       * cookie.
       */
      if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookid'])){
         setcookie("cookname", "", time()-COOKIE_EXPIRE, COOKIE_PATH);
         setcookie("cookid",   "", time()-COOKIE_EXPIRE, COOKIE_PATH);
         setcookie("cooklevel",   "", time()-COOKIE_EXPIRE, COOKIE_PATH);
      }

      /* Unset PHP session variables */
      unset($_SESSION['username']);
      unset($_SESSION['userid']);
      session_unset();
      /* Reflect fact that user has logged out */
      $this->logged_in = false;
      
      /**
       * Remove from active users table and add to
       * active guests tables.
       */
      $database->removeActiveUser($this->username);
      $database->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
      
      /* Set user level to guest */
      $this->username  = GUEST_NAME;
      $this->userlevel = GUEST_LEVEL;
   }

   /**
    * register - Gets called when the user has just submitted the
    * registration form. Determines if there were any errors with
    * the entry fields, if so, it records the errors and returns
    * 1. If no errors were found, it registers the new user and
    * returns 0. Returns 2 if registration failed.
    */
   function register($subname, $subuser, $subpass, $subemail, $subschool, $subpostcode, $subnewsletter, $subhow, $subwhat, $activation){
      global $database, $form, $mailer;  //The database, form and mailer object
      
      /* Username error checking */
      $field = "user_name";  //Use field name for username
      if(!$subname || strlen($subname = trim($subname)) == 0){
         $form->setError($field, "Name can't be blank");
      }
      $field = "user_screen_name";  //Use field name for username
      if(!$subuser || strlen($subuser = trim($subuser)) == 0){
         $form->setError($field, "Username can't be blank");
      }
      $field = "school_name";  //Use field name for username
      if(!$subschool || strlen($subschool = trim($subschool)) == 0){
         $form->setError($field, "School name can't be blank");
      }
      $field = "user_postcode";  //Use field name for username
      if(!$subpostcode || strlen($subpostcode = trim($subpostcode)) == 0){
         $form->setError($field, "Postcode can't be blank");
      }
      $field = "how-button";  //Use field name for username
      if(!$subhow || strlen($subhow = trim($subhow)) == 0){
         $form->setError($field, "You must select one option");
      }
      $field = "what-button";  //Use field name for username
      if(!$subwhat || strlen($subwhat = trim($subwhat)) == 0){
         $form->setError($field, "You must select one option");
      }
      /*
      * else{
       */
         /* Spruce up username, check length *
         $subuser = stripslashes($subuser);
         if(strlen($subuser) < 5){
            $form->setError($field, "* Username below 5 characters");
         }
         else if(strlen($subuser) > 30){
            $form->setError($field, "* Username above 30 characters");
         }
         /* Check if username is not alphanumeric 
         else if(!eregi("^([0-9a-z])+$", $subuser)){
            $form->setError($field, "* Username not alphanumeric");
         }
         /* Check if username is reserved 
         else if(strcasecmp($subuser, GUEST_NAME) == 0){
            $form->setError($field, "* Username reserved word");
         }
         /* Check if username is already in use 
         else if($database->usernameTaken($subuser)){
            $form->setError($field, "* Username already in use");
         }
         /* Check if username is banned 
         else if($database->usernameBanned($subuser)){
            $form->setError($field, "* Username banned");
         }
      }

      /* Password error checking*/
      $field = "user_password";  //Use field name for password
      if(!$subpass){
         $form->setError($field, "Password not entered");
      }
      else{
         /* Spruce up password and check length*/
         $subpass = stripslashes($subpass);
         if(strlen($subpass) < 6){
            $form->setError($field, "Password too short");
         }
      }
         /* Check if password is not alphanumeric 
         else if(!eregi("^([0-9a-z])+$", ($subpass = trim($subpass)))){
            $form->setError($field, "* Password not alphanumeric");
         }
         /**
          * Note: I trimmed the password only after I checked the length
          * because if you fill the password field up with spaces
          * it looks like a lot more characters than 4, so it looks
          * kind of stupid to report "password too short".
          
      }
      
      /* Email error checking */
      //
      $field = "user_email";  //Use field name for email
      if(!$subemail || strlen($subemail = trim($subemail)) == 0){
         $form->setError($field, "Email can't be blank");
      } // this check is done client side
      else{
         /* Check if valid format email address */
         $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$";
         if(!eregi($regex,$subemail)){
            $form->setError($field, "Email invalid format");
         }
         $subemail = stripslashes($subemail);
      }

      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         
            //Errors with form
         return 1;
                  
      }
      
      /* No errors, add the new account to the */
      else{
         if($database->addNewUser($subname, $subuser, md5($subpass), $subemail, $subtelephone, $subschool, $subpostcode, $subnewsletter, $subhow, $subwhat,  $activation)){
            if(EMAIL_WELCOME){
               $mailer->sendWelcome($subname,$subuser,$subemail,$subpass,$activation);
            }            
            return 0;  //New user added succesfully
         }else{
            return 2;  //Registration attempt failed
         }
      }
   }
function reactivate($username){
    global $database, $form, $mailer;
    $retval = $database->getActivationCode($username);
    if($retval==1){
        $field="user";
        $form->setError($field,"User not found in system, please <a href=signup.php>re-register</a>");
        return 1; //failure
    }
    else{
        $resend_details=explode(",",$retval);
        $mailer->resendActivation($resend_details[0],$resend_details[1]);
        return 0;
    }
    
}
function subscribe($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$total_cost,$classnum,$subfrom,$subto,$licence){
      global $database, $form, $mailer;  //The database, form and mailer object

      /* Username error checking */
      $field = "school_name";  //Use field name for username
      if(!$school || strlen($school = trim($school)) == 0){
         $form->setError($field, "School Name can't be blank");
      }
      $field = "address-1";  //Use field name for username
      if(!$school || strlen($school = trim($school)) == 0){
         $form->setError($field, "You must fill at least 1 address field");
      }
      $field = "telephone";  //Use field name for username
      if(!$telephone || strlen($telephone = trim($telephone)) == 0){
         $form->setError($field, "Telephone can't be blank");
      }
      $field = "user_name";  //Use field name for username
      if(!$name || strlen($name = trim($name)) == 0){
         $form->setError($field, "Contact name can't be blank");
      }
      $field = "user_postcode";  //Use field name for username
      if(!$postcode || strlen($postcode = trim($postcode)) == 0){
         $form->setError($field, "Postcode can't be blank");
      }
      $field = "class-num";  //Use field name for username
      if(!$classnum || strlen($classnum = trim($classnum)) == 0){
         $form->setError($field, "You must enter the number of classes");
      }/*
      * else{
       */
         /* Spruce up username, check length *
         $subuser = stripslashes($subuser);
         if(strlen($subuser) < 5){
            $form->setError($field, "* Username below 5 characters");
         }
         else if(strlen($subuser) > 30){
            $form->setError($field, "* Username above 30 characters");
         }
         /* Check if username is not alphanumeric
         else if(!eregi("^([0-9a-z])+$", $subuser)){
            $form->setError($field, "* Username not alphanumeric");
         }
         /* Check if username is reserved
         else if(strcasecmp($subuser, GUEST_NAME) == 0){
            $form->setError($field, "* Username reserved word");
         }
         /* Check if username is already in use
         else if($database->usernameTaken($subuser)){
            $form->setError($field, "* Username already in use");
         }
         /* Check if username is banned
         else if($database->usernameBanned($subuser)){
            $form->setError($field, "* Username banned");
         }
      }


      /* Email error checking */
      //
      $field = "user_email";  //Use field name for email
      if(!$email || strlen($email = trim($email)) == 0){
         $form->setError($field, "Email can't be blank");
      } // this check is done client side
      else{
         /* Check if valid format email address */
         $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$";
         if(!eregi($regex,$email)){
            $form->setError($field, "Email invalid format");
         }
         $email = stripslashes($email);
      }

      /* Errors exist, have user correct them */
      if($form->num_errors > 0){

            //Errors with form
         return 1;

      }

      /* No errors, add the new account to the */
      else{
         if($database->addNewSchool($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$total_cost,$classnum,$subfrom,$subto,$licence)){
            if(EMAIL_WELCOME){
               $mailer->sendSubConfirm($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$total_cost,$classnum,$subfrom,$subto,$licence);
            }
            return 0;  //New user added succesfully
         }else{
            return 2;  //Registration attempt failed
         }
      }
   }
function createSchool($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$total_cost,$classnum,$subfrom,$subto,$licence){
      global $database, $form, $mailer, $school_id;  //The database, form and mailer object

      /* Username error checking */
      $field = "schoolname";  //Use field name for username
      if(!$school || strlen($school = trim($school)) == 0){
         $form->setError($field, "School Name can't be blank");
      }
      $field = "address1";  //Use field name for username
      if(!$address1 || strlen($address1 = trim($address1)) == 0){
         $form->setError($field, "You must fill at least 1 address field");
      }
          $field = "telephone";  //Use field name for username
      if(!$telephone || strlen($telephone = trim($telephone)) == 0){
         $form->setError($field, "Telephone can't be blank");
      }
      $field = "contact";  //Use field name for username
      if(!$name || strlen($name = trim($name)) == 0){
         $form->setError($field, "Contact name can't be blank");
      }
      $field = "postcode";  //Use field name for username
      if(!$postcode || strlen($postcode = trim($postcode)) == 0){
         $form->setError($field, "Postcode can't be blank");
      }
      $field = "classnum";  //Use field name for username
      if(!$classnum || strlen($classnum = trim($classnum)) == 0){
         $form->setError($field, "You must enter the number of classes");
      }     /* Email error checking */
      //
      $field = "email";  //Use field name for email
      if(!$email || strlen($email = trim($email)) == 0){
         $form->setError($field, "Email can't be blank");
      } // this check is done client side
      else{
         /* Check if valid format email address */
         $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$";
         if(!eregi($regex,$email)){
            $form->setError($field, "Email invalid format");
         }
         $email = stripslashes($email);
      }

      /* Errors exist, have user correct them */
      if($form->num_errors > 0){

            //Errors with form - normally this will be a number but I want to retunr the id if success full
         return 0;

      }

      /* No errors, add the new account to the */
      else{
         if($school_id=$database->addNewSchool($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$total_cost,$classnum,$subfrom,$subto,$licence)){
            return $school_id; //New user added succesfully
         }else{
            return 0;  //Registration attempt failed
         }
      }
   }
function subscribe_teacher($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$total_cost,$subfrom,$subto,$licence){
      global $database, $form, $mailer;  //The database, form and mailer object

      /* Username error checking */
      $field = "school_name";  //Use field name for username
      if(!$school || strlen($school = trim($school)) == 0){
         $form->setError($field, "School Name can't be blank");
      }
      $field = "address-1";  //Use field name for username
      if(!$school || strlen($school = trim($school)) == 0){
         $form->setError($field, "You must fill at least 1 address field");
      }
      $field = "telephone";  //Use field name for username
      if(!$telephone || strlen($telephone = trim($telephone)) == 0){
         $form->setError($field, "Telephone can't be blank");
      }
      $field = "user_name";  //Use field name for username
      if(!$name || strlen($name = trim($name)) == 0){
         $form->setError($field, "Contact name can't be blank");
      }
      $field = "user_postcode";  //Use field name for username
      if(!$postcode || strlen($postcode = trim($postcode)) == 0){
         $form->setError($field, "Postcode can't be blank");
      }
     /* else{
       */
         /* Spruce up username, check length *
         $subuser = stripslashes($subuser);
         if(strlen($subuser) < 5){
            $form->setError($field, "* Username below 5 characters");
         }
         else if(strlen($subuser) > 30){
            $form->setError($field, "* Username above 30 characters");
         }
         /* Check if username is not alphanumeric
         else if(!eregi("^([0-9a-z])+$", $subuser)){
            $form->setError($field, "* Username not alphanumeric");
         }
         /* Check if username is reserved
         else if(strcasecmp($subuser, GUEST_NAME) == 0){
            $form->setError($field, "* Username reserved word");
         }
         /* Check if username is already in use
         else if($database->usernameTaken($subuser)){
            $form->setError($field, "* Username already in use");
         }
         /* Check if username is banned
         else if($database->usernameBanned($subuser)){
            $form->setError($field, "* Username banned");
         }
      }


      /* Email error checking */
      //
      $field = "user_email";  //Use field name for email
      if(!$email || strlen($email = trim($email)) == 0){
         $form->setError($field, "Email can't be blank");
      } // this check is done client side
      else{
         /* Check if valid format email address */
         $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$";
         if(!eregi($regex,$email)){
            $form->setError($field, "Email invalid format");
         }
         $email = stripslashes($email);
      }

      /* Errors exist, have user correct them */
      if($form->num_errors > 0){

            //Errors with form
         return 1;

      }

      /* No errors, add the new account to the */
      else{
         if($database->addNewTeacher($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$total_cost,$subfrom,$subto,$licence)){
            if(EMAIL_WELCOME){
               $mailer->sendSubConfirmTeacher($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$total_cost,$subfrom,$subto,$licence);
            }
            return 0;  //New user added succesfully
         }else{
            return 2;  //Registration attempt failed
         }
      }
   }

 function subscribe_coach($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$subfrom,$subto,$licence){
      global $database, $form, $mailer;  //The database, form and mailer object

      /* Username error checking */
      $field = "company_name";  //Use field name for username
      if(!$school || strlen($school = trim($school)) == 0){
         $form->setError($field, "Company Name can't be blank");
      }
      $field = "address-1";  //Use field name for username
      if(!$school || strlen($school = trim($school)) == 0){
         $form->setError($field, "You must fill at least 1 address field");
      }
      $field = "telephone";  //Use field name for username
      if(!$telephone || strlen($telephone = trim($telephone)) == 0){
         $form->setError($field, "Telephone can't be blank");
      }
      $field = "user_name";  //Use field name for username
      if(!$name || strlen($name = trim($name)) == 0){
         $form->setError($field, "Contact name can't be blank");
      }
      $field = "user_postcode";  //Use field name for username
      if(!$postcode || strlen($postcode = trim($postcode)) == 0){
         $form->setError($field, "Postcode can't be blank");
      }
      /* else{
       */
         /* Spruce up username, check length *
         $subuser = stripslashes($subuser);
         if(strlen($subuser) < 5){
            $form->setError($field, "* Username below 5 characters");
         }
         else if(strlen($subuser) > 30){
            $form->setError($field, "* Username above 30 characters");
         }
         /* Check if username is not alphanumeric
         else if(!eregi("^([0-9a-z])+$", $subuser)){
            $form->setError($field, "* Username not alphanumeric");
         }
         /* Check if username is reserved
         else if(strcasecmp($subuser, GUEST_NAME) == 0){
            $form->setError($field, "* Username reserved word");
         }
         /* Check if username is already in use
         else if($database->usernameTaken($subuser)){
            $form->setError($field, "* Username already in use");
         }
         /* Check if username is banned
         else if($database->usernameBanned($subuser)){
            $form->setError($field, "* Username banned");
         }
      }


      /* Email error checking */
      //
      $field = "user_email";  //Use field name for email
      if(!$email || strlen($email = trim($email)) == 0){
         $form->setError($field, "Email can't be blank");
      } // this check is done client side
      else{
         /* Check if valid format email address */
         $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$";
         if(!eregi($regex,$email)){
            $form->setError($field, "Email invalid format");
         }
         $email = stripslashes($email);
      }

      /* Errors exist, have user correct them */
      if($form->num_errors > 0){

            //Errors with form
         return 1;

      }

      /* No errors, add the new account to the */
      else{
         if($database->addNewCoach($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$subfrom,$subto,$licence)){
            if(EMAIL_WELCOME){
               $mailer->sendSubConfirmCoach($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$subfrom,$subto,$licence);
            }
            return 0;  //New user added succesfully
         }else{
            return 2;  //Registration attempt failed
         }
      }
   }
  /**
    * editAccount - Attempts to edit the user's account information
    * including the password, which it first makes sure is correct
    * if entered, if so and the new password is in the right
    * format, the change is made. All other fields are changed
    * automatically.
    */
   function editAccount( $subemail, $subname, $subschool, $subpostcode, $subnewsletter){
      global $database, $form;//The database and form object
      /* New password entered */
      if($subnewpass){
         /* Current Password error checking */
         $field = "curpass";  //Use field name for current password
         if(!$subcurpass){
            $form->setError($field, "* Current Password not entered");
         }
         else{
            /* Check if password too short or is not alphanumeric */
            $subcurpass = stripslashes($subcurpass);
            if(strlen($subcurpass) < 4 ||
               !eregi("^([0-9a-z])+$", ($subcurpass = trim($subcurpass)))){
               $form->setError($field, "* Current Password incorrect");
            }
            /* Password entered is incorrect */
            if($database->confirmUserPass($this->username,md5($subcurpass)) != 0){
               $form->setError($field, "* Current Password incorrect");
            }
         }
         
         /* New Password error checking */
         $field = "newpass";  //Use field name for new password
         /* Spruce up password and check length*/
         $subpass = stripslashes($subnewpass);
         if(strlen($subnewpass) < 4){
            $form->setError($field, "* New Password too short");
         }
         /* Check if password is not alphanumeric */
         else if(!eregi("^([0-9a-z])+$", ($subnewpass = trim($subnewpass)))){
            $form->setError($field, "* New Password not alphanumeric");
         }
      }
      /* Change password attempted */
      else if($subcurpass){
         /* New Password error reporting */
         $field = "newpass";  //Use field name for new password
         $form->setError($field, "* New Password not entered");
      }
      
      /* Email error checking */
      $field = "email";  //Use field name for email
      if($subemail && strlen($subemail = trim($subemail)) > 0){
         /* Check if valid email address */
         $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$";
         if(!eregi($regex,$subemail)){
            $form->setError($field, "* Email invalid");
         }
         $subemail = stripslashes($subemail);
      }
      
      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         return false;  //Errors with form
      }
      
      /* Update password since there were no errors */
      if($subcurpass && $subnewpass){
         $database->updateUserField($this->username,"password",md5($subnewpass));
      }
      
      /* Change Email */
      if($subemail){
         $database->updateUserField($this->username,"email",$subemail);
      }
      
      /* Change FirstName */
      if($subname){
         $database->updateUserField($this->username,"name",$subname);
      }
      
      /* Change School */
      if($subschool){
         $database->updateUserField($this->username,"school",$subschool);
      }
      
      /* Change Postcode */
      if($subpostcode){
         $database->updateUserField($this->username,"postcode",$subpostcode);
      }
      
      /* Change FirstName */
      if($subnewsletter){
         $database->updateUserField($this->username,"newsletter",1);
      }
      if(!$subnewsletter){
         $database->updateUserField($this->username,"newsletter",0);
      }
      
      /* Success! */
      return true;
   }
   function editOtherAccount($username, $subnewpass, $subemail, $subname, $subtelephone, $subschool, $subpostcode, $subnewsletter, $subuserlevel,$subactivation){
      global $database, $form;  //The database and form object
     

      /* Email error checking */
      $field = "email";  //Use field name for email
      if($subemail && strlen($subemail = trim($subemail)) > 0){
         /* Check if valid email address */
         $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$";
         if(!eregi($regex,$subemail)){
            $form->setError($field, "* Email invalid");
         }
         $subemail = stripslashes($subemail);
      }

      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         return false;  //Errors with form
      }

      /* Update password since there were no errors */
      if($subnewpass){
         $database->updateUserField($username,"password",md5($subnewpass));
      }

      /* Change Email */
      if($subemail){
         $database->updateUserField($username,"email",$subemail);
      }

      /* Change FirstName */
      if($subname){
         $database->updateUserField($username,"name",$subname);
      }

      /* Change LastName */
      if($subtelephone){
         $database->updateUserField($username,"telephone",$subtelephone);
      }

      /* Change Year */
      if($subschool){
         $database->updateUserField($username,"school",$subschool);
      }

      /* Change Class */
      if($subpostcode){
         $database->updateUserField($username,"postcode",$subpostcode);
      }

      /* Change FirstName */
      if($subnewsletter){
         $database->updateUserField($username,"newsletter",$subnewsletter);
      }
      /*
       *  Change FirstName */
      if($subuserlevel){
         $database->updateUserField($username,"userlevel",$subuserlevel);
      }
      if(!$subactivation){
         $database->updateUserField($username,"activation",NULL);
      }
      /* Success! */
      return true;
   }
   function createUserAccount($username, $password,$subemail, $subname, $subtelephone, $subschool, $subpostcode, $subuserlevel){
      global $database, $form;  //The database and form object
       /* Email error checking */
      $field = "email";  //Use field name for email
      if($subemail && strlen($subemail = trim($subemail)) > 0){
         /* Check if valid email address */
         $regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$";
         if(!eregi($regex,$subemail)){
            $form->setError($field, "* Email invalid");
         }
         $subemail = stripslashes($subemail);
      }

      /* Errors exist, have user correct them */
      if($form->num_errors > 0){
         return false;  //Errors with form
      }
            $database->addNewSubscribedUser($username, $password,$subemail, $subname, $subtelephone, $subschool, $subpostcode, $subuserlevel);
      /* Success! */
      return true;
   }

   function changePassword($subcurpass,$subnewpass)
   {
       global $database, $form;
       if($subnewpass){
         /* Current Password error checking */
         $field = "curpass";  //Use field name for current password
         if(!$subcurpass){
            $form->setError($field, "* Current Password not entered");
         }
         else{
            /* Check if password too short or is not alphanumeric */
            $subcurpass = stripslashes($subcurpass);
            //echo $subcurpass."<br>";
            if(strlen($subcurpass) < 4 ||
               !eregi("^([0-9a-z])+$", ($subcurpass = trim($subcurpass)))){
               $form->setError($field, "* Current Password incorrect");
            }
            /* Password entered is incorrect */
            if($database->confirmUserPass($this->username,md5($subcurpass)) != 0){
               $form->setError($field, "* Current Password incorrect");
            }
         }

         /* New Password error checking */
         $field = "newpass";  //Use field name for new password
         /* Spruce up password and check length*/
         $subpass = stripslashes($subnewpass);
         if(strlen($subnewpass) < 4){
            $form->setError($field, "* New Password too short");
         }
         /* Check if password is not alphanumeric */
         //else if(!eregi("^([0-9a-z])+$", ($subnewpass = trim($subnewpass)))){
         //   $form->setError($field, "* New Password not alphanumeric");
         //}
      }
      /* Change password attempted */
      else if(!$subcurpass){
         /* New Password error reporting */
         $field = "newpass";  //Use field name for new password
         $form->setError($field, "* New Password not entered");
      }
      if($form->num_errors > 0){
         return false;  //Errors with form
      }
      if($subcurpass && $subnewpass){
         $database->updateUserField($this->username,"password",md5($subnewpass));
         return true;
      }
   }
   /**
    * isAdmin - Returns true if currently logged in user is
    * an administrator, false otherwise.
    */
   function isAdmin(){
      return ($_SESSION['userlevel'] == 9 );
   }
   
   /**
    * generateRandID - Generates a string made up of randomized
    * letters (lower and upper case) and digits and returns
    * the md5 hash of it to be used as a userid.
    */
   function generateRandID(){
      return md5($this->generateRandStr(16));
   }
   function generateLicenceKey(){
       return $this->generateRandStr(8);
   }
   /**
    * generateRandStr - Generates a string made up of randomized
    * letters (lower and upper case) and digits, the length
    * is a specified parameter.
    */
   function generateRandStr($length){
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
};


/**
 * Initialize session object - This must be initialized before
 * the form object because the form uses session variables,
 * which cannot be accessed unless the session has started.
 */
$session = new Session;

/* Initialize form object */
$form = new Form;
?>
