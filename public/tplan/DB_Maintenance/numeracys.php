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

$maxRows_numeracy = 10;
$pageNum_numeracy = 0;
if (isset($_GET['pageNum_numeracy'])) {
  $pageNum_numeracy = $_GET['pageNum_numeracy'];
}
$startRow_numeracy = $pageNum_numeracy * $maxRows_numeracy;

mysql_select_db($database_tp, $tp);
$query_numeracy = "SELECT * FROM numeracy";
$query_limit_numeracy = sprintf("%s LIMIT %d, %d", $query_numeracy, $startRow_numeracy, $maxRows_numeracy);
$numeracy = mysql_query($query_limit_numeracy, $tp) or die(mysql_error());
$row_numeracy = mysql_fetch_assoc($numeracy);

if (isset($_GET['totalRows_numeracy'])) {
  $totalRows_numeracy = $_GET['totalRows_numeracy'];
} else {
  $all_numeracy = mysql_query($query_numeracy);
  $totalRows_numeracy = mysql_num_rows($all_numeracy);
}
$totalPages_numeracy = ceil($totalRows_numeracy/$maxRows_numeracy)-1;

$queryString_numeracy = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_numeracy") == false && 
        stristr($param, "totalRows_numeracy") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_numeracy = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_numeracy = sprintf("&totalRows_numeracy=%d%s", $totalRows_numeracy, $queryString_numeracy);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<script src="../code/javascripts.js"></script>
<body>
<table border="1" align="center">
  <tr>
    <td>id</td>
    <td>description</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="numeracy_update.php?recordID=<?php echo $row_numeracy['id']; ?>"> <?php echo $row_numeracy['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_numeracy['description']; ?>&nbsp; </td>
	  <td><label onclick="DeleteTableItem('numeracy',<? echo $row_numeracy['id'];?>,'<? echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
    </tr>
    <?php } while ($row_numeracy = mysql_fetch_assoc($numeracy)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_numeracy > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_numeracy=%d%s", $currentPage, 0, $queryString_numeracy); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_numeracy > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_numeracy=%d%s", $currentPage, max(0, $pageNum_numeracy - 1), $queryString_numeracy); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_numeracy < $totalPages_numeracy) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_numeracy=%d%s", $currentPage, min($totalPages_numeracy, $pageNum_numeracy + 1), $queryString_numeracy); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_numeracy < $totalPages_numeracy) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_numeracy=%d%s", $currentPage, $totalPages_numeracy, $queryString_numeracy); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_numeracy + 1) ?> to <?php echo min($startRow_numeracy + $maxRows_numeracy, $totalRows_numeracy) ?> of <?php echo $totalRows_numeracy ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php
mysql_free_result($numeracy);
}
?>
