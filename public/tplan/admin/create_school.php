<?php include('functions.php');
include('session.php');
//print_r($_SESSION);
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
<tr>
<td>School:</td>
<td><input type="text" id="school" name="school" value="" onChange="javascript:lookUp('school',this.value,this.id)">
</td>
</tr>
<tr>
<td>Address:</td>
<td><input type="text" name="address1" maxlength="30" value=""/>
</td>
<td></td>
</tr>
<tr>
<td>Address:</td>
<td><input type="text" name="address2" maxlength="30" value=""/>
</td>
<td></td>
</tr><tr>
<td>Address:</td>
<td><input type="text" name="address3" maxlength="30" value=""/>
</td>
<td></td>
</tr>
<tr>
<td>Postcode:</td>
<td><input type="text" name="postcode" maxlength="30" value="">
</td>
<td></td>
</tr><tr>
<td>Telephone:</td>
<td><input type="text" name="telephone" maxlength="30" value="">
</td>
<td></td>
</tr>
<tr>
<td>Email:</td>
<td><input type="text" name="email" size="30" maxlength="80" value="">
</td>
<td></td>
</tr>
<tr>
<td>Contact:</td>
<td><input type="text" name="contact" size="30" maxlength="80" value="">
</td>
<td></td>
</tr>
<tr>
<td>Subscription from (dd-mm-yyyy)</td>
<td><input type="text" name="subfrom" size="30" maxlength="80" value="">
</td>
<td></td>
</tr>
<tr>
<tr>
<td>Subscription to (dd-mm-yyyy)</td>
<td><input type="text" name="subto" size="30" maxlength="80" value="">
</td>
<td></td>
</tr>
<tr>
<td>Number of Classes</td>
<td><input type="text" name="classnum" size="30" maxlength="80" value="">
</td>
<td></td>
</tr>
<tr>
<td>Total Cost</td>
<td><input type="text" name="totalcost" size="30" maxlength="80" value="">
</td>
<td></td>
</tr>
<tr><td colspan="2" align="right">
<input type="hidden" name="subschoolcreate" value="1">
<input type="submit" value="Create School"></td></tr>
</table>
</form>
    </body>
</html>
