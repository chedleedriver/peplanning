<?php
if(@$_SERVER['HTTPS'] == false)
  {
     $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
     header("Location: $redirect");
     print $redirect;
  }
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | Change account</title>
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css"/>
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/signupflow-https.css?<?=time()?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/pep-https.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css" />
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/login.css?<?=time()?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/settings.css?<?=time()?>" media="screen, projection" rel="stylesheet" type="text/css" />
    </head>
    <body id="login">
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/pep-https.js?<?=time()?>" type="text/javascript"></script>
<?php include("header.php")?>
    <div id="doc"  class="login">
        <div class="content-heading">
  <div class="content-heading">
  <div class="heading">
<? if (!$session->logged_in) {?>
    <p class="sign-in">
      You must be signed in to make changes <a href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/login.php">Sign in</a>.
    </p>
    <? } else {
    $userinfo=$database->getUserInfo($_SESSION['username']);
    ?>
    <p class="sign-in">
      need a new password?&nbsp;<a href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/password.php">Change Password</a>.
    </p>
    <h2>Change Your Settings</h2>
   <? if ($_SESSION['useredit']) {?><p>Changes have been successfully saved</p><a href="/tplan/index.php">click here to return to the start page</a><?$_SESSION['useredit']=false;}
   ?>

  </div>
</div>

<div id="signup-form" class="">
  <form action="/tplan/process.php" method="post"><div style="margin:0;padding:0"><input name="subedit" type="hidden" value="1" /></div>
    <input id="follow" name="follow" type="hidden" />
    <fieldset>
      <table class="input-form">
        <? if ($_GET['error']){ ?>
      <tr>
          <th></th>
         <td>
            <label class="error">
                <? echo base64_decode($_GET['error']);
                 ?>
            </label>
         </td>
      </tr>
      <? }?>
      <tr class="full-name">
          <th>
            <label for="user_name">Full name</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="user_name" maxlength="40" name="name" size="20" tabindex="1" type="text" value="<? echo $userinfo['name']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter your first and last name
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error">
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              Your full name will appear on your plans and assessments
            </span>
          </td>
        </tr>
        <tr class="email">
          <th>
            <label for="user_email">Email</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="user_email" name="email" size="30" tabindex="2" type="text" value="<? echo $userinfo['email']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              <span id="email_info">We'll send you a confirmation</span>
              <span id="avail_email_check_indicator" style="display:none">
                <img alt="Indicator_arrows_circle" src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/indicator_arrows_circle.gif" /> Checking availability...
              </span>
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error">

            </div>
          </td>
        </tr>
         <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              This information will only be used by PE Planning Limited.
            </span>
          </td>
        </tr>
       <tr class="school-name">
          <th>
            <label for="school_name">School name</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="school_name" maxlength="60" name="school" size="20" tabindex="3" type="text" value="<? echo $userinfo['school']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter the name of your school
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error">
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              This information will only be used by PE Planning Limited.
            </span>
          </td>
        </tr>
        <tr class="postcode">
          <th>
            <label for="postcode">Postcode</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="postcode" maxlength="20" name="postcode" size="20" tabindex="4" type="text" value="<? echo $userinfo['postcode']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter your postcode
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error">
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              This information will only be used by PE Planning Limited.
            </span>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <input alt="Update" value="" id="update_submit" tabindex="5" type="submit"  class="update" />          </td>
        </tr>
        <tr class="email-updates">
          <th></th>
          <td colspan="2" class="col-field">
            <input id="user_send_email_newsletter" name="send_email_newsletter" tabindex="6" type="checkbox" <?if ($userinfo['newsletter']==1) echo 'checked="yes"';?>/>
              <label for="user_send_email_newsletter">
                please send me email updates!
              </label>
          
          </td>
        </tr>
      </table>
    </fieldset>

    
</form></div></div>
    </div>
     <?php include("footer.php")?>
    </body>
  <?php }?>
</html>