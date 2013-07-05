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

$maxRows_help = 10;
$pageNum_help = 0;
if (isset($_GET['pageNum_help'])) {
  $pageNum_help = $_GET['pageNum_help'];
}
$startRow_help = $pageNum_help * $maxRows_help;

mysql_select_db($database_tp, $tp);
$query_help = "SELECT * FROM help";
$query_limit_help = sprintf("%s LIMIT %d, %d", $query_help, $startRow_help, $maxRows_help);
$help = mysql_query($query_limit_help, $tp) or die(mysql_error());
$row_help = mysql_fetch_assoc($help);

if (isset($_GET['totalRows_help'])) {
  $totalRows_help = $_GET['totalRows_help'];
} else {
  $all_help = mysql_query($query_help);
  $totalRows_help = mysql_num_rows($all_help);
}
$totalPages_help = ceil($totalRows_help/$maxRows_help)-1;

$queryString_help = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_help") == false && 
        stristr($param, "totalRows_help") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_strands = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_help = sprintf("&totalRows_help=%d%s", $totalRows_help, $queryString_help);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Help List</title>
</head>
<script src="../code/javascripts.js"></script>
<body>
<table border="1" align="center">
  <tr>
    <td>name</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="help_update.php?name=<?php echo $row_help['name']; ?>"> <?php echo $row_help['name']; ?>&nbsp; </a> </td>
	  <td><label onclick="DeleteTableItem('help','<? echo $row_help['name'];?>','<? echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
    </tr>
    <?php } while ($row_help = mysql_fetch_assoc($help)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_help > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_help=%d%s", $currentPage, 0, $queryString_help); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_strands > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_help=%d%s", $currentPage, max(0, $pageNum_help - 1), $queryString_help); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_help < $totalPages_help) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_help=%d%s", $currentPage, min($totalPages_help, $pageNum_help + 1), $queryString_help); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_help < $totalPages_help) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_help=%d%s", $currentPage, $totalPages_help, $queryString_help); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_help + 1) ?> to <?php echo min($startRow_help + $maxRows_help, $totalRows_help) ?> of <?php echo $totalRows_help ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php
mysql_free_result($help);
}
?>
