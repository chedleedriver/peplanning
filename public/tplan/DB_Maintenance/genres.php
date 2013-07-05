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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_genre_list = 10;
$pageNum_genre_list = 0;
if (isset($_GET['pageNum_genre_list'])) {
  $pageNum_genre_list = $_GET['pageNum_genre_list'];
}
$startRow_genre_list = $pageNum_genre_list * $maxRows_genre_list;

mysql_select_db($database_tp, $tp);
$query_genre_list = "SELECT * FROM genre";
$query_limit_genre_list = sprintf("%s LIMIT %d, %d", $query_genre_list, $startRow_genre_list, $maxRows_genre_list);
$genre_list = mysql_query($query_limit_genre_list, $tp) or die(mysql_error());
$row_genre_list = mysql_fetch_assoc($genre_list);

if (isset($_GET['totalRows_genre_list'])) {
  $totalRows_genre_list = $_GET['totalRows_genre_list'];
} else {
  $all_genre_list = mysql_query($query_genre_list);
  $totalRows_genre_list = mysql_num_rows($all_genre_list);
}
$totalPages_genre_list = ceil($totalRows_genre_list/$maxRows_genre_list)-1;

$queryString_genre_list = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_genre_list") == false && 
        stristr($param, "totalRows_genre_list") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_genre_list = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_genre_list = sprintf("&totalRows_genre_list=%d%s", $totalRows_genre_list, $queryString_genre_list);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="../code/javascripts.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<table border="1" align="center">
  <tr>
    <td>id</td>
    <td>genre</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="genre_update.php?recordID=<?php echo $row_genre_list['id']; ?>"> <?php echo $row_genre_list['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_genre_list['description']; ?>&nbsp; </td>
    	<td><label onclick="DeleteTableItem('genre',<? echo $row_genre_list['id'];?>,'<? echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
    </tr>
    <?php } while ($row_genre_list = mysql_fetch_assoc($genre_list)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_genre_list > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_keywords_list=%d%s", $currentPage, 0, $queryString_genre_list); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_genre_list > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_genre_list=%d%s", $currentPage, max(0, $pageNum_genre_list - 1), $queryString_genre_list); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_genre_list < $totalPages_genre_list) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_genre_list=%d%s", $currentPage, min($totalPages_genre_list, $pageNum_genre_list + 1), $queryString_genre_list); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_genre_list < $totalPages_genre_list) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_genre_list=%d%s", $currentPage, $totalPages_genre_list, $queryString_genre_list); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_genre_list + 1) ?> to <?php echo min($startRow_genre_list + $maxRows_genres_list, $totalRows_genre_list) ?> of <?php echo $totalRows_genre_list ?>
<a href="index.php">Menu</a>
</body>
</html>
<?php
mysql_free_result($genre_list);
}
?>
