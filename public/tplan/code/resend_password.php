<?php include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=8">

    <script type="text/javascript">
//<![CDATA[
(function(g){var a=location.href.split("#!")[1];if(a){window.location.hash = "";g.location.pathname = g.HBR = a.replace(/^([^/])/,"/$1");}})(window);
//]]>
</script>
    <script type="text/javascript" charset="utf-8">
      if (!twttr) {
        var twttr = {}
      }

      // Benchmarking load time.
      // twttr.timeTillReadyUnique = '1285847576-15368-41672';
      // twttr.timeTillReadyStart = new Date().getTime();
    </script>

        <script type="text/javascript">
//<![CDATA[
var page={};var onCondition=function(D,C,A,B){D=D;A=A?Math.min(A,5):5;B=B||100;if(D()){C()}else{if(A>1){setTimeout(function(){onCondition(D,C,A-1,B)},B)}}};
//]]>
</script>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta content="en-us" http-equiv="Content-Language" />
<meta content="no" http-equiv="imagetoolbar" />
<meta content="width = 780" name="viewport" />
<meta content="4FTTxY4uvo0RZTMQqIyhh18HsepyJOctQ+XTOu1zsfE=" name="verify-v1" />
<meta content="1" name="page" />
<meta content="NOODP" name="robots" />
<meta content="n" name="session-loggedin" />
<meta content="" name="page-user-screen_name" />
    <title id="page_title">PE Planning | Resend Password</title>
<link href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/pep-https.css" media="screen" rel="stylesheet" type="text/css" />
<link href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/geo-https.css" media="screen" rel="stylesheet" type="text/css" />
<link href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/buttons_new-https.css" media="screen" rel="stylesheet" type="text/css" />
        <style type="text/css">

        body { background: #FFFFFF; }



    </style>
      <link href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/signupflow-https.css" media="screen, projection" rel="stylesheet" type="text/css" />

  </head>

  <body class="account chrome" id="new">    <div class="fixed-banners">


    </div>
    <script type="text/javascript">
//<![CDATA[
if (window.top !== window.self) {document.write = "";window.top.location = window.self.location; setTimeout(function(){document.body.innerHTML='';},1);window.self.onload=function(evt){document.body.innerHTML='';};}
//]]>
</script>



    




    <div id="container" class="subpage">
            <span id="loader" style="display:none"><img alt="Loader" src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/loader.gif" /></span>
      <div class="clearfix no-nav" id="header">
  <a href="/tplan/main.php" title="PEPlanning / Home" accesskey="1" id="logo">
          <img alt="peplanning.org.uk" src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/index_files/bnb_logo.jpg" />
  </a>
  </div>





      <div class="content-bubble-arrow"></div>



        <table cellspacing="0" class="columns">
          <tbody>
            <tr>
              <td id="content" class="round-left column wide">
                                <div class="wrapper">




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
    <div id="topnav" class="topnav">
 <form action="/tplan/process.php" method="post"><div style="margin:0;padding:0">
  <fieldset class="common-form standard-form">

    <table cellspacing="0">
      <? if ($_GET['change']=="no"){?>
      <tr>
          <th></th>
         <td>
            <label class="error">
                An error has oocurred in this process.<br>Please try again later or contact your system adminstrator
            </label>
         </td>
      </tr>
      <? }?>
        <tr>
        <th><label for="email">Username</label></th>
        <td><input id="username" name="username" type="text" value="<? echo $_SESSION['form_values']['username']?>" /></td>
      </tr>
      <tr>
        <th></th>
        <td class="error"><? echo $_SESSION['form_errors']['username']?></td>
      </tr>
      <tr>
        <th><label for="email">Email</label></th>
        <td><input id="email" name="email" type="text" value="<? echo $_SESSION['form_values']['email']?>" /></td>
      </tr>
        <tr>
        <th></th>
        <td class="error"><? echo $_SESSION['form_errors']['email']?></td>
      </tr>
      <tr>
        <th></th>
        <td><input id="password_submit" value="Submit" tabindex="3" type="submit" />
            <input id="subforgot" name="subforgot" type="hidden" value="1"/></td>

      </tr>
      <tr>
          <th></th>
        </tr>
    </table>
  </fieldset>
</form>



   </div>
</div></td</tr>
</tbody>
</table>
<hr />
</div>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/pep-https.js" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery.tipsy.min.js" type="text/javascript"></script>
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/gears_init.js" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/mustache.js" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/geov1.js" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/api.js" type="text/javascript"></script>

  
      




    <div id="notifications"></div>






  </body>

</html>
<? unset($_SESSION['form_errors']);
   unset($_SESSION['form_values']);
   ?>