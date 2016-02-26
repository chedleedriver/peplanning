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

$maxRows_strands = 10;
$pageNum_strands = 0;
if (isset($_GET['pageNum_strands'])) {
  $pageNum_strands = $_GET['pageNum_strands'];
}
$startRow_strands = $pageNum_strands * $maxRows_strands;


$query_strands = "SELECT * FROM strand";
$query_limit_strands = sprintf("%s LIMIT %d, %d", $query_strands, $startRow_strands, $maxRows_strands);
$strands = mysqli_query($tp, $query_limit_strands) or die(mysqli_error());
$row_strands = mysqli_fetch_assoc($strands);

if (isset($_GET['totalRows_strands'])) {
  $totalRows_strands = $_GET['totalRows_strands'];
} else {
  $all_strands = mysqli_query($tp, $query_strands);
  $totalRows_strands = mysqli_num_rows($all_strands);
}
$totalPages_strands = ceil($totalRows_strands/$maxRows_strands)-1;

$queryString_strands = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_strands") == false && 
        stristr($param, "totalRows_strands") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_strands = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_strands = sprintf("&totalRows_strands=%d%s", $totalRows_strands, $queryString_strands);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Strand List</title>
</head>
<script src="../code/javascripts.js"></script>
<body>
<table border="1" align="center">
  <tr>
    <td>strand_id</td>
    <td>strand</td>
    <td>description</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="strand_update.php?recordID=<?php echo $row_strands['id']; ?>"> <?php echo $row_strands['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_strands['strand']; ?>&nbsp; </td>
      <td><?php echo $row_strands['description']; ?>&nbsp; </td>
	  <td><label onclick="DeleteTableItem('strand',<?php echo $row_strands['id'];?>,'<?php echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
    </tr>
    <?php } while ($row_strands = mysqli_fetch_assoc($strands)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_strands > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_strands=%d%s", $currentPage, 0, $queryString_strands); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_strands > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_strands=%d%s", $currentPage, max(0, $pageNum_strands - 1), $queryString_strands); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_strands < $totalPages_strands) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_strands=%d%s", $currentPage, min($totalPages_strands, $pageNum_strands + 1), $queryString_strands); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_strands < $totalPages_strands) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_strands=%d%s", $currentPage, $totalPages_strands, $queryString_strands); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_strands + 1) ?> to <?php echo min($startRow_strands + $maxRows_strands, $totalRows_strands) ?> of <?php echo $totalRows_strands ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php
mysqli_free_result($strands);
}
?>
