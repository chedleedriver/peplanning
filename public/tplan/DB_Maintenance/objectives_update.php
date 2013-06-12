<?php  session_start();
virtual('/tplan/Connections/tp.php');
include('session.php');
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include ("functions.php");
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
  $updateSQL = sprintf("UPDATE objectives SET objective=%s, genre_id=%s, topic_id=%s WHERE id=%s",
                       GetSQLValueString($_POST['objective'], "text"),
                       GetSQLValueString($_POST['genre_id'], "int"),
                       GetSQLValueString($_POST['topics'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_tp, $tp);
  $Result1 = mysql_query($updateSQL, $tp) or die(mysql_error());
  if ($_POST['themes']) Update_theme_objectives($_POST['themes'],$_POST['id']);
  //print_r($_POST);
  $updateGoTo = "objectives.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  //echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/objectives.php\">");

}
$objective_id = $_GET['recordID'];
mysql_select_db($database_tp, $tp);
$query_objective_update = "SELECT * FROM objectives where id=$objective_id";
$objective_update = mysql_query($query_objective_update, $tp) or die(mysql_error());
$row_objective_update = mysql_fetch_assoc($objective_update);
$totalRows_objective_update = mysql_num_rows($objective_update);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="../code/javascripts.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Objective Update</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Objective:</td>
      <td><input type="text" name="objective" value="<?php echo $row_objective_update['objective']; ?>" size="32"></td>
    </tr>
 	 <tr valign="baseline">
      <td nowrap align="right">Genre:</td>
      <td><select id="genre_id" name="genre_id"><? GetGenres($row_point_update['genre_id']);?></select></td>
    </tr>
	 <tr valign="baseline">
      <td nowrap align="right">Themes:</td>
      <td><select name="themes[]" multiple="multiple" size="20"><? GetObjectiveThemes($objective_id)?></select></td>
    </tr>
	 <tr valign="baseline">
      <td nowrap align="right">Topics:</td>
      <td><select name="topics" size="20"><? GetObjectiveTopics($objective_id)?></select></td>
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
  <input type="hidden" name="id" value="<?php echo $row_objective_update['id']; ?>">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($objective_update);
}
?>
