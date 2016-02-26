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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1"))
{
	
	mysqli_query($tp, "Delete from objective_topic_theme where objective_id=".$_POST['id']." and topic_id=".$_POST['topic_id']);
	foreach($_POST['year'] as $year) {
		$theme_name="theme_id_".$year;
		$notes_name="theme_notes_".$year;
		foreach($_POST[$theme_name] as $theme_id) {
	    $updateSQL = sprintf("INSERT into objective_topic_theme (objective_id,topic_id,theme_id,year,notes) values (%s,%s,%s,%s,%s)",
						   GetSQLValueString($_POST['id'], "int"),
						   GetSQLValueString($_POST['topic_id'], "int"),
						   GetSQLValueString($theme_id, "int"),
						   GetSQLValueString($year, "int"),
						   GetSQLValueString($_POST[$notes_name], "text"));
						   //GetSQLValueString($_POST['theme_notes'], "text"));
		//$updateSQL = "insert into objective_topic_theme (objective_id,topic_id,theme_id,notes) values ($objective_id,$topic_id,$theme_id,$theme_notes)";
		
		$Result1 = mysqli_query($tp, $updateSQL) or die(mysqli_error());
	  }
	}
  $updateGoTo = "objectives_2014.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  //echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/objectives_2014.php\">");

}
$objective_id = $_GET['objective_id'];

$query_objective_update = "SELECT * FROM objectives where id=$objective_id";
$objective_update = mysqli_query($tp, $query_objective_update) or die(mysqli_error());
$row_objective_update = mysqli_fetch_assoc($objective_update);
$totalRows_objective_update = mysqli_num_rows($objective_update);
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
     <td></td>
     
     <td>
<?php	echo "<select id='topic_id' onchange='getThemes(this.value,".$objective_id.")'\"> <option value=\"topic\">topic</option>";
	ChooseSomethingToEdit('topic');			
	echo "</select>";
?>
</td>
</tr>
	<tr>
    <td></td><td><div id='theme_div'>
    </div>
    </td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Assign"></td>
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
mysqli_free_result($objective_update);
}
?>
