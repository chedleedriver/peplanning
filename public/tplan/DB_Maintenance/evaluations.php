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

$maxRows_evaluation = 10;
$pageNum_evaluation = 0;
if (isset($_GET['pageNum_evaluation'])) {
  $pageNum_evaluation = $_GET['pageNum_evaluation'];
}
$startRow_evaluation = $pageNum_evaluation * $maxRows_evaluation;

mysql_select_db($database_tp, $tp);
$query_evaluation = "SELECT * FROM evaluation";
$query_limit_evaluation = sprintf("%s LIMIT %d, %d", $query_evaluation, $startRow_evaluation, $maxRows_evaluation);
$evaluation = mysql_query($query_limit_evaluation, $tp) or die(mysql_error());
$row_evaluation = mysql_fetch_assoc($evaluation);

if (isset($_GET['totalRows_evaluation'])) {
  $totalRows_evaluation = $_GET['totalRows_evaluation'];
} else {
  $all_evaluation = mysql_query($query_evaluation);
  $totalRows_evaluation = mysql_num_rows($all_evaluation);
}
$totalPages_evaluation = ceil($totalRows_evaluation/$maxRows_evaluation)-1;

$queryString_evaluation = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_evaluation") == false && 
        stristr($param, "totalRows_evaluation") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_evaluation = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_evaluation = sprintf("&totalRows_evaluation=%d%s", $totalRows_evaluation, $queryString_evaluation);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Evaluation</title>
</head>
<script src="../code/javascripts.js"></script>
<body>
<table border="1" align="center">
  <tr>
    <td>id</td>
    <td>description</td>
  </tr>
  <?php do { $description=unserialize($row_evaluation['evaluation']);
             foreach ($description as $description_line) {if ($description_line) $evaluation_text=$evaluation_text." ".$description_line;}
?>
    <tr>
      <td><a href="evaluation_update.php?recordID=<?php echo $row_evaluation['id']; ?>"> <?php echo $row_evaluation['id']; ?>&nbsp; </a> </td>
      <td><?php echo $evaluation_text; $evaluation_text='';?>&nbsp; </td>
	  <td><label onclick="DeleteTableItem('evaluation',<? echo $row_evaluation['id'];?>,'<? echo $_SERVER["PHP_SELF"]?>')">delete</label></td>    
	</tr>
    <?php } while ($row_evaluation = mysql_fetch_assoc($evaluation)); ?>
</table>
<br>
<table border="0" width="50%" align="center">
  <tr>
    <td width="23%" align="center"><?php if ($pageNum_evaluation > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_evaluation=%d%s", $currentPage, 0, $queryString_evaluation); ?>">First</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="31%" align="center"><?php if ($pageNum_evaluation > 0) { // Show if not first page ?>
          <a href="<?php printf("%s?pageNum_evaluation=%d%s", $currentPage, max(0, $pageNum_evaluation - 1), $queryString_evaluation); ?>">Previous</a>
          <?php } // Show if not first page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_evaluation < $totalPages_evaluation) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_evaluation=%d%s", $currentPage, min($totalPages_evaluation, $pageNum_evaluation + 1), $queryString_evaluation); ?>">Next</a>
          <?php } // Show if not last page ?>
    </td>
    <td width="23%" align="center"><?php if ($pageNum_evaluation < $totalPages_evaluation) { // Show if not last page ?>
          <a href="<?php printf("%s?pageNum_evaluation=%d%s", $currentPage, $totalPages_evaluation, $queryString_evaluation); ?>">Last</a>
          <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
Records <?php echo ($startRow_evaluation + 1) ?> to <?php echo min($startRow_evaluation + $maxRows_evaluation, $totalRows_evaluation) ?> of <?php echo $totalRows_evaluation ?><br />
<a href="index.php">Menu</a>
</body>
</html>
<?php }
mysql_free_result($evaluation);
?>
