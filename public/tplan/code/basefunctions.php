<? // functions file to store PHP basic functions
// version 1
// created on 10/9/11
//
session_start();
function customError($errno, $errstr,$errfile,$errline)
  {
  echo "<b>Error:</b> [$errno] $errstr at line $errline in $errfile<br />";
  echo "Ending Script";
  die();
  }
set_error_handler("customError",E_USER_ERROR);
include_once('config.php');

// coming from main.php
$_GET['GetThemes'] = (isset($_GET['GetThemes']) ? $_GET['GetThemes'] : 'default');
$_GET['DrawPlanPage'] = (isset($_GET['DrawPlanPage']) ? $_GET['DrawPlanPage'] : 'default');
$_GET['GetData'] = (isset($_GET['GetData']) ? $_GET['GetData'] : 'default');
$_GET['DeletePlan'] = (isset($_GET['DeletePlan']) ? $_GET['DeletePlan'] : 'default');
$_GET['SaveUnitofWork'] = (isset($_GET['SaveUnitofWork']) ? $_GET['SaveUnitofWork'] : 'default');
$_GET['DeletePlanFromAll'] = (isset($_GET['DeletePlanFromAll']) ? $_GET['DeletePlanFromAll'] : 'default');
$_GET['GetMyUnits'] = (isset($_GET['GetMyUnits']) ? $_GET['GetMyUnits'] : 'default');
$_GET['GetAllMyUnits'] = (isset($_GET['GetAllMyUnits']) ? $_GET['GetAllMyUnits'] : 'default');
$_GET['GetAllMyAssessments'] = (isset($_GET['GetAllMyAssessments']) ? $_GET['GetAllMyAssessments'] : 'default');
$_GET['GetMyAssessments'] = (isset($_GET['GetMyAssessments']) ? $_GET['GetMyAssessments'] : 'default');
$_GET['GetSomeTopics'] = (isset($_GET['GetSomeTopics']) ? $_GET['GetSomeTopics'] : 'default');
$_GET['GetSomeGenres'] = (isset($_GET['GetSomeGenres']) ? $_GET['GetSomeGenres'] : 'default');
$_GET['EditUser'] = (isset($_GET['EditUser']) ? $_GET['EditUser'] : 'default');
$_GET['CanIDoThis'] = (isset($_GET['CanIDoThis']) ? $_GET['CanIDoThis'] : 'default');
$_GET['email'] = (isset($_GET['email']) ? $_GET['email'] : 'default');
$_GET['school_email'] = (isset($_GET['school_email']) ? $_GET['school_email'] : 'default');
$_GET['username_available'] = (isset($_GET['username_available']) ? $_GET['username_available'] : 'default');
$_GET['schoolname_available'] = (isset($_GET['schoolname_available']) ? $_GET['schoolname_available'] : 'default');
$_GET['GetHelp'] = (isset($_GET['GetHelp']) ? $_GET['GetHelp'] : 'default');
$_GET['CreateDefaultUnit'] = (isset($_GET['CreateDefaultUnit']) ? $_GET['CreateDefaultUnit'] : 'default');
$_GET['CreateDefaultUnit2'] = (isset($_GET['CreateDefaultUnit2']) ? $_GET['CreateDefaultUnit2'] : 'default');
$_GET['CreateDefaultUnit1'] = (isset($_GET['CreateDefaultUnit1']) ? $_GET['CreateDefaultUnit1'] : 'default');
$_GET['CreateDefaultLessons'] = (isset($_GET['CreateDefaultLessons']) ? $_GET['CreateDefaultLessons'] : 'default');
if ($_GET['GetThemes']!='default') GetThemes($_GET['GetThemes'],$_GET['topic_id'],$_GET['level'],$_GET['description'],$_GET['num_lessons']);
if ($_GET['DrawPlanPage']!='default') DrawPlanPage($_GET['DrawPlanPage'],$_GET['theme_id'],$_GET['topic_id'],$_GET['level']);
if ($_GET['GetData']!='default') GetData($_GET['GetData']);
if ($_GET['SaveUnitofWork']!='default') SaveUnitofWork($_GET['topic_id'],$_GET['topic'],$_GET['level_id'],$_GET['num_lessons'],$_GET['description'],$_GET['plan_type']);
if ($_GET['DeletePlan']!='default') deleteplan($_GET['DeletePlan']);
if ($_GET['DeletePlanFromAll']!='default') deleteplanfromall($_GET['DeletePlanFromAll']);
if ($_GET['GetMyUnits']!='default') GetMyUnits();
if ($_GET['GetAllMyUnits']!='default') GetAllMyUnits();
if ($_GET['GetMyAssessments']!='default') GetMyAssessments();
if ($_GET['GetAllMyAssessments']!='default') GetAllMyAssessments();
if ($_GET['GetSomeTopics']!='default') GetSomeTopics($_GET['GetSomeTopics'],$_GET['level']);
if ($_GET['GetSomeGenres']!='default') GetSomeGenres($_GET['GetSomeGenres']);
if ($_GET['EditUser']!='default') EditUser($_GET['EditUser']);
if ($_GET['CanIDoThis']!='default') CanIDoThis($_GET['CanIDoThis']);
if ($_GET['email']!='default') email_available($_GET['email']);
if ($_GET['school_email']!='default') school_email_available($_GET['school_email']);
if ($_GET['username_available']!='default') username_available($_GET['username_available']);
if ($_GET['schoolname_available']!='default') schoolname_available($_GET['schoolname_available']);
if ($_GET['GetHelp']!='default') GetHelp($_GET['GetHelp']);
if ($_GET['CreateDefaultUnit']!='default') CreateDefaultUnit($_GET['topic_id'],$_GET['topic'],$_GET['level'],$_GET['description'],$_GET['num_lessons']);
if ($_GET['CreateDefaultUnit1']!='default') CreateDefaultUnit1($_GET['topic_id'],$_GET['topic'],$_GET['level'],$_GET['description'],$_GET['num_lessons']);
if ($_GET['CreateDefaultUnit2']!='default') CreateDefaultUnit2($_GET['topic_id'],$_GET['topic'],$_GET['level'],$_GET['description'],$_GET['num_lessons']);
if ($_GET['CreateDefaultLessons']!='default') CreateDefaultLessons();
//functions start here
// get the data functions

// save data functions*/
function SaveUnitofWork($topic_id,$topic,$level_id,$num_lessons,$description,$plan_type)
{
	if ($level_id=='0.0') $level_string=' - foundation level - ';
        else $level_string=' - level - '.$level_id;
        $teacher_id=$_SESSION['id'];
        if ($teacher_id) {
	if (!$description) $description=$topic.$level_string." ".date("F j, Y, g:i a");
	$savesql="insert into unit_of_work (description, topic_id, level_id, teacher_id, num_lessons, original_type) values ('$description',$topic_id,$level_id,$teacher_id,$num_lessons,'$plan_type')";
	$saveresult=mysql_query($savesql) or die("Error reported while executing the statement: $savesql<br />MySQL reported: ".mysql_error());
	echo mysql_insert_id();
        }
        else {
            echo "not_logged_in";
        }
}
function GetMyUnits()
{
	$whoami=$_SESSION['id'];
	//$remove_empty_units=mysql_query("delete from `unit_of_work` where `unit_of_work`.id not in (select `lesson`.uow_id from lesson order by uow_id) and teacher_id=$whoami");
	$user_level=$_SESSION['userlevel'];
        $myunits="select * from unit_of_work where teacher_id=$whoami order by date_created desc";
	$gotmyunits=mysql_query($myunits) or die("Error reported while executing the statement: $myunits<br />MySQL reported: ".mysql_error());
        if (mysql_num_rows($gotmyunits)==0) echo "You Haven't created any plans yet.<br>Select the 'Create Plans' tab to start creating PE plans";
        else {
	while (list($unit_id,$description,$topic_id,$level_id,$teacher_id,$num_lessons,$public,$date_created)=mysql_fetch_array($gotmyunits))
		{
			$month=Month_Display(substr($date_created,9,2));
			$year=substr($date_created,1,4);
			$gettopic="select name from topic where id=$topic_id";
			$gottopic=mysql_query($gettopic) or die("Error reported while executing the statement: $gettopic<br />MySQL reported: ".mysql_error());
			echo "<h4 id='heading_".$unit_id."'><a class=\"ui-widget\" href='#'>".$description."</a><img src='images/icon_delete_30.jpg' border='0' onclick='deletePlan(".$unit_id.")' alt='delete this unit' title='delete this unit' style='position:absolute;right:100px;top:8px;'> </h4>";
			echo "<ul>";
			//echo "<li><a class=\"ui-widget\" href=\"../tplan/Lessons.php?unit_id=".$unit_id."&plan_type=newPlan\"'>Edit This Unit</a></li>";
//			echo "<li><a class=\"ui-widget\" href=\"javascript:editPlan(".$unit_id.",'newPlan')\"'>Edit This Unit</a></li>";
			//echo "<li><a class=\"ui-widget\" href=\"javascript:deletePlan(".$unit_id.")\">Delete This Unit</a></li>";
			//echo "<li><br><h6>Select a Plan to Print</h6></li>";
			GetMyLessons($unit_id,$num_lessons,$user_level);
		}
                echo "<div><br/><div class='help' onclick='javascript:showHelpDialog(\"plans\")'></div></div>";
}}

function GetAllMyUnits()
{
	$whoami=$_SESSION['id'];
	$user_level=$_SESSION['userlevel'];
        $filteroptions="where teacher_id=$whoami";
	//$remove_empty_units=mysql_query("delete from `unit_of_work` where `unit_of_work`.id not in (select `lesson`.uow_id from lesson order by uow_id) and teacher_id=$whoami");
	if (($_POST['topic_filter']) AND ($_POST['topic_filter']!='none')) $filteroptions=$filteroptions." and topic_id=".$_POST['topic_filter'];
        if (($_POST['level_filter']) AND ($_POST['level_filter']!='none')) $filteroptions=$filteroptions." and level_id=".$_POST['level_filter'];
        if ((!$_POST['sorter']) OR ($_POST['sorter']=='none')) $sortoption=" order by date_created";
        else $sortoption="order by ".$_POST['sorter'];
        if ((!$_POST['up_or_down']) OR ($_POST['up_or_down']=='none')) $sortoption=$sortoption." DESC";
        else $sortoption=$sortoption." ".($_POST['up_or_down']);
        $myunits="select * from unit_of_work $filteroptions $sortoption";
	$gotmyunits=mysql_query($myunits) or die("Error reported while executing the statement: $myunits<br />MySQL reported: ".mysql_error());
	while (list($unit_id,$description,$topic_id,$level_id,$teacher_id,$num_lessons,$public,$date_created)=mysql_fetch_array($gotmyunits))
		{
			$month=Month_Display(substr($date_created,9,2));
			$year=substr($date_created,1,4);
			$gettopic="select name from topic where id=$topic_id";
			$gottopic=mysql_query($gettopic) or die("Error reported while executing the statement: $gettopic<br />MySQL reported: ".mysql_error());
			echo "<h4 id='heading_".$unit_id."'><a class=\"ui-widget\" href='#'>".$description."</a><img src='images/icon_delete_30.jpg' border='0' onclick='deletePlanFromAll(".$unit_id.")' alt='delete this unit' style='position:absolute;right:100px;top:8px;'>  </h4>";
			echo "<ul>";
			//echo "<li><a class=\"ui-widget\" href=\"../tplan/Lessons.php?unit_id=".$unit_id."&plan_type=newPlan\"'>Edit This Unit</a></li>";
			//echo "<li><a class=\"ui-widget\" href=\"javascript:deletePlan(".$unit_id.")\">Delete This Unit</a></li>";
			//echo "<li><br><h6>Select a Plan to Print</h6></li>";
			GetMyLessons($unit_id,$num_lessons,$user_level);
		}
}
function GetMyLessons($unit_id,$num_lessons,$user_level)
{
	for($i=1;$i<=$num_lessons;$i++){
        $resources_exist=0;
        $getplanid="select lesson.id,lesson_num,theme from lesson left join theme on lesson.theme_id=theme.id where uow_id = $unit_id and lesson_num=$i";
	$gotplans=mysql_query($getplanid) or die("Error reported while executing the statement: $getplanid<br />MySQL reported: ".mysql_error());
        if ($user_level!=1){
        if (mysql_num_rows($gotplans)>0){
                list($plan_id,$lesson_num,$theme)=mysql_fetch_array($gotplans);
                $got_resources=mysql_query("select activity_id from lesson_activities where lesson_id=$plan_id");
                while(list($content_id)=mysql_fetch_array($got_resources)){
                if(mysql_num_rows(mysql_query("select id from tplan.content_resources where content_id=$content_id"))>0) $resources_exist=1;}
        	echo "<li style='width:600px;line-height:40px;*line-height:25px;'><table><tr><td width='500px' id='lesson_title_".$unit_id."_".$i."'><label style='*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Lesson ".$i.". ".$theme."</label></td><td width='30px'><a class=\"ui-widget\" href='javascript:mainPrintPlan(".$i.",".$unit_id.");'><img class='printer' id='printer".$i."' src='images/icon_printer_30.jpg' border='0' alt='print this lesson' title='print this lesson'></a></td><td width='30px'><a class=\"ui-widget\" href=\"http://".$_SERVER['HTTP_HOST']."/tplan/Lessons.php?=".time()."&unit_id=".$unit_id."&plan_type=newPlan&lesson_num=".$i."\"'><img class='edit' id='edit".$i."' src='images/icon_edit_30.jpg' border='0'  alt='edit this lesson' title='edit this lesson'></a></td>";if ($resources_exist){echo "<td width='30px'><a class=\"ui-widget\" href=\"http://".$_SERVER['HTTP_HOST']."/tplan/resources.php?=".time()."&unit_id=".$unit_id."&plan_type=newPlan&lesson_num=".$i."\"><img class='edit' id='resource".$i."' src='images/icon_resources_30.jpg' border='0'  alt='get resources for this lesson' title='get resources for this lesson'></a></td>";}else{ echo "<td width='30px'><img class='edit' id='resource".$i."' src='images/icon_blank_30.jpg' border='0'</td>";} echo "</tr></table></li>";
            }
            else{
        	echo "<li style='width:600px;line-height:40px;*line-height:25px;'><table><tr><td width='500px'  id='lesson_title_".$unit_id."_".$i."'><label style='font-style:italic;*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Lesson ".$i.". Unplanned</label></td><td width='30px'><a class=\"ui-widget\" href=\"http://".$_SERVER['HTTP_HOST']."/tplan/Lessons.php?=".time()."&unit_id=".$unit_id."&plan_type=newPlan&lesson_num=".$i."\"'><img class='edit'  id='edit".$i."' src='images/icon_edit_30.jpg'  border='0' alt='edit this lesson' title='edit this lesson'></a></td></tr></table></li>";
           }
        }
        else{
            if (mysql_num_rows($gotplans)>0){
                list($plan_id,$lesson_num,$theme)=mysql_fetch_array($gotplans);
                if ($lesson_num==1){
        	echo "<li style='width:600px;line-height:40px;*line-height:25px;'><table><tr><td width='500px'  id='lesson_title_".$unit_id."_".$i."'><label style='*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Lesson ".$i.". ".$theme."</label></td><td width='30px'><a class=\"ui-widget\" href='javascript:mainPrintPlan(".$i.",".$unit_id.");'><img class='printer' id='printer".$i."' src='images/icon_printer_30.jpg'  border='0' alt='print this lesson' title='print this lesson'></a></td><td width='30px'><a class=\"ui-widget\" href=\"../tplan/Lessons.php?unit_id=".$unit_id."&plan_type=newPlan&lesson_num=".$i."\"'><img class='edit' id='edit".$i."' src='images/icon_edit_30.jpg'  border='0' alt='edit this lesson' title='edit this lesson'></a></td>";if ($resources_exist){echo "<td width='30px'><a class=\"ui-widget\" href=\"http://".$_SERVER['HTTP_HOST']."/tplan/resources.php?=".time()."&unit_id=".$unit_id."&plan_type=newPlan&lesson_num=".$i."\"'><img class='edit' id='resource".$i."' src='images/icon_resources_30.jpg' border='0'  alt='get resources for this lesson' title='get resources for this lesson'></a></td>";} echo "</tr></table></li>";
                }
                else{
                    echo "<li style='width:600px;line-height:40px;*line-height:25px;'><table><tr><td width='500px'  id='lesson_title_".$unit_id."_".$i."'><label style='*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Lesson ".$i.". ".$theme."</label></td><td width='30px'><a class=\"ui-widget\" href='javascript:trialNotification()'><img class='printer' id='printer".$i."' src='images/icon_printer_30.jpg'  border='0' alt='print this lesson' title='print this lesson'></a></td><td width='30px'><a class=\"ui-widget\" href=javascript:trialNotification()><img class='edit' id='edit".$i."' src='images/icon_edit_30.jpg'  border='0' alt='edit this lesson' title='edit this lesson'></a></td></tr></table></li>";
                }
            }
            else{
                
                    echo "<li style='width:600px;line-height:40px;*line-height:25px;'><table><tr><td width='500px'  id='lesson_title_".$unit_id."_".$i."'><label style='font-style:italic;*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Lesson ".$i.". Unplanned</label></td><td width='30px'><a class=\"ui-widget\" href='javascript:trialNotification()'><img class='edit' id='edit".$i."' src='images/icon_edit_30.jpg'  border='0' alt='edit this lesson' title='edit this lesson'></a></td></tr></table></li>";
                }
           }
        }
	echo "</ul>";
}
function GetMyFreeUnits($whoami,$user_level)
{
	 $filteroptions="where teacher_id=$whoami";
	//$remove_empty_units=mysql_query("delete from `unit_of_work` where `unit_of_work`.id not in (select `lesson`.uow_id from lesson order by uow_id) and teacher_id=$whoami");
	if (($_POST['topic_filter']) AND ($_POST['topic_filter']!='none')) $filteroptions=$filteroptions." and topic_id=".$_POST['topic_filter'];
        if (($_POST['level_filter']) AND ($_POST['level_filter']!='none')) $filteroptions=$filteroptions." and level_id=".$_POST['level_filter'];
        if ((!$_POST['sorter']) OR ($_POST['sorter']=='none')) $sortoption=" order by date_created";
        else $sortoption="order by ".$_POST['sorter'];
        if ((!$_POST['up_or_down']) OR ($_POST['up_or_down']=='none')) $sortoption=$sortoption." DESC";
        else $sortoption=$sortoption." ".($_POST['up_or_down']);
        $myunits="select * from unit_of_work left join users on users.id=teacher_id where level_id=$user_level and username='$whoami'";
	$gotmyunits=mysql_query($myunits) or die("Error reported while executing the statement: $myunits<br />MySQL reported: ".mysql_error());
	while (list($unit_id,$description,$topic_id,$level_id,$teacher_id,$num_lessons,$public,$date_created)=mysql_fetch_array($gotmyunits))
		{
			$month=Month_Display(substr($date_created,9,2));
			$year=substr($date_created,1,4);
			$gettopic="select name from topic where id=$topic_id";
			$gottopic=mysql_query($gettopic) or die("Error reported while executing the statement: $gettopic<br />MySQL reported: ".mysql_error());
			echo "<h4 id='heading_".$unit_id."'><a class=\"ui-widget\" href='#'>".$description."</a></h4>";
			echo "<ul>";
			//echo "<li><a class=\"ui-widget\" href=\"../tplan/Lessons.php?unit_id=".$unit_id."&plan_type=newPlan\"'>Edit This Unit</a></li>";
			//echo "<li><a class=\"ui-widget\" href=\"javascript:deletePlan(".$unit_id.")\">Delete This Unit</a></li>";
			//echo "<li><br><h6>Select a Plan to Print</h6></li>";
			GetMyFreeLessons($unit_id,$num_lessons,$user_level);
		}
}
function GetMyFreeLessons($unit_id,$num_lessons,$user_level)
{
	for($i=1;$i<=$num_lessons;$i++){
        $getplanid="select lesson.id,lesson_num,theme from lesson left join theme on lesson.theme_id=theme.id where uow_id = $unit_id and lesson_num=$i";
	$gotplans=mysql_query($getplanid) or die("Error reported while executing the statement: $getplanid<br />MySQL reported: ".mysql_error());
        if ($user_level!=1){
        if (mysql_num_rows($gotplans)>0){
                list($plan_id,$lesson_num,$theme)=mysql_fetch_array($gotplans);
        	echo "<li style='width:600px;line-height:40px;*line-height:25px;'><div id='lesson_title_".$unit_id."_".$i."'><label style='*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Lesson ".$i.". ".$theme."</label><a class=\"ui-widget\" href='javascript:freePrintPlan(".$i.",".$unit_id.");'><img src='images/icon_printer_30.jpg' style='right:240px;position:absolute;' alt='print this lesson' title='print this lesson'></a></div></li>";
            }
            else{
        	//echo "<li style='width:600px;line-height:40px;*line-height:25px;'><div id='lesson_title_".$unit_id."_".$i."'><label style='font-style:italic;*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Lesson ".$i.". Unplanned</label><a class=\"ui-widget\" href=\"http://".$_SERVER['HTTP_HOST']."/tplan/Lessons.php?=".time()."&unit_id=".$unit_id."&plan_type=newPlan&lesson_num=".$i."\"'><img src='images/icon_edit_30.jpg' style='right:200px;position:absolute;' alt='edit this lesson' title='edit this lesson'></a></div></li>";
           }
        }
        else{
            if (mysql_num_rows($gotplans)>0){
                list($plan_id,$lesson_num,$theme)=mysql_fetch_array($gotplans);
        	echo "<li style='width:600px;line-height:40px;*line-height:25px;'><div id='lesson_title_".$unit_id."_".$i."'><label style='*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Lesson ".$i.". ".$theme."</label><a class=\"ui-widget\" href='javascript:freePrintPlan(".$i.",".$unit_id.");'><img src='images/icon_printer_30.jpg' style='right:240px;position:absolute;' alt='print this lesson' title='print this lesson'></a></div></li>";
            }
            else{

                    //echo "<li style='width:600px;line-height:40px;*line-height:25px;'><div id='lesson_title_".$unit_id."_".$i."'><label style='font-style:italic;*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Lesson ".$i.". Unplanned</label><a class=\"ui-widget\" href='javascript:trialNotification()'><img src='images/icon_edit_30.jpg' style='right:200px;position:absolute;' alt='edit this lesson' title='edit this lesson'></a></div></li>";
                }
           }
        }
	echo "</ul>";
}
function GetMyAssessments() // GetAllMyAssessments($assessType)
{
	$whoami=$_SESSION['id'];
	$filteroptions="where teacher_id=$whoami";
	$myunits="select * from unit_of_work $filteroptions  order by date_created desc";
	$gotmyunits=mysql_query($myunits) or die("Error reported while executing the statement: $myunits<br />MySQL reported: ".mysql_error());
	if(mysql_num_rows($gotmyunits)>0){
        while (list($unit_id,$description,$topic_id,$level_id,$teacher_id,$num_lessons,$public,$date_created)=mysql_fetch_array($gotmyunits))
		{
			$month=Month_Display(substr($date_created,9,2));
			$year=substr($date_created,1,4);
			$gettopic="select name from topic where id=$topic_id";
		        $gottopic=mysql_query($gettopic) or die("Error reported while executing the statement: $gettopic<br />MySQL reported: ".mysql_error());
                        echo "<h4 id='heading_".$unit_id."'><a class=\"ui-widget\" href='#'>".$description."</a> </h4>";
			echo "<ul>";
		        echo "<li style='width:600px;line-height:40px;*line-height:25px;'><table><tr><td width='500px'><label style='*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Class Assessment – Print &lsquo;I CAN&rsquo; statements for sharing objectives and displays</label></td><td width='30px'><a class=\"ui-widget\" href='javascript:mainPrintAssessment(1, ".$topic_id.", ".$level_id.",".$unit_id.")'><img src='images/assess_class_30.jpg' border='0' alt='print class assessment' title='print class assessment'></a></td></tr></table></li>";
			echo "<li style='width:600px;line-height:40px;*line-height:25px;'><table><tr><td width='500px'><label style='*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Individual Assessment – Print &lsquo;Individual Assessment for Learning&rsquo; worksheets</label></td><td width='30px'><a class=\"ui-widget\" href='javascript:mainPrintAssessment(2, ".$topic_id.", ".$level_id.",".$unit_id.")'><img src='images/assess_indiv_30.jpg' border='0'  alt='print individual assessment' title='print individual assessment'></a></td></tr></table></li>";
			echo "<li style='width:600px;line-height:40px;*line-height:25px;'><table><tr><td width='500px'><label style='*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Teacher Assessment – Assess each child with National Curriculum levels</label></td><td width='30px'><a class=\"ui-widget\" href='javascript:mainPrintAssessment(3, ".$topic_id.", ".$level_id.",".$unit_id.")'><img src='images/assess_teacher_30.jpg' border='0' alt='print class assessment' title='print class assessment'></a></td></tr></table></li>";
			echo "</ul>";
		}
                echo "<div><br/><div class='help' onclick='javascript:showHelpDialog(\"assessments\")'></div></div>";
        }
        else {
            echo "You Haven't created any plans yet.<br>Select the 'Create Plans' tab to start creating PE plans";
        }
}

function GetAllMyAssessments() // GetAllMyAssessments($assessType)
{
	$whoami=$_SESSION['id'];
	$filteroptions="where teacher_id=$whoami";
	if (($_POST['topic_filter']) AND ($_POST['topic_filter']!='none')) $filteroptions=$filteroptions." and topic_id=".$_POST['topic_filter'];
        if (($_POST['level_filter']) AND ($_POST['level_filter']!='none')) $filteroptions=$filteroptions." and level_id=".$_POST['level_filter'];
        if ((!$_POST['sorter']) OR ($_POST['sorter']=='none')) $sortoption=" order by date_created";
        else $sortoption="order by ".$_POST['sorter'];
        if ((!$_POST['up_or_down']) OR ($_POST['up_or_down']=='none')) $sortoption=$sortoption." DESC";
        else $sortoption=$sortoption." ".($_POST['up_or_down']);
        $myunits="select * from unit_of_work $filteroptions $sortoption";
	$gotmyunits=mysql_query($myunits) or die("Error reported while executing the statement: $myunits<br />MySQL reported: ".mysql_error());
	while (list($unit_id,$description,$topic_id,$level_id,$teacher_id,$num_lessons,$public,$date_created)=mysql_fetch_array($gotmyunits))
		{
			$month=Month_Display(substr($date_created,9,2));
			$year=substr($date_created,1,4);
			$gettopic="select name from topic where id=$topic_id";
		        $gottopic=mysql_query($gettopic) or die("Error reported while executing the statement: $gettopic<br />MySQL reported: ".mysql_error());
                        echo "<h4 id='heading_".$unit_id."'><a class=\"ui-widget\" href='#'>".$description."</a> </h4>";
			echo "<ul>";
		        echo "<li style='font-size:12px;width:600px;line-height:40px;*line-height:25px;'><label style='*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Class Assessment – Print &lsquo;I CAN&rsquo; statements for sharing objectives and displays</label><a class=\"ui-widget\" href='javascript:mainPrintAssessment(1, ".$topic_id.", ".$level_id.",".$unit_id.")'><img src='images/assess_class_30.jpg' style='right:100px;position:absolute;' alt='print class assessment' title='print class assessment'></a></li>";
			echo "<li style='font-size:12px;width:600px;line-height:40px;*line-height:25px;'><label style='*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Individual Assessment – Print &lsquo;Individual Assessment for Learning&rsquo; worksheets</label><a class=\"ui-widget\" href='javascript:mainPrintAssessment(2, ".$topic_id.", ".$level_id.",".$unit_id.")'><img src='images/assess_indiv_30.jpg' style='right:100px;position:absolute;' alt='print individual assessment' title='print individual assessment'></a></li>";
			echo "<li style='font-size:12px;width:600px;line-height:40px;*line-height:25px;'><label style='*zoom:1;*vertical-align:bottom;*padding-top:20px;'>Teacher Assessment – Assess each child with National Curriculum levels</label><a class=\"ui-widget\" href='javascript:mainPrintAssessment(3, ".$topic_id.", ".$level_id.",".$unit_id.")'><img src='images/assess_teacher_30.jpg' style='right:100px;position:absolute;' alt='print class assessment' title='print class assessment'></a></li>";
			echo "</ul>";
		}
}
// misc functions
function Month_Display($month)
{
	switch ($month) {
		case "01":
			return "January";
			break;
		case "02":
			return "February";
			break;
		case "03":
			return "March";
			break;
		case "04":
			return "April";
			break;
		case "05":
			return "May";
			break;
		case "06":
			return "June";
			break;
		case "07":
			return "July";
			break;
		case "08":
			return "August";
			break;
		case "09":
			return "September";
			break;
		case "10":
			return "October";
			break;
		case "11":
			return "November";
			break;
		case "12":
			return "December";
			break;
		}
                

}
function deleteplan($uow_id)
{
/*	$getlessonsql="select id from lesson where uow_id=$uow_id";
	$getlessonresult=mysql_query($getlessonsql) or die("Error reported while executing the statement: $getlessonsql<br />MySQL reported: ".mysql_error());
	while (list($lesson_id)=mysql_fetch_array($getlessonresult))
	{
		$removeoldobjectives=mysql_query("delete from lesson_objectives where lesson_id=$lesson_id");
		$removeoldict=mysql_query("delete from lesson_ict where lesson_id=$lesson_id");
		$removeoldkeywords=mysql_query("delete from lesson_keywords where lesson_id=$lesson_id");
		$removeoldnumeracy=mysql_query("delete from lesson_numeracy where lesson_id=$lesson_id");
		$removeoldrisk_assessment=mysql_query("delete from lesson_risk_assessment where lesson_id=$lesson_id");
		$removeoldcitizenship=mysql_query("delete from lesson_citizenship where lesson_id=$lesson_id");
		$removeoldactivity=mysql_query("delete from lesson_activities where lesson_id=$lesson_id");
		$removeoldlesson=mysql_query("delete from lesson where uow_id=$uow_id");
	}
	$removeunit="delete from unit_of_work where id=$uow_id";
	$removeunitresult=mysql_query($removeunit) or die("Error reported while executing the statement:$removeunit <br />MySQL reported: ".mysql_error());*/
    $removeunit="update unit_of_work set teacher_id=000000 where id=$uow_id";#
    	$removeunitresult=mysql_query($removeunit) or die("Error reported while executing the statement:$removeunit <br />MySQL reported: ".mysql_error());
        GetMyUnits();
}
function deleteplanfromall($uow_id)
{
	$getlessonsql="select id from lesson where uow_id=$uow_id";
	$getlessonresult=mysql_query($getlessonsql) or die("Error reported while executing the statement: $getlessonsql<br />MySQL reported: ".mysql_error());
	while (list($lesson_id)=mysql_fetch_array($getlessonresult))
	{
		$removeoldobjectives=mysql_query("delete from lesson_objectives where lesson_id=$lesson_id");
		$removeoldict=mysql_query("delete from lesson_ict where lesson_id=$lesson_id");
		$removeoldkeywords=mysql_query("delete from lesson_keywords where lesson_id=$lesson_id");
		$removeoldnumeracy=mysql_query("delete from lesson_numeracy where lesson_id=$lesson_id");
		$removeoldrisk_assessment=mysql_query("delete from lesson_risk_assessment where lesson_id=$lesson_id");
		$removeoldcitizenship=mysql_query("delete from lesson_citizenship where lesson_id=$lesson_id");
		$removeoldactivity=mysql_query("delete from lesson_activities where lesson_id=$lesson_id");
		$removeoldlesson=mysql_query("delete from lesson where uow_id=$uow_id");
	}
	$removeunit="delete from unit_of_work where id=$uow_id";
	$removeunitresult=mysql_query($removeunit) or die("Error reported while executing the statement:$removeunit <br />MySQL reported: ".mysql_error());
        GetAllMyUnits();
        echo "~";
        GetAllMyAssessments();
}
function GetGenres()
{
	$sql="select id,description from genre order by description";
	$genres=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('genres',$genres);
}
function GetSomeGenres($level_id)
{
	$sql="select genre_id,genre_description from genre_description where genre_level=$level_id and genre_description!='' order by genre_description";
	$genres=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
        echo "<h4><select name=\"sel_genre\" id =\"sel_genre\" size=\"1\"  onchange=\"getSomeTopics(this.value)\"><option value=\" \" selected=\"selected\">All Activities</option>";
        CreateList('genres',$genres);
        echo "</select></h4>";
	}
function GetSomeTopics($genre_id,$level_id)
{
	if ($genre_id!=0) $sql="select id,name,status,topic_description from topic left join topic_description on id=topic_id where genre=$genre_id and topic_level=$level_id and topic_description!='' order by topic_description";
        else $sql="select topic.id,name,status,topic_description,genre.description from topic left join topic_description on id=topic_id left join genre on genre=genre.id where topic_level=$level_id and topic_description!='' order by genre.description";
	$topics=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
        echo "<h4><select name=\"sel_topic\" id =\"sel_topic\" size=\"1\"><option value=\" \" selected=\"selected\">Select an Activity</option>";
        CreateTopicList('topics',$topics);
        echo "</select></h4>";
	}
function GetTopics()
{
	$sql="select id,name from topic";
	$topics=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('topics',$topics);
}
function GetLevels($topic_id=0)
{
	$sql="select id from level";
	$levels=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('levels',$levels);
}
function CreateList($what,$things)
{
	$what_id=$what."_id";
	$what_name=$what."_name";
	if (!$things) echo "No ".$what." currrently defined";
	else {
	while (list($what_id,$what_name) = mysql_fetch_array($things))
	{
		if (!$what_name) $what_name=$what_id;
		echo "<option value=".$what_id.">".$what_name."</option>";
 	}
	}
}
function CreateSpecialList($what,$things)
{
	$what_id=$what."_id";
	$what_name=$what."_name";
	if (!$things) echo "No ".$what." currrently defined";
	else {
	while (list($what_id,$what_name,$what_status,$what_description) = mysql_fetch_array($things))
	{
		if ($what_status=="L"||$what_status=="R")
                {
                    echo "<option value=".$what_id." title='my title'>".$what_description."</option>";
                }
                else
                {
                    echo "<option style='color:#bbbbbb' value=".$what_id."  title='my title'>".$what_description."</option>";
                }

 	}
	}
}
function CreateTopicList($what,$things)
{
	$what_id=$what."_id";
	$what_name=$what."_name";
	$last_genre='';
        if (!$things) echo "No ".$what." currrently defined";
        else {
	while (list($what_id,$what_name,$what_status,$what_description,$genre_description) = mysql_fetch_array($things))
	{
            if ($genre_description!=$last_genre) {
                if ($last_genre!='') echo "</optgroup>";
                $last_genre=$genre_description;
                echo "<optgroup label='".$genre_description."'>";
            }
            if ($what_status=="L"||$what_status=="R")
                {
                    echo "<option value=".$what_id." title='my title'>".$what_description."</option>";
                }
                else
                {
                    echo "<option style='color:#bbbbbb' value=".$what_id."  title='my title'>".$what_description."</option>";
                }

 	}
	}
}
function EditUser($user)
{
    $q = "SELECT first_name,last_name,school,postcode,email FROM users WHERE username = '$user'";
      $result = mysql_query($q) or die("Error reported while executing the statement: $q<br />MySQL reported: ".mysql_error());
      /* Error occurred, return given name by default */
      if(!$result || (mysql_numrows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $userinfo = mysql_fetch_array($result,MYSQL_NUM);
      echo implode(",",$userinfo);
      //echo json_encode($userinfo);
}
function CanIDoThis($topic_id)
{
    $get_status="select status from topic where id=$topic_id";
    $got_status=mysql_query($get_status) or die("Error reported while executing the statement: $get_status<br />MySQL reported: ".mysql_error());
    $topic_status_array=mysql_fetch_array($got_status);
    $topic_status=$topic_status_array['status'];
    $username=$_SESSION['username'];
    $logged_in="select userlevel from users where username='$username'";
    $result = mysql_query($logged_in) or die("Error reported while executing the statement: $logged_in<br />MySQL reported: ".mysql_error());
    $userinfo=mysql_fetch_array($result);
    switch ($userinfo['userlevel']) {
		case "9":
                    echo $userinfo['userlevel']."~good_to_go~".$topic_status;
                    break;
                case "5":
                    if (($topic_status=="M")||($topic_status=="L")||($topic_status=="R")) echo $userinfo['userlevel']."~good_to_go~".$topic_status;
                    else echo $userinfo['userlevel']."~level_5_not_allowed~".$topic_status;
                    break;
                case "1":
                    if (($topic_status=="L")||($topic_status=="R")) echo $userinfo['userlevel']."~good_to_go~".$topic_status;
                    else echo $userinfo['userlevel']."~level_1_not_allowed~".$topic_status;
                    break;
                default:
                    echo "0~not_logged_in~".$topic_status;
                    break;
    }
    
}
function username_available($username)
{
     if (!$username){
         print '{"msg":"Username can\'t be blank","valid":false,"desc":"Username can\'t be blank"}';
     }
     else {
            $q = "SELECT username FROM users WHERE username = '$username'";
            $result = mysql_query($q);
            if (mysql_num_rows($result) > 0){
                print '{"msg":"Username has already taken","valid":false,"desc":"That username has been taken. Please choose another"}';
            }
            else {
                print '{"msg":"Available!","valid":true,"desc":"Available!"}';
            }
     }
}
function schoolname_available($schoolname)
{
     if (!$schoolname){
         print '{"msg":"Schoolname can\'t be blank","valid":false,"desc":"Schoolname can\'t be blank"}';
     }
     else {
            //$q = "SELECT school FROM school WHERE school = '$schoolname'";
            //$result = mysql_query($q);
            //if (mysql_num_rows($result) > 0){
           //     print '{"msg":"schoolname has already subscribed","valid":false,"desc":"That school has already subscribed. Please contact PE Planning"}';
           // }
            //else {
                print '{"msg":"Available!","valid":true,"desc":"Available!"}';
            //}
     }
}
function email_available($email)
{
     if (!$email){
         print '{"msg":"Email can\'t be blank","valid":false,"desc":"Email can\'t be blank"}';
     }
     else {
         $q = "SELECT email FROM users WHERE email = '$email'";
            $result = mysql_query($q);
            if (mysql_num_rows($result) > 0) {
                print '{"msg":"Are you sure? This email is in use.","valid":false,"color":"#FFE2CF"}';
            }
            else {
                print '{"msg":"Available!","valid":true,"color":"green"}';
            }
     }
}
function school_email_available($email)
{
     if (!$email){
         print '{"msg":"Email can\'t be blank","valid":false,"desc":"Email can\'t be blank"}';
     }
     else {
         $q = "SELECT email FROM school WHERE email = '$email'";
            $result = mysql_query($q);
            if (mysql_num_rows($result) > 0) {
                print '{"msg":"Are you sure? This email is in use.","valid":false,"color":"#FFE2CF"}';
            }
            else {
                print '{"msg":"Available!","valid":true,"color":"green"}';
            }
     }
}
function GetHelp($help_topic)
{
    $sql="select text from help where name='$help_topic'";
    $result=mysql_query($sql);
    if(mysql_num_rows($result)>=1)
    {
    list($help)=mysql_fetch_array($result);
    $help_array=unserialize(base64_decode($help));
    echo "<ul class='help-dialog'>";
    foreach ($help_array as $help_point)
    {
        if($help_point){
        echo "<li class='help-dialog'>".stripslashes($help_point)."</li>";
        }
    }
    echo "</ul>";
    }
else echo "<label class='error'>no help for this topic</label>";
}
function GetPrintContent($lesson_num,$uow_id)
{

   // first we get the unit of work details
        $unit=mysql_query("select * from unit_of_work where id =$uow_id")  or die("Error reported while executing the statement: <br />MySQL reported: ".mysql_error());;
	list($unit_id,$unit_description,$topic_id,$level_id,$teacher_id,$num_lessons,$public,$date_created)=mysql_fetch_array($unit);
        $_SESSION['level']=$level_id;
        $_SESSION['title']=$unit_description;
   //get the topic details
        $topic_name=mysql_query("select name from topic where id=$topic_id");
	list ($_SESSION['mysubject'])=mysql_fetch_array($topic_name);
   // get the school, this may need some thought regarding setting their accounts up
        $school_name=mysql_query("select school from school");
	list($_SESSION['school'])=mysql_fetch_array($school_name);
   // get the teacher details, again they have to set this up in their accounts
	$mydetails=mysql_query("select name, gender, school, postcode from users where id=$teacher_id");
	list($name,$gender,$school,$postcode)=mysql_fetch_array($mydetails);
	$_SESSION['name']=$name;
        $_SESSION['school']=$school;
   // get the assistance details
        $lesson=mysql_query("select id from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
        list ($lesson_id)=mysql_fetch_array($lesson);
        $_SESSION['assistance']=mysql_query("select ta,sen from lesson where id=$lesson_id");
  // get the theme for the lesson, the teacher notes and any evaluation guidance
	//$themes=mysql_query("select lesson.theme_id,theme.theme, topic_theme.notes,evaluation.evaluation from lesson left join theme on lesson.theme_id=theme.id left join topic_theme on theme.id=topic_theme.theme_id left join topic_theme_evaluation on topic_theme_evaluation.theme_id=topic_theme.theme_id left join evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where lesson.id=$lesson_id and topic_theme.topic_id=$topic_id and topic_theme_evaluation.level=$level_id and evaluation.evaluation is not NULL order by topic_theme.notes desc");
        $themes=mysql_query("select lesson.theme_id,theme.theme, topic_theme.notes from lesson left join theme on lesson.theme_id=theme.id left join topic_theme on theme.id=topic_theme.theme_id where lesson.id=$lesson_id and topic_theme.topic_id=$topic_id and topic_theme.level=$level_id order by topic_theme.notes desc");
        list($theme_id,$theme,$teacher_notes)=mysql_fetch_array($themes);
        $_SESSION['theme']="Lesson ".$lesson_num." of ".$num_lessons." - ".$theme;
   // put the teachers notes into an array aqfter checking for encoding and the metohod they were stored
        if (checkBase64Encoded($teacher_notes)) $_SESSION['teacher_notes_arr']=unserialize(base64_decode($teacher_notes));
        else  $_SESSION['teacher_notes_arr']=unserialize($teacher_notes);
        if ( $_SESSION['teacher_notes_arr']==false)  $_SESSION['teacher_notes_arr']=explode('^',$teacher_notes);
        //$evaluations=mysql_query("select lesson.theme_id,theme.theme, topic_theme.notes,evaluation.evaluation from lesson left join theme on lesson.theme_id=theme.id left join topic_theme on theme.id=topic_theme.theme_id left join topic_theme_evaluation on topic_theme_evaluation.theme_id=topic_theme.theme_id left join evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where lesson.id=$lesson_id and topic_theme.topic_id=$topic_id and topic_theme_evaluation.level=$level_id and evaluation.evaluation is not NULL order by topic_theme.notes desc");
        $evaluations=mysql_query("select evaluation.evaluation from evaluation left join topic_theme_evaluation on topic_theme_evaluation.evaluation_id=evaluation.id where topic_theme_evaluation.topic_id=$topic_id and topic_theme_evaluation.level=$level_id and topic_theme_evaluation.theme_id=$theme_id and evaluation.evaluation is not NULL");
        list($evaluation)=mysql_fetch_array($evaluations);
  // put the evaluation guidance in an array in the same way as teacher notes above
        //if (checkBase64Encoded($_SESSION['evaluation_arr'])) $_SESSION['evaluation_arr']=unserialize(base64_decode($evaluation));
        //else
        $_SESSION['evaluation_arr']=unserialize($evaluation);
        if ($_SESSION['evaluation_arr']==false) $_SESSION['evaluation_arr']=explode('?',$evaluation);
  // get the objectives for the lesson and store in an array
        $_SESSION['objectives']=mysql_query("select objective_id,objective from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id where lesson.id=$lesson_id order by objectives.id");
	$_SESSION['keywords']=mysql_query("select keyword_id,keyword from lesson_keywords left join keywords on keywords.id=lesson_keywords.keyword_id left join lesson on lesson.id=lesson_keywords.lesson_id where lesson.id=$lesson_id");
	$_SESSION['icts']=mysql_query("select ict_id,description from lesson_ict left join ICT on ICT.id=ict_id left join lesson on lesson.id=lesson_ict.lesson_id where lesson.id=$lesson_id");
	$_SESSION['numeracys']=mysql_query("select numeracy_id,description from lesson_numeracy left join numeracy on numeracy.id=numeracy_id left join lesson on lesson.id=lesson_numeracy.lesson_id where lesson.id=$lesson_id");
	$_SESSION['citizenships']=mysql_query("select citizenship_id,description from lesson_citizenship left join citizenship on citizenship.id=citizenship_id left join lesson on lesson.id=lesson_citizenship.lesson_id where lesson.id=$lesson_id");
	$_SESSION['risk_assessments']=mysql_query("select ra_id,description from lesson_risk_assessment left join risk_assessment on risk_assessment.id=ra_id left join lesson on lesson.id=lesson_risk_assessment.lesson_id where lesson.id=$lesson_id");
	$_SESSION['equipment']=mysql_query("select la_id,activity_id,lesson_activities.time as la_time,lesson_part.description as lesson_part,content.name as content_name,content.description as content_description,content.time as content_time, equipment.description as equipment from lesson_activities left join content on content.content_id=activity_id left join lesson on lesson.id=lesson_activities.lesson_id left join content_lesson_part on content_lesson_part.content_id = lesson_activities.activity_id left join lesson_part on lesson_part.id = content_lesson_part.lesson_part_id left join content_equipment on activity_id=content_equipment.content_id left join equipment on content_equipment.equipment_id=equipment.id where lesson.id=$lesson_id order by activity_num");
	$_SESSION['activities']=mysql_query("select la_id,activity_id,lesson_activities.time as la_time,lesson_part.description as lesson_part,content.name as content_name,content.description as content_description,content.time as content_time from lesson_activities left join content on content.content_id=activity_id left join lesson on lesson.id=lesson_activities.lesson_id left join content_lesson_part on content_lesson_part.content_id = lesson_activities.activity_id left join lesson_part on lesson_part.id = content_lesson_part.lesson_part_id where lesson.id=$lesson_id order by activity_num");
	if ($_SESSION['activities'])
	{
		$act_num=1;
		$num_acts=mysql_num_rows($_SESSION['activities']);
		while (list($la_id,$activity_id,$time,$lesson_part,$content_name,$content_description,$content_time)=mysql_fetch_array($_SESSION['activities']))
		{
			if ($lesson_part) $lesson_part_string[$act_num]=$lesson_part;
                                $strands=mysql_query("select strand_id,strand from lesson_activity_strand left join strand on strand.id=strand_id left join lesson_activities on lesson_activities.la_id=lesson_activity_strand.la_id where lesson_activity_strand.la_id = $la_id");
				if ($strands)
				{
					$_SESSION['strands'][$act_num]=$strands;
                                }
				$teaching_points=mysql_query("SELECT point FROM point LEFT JOIN content_point ON content_point.point_id = point.id LEFT JOIN lesson_activity_point ON lesson_activity_point.point_id = point.id WHERE lesson_activity_point.la_id=$la_id and content_id = $activity_id ORDER BY point_num");
				if ($teaching_points)
				{
					$_SESSION['teaching_points'][$act_num]=$teaching_points;
                                }
				$hard_differentiations=mysql_query("select diff_id,differentiation,difficulty from lesson_activity_differentiation left join differentiation on diff_id=differentiation.id left join lesson_activities on lesson_activities.la_id=lesson_activity_differentiation.la_id where lesson_activity_differentiation.la_id = $la_id and difficulty = 'H' order by difficulty desc");
				if ($hard_differentiations)
				{
					$_SESSION['hard_differentiations'][$act_num]=$hard_differentiations;
                                }
				$easy_differentiations=mysql_query("select diff_id,differentiation,difficulty from lesson_activity_differentiation left join differentiation on diff_id=differentiation.id left join lesson_activities on lesson_activities.la_id=lesson_activity_differentiation.la_id where lesson_activity_differentiation.la_id = $la_id and difficulty = 'E' order by difficulty desc");
				if ($easy_differentiations)
				{
					$_SESSION['easy_differentiations'][$act_num]=$easy_differentiations;
                                }
				$_SESSION['progressions'][$act_num]=mysql_query("select la_pr_id,pr_id,progression from lesson_activity_progression left join progression on progression.id=pr_id left join lesson_activities on lesson_activities.la_id=lesson_activity_progression.la_id where lesson_activity_progression.la_id = $la_id");
				if ($_SESSION['progressions'][$act_num])
				{
				       $_SESSION['num_progs'][$act_num]=mysql_num_rows($_SESSION['progressions'][$act_num]);
                                        for ($i = 0 ; $i <= count($_SESSION['num_progs'][$act_num]) ; $i++)
                                        {
                                            list($la_pr_id,$progression_id,$progression)=mysql_fetch_array($_SESSION['progressions'][$act_num]);
					    $_SESSION['prog_points'][$act_num][$i]=mysql_query("select point_id,point from lesson_activity_progression_point left join lesson_activity_progression on lesson_activity_progression.la_pr_id=lesson_activity_progression_point.la_pr_id left join point on point.id=point_id where  lesson_activity_progression.la_id = $la_id and lesson_activity_progression.pr_id=$progression_id order by point.id desc");
                                            //$_SESSION['prog_points'][$act_num][$i]=mysql_query("select point_id,point from lesson_activity_progression_point left join lesson_activity_progression on lesson_activity_progression.la_pr_id=lesson_activity_progression_point.la_pr_id left join point on point.id=point_id where  lesson_activity_progression_point.la_pr_id = $la_pr_id");
                                        }
				}
				$_SESSION['analysess'][$act_num]=mysql_query("select analyses_id,content.name as analysis_title,content.description as analysis from lesson_activity_analyses left join content on content.content_id=analyses_id left join lesson_activities on lesson_activities.la_id=lesson_activity_analyses.la_id where lesson_activity_analyses.la_id = $la_id");
				if ($_SESSION['analysess'][$act_num])
				{
				      	$num_anals=mysql_num_rows($_SESSION['analysess'][$act_num]);
                                        for ($i = 0 ; $i < $num_anals ; $i++)
                                            {
						list($analyses_id,$content_name,$content_description)=mysql_fetch_array($_SESSION['analysess'][$act_num]);
                                                $_SESSION['anal_points'][$act_num][$i]=mysql_query("select point_id,point from point left join content_point on content_point.point_id=point.id where content_point.content_id=$analyses_id");
                                            }
                                }
		$act_num++;
		}
                if (mysql_num_rows($_SESSION['activities'])>0) mysql_data_seek($_SESSION['activities'],0);
	}
}
function checkBase64Encoded($encodedString) {
    $length = strlen($encodedString);

    // Check every character.
    for ($i = 0; $i < $length; ++$i) {
      $c = $encodedString[$i];
      if (
        ($c < '0' || $c > '9')
        && ($c < 'a' || $c > 'z')
        && ($c < 'A' || $c > 'Z')
        && ($c != '+')
        && ($c != '/')
        && ($c != '=')
      ) {
        // Bad character found.
        return false;
      }
    }
    // Only good characters found.
    return true;
  }

function sp_utf2ascii ($string) {
	$string=iconv('utf-8','windows-1252',$string);
	//$win = "Ã¬ÂšÃ¨Ã¸ÂžÃ½Ã¡Ã­Ã©ÂÃ²Ã¯ÃºÃ¹Ã³Ã¶Ã¼Ã¤ÃŒÂŠÃˆÃ˜ÂŽÃÃÃÃ‰ÂÃ’ÃÃšÃ™Ã“Ã–ÃœÃ‹Ã„\x97\x96\x91\x92\x84\x93\x94\xAB\xBB";
	//$ascii="escrzyaietnduuoouaESCRZYAIETNDUUOOUEAOUEA\x2D\x2D\x27\x27\x22\x22\x22\x22\x22";
        $win = Array("â€“","â€™");
        $ascii=Array("-","'");
	$string = str_replace($win,$ascii,$string);
	return $string;
	}
function utf2ascii($s)
  {
      static $tbl =
      array(
      "\xc3\xa1"=>"a","\xc3\xa4"=>"a","\xc4\x8d"=>"c","\xc4\x8f"=>"d",
      "\xc3\xa9"=>"e","\xc4\x9b"=>"e","\xc3\xad"=>"i","\xc4\xbe"=>"l",
      "\xc4\xba"=>"l","\xc5\x88"=>"n","\xc3\xb3"=>"o","\xc3\xb6"=>"o",
      "\xc5\x91"=>"o","\xc3\xb4"=>"o","\xc5\x99"=>"r","\xc5\x95"=>"r",
      "\xc5\xa1"=>"s","\xc5\xa5"=>"t","\xc3\xba"=>"u","\xc5\xaf"=>"u",
      "\xc3\xbc"=>"u","\xc5\xb1"=>"u","\xc3\xbd"=>"y","\xc5\xbe"=>"z",
      "\xc3\x81"=>"A","\xc3\x84"=>"A","\xc4\x8c"=>"C","\xc4\x8e"=>"D",
      "\xc3\x89"=>"E","\xc4\x9a"=>"E","\xc3\x8d"=>"I","\xc4\xbd"=>"L",
      "\xc4\xb9"=>"L","\xc5\x87"=>"N","\xc3\x93"=>"O","\xc3\x96"=>"O",
      "\xc5\x90"=>"O","\xc3\x94"=>"O","\xc5\x98"=>"R","\xc5\x94"=>"R",
      "\xc5\xa0"=>"S","\xc5\xa4"=>"T","\xc3\x9a"=>"U","\xc5\xae"=>"U",
      "\xc3\x9c"=>"U","\xc5\xb0"=>"U","\xc3\x9d"=>"Y","\xc5\xbd"=>"Z");
      return strtr($s, $tbl);
  }
  function CleanFiles($dir)
{
    //Delete temporary files
    $t=time();
    $h=opendir($dir);
    while($file=readdir($h))
    {
        if(substr($file,0,3)=='tmp' and substr($file,-4)=='.pdf')
        {
            $path=$dir.'/'.$file;
            if($t-filemtime($path)>3600)
                @unlink($path);
        }
        if(substr($file,0,3)=='tmp' and substr($file,-5)=='.html')
        {
            $path=$dir.'/'.$file;
            if($t-filemtime($path)>3600)
                @unlink($path);
        }
    }
    closedir($h);
}
function CreateDefaultUnit($topic_id,$topic,$level,$description,$num_lessons)
{
$teacher_id=$_SESSION['id'];
$topic_id=$_GET['topic_id'];
$topic=$_GET['topic'];
$level=$_GET['level'];
if ($level=='0.0') $level_string=' - foundation level - ';
else $level_string=' - level - '.$level;
$description=$_GET['description'];
if (!$description) $description=$topic.$level_string." ".date("F j, Y, g:i a");
$num_lessons=$_GET['num_lessons'];
$get_plans=list($set_plan_id)=mysql_fetch_array(mysql_query("select set_plan_id from set_plans where topic_id=$topic_id and level=$level and num_lessons=$num_lessons"));
if ($set_plan_id)
    {
	$get_lessons=mysql_query("select lesson_id,lesson_num from set_plan_lessons where set_plan_id=$set_plan_id order by lesson_num");
	while (list($lesson_id,$i)=mysql_fetch_array($get_lessons))
		{
	         $lessons[$i]=$lesson_id;
                 $themes[$i]=mysql_query("select theme_id,theme.theme from lesson left join theme on theme_id=theme.id where lesson.id=$lesson_id") or die(mysql_error());
                 $sens[$i]=mysql_query("select ta,sen from lesson where id=$lesson_id") or die(mysql_error());
                 $objectives[$i]=mysql_query("select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join topic_objectives on topic_objectives.objectives_id=lesson_objectives.objective_id where lesson.id=$lesson_id") or die(mysql_error());
                 $keywords[$i]=mysql_query("select keyword_id from lesson_keywords left join lesson on lesson.id=lesson_keywords.lesson_id where lesson.id=$lesson_id") or die(mysql_error());
                 $ict[$i]=mysql_query("select ict_id from lesson_ict left join lesson on lesson.id=lesson_ict.lesson_id where lesson.id=$lesson_id") or die(mysql_error());
                 $numeracy[$i]=mysql_query("select numeracy_id from lesson_numeracy left join lesson on lesson.id=lesson_numeracy.lesson_id where lesson.id=$lesson_id") or die(mysql_error());
                 $citizenship[$i]=mysql_query("select citizenship_id from lesson_citizenship left join lesson on lesson.id=lesson_citizenship.lesson_id where lesson.id=$lesson_id") or die(mysql_error());
                 $risk_assessment[$i]=mysql_query("select ra_id from lesson_risk_assessment left join lesson on lesson.id=lesson_risk_assessment.lesson_id where lesson.id=$lesson_id") or die(mysql_error());
                 $activities[$i]=mysql_query("select la_id,activity_id,time,activity_num,lesson_part.description from lesson_activities left join lesson on lesson.id=lesson_activities.lesson_id left join content_lesson_part on content_lesson_part.content_id = lesson_activities.activity_id left join lesson_part on lesson_part.id = content_lesson_part.lesson_part_id where lesson.id=$lesson_id order by activity_num") or die(mysql_error());
                                if ($activities[$i])
                                {
                                $a=1;
                                while (list($la_id,$activity_id,$time,$activity_num,$lesson_part)=mysql_fetch_array($activities[$i]))
                                        {
                                                $strands[$i][$a]=mysql_query("select strand_id from lesson_activity_strand left join lesson_activities on lesson_activities.la_id=lesson_activity_strand.la_id where lesson_activity_strand.la_id = $la_id") or die(mysql_error());
                                                $teaching_points[$i][$a]=mysql_query("select point_id from lesson_activity_point left join lesson_activities on lesson_activities.la_id=lesson_activity_point.la_id where lesson_activity_point.la_id = $la_id") or die(mysql_error());
                                                $differentiations[$i][$a]=mysql_query("select diff_id from lesson_activity_differentiation left join lesson_activities on lesson_activities.la_id=lesson_activity_differentiation.la_id where lesson_activity_differentiation.la_id = $la_id") or die(mysql_error());
                                                $progressions[$i][$a]=mysql_query("select la_pr_id,pr_id from lesson_activity_progression left join lesson_activities on lesson_activities.la_id=lesson_activity_progression.la_id where lesson_activity_progression.la_id = $la_id") or die(mysql_error());
                                                if ($progressions[$i][$a])
                                                        {
                                                                $p=1;
                                                                while (list($la_pr_id,$progression_id)=mysql_fetch_array($progressions[$i][$a]))
                                                                {
                                                                        $prog_points[$i][$a][$p]=mysql_query("select point_id from lesson_activity_progression_point left join lesson_activity_progression on lesson_activity_progression.la_pr_id=lesson_activity_progression_point.la_pr_id where lesson_activity_progression.la_id = $la_id and lesson_activity_progression.pr_id=$progression_id") or die(mysql_error());
                                                                        $p++;
                                                                }
                                                        }
                                                        $analysess[$i][$a]=mysql_query("select analyses_id from lesson_activity_analyses left join lesson_activities on lesson_activities.la_id=lesson_activity_analyses.la_id where lesson_activity_analyses.la_id = $la_id") or die(mysql_error());
                                                        if ($analysess[$i][$a])
                                                        {
                                                                $b=1;
                                                                while (list($analyses_id)=mysql_fetch_array($analysess[$i][$a]))
                                                                {
                                                                        $anal_points[$i][$a][$b]=mysql_query("select point_id from lesson_activity_analyses_point left join lesson_activity_analyses on lesson_activity_analyses.la_an_id=lesson_activity_analyses_point.la_an_id where lesson_activity_analyses.la_id = $la_id and lesson_activity_analyses.analyses_id=$analyses_id") or die(mysql_error());
                                                                        $b++;
                                                                }
                                                        }
                                        $a++;

                                        }
                                }
                            }
                            /* Save the Unit*/
                            $savesql="insert into unit_of_work (description, topic_id, level_id, teacher_id, num_lessons) values ('$description',$topic_id,$level,$teacher_id,$num_lessons)";
                            $saveresult=mysql_query($savesql) or die("Error reported while executing the statement: $savesql<br />MySQL reported: ".mysql_error());
                            $unit_id=mysql_insert_id();
                            // Save the lessons
                            for ($j=1;$j<=$num_lessons;$j++)
                            {
                                list($theme_id)=mysql_fetch_array($themes[$j]);if (!$theme_id) $theme_id=0;
                                list($ta,$sen)=mysql_fetch_array($sens[$j]);
                                $createlesson="insert into lesson (uow_id,lesson_num,theme_id,ta,sen) values ($unit_id,$j,$theme_id,'$ta','$sen')";
                                $createlessonresult=mysql_query($createlesson) or die(mysql_error().$createlesson);
                                $lesson_id=mysql_insert_id();
                                if ($objectives[$j])
                                {
                                while (list ($objective_id,$objective,$strand_id)=mysql_fetch_array($objectives[$j]))
                                    {
                                        $createobjective="insert into lesson_objectives (lesson_id,objective_id) values ($lesson_id,$objective_id)";
                                        $createobjectiveresult=mysql_query($createobjective) or die("Error reported while executing the statement: $createobjective<br />MySQL reported: ".mysql_error());
                                    }
                                }
                                if ($ict[$j])
                                {
                                while (list ($ict_id)=mysql_fetch_array($ict[$j]))
                                    {
                                        $createict="insert into lesson_ict (lesson_id,ict_id) values ($lesson_id,$ict_id)";
                                        $createictresult=mysql_query($createict) or die("Error reported while executing the statement: $createict<br />MySQL reported: ".mysql_error());
                                    }
                                }
                                if ($keywords[$j])
                                {
                                while (list ($keywords_id)=mysql_fetch_array($keywords[$j]))
                                    {
                                        $createkeywords="insert into lesson_keywords (lesson_id,keyword_id) values ($lesson_id,$keywords_id)";
                                        $createkeywordsresult=mysql_query($createkeywords) or die("Error reported while executing the statement: $createkeywords<br />MySQL reported: ".mysql_error());
                                    }
                                }
                                if ($numeracy[$j])
                                {
                                while (list ($numeracy_id)=mysql_fetch_array($numeracy[$j]))
                                    {
                                        $createnumeracy="insert into lesson_numeracy (lesson_id,numeracy_id) values ($lesson_id,$numeracy_id)";
                                        $createnumeracyresult=mysql_query($createnumeracy) or die("Error reported while executing the statement: $createnumeracy<br />MySQL reported: ".mysql_error());
                                    }
                                }
                                if ($risk_assessment[$j])
                                {
                                while (list ($risk_assessment_id)=mysql_fetch_array($risk_assessment[$j]))
                                    {
                                        $createrisk_assessment="insert into lesson_risk_assessment (lesson_id,ra_id) values ($lesson_id,$risk_assessment_id)";
                                        $createrisk_assessmentresult=mysql_query($createrisk_assessment) or die("Error reported while executing the statement: $createrisk_assessment<br />MySQL reported: ".mysql_error());
                                    }
                                }
                                if ($citizenship[$j])
                                {
                                while (list ($citizenship_id)=mysql_fetch_array($citizenship[$j]))
                                    {
                                        $createcitizenship="insert into lesson_citizenship (lesson_id,citizenship_id) values ($lesson_id,$citizenship_id)";
                                        $createcitizenshipresult=mysql_query($createcitizenship) or die("Error reported while executing the statement: $createcitizenship<br />MySQL reported: ".mysql_error());
                                    }
                                }
                                if (mysql_num_rows($activities[$j])>0)
                                {
                                $a=1;
                                mysql_data_seek($activities[$j],0);
                                while (list($la_id,$activity_id,$time,$activity_num,$lesson_part)=mysql_fetch_array($activities[$j]))
                                {
                                        if ($activity_id)
                                        {
                                                $createactivity="insert into lesson_activities (lesson_id,activity_id,time,activity_num) values ($lesson_id,$activity_id,'$time',$activity_num)";
                                                $createactivityresult=mysql_query($createactivity) or die("Error reported while executing the statement: $createactivity<br />MySQL reported: ".mysql_error());
                                                $la_id=mysql_insert_id();
                                                if ($teaching_points[$j][$a])
                                                {
                                                while ( list ($teach_point_id)=mysql_fetch_array($teaching_points[$j][$a]))
                                                    {
                                                        $createteachpoint="insert into lesson_activity_point (la_id,point_id) values ($la_id,$teach_point_id)";
                                                        $createteachpointresult=mysql_query($createteachpoint) or die("Error reported while executing the statement: $createteachpoint<br />MySQL reported: ".mysql_error());
                                                    }
                                                }
                                                if ($strands[$j][$a])
                                                {
                                                while ( list ($strand_id)=mysql_fetch_array($strands[$j][$a]))
                                                    {
                                                        $createstrand="insert into lesson_activity_strand (la_id,strand_id) values ($la_id,$strand_id)";
                                                        $createstrandresult=mysql_query($createstrand) or die("Error reported while executing the statement: $createstrand<br />MySQL reported: ".mysql_error());
                                                    }
                                                }
                                                if ($differentiations[$j][$a])
                                                {
                                                while ( list ($differentiation_id)=mysql_fetch_array($differentiations[$j][$a]))
                                                    {
                                                        $createdifferentiation="insert into lesson_activity_differentiation (la_id,diff_id) values ($la_id,$differentiation_id)";
                                                        $createdifferentiationresult=mysql_query($createdifferentiation) or die("Error reported while executing the statement: $createdifferentiation<br />MySQL reported: ".mysql_error());
                                                    }
                                                }
                                                if ($analysess[$j][$a])
                                                {
                                                $b=1;
                                                if (mysql_num_rows($analysess[$j][$a])>0)
                                                {
                                                    mysql_data_seek($analysess[$j][$a],0);
                                                    while ( list ($analyses_id)=mysql_fetch_array($analysess[$j][$a]))
                                                    {
                                                        $createanalyses="insert into lesson_activity_analyses (la_id,analyses_id) values ($la_id,$analyses_id)";
                                                        $createanalysesresult=mysql_query($createanalyses) or die("Error reported while executing the statement: $createanalyses<br />MySQL reported: ".mysql_error());
                                                        $la_an_id=mysql_insert_id();
                                                        if ($anal_points[$j][$a][$b])
                                                            {
                                                                while ( list ($anal_point_id)=mysql_fetch_array($anal_points[$j][$a][$b]))
                                                                    {
                                                                        $createanalpoint="insert into lesson_activity_analyses_point (la_an_id,point_id) values ($la_an_id,$anal_point_id)";
                                                                        $createanalpointresult=mysql_query($createanalpoint) or die("Error reported while executing the statement: $createanalpoint<br />MySQL reported: ".mysql_error());
                                                                    }
                                                             }
                                                        $b++;
                                                        }
                                                }
                                                }
                                                if ($progressions[$j][$a])
                                                {
                                                $p=1;
                                                if (mysql_num_rows($progressions[$j][$a])>0)
                                                {
                                                    mysql_data_seek($progressions[$j][$a],0);
                                                    while ( list ($la_pr_id,$progression_id)=mysql_fetch_array($progressions[$j][$a]))
                                                    {
                                                        $createprogression="insert into lesson_activity_progression (la_id,pr_id) values ($la_id,$progression_id)";
                                                        $createprogressionresult=mysql_query($createprogression) or die("Error reported while executing the statement: $createprogression<br />MySQL reported: ".mysql_error());
                                                        $la_pr_id=mysql_insert_id();
                                                        if ($prog_points[$j][$a][$p])
                                                        {
                                                                while(list($prog_point_id)=mysql_fetch_array($prog_points[$j][$a][$p]))
                                                                    {
                                                                        $createprogpoint="insert into lesson_activity_progression_point (la_pr_id,point_id) values ($la_pr_id,$prog_point_id)";
                                                                        $createprogpointresult=mysql_query($createprogpoint) or die("Error reported while executing the statement: $createprogpoint<br />MySQL reported: ".mysql_error());
                                                                    }
                                                        }
                                                     $p++;
                                                    }
                                                }
                                                }
                                        }
                                        $a++;
                                    }
                                }
                            }
                     }
    else {
        echo "no plans";
    }
}
function debug($obj)
{
    echo "<script>debug(".$obj.")</script>";
}
function CreateDefaultUnit2($topic_id,$topic,$level,$description,$num_lessons)
{
if ($level=='0.0') $level_string=' - foundation level - ';
else $level_string=' - level - '.$level;
$mysqli = new mysqli("localhost", "tp", "enquiry","tplan") ;
if (!$description) $description=$topic.$level_string." ".date("F j, Y, g:i a");
$teacher_id=$_SESSION['id'];
$success=$mysqli->query("call CreateDefaultUnit($teacher_id,$topic_id,'$topic',$level,'$description',$num_lessons,@success)") ;
if ($success) {
    $success_result=$mysqli->query('SELECT @success');
}
}
function redirect($url){
    $ie6 = "MSIE 6.0";
    $ie7 = "MSIE 7.0";
    $ie7 = "MSIE 8.0";
    $browser = $_SERVER['HTTP_USER_AGENT'];
    $browser = substr("$browser", 25, 8);
    if ((!headers_sent())||($browser!=$ie6)||($browser!=$ie7)||($browser!=$ie8)){    //If headers not sent yet... then do php redirect
        header('Location: '.$url);header("Connection:close"); exit;
    }else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}
