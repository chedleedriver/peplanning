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

$maxRows_points = 10;
$pageNum_points = 0;
if (isset($_GET['pageNum_points'])) {
  $pageNum_points = $_GET['pageNum_points'];
}
$startRow_points = $pageNum_points * $maxRows_points;


$query_points = "SELECT * FROM point";
$query_limit_points = sprintf("%s LIMIT %d, %d", $query_points, $startRow_points, $maxRows_points);
$points = mysqli_query($tp, $query_limit_points) or die(mysqli_error());
$row_points = mysqli_fetch_assoc($points);

if (isset($_GET['totalRows_points'])) {
  $totalRows_points = $_GET['totalRows_points'];
} else {
  $all_points = mysqli_query($tp, $query_points);
  $totalRows_points = mysqli_num_rows($all_points);
}
$totalPages_points = ceil($totalRows_points/$maxRows_points)-1;

$queryString_points = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_points") == false && 
        stristr($param, "totalRows_points") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_points = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_points = sprintf("&totalRows_points=%d%s", $totalRows_points, $queryString_points);
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
    <td>point_id</td>
    <td>point</td>
    <td>genre_id</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="point_update.php?recordID=<?php echo $row_points['id']; ?>"> <?php echo $row_points['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_points['point']; ?>&nbsp; </td>
      <td><?php echo $row_points['genre_id']; ?>&nbsp; </td>
      <td><label onclick="DeleteTableItem('point',<?php echo $row_points['id'];?>,'<?php echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
	</tr>
    <?php } while ($row_points = mysqli_fetch_assoc($points)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_points > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_points=%d%s", $currentPage, 0, $queryString_points); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_points > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_points=%d%s", $currentPage, max(0, $pageNum_points - 1), $queryString_points); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_points < $totalPages_points) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_points=%d%s", $currentPage, min($totalPages_points, $pageNum_points + 1), $queryString_points); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_points < $totalPages_points) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_points=%d%s", $currentPage, $totalPages_points, $queryString_points); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_points + 1) ?> to <?php echo min($startRow_points + $maxRows_points, $totalRows_points) ?> of <?php echo $totalRows_points ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php
mysqli_free_result($points);
}
?>
