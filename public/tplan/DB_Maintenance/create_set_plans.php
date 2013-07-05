<?php  session_start();
virtual('/tplan/Connections/tp.php');
include('session.php');
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include ('lessonfunctions.php');
$uow_id=$_GET['uow_id'];
$unit_details=mysql_query("select topic_id,level_id from unit_of_work where id=$uow_id");
list ($topic_id,$level)=mysql_fetch_array($unit_details);
for ($i=1;$i<=12;$i++)
{
	$set_plan=mysql_query("insert into set_plans (topic_id,level,num_lessons) values ($topic_id,$level,$i)");
	echo "insert into set_plans (topic_id,level,num_lessons) values (".$topic_id.",".$level.",".$i.")<br>";
	$set_plan_id[$i]=mysql_insert_id();
	echo $set_plan_id[$i]."<br>";
}
for ($i=1;$i<=12;$i++)
{
$lessons=mysql_query("select lesson.id,lesson_num,topic_id,level_id from lesson left join unit_of_work on unit_of_work.id=uow_id where uow_id=$uow_id order by lesson_num;");
$lesson=1;
while (list ($lesson_id,$lesson_num,$topic_id,$level_id)=mysql_fetch_array($lessons))
	{
		switch ($lesson_num) {
			case 1:
				$set_plan_lesson=mysql_query("insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";
				$lesson++;
			break;
			case 2:
				if ($i >= 3) {
				$set_plan_lesson=mysql_query("insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)"); 
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 3:
				if ($i >= 7) {
				$set_plan_lesson=mysql_query("insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 4:
				if ($i >= 9) {
				$set_plan_lesson=mysql_query("insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)"); 
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 5:
				if ($i >= 8) {
				$set_plan_lesson=mysql_query("insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)"); 
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 6:
				if ($i >= 4) {
				$set_plan_lesson=mysql_query("insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 7:
				if ($i >= 10) {
				$set_plan_lesson=mysql_query("insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 8:
				if ($i >= 11) {
				$set_plan_lesson=mysql_query("insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 9:
				if ($i >= 5) {
				$set_plan_lesson=mysql_query("insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 10:
				if ($i >= 12) {
				$set_plan_lesson=mysql_query("insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 11:
				if ($i >= 6) {
				$set_plan_lesson=mysql_query("insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)"); 
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 12:
				if ($i >= 2) {
				$set_plan_lesson=mysql_query("insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			}
	}
}
				
				




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
<? }
