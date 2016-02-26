<?php  session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . '/../library/tplan_config.php'); 
include("session.php");
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include('mysqli_dbconnect.php');
include ("functions.php");
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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
  $insertSQL = sprintf("INSERT INTO theme (id, theme, `description`) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['theme'], "text"),
                       GetSQLValueString(serialize($_POST['description']), "text"));

  
  $Result1 = mysqli_query($tp, $insertSQL) or die(mysqli_error());

  $insertGoTo = "/tplan/DB_Maintenance/themes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
//  header(sprintf("Location: %s", $updateGoTo));
	echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/theme_insert.php\">");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Insert Theme</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Theme:</td>
      <td><input type="text" name="theme" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Description:</td>
      <td><table>
	  <?php $description=unserialize($row_theme_update['description']);?>
      <tr><td><input type="text" name="description[0]" size="128" value="<?php echo $description[0]?>" /></td></tr>
      <tr><td><input type="text" name="description[1]" size="128" value="<?php echo $description[1]?>"  /></td></tr>
      <tr><td><input type="text" name="description[2]" size="128" value="<?php echo $description[2]?>"  /></td></tr>
      <tr><td><input type="text" name="description[3]" size="128" value="<?php echo $description[3]?>"  /></td></tr>
      <tr><td><input type="text" name="description[4]" size="128" value="<?php echo $description[4]?>"  /></td></tr>
      <tr><td><input type="text" name="description[5]" size="128" value="<?php echo $description[5]?>"  /></td></tr>
      <tr><td><input type="text" name="description[6]" size="128" value="<?php echo $description[6]?>"  /></td></tr>
      <tr><td><input type="text" name="description[7]" size="128" value="<?php echo $description[7]?>"  /></td></tr>
      <tr><td><input type="text" name="description[8]" size="128" value="<?php echo $description[8]?>"  /></td></tr>
      <tr><td><input type="text" name="description[9]" size="128" value="<?php echo $description[9]?>"  /></td></tr>
    </table></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><a href="themes.php">Theme List</a></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><a href="index.php">Menu</a></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php }