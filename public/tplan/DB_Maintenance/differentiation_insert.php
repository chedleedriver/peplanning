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
print_r ($_POST);
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO differentiation (differentiation, difficulty, genre_id) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['differentiation'], "text"),
					   GetSQLValueString($_POST['difficulty'], "text"),
                       GetSQLValueString($_POST['genre_id'], "int"));

  mysql_select_db($database_tp, $tp);
  $Result1 = mysql_query($insertSQL, $tp) or die(mysql_error());

  $insertGoTo = "differentiation_insert.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  // header(sprintf("Location: %s", $updateGoTo));
	//echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/differentiation_insert.php\">");
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
      <td nowrap align="right">Differentiation:</td>
      <td><input type="text" name="differentiation" value="" size="128"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Difficulty:</td>
      <td><input type="text" name="difficulty" value="" size="1"></td>
    </tr>
	 <tr valign="baseline">
      <td nowrap align="right">Genre:</td>
      <td><select name="genre_id"><? GetGenres(0)?></select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
 	    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><a href="differentiations.php">Differentiation List</a></td>
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
<? }
