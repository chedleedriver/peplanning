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
  $updateSQL = sprintf("UPDATE differentiation SET differentiation=%s, difficulty=%s, genre_id=%s WHERE id=%s",
                       GetSQLValueString($_POST['differentiation'], "text"),
					   GetSQLValueString($_POST['difficulty'], "text"),
                       GetSQLValueString($_POST['genre_id'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  
  $Result1 = mysqli_query($tp, $updateSQL) or die(mysqli_error());

  $updateGoTo = "differentiations.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/differentiations.php\">");

}
$differentiation_id = $_GET['recordID'];

$query_differentiation_update = "SELECT * FROM differentiation where id=$differentiation_id";
$differentiation_update = mysqli_query($tp, $query_differentiation_update) or die(mysqli_error());
$row_differentiation_update = mysqli_fetch_assoc($differentiation_update);
$totalRows_differentiation_update = mysqli_num_rows($differentiation_update);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="../code/javascripts.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>differentiation Update</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">differentiation:</td>
      <td><input type="text" name="differentiation" value="<?php echo $row_differentiation_update['differentiation']; ?>" size="128"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">difficulty:</td>
      <td><input type="text" name="difficulty" value="<?php echo $row_differentiation_update['difficulty']; ?>" size="1"></td>
    </tr>
 	 <tr valign="baseline">
      <td nowrap align="right">Genre:</td>
      <td><select id="genre_id" name="genre_id"><?php GetGenres($row_point_update['genre_id']);?></select></td>
    </tr>
   <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
<tr>
<td><input type="button" id="return" id="return" onclick="ReturnTo('index',0)" value="return to menu" /></td>
</tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_differentiation_update['id']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php }
mysqli_free_result($differentiation_update);
?>
