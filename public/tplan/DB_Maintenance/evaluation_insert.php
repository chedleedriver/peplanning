<?php  session_start();
virtual('/tplan/Connections/tp.php');
include('session.php');
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO evaluation (`evaluation`) VALUES (%s)",
                       GetSQLValueString(serialize($_POST['description']), "text"));

  mysql_select_db($database_tp, $tp);
  $Result1 = mysql_query($insertSQL, $tp) or die(mysql_error());

  $insertGoTo = "evaluation_insert.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  // header(sprintf("Location: %s", $updateGoTo));
	echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/evaluation_insert.php\">");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Evaluation Insert</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Evaluation:</td></tr>
      <tr><td><input type="text" name="description[0]" value="" size="128" maxlength="512" /></td></tr>
      <tr><td><input type="text" name="description[1]" value="" size="128" maxlength="512" /></td></tr>
      <tr><td><input type="text" name="description[2]" value="" size="128" maxlength="512" /></td></tr>
      <tr><td><input type="text" name="description[3]" value="" size="128" maxlength="512" /></td></tr>
      <tr><td><input type="text" name="description[4]" value="" size="128" maxlength="512" /></td></tr>
      <tr><td><input type="text" name="description[5]" value="" size="128" maxlength="512" /></td></tr>
      <tr><td><input type="text" name="description[6]" value="" size="128" maxlength="512" /></td></tr>
      <tr><td><input type="text" name="description[7]" value="" size="128" maxlength="512" /></td></tr>
      <tr><td><input type="text" name="description[8]" value="" size="128" maxlength="512" /></td></tr>
      <tr><td><input type="text" name="description[9]" value="" size="128" maxlength="512" /></td></tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"/></td>
    </tr>
 	    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><a href="evaluations.php">evaluation List</a></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><a href="index.php">Menu</a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1"/>
</form>
<p>&nbsp;</p>
</body>
</html>
<? }
