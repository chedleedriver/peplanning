<?php
include ("basefunctions.php");
include ("session.php");
if (isset($_GET['email_address']) && preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $_GET['email_address']))
{
 $email = $_GET['email_address'];
}
if (isset($_GET['key']) && (strlen($_GET['key']) == 32))
{
 $key = $_GET['key'];
}
if (isset($email) && isset($key)) {
 $get_user_info="select username,password from users WHERE (email ='$email' AND activation='$key') LIMIT 1";
 $result_user_info = mysql_query($get_user_info) or die("Error reported while excetung the statement; $get_user_info<br />MySQL reportedL  ".mysql_error());
 list($username,$password)=mysql_fetch_array($result_user_info);
 $query_activate_account = "UPDATE users SET activation=NULL WHERE (email ='$email' AND activation='$key') LIMIT 1";
 $result_activate_account = mysql_query($query_activate_account) or die("Error reported while executing the statement; $query_activate_account<br />MySQL reportedL  ".mysql_error());
 }

$session->login($username,$password,1);
?><!DOCTYPE HTML PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
                    <html dir="ltr" xml:lang="en-GB" xmlns="http://www.w3.org/1999/xhtm" lang="en-GB">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
                        <meta http-equiv="X-UA-Compatible" content="IE=8" />
                        <title>PE Planning | Account Activation</title>
                        <link href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/pep-https.css" media="screen" rel="stylesheet" type="text/css" />


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

    </p>
    <h2>PE Planning Account Activation</h2></div>
                                            <?if ($result_activate_account==1)
                                            {
                                                echo "<p>Your account is now active.<br><br>  By logging onto your account, you are confirming that you have read and agree to abide by our Terms & Conditions of Use as set out on our Website homepage and <a href='http://". $_SERVER['SERVER_NAME']."/tplan/termsandconditions.html' target=_new>here</a><br><br></p>";
                                            }
                                            else
                                            {
                                                echo '<p>Oops !Your account could not be activated.<br> Please recheck the link or contact the system administrator.</p>';
                                            }?>
                                  <p>
                                      We hope you enjoy using this site!  You may now <a href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/main.php#feature-plan"> Log in</a>
                                   </p>
                               </div>
                        
                      </body>
                    </html>
