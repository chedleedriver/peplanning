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
  $insertSQL = sprintf("INSERT INTO help (name, `text`) VALUES (%s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString(base64_encode(serialize($_POST['help_text'])), "text"));

  
  $Result1 = mysqli_query($tp, $insertSQL) or die(mysqli_error());

  $insertGoTo = "help_insert.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  // header(sprintf("Location: %s", $updateGoTo));
	echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/help_insert.php\">");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Help Insert</title>
<script type="text/javascript" src="../editor/editor.js"></script>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr>
      <td nowrap align="right">Field Name:</td>
      <td><input type="text" name="name" value="" size="32"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr>
      <td nowrap align="right">help text:</td>
      <td><input type="text" name="help_text[]" value="" size="128"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
 	    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><a href="help_list.php">Help List</a></td>
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
