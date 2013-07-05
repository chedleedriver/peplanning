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
        <title>PE Planning | Change password</title>
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
  <div class="heading">
<? if (!$session->logged_in) {?>
    <p class="sign-in">
      You must be signed in to make changes <a href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/login.php">Sign in</a>.
    </p>
    <? } else {

    ?>
    <p class="sign-in">

    </p>
    <h2>Change Your Password</h2>

  </div>
</div>



<div id="signup-form" class="">
  <form action="/tplan/process.php" method="post" name="f"><input name="subpassreset" type="hidden" value="1" />
    <fieldset class="common-form standard-form">
    <table cellspacing="0" class="input-form" width="100%">
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
      <tr>

        <th><label for="password">Current Password:</label></th>
        <td><input autocomplete="off" id="current_password" name="current_password" tabindex="1" type="password" class="login"/></td>
        <td>
              <label class="error">
                  <? echo $_SESSION['error_array']['curpass']?>
              </label>
          </td>
      </tr>
      <tr>
        <th><label for="password">New Password:</label></th>
        <td><input autocomplete="off" id="user_password" name="user_password" tabindex="2" type="password" class="login" /> <span class="password-meter"></span>
        </td>
        <td>
              <label class="error">
                  <? echo $_SESSION['error_array']['newpass']?>
              </label>
          </td>
      </tr>
      <tr>
        <th><label for="password_confirmation">Verify New Password:</label></th>
        <td><input autocomplete="off" id="user_password_confirmation" name="user_password_confirmation" tabindex="3" type="password" class="login"/>
          <small class="error" id="nomatch" style="display:none;">Passwords don't match</small>
        </td>
      </tr>
      <tr>

        <th></th>
        <td><input alt="Change" value="" id="change_submit" tabindex="8" type="submit"  class="change" /></td>
      </tr>
    </table>
    </fieldset>
  </form></div>

<!--<div class="side-section">
    <h3>Password</h3>

    <p class="explanation">Be tricky! Your password should be at least 6 characters and not a dictionary word or common name. Change your password on occasion.</p>
</div>-->
    </div>
     <?php include("footer.php")?>
    </body>
  <script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/login.js?<?=time()?>" type="text/javascript"></script>
  <?php }?>
</html>