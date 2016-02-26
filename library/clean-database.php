<?php
include "mysqli_dbconnect.php";

$sql[1]="delete from lesson_activity_strand where la_id in
(select la_id from lesson_activities where lesson_id not in
(select id from lesson order by lesson.id))";

$sql[2]="delete from lesson_activity_point where la_id in
(select la_id from lesson_activities where lesson_id not in
(select id from lesson order by lesson.id))";

$sql[3]="delete from lesson_activity_differentiation where la_id in
(select la_id from lesson_activities where lesson_id not in
(select id from lesson order by lesson.id))";

$sql[4]="delete from lesson_activity_analyses_point where la_an_id in
(select la_an_id from lesson_activity_analyses where la_id not in
(select la_id from lesson_activities where lesson_id not in
(select id from lesson order by lesson.id)))";

$sql[5]="delete from lesson_activity_analyses where la_id in
(select la_id from lesson_activities where lesson_id not in
(select id from lesson order by lesson.id))";

$sql[6]="delete from lesson_activity_progression_point where la_pr_id in
(select la_pr_id from lesson_activity_progression where la_id not in
(select la_id from lesson_activities where lesson_id not in
(select id from lesson order by lesson.id)))";

$sql[7]="delete from lesson_activity_progression where la_id in
(select la_id from lesson_activities where lesson_id not in
(select id from lesson order by lesson.id))";

$sql[8]="delete from lesson_activities where lesson_id not in
(select id from lesson order by lesson.id)";

$sql[9]="delete from lesson_citizenship where lesson_id not in
(select id from lesson order by lesson.id)";

$sql[10]="delete from lesson_ict where lesson_id not in
(select id from lesson order by lesson.id)";

$sql[11]="delete from lesson_keywords where lesson_id not in
(select id from lesson order by lesson.id)";

$sql[12]="delete from lesson_numeracy where lesson_id not in
(select id from lesson order by lesson.id)";

$sql[13]="delete from lesson_risk_assessment where lesson_id not in
(select id from lesson order by lesson.id)";

$sql[14]="delete from lesson where uow_id not in
(select id from unit_of_work order by id)";

$sql[15]="delete from unit_of_work where teacher_id not in
(select id from users order by id)";

for($i=1;$i<=15;$i++)
{
	
	$del_it = mysqli_query($tp,$sql[$i]);
	if(!$del_it){
		print $sql[$i]." - failed";
		break;
	}
}
?>