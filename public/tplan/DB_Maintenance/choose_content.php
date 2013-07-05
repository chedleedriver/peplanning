<?php  session_start();
virtual('/tplan/Connections/tp.php');
include('session.php');
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include ("functions.php");
$mode=$_GET['mode'];
$topic=$_GET['topic'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Choose <? echo $mode?></title>
</head>
<script src="../code/javascripts.js"></script>
<body>
<table>
<tr><td>
<? if (!$topic)
{?>
    <tr valign="baseline">
      <td nowrap align="right">Topic</td>
      <td><select name="point[]" size="5" multiple="multiple" onclick="chooseContent(this,'<?php echo $mode?>')">
        <? GetTopics();?>
      </select>      </td>
    </tr>
<tr>
<td><input type="button" id="return" id="return" onclick="ReturnTo('index',0)" value="return to menu" /></td>
</tr>

<? }
else {?>

<?	if ($mode=="content") echo "<select id='".$mode."' onchange=\"editContent(".$topic.",this.value)\"> <option value=\"".$mode."\">".$mode."</option>";
        if ($mode=="resources") echo "<select id='".$mode."' onchange=\"editContentResources(".$topic.",this.value)\"> <option value=\"".$mode."\">".$mode."</option>";
	ChooseContentToEdit($mode,$topic);			
	echo "</select>";
} ?>
</td>
</tr>
</table>
</body>
</html>
<? }
