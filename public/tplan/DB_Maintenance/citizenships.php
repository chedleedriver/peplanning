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

$maxRows_citizenship = 10;
$pageNum_citizenship = 0;
if (isset($_GET['pageNum_citizenship'])) {
  $pageNum_citizenship = $_GET['pageNum_citizenship'];
}
$startRow_citizenship = $pageNum_citizenship * $maxRows_citizenship;

mysql_select_db($database_tp, $tp);
$query_citizenship = "SELECT * FROM citizenship";
$query_limit_citizenship = sprintf("%s LIMIT %d, %d", $query_citizenship, $startRow_citizenship, $maxRows_citizenship);
$citizenship = mysql_query($query_limit_citizenship, $tp) or die(mysql_error());
$row_citizenship = mysql_fetch_assoc($citizenship);

if (isset($_GET['totalRows_citizenship'])) {
  $totalRows_citizenship = $_GET['totalRows_citizenship'];
} else {
  $all_citizenship = mysql_query($query_citizenship);
  $totalRows_citizenship = mysql_num_rows($all_citizenship);
}
$totalPages_citizenship = ceil($totalRows_citizenship/$maxRows_citizenship)-1;

$queryString_citizenship = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_citizenship") == false && 
        stristr($param, "totalRows_citizenship") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_citizenship = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_citizenship = sprintf("&totalRows_citizenship=%d%s", $totalRows_citizenship, $queryString_citizenship);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Citizenship List</title>
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
      <td><a href="citizenship_update.php?recordID=<?php echo $row_citizenship['id']; ?>"> <?php echo $row_citizenship['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_citizenship['description']; ?>&nbsp; </td>
	  <td><label onclick="DeleteTableItem('citizenship',<? echo $row_citizenship['id'];?>,'<? echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
    </tr>
    <?php } while ($row_citizenship = mysql_fetch_assoc($citizenship)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_citizenship > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_citizenship=%d%s", $currentPage, 0, $queryString_citizenship); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_citizenship > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_citizenship=%d%s", $currentPage, max(0, $pageNum_citizenship - 1), $queryString_citizenship); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_citizenship < $totalPages_citizenship) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_citizenship=%d%s", $currentPage, min($totalPages_citizenship, $pageNum_citizenship + 1), $queryString_citizenship); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_citizenship < $totalPages_citizenship) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_citizenship=%d%s", $currentPage, $totalPages_citizenship, $queryString_citizenship); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_citizenship + 1) ?> to <?php echo min($startRow_citizenship + $maxRows_citizenship, $totalRows_citizenship) ?> of <?php echo $totalRows_citizenship ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php }
mysql_free_result($citizenship);
?>
