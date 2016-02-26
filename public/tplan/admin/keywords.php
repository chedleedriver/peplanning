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

$maxRows_keywords_list = 10;
$pageNum_keywords_list = 0;
if (isset($_GET['pageNum_keywords_list'])) {
  $pageNum_keywords_list = $_GET['pageNum_keywords_list'];
}
$startRow_keywords_list = $pageNum_keywords_list * $maxRows_keywords_list;


$query_keywords_list = "SELECT * FROM keywords";
$query_limit_keywords_list = sprintf("%s LIMIT %d, %d", $query_keywords_list, $startRow_keywords_list, $maxRows_keywords_list);
$keywords_list = mysqli_query($tp, $query_limit_keywords_list) or die(mysqli_error());
$row_keywords_list = mysqli_fetch_assoc($keywords_list);

if (isset($_GET['totalRows_keywords_list'])) {
  $totalRows_keywords_list = $_GET['totalRows_keywords_list'];
} else {
  $all_keywords_list = mysqli_query($tp, $query_keywords_list);
  $totalRows_keywords_list = mysqli_num_rows($all_keywords_list);
}
$totalPages_keywords_list = ceil($totalRows_keywords_list/$maxRows_keywords_list)-1;

$queryString_keywords_list = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_keywords_list") == false && 
        stristr($param, "totalRows_keywords_list") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_keywords_list = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_keywords_list = sprintf("&totalRows_keywords_list=%d%s", $totalRows_keywords_list, $queryString_keywords_list);
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
    <td>keyword</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="keyword_update.php?recordID=<?php echo $row_keywords_list['id']; ?>"> <?php echo $row_keywords_list['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_keywords_list['keyword']; ?>&nbsp; </td>
    	<td><label onclick="DeleteTableItem('keywords',<?php echo $row_keywords_list['id'];?>,'<?php echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
	</tr>
    <?php } while ($row_keywords_list = mysqli_fetch_assoc($keywords_list)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_keywords_list > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_keywords_list=%d%s", $currentPage, 0, $queryString_keywords_list); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_keywords_list > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_keywords_list=%d%s", $currentPage, max(0, $pageNum_keywords_list - 1), $queryString_keywords_list); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_keywords_list < $totalPages_keywords_list) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_keywords_list=%d%s", $currentPage, min($totalPages_keywords_list, $pageNum_keywords_list + 1), $queryString_keywords_list); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_keywords_list < $totalPages_keywords_list) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_keywords_list=%d%s", $currentPage, $totalPages_keywords_list, $queryString_keywords_list); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_keywords_list + 1) ?> to <?php echo min($startRow_keywords_list + $maxRows_keywords_list, $totalRows_keywords_list) ?> of <?php echo $totalRows_keywords_list ?>
<a href="index.php">Menu</a>
</body>
</html>
<?php
mysqli_free_result($keywords_list);
}
?>
