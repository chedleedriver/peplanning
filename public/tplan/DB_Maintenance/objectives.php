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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_objectives = 10;
$pageNum_objectives = 0;
if (isset($_GET['pageNum_objectives'])) {
  $pageNum_objectives = $_GET['pageNum_objectives'];
}
$startRow_objectives = $pageNum_objectives * $maxRows_objectives;

mysql_select_db($database_tp, $tp);
$query_objectives = "SELECT * FROM objectives";
$query_limit_objectives = sprintf("%s LIMIT %d, %d", $query_objectives, $startRow_objectives, $maxRows_objectives);
$objectives = mysql_query($query_limit_objectives, $tp) or die(mysql_error());
$row_objectives = mysql_fetch_assoc($objectives);

if (isset($_GET['totalRows_objectives'])) {
  $totalRows_objectives = $_GET['totalRows_objectives'];
} else {
  $all_objectives = mysql_query($query_objectives);
  $totalRows_objectives = mysql_num_rows($all_objectives);
}
$totalPages_objectives = ceil($totalRows_objectives/$maxRows_objectives)-1;

$queryString_objectives = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_objectives") == false && 
        stristr($param, "totalRows_objectives") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_objectives = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_objectives = sprintf("&totalRows_objectives=%d%s", $totalRows_objectives, $queryString_objectives);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Objectives List</title>
</head>
<script src="../code/javascripts.js"></script>
<body>
<table border="1" align="center">
  <tr>
    <td>id</td>
    <td>objective</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="objectives_update.php?recordID=<?php echo $row_objectives['id']; ?>"> <?php echo $row_objectives['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_objectives['objective']; ?>&nbsp; </td>
      <td><?php echo $row_points['genre_id']; ?>&nbsp; </td>
	  <td><label onclick="DeleteTableItem('objectives',<? echo $row_objectives['id'];?>,'<? echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
    </tr>
    <?php } while ($row_objectives = mysql_fetch_assoc($objectives)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_objectives > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_objectives=%d%s", $currentPage, 0, $queryString_objectives); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_objectives > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_objectives=%d%s", $currentPage, max(0, $pageNum_objectives - 1), $queryString_objectives); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_objectives < $totalPages_objectives) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_objectives=%d%s", $currentPage, min($totalPages_objectives, $pageNum_objectives + 1), $queryString_objectives); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_objectives < $totalPages_objectives) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_objectives=%d%s", $currentPage, $totalPages_objectives, $queryString_objectives); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_objectives + 1) ?> to <?php echo min($startRow_objectives + $maxRows_objectives, $totalRows_objectives) ?> of <?php echo $totalRows_objectives ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php
mysql_free_result($objectives);
}
?>
