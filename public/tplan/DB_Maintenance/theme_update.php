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
  $updateSQL = sprintf("UPDATE theme SET theme=%s, `description`=%s WHERE id=%s",
                       GetSQLValueString($_POST['theme'], "text"),
                       GetSQLValueString(serialize($_POST['description']), "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_tp, $tp);
  $Result1 = mysql_query($updateSQL, $tp) or die(mysql_error());

  echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/themes.php\">");
}
$theme_id=$_GET['recordID'];
mysql_select_db($database_tp, $tp);
$query_theme_update = "SELECT * FROM theme where id = $theme_id";
$theme_update = mysql_query($query_theme_update, $tp) or die(mysql_error());
$row_theme_update = mysql_fetch_assoc($theme_update);
$totalRows_theme_update = mysql_num_rows($theme_update);
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
      <td nowrap align="right">Theme_id:</td>
      <td><?php echo $row_theme_update['id']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Theme:</td>
      <td><input type="text" name="theme" value="<?php echo $row_theme_update['theme']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Description:</td>
      <td><table>
	  <? $description=unserialize($row_theme_update['description']);?>
      <tr><td><input type="text" name="description[0]" size="128" value="<? echo $description[0]?>" /></td></tr>
      <tr><td><input type="text" name="description[1]" size="128" value="<? echo $description[1]?>"  /></td></tr>
      <tr><td><input type="text" name="description[2]" size="128" value="<? echo $description[2]?>"  /></td></tr>
      <tr><td><input type="text" name="description[3]" size="128" value="<? echo $description[3]?>"  /></td></tr>
      <tr><td><input type="text" name="description[4]" size="128" value="<? echo $description[4]?>"  /></td></tr>
      <tr><td><input type="text" name="description[5]" size="128" value="<? echo $description[5]?>"  /></td></tr>
      <tr><td><input type="text" name="description[6]" size="128" value="<? echo $description[6]?>"  /></td></tr>
      <tr><td><input type="text" name="description[7]" size="128" value="<? echo $description[7]?>"  /></td></tr>
      <tr><td><input type="text" name="description[8]" size="128" value="<? echo $description[8]?>"  /></td></tr>
      <tr><td><input type="text" name="description[9]" size="128" value="<? echo $description[9]?>"  /></td></tr>
    </table>
	</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_theme_update['id']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($theme_update);
}
?>
