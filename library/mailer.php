<?php 
/**
 * Mailer.php
 *
 * The Mailer class is meant to simplify the task of sending
 * emails to users. Note: this email system will not work
 * if your server is not setup to send mail.
 *
 * If you are running Windows and want a mail server, check
 * out this website to see a list of freeware programs:
 * <http://www.snapfiles.com/freeware/server/fwmailserver.html>
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 */
 
class Mailer
{
   /**
    * sendWelcome - Sends a welcome message to the newly
    * registered user, also supplying the username and
    * password.
   
   function sendWelcome($name, $user, $email, $pass, $activation){
      $pass = str_replace('£',chr(163),$pass);
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Reply-To: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Return-Path: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n";
      $subject = "WWW.PEPLANNING.ORG.UK Welcome";
      $body = $name.",\n\n"
             ."Welcome! You've just registered at WWW.PEPLANNING.ORG.UK "
             ."with the following information:\n\n"
             ."Username: ".$user."\n"
             ."Password: ".$pass."\n\n"
             ."To confirm your email address and complete the registration process you must visit this address:\n\n"
             .HOME_URL."tplan/activate-confirm.php?email_address=" . urlencode($email) . "&key=$activation\n\n";

      return mail($email,$subject,$body,$from);
   }
 */

   function resendActivation($email,$activation){
       $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Reply-To: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Return-Path: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n";
      $subject = "WWW.PEPLANNING.ORG.UK Activation";
      $body = "You have requested us to resend your activation detail "
             ."To complete the registration process you must visit this address:\n\n"
             .HOME_URL."tplan/activate-confirm.php?email_address=" . urlencode($email) . "&key=$activation\n\n\n\n"
             ."If you did not make this request please ignore this email";

      return mail($email,$subject,$body,$from);
   }
   /**
    * sendNewPass - Sends the newly generated password
    * to the user's email address that was specified at
    * sign-up.
    */
   function sendNewPass($user, $email, $pass){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">";
      $subject = "WWW.PEPLANNING.ORG.UK - Your new password";
      $body = $user.",\n\n"
             ."We've generated a new password for you at your "
             ."request, you can use this new password with your "
             ."username to log in to WWW.PEPLANNING.ORG.UK.\n\n"
             ."Username: ".$user."\n"
             ."New Password: ".$pass."\n\n"
             ."It is recommended that you change your password "
             ."to something that is easier to remember, which "
             ."can be done by clicking on your username on the main page "
             ."and going to the Edit Account page after signing in.\n\n";
             
      return mail($email,$subject,$body,$from);
   }
   function sendSubConfirm($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$total_cost,$classnum,$subfrom,$subto,$licence){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Reply-To: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Return-Path: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Bcc:".EMAIL_COPY_NAME." <".EMAIL_COPY_ADDR.">\r\n";
      $subject = "WWW.PEPLANNING.ORG.UK Subscription";
      $body = $name.",\n\n"
             ."Welcome! You've just subscribed your school at WWW.PEPLANNING.ORG.UK "
             ."with the following information:\n\n"
             ."School Name: ".$school."\n"
             ."Address: ".$address1."\n"
             ."Postcode: ".$postcode."\n"
             ."School Contact: ".$name."\n"
             ."Contact Telephone: ".$telephone."\n"
             ."Contact Email: ".$email."\n"
             ."Number of Classes: ".$classnum."\n"
             ."Subscription From: ".$subfrom."\n"
             ."Subscription To: ".$subto."\n"
             ."Subscription Cost: ".chr(163).$total_cost."\n\n"
             ."You will be contacted shortly by a representative of PE Planning to confirm your subscription\n\n"
             ."and provide you with your licence key. You will then be able to register your teachers to use the system.\n\n";

      return mail($email,$subject,$body,$from);
   }

   function sendSubConfirmTeacher($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$total_cost,$subfrom,$subto,$licence){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Reply-To: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Return-Path: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Bcc:".EMAIL_COPY_NAME." <".EMAIL_COPY_ADDR.">\r\n";
     $subject = "WWW.PEPLANNING.ORG.UK Subscription";
      $body = $name.",\n\n"
             ."Welcome! You've just subscribed for PEteacher at WWW.PEPLANNING.ORG.UK "
             ."with the following information:\n\n"
             ."School Name: ".$school."\n"
             ."Address: ".$address1."\n"
             ."Postcode: ".$postcode."\n"
             ."School Contact: ".$name."\n"
             ."Contact Telephone: ".$telephone."\n"
             ."Contact Email: ".$email."\n"
             ."Subscription From: ".$subfrom."\n"
             ."Subscription To: ".$subto."\n"
             ."Subscription Cost: ".chr(163).$total_cost."\n\n"
             ."You will be contacted shortly by a representative of PE Planning to confirm your subscription\n\n"
             ."and provide you with your licence key.\n\n";

      return mail($email,$subject,$body,$from);
   }


   function sendSubConfirmCoach($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$subfrom,$subto,$licence){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Reply-To: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Return-Path: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.">\r\n".
              "Bcc:".EMAIL_COPY_NAME." <".EMAIL_COPY_ADDR.">\r\n";
      $subject = "WWW.PEPLANNING.ORG.UK Subscription";
      $body = $name.",\n\n"
             ."Welcome! You've just subscribed to PEcoach at WWW.PEPLANNING.ORG.UK "
             ."with the following information:\n\n"
             ."School Name: ".$school."\n"
             ."Address: ".$address1."\n"
             ."Postcode: ".$postcode."\n"
             ."School Contact: ".$name."\n"
             ."Contact Telephone: ".$telephone."\n"
             ."Contact Email: ".$email."\n"
             ."Subscription From: ".$subfrom."\n"
             ."Subscription To: ".$subto."\n"
              ."You will be contacted shortly by a representative of PE Planning to confirm your subscription\n\n"
             ."and provide you with your licence key. You will then be able to register your staff to use the system.\n\n";

      return mail($email,$subject,$body,$from);
   }
};


/* Initialize mailer object */
$mailer = new Mailer;
 
?>
