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

$maxRows_topics_list = 10;
$pageNum_topics_list = 0;
if (isset($_GET['pageNum_topics_list'])) {
  $pageNum_topics_list = $_GET['pageNum_topics_list'];
}
$startRow_topics_list = $pageNum_topics_list * $maxRows_topics_list;


$query_topics_list = "SELECT * FROM topic";
$query_limit_topics_list = sprintf("%s LIMIT %d, %d", $query_topics_list, $startRow_topics_list, $maxRows_topics_list);
$topics_list = mysqli_query($tp, $query_limit_topics_list) or die(mysqli_error());
$row_topics_list = mysqli_fetch_assoc($topics_list);

if (isset($_GET['totalRows_topics_list'])) {
  $totalRows_topics_list = $_GET['totalRows_topics_list'];
} else {
  $all_topics_list = mysqli_query($tp, $query_topics_list);
  $totalRows_topics_list = mysqli_num_rows($all_topics_list);
}
$totalPages_topics_list = ceil($totalRows_topics_list/$maxRows_topics_list)-1;

$queryString_topics_list = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_topics_list") == false && 
        stristr($param, "totalRows_topics_list") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_topics_list = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_topics_list = sprintf("&totalRows_topics_list=%d%s", $totalRows_topics_list, $queryString_topics_list);
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
    <td>topics</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><a href="topic_update.php?recordID=<?php echo $row_topics_list['id']; ?>"> <?php echo $row_topics_list['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_topics_list['name']; ?>&nbsp; </td>
	  <td><label onclick="DeleteTableItem('topic',<?php echo $row_topics_list['id'];?>,'<?php echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
    </tr>
    <?php } while ($row_topics_list = mysqli_fetch_assoc($topics_list)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_topics_list > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_keywords_list=%d%s", $currentPage, 0, $queryString_topics_list); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_topics_list > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_topics_list=%d%s", $currentPage, max(0, $pageNum_topics_list - 1), $queryString_topics_list); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_topics_list < $totalPages_topics_list) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_topics_list=%d%s", $currentPage, min($totalPages_topics_list, $pageNum_topics_list + 1), $queryString_topics_list); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_topics_list < $totalPages_topics_list) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_genre_list=%d%s", $currentPage, $totalPages_topics_list, $queryString_topics_list); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_topics_list + 1) ?> to <?php echo min($startRow_topics_list + $maxRows_topicss_list, $totalRows_topics_list) ?> of <?php echo $totalRows_topics_list ?>
<a href="index.php">Menu</a>
</body>
</html>
<?php
mysqli_free_result($topics_list);
}
?>
