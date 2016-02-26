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
  $updateSQL = sprintf("UPDATE strand SET strand=%s, `description`=%s WHERE id=%s",
                       GetSQLValueString($_POST['strand'], "text"),
                       GetSQLValueString($_POST['description'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  
  $Result1 = mysqli_query($tp, $updateSQL) or die(mysqli_error());

  $updateGoTo = "strands.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/strands.php\">");

}
$strand_id = $_GET['recordID'];

$query_strand_update = "SELECT * FROM strand where id=$strand_id";
$strand_update = mysqli_query($tp, $query_strand_update) or die(mysqli_error());
$row_strand_update = mysqli_fetch_assoc($strand_update);
$totalRows_strand_update = mysqli_num_rows($strand_update);
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
      <td nowrap align="right">Strand:</td>
      <td><input type="text" name="strand" value="<?php echo $row_strand_update['strand']; ?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Description:</td>
      <td><input type="text" name="description" value="<?php echo $row_strand_update['description']; ?>" size="32" maxlength="256"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_strand_update['id']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysqli_free_result($strand_update);
}
?>
