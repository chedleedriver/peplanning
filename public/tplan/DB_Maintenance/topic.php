<?php  
include('session.php');
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
    
include ("functions.php");
$mode=$_GET['mode'];
$topic_id=$_GET['topic_id'];
$what[0]="equipment";
$what[1]="keywords";
$what[2]="objectives";
$what[3]="theme";
$what[4]="lesson_part";
$what[5]="point";
$what[6]="numeracy";
$what[7]="ICT";
$what[8]="risk_assessment";
$what[9]="citizenship";
if ($mode=="update")
	{ TopicUpdate();
}
if ($mode=="UpdateThemeLevelImportanceNotes") { UpdateThemeLevelImportanceNotes(); $topic_id=$_POST['topic_id']; }
$sql="select topic.id,name,genre,genre.description from topic left join genre on topic.genre = genre.id where topic.id = $topic_id";
list($topic_topic_id,$topic_name,$genre_id,$description) = mysql_fetch_array(mysql_query($sql)) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
if ($mode!="look") {
 $list_in_id=$mode."_in"; $list_out_id=$mode."_out";
 }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Topic</title>
<script src="../code/javascripts.js">
</script>
</head>
<body>
<form name="topic" method="post" action="<? if ($mode=='theme') echo 'topic.php?mode=UpdateThemeLevelImportanceNotes'; else echo 'topic.php?mode=update';?>">
<table>
<tr>
<td>Name:</td><td colspan="5"><input name="topic_id" type="hidden" value="<? echo $topic_id?>" /><input name="topic_name" size="20" value="<? echo $topic_name?>" /></td>
</tr>
<?
if (($mode=="look") OR ($mode=="create")) 
{
$i=0;
while ($i < count($what)) {
if ($col==0) {echo "<tr>";}; echo "<td><input name=".$what[$i]." id=".$what[$i]." type=\"button\" value=".$what[$i]." onclick=\"ChangeList(this.value,".$topic_id.")\" /></td><td>"?>
<select name="<? echo $what[$i]."[]"?>" multiple="multiple" size="10">
<? if ($mode=="create") GetList($what[$i]); else GetTopicList($what[$i],$topic_id);
if (mysql_num_rows($data)!=0) { while (list($id,$name)=mysql_fetch_array($data)) {?>
<option value=<? echo $id?>><? echo $name?></option>
<? }}?>
</select>
<? echo "</td>";$col++; if (($col==3)|| ($col==6)|| ($col==9)) {echo "</tr>";$col=0;};$i++; }
?> <tr>
<td><input type="button" id="return" id="return" onclick="ReturnTo('index',0)" value="return to menu" /></td>
</tr>
<?
}
else { 
?>
<td id="<? echo $list_in_id."_cell"?>"><select name="<? echo $list_in_id?>" id="<? echo $list_in_id?>" size="10" multiple>
<? GetTopicList($mode,$topic_id);
while (list($id,$name)=mysql_fetch_array($data)) {
if ($mode=="objectives") {?>
<option onclick="GetStrandLevel(<? echo $id.",".$topic_id?>)" value=<? echo $id?>><? echo $name?></option>
<? }
elseif ($mode=="theme")  {?>
<option onclick="GetLevel(<? echo $id.",".$topic_id?>)" value=<? echo $id?>><? echo $name?></option>
<? } else {?>
<option value=<? echo $id?>><? echo $name?></option>
<? }}?></select>
</td>

<td id="<? echo $list_out_id."_cell"?>"><select name="<? echo $list_out_id?>"  id="<? echo $list_out_id?>" size="10" multiple>
<? if (($mode=="easy_differentiation") OR ($mode=="hard_differentiation") OR ($mode=="objectives") OR ($mode=="point")) GetList($mode,$topic_id); else GetList($mode,0);
while (list($id,$name)=mysql_fetch_array($data)) {?>
<option value=<? echo $id?>><? echo $name?></option>
<? }?>
</select>
</td>
<? }?>
<tr>
<? if ($mode=="create"){ ?><td colspan="6"><input type="submit" name="save" value="save" /></td>
<? }  if (($mode!="look") AND ($mode!="create")) {?>
<td><input type="button" id="remove" id="remove" onclick="RemoveManyFromList(<? echo $topic_id.",'".$mode."','topic'"?>)" value="remove" /></td>
<td><input type="button" id="add" id="add" onclick="AddManyToList(<? echo $topic_id.",'".$mode."','topic'"?>)" value="add" /></td>
<tr>
<td><input type="button" id="return" id="return" onclick="ReturnTo('topic',<? echo $topic_id?>)" value="return" /></td>
</tr>
<? if ($mode=="objectives") {?>
<tr>
<td>Strand for this objective with this topic</td>
<td>Level for this objective with this topic</td>
</tr>
<tr id="strandlevelcell">
</tr>
<? }
if ($mode=="theme") {?>
<tr>
<td colspan="2">Level for this theme with this topic</td>
</tr>
<tr><td id="levelcell" colspan="2">
</tr>
<tr>
<td>Importance for this theme with this topic</td>
</tr>
<tr><td id="importancecell"></td></tr>
<tr><td>Notes for this theme with this topic</td></tr>
<tr><td id="notescell" colspan="2"></td></tr>
<tr><td>Evaluation for this theme with this topic</td></tr>
<tr><td id="evaluationcell" colspan="2"></td></tr>
</tr>
<? }}?>
</tr>
</table>
</form>
</body>
</html>
<?}