<?php  session_start();
virtual('/tplan/Connections/tp.php');
include('session.php');
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include ("functions.php");
//$topic=$_GET['topic'];
//$topic_id=$_GET['topic_id'];
//$level_id=$_GET['level'];
$topic_ids=array(37,38,52);
$topics=array('hockey','football','tennis');
$levels=array('1.0','1.5','2.0','2.5','3.0','3.5','4.0');
for ($t=0;$t<count($topic_ids);$t++)
{
$topic_id=$topic_ids[$t];
$topic=$topics[$t];
for ($l=0;$l<count($levels);$l++)
{
$level_id=$levels[$l];
$teacher=$topic.'level'.$level_id;
echo $teacher."<br>";
$sql=("SELECT lesson.id from lesson left join unit_of_work on uow_id=unit_of_work.id left join users on users.id=unit_of_work.teacher_id left join theme on theme.id=lesson.theme_id where users.username='$teacher' and unit_of_work.level_id=$level_id and unit_of_work.topic_id=$topic_id;");
$get_plans=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
while (list($lesson_id)=mysql_fetch_array($get_plans))
{
    $lesson_objectives=mysql_query("select objective_id from lesson_objectives where lesson_id=$lesson_id") or die("Error reported while executing the statement: <br />MySQL reported: ".mysql_error());
    $topic_objectives=mysql_query("select objectives_id from topic_objectives where topic_id=$topic_id and level_id=$level_id") or die("Error reported while executing the statement: <br />MySQL reported: ".mysql_error());
    unset($objectives_array);
    if (mysql_num_rows($topic_objectives)!=0)
    {
    for ($i=0;$i<mysql_num_rows($topic_objectives);$i++)
    {
        list($topic_objective_id)=mysql_fetch_array($topic_objectives);
        $objectives_array[$i]=$topic_objective_id;
    }
    while (list($objective_id)=mysql_fetch_array($lesson_objectives))
       {
           if (!in_array($objective_id,$objectives_array))
           {
               echo "delete from lesson_objectives where lesson_id=".$lesson_id." and objectives_id=".$objective_id."<br>";
           }
       }
    }
    $lesson_activities=mysql_query("select la_id,activity_id from lesson_activities where lesson_activities.lesson_id=$lesson_id")or die("Error reported while executing the statement: activities<br />MySQL reported: ".mysql_error());
    while (list($la_id,$activity_id)=mysql_fetch_array($lesson_activities))
	{
           $teaching_points=mysql_query("select point_id from lesson_activity_point left join lesson_activities on lesson_activities.la_id=lesson_activity_point.la_id where lesson_activity_point.la_id = $la_id")or die("Error reported while executing the statement: teaching points<br />MySQL reported: ".mysql_error());
	   $points=mysql_query("select point.id,point from point left join content_point on content_point.point_id=point.id where content_point.content_id=$activity_id")or die("Error reported while executing the statement:select point.id,point from point left join content_point on content_point.point_id=point.id where content_point.content_id=".$activity_id."<br />MySQL reported: ".mysql_error());
           unset($points_array);
           if (mysql_num_rows($points)!=0)
           {
           for ($i=0;$i<mysql_num_rows($points);$i++)
           {
               list ($point_id,$point)=mysql_fetch_array($points);
               $points_array[$i]=$point_id;
           }
           while (list($teaching_point_id)=mysql_fetch_array($teaching_points))
           {
               if (!in_array($teaching_point_id,$points_array))
               {
                   echo "delete from lesson_activity_point where la_id=".$la_id." and point_id=".$teaching_point_id."<br>";
                   $remove_points=mysql_query("delete from lesson_activity_point where la_id=$la_id and point_id=$teaching_point_id");
               }
           }
           }
           $lesson_strands=mysql_query("select strand_id from lesson_activity_strand left join lesson_activities on lesson_activities.la_id=lesson_activity_strand.la_id where lesson_activity_strand.la_id = $la_id");
	   $strands=mysql_query("select strand.id,strand from strand left join content_strand on content_strand.strand_id=strand.id where content_strand.content_id=$activity_id");
           unset($strands_array);
           if (mysql_num_rows($strands)!=0)
           {
           for ($i=0;$i<mysql_num_rows($strands);$i++)
           {
               list ($strand_id,$strand)=mysql_fetch_array($strands);
               $strands_array[$i]=$strand_id;
           }
           while (list($lesson_strand_id)=mysql_fetch_array($lesson_strands))
           {
               if (!in_array($lesson_strand_id,$strands_array))
               {
                   echo "delete from lesson_activity_strand where la_id=".$la_id." and strand_id=".$lesson_strand_id."<br>";
                   $remove_strands=mysql_query("delete from lesson_activity_strand where la_id=$la_id and strand_id=$lesson_strand_id");
               }
           }
           }
           $lesson_differentiations=mysql_query("select diff_id from lesson_activity_differentiation left join lesson_activities on lesson_activities.la_id=lesson_activity_differentiation.la_id where lesson_activity_differentiation.la_id = $la_id");
           $differentiations=mysql_query("select differentiation.id,differentiation,difficulty from differentiation left join content_differentiation on content_differentiation.differentiation_id = differentiation.id where content_differentiation.content_id = $activity_id order by difficulty") or die("Error reported while executing the statement: diffs<br />MySQL reported: ".mysql_error());
           unset($differentiations_array);
           if (mysql_num_rows($differentiations)!=0)
           {
           for ($i=0;$i<mysql_num_rows($differentiations);$i++)
           {
               list ($differentiation_id)=mysql_fetch_array($differentiations);
               $differentiations_array[$i]=$differentiation_id;
           }
           while (list($lesson_differentiation_id)=mysql_fetch_array($lesson_differentiations))
           {
               if (!in_array($lesson_differentiation_id,$differentiations_array))
               {
                   echo "delete from lesson_activity_differentiation where la_id=".$la_id." and diff_id=".$lesson_differentiation_id."<br>";
                   $remove_diffs=mysql_query("delete from lesson_activity_differentiation where la_id=$la_id and diff_id=$lesson_differentiation_id");
               }
           }
           }
           $lesson_progressions=mysql_query("select la_pr_id,pr_id from lesson_activity_progression left join lesson_activities on lesson_activities.la_id=lesson_activity_progression.la_id where lesson_activity_progression.la_id = $la_id");
           $progressions=mysql_query("select progression.id,progression from progression left join content_progression on content_progression.progression_id = progression.id where content_progression.content_id = $activity_id");
           unset ($progressions_array);
           if (mysql_num_rows($progressions)!=0)
           {
           for ($i=0;$i<mysql_num_rows($progressions);$i++)
           {
               list ($progression_id,$progression)=mysql_fetch_array($progressions);
               $progressions_array[$i]=$progression_id;
           }
           while (list($la_pr_id,$pr_id)=mysql_fetch_array($lesson_progressions))
           {
               if (!in_array($pr_id,$progressions_array))
               {
                   echo "delete from lesson_activity_progression where la_id=$la_id and pr_id=$pr_id<br>";
                   $remove_progressions=mysql_query("delete from lesson_activity_progression where la_id=$la_id and pr_id=$pr_id");
                   $lesson_ppoints=mysql_query("select point_id from lesson_activity_progression_point la_pr_id = $la_pr_id");
		   $ppoints=mysql_query("select id,point from point left join  progression_point on point.id = progression_point.point_id  where progression_point.progression_id = $pr_id") or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
                   unset ($ppoints_array);
                   if (mysql_num_rows($ppoints)!=0)
                   {
                       for ($p=0;$p<mysql_num_rows($ppoints);$p++)
                       {
                           list ($ppoint_id,$ppoint)=mysql_fetch_array($ppoints);
                           $ppoints_array[$p]=$ppoint_id;
                       }
                       while (list($lesson_pr_id)=mysql_fetch_array($lesson_activities))
                       {
                           if (!in_array($lesson_pr_id,$ppoints_array))
                           {
                               echo "delete from lesson_activity_progression_point where la_pr_id=$la_pr_id and point_id=$lesson_pr_id<br>";
                               $remove_ppoints=mysql_query("delete from lesson_activity_progression_point where la_pr_id=$la_pr_id and point_id=$lesson_pr_id");
                           }
                       }
                   }
               }
           }
           }
        }
}
}
}
}
?>
