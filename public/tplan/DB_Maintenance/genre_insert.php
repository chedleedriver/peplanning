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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO genre (description) VALUES (%s)",
                       GetSQLValueString($_POST['genre'], "text"));

  mysql_select_db($database_tp, $tp);
  $Result1 = mysql_query($insertSQL, $tp) or die(mysql_error());
  $genre_id=mysql_insert_id($tp);
  $level_array=array('0.0','1.0','1.5','2.0','2.5','3.0','3.5','4.0');
  $i=0;
  foreach($level_array as $genre_level){
      if ($_POST['description'][$i])$genre_description=$_POST['description'][$i]; else $genre_description='';
      $insertGD="insert into genre_description (genre_id,genre_description,genre_level) values ($genre_id,'$genre_description',$genre_level)";
      $gd_result=mysql_query($insertGD, $tp) or die(mysql_error());
      $i++;
  }
  $insertGoTo = "genre_insert.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  // header(sprintf("Location: %s", $updateGoTo));
	//echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/genre_insert.php\">");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Insert Genre</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Genre:</td>
      <td><input type="text" name="genre" value="" size="128"></td>
    </tr>

    <? $level_array=array('0.0','1.0','1.5','2.0','2.5','3.0','3.5','4.0');
       foreach($level_array as $genre_level) {?>
   <tr>
        <td>Level <?echo $genre_level?> Description</td>
        <td>
            <input type="text" name="description[]" value="" size="128" />
        </td>
    </tr>
<? }?> <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
	    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><a href="genres.php">Genre List</a></td>
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
