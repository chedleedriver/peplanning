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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE `level` SET `description`=%s WHERE `id`=%s",
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['level'], "double"));

  mysql_select_db($database_tp, $tp);
  $Result1 = mysql_query($updateSQL, $tp) or die(mysql_error());

  $updateGoTo = "levels.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  // header(sprintf("Location: %s", $updateGoTo));
	echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/levels.php\">");
}
$level = $_GET['recordID'];
mysql_select_db($database_tp, $tp);
$query_level_update = "SELECT * FROM `level` where id=$level";
$level_update = mysql_query($query_level_update, $tp) or die(mysql_error());
$row_level_update = mysql_fetch_assoc($level_update);
$totalRows_level_update = mysql_num_rows($level_update);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Level:</td>
      <td><?php echo $row_level_update['level_id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Description:</td>
      <td><input type="text" name="description" value="<?php echo $row_level_update['description']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="level" value="<?php echo $row_level_update['level_id']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($level_update); }
?>
