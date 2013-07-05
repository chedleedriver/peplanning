<?php  session_start();
virtual('/tplan/Connections/tp.php');
include('session.php');
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include ("functions.php");
$mode=$_GET['mode'];
$plan_id=$_GET['plan_id'];
$topic_id=$_GET['topic_id'];
$level_id=$_GET['level_id'];
if ($mode=="save") { save_set_plan();
    	echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/set_plan_maintenance.php\">");
	}
else {
if ($mode=="look")
{
	list($topic)=mysql_fetch_array(mysql_query("select name from topic where id=$topic_id"));
        $teacher=$topic.'level'.$level_id;
        $sql=("SELECT lesson.id,theme.theme".
                                    " from lesson".
                                    " left join unit_of_work on uow_id=unit_of_work.id".
                                    " left join users on users.id=unit_of_work.teacher_id".
                                    " left join theme on theme.id=lesson.theme_id".
                                    " where users.username='$teacher'".
                                    " and unit_of_work.level_id=$level_id".
                                    " and unit_of_work.topic_id=$topic_id;");
	$get_plans=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Choose <? echo $mode?></title>
<script src="../code/javascripts.js"></script>
</head>
<body>
<form action="/tplan/DB_Maintenance/set_plan_maintenance.php?mode=save" method="post">
    <input type="hidden" name="topic_id" id="topic_id" value="<? echo $topic_id?>" />
    <input type="hidden" name="level" id="level_id" value="<? echo $level_id?>" />
<table>
<? if ($mode!="look") {?>
<tr><td>
<?	echo "<select id='topic'> <option value=\"select topic\">select topic</option>";
	GetTopics();
	echo "</select>";
?>
</td>
<td>
<?	echo "<select id='level' onchange=\"maintainSetPlan()\"> <option value=\"select level\">level</option>";
	GetLevels();
	echo "</select>";
?>
</td>
<? } else {

$j=1; while (list($lesson_id,$theme)=mysql_fetch_array($get_plans))
{
$themes[$j]=$theme;
$lesson_ids[$j]=$lesson_id;
	$get_set_plans=mysql_query("select set_plan_id from set_plans where topic_id=$topic_id and level=$level_id and num_lessons=$j");
	if ($get_set_plans)	list ($set_plan_ids[$j])=mysql_fetch_array($get_set_plans);
$j++;
?>

<?
}
echo "<tr>";
for ($i=1;$i<=12;$i++)
{
	echo "<td>".$i." lesson plan<br>".$set_plan_ids[$i]."<br><table>";
	for ($o=1;$o<=15;$o++) {
            	if ($set_plan_ids[$i])
			{
				$get_set_lessons=mysql_query("select lesson_num from set_plan_lessons where set_plan_id=$set_plan_ids[$i] and lesson_id=$lesson_ids[$o]");
				if ($get_set_lessons) list ($set_lesson_num[$o])=mysql_fetch_array($get_set_lessons);
			}
		echo "<tr><td width=100>Num: <input size=2 id=".$lesson_ids[$o]."_".$i." name=".$lesson_ids[$o]."_".$i." value='".$set_lesson_num[$o]."' /><input type=hidden id=".$o."_".$i." name=".$o."_".$i." value='".$lesson_ids[$o]."' /></td><td width=200> $themes[$o]</td></tr>";
                }
	//echo "</select></td>";
        echo "</table></td>";
}
echo "</tr>";
}?>
</tr>
<tr><td colspan="12" align="left"><input type="submit" value="save plan" /></td></tr>
</table>
</form>
</body>
</html>
<?php } }?>