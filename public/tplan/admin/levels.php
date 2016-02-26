<?php  session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . '/../library/tplan_config.php'); 
include("session.php");
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include('mysqli_dbconnect.php');
include ("functions.php");
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

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

$maxRows_levels = 10;
$pageNum_levels = 0;
if (isset($_GET['pageNum_levels'])) {
  $pageNum_levels = $_GET['pageNum_levels'];
}
$startRow_levels = $pageNum_levels * $maxRows_levels;


$query_levels = "SELECT * FROM `level`";
$query_limit_levels = sprintf("%s LIMIT %d, %d", $query_levels, $startRow_levels, $maxRows_levels);
$levels = mysqli_query($tp, $query_limit_levels) or die(mysqli_error());
$row_levels = mysqli_fetch_assoc($levels);

if (isset($_GET['totalRows_levels'])) {
  $totalRows_levels = $_GET['totalRows_levels'];
} else {
  $all_levels = mysqli_query($tp, $query_levels);
  $totalRows_levels = mysqli_num_rows($all_levels);
}
$totalPages_levels = ceil($totalRows_levels/$maxRows_levels)-1;

$queryString_levels = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_levels") == false && 
        stristr($param, "totalRows_levels") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_levels = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_levels = sprintf("&totalRows_levels=%d%s", $totalRows_levels, $queryString_levels);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Levels</title>
</head>
<script src="../code/javascripts.js"></script>
<body>
<table border="1" align="center">
  <tr>
    <td>level</td>
    <td>description</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="level_update.php?recordID=<?php echo $row_levels['id']; ?>"> <?php echo $row_levels['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_levels['description']; ?>&nbsp; </td>
	  <td><label onclick="DeleteTableItem('level',<?php echo $row_levels['id'];?>,'<?php echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
    </tr>
    <?php } while ($row_levels = mysqli_fetch_assoc($levels)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_levels > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_levels=%d%s", $currentPage, 0, $queryString_levels); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_levels > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_levels=%d%s", $currentPage, max(0, $pageNum_levels - 1), $queryString_levels); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_levels < $totalPages_levels) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_levels=%d%s", $currentPage, min($totalPages_levels, $pageNum_levels + 1), $queryString_levels); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_levels < $totalPages_levels) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_levels=%d%s", $currentPage, $totalPages_levels, $queryString_levels); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_levels + 1) ?> to <?php echo min($startRow_levels + $maxRows_levels, $totalRows_levels) ?> of <?php echo $totalRows_levels ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php
mysqli_free_result($levels);
}
?>
