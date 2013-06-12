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

$maxRows_risk_assessment = 10;
$pageNum_risk_assessment = 0;
if (isset($_GET['pageNum_risk_assessment'])) {
  $pageNum_risk_assessment = $_GET['pageNum_risk_assessment'];
}
$startRow_risk_assessment = $pageNum_risk_assessment * $maxRows_risk_assessment;

mysql_select_db($database_tp, $tp);
$query_risk_assessment = "SELECT * FROM risk_assessment";
$query_limit_risk_assessment = sprintf("%s LIMIT %d, %d", $query_risk_assessment, $startRow_risk_assessment, $maxRows_risk_assessment);
$risk_assessment = mysql_query($query_limit_risk_assessment, $tp) or die(mysql_error());
$row_risk_assessment = mysql_fetch_assoc($risk_assessment);

if (isset($_GET['totalRows_risk_assessment'])) {
  $totalRows_risk_assessment = $_GET['totalRows_risk_assessment'];
} else {
  $all_risk_assessment = mysql_query($query_risk_assessment);
  $totalRows_risk_assessment = mysql_num_rows($all_risk_assessment);
}
$totalPages_risk_assessment = ceil($totalRows_risk_assessment/$maxRows_risk_assessment)-1;

$queryString_risk_assessment = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_risk_assessment") == false && 
        stristr($param, "totalRows_risk_assessment") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_risk_assessment = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_risk_assessment = sprintf("&totalRows_risk_assessment=%d%s", $totalRows_risk_assessment, $queryString_risk_assessment);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Risk Assessments</title>
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
      <td><a href="risk_assessment_update.php?recordID=<?php echo $row_risk_assessment['id']; ?>"> <?php echo $row_risk_assessment['id']; ?>&nbsp; </a> </td>
      <td><?php echo $row_risk_assessment['description']; ?>&nbsp; </td>
	  <td><label onclick="DeleteTableItem('risk_assessment',<? echo $row_risk_assessment['id'];?>,'<? echo $_SERVER["PHP_SELF"]?>')">delete</label></td>
    </tr>
    <?php } while ($row_risk_assessment = mysql_fetch_assoc($risk_assessment)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_risk_assessment > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_risk_assessment=%d%s", $currentPage, 0, $queryString_risk_assessment); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_risk_assessment > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_risk_assessment=%d%s", $currentPage, max(0, $pageNum_risk_assessment - 1), $queryString_risk_assessment); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_risk_assessment < $totalPages_risk_assessment) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_risk_assessment=%d%s", $currentPage, min($totalPages_risk_assessment, $pageNum_risk_assessment + 1), $queryString_risk_assessment); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_risk_assessment < $totalPages_risk_assessment) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_risk_assessment=%d%s", $currentPage, $totalPages_risk_assessment, $queryString_risk_assessment); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_risk_assessment + 1) ?> to <?php echo min($startRow_risk_assessment + $maxRows_risk_assessment, $totalRows_risk_assessment) ?> of <?php echo $totalRows_risk_assessment ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php
mysql_free_result($risk_assessment);
}
?>
