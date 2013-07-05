<?php include('functions.php');
include('session.php');
$school_id=$_GET['school_id'];
if($school_id) $schoolinfo=$database->getSchoolInfo($school_id);
//print_r($schoolinfo);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
   <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>" type="text/javascript"></script>
   <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>" type="text/javascript"></script>
   <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/realtime_db_scripts.js?<?=time()?>" type="text/javascript"></script>
        <form action="../process.php" method="POST">
<table align="left" border="0" cellspacing="10" cellpadding="3">
    <?php
    if($school_id) {$schoolinfo=$database->getSchoolInfo($school_id);
    for ($i=1;$i<=$schoolinfo['classnum'];$i++){?>
<tr>
<td>Username:</td>
<td><input type="text" id="username_<?php echo $i?>" name="username[]" value="" onChange="javascript:lookUp('username',this.value,this.id)">
</td>
</tr>
<tr>
<td>Password:</td>
<td><input type="text" name="password[]" value="">
</td>
</tr>
<tr>
<td>Name:</td>
<td><input type="text" name="name[]" maxlength="30" value=""/>
</td>

<td></td>
</tr>
<?php }} else {?>
<tr>
<td>Username:</td>
<td><input type="text" id ="username" name="username" value="" onChange="javascript:lookUp('username',this.value,this.id)">
</td>
</tr>
<tr>
<td>Password:</td>
<td><input type="text" name="password" value="">
</td>
</tr>
<tr>
<td>Name:</td>
<td><input type="text" name="name" maxlength="30" value=""/>
</td>

<td></td>
</tr>
<?php }?>
<tr>
<td>Telephone:</td>
<td><input type="text" name="telephone" maxlength="30" value="<?php echo $schoolinfo['telephone']?>">
</td>
<td></td>
</tr>
<tr>
<td>School:</td>
<td><input type="text" name="school" maxlength="30" value="<?php echo $schoolinfo['school']?>">
</td>
<td></td>
</tr>
<tr>

<td>Postcode:</td>
<td><input type="text" name="postcode" maxlength="30" value="<?php echo $schoolinfo['postcode']?>">
</td>
<td></td>
</tr>
<tr>
<td>Email:</td>
<td><input type="text" name="email" size="30" maxlength="80" value="<?php echo $schoolinfo['email']?>">
</td>
<td></td>
</tr>
<tr>
<td>Access Level (9=admin):</td>
<td><input type="text" name="userlevel" size="30" maxlength="80" value="">
</td>
<td></td>
</tr>
<tr><td colspan="2" align="right">
<input type="hidden" name="subusercreate" value="1">
<input type="submit" value="Create User(s)"></td></tr>
</table>
</form>
    </body>
</html>
