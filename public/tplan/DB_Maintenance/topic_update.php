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
$topic_id = $_GET['recordID'];
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE topic SET name=%s,description=%s,genre=%s,status=%s WHERE id=%s",
                       GetSQLValueString($_POST['topic_name'], "text"),
                       GetSQLValueString($_POST['topic_description'], "text"),
                       GetSQLValueString($_POST['genres'], "int"),
                       GetSQLValueString($_POST['status'], "text"),
					   GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_tp, $tp);
  $Result1 = mysql_query($updateSQL, $tp) or die(mysql_error());
  $level_array=array('0.0','1.0','1.5','2.0','2.5','3.0','3.5','4.0');
  $i=0;
  foreach($level_array as $topic_level){
      $topic_description=$_POST['description'][$i];
      $updateGD="update topic_description set topic_description='$topic_description' where topic_id=$topic_id and topic_level=$topic_level";
      $gd_result=mysql_query($updateGD, $tp) or die(mysql_error());
      $i++;
  }
  echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/topics.php\">");

}


mysql_select_db($database_tp, $tp);
$query_topic_update = "SELECT * FROM topic where topic.id = $topic_id";
$topic_update = mysql_query($query_topic_update, $tp) or die(mysql_error());
$row_topic_update = mysql_fetch_assoc($topic_update);
$totalRows_topic_update = mysql_num_rows($topic_update);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Update Topic</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
     <tr valign="baseline">
      <td nowrap align="right">Name:</td>
      <td><input type="text" name="topic_name" value="<?php echo $row_topic_update['name']; ?>" size="128" /><input type="hidden" name="topic_description" value="<?php echo $row_topic_update['description']; ?>" size="128" /></td>
    </tr>
   <? mysql_select_db($database_tp, $tp);
$query_topic_description = "SELECT topic_description,topic_level FROM topic_description where topic_id = $topic_id order by topic_level";
$topic_description_result = mysql_query($query_topic_description, $tp) or die(mysql_error());
while (list ($topic_description,$level)=mysql_fetch_array($topic_description_result)){?>
   <tr>
        <td>Level <?echo $level?> Description</td>
        <td>
            <input type="text" name="description[]" value="<?php echo $topic_description; ?>" size="128" />
        </td>
    </tr>
<? }?>
    
    <tr valign="baseline">
      <td nowrap align="right">Genre:</td>
	  <td><select name="genres">
	  <? $get_genres="select * from genre";
	  $genres=mysql_query($get_genres, $tp) or die(mysql_error());
	  while (list ($genre_id,$genre_description)=mysql_fetch_array($genres)) {?>
	  <option value="<? echo $genre_id?>" <? if ($genre_id==$row_topic_update['genre']) echo "selected=\"selected\""?>><? echo $genre_description?></option><? }?>
	  </select>
    <tr>
        <td nowrap align="right">Status:</td>
        <td>
            <select name="status">
                <option value="D" <? if ($row_topic_update['status']=="D") echo "selected=\"selected\""?>>Development</option>
                <option value="L" <? if ($row_topic_update['status']=="L") echo "selected=\"selected\""?>>Live</option>
                <option value="M" <? if ($row_topic_update['status']=="M") echo "selected=\"selected\""?>>Maintenance</option>
                <option value="R" <? if ($row_topic_update['status']=="R") echo "selected=\"selected\""?>>Restricted</option>
            </select>
        </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_topic_update['id']; ?>">
</form>
</table>
</body>
</html>
<?php
mysql_free_result($topic_update);
}
?>