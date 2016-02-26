<?php  session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . '/../library/tplan_config.php'); 
include("session.php");
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include('mysqli_dbconnect.php');
include ("functions.php");
include ('lessonfunctions_2.php');
$uow_id=$_GET['uow_id'];
$unit_details=mysqli_query($tp, "select topic_id,level_id from unit_of_work where id=$uow_id");
list ($topic_id,$level)=mysqli_fetch_array($unit_details);
for ($i=1;$i<=12;$i++)
{
	$set_plan=mysqli_query($tp, "insert into set_plans (topic_id,level,num_lessons) values ($topic_id,$level,$i)");
	echo "insert into set_plans (topic_id,level,num_lessons) values (".$topic_id.",".$level.",".$i.")<br>";
	$set_plan_id[$i]=mysqli_insert_id();
	echo $set_plan_id[$i]."<br>";
}
for ($i=1;$i<=12;$i++)
{
$lessons=mysqli_query($tp, "select lesson.id,lesson_num,topic_id,level_id from lesson left join unit_of_work on unit_of_work.id=uow_id where uow_id=$uow_id order by lesson_num;");
$lesson=1;
while (list ($lesson_id,$lesson_num,$topic_id,$level_id)=mysqli_fetch_array($lessons))
	{
		switch ($lesson_num) {
			case 1:
				$set_plan_lesson=mysqli_query($tp, "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";
				$lesson++;
			break;
			case 2:
				if ($i >= 3) {
				$set_plan_lesson=mysqli_query($tp, "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)"); 
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 3:
				if ($i >= 7) {
				$set_plan_lesson=mysqli_query($tp, "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 4:
				if ($i >= 9) {
				$set_plan_lesson=mysqli_query($tp, "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)"); 
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 5:
				if ($i >= 8) {
				$set_plan_lesson=mysqli_query($tp, "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)"); 
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 6:
				if ($i >= 4) {
				$set_plan_lesson=mysqli_query($tp, "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 7:
				if ($i >= 10) {
				$set_plan_lesson=mysqli_query($tp, "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 8:
				if ($i >= 11) {
				$set_plan_lesson=mysqli_query($tp, "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 9:
				if ($i >= 5) {
				$set_plan_lesson=mysqli_query($tp, "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 10:
				if ($i >= 12) {
				$set_plan_lesson=mysqli_query($tp, "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 11:
				if ($i >= 6) {
				$set_plan_lesson=mysqli_query($tp, "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)"); 
				echo "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values (".$set_plan_id[$i].",".$lesson_id.",".$lesson.")";}
				$lesson++;
			break;
			case 12:
				if ($i >= 2) {
				$set_plan_lesson=mysqli_query($tp, "insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id[$i],$lesson_id,$lesson)");
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
<?php }
