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

$maxRows_theme = 10;
$pageNum_theme = 0;
if (isset($_GET['pageNum_theme'])) {
  $pageNum_theme = $_GET['pageNum_theme'];
}
$startRow_theme = $pageNum_theme * $maxRows_theme;


$query_theme = "SELECT * FROM theme";
$query_limit_theme = sprintf("%s LIMIT %d, %d", $query_theme, $startRow_theme, $maxRows_theme);
$theme = mysqli_query($tp, $query_limit_theme) or die(mysqli_error());
$row_theme = mysqli_fetch_assoc($theme);

if (isset($_GET['totalRows_theme'])) {
  $totalRows_theme = $_GET['totalRows_theme'];
} else {
  $all_theme = mysqli_query($tp, $query_theme);
  $totalRows_theme = mysqli_num_rows($all_theme);
}
$totalPages_theme = ceil($totalRows_theme/$maxRows_theme)-1;

$queryString_theme = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_theme") == false && 
        stristr($param, "totalRows_theme") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_theme = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_theme = sprintf("&totalRows_theme=%d%s", $totalRows_theme, $queryString_theme);
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
    <td>theme_id</td>
    <td>theme</td>
    <td>delete</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="theme_update.php?recordID=<?php echo $row_theme['id']; ?>"> <?php echo $row_theme['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_theme['theme']; ?>&nbsp; </td>
	  <td><label onclick="DeleteTableItem('theme',<?php echo $row_theme['id'];?>,'<?php echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
    </tr>
    <?php } while ($row_theme = mysqli_fetch_assoc($theme)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_theme > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_theme=%d%s", $currentPage, 0, $queryString_theme); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_theme > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_theme=%d%s", $currentPage, max(0, $pageNum_theme - 1), $queryString_theme); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_theme < $totalPages_theme) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_theme=%d%s", $currentPage, min($totalPages_theme, $pageNum_theme + 1), $queryString_theme); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_theme < $totalPages_theme) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_theme=%d%s", $currentPage, $totalPages_theme, $queryString_theme); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_theme + 1) ?> to <?php echo min($startRow_theme + $maxRows_theme, $totalRows_theme) ?> of <?php echo $totalRows_theme ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php
mysqli_free_result($theme);
}
?>