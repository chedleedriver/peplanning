<?php  session_start();
virtual('/tplan/Connections/tp.php');
include('session.php');
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include ("functions.php");
$mode=$_GET['mode'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Choose <?php echo $mode?></title>
</head>
<script src="../code/javascripts.js"></script>
<body>
<table>
<tr><td>
<?php	echo "<select id='".$mode."' onchange=\"ReturnTo('".$mode."',this.value)\"> <option value=\"".$mode."\">".$mode."</option>";
	ChooseSomethingToEdit($mode);			
	echo "</select>";
?>
</td>
</tr>
</table>
</body>
</html>
<?php }
