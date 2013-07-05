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
  $insertSQL = sprintf("INSERT INTO topic (name,genre,status) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['topic_name'], "text"),
                       GetSQLValueString($_POST['genre'], "text"),
                       GetSQLValueString($_POST['status'], "text"));

  mysql_select_db($database_tp, $tp);
  $Result1 = mysql_query($insertSQL, $tp) or die(mysql_error());
  $topic_id=mysql_insert_id($tp);
  $level_array=array('0.0','1.0','1.5','2.0','2.5','3.0','3.5','4.0');
  $i=0;
  foreach($level_array as $topic_level){
      $topic_description=$_POST['description'][$i];
      $insertGD="insert into topic_description (topic_id,topic_description,topic_level) values ($topic_id,'$topic_description',$topic_level)";
      $gd_result=mysql_query($insertGD, $tp) or die(mysql_error());
      $i++;
  }
  $insertGoTo = "topic_insert.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  // header(sprintf("Location: %s", $updateGoTo));
	echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/topic_insert.php\">");
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Insert Topic</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Name:</td>
      <td><input type="text" name="topic_name" value="" size="128"></td>
    </tr>

    <? $level_array=array('0.0','1.0','1.5','2.0','2.5','3.0','3.5','4.0');
       foreach($level_array as $genre_level) {?>
   <tr>
        <td>Level <?echo $genre_level?> Description</td>
        <td>
            <input type="text" name="description[]" value="" size="128" />
        </td>
    </tr>
<? }?>
    <tr valign="baseline">
      <td nowrap align="right">Genre:</td>
      <td><select name="genre">
	  <? $get_genres="select * from genre"; mysql_select_db($database_tp, $tp);
  $genre_result = mysql_query($get_genres, $tp) or die(mysql_error()); while (list($genre_id,$description) = mysql_fetch_array($genre_result)) {?>
<option value=<? echo $genre_id?>><? echo $description?></option><? }?></select></td>
    </tr>
    <tr>
        <td>
            <select name="status">
                <option value="D">Development</option>
                <option value="L">Live</option>
                <option value="M">Maintenance</option>
                <option value="R">Restricted</option>
            </select>
        </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Insert record"></td>
    </tr>
	    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><a href="topics.php">Topic List</a></td>
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