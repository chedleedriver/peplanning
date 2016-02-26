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

$maxRows_differentiations = 10;
$pageNum_differentiations = 0;
if (isset($_GET['pageNum_differentiations'])) {
  $pageNum_differentiations = $_GET['pageNum_differentiations'];
}
$startRow_differentiations = $pageNum_differentiations * $maxRows_differentiations;


$query_differentiations = "SELECT * FROM differentiation";
$query_limit_differentiations = sprintf("%s LIMIT %d, %d", $query_differentiations, $startRow_differentiations, $maxRows_differentiations);
$differentiations = mysqli_query($tp, $query_limit_differentiations) or die(mysqli_error());
$row_differentiations = mysqli_fetch_assoc($differentiations);

if (isset($_GET['totalRows_differentiations'])) {
  $totalRows_differentiations = $_GET['totalRows_differentiations'];
} else {
  $all_differentiations = mysqli_query($tp, $query_differentiations);
  $totalRows_differentiations = mysqli_num_rows($all_differentiations);
}
$totalPages_differentiations = ceil($totalRows_differentiations/$maxRows_differentiations)-1;

$queryString_differentiations = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_differentiations") == false && 
        stristr($param, "totalRows_differentiations") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_differentiations = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_differentiations = sprintf("&totalRows_differentiations=%d%s", $totalRows_differentiations, $queryString_differentiations);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>differentiation List</title>
</head>
<script src="../code/javascripts.js"></script>
<body>
<table border="1" align="center">
  <tr>
    <td>id</td>
    <td>differentiation</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="differentiation_update.php?recordID=<?php echo $row_differentiations['id']; ?>"> <?php echo $row_differentiations['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_differentiations['differentiation']; ?>&nbsp; </td>
      <td><?php echo $row_differentiations['difficulty']; ?>&nbsp; </td>
      <td><?php echo $row_points['genre_id']; ?>&nbsp; </td>
	  <td><label onclick="DeleteTableItem('differentiation',<?php echo $row_differentiations['id'];?>,'<?php echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
    </tr>
    <?php } while ($row_differentiations = mysqli_fetch_assoc($differentiations)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_differentiations > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_differentiations=%d%s", $currentPage, 0, $queryString_differentiations); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_differentiations > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_differentiations=%d%s", $currentPage, max(0, $pageNum_differentiations - 1), $queryString_differentiations); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_differentiations < $totalPages_differentiations) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_differentiations=%d%s", $currentPage, min($totalPages_differentiations, $pageNum_differentiations + 1), $queryString_differentiations); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_differentiations < $totalPages_differentiations) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_differentiations=%d%s", $currentPage, $totalPages_differentiations, $queryString_differentiations); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_differentiations + 1) ?> to <?php echo min($startRow_differentiations + $maxRows_differentiations, $totalRows_differentiations) ?> of <?php echo $totalRows_differentiations ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php }
mysqli_free_result($differentiations);
?>
