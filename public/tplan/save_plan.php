<? session_start();
include ("lessonfunctions.php");
$_SESSION['id'];
$_SESSION['school'];
//print_r($_POST['exit_mode']);
$plan_type=$_GET['plan_type'];
$uow_id=$_POST['uow_id'];
$removeoldplans=mysql_query("delete from lesson where uow_id=$uow_id");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Saving Page</title>
</head>
<body>
<script language="JavaScript" type="text/javascript" src="/tplan/js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="/tplan/js/jquery-ui-1.7.2.custom.min.js"></script>
<script language="JavaScript" type="text/javascript" src="/tplan/js/planScripts.js"></script>
</body>
<?
for ($i=1 ; $i <= $_POST['num_lessons'] ; $i++) 
{
$theme_id=$_POST['themeid'][$i];
if ($_POST['ta'][$i]) $ta=$_POST['ta'][$i]; else $ta='none';
if ($_POST['sen'][$i]) $sen=$_POST['sen'][$i]; else $sen='none';
if ($theme_id) 
{
	$createlesson="insert into lesson (uow_id,lesson_num,theme_id,ta,sen) values ($uow_id,$i,$theme_id,'$ta','$sen')";
	$createlessonresult=mysql_query($createlesson) or die("Error reported while executing the statement: $createlesson<br />MySQL reported: ".mysql_error());
	$lesson_id=mysql_insert_id();
if ($admin_flag=='y')
	{	
		$lesson_id=$_POST['lesson_id'][$i];
	}
if ($_POST['objectiveid'][$i])
{
	$removeoldobjectives=mysql_query("delete from lesson_objectives where lesson_id=$lesson_id");
	foreach ($_POST['objectiveid'][$i] as $objective_id)
	{
		$createobjective="insert into lesson_objectives (lesson_id,objective_id) values ($lesson_id,$objective_id)";
		$createobjectiveresult=mysql_query($createobjective) or die("Error reported while executing the statement: $createobjective<br />MySQL reported: ".mysql_error());
	}
}
if ($_POST['ict'][$i])
{
	$removeoldict=mysql_query("delete from lesson_ict where lesson_id=$lesson_id");
	foreach ($_POST['ict'][$i] as $ict_id) 
	{
		$createict="insert into lesson_ict (lesson_id,ict_id) values ($lesson_id,$ict_id)";
		$createictresult=mysql_query($createict) or die("Error reported while executing the statement: $createict<br />MySQL reported: ".mysql_error());
	}
}
if ($_POST['keywords'][$i])
{
	$removeoldkeywords=mysql_query("delete from lesson_keywords where lesson_id=$lesson_id");
	foreach ($_POST['keywords'][$i] as $keywords_id)
	{
		$createkeywords="insert into lesson_keywords (lesson_id,keyword_id) values ($lesson_id,$keywords_id)";
		$createkeywordsresult=mysql_query($createkeywords) or die("Error reported while executing the statement: $createkeywords<br />MySQL reported: ".mysql_error());
	}
}
if ($_POST['numeracy'][$i])
{
	$removeoldnumeracy=mysql_query("delete from lesson_numeracy where lesson_id=$lesson_id");
	foreach ($_POST['numeracy'][$i] as $numeracy_id)
	{
		$createnumeracy="insert into lesson_numeracy (lesson_id,numeracy_id) values ($lesson_id,$numeracy_id)";
		$createnumeracyresult=mysql_query($createnumeracy) or die("Error reported while executing the statement: $createnumeracy<br />MySQL reported: ".mysql_error());
	}
}
if ($_POST['risk_assessment'][$i])
{
	$removeoldrisk_assessment=mysql_query("delete from lesson_risk_assessment where lesson_id=$lesson_id");
	foreach ($_POST['risk_assessment'][$i] as $risk_assessment_id)
	{
		$createrisk_assessment="insert into lesson_risk_assessment (lesson_id,ra_id) values ($lesson_id,$risk_assessment_id)";
		$createrisk_assessmentresult=mysql_query($createrisk_assessment) or die("Error reported while executing the statement: $createrisk_assessment<br />MySQL reported: ".mysql_error());
	}
}
if ($_POST['citizenship'][$i])
{
	$removeoldcitizenship=mysql_query("delete from lesson_citizenship where lesson_id=$lesson_id");
	foreach ($_POST['citizenship'][$i] as $citizenship_id)
	{
		$createcitizenship="insert into lesson_citizenship (lesson_id,citizenship_id) values ($lesson_id,$citizenship_id)";
		$createcitizenshipresult=mysql_query($createcitizenship) or die("Error reported while executing the statement: $createcitizenship<br />MySQL reported: ".mysql_error());
	}
}
if ($_POST['activityid'][$i])
{
	$removeoldactivity=mysql_query("delete from lesson_activities where lesson_id=$lesson_id");
	foreach ($_POST['activityid'][$i] as $a => $activity_id) 
	{
		if ($activity_id) {
		$time=$_POST['timeout'][$i][$a];
			foreach ($_POST['activitynum'][$i] as $n => $act_num) {
			if ($activity_id==$act_num)
				{$activity_num=$n;
				break; }
			}
		$createactivity="insert into lesson_activities (lesson_id,activity_id,time,activity_num) values ($lesson_id,$activity_id,'$time',$activity_num)";
		$createactivityresult=mysql_query($createactivity) or die("Error reported while executing the statement: $createactivity<br />MySQL reported: ".mysql_error());
		$la_id=mysql_insert_id();
		if ($_POST['teaching_point'][$i][$a])
		{
			foreach ($_POST['teaching_point'][$i][$a] as $teach_point_id)
			{
				$createteachpoint="insert into lesson_activity_point (la_id,point_id) values ($la_id,$teach_point_id)";
				$createteachpointresult=mysql_query($createteachpoint) or die("Error reported while executing the statement: $createteachpoint<br />MySQL reported: ".mysql_error());
			}
		}
		if ($_POST['strand'][$i][$a])
		{
			foreach ($_POST['strand'][$i][$a] as $strand_id)
			{
				$createstrand="insert into lesson_activity_strand (la_id,strand_id) values ($la_id,$strand_id)";
				$createstrandresult=mysql_query($createstrand) or die("Error reported while executing the statement: $createstrand<br />MySQL reported: ".mysql_error());
			}
		}
		if ($_POST['differentiation'][$i][$a])
		{
			foreach ($_POST['differentiation'][$i][$a] as $differentiation_id)
			{
				$createdifferentiation="insert into lesson_activity_differentiation (la_id,diff_id) values ($la_id,$differentiation_id)";
				$createdifferentiationresult=mysql_query($createdifferentiation) or die("Error reported while executing the statement: $createdifferentiation<br />MySQL reported: ".mysql_error());
			}
		}
		if ($_POST['analyses'][$i][$a])
		{ 
			foreach ($_POST['analyses'][$i][$a] as $analyses_id)
			{
				$createanalyses="insert into lesson_activity_analyses (la_id,analyses_id) values ($la_id,$analyses_id)";
				$createanalysesresult=mysql_query($createanalyses) or die("Error reported while executing the statement: $createanalyses<br />MySQL reported: ".mysql_error());
				$la_an_id=mysql_insert_id();
				if ($_POST['analyses_points'][$i][$a][$analyses_id])
				{ 
					foreach ($_POST['analyses_points'][$i][$a][$analyses_id] as $anal_point_id)
					{
					$createanalpoint="insert into lesson_activity_analyses_point (la_an_id,point_id) values ($la_an_id,$anal_point_id)";
					$createanalpointresult=mysql_query($createanalpoint) or die("Error reported while executing the statement: $createanalpoint<br />MySQL reported: ".mysql_error());
					}
				}
			}
		}
		if ($_POST['progression'][$i][$a])
		{
			foreach ($_POST['progression'][$i][$a] as $progression_id)
			{
				$createprogression="insert into lesson_activity_progression (la_id,pr_id) values ($la_id,$progression_id)";
				$createprogressionresult=mysql_query($createprogression) or die("Error reported while executing the statement: $createprogression<br />MySQL reported: ".mysql_error());
				$la_pr_id=mysql_insert_id();
				if ($_POST['progression_points'][$i][$a][$progression_id])
				{ 
					foreach ($_POST['progression_points'][$i][$a][$progression_id] as $prog_point_id)
					{
					$createprogpoint="insert into lesson_activity_progression_point (la_pr_id,point_id) values ($la_pr_id,$prog_point_id)";
					$createprogpointresult=mysql_query($createprogpoint) or die("Error reported while executing the statement: $createprogpoint<br />MySQL reported: ".mysql_error());
					}
				}
			}
		}
		}
		
	}
}
}
	if (($_POST['exit_mode'][$i]=="PC") OR ($_POST['exit_mode'][$i]=="PE")) echo "<script>printPlan(".$lesson_id.",".$uow_id.")</script>";
//	echo("<meta http-equiv=\"Refresh\" content=\"0;url=../tplan/code/plan_print.php?lesson_id=".$lesson_id."&unit_id=".$uow_id."\">");
}

	foreach ($_POST['exit_mode'] as $exit_mode) {
//		if (($exit_mode[$i]=="PC") OR ($exit_mode[$i]=="PE")) PrintPlan($lesson_id,'n'); 
		if (($exit_mode=="PC") OR ($exit_mode=="SC")) 
			{$next_mode='continue';
			break; }
        }
        foreach ($_POST['exit_mode'] as $exit_mode) {
//		if (($exit_mode[$i]=="PC") OR ($exit_mode[$i]=="PE")) PrintPlan($lesson_id,'n');
		if ($exit_mode=="EP")
			{$next_mode='popups';
			break; }
        }
/*if ($next_mode=='continue')
	{
            echo("<meta http-equiv=\"Refresh\" content=\"0;url=../tplan/Lessons.php?unit_id=".$uow_id."&plan_type=newPlan\">");
	}
elseif ($next_mode=='popups')
        {
            echo("<meta http-equiv=\"Refresh\" content=\"0;url=../tplan/enable_popups.php?unit_id=".$uow_id."&plan_type=newPlan\">");
        }
else
	{
            echo("<meta http-equiv=\"Refresh\" content=\"0;url=../tplan/main.php\">");

	}*/
?>
</html>