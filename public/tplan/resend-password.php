<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | Resend Password</title>
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" rel="stylesheet" type="text/css" media="screen"/>
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/signupflow-https.css?<?=time()?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/pep-https.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css" />
         <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/login.css?<?=time()?>" media="screen, projection" rel="stylesheet" type="text/css" />
    </head>
    <body id="login">
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/pep-https.js?<?=time()?>" type="text/javascript"></script>
<?php include("header.php")?>
    <div id="doc"  class="subscription-confirmation">
<div class="content-heading">
  <div class="heading">
    <p class="sign-in">
      New to PE Planning? <a href="/tplan/code/signup.php">Sign up</a>.
    </p>
    <h2>Forgot your PE Planning Password?</h2><br>
<? if ($_GET['change']=="yes") {?>
        <p>PE Planning has sent a new password and reset instructions to the email address associated with your account.
        <a href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/main.php">Click here to sign in</a></p>
<?} else { ?>
       <p>PE Planning will send password reset instructions to the email address associated with your account.</p>
<?} ?>
  </div>
</div>

<div id="signup-form" class="">
 <form action="/tplan/process.php" method="post">
  <fieldset class="common-form standard-form">

    <table cellspacing="0">
      <? if ($_GET['change']=="no"){?>
      <tr>
          <th></th>
         <td>
            <label class="error">
                An error has occurred in this process.</br>Please try again later or contact your <a href="mailto:admin@peplanning.org.uk">system administrator</a>
            </label>
         </td>
      </tr>
      <? }?>
        <tr>
        <th><label for="email">Username</label></th>
        <td><input id="username" name="username" type="text" value="<? echo $_SESSION['form_values']['username']?>" class="login"/></td>
      </tr>
      <tr>
        <th></th>
        <td class="error"><? echo $_SESSION['form_errors']['username']?></td>
      </tr>
      <tr>
        <th><label for="email">Email</label></th>
        <td><input id="email" name="email" type="text" value="<? echo $_SESSION['form_values']['email']?>" class="login"/></td>
      </tr>
        <tr>
        <th></th>
        <td class="error"><? echo $_SESSION['form_errors']['email']?></td>
      </tr>
      <tr>
        <th></th>
        <td><input alt="Resend" value="" id="resend_submit" tabindex="8" type="submit"  class="resend" />
            <input id="subforgot" name="subforgot" type="hidden" value="1"/></td>

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
</html>