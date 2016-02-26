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
  $insertSQL = sprintf("INSERT INTO objectives (id, objective) VALUES (%s, %s)",
                       GetSQLValueString($_POST['id'], "int"),
                       GetSQLValueString($_POST['objective'], "text"));
                       //GetSQLValueString($_POST['topics'], "int"));

  
  $Result1 = mysqli_query($tp, $insertSQL) or die(mysqli_error());
  $objective_id = mysqli_insert_id();
  if ($_POST['themes']) Update_theme_objectives($_POST['themes'],$objective_id);
  if ($_POST['topics']) Update_topic_objectives($_POST['topics'],$objective_id);
  if ($_POST['genre_id']) Update_genre_objectives($_POST['genre_id'],$objective_id);
  $insertGoTo = "objective_insert.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  // header(sprintf("Location: %s", $updateGoTo));
	echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/objective_insert.php\">");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="../code/javascripts.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Insert Objective</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Objective:</td>
      <td><input type="text" name="objective" value="" size="32"/></td>
    </tr>
	 <tr valign="baseline">
      <td nowrap align="right">Genre:</td>
      <td><select name="genre_id[]" multiple="multiple" size="20"><?php GetGenres(0)?></select></td>
    </tr>
	 <tr valign="baseline">
      <td nowrap align="right">Themes:</td>
      <td><select name="themes[]" multiple="multiple" size="20"><?php GetObjectiveThemes(0)?></select></td>
    </tr>
    </tr>
	 <tr valign="baseline">
      <td nowrap align="right">Topics:</td>
      <td><select name="topics[]" multiple="multiple" size="20"><?php GetObjectiveTopics(0)?></select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"/></td>
    </tr>
 	    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><a href="objectives.php">Objective List</a></td>
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
<?php }