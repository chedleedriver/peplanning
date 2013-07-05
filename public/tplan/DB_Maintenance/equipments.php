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

$maxRows_equipment = 10;
$pageNum_equipment = 0;
if (isset($_GET['pageNum_equipment'])) {
  $pageNum_equipment = $_GET['pageNum_equipment'];
}
$startRow_equipment = $pageNum_equipment * $maxRows_equipment;

mysql_select_db($database_tp, $tp);
$query_equipment = "SELECT * FROM equipment";
$query_limit_equipment = sprintf("%s LIMIT %d, %d", $query_equipment, $startRow_equipment, $maxRows_equipment);
$equipment = mysql_query($query_limit_equipment, $tp) or die(mysql_error());
$row_equipment = mysql_fetch_assoc($equipment);

if (isset($_GET['totalRows_equipment'])) {
  $totalRows_equipment = $_GET['totalRows_equipment'];
} else {
  $all_equipment = mysql_query($query_equipment);
  $totalRows_equipment = mysql_num_rows($all_equipment);
}
$totalPages_equipment = ceil($totalRows_equipment/$maxRows_equipment)-1;

$queryString_equipment = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_equipment") == false && 
        stristr($param, "totalRows_equipment") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_equipment = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_equipment = sprintf("&totalRows_equipment=%d%s", $totalRows_equipment, $queryString_equipment);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Equipment</title>
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
      <td><a href="equipment_update.php?recordID=<?php echo $row_equipment['id']; ?>"> <?php echo $row_equipment['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_equipment['description']; ?>&nbsp; </td>
	  <td><label onclick="DeleteTableItem('equipment',<? echo $row_equipment['id'];?>,'<? echo $_SERVER["PHP_SELF"]?>')">delete</label></td>    
	</tr>
    <?php } while ($row_equipment = mysql_fetch_assoc($equipment)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_equipment > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_equipment=%d%s", $currentPage, 0, $queryString_equipment); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_equipment > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_equipment=%d%s", $currentPage, max(0, $pageNum_equipment - 1), $queryString_equipment); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_equipment < $totalPages_equipment) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_equipment=%d%s", $currentPage, min($totalPages_equipment, $pageNum_equipment + 1), $queryString_equipment); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_equipment < $totalPages_equipment) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_equipment=%d%s", $currentPage, $totalPages_equipment, $queryString_equipment); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_equipment + 1) ?> to <?php echo min($startRow_equipment + $maxRows_equipment, $totalRows_equipment) ?> of <?php echo $totalRows_equipment ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php }
mysql_free_result($equipment);
?>
