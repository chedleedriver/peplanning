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
$genre_id = $_GET['recordID'];
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE genre SET description=%s WHERE id=%s",
                       GetSQLValueString($_POST['genre'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_tp, $tp);
  $Result1 = mysql_query($updateSQL, $tp) or die(mysql_error());
  $level_array=array('0.0','1.0','1.5','2.0','2.5','3.0','3.5','4.0');
  $i=0;
  foreach($level_array as $genre_level){
      $genre_description=$_POST['description'][$i];
      $updateGD="update genre_description set genre_description='$genre_description' where genre_id=$genre_id and genre_level=$genre_level";
      $gd_result=mysql_query($updateGD, $tp) or die(mysql_error());
      $i++;
  }
  echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/genres.php\">");

}
mysql_select_db($database_tp, $tp);
$query_genre = "SELECT * FROM genre where id = $genre_id";
$genre = mysql_query($query_genre, $tp) or die(mysql_error());
$row_genre = mysql_fetch_assoc($genre);
$totalRows_genre = mysql_num_rows($genre);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Update Genre</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Genre:</td>
      <td><input type="text" name="genre" value="<?php echo $row_genre['description']; ?>" size="128"></td>
    </tr>
    
    <? mysql_select_db($database_tp, $tp);
$query_genre_description = "SELECT genre_description,genre_level FROM genre_description where genre_id = $genre_id order by genre_level";
$genre_description_result = mysql_query($query_genre_description, $tp) or die(mysql_error());
while (list ($genre_description,$level)=mysql_fetch_array($genre_description_result)){?>
   <tr>
        <td>Level <?echo $level?> Description</td>
        <td>
            <input type="text" name="description[]" value="<?php echo $genre_description; ?>" size="128" />
        </td>
    </tr>
<? }?>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Update record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="id" value="<?php echo $row_genre['id']; ?>">
</form>
</table>
</body>
</html>
<?php
mysql_free_result($genre);
}
?>