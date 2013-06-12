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
        <title>PE Planning | Login</title>
        <link href="<?php if (!empty($_SERVER['HTTPS'])) echo "https://".$_SERVER['SERVER_NAME']; else echo "http://".$_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css"/>
        <link href="<?php if (!empty($_SERVER['HTTPS'])) echo "https://".$_SERVER['SERVER_NAME']; else echo "http://".$_SERVER['SERVER_NAME']?>/tplan/css/signupflow-https.css?<?=time()?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="<?php if (!empty($_SERVER['HTTPS'])) echo "https://".$_SERVER['SERVER_NAME']; else echo "http://".$_SERVER['SERVER_NAME']?>/tplan/css/pep-https.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css" />
        <link href="<?php if (!empty($_SERVER['HTTPS'])) echo "https://".$_SERVER['SERVER_NAME']; else echo "http://".$_SERVER['SERVER_NAME']?>/tplan/css/login.css?<?=time()?>" media="screen, projection" rel="stylesheet" type="text/css" />
    </head>
    <body id="login">
    <script src="<?php if (!empty($_SERVER['HTTPS'])) echo "https://".$_SERVER['SERVER_NAME']; else echo "http://".$_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>" type="text/javascript"></script>
    <script src="<?php if (!empty($_SERVER['HTTPS'])) echo "https://".$_SERVER['SERVER_NAME']; else echo "http://".$_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>" type="text/javascript"></script>
    <script src="<?php if (!empty($_SERVER['HTTPS'])) echo "https://".$_SERVER['SERVER_NAME']; else echo "http://".$_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>" type="text/javascript"></script>
    <script src="<?php if (!empty($_SERVER['HTTPS'])) echo "https://".$_SERVER['SERVER_NAME']; else echo "http://".$_SERVER['SERVER_NAME']?>/tplan/js/pep-https.js?<?=time()?>" type="text/javascript"></script>
<?php include("header.php")?>
    <div id="doc"  class="login">
        <div class="content-heading">
  <div class="heading">
    <p class="sign-in">
      New to PE Planning? <a href="/tplan/register.php">Sign up</a>.
    </p>
    <h2>Sign in to Start Planning PE Lessons</h2>

  </div>
</div>
<div id="signup-form" class="">
 <form action="/tplan/process.php" method="post">
  <fieldset class="common-form standard-form">

    <table cellspacing="0">
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
        <th><label for="username">Username</label></th>
        <td><input id="username" name="username" type="text" value="" class="login"/></td>
      </tr>
      <tr>
        <th><label for="password">Password</label></th>
        <td><input id="password" name="password" type="password" value="" class="login" /> <small><a href="/tplan/resend-password.php">Forgot?</a></small></td>

      </tr>
      <tr>
        <th></th>
        <td></td>
      </tr>

      <tr>
        <th></th>
        <td><input alt="Sign In" value="" id="signin_sub" tabindex="8" type="submit"  class="signin" />
            <input id="sublogin" name="sublogin" type="hidden" value="1"/></td>

      </tr>
      <tr>
          <th></th>
        </tr>
    </table>
  </fieldset>
</form>
</div>
   </div>
     <?php include("footer.php")?>
    </body>
  <script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/login.js?<?=time()?>" type="text/javascript"></script>
</html>