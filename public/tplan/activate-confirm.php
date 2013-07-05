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
 $result_user_info = mysql_query($get_user_info) or die("Error reported while executing the statement; $get_user_info<br />MySQL reportedL  ".mysql_error());
list($username,$password)=mysql_fetch_array($result_user_info);

 $query_activate_account = "UPDATE users SET activation=NULL WHERE (email ='$email' AND activation='$key') LIMIT 1";
 $result_activate_account = mysql_query($query_activate_account) or die("Error reported while excetung the statement; $query_activate_account<br />MySQL reportedL  ".mysql_error());
 }
$session->activate_and_login($username,$password,false);
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | Activation Confirmation</title>
        <link href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" rel="stylesheet" type="text/css" media="screen"/>
        <link href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/signupflow-https.css?<?=time()?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/pep-https.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css" />
    </head>
    <body id="confirm">
<?php include("header.php");?>
    <div id="doc"  class="activation-confirmation">
<div class="content-heading">
  <div class="heading">
    <p class="sign-in">

    </p>
    <h2>PE Planning Account Activation</h2></div>
                                            <?if ($result_activate_account==1)
                                            {
                                                echo "<p>Your account is now active.<br><br>  By logging onto your account, you are confirming that you have read and agree to abide by our Terms & Conditions of Use as set out on our Website homepage and <a href='http://". $_SERVER['SERVER_NAME']."/tplan/termsandconditions.html' target=_new>here</a><br><br></p><p>
                                      We hope you enjoy using this site!  You may now <a href=\"https://". $_SERVER['SERVER_NAME']."/tplan/createplan.php\">start creating plans</a>
                                   </p>";
                                            }
                                            else
                                            {
                                                echo '<p>Oops !Your account could not be activated.<br> Please recheck the link or contact the <a href="mailto:admin@peplanning.org.uk">system administrator</a>.</p>';
                                            }?>
                                  
                               </div>
</div>
     <?php include("footer.php")?>
    </body>
</html>