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

$maxRows_lesson_parts = 10;
$pageNum_lesson_parts = 0;
if (isset($_GET['pageNum_lesson_parts'])) {
  $pageNum_lesson_parts = $_GET['pageNum_lesson_parts'];
}
$startRow_lesson_parts = $pageNum_lesson_parts * $maxRows_lesson_parts;


$query_lesson_parts = "SELECT * FROM lesson_part";
$query_limit_lesson_parts = sprintf("%s LIMIT %d, %d", $query_lesson_parts, $startRow_lesson_parts, $maxRows_lesson_parts);
$lesson_parts = mysqli_query($tp, $query_limit_lesson_parts) or die(mysqli_error());
$row_lesson_parts = mysqli_fetch_assoc($lesson_parts);

if (isset($_GET['totalRows_lesson_parts'])) {
  $totalRows_lesson_parts = $_GET['totalRows_lesson_parts'];
} else {
  $all_lesson_parts = mysqli_query($tp, $query_lesson_parts);
  $totalRows_lesson_parts = mysqli_num_rows($all_lesson_parts);
}
$totalPages_lesson_parts = ceil($totalRows_lesson_parts/$maxRows_lesson_parts)-1;

$queryString_lesson_parts = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_lesson_parts") == false && 
        stristr($param, "totalRows_lesson_parts") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_lesson_parts = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_lesson_parts = sprintf("&totalRows_lesson_parts=%d%s", $totalRows_lesson_parts, $queryString_lesson_parts);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lesson Parts</title>
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
      <td><a href="lesson_part_update.php?recordID=<?php echo $row_lesson_parts['id']; ?>"> <?php echo $row_lesson_parts['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_lesson_parts['description']; ?>&nbsp; </td>
      <td><label onclick="DeleteTableItem('lesson_part',<?php echo $row_lesson_parts['id'];?>,'<?php echo $_SERVER["PHP_SELF"]?>')">delete</label></td></tr>
    <?php } while ($row_lesson_parts = mysqli_fetch_assoc($lesson_parts)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_lesson_parts > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_lesson_parts=%d%s", $currentPage, 0, $queryString_lesson_parts); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_lesson_parts > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_lesson_parts=%d%s", $currentPage, max(0, $pageNum_lesson_parts - 1), $queryString_lesson_parts); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_lesson_parts < $totalPages_lesson_parts) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_lesson_parts=%d%s", $currentPage, min($totalPages_lesson_parts, $pageNum_lesson_parts + 1), $queryString_lesson_parts); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_lesson_parts < $totalPages_lesson_parts) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_lesson_parts=%d%s", $currentPage, $totalPages_lesson_parts, $queryString_lesson_parts); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_lesson_parts + 1) ?> to <?php echo min($startRow_lesson_parts + $maxRows_lesson_parts, $totalRows_lesson_parts) ?> of <?php echo $totalRows_lesson_parts ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php
mysqli_free_result($lesson_parts);
}
?>
