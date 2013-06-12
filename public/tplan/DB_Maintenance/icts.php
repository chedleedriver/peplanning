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

$maxRows_ict = 10;
$pageNum_ict = 0;
if (isset($_GET['pageNum_ict'])) {
  $pageNum_ict = $_GET['pageNum_ict'];
}
$startRow_ict = $pageNum_ict * $maxRows_ict;

mysql_select_db($database_tp, $tp);
$query_ict = "SELECT * FROM ICT";
$query_limit_ict = sprintf("%s LIMIT %d, %d", $query_ict, $startRow_ict, $maxRows_ict);
$ict = mysql_query($query_limit_ict, $tp) or die(mysql_error());
$row_ict = mysql_fetch_assoc($ict);

if (isset($_GET['totalRows_ict'])) {
  $totalRows_ict = $_GET['totalRows_ict'];
} else {
  $all_ict = mysql_query($query_ict);
  $totalRows_ict = mysql_num_rows($all_ict);
}
$totalPages_ict = ceil($totalRows_ict/$maxRows_ict)-1;

$queryString_ict = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_ict") == false && 
        stristr($param, "totalRows_ict") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_ict = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_ict = sprintf("&totalRows_ict=%d%s", $totalRows_ict, $queryString_ict);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>ICT</title>
</head>
<script src="../code/javascripts.js"></script>
<body>
<table border="1" align="center">
  <tr>
    <td>ict_id</td>
    <td>description</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="ict_update.php?recordID=<?php echo $row_ict['id']; ?>"> <?php echo $row_ict['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_ict['description']; ?>&nbsp; </td>
	  <td><label onclick="DeleteTableItem('ict',<? echo $row_ict['id'];?>,'<? echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
    </tr>
    <?php } while ($row_ict = mysql_fetch_assoc($ict)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_ict > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_ict=%d%s", $currentPage, 0, $queryString_ict); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_ict > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_ict=%d%s", $currentPage, max(0, $pageNum_ict - 1), $queryString_ict); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ict < $totalPages_ict) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_ict=%d%s", $currentPage, min($totalPages_ict, $pageNum_ict + 1), $queryString_ict); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_ict < $totalPages_ict) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_ict=%d%s", $currentPage, $totalPages_ict, $queryString_ict); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_ict + 1) ?> to <?php echo min($startRow_ict + $maxRows_ict, $totalRows_ict) ?> of <?php echo $totalRows_ict ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php }
mysql_free_result($ict);
?>
