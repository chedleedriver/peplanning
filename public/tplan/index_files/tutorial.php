<?
$name=htmlspecialchars($_GET['name']);
$name=stripslashes($name);
$age=(int)$_GET['age'];
echo "<span style='color:red'>Your values are: <b>$name</b> and <b>$age</b></span>";
?>