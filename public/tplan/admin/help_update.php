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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE help SET text=%s WHERE name=%s",
                       GetSQLValueString(base64_encode(serialize($_POST['help_text'])), "text"),
                       GetSQLValueString($_POST['name'], "text"));

  
  $Result1 = mysqli_query($tp, $updateSQL) or die(mysqli_error());

  $updateGoTo = "help_list.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/help_list.php\">");

}
$help_name = $_GET['name'];

$query_help_update = "SELECT * FROM help where name='$help_name'";
$help_update = mysqli_query($tp, $query_help_update) or die(mysqli_error());
$row_help_update = mysqli_fetch_assoc($help_update);
$help_text=unserialize(base64_decode($row_help_update['text']));
$totalRows_help_update = mysqli_num_rows($help_update);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Help Maintenance</title>
<script type="text/javascript" src="../editor/editor.js"></script>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Field Name:</td>
      <td><input type="text" name="name" value="<?php echo $row_help_update['name']; ?>" size="32"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo stripslashes($help_text[0]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo stripslashes($help_text[1]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[2]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[3]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[4]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[5]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[6]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[7]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[8]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[9]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[10]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[11]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[12]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[13]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[14]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[15]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[16]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[17]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[18]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[19]); ?>" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="<?php echo  stripslashes($help_text[20]); ?>" size="128"></td>
    </tr>

    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php }
mysqli_free_result($help_update);
?>
