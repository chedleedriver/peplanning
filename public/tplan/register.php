<?php
header("Location: https://www.peplanning.org.uk/auth/subscribe");
/**if(@$_SERVER['HTTPS'] == false)
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
        <title>PE Planning | Register</title>
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css"/>
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/pep-https.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css" />
         <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/signupflow-https.css?<?=time()?>" media="screen, projection" rel="stylesheet" type="text/css" />
   </head>
    <body id="login">
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/pep-https.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery.tipsy.min.js?<?=time()?>" type="text/javascript"></script>
<script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-16957975-1']);
        _gaq.push(['_trackPageview']);

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        </script>
<?php include("header.php")?>
    <div id="register-doc"  class="register">
<div class="content-heading">
  <div class="heading">
    <p class="sign-in">
      Already on PE Planning? <a href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/login.php">Sign in</a>.
    </p>
    <h2>Start Planning PE Lessons</h2>
    <p class="instructions">In order to gain access to the system you must fill in your details below for our records</p>
    <p class="instructions">This activity does not constitute any commitment to purchase anything from us and the information will only be used for PE Planning purposes</p>
  </div>
</div>

<div id="signup-form" class="">
  <form action="/tplan/process.php" method="post"><div style="margin:0;padding:0"><input name="subjoin" type="hidden" value="1" /></div>
    <fieldset>
      <table class="input-form">
        <tr class="full-name">
          <th>
            <label for="user_name">Full name</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="user_name" maxlength="20" name="name" size="20" tabindex="1" type="text" value="<? echo $_SESSION['form_values']['name']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter your first and last name
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['user_name']?>
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
        <tr class="screen-name">
          <th>
            <label for="user_screen_name">Username</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="user_screen_name" maxlength="15" name="user" size="15" tabindex="2" type="text" value="<? echo $_SESSION['form_values']['user']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              <span id="screen_name_info">Pick a unique name.</span>
              <span id="avail_screenname_check_indicator" style="display:none">
                <img alt="Indicator_arrows_circle" src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/indicator_arrows_circle.gif" /> Checking availability...
              </span>
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['user_screen_name']?>

            </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span id="screen_name_url" class="field-desc">
                 You will sign onto PE Planning with your username
              </span>
          </td>
        </tr>
        <tr>
          <th>
            <label for="user_password">Password</label>
          </th>
          <td class="col-field">

              <input autocomplete="off" class="text_field" id="user_password" name="password" size="30" tabindex="3" type="password" value="<? echo $_SESSION['form_values']['password']?>"/>

          </td>
          <td class="col-help">
 <!--           <div class="label-box password-meter">
              <span>6 characters or more (be tricky!)</span>
            </div>-->
             <div class="label-box info">
             At least 6 chars and try not to be too obvious
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['user_password']?>
                          </div>

          </td>
        </tr>
        <tr class="email">
          <th>
            <label for="user_email">Email</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="user_email" name="email" size="30" maxlength="128" tabindex="4" type="text" value="<? echo $_SESSION['form_values']['email']?>"/>
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
            <div class="label-box error"><? echo $_SESSION['form_errors']['user_email']?>

            </div>
          </td>
        </tr>
         <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              This information will only be used for PE Planning purposes.
            </span>
          </td>
        </tr>
        <tr class="school-name">
          <th>
            <label for="school_name">School name</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="school_name" maxlength="128" name="school" size="30" tabindex="6" type="text" value="<? echo $_SESSION['form_values']['school']?>" />
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter the name of your school
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['school_name']?>
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              This information will only be used for PE Planning purposes.
            </span>
          </td>
        </tr>
        <tr class="postcode">
          <th>
            <label for="user_postcode">School Postcode</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="user_postcode" maxlength="20" name="postcode" size="20" tabindex="7" type="text" value="<? echo $_SESSION['form_values']['postcode']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter your postcode
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['user_postcode']?>
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              This information will only be used for PE Planning purposes.
            </span>
          </td>
        </tr>
        <tr class="email-updates">
          <th></th>
          <td colspan="2" class="col-field">
              <label>
                How did you find out about PE Planning?
              </label>
         </td>
        </tr><tr class="how-do-you-know">
          <th></th>
          <td colspan="2" class="col-field">
            <div id="how"><input id="how-button" name="how-button" tabindex="10" type="radio" value="email" <? if ($_SESSION['form_values']['how-button']=="email") echo "checked"?>/>
              <label for="how-email">
                Email message
              </label>
            </div>
              <div id="how"><input id="how-button" name="how-button" tabindex="11" type="radio" value="letter" <? if ($_SESSION['form_values']['how-button']=="letter") echo "checked"?> />
              <label for="how-letter">
                Letter
              </label>
            </div>
              <div id="how"><input id="how-button" name="how-button" tabindex="12" type="radio" value="search" <? if ($_SESSION['form_values']['how-button']=="search") echo "checked"?> />
              <label for="how-search">
                Internet search
              </label>
            </div>
              <div id="how"><input id="how-button" name="how-button" tabindex="13" type="radio" value="notice-board" <? if ($_SESSION['form_values']['how-button']=="notice-board") echo "checked"?> />
              <label for="how-notice-board">
                School notice board
              </label>
            </div>
              <div id="how"><input id="how-button" name="how-button" tabindex="13" type="radio" value="colleague" <? if ($_SESSION['form_values']['how-button']=="colleague") echo "checked"?> />
              <label for="how-colleague">
                Referral from a colleague
              </label>
            </div>
               <div id="how"><input id="how-button" name="how-button" tabindex="13" type="radio" value="show" <? if ($_SESSION['form_values']['how-button']=="show") echo "checked"?> />
              <label for="how-show">
               Education Show
              </label>
            </div>
          </td>
        </tr>
        <tr class="how-error">
          <th></th>
          <td colspan="2" class="col-field">
              <label class="error">
                <? echo $_SESSION['form_errors']['how-button']?>
              </label>
         </td>
        </tr>
                  <tr class="email-updates">
          <th></th>
          <td colspan="2" class="col-field">
              <label>
                What is your role in your school?
              </label>
         </td>
        </tr><tr class="what-do-you-do">
          <th></th>
          <td colspan="2" class="col-field">
            <div id="what"><input id="what-button" name="what-button" tabindex="10" type="radio" value="management" <? if ($_SESSION['form_values']['what-button']=="management") echo "checked"?>/>
              <label for="what-management">
                Senior management
              </label>
            </div>
              <div id="what"><input id="what-button" name="what-button" tabindex="11" type="radio" value="coordinator" <? if ($_SESSION['form_values']['what-button']=="coordinator") echo "checked"?> />
              <label for="what-coordinator">
                PE Coordinator
              </label>
            </div>
              <div id="what"><input id="what-button" name="what-button" tabindex="12" type="radio" value="teacher" <? if ($_SESSION['form_values']['what-button']=="teacher") echo "checked"?> />
              <label for="what-teacher">
                Teacher
              </label>
            </div>
              <div id="what"><input id="what-button" name="what-button" tabindex="13" type="radio" value="ta" <? if ($_SESSION['form_values']['what-button']=="ta") echo "checked"?> />
              <label for="what-teaching-assistant">
                Teaching Assistant
              </label>
            </div>
              <div id="what"><input id="what-button" name="what-button" tabindex="13" type="radio" value="other" <? if ($_SESSION['form_values']['what-button']=="other") echo "checked"?> />
              <label for="what-other">
                Other
              </label>
            </div>
          </td>
        </tr>
        <tr class="what-error">
          <th></th>
          <td colspan="2" class="col-field">
              <label class="error">
                <? echo $_SESSION['form_errors']['what-button']?>
              </label>
         </td>
        </tr>
          <tr>
          <th></th>
          <td colspan="2">
            <input alt="I accept. Create my account." value="" id="user_create_submit" tabindex="8" type="submit" value="Create my account" class="create-account" /> </td>
        </tr>
        <tr class="email-updates">
          <th></th>
          <td colspan="2" class="col-field">
            <div id="scoop"><input checked="checked" id="user_send_email_newsletter" name="send_email_newsletter" tabindex="9" type="checkbox" value="1" />
              <label for="user_send_email_newsletter">
                please send me email updates!
              </label>
            </div>
          </td>
        </tr>
      </table>
    </fieldset>
</form></div>
</div>
     <?php include("footer.php")?>
<?php if ($_SESSION['form_errors']){?>
    <script type="text/javascript">
    $("#signup-form").addClass('validated-by-backend');
    <?php foreach($_SESSION['form_errors'] as $field_name) {
        echo "$('#".array_search($field_name,$_SESSION['form_errors'])."').wrap('<div class=\"fieldWithErrors\" />');";
        }?>
    </script>
<?php }?>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/signup.js?<?=time()?>" type="text/javascript"></script>
</body>
</html>
<?php unset($_SESSION['form_errors']);?>