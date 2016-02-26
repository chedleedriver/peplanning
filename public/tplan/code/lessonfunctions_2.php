<?php
// functions file to store PHP basic functions
// version 1
// created on 10/9/11
//
if(preg_match( "/MSIE/", $_SERVER['HTTP_USER_AGENT'])){
session_cache_limiter('private');  
}  
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . '/../library/tplan_config.php');
include_once('config.php');

// Main decision area for what function to run
$_GET['GetThemes'] = (isset($_GET['GetThemes']) ? $_GET['GetThemes'] : 'default');
$_GET['GetSetLessons'] = (isset($_GET['GetSetLessons']) ? $_GET['GetSetLessons'] : 'default');
$_GET['GetObjectives'] = (isset($_GET['GetObjectives']) ? $_GET['GetObjectives'] : 'default');
$_GET['GetActivities'] = (isset($_GET['GetActivities']) ? $_GET['GetActivities'] : 'default');
$_GET['DrawPlanPage'] = (isset($_GET['DrawPlanPage']) ? $_GET['DrawPlanPage'] : 'default');
$_GET['DrawPlanPage2014'] = (isset($_GET['DrawPlanPage2014']) ? $_GET['DrawPlanPage2014'] : 'default');
$_GET['GetData'] = (isset($_GET['GetData']) ? $_GET['GetData'] : 'default');
$_GET['SaveUnitofWork'] = (isset($_GET['SaveUnitofWork']) ? $_GET['SaveUnitofWork'] : 'default');
$_GET['GetActivity'] = (isset($_GET['GetActivity']) ? $_GET['GetActivity'] : 'default');
$_GET['GetDifferentiation'] = (isset($_GET['GetDifferentiation']) ? $_GET['GetDifferentiation'] : 'default');
$_GET['GetProgression'] = (isset($_GET['GetProgression']) ? $_GET['GetProgression'] : 'default');
$_GET['GetAnalysis'] = (isset($_GET['GetAnalysis']) ? $_GET['GetAnalysis'] : 'default');
$_GET['GetProgressionPoints'] = (isset($_GET['GetProgressionPoints']) ? $_GET['GetProgressionPoints'] : 'default');
$_GET['PrintPlan'] = (isset($_GET['PrintPlan']) ? $_GET['PrintPlan'] : 'default');
$_GET['GetUnit'] = (isset($_GET['GetUnit']) ? $_GET['GetUnit'] : 'default');
$_GET['SetUpLessons'] = (isset($_GET['SetUpLessons']) ? $_GET['SetUpLessons'] : 'default');
$_GET['SaveLesson'] = (isset($_GET['SaveLesson']) ? $_GET['SaveLesson'] : 'default');
$_GET['DeleteLesson'] = (isset($_GET['DeleteLesson']) ? $_GET['DeleteLesson'] : 'default');
$_GET['DeleteUnit'] = (isset($_GET['DeleteUnit']) ? $_GET['DeleteUnit'] : 'default');
$_GET['GetHelp'] = (isset($_GET['GetHelp']) ? $_GET['GetHelp'] : 'default');
$_GET['lesson_id'] = (isset($_GET['lesson_id']) ? $_GET['lesson_id'] : 0);
if ($_GET['GetThemes']!='default') GetThemes($_GET['GetThemes'],$_GET['topic_id'],$_GET['level'],$_GET['description'],$_GET['num_lessons'],$_GET['plan_type']);
if ($_GET['GetSetLessons']!='default') GetSetLessons($_GET['GetSetLessons'],$_GET['topic_id'],$_GET['level'],$_GET['description'],$_GET['num_lessons'],$_GET['plan_type']);
if ($_GET['GetObjectives']!='default') GetObjectives($_GET['GetObjectives'],$_GET['lesson_num'],$_GET['topic_id'],$_GET['level'],$_GET['theme_id']);
if ($_GET['GetActivities']!='default') GetActivities($_GET['GetActivities'],$_GET['lesson_num'],$_GET['topic_id'],$_GET['level'],$_GET['theme_id'],$_GET['plan_type']);
if ($_GET['DrawPlanPage']!='default') DrawPlanPage($_GET['DrawPlanPage'],$_GET['theme_id'],$_GET['topic_id'],$_GET['level'],$_GET['uow_id'],$_GET['objectives'],$_GET['lesson_id'],$_GET['plan_type']);
if ($_GET['DrawPlanPage2014']!='default') DrawPlanPage2014($_GET['DrawPlanPage2014'],$_GET['theme_id'],$_GET['topic_id'],$_GET['level'],$_GET['uow_id'],$_GET['objectives'],$_GET['lesson_id'],$_GET['plan_type']);
if ($_GET['GetData']!='default') GetData($_GET['GetData'],$_GET['lesson_num'],$_GET['topic_id'],$_GET['data'],$_GET['plan_type']);
if ($_GET['SaveUnitofWork']!='default') SaveUnitofWork($_GET['topic_id'],$_GET['level_id'],$_GET['num_lessons'],$_GET['description']);
if ($_GET['GetActivity']!='default') GetActivity($_GET['GetActivity'],$_GET['lesson_num'],$_GET['content_id'],$_GET['strands'],$_GET['teaching_points'],$_GET['time'],$_GET['plan_type'],$_GET['topic_status'],$_GET['topic_id'],$_GET['theme_id'],$_GET['level']);
if ($_GET['GetDifferentiation']!='default') GetDifferentiation($_GET['GetDifferentiation'],$_GET['content_id'],$_GET['obj_num'],$_GET['differentiations']);
if ($_GET['GetProgression']!='default') GetProgression($_GET['GetProgression'],$_GET['content_id'],$_GET['obj_num'],$_GET['progressions'],$_GET['progression_points']);
if ($_GET['GetAnalysis']!='default') GetAnalysis($_GET['GetAnalysis'],$_GET['content_id'],$_GET['obj_num'],$_GET['topic_id'],$_GET['level'],$_GET['theme_id'],$_GET['analyses'],$_GET['analyses_points']);
if ($_GET['GetProgressionPoints']!='default') ShowProgressionPoints($_GET['progression_id']);
if ($_GET['PrintPlan']!='default') Print_a_Plan($_GET['PrintPlan'],$_GET['ajax']);
// Version 2
//if ($_GET['GetUnit']!='default') GetUnit($_GET['GetUnit']);
if ($_GET['GetUnit']!='default') GetUnit($_GET['GetUnit'],$_GET['user_id'],$_GET['user_level']);
if ($_GET['SetUpLessons']!='default') SetUpLessons($_GET['SetUpLessons'],$_GET['num_lessons'],$_GET['lesson_type'],$_GET['topic_id'],$_GET['level_id'],$_GET['original_type'],$_GET['lesson_num']);
if ($_GET['SaveLesson']!='default') SaveLesson($_GET['plan_type'],$_GET['uow_id'],$_GET['lesson_num'],$_GET['SaveLesson']);
if ($_GET['DeleteLesson']!='default') DeleteLesson($_GET['uow_id'],$_GET['lesson_num'],$_GET['DeleteLesson']);
if ($_GET['DeleteUnit']!='default') DeleteUnit($_GET['unit_id']);
if ($_GET['GetHelp']!='default') GetHelp($_GET['GetHelp']);
//functions start here
// get the data functions
function reload($destination) {
    $reload = 'Location: ' . $destination;
    header($reload);
}
function GetNumLessons($unit_id)
{
    include('mysqli_dbconnect.php');
	$sql="select num_lessons from unit_of_work where id=$unit_id";
    $result=mysqli_query($tp,$sql) or die("Error reported while excetung the statement; $sql<br />MySQL reportedL  ".mysqli_error());
    list($num_lessons)=  mysqli_fetch_array($result);
    return($num_lessons);
}
function GetThemes($lesson_num,$topic_id,$level_id,$description,$num_lessons,$plan_type)
{
    include('mysqli_dbconnect.php');
	$sql = "select theme.id as 'theme_id',theme.theme as 'theme_name', ".
           "theme.description as 'theme_description', topic_theme.level as 'level_id', " .
		   "topic_theme.importance as 'theme_importance', " .
		   "topic_theme.notes as 'theme_notes' ".
           "from topic_theme ".
           "left join theme on theme.id = topic_theme.theme_id ".
           "left join level on level.id = topic_theme.level " .
           "where topic_theme.topic_id=$topic_id and " .
           "topic_theme.level=$level_id ".
           "order by topic_theme.importance "; // also order by early->late

    $themes=mysqli_query($tp,$sql) or die("Error reported while excetung the statement; $sql<br />MySQL reportedL  ".mysqli_error());
	DrawThemes($themes,$lesson_num,$plan_type);
}
function GetObjectives($obj_num,$lesson_num,$topic_id,$level_id,$theme_id,$uow_id,$lesson_objectives)
{
	include('mysqli_dbconnect.php');
	switch ($level_id) {
		case "1.5":
		$levelspecifyingstring = "topic_objectives.level_id=\"1\" or topic_objectives.level_id=\"2\"";
		break;
		case "2.5":
		$levelspecifyingstring = "topic_objectives.level_id=\"2\" or topic_objectives.level_id=\"3\"";
		break;
		case "3.5":
		$levelspecifyingstring = "topic_objectives.level_id=\"3\" or topic_objectives.level_id=\"4\"";
		break;
		default:
	    $levelspecifyingstring = "topic_objectives.level_id=\"" . $level_id . "\"";
		break;
		}

    $sql = "select topic_objectives.objectives_id as 'objective_id', objectives.objective as 'objective_name', " .
           "topic_objectives.topic_id, topic.name as 'topic_name', " .
           "topic_objectives.strand_id, strand.strand as 'strand_name', strand.description as 'strand_description', " .
           "topic_objectives.level_id, level.description as 'level_name' " .
           "from topic_objectives " .
           "left join objectives on topic_objectives.objectives_id = objectives.id " .
           "left join level on topic_objectives.level_id = level.id " .
           "left join topic on topic_objectives.topic_id = topic.id " .
           "left join strand on topic_objectives.strand_id = strand.id " .
		   "left join theme_objective on theme_objective.objective_id = objectives.id ".  
           "where topic_objectives.topic_id=\"" . $topic_id . "\" " .
           " and ( $levelspecifyingstring ) " .
		   " and theme_objective.theme_id = ".$theme_id." ".
//           "order by topic_objectives.strand_id, level.id";
           "order by topic_objectives.strand_id";

    $objectives = mysqli_query($tp,$sql) or die("Error reported while excecuting the statement; $sql<br />MySQL reportedL  ".mysqli_error());
	DrawObjectives($obj_num,$lesson_num,$objectives,$uow_id,$lesson_objectives);
}
function GetObjectives2014($obj_num,$lesson_num,$topic_id,$level,$theme_id,$uow_id,$lesson_objectives)
{
	include('mysqli_dbconnect.php');
	$year = level_to_year($level);
	$sql = "select objectives.id as 'objective_id', ".
			"objectives.objective as 'objective_name', ".
			"strand.id as 'strand_id', ".
			"strand.strand as 'strand_name', ".
			"strand.description as 'strand_description' from objectives ".
			"left join objective_topic_theme on objectives.id=objective_topic_theme.objective_id ".
			"left join objective_strand on objectives.id=objective_strand.objective_id ".
			"left join strand on objective_strand.strand_id=strand.id ".
			"where objective_topic_theme.theme_id=".$theme_id." ".
			"and objective_topic_theme.topic_id=".$topic_id." ".
			"and objective_topic_theme.year=".$year." ".
			"order by strand.id";
			
	
	$objectives = mysqli_query($tp,$sql) or die("Error reported while excecuting the statement; $sql<br />MySQL reportedL  ".mysqli_error());
	DrawObjectives2014($obj_num,$lesson_num,$objectives,$uow_id,$lesson_objectives,$topic_id,$year,$theme_id);
}
function DrawObjectives2014($obj_num,$lesson_num,$objectives,$unit_id,$lesson_objectives,$topic_id,$year,$theme_id)
{
	include('mysqli_dbconnect.php');
	print	"<script type=\"text/javascript\">".
		 	" $(function() { $('#strandList_".$lesson_num."').accordion({".
			" autoHeight: false,".
			" collapsible: true,".
//			" fillSpace: true,".
//			" change: function(event, ui){alert($(ui.newContent).attr(\"id\") + \" was opened, \" + $(ui.oldContent).attr(\"id\") + \" was closed\");},".			
			" header: 'h6',".
                        " icons: { 'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s' },".
			" active: false".
			" });".
			" });".
			" </script>";
//	print "<div id=\"strandList_".$lesson_num."_".$obj_num."\" class=\"ui-widget ui-widget-content ui-corner-all leftobjcol\"><span class='ui-widget'></span>";*/
	print "<div id=\"objtabs_".$lesson_num."\" class='ui-widget ui-widget-content ui-corner-all'  style='height:400px;padding:30px'><div id=\"strandList_".$lesson_num."\">";
	if ($lesson_objectives) {
		$lesson_objectives_array=explode(",",$lesson_objectives);
				}
        $last_strand_id=0;
	while (list ($objective_id,$objective,$strand_id,$strand,$strand_description) = mysqli_fetch_array($objectives)) 
	{
			if ($strand_id!=$last_strand_id) 
			{
				if ($last_strand_id!=0) print "</ul>";
				print "<h6><a class='ui-widget' href=\"#\">".$strand_description." ".$strand."<div id=strandList_".$lesson_num."_".$strand_id." style='visibility:hidden;font-weight:bold'></div></a></h6><ul class='ui-widget'>";
				$last_strand_id=$strand_id;
				}	
//					print "<li  class='ui-widget' id=".$objective_id." onclick='changeObjTabAndMoveOn(this,\"objtabs_".$lesson_num."\",\"".$objective."\",\"objectiveid\",".$lesson_num.",".$obj_num.")'>".$objective."</li>";
			$obj_id=rand_str();
			if (($lesson_objectives_array) AND (in_array($objective_id,$lesson_objectives_array))) {
				print "<li><input id='".$obj_id."' name='".$obj_id."' type=\"checkbox\" class='ui-widget' value=".$objective_id." onclick=\"toggleUpdateField('objectiveid',".$lesson_num.",".$objective_id.",this.value,".$strand_id.",'".addslashes($objective)."')\" checked=true><label for='".$obj_id."'>   ".$objective."</label></li>";
				 
				}
			else {
				print "<li><input id='".$obj_id."' name='".$obj_id."' type=\"checkbox\" class='ui-widget' value=".$objective_id." onclick=\"toggleUpdateField('objectiveid',".$lesson_num.",".$objective_id.",this.value,".$strand_id.",'".addslashes($objective)."')\"><label for='".$obj_id."'>   ".$objective."</label></li>"; 
				}
	}
	print "</ul></div></div>";
}
function GetActivities($obj_num,$lesson_num,$topic_id,$level_id,$theme_id,$plan_type)
{
     	include('mysqli_dbconnect.php');
		switch ($level_id) {
		case "1.5":
		$levelspecifierstring = "content_level.level_id=\"1\" or content_level.level_id=\"2\"";
		break;
		case "2.5":
		$levelspecifierstring = "content_level.level_id=\"2\" or content_level.level_id=\"3\"";
		break;
		case "3.5":
		$levelspecifierstring = "content_level.level_id=\"3\" or content_level.level_id=\"4\"";
		break;
		default:
	    $levelspecifierstring = "content_level.level_id = $level_id ";
		break;
		}


     $limitbylessonpartstring;
     if ($lesson_part_id == 0 || $lesson_part_id == "0") {
         $limitbylessonpartstring = ""; // i.e. no limiting
     } else {
         $limitbylessonpartstring = "AND content_lesson_part.lesson_part_id=$lesson_part_id";
     }

     $sql="select content.content_id, name as 'content_name', " .
     "content.description as 'content_description', content.time as 'content_time', " .
     "  content_level.level_id as 'level_id', level.description as 'level_name',  " .
    " lesson_part.id as 'lesson_part_id', lesson_part.order, lesson_part.description as 'lesson_part_name' " .
     "from content ".
    "left join (content_topic, content_theme, content_level, content_lesson_part, level, lesson_part) " .
    " on (content.content_id = content_topic.content_id " .
    " AND content.content_id = content_theme.content_id " .
    " AND content.content_id = content_level.content_id " .
    " AND content.content_id = content_lesson_part.content_id) " .
    " WHERE content_topic.topic_id = $topic_id " .
    " AND content_level.level_id = level.id " .
    " AND  lesson_part.id = content_lesson_part.lesson_part_id " .
    " AND content_theme.theme_id = $theme_id " .
	" AND lesson_part.description NOT IN ('Discussion','EI Discussion','KUFH Discussion','Core Task','Analysis') ".
    " AND content_level.level_id= $level_id " .
    " $limitbylessonpartstring   " .
    " ORDER BY lesson_part.order";

    $activities[$lesson_num]=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
	DrawActivities($obj_num,$lesson_num,$activities[$lesson_num],$plan_type);
}
function GetData($what_data,$lesson_num,$topic_id,$data,$plan_type)
{
	switch ($what_data) {
		case 'ict':
			GetIct($lesson_num,$topic_id,$data,$plan_type);
			break;
		case 'citizenship':
			GetCitizenship($lesson_num,$topic_id,$data,$plan_type);
			break;
		case 'risk_assessment':
			GetRisk_Assessment($lesson_num,$topic_id,$data,$plan_type);
			break;
		case 'numeracy':
			GetNumeracy($lesson_num,$topic_id,$data,$plan_type);
			break;
		case 'keywords':
			GetKeywords($lesson_num,$topic_id,$data,$plan_type);
			break;
		}
}
function GetActivity($obj_num,$lesson_num,$content_id,$strands,$teaching_points,$set_time,$plan_type,$topic_status,$topic_id,$theme_id,$level_id)
{
	include('mysqli_dbconnect.php');
	$act_num = rand();
	$sql="select name,description,time from content where content_id=$content_id";
	$content[$act_num]=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
	list($content_name,$content_description,$time) = mysqli_fetch_array($content[$act_num]);
	if ($set_time!=0) $time=$set_time;
	  if (checkBase64Encoded($content_description)) 
	  { 
	  	$description=unserialize(base64_decode($content_description));
	  }
	  else 
	  {
	  	$description=unserialize($content_description);
	  }
	for ($i=0 ; $i <= count($description) ; $i++)
	{
		if ($description[$i]!="") {
                        if (substr($description[$i],0,1)=="^") $description[$i]="&nbsp; &nbsp;".substr($description[$i],1);
			if ($i==0) $description_out=stripslashes($description[$i]);
			else $description_out=$description_out."<br><br>".stripslashes($description[$i]);
			}
		}
	$description_out=utf2ascii($description_out);
	$check_differentiation=mysqli_num_rows(mysqli_query($tp,"select * from content_differentiation where content_id=$content_id"));
	$check_progression=mysqli_num_rows(mysqli_query($tp,"select * from content_progression where content_id=$content_id"));
        switch ($level_id) {
		case "1.5":
		$levelspecifierstring = "content_level.level_id=\"1\" or content_level.level_id=\"2\"";
		break;
		case "2.5":
		$levelspecifierstring = "content_level.level_id=\"2\" or content_level.level_id=\"3\"";
		break;
		case "3.5":
		$levelspecifierstring = "content_level.level_id=\"3\" or content_level.level_id=\"4\"";
		break;
		default:
	    $levelspecifierstring = "content_level.level_id = $level_id ";
		break;
		}
        $analysis_sql="select content.content_id from content ".
                    "left join (content_topic, content_theme, content_level, content_lesson_part, level, lesson_part) " .
                    " on (content.content_id = content_topic.content_id " .
                    " AND content.content_id = content_theme.content_id " .
                    " AND content.content_id = content_level.content_id " .
                    " AND content.content_id = content_lesson_part.content_id) " .
                    " WHERE content_topic.topic_id = $topic_id " .
                    " AND content_level.level_id = level.id " .
                    " AND  lesson_part.id = content_lesson_part.lesson_part_id " .
                    " AND content_theme.theme_id = $theme_id " .
                    " AND lesson_part.description IN ('Analysis') ".
                    " AND ( $levelspecifierstring ) ";
	$check_analysis=mysqli_num_rows(mysqli_query($tp,$analysis_sql));
	$equipment_query="select equipment.description from equipment left join content_equipment on content_equipment.equipment_id = equipment.id where content_equipment.content_id=$content_id";
	$equipment[$act_num]=mysqli_query($tp,$equipment_query) or die("Error reported while executing the statement: $equipment_query<br />MySQL reported: ".mysqli_error());
	if ($equipment[$act_num]) 
	{
		$e=0;
		while (list($equipment_description)=mysqli_fetch_array($equipment[$act_num]))
		{ 	if ($e==0) $equipment_string=$equipment_description;
			else $equipment_string=$equipment_string.", ".$equipment_description;
			$e++;
		}
	}
	$sql="select point.id,point from point left join content_point on content_point.point_id=point.id where content_point.content_id=$content_id order by point_num";
	$point[$act_num]=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
	if ($point[$act_num])
		{
			$what='teaching_point';
			$point_list="<ul class='ui-widget'>";
			$arr_index=$obj_num-1;
			$i=1;
			$data_array=explode(',',$teaching_points);
			while (list($what_id,$what_name) = mysqli_fetch_array($point[$act_num]))
			{ 
				$cb_id=rand_str();
				$what_name=utf2ascii($what_name);
				if (!$what_name) {$what_name=$what_id;}
					if (in_array($what_id,$data_array)) {
                                            if($topic_status=="R"&&$_SESSION['userlevel']!=9){
						$point_list=$point_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" value=".$what_id." checked=true disabled><label for='".$cb_id."'>   ".$what_name."</label></li>";
                                            }
                                            else{
                                                $point_list=$point_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" value=".$what_id."  onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$content_id.",this)\" class='ui-widget' checked=true><label for='".$cb_id."'>   ".$what_name."</label></li>";
                                                }
                                        }
                                        else {
                                            if($topic_status=="R"&&$_SESSION['userlevel']!=9){
                                                $point_list=$point_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" value=".$what_id." disabled><label for='".$cb_id."'>   ".$what_name."</label></li>";
                                            }
                                            else{
                                                $point_list=$point_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" value=".$what_id."  onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$content_id.",this)\" class='ui-widget'><label for='".$cb_id."'>   ".$what_name."</label></li>"; 
                                            }
                                        }
			$i++;
 			} 
		$point_list=$point_list."</ul>";
		}
	$sql="select strand.id,strand,description from strand left join content_strand on content_strand.strand_id=strand.id where content_strand.content_id=$content_id";
	$strand[$act_num]=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
	if ($strand[$act_num])
		{
			$what='strand';
			$strand_list="<ul class='ui-widget'>";
			$arr_index=$obj_num-1;
			$i=1;
			$data_array=explode(',',$strands);
			while (list($what_id,$what_name,$description) = mysqli_fetch_array($strand[$act_num]))
			{
				$cb_id=rand_str();
				if (!$what_name) {$what_name=$what_id;}
					if (in_array($what_id,$data_array)) {
                                            if($topic_status=="R"&&$_SESSION['userlevel']!=9){
						$strand_list=$strand_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" value=".$what_id." checked=true disabled><label for='".$cb_id."'>   ".$what_name." (".$description.")</label></li>";
                                                }
                                                else{
                                                    $strand_list=$strand_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" value=".$what_id."  onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$content_id.",this)\" class='ui-widget' checked=true><label for='".$cb_id."'>   ".$what_name." (".$description.")</label></li>"; 
                                                }
                                            }
                                        else{
                                            if($topic_status=="R"&&$_SESSION['userlevel']!=9){
                                                $strand_list=$strand_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" value=".$what_id." disabled><label for='".$cb_id."'>   ".$what_name." (".$description.")</label></li>";
                                            }
                                            else{
                                                $strand_list=$strand_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" value=".$what_id."  onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$content_id.",this)\" class='ui-widget'><label for='".$cb_id."'>   ".$what_name." (".$description.")</label></li>"; 
                                            }
                                       }
			$i++;
 			} 
		$strand_list=$strand_list."</ul>";
		}
		//$image_file=FILE_ROOT.DIAGRAM_PATH.$content_id.".gif";
		$image_file=APPLICATION_BASE."/public/tplan/diagrams/".$content_id.".gif";
		if (!file_exists($image_file)) $image_file="/tplan/diagrams/no-image.png";
		else $image_file="/tplan/diagrams/".$content_id.".gif";
	echo "<table id='table_".$content_id."_".$lesson_num."_".$obj_num."' width=100% border='0' cellpadding='2' cellspacing='2' class='ui-widget ui-widget-content ui-corner-all'>".
		" <tr>". 
		" <td width=33% valign='top' class=\"ui-widget ui-widget-content ui-corner-all\" rowspan=3><span class='ui-widget'>".stripslashes($content_name)."<span>".
		" <p>".$description_out."</p></td>".
		" <td width=33% valign='top' class='ui-widget ui-widget-content ui-corner-all'><span class='ui-widget'>Select Teaching Point</span>".$point_list."</td>".
		" <td width=33% valign='top' align='center' class='ui-widget ui-widget-content ui-corner-all'><span class='ui-widget'>Diagram</span><br><img src='".$image_file."' border=none width='300' height='200'></tr>".
		" <tr><td width=33% class='ui-widget ui-widget-content ui-corner-all'><span class='ui-widget'>Select Strand</span>".$strand_list."</td>".
		" <td width=33% valign='top' rowspan=2 class='ui-widget ui-widget-content ui-corner-all'><span class='ui-widget'>Equipment</span>".
		" <p>".$equipment_string."</p></td></tr>".
		" <tr><td width=33% valign='top' class='ui-widget ui-widget-content ui-corner-all'><span class='ui-widget'>Enter Time:  </span><input  class='ui-widget input' type='text' id='time[".$lesson_num."][".$content_id."]' name='time[".$lesson_num."][".$content_id."]' size='10' value='".$time."' onchange=\"doUpdateActivity('timeout',".$lesson_num.",".$content_id.",this.value)\"/><br><span style='font-size:smaller'>(For guidance only please change to suit your lesson timings)</span></td></tr>".
		" <tr>";
	if ($check_differentiation!=0) {
	echo " <td align=center width=33%><input alt=\"Differentiation\" class=\"btn btn-m\" type=\"submit\" value=\"Differentiation\" onclick='showDifferentiationDialog(".$lesson_num.",".$content_id.",".$obj_num.")' /></td>";
		}
	else {
	echo " <td align=center width=33%><input alt=\"Differentiation\" class=\"btn-g\" type=\"submit\" value=\"Differentiation\"  /></td>";}
	if ($check_progression!=0) {
	echo " <td align=center width=33%><input alt=\"Progression\" class=\"btn btn-m\" type=\"submit\" value=\"Progression\" onclick='showProgressionDialog(".$lesson_num.",".$content_id.",".$obj_num.")' /></td>";}
	else {
	echo " <td align=center width=33%><input alt=\"Progression\" class=\"btn-g\" type=\"submit\" value=\"Progression\"  /></td>";}
        if($check_analysis!=0) {
	echo " <td align=center width=33%><input alt=\"Analysis\" class=\"btn btn-m\" type=\"submit\" value=\"Analysis\" onclick='showAnalysisDialog(".$lesson_num.",".$content_id.",".$obj_num.")' /></td></td>";}
        else {
        echo " <td align=center width=33%><input alt=\"Analysis\" class=\"btn-g\" type=\"submit\" value=\"Analysis\"  /></td>";}
	echo " </tr>".
		" </table><div class=\"help\" onclick='javascript:showHelpDialog(\"activities-".$plan_type."\")'>help</div></a>";
}
function GetSetLessons($lesson_num,$topic_id,$level_id,$description,$num_lessons,$plan_type)
{
	include('mysqli_dbconnect.php');
	$topic=mysqli_query($tp,"select name from topic where id=$topic_id");
        list($topic_name)=mysqli_fetch_array($topic);
        $teacher_name=$topic_name."level".$level_id;
	$lessons=mysqli_query($tp,"select lesson.id,theme.id,theme.theme,topic_theme.notes".
        " from lesson".
        " left join theme on theme.id=lesson.theme_id".
        " left join topic_theme on topic_theme.theme_id=lesson.theme_id".
        " left join unit_of_work on lesson.uow_id=unit_of_work.id".
        " where unit_of_work.teacher_id in (select users.id from users where username='$teacher_name')".
        " and topic_theme.level=$level_id".
        " and topic_theme.topic_id=$topic_id".
        " order by topic_theme.importance ");
	DrawSetLessons($lessons,$lesson_num,$plan_type);
}
function GetUnit($unit_id,$user_id,$userlevel)
{
		include('mysqli_dbconnect.php');
		//$username=$_SESSION['username'];
                //$get_user_id=mysqli_query($tp,"select id,userlevel from users where username='$username'");
                //list($user_id,$userlevel)=mysqli_fetch_array($get_user_id);
                if ($userlevel==9){
                    $got_unit=mysqli_query($tp,"select topic_id,level_id,num_lessons,topic.name,topic.status,set_plan_id from unit_of_work left join topic on topic.id=unit_of_work.topic_id where unit_of_work.id=$unit_id");
                }
                else {
                    $got_unit=mysqli_query($tp,"select topic_id,level_id,num_lessons,topic.name,topic.status,set_plan_id from unit_of_work left join topic on topic.id=unit_of_work.topic_id where unit_of_work.id=$unit_id and (unit_of_work.teacher_id=$user_id or public='y')");
                }
                if ($got_unit)
                {
                    if (mysqli_num_rows($got_unit)!=0)
                    {
                        list($topic_id,$level_id,$num_lessons,$topic,$topic_status,$set_unit_id)=mysqli_fetch_array($got_unit);
                        echo ($topic_id."^".$level_id."^".$num_lessons."^".$topic."^".$topic_status."^".$set_unit_id."^".$userlevel);
                    }
                    else
                    {
                    echo 'no';
                    }
                }
}
function GetLessons($unit_id)
{
	include('mysqli_dbconnect.php');
	$getplans="select * from plan where uow_id = $unit_id";
	$gotplans=mysqli_query($tp,$getplans) or die("Error reported while executing the statement: $getplanid<br />MySQL reported: ".mysqli_error());
	for ($p = 1 ; $p < count(mysqli_fetch_array($gotplans)) ; $p++)
	{
		list ($id, $uow_id, $theme_id, $description, $objectives, $content, $lesson_parts, $content_point, $differentiation, $progression, $content_strand, $content_images, $content_time, $content_equipment, $keywords, $ICT, $numeracy, $sen, $citizenship, $risk_assessment,$ta)=mysqli_fetch_array($gotplans); 
		
		if ($objectives) {
			for ($o = 1 ; $o < count($objectives) ; $o++)
				{ print "<script type=\"text/javascript\">".
						" alert(".$objectives[$o].");".
						" var objInput=document.createElement('input');".
						"	  objInput.id='objective_".$o."[".$p."]';".
						"     objInput.value=".$objectives[$o].";".
						" document.getElementById('storeRoom['".$p."']).appendChild(objInput);".
						" </script>"; }
			}
	}
}
function GetIct($lesson_num,$topic_id,$icts,$plan_type)
{
	include('mysqli_dbconnect.php');
	$sql="select id,description from ICT  left join topic_ICT on ICT.id=ICT_id where topic_id=$topic_id order by description";
	$ict=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
	CreateList('ict',$ict,$lesson_num,$topic_id,$icts,"Select any ICT opportunities you can incorporate into your lesson",$plan_type);
}
function GetCitizenship($lesson_num,$topic_id,$citizenships,$plan_type)
{
	include('mysqli_dbconnect.php');
	$sql="select id,description from citizenship left join topic_citizenship on citizenship.id=citizenship_id where topic_id=$topic_id order by description";
	$citizenship=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
	CreateList('citizenship',$citizenship,$lesson_num,$topic_id,$citizenships,"Select appropriate citizenship links for your lesson",$plan_type);
}
function GetNumeracy($lesson_num,$topic_id,$numeracys,$plan_type)
{
	include('mysqli_dbconnect.php');
	$sql="select id,description from numeracy left join topic_numeracy on numeracy.id=numeracy_id where topic_id=$topic_id order by description";
	$numeracy=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
	CreateList('numeracy',$numeracy,$lesson_num,$topic_id,$numeracys,"Select appropriate numeracy links for your lesson",$plan_type);
}
function GetRisk_Assessment($lesson_num,$topic_id,$risk_assessments,$plan_type)
{
	include('mysqli_dbconnect.php');
	$sql="select id,description from risk_assessment left join topic_risk_assessment on risk_assessment.id=risk_assessment_id where topic_id=$topic_id order by description";
	$risk_assessment=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
	CreateList('risk_assessment',$risk_assessment,$lesson_num,$topic_id,$risk_assessments,"Select the appropriate safety checks to be carried out prior to your lesson",$plan_type);
}
function GetKeywords($lesson_num,$topic_id,$keywordss,$plan_type)
{
	include('mysqli_dbconnect.php');
	$sql="select keywords.id,keyword from keywords left join topic_keywords on keywords.id = topic_keywords.keywords_id where topic_keywords.topic_id=$topic_id order by keyword";
	$keywords=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
	CreateList('keywords',$keywords,$lesson_num,$topic_id,$keywordss,"Select appropriate keywords for your lesson",$plan_type);
}
function GetDifferentiation($lesson_num,$content_id,$obj_num,$differentiations)
{
	include('mysqli_dbconnect.php');
	$sql="select differentiation.id,differentiation,difficulty from differentiation left join content_differentiation on content_differentiation.differentiation_id = differentiation.id where content_differentiation.content_id = $content_id order by difficulty";
	$differentiation=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
	if ($differentiation)
		{
		echo "<table width=100% cellpadding=2 cellspacing=2><tr><td width=50%>"; 
			$what='differentiation';
			$differentiation_list="<ul class='ui-widget'>";
			$arr_index=$obj_num-1;
//			$lesson_differentiations=explode(';',$differentiations);
//			if (!$lesson_strands) { $lesson_strands='0,0';}
			$i=1;
			$data_array=explode(',',$differentiations);
			while (list($what_id,$what_name,$how_hard) = mysqli_fetch_array($differentiation))
			{
				if (($how_hard=="E") OR ($how_hard=="e")) $how_hard_title="Make it Easier"; else $how_hard_title="Make it Harder";
				if (!$last_how_hard) $differentiation_list=$differentiation_list."<h3><a class='ui-widget' href=\"#\">".$how_hard_title."</a></h3>";
				if (($last_how_hard) && ($how_hard!=$last_how_hard))  $differentiation_list=$differentiation_list."</ul></td><td width=50%><h3><a class='ui-widget' href=\"#\">".$how_hard_title."</a></h3><ul class='ui-widget'>";
				$cb_id=rand_str();
				if (!$what_name) {$what_name=$what_id;}
					if (in_array($what_id,$data_array)) {
						$differentiation_list=$differentiation_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" class='ui-widget' value=".$what_id." onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$content_id.",this);this.style.display=this.checked?'true':'false'\" checked=true><label for='".$cb_id."'>   ".$what_name."</label></li>"; }
				else {
						$differentiation_list=$differentiation_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" class='ui-widget' value=".$what_id." onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$content_id.",this);this.style.display=this.checked?'true':'false'\" ><label for='".$cb_id."'>   ".$what_name."</label></li>"; }
			$i++; $last_how_hard=$how_hard;
 			} 
		$differentiation_list=$differentiation_list."</ul></td></tr></table>";
		}
	print $differentiation_list;
}
function GetProgression($lesson_num,$content_id,$obj_num,$progressions,$progression_points)
{
	include('mysqli_dbconnect.php');
	$sql="select progression.id,progression from progression left join content_progression on content_progression.progression_id = progression.id where content_progression.content_id = $content_id";
	$progression=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
	if ($progression)
		{
//		echo " <div class='colmask doublepage'>". 
//			 " <div class='colleft'>". 
//			 " <div class='col1'>"; 
		echo " <table width=100% cellpadding=2 cellspacing=2><tr><td width=50% valign='top'>";
			$what='progression';
			$progression_list="<ul class='ui-widget'>";
			$arr_index=$obj_num-1;
			$progress_index=0;
			$data_array=explode(',',$progressions);
			if (($progression_points) AND ($progression_points!='undefined'))
				{
					$progression_data_arrays=explode(';',$progression_points);
					for ($p=0;$p<count($progression_data_arrays);$p++)
						{
							$point_data_array=explode(',',$progression_data_arrays[$p]);
							for ($a=1;$a<count($point_data_array);$a++)
								{
									$point_check_array[$point_data_array[0]][$a]=$point_data_array[$a];
								}
							}
						}
			while (list($what_id,$what_name) = mysqli_fetch_array($progression))
			{
//				$description=unserialize($what_name);
	  			if (checkBase64Encoded($what_name)) 
	  			{ 
	  				$description=unserialize(base64_decode($what_name));
	  			}
	  			else 
	  			{
	  				$description=unserialize($what_name);
	  			}
                                $desc_out='';
				$description_out = implode('<br>',$description);
                                //foreach($description as $desc_line){
                                //    if ($desc_line) $desc_out=$desc_out."<br>".$desc_line;
                                //}
				$description_out=utf2ascii($description_out);
				$cb_id=rand_str();
				if (!$what_name) {$what_name=$what_id;}
					
					if (in_array($what_id,$data_array)) {
						$progression_list=$progression_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" class='ui-widget' value=".$what_id." onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$content_id.",this);\"  checked=true><label for='".$cb_id."' onmouseover=\"showProgressPoints(".$what_id.",".$lesson_num.",".$content_id.",'".$cb_id."')\">   ".stripslashes($description_out)."</label></li>"; }
				else {
						$progression_list=$progression_list."<li><input id='".$cb_id."'' name='".$cb_id."' type=\"checkbox\" class='ui-widget' value=".$what_id." onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$content_id.",this);\" ><label for='".$cb_id."' onmouseover=\"showProgressPoints(".$what_id.",".$lesson_num.",".$content_id.",'".$cb_id."')\">   ".stripslashes($description_out)."</label></li>"; }
						$points=mysqli_query($tp,"select id,point from point left join  progression_point on point.id = progression_point.point_id  where progression_point.progression_id = $what_id order by point.id desc") or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
						$point_list[$progress_index]="<h3><a class='ui-widget' href=\"#\">Teaching Points</a></h3><br><ul class='ui-widget' >";
						while (list ($point_id,$point)=mysqli_fetch_array($points))
						{
							$cb_id=rand_str();
							if (($progression_points) AND ($progression_points!='undefined'))
							{
								if (is_array($point_check_array[$what_id]))
									{
										if (in_array($point_id,$point_check_array[$what_id]))
										{
											$point_list[$progress_index]=$point_list[$progress_index]."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" class='ui-widget' value=".$point_id." onclick=\"toggleUpdateField4Dim('progression_points',".$lesson_num.",".$content_id.",this,".$what_id.");\" checked /><label for='".$cb_id."'>   ".$point."</label></li>";
										}
										else 
										{
											$point_list[$progress_index]=$point_list[$progress_index]."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" class='ui-widget' value=".$point_id." onclick=\"toggleUpdateField4Dim('progression_points',".$lesson_num.",".$content_id.",this,".$what_id.");\" /><label for='".$cb_id."'>   ".$point."</label></li>";
										}
									}
								else 
									{
										$point_list[$progress_index]=$point_list[$progress_index]."<li><input id='".$cb_id."' name='".$cb_id."'' type=\"checkbox\" class='ui-widget' value=".$point_id." onclick=\"toggleUpdateField4Dim('progression_points',".$lesson_num.",".$content_id.",this,".$what_id.");\"  /><label for='".$cb_id."'>   ".$point."</label></li>";
									} 										

								}
							else 
								{
								$point_list[$progress_index]=$point_list[$progress_index]."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" class='ui-widget' value=".$point_id." onclick=\"toggleUpdateField4Dim('progression_points',".$lesson_num.",".$content_id.",this,".$what_id.")\" /><label for='".$cb_id."'>   ".$point."</label></li>";
								} 										
						}
					$point_list[$progress_index]=$point_list[$progress_index]."</ul>";
					$progress_ids[$progress_index]=$what_id;
					$progress_index++;			
 			} 
	   $progression_list=$progression_list."</ul></td><td width=50% valign='top' id='progress_point'>";
	   for ($j = 0 ; $j < count($progress_ids) ; $j++) {
	   $point_div="<div class='prog_points' id=\"".$progress_ids[$j]."_".$content_id."[".$lesson_num."]\" style=\"
		visibility:hidden; 
		position:absolute; 
\">".$point_list[$j]."</div>";
		$progression_list=$progression_list.$point_div;
		}
		
		$progression_list=$progression_list."</td></tr></table>";
		}
	print $progression_list;
}
function GetAnalysis($lesson_num,$activity_id,$obj_num,$topic_id,$level_id,$theme_id,$analyses,$analyses_points)
{
     	include('mysqli_dbconnect.php');
		switch ($level_id) {
		case "1.5":
		$levelspecifierstring = "content_level.level_id=\"1\" or content_level.level_id=\"2\"";
		break;
		case "2.5":
		$levelspecifierstring = "content_level.level_id=\"2\" or content_level.level_id=\"3\"";
		break;
		case "3.5":
		$levelspecifierstring = "content_level.level_id=\"3\" or content_level.level_id=\"4\"";
		break;
		default:
	    $levelspecifierstring = "content_level.level_id = $level_id ";
		break;
		}
     $sql="select content.content_id, name as 'content_name', " .
     "content.description as 'content_description', content.time as 'content_time', " .
     "  content_level.level_id as 'level_id', level.description as 'level_name',  " .
    " lesson_part.id as 'lesson_part_id', lesson_part.description as 'lesson_part_name' " .
     "from content ".
    "left join (content_topic, content_theme, content_level, content_lesson_part, level, lesson_part) " .
    " on (content.content_id = content_topic.content_id " .
    " AND content.content_id = content_theme.content_id " .
    " AND content.content_id = content_level.content_id " .
    " AND content.content_id = content_lesson_part.content_id) " .
    " WHERE content_topic.topic_id = $topic_id " .
    " AND content_level.level_id = level.id " .
    " AND  lesson_part.id = content_lesson_part.lesson_part_id " .
    " AND content_theme.theme_id = $theme_id " .
	" AND lesson_part.description IN ('Analysis') ".
    " AND ( $levelspecifierstring ) " .
    " ORDER BY content_lesson_part.lesson_part_id";

    $activities=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
		if ($activities)
		{
//	print	"<script type=\"text/javascript\">".
//		 	" $(function() { $('#lessonPartList_".$lesson_num."_".$obj_num."').accordion({".
//			" autoHeight: false,".
//			" collapsible: true,".
//			" header: 'h6',".
//			" active: false".
//			" });".
/**			" });</script>"; **/
//		echo " <div id=\"lessonPartList_".$lesson_num."_".$obj_num."\" class=\"leftactcol\">"; 
//	$heading_list="<div class='colmask doublepage'><div class='ui-widget ui-widget-content colleft'>";
	$heading_list="<table width=100% cellpadding=4 cellspacing=4><tr>";
			$what='analyses';
			$activities_list="<ul class='ui-widget'>";
			$arr_index=$obj_num-1;
			if (($analyses_points) AND ($analyses_points!='undefined'))
				{
					$analyses_data_arrays=explode(';',$analyses_points);
					for ($p=0;$p<count($analyses_data_arrays);$p++)
						{
							$point_data_array=explode(',',$analyses_data_arrays[$p]);
							for ($a=1;$a<count($point_data_array);$a++)
								{
									$point_check_array[$point_data_array[0]][$a]=$point_data_array[$a];
								}
							}
						}
			$i=1;
			$content_index=0;
			$data_array=explode(',',$analyses);
			while (list($content_id,$content_name,$content_description,$content_time,$level_id,$level_name,$lesson_part_id,$lesson_part_name) = mysqli_fetch_array($activities))
			{
			$content_name=no_magic_quotes($content_name);
                        $none_for_this_id='';
			$cb_id=rand_str();
			if ($lesson_part_id!=$last_lesson_part_id) {
				if ($last_lesson_part_id) print "</ul>"; 
				$activities_list=$activities_list."<h3><a class='ui-widget' href=\"#\">".$lesson_part_name."</a></h3><ul class='ui-widget'>"; 
				$last_lesson_part_id=$lesson_part_id;}
				if (in_array($content_id,$data_array)) {
// with points					$activities_list=$activities_list."<li><input id='cb_content".$content_id."' name='cb_content".$content_id."' type=\"checkbox\" class='ui-widget' value=".$content_id." onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$obj_num.",this);this.style.display=this.checked?'true':'false'\" checked=true><label for='cb_content".$content_id."' onmouseover=\"showAnalysisPoints(".$content_id.",".$lesson_num.",".$obj_num."); displayAnalysisActivityDescription(".$content_id.",".$lesson_num.",".$obj_num.")\" >   ".$content_name."</label></li>"; }
					$activities_list=$activities_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" class='ui-widget' value=".$content_id." onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$activity_id.",this);this.style.display=this.checked?'true':'false'\" checked=true><label for='".$cb_id."' onmouseover=\"displayAnalysisActivityDescription(".$content_id.",".$lesson_num.",".$obj_num.")\" >   ".$content_name."</label></li>"; }
				else {
// with points					$activities_list=$activities_list."<li><input id='cb_content".$content_id."' name='cb_content".$content_id."' type=\"checkbox\" class='ui-widget' value=".$content_id." onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$obj_num.",this);this.style.display=this.checked?'true':'false'\" ><label for='cb_content".$content_id."' onmouseover=\"showAnalysisPoints(".$content_id.",".$lesson_num.",".$obj_num."); displayAnalysisActivityDescription(".$content_id.",".$lesson_num.",".$obj_num.")\" >   ".$content_name."</label></li>"; }
					$activities_list=$activities_list."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" class='ui-widget' value=".$content_id." onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$activity_id.",this);this.style.display=this.checked?'true':'false'\" ><label for='".$cb_id."' onmouseover=\"displayAnalysisActivityDescription(".$content_id.",".$lesson_num.",".$obj_num.")\" >   ".$content_name."</label></li>"; }
					$points=mysqli_query($tp,"select id,point from point left join  content_point on point.id = content_point.point_id  where content_point.content_id = $content_id") or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
						$point_list[$content_index]="<h3><a class='ui-widget' href=\"#\">Teaching Points</a></h3><br><ul class='ui-widget'>";
						while (list ($point_id,$point)=mysqli_fetch_array($points))
						{
							$point=str_replace("^","-",$point);
                                                        $cb_id=rand_str();
							if (($analyses_points) AND ($analyses_points!='undefined'))
							{
								if (is_array($point_check_array[$content_id]))
									{
										if (in_array($point_id,$point_check_array[$content_id]))
												{
												$point_list[$content_index]=$point_list[$content_index]."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" class='ui-widget' value=".$point_id." onclick=\"toggleUpdateField4Dim('analyses_points',".$lesson_num.",".$activity_id.",this,".$content_id.");this.style.display=this.checked?'true':'false'\" checked=true><label for='".$cb_id."'>   ".$point."</label></li>";
												}
												else
												{
												$point_list[$content_index]=$point_list[$content_index]."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" class='ui-widget' value=".$point_id." onclick=\"toggleUpdateField4Dim('analyses_points',".$lesson_num.",".$activity_id.",this,".$content_id.");this.style.display=this.checked?'true':'false'\"><label for='".$cb_id."'>   ".$point."</label></li>";
												}
									}
								else
									{
										$point_list[$content_index]=$point_list[$content_index]."<li><input id='".$cb_id."' name='".$cb_id."'' type=\"checkbox\" class='ui-widget' value=".$point_id." onclick=\"toggleUpdateField4Dim('analyses_points',".$lesson_num.",".$activity_id.",this,".$content_id.");this.style.display=this.checked?'true':'false'\"><label for='".$cb_id."'>   ".$point."</label></li>";
									}
							}
							else
							{
								$point_list[$content_index]=$point_list[$content_index]."<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" class='ui-widget' value=".$point_id." onclick=\"toggleUpdateField4Dim('analyses_points',".$lesson_num.",".$activity_id.",this,".$content_id.");this.style.display=this.checked?'true':'false'\" ><label for='".$cb_id."'>   ".$point."</label></li>";
							}
						}
					$point_list[$content_index]=$point_list[$content_index]."</ul>";
					$content_ids[$content_index]=$content_id;
					$content_names[$content_index]=$content_name;
					$content_descriptions[$content_index]=$content_description;
					$content_index++;
 			} 
		$description_list="</ul></div>";
//	print "<div id=\"detailcol[".$lesson_num."]\" class=\"rightactcol\">";
		for ($j = 0 ; $j < count($content_ids) ; $j++) {
//		$content_description_arr=unserialize($content_descriptions[$j]);
	  	if (checkBase64Encoded($content_descriptions[$j])) 
	  	{ 
	  	$content_description_arr=unserialize(base64_decode($content_descriptions[$j]));
	  	}
	 	 else 
	  	{
	  	$content_description_arr=unserialize($content_descriptions[$j]);
	  	}
		$content_description_display="<h3><a class='ui-widget' href=\"#\">".$content_names[$j]."</a></h3><p class='ui-widget'>";
		for ($i = 0 ; $i < count($content_description_arr) ; $i++) {
				if ($content_description_arr[$i]) $content_description_display=$content_description_display."<br>".str_replace("^","-",$content_description_arr[$i]);
			}
		$description_list=$description_list."<div id=\"".$content_ids[$j]."_".$obj_num."[".$lesson_num."]\" style=\" 
		visibility:hidden; 
		z-index:100; 
		position:absolute;
		width:48%; 
\">".$content_description_display."</p></div>";
		}
		for ($j = 0 ; $j < count($content_ids) ; $j++) {
	   	$point_div="<div id=\"point_".$content_ids[$j]."_".$obj_num."[".$lesson_num."]\" style=\" 
		visibility:hidden; 
		z-index:100; 
		position:absolute; 
\">".$point_list[$j]."</div>";
		$points_list=$points_list.$point_div;
		}

		$points_list=$points_list."</div>";
		}
//with points	$analysis_list=$heading_list."<td width=33% valign='top'>".$activities_list."</td><td width=33% valign='top' id='activity_description'>".$description_list."</td><td width=33% valign='top'>".$points_list."</td></tr></table>";
	$analysis_list=$heading_list."<td width=48% valign='top'>".$activities_list."</td><td width=48% valign='top'  id='activity_description'>".$description_list."</td></tr></table>";
	print $analysis_list;

}
// format the data functions
function ShowProgressionPoints($progression_id)
{
//	$sql="select point.id,point from point left join progression_point on progression_point.point_id=point.id left join content_progression on content_progression.progression_id = progression_point.progression_id where content_progression.content_id=$content_id";
	include('mysqli_dbconnect.php');
	$sql="select point.id,point from point left join progression_point on progression_point.point_id=point.id  where progression_point.progression_id=$progression_id";
	$point=mysqli_query($tp,$sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysqli_error());
	if ($point)
		{
			" <div class='ui-widget ui-widget-content'>"; 
			$what='teaching_point';
			$point_list="<ul>";
			$arr_index=$obj_num-1;
			$lesson_teaching_points=explode(';',$teaching_points);
			$i=1;
			$data_array=explode(',',$lesson_teaching_points[$arr_index]);
			while (list($what_id,$what_name) = mysqli_fetch_array($point))
			{ 
				if (!$what_name) {$what_name=$what_id;}
					if (in_array($what_id,$data_array)) {
						$point_list=$point_list."<li class='ui-widget' value=".$what_id." style='font-weight:bold' onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$obj_num.",this)\">".$what_name."</li>"; }
				else {
						$point_list=$point_list."<li class='ui-widget' value=".$what_id." onclick=\"toggleUpdateField3Dim('".$what."',".$lesson_num.",".$obj_num.",this)\">".$what_name."</li>"; }
			$i++;
 			} 
		$point_list=$point_list."</ul></div>";
		}
	print $point_list;
}
function DrawThemes($themes,$lesson_num,$plan_type)
{
	include('mysqli_dbconnect.php');
	$user_level=$_SESSION['userlevel'];
	$theme_ids=array();
	$theme_descriptions=array();
	$theme_index=0;
        $draw_function="drawLessonLayout";
	print "<table width=100% border='0' cellpadding='2' cellspacing='2' class='ui-widget'>".
		" <tr>". 
		" <td width=40% valign='top' class=\"ui-widget\">";
	print "<div id=\"listcol[".$lesson_num."]\" class=\"ui-widget\"><b>Select a different theme for each lesson in your Unit of Work:</b><br><br><ul class='ui-widget'>";
	while (list($theme_id,$theme,$theme_description,$level,$importance,$notes)=mysqli_fetch_array($themes)) {
                if ($theme=='Core Task - Introduction Lesson') {
                    print "<li class='ui-widget' id=\"li_".$theme_id."[".$lesson_num."]\" value=\"".$theme_id."\"".
                    " onclick=\"". $draw_function."(this.value,".$lesson_num.",'".$theme."')\"".
                    " onmouseout=\"hideThemeDescription(this.value,".$lesson_num.")\"".
                    " onmouseover=\"displayThemeDescription(this.value,".$lesson_num.")\">".$theme."</li>";
                } elseif (($theme!='Core Task - Introduction Lesson')&&($user_level!=1)) {
                    print "<li class='ui-widget' id=\"li_".$theme_id."[".$lesson_num."]\" value=\"".$theme_id."\"".
                    " onclick=\"". $draw_function."(this.value,".$lesson_num.",'".$theme."')\"".
                    " onmouseout=\"hideThemeDescription(this.value,".$lesson_num.")\"".
                    " onmouseover=\"displayThemeDescription(this.value,".$lesson_num.")\">".$theme."</li>";
                } else {
                    print "<li class='ui-widget' id=\"li_".$theme_id."[".$lesson_num."]\" value=\"".$theme_id."\"".
                    " onclick=\"trialNotification()\"".
                    " onmouseout=\"hideThemeDescription(this.value,".$lesson_num.")\"".
                    " onmouseover=\"displayThemeDescription(this.value,".$lesson_num.")\">".$theme."</li>";
                }
		$theme_ids[$theme_index]=$theme_id;
		$theme_names[$theme_index]=$theme."<br><br>";
		$notes_out='';
                if (checkBase64Encoded($notes)) $notes_arr=unserialize(base64_decode($notes));
                else $notes_arr=unserialize($notes);
                if ($notes_arr==false) $notes_arr=explode('^',$notes);
		for ($n=0;$n<count($notes_arr);$n++)
		{ if ($notes_arr[$n]) $notes_out=$notes_out.no_magic_quotes(utf2ascii($notes_arr[$n]))."<br><br>";}
		$theme_descriptions[$theme_index]=str_replace("^","-",$notes_out);
		$theme_index++;
		}
	print "</ul></div>";
        print "<div class=\"help\" style=\"right:200px;top:790px;bottom:90px;height:24px;margin-top:30px;\"><a href='javascript:showHelpDialog(\"theme-".$plan_type."\")'>help</a></div>";
	print "</td> <td width=60% valign='top' class=\"ui-widget\">";
	print "<div id=\"detailcol[".$lesson_num."]\" class=\"ui-widget\">";
	for ($j = 0 ; $j < count($theme_ids) ; $j++) {
	$theme_description_display="<b>".$theme_names[$j]."</b><br>";
	$theme_description_display=$theme_description_display.$theme_descriptions[$j];
//		for ($i = 0 ; $i < count($theme_description_arr) ; $i++) {
//				if ($i==0) $theme_description_display=$theme_description_arr[$i];
//				else $theme_description_display=$theme_description_display."<br>".$theme_description_arr[$i];
//			}
		print "<div id=\"".$theme_ids[$j]."[".$lesson_num."]\" style=\"width:400px; visibility:hidden; z-index:100; position:absolute; \"><label>".$theme_description_display."</label></div>";
		}
	print "</div>";
	print "</td></tr></table>";
}
function DrawSetLessons($lessons,$lesson_num,$plan_type)
{
	$user_level=$_SESSION['userlevel'];
	$lesson_ids=array();
	$lesson_descriptions=array();
	$lesson_index=0;
	print "<table width=100% border='0' cellpadding='2' cellspacing='2' class='ui-widget'>".
		" <tr>". 
		" <td width=40% valign='top' class=\"ui-widget\">";
	print "<div id=\"listcol[".$lesson_num."]\" class=\"ui-widget\"><b>Select a set lesson for your Unit of Work:</b><br><br><ul class='ui-widget'>";
	while (list($lesson_id,$theme_id,$theme,$theme_notes)=mysqli_fetch_array($lessons)) {
            if ($theme=='Core Task - Introduction Lesson') {
		print "<li class='ui-widget' id=\"li_".$lesson_id."[".$lesson_num."]\" value=\"".$lesson_id."\"".
                " onclick=\"drawSetLessonLayout(this.value,".$theme_id.",".$lesson_num.",'".$theme."')\">".$theme."</li>";
            }
            elseif (($theme!='Core Task - Introduction Lesson')&&($user_level!=1)) {
		print "<li class='ui-widget' id=\"li_".$lesson_id."[".$lesson_num."]\" value=\"".$lesson_id."\"".
                " onclick=\"drawSetLessonLayout(this.value,".$theme_id.",".$lesson_num.",'".$theme."')\">".$theme."</li>";
            }
            else {
		print "<li class='ui-widget' id=\"li_".$lesson_id."[".$lesson_num."]\" value=\"".$lesson_id."\"".
                " onclick=\"trialNotification()\">".$theme."</li>";
            }
		$theme_ids[$lesson_index]=$lesson_id;
		$theme_names[$lesson_index]=$theme."<br><br>";
		$notes_out='';
                if (checkBase64Encoded($theme_notes)) $notes_arr=unserialize(base64_decode($theme_notes));
                else $notes_arr=unserialize($theme_notes);
                if ($notes_arr==false) $notes_arr=explode('^',$theme_notes);
		for ($n=0;$n<count($notes_arr);$n++)
		{ if ($notes_arr[$n]) $notes_out=$notes_out.utf2ascii($notes_arr[$n])."<br><br>";}
		$theme_descriptions[$theme_index]=$notes_out;
		$theme_index++;
		}
	print "</ul></div>";
	print "<div class=\"help\" style=\"right:200px;top:790px;bottom:90px;height:18px;margin-top:30px;\"><a href='javascript:showHelpDialog(\"theme-".$plan_type."\")'>help</a></div>";
	print "</td> <td width=60% valign='top' class=\"ui-widget\">";
	print "<div id=\"detailcol[".$lesson_num."]\" class=\"ui-widget\">";
	for ($j = 0 ; $j < count($theme_ids) ; $j++) {
	$theme_description_display="<b>".$theme_names[$j]."</b><br>";
	$theme_description_display=$theme_description_display.$theme_descriptions[$j];
//		for ($i = 0 ; $i < count($theme_description_arr) ; $i++) {
//				if ($i==0) $theme_description_display=$theme_description_arr[$i];
//				else $theme_description_display=$theme_description_display."<br>".$theme_description_arr[$i];
//			}
		print "<div id=\"".$theme_ids[$j]."[".$lesson_num."]\" style=\"width:400px; visibility:hidden; z-index:100; position:absolute; \"><label>".$theme_description_display."</label></div>";
		}
	print "</div>";
	print "</td></tr></table>";
}
function DrawObjectives($obj_num,$lesson_num,$objectives,$unit_id,$lesson_objectives)
{
	print	"<script type=\"text/javascript\">".
		 	" $(function() { $('#strandList_".$lesson_num."').accordion({".
			" autoHeight: false,".
			" collapsible: true,".
//			" fillSpace: true,".
//			" change: function(event, ui){alert($(ui.newContent).attr(\"id\") + \" was opened, \" + $(ui.oldContent).attr(\"id\") + \" was closed\");},".			
			" header: 'h6',".
                        " icons: { 'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s' },".
			" active: false".
			" });".
			" });".
			" </script>";
//	print "<div id=\"strandList_".$lesson_num."_".$obj_num."\" class=\"ui-widget ui-widget-content ui-corner-all leftobjcol\"><span class='ui-widget'></span>";*/
	print "<div id=\"objtabs_".$lesson_num."\" class='ui-widget ui-widget-content ui-corner-all'  style='height:400px;padding:30px'><div id=\"strandList_".$lesson_num."\">";
	if ($lesson_objectives) {
		$lesson_objectives_array=explode(",",$lesson_objectives);
				}
        $last_strand_id=0;
	while (list ($objective_id, $objective,$topic_id,$topic_name,$strand_id,$strand,$strand_description,$level_id,$level_name) = mysqli_fetch_array($objectives)) 
	{
			if ($strand_id!=$last_strand_id) 
			{
				if ($last_strand_id!=0) print "</ul>";
				print "<h6><a class='ui-widget' href=\"#\">".$strand_description." ".$strand."<div id=strandList_".$lesson_num."_".$strand_id." style='visibility:hidden;font-weight:bold'></div></a></h6><ul class='ui-widget'>";
				$last_strand_id=$strand_id;
				}	
//					print "<li  class='ui-widget' id=".$objective_id." onclick='changeObjTabAndMoveOn(this,\"objtabs_".$lesson_num."\",\"".$objective."\",\"objectiveid\",".$lesson_num.",".$obj_num.")'>".$objective."</li>";
			$obj_id=rand_str();
			if (($lesson_objectives_array) AND (in_array($objective_id,$lesson_objectives_array))) {
				print "<li><input id='".$obj_id."' name='".$obj_id."' type=\"checkbox\" class='ui-widget' value=".$objective_id." onclick=\"toggleUpdateField('objectiveid',".$lesson_num.",".$objective_id.",this.value,".$strand_id.",'".addslashes($objective)."')\" checked=true><label for='".$obj_id."'>   ".$objective."</label></li>"; 
				}
			else {
				print "<li><input id='".$obj_id."' name='".$obj_id."' type=\"checkbox\" class='ui-widget' value=".$objective_id." onclick=\"toggleUpdateField('objectiveid',".$lesson_num.",".$objective_id.",this.value,".$strand_id.",'".addslashes($objective)."')\"><label for='".$obj_id."'>   ".$objective."</label></li>"; 
				}
	}
	print "</ul></div></div>";
}
function DrawActivities($obj_num,$lesson_num,$activities,$plan_type)
{
	$content_ids=array();
	$content_descriptions=array();
	$content_index=0;
	print	"<script type=\"text/javascript\">".
		 	" $(function() { $('#lessonPartList_".$lesson_num."_".$obj_num."').accordion({".
			" autoHeight: false,".
			" collapsible: true,".
			" header: 'h6',".
			" icons: { 'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s' },".
			" active: false".
			" });".
			" });</script>";
	print "<table width=100% border='0' cellpadding='2' cellspacing='2' class='ui-widget'>".
		" <tr>". 
		" <td width=40% valign='top' class=\"ui-widget\">";
	print "<div id=\"lessonPartList_".$lesson_num."_".$obj_num."\">";
        $last_lesson_part_id=0;
	while (list ($content_id,$content_name,$content_description,$content_time,$level_id,$level_name,$lesson_part_id,$lesson_part_order,$lesson_part_name) = mysqli_fetch_array($activities)) {
			if ($lesson_part_id!=$last_lesson_part_id) {
				if ($last_lesson_part_id!=0) print "</ul>";
				print "<h6><a class='ui-widget' href=\"#\">".$lesson_part_name."</a></h6><ul class='ui-widget ui-widget-content'>"; 
				$last_lesson_part_id=$lesson_part_id;}
//				if ($content_id!=$last_content_id){
					print "<li class='ui-widget' id=\"li_".$content_id."_".$obj_num."[".$lesson_num."]\" value=\"".$content_id."\"". 
					" onclick='changeActivityTabAndMoveOn(this,\"acttabs_".$lesson_num."\",\"".$lesson_part_name."\",\"activityid\",".$lesson_num.",".$obj_num.",\"".$plan_type."\")'".
					" onmouseover=\"displayActivityDescription(this.value,".$lesson_num.",".$obj_num.")\">".stripslashes($content_name)."</li>";
//					$last_content_id=$content_id;}
					$content_ids[$content_index]=$content_id;
					$content_names[$content_index]=stripslashes($content_name);
					$content_descriptions[$content_index]=$content_description;
					$content_index++;
			}
	print "</ul></div>";
	print "</td><td width=60% valign='top' class=\"ui-widget\">";
//	print "<div id=\"detailcol[".$lesson_num."]\">";
	for ($j = 0 ; $j < count($content_ids) ; $j++) {
//	$content_description_arr=unserialize($content_descriptions[$j]);
	  	if (checkBase64Encoded($content_descriptions[$j])) 
	  	{ 
	  	$content_description_arr=unserialize(base64_decode($content_descriptions[$j]));
	  	}
	 	 else 
	  	{
	  	$content_description_arr=unserialize($content_descriptions[$j]);
	  	}
	$content_description_display="<b>".$content_names[$j]."</b><br>";
		for ($i = 0 ; $i < count($content_description_arr) ; $i++) {
				if ($content_description_arr[$i]) {
                                    if (substr($content_description_arr[$i],0,1)=="^") $content_description_arr[$i]="&nbsp; &nbsp;".substr($content_description_arr[$i],1);
                                    $content_description_display=$content_description_display."<br><br>".stripslashes($content_description_arr[$i]); }
			}
		print "<div id=\"".$content_ids[$j]."_".$obj_num."[".$lesson_num."]\" class=\"ui-widget ui-widget-content ui-corner-all\" style=\"visibility:hidden; z-index:100; position:absolute; padding:20px; width:48%;\">".$content_description_display."</div>";
		}
//		print "</div>";
		print "</td></tr><div class=\"help\" onclick='javascript:showHelpDialog(\"activities-".$plan_type."\")'>help</div>";
}
function DrawPlanPage($lesson_num,$theme_id,$topic_id,$level_id,$uow_id,$lesson_objectives,$lesson_id,$plan_type)
{
    include('mysqli_dbconnect.php');
	    
        $tab_index=$lesson_num-1;
	if ($lesson_id)
	{ 
		echo "<script type=\"text/javascript\">";
		SetUpSetLesson($lesson_id,$lesson_num,$level_id);
		echo "</script>";
		$tas=mysqli_query($tp,"select ta from lesson where id=$lesson_id");
		$sens=mysqli_query($tp,"select SEN from lesson where id=$lesson_id");
                if ((!$lesson_objectives)||($lesson_objectives=='undefined'))
                {
                    $objectives=mysqli_query($tp,"select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join objective_topic_theme on objective_topic_theme.objective_id=lesson_objectives.objective_id where lesson.id=$lesson_id");
                    $o=1;
                    $objective_array='';
                    if ($objectives)
                        {
                            while (list($objective_id,$objective,$strand_id)=mysqli_fetch_array($objectives))
                                {
                                    if ($o==1) $objective_array=$objective_id;
                                    else $objective_array=$objective_array.",".$objective_id;
                                    $o++;
                                }
                    $lesson_objectives=$objective_array;
                    }
		}
        }
	else {
            if ($plan_type=="newPlan")
            {
		echo "<script type=\"text/javascript\">;window.lessonType='newLesson';";
            	SetUpNewLesson($uow_id,$lesson_num,$theme_id,$level_id);
		echo "</script>";
		$tas=mysqli_query($tp,"select ta from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
		$sens=mysqli_query($tp,"select SEN from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
            }
            else
             {
		echo "<script type=\"text/javascript\">";
            	SetUpBlankNewLesson($uow_id,$lesson_num);
		echo "</script>";
		$tas=mysqli_query($tp,"select ta from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
		$sens=mysqli_query($tp,"select SEN from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
            }
	}
	list($ta)=mysqli_fetch_array($tas);
	list($sen)=mysqli_fetch_array($sens);
	print	"<script type=\"text/javascript\">".
		 	" $(function() { $('#planPage_".$lesson_num."').accordion({".
			" collapsible: true,".
			" change: function(event, ui) {showInstruction(".$lesson_num.",$(ui.newContent).attr(\"id\"));hideInstruction(".$lesson_num.",$(ui.oldContent).attr(\"id\"));},".
			" autoHeight: false,".
			" header: 'h3',".
                        " icons: { 'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s' },".
			" active: false".
			" });".
			" });".
			" </script>".
 			" <div id=\"planPage_".$lesson_num."\">".
			" <h3><a class='ui-widget' href=\"#\">Step 1 - Objectives<div id='objtabs_".$lesson_num."_full' style='visibility:hidden;font-weight:bold'>Select up to 4 appropriate objectives for your lesson theme from the strands below</div></a></h3>".
			" <div style='height:500px' id='objectiveListDiv[".$lesson_num."]'>";
			GetObjectives(1,$lesson_num,$topic_id,$level_id,$theme_id,$uow_id,$lesson_objectives);
                  print "<div class=\"help\" onclick='javascript:showHelpDialog(\"objectives-".$plan_type."\")'>help</div></div>".
			" <h3><a class='ui-widget' href=\"#\">Step 2 - Activities<div id='acttabs_".$lesson_num."_full' style='visibility:hidden;font-weight:bold'>Select activities from these lesson parts to structure your lesson. Drag and drop tabs to reorder activities</div></a></h3>".
			" <div style='height:500px' id='activityListDiv[".$lesson_num."]'>".
			" <div id=\"acttabs_".$lesson_num."\" style=\"visibility:hidden;cursor:pointer;\">".
			" <ul id='act_ul_".$lesson_num."'>".
			" </ul>".
			" </div>".
			" </div>".
			" <h3><a class='ui-widget' href=\"#\">Step 3 - Assistance<div id='asstabs_".$lesson_num."_full' style='visibility:hidden;font-weight:bold'>Enter any assistance you might need with this lesson</div></a></h3>".
			" <div id='assistanceDiv[".$lesson_num."]'>".
			" <div id='asstabs_".$lesson_num."' class='ui-widget ui-widget-content ui-corner-all' style='height:120px;padding:30px'><span class='ui-widget'>Teaching Assistant to support lesson by: </span><br><br>".
			" <input type='text' id='ta[".$lesson_num."]' name='ta[".$lesson_num."]' class='ui-widget ui-widget-content ui-corner-all' style='border:1px solid grey' size=64 value='".$ta."' onchange=\"doUpdateSEN('taout',".$lesson_num.",this.value)\"><br><br>".
			" <span class='ui-widget'>SEN Information: </span><br><br>".
			" <input type='text' id='sen[".$lesson_num."]' name='sen[".$lesson_num."]' class='ui-widget ui-widget-content ui-corner-all' style='border:1px solid grey' size=64 value='".$sen."' onchange=\"doUpdateSEN('senout',".$lesson_num.",this.value)\">".
			" </div><div class=\"help\" onclick='javascript:showHelpDialog(\"assistance -".$plan_type."\")'>help</div></div>".
			" <h3><a class='ui-widget' href=\"#\">Step 4 - Cross Curricular Opportunities<div id='ccotabs_".$lesson_num."_full' style='visibility:hidden;font-weight:bold'>Select Literacy Keywords, Citizenship, ICT, Numeracy and Risk Assessment</div></a></h3>".
			" <div style='height:400px' id='ccoDiv[".$lesson_num."]'>".
			" <div id=\"ccotabs_".$lesson_num."\" style=\"visibility:hidden;cursor:pointer;\">".
			" <ul id='cco_ul_".$lesson_num."'>".
			" </ul>".
			" </div>".
			" </div>".
			" <h3><a class='ui-widget' href=\"#\">Step 5 - Finish, Save & Print<div id='savetabs_".$lesson_num."_full' style='visibility:hidden;font-weight:bold'>Finish creating your unit and print off your plans</div></a></h3>".
			" <div id='saveDiv[".$lesson_num."]'>".
			" <div id='savetabs_".$lesson_num."' style='height:200px!important;'><table width=100% border='0' cellpadding='2' cellspacing='2'>".
			" <tr><td colspan=5><input name='exit_mode[".$lesson_num."]' id='exit_mode[".$lesson_num."]' type=hidden /></td></tr><tr>".
			" <td align=center valign=top width=20%><input alt=\"Save and Exit\" class=\"btn btn-m\" type=\"submit\" value=\"Save and Exit\" onclick='goHome();' /></td>".
			" <td align=center valign=top width=20%><input alt=\"Save and Continue\" class=\"btn btn-m\" type=\"submit\" value=\"Save & Continue\" onclick='submitAndUpdate(\"#storeRoom_".$lesson_num."\");' /></td>".
			" <td align=center valign=top width=20%><input alt=\"Save and Print\" class=\"btn btn-m\" type=\"submit\" value=\"Save & Print\" onclick='submitAndUpdate(\"#storeRoom_".$lesson_num."\");printPlan(".$lesson_num.",".$uow_id.")' /></td>".
			" <td align=center valign=top width=20%><a class=\"btn btn-m assessment\"><span>Assessment</span></a>".
                        " <fieldset id=\"assessment_menu_".$lesson_num."\" class=\"assessment_menu\"><ul><li><a href=\"javascript:mainPrintAssessment(1, ".$topic_id.", ".$level_id.",".$uow_id.")\">Class</a></li><li><a href=\"javascript:mainPrintAssessment(2, ".$topic_id.", ".$level_id.",".$uow_id.")\"'>Individual</a></li><li><a href=\"javascript:mainPrintAssessment(3, ".$topic_id.", ".$level_id.",".$uow_id.")\"'>Teacher</a></li></ul></fieldset></td></tr>".
                        " </table><div class=\"help\" style=\"margin-top:60px;\" onclick='javascript:showHelpDialog(\"exit\")'>help</div>".
			" </div></div>".
                        " <div id=\"lesson_help\" class=\"top_help\" style=\"margin-top:10px;position:relative;\" onclick='javascript:showHelpDialog(\"lesson-".$plan_type."\")'>help</div>".
                        " <script type=\"text/javascript\">".
			" drawObjectiveTabs(".$lesson_num.");".
			" drawActivityTabs(".$lesson_num.");".
			" drawCcoTabs(".$lesson_num.");".
                        " $(\".assessment\").click(function(e) {".
                        " e.preventDefault();".
                        " $(\"fieldset#assessment_menu_".$lesson_num."\").toggle();".
                        " $(\".assessment\").toggleClass(\"menu-open\");".
                        " });".
                        " $(\"fieldset#assessment_menu_".$lesson_num."\").mouseup(function() {".
                        "       return false".
                        " });".
                        " $(document).mouseup(function(e) {".
                        " if($(e.target).parent(\"a.assessment\").length==0) {".
                        " $(\".assessment\").removeClass(\"menu-open\");".
                        " $(\"fieldset#assessment_menu_".$lesson_num."\").hide();".
                        " }".
                        " });".
			" </script>";
}
function DrawPlanPage2014($lesson_num,$theme_id,$topic_id,$level_id,$uow_id,$lesson_objectives,$lesson_id,$plan_type)
{
     include('mysqli_dbconnect.php');
	   
        $tab_index=$lesson_num-1;
	if ($lesson_id)
	{ 
		echo "<script type=\"text/javascript\">";
		SetUpSetLesson($lesson_id,$lesson_num,$level_id);
		echo "</script>";
		$tas=mysqli_query($tp,"select ta from lesson where id=$lesson_id");
		$sens=mysqli_query($tp,"select SEN from lesson where id=$lesson_id");
                if ((!$lesson_objectives)||($lesson_objectives=='undefined'))
                {
                    $objectives=mysqli_query($tp,"select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join objective_topic_theme on objective_topic_theme.objective_id=lesson_objectives.objective_id where lesson.id=$lesson_id");
                    $o=1;
                    $objective_array='';
                    if ($objectives)
                        {
                            while (list($objective_id,$objective,$strand_id)=mysqli_fetch_array($objectives))
                                {
                                    if ($o==1) $objective_array=$objective_id;
                                    else $objective_array=$objective_array.",".$objective_id;
                                    $o++;
                                }
                    $lesson_objectives=$objective_array;
                    }
		}
        }
	else {
            if ($plan_type=="newPlan")
            {
		echo "<script type=\"text/javascript\">;window.lessonType='newLesson';";
            	SetUpNewLesson($uow_id,$lesson_num,$theme_id,$level_id);
		echo "</script>";
		$tas=mysqli_query($tp,"select ta from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
		$sens=mysqli_query($tp,"select SEN from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
            }
            else
             {
		echo "<script type=\"text/javascript\">";
            	SetUpBlankNewLesson($uow_id,$lesson_num);
		echo "</script>";
		$tas=mysqli_query($tp,"select ta from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
		$sens=mysqli_query($tp,"select SEN from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
            }
	}
	list($ta)=mysqli_fetch_array($tas);
	list($sen)=mysqli_fetch_array($sens);
	print	"<script type=\"text/javascript\">".
		 	" $(function() { $('#planPage_".$lesson_num."').accordion({".
			" collapsible: true,".
			" change: function(event, ui) {showInstruction(".$lesson_num.",$(ui.newContent).attr(\"id\"));hideInstruction(".$lesson_num.",$(ui.oldContent).attr(\"id\"));},".
			" autoHeight: false,".
			" header: 'h3',".
                        " icons: { 'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s' },".
			" active: false".
			" });".
			" });".
			" </script>".
 			" <div id=\"planPage_".$lesson_num."\">".
			" <h3><a class='ui-widget' href=\"#\">Step 1 - Objectives<div id='objtabs_".$lesson_num."_full' style='visibility:hidden;font-weight:bold'>Select up to 4 appropriate objectives for your lesson theme from the strands below</div></a></h3>".
			" <div style='height:500px' id='objectiveListDiv[".$lesson_num."]'>";
			if($level_id!=0.0) GetObjectives2014(1,$lesson_num,$topic_id,$level_id,$theme_id,$uow_id,$lesson_objectives);
			else GetObjectives(1,$lesson_num,$topic_id,$level_id,$theme_id,$uow_id,$lesson_objectives);
                  print "<div class=\"help\" onclick='javascript:showHelpDialog(\"objectives-".$plan_type."\")'>help</div></div>".
			" <h3><a class='ui-widget' href=\"#\">Step 2 - Activities<div id='acttabs_".$lesson_num."_full' style='visibility:hidden;font-weight:bold'>Select activities from these lesson parts to structure your lesson. Drag and drop tabs to reorder activities</div></a></h3>".
			" <div style='height:500px' id='activityListDiv[".$lesson_num."]'>".
			" <div id=\"acttabs_".$lesson_num."\" style=\"visibility:hidden;cursor:pointer;\">".
			" <ul id='act_ul_".$lesson_num."'>".
			" </ul>".
			" </div>".
			" </div>".
			" <h3><a class='ui-widget' href=\"#\">Step 3 - Assistance<div id='asstabs_".$lesson_num."_full' style='visibility:hidden;font-weight:bold'>Enter any assistance you might need with this lesson</div></a></h3>".
			" <div id='assistanceDiv[".$lesson_num."]'>".
			" <div id='asstabs_".$lesson_num."' class='ui-widget ui-widget-content ui-corner-all' style='height:120px;padding:30px'><span class='ui-widget'>Teaching Assistant to support lesson by: </span><br><br>".
			" <input type='text' id='ta[".$lesson_num."]' name='ta[".$lesson_num."]' class='ui-widget ui-widget-content ui-corner-all' style='border:1px solid grey' size=64 value='".$ta."' onchange=\"doUpdateSEN('taout',".$lesson_num.",this.value)\"><br><br>".
			" <span class='ui-widget'>SEN Information: </span><br><br>".
			" <input type='text' id='sen[".$lesson_num."]' name='sen[".$lesson_num."]' class='ui-widget ui-widget-content ui-corner-all' style='border:1px solid grey' size=64 value='".$sen."' onchange=\"doUpdateSEN('senout',".$lesson_num.",this.value)\">".
			" </div><div class=\"help\" onclick='javascript:showHelpDialog(\"assistance -".$plan_type."\")'>help</div></div>".
			" <h3><a class='ui-widget' href=\"#\">Step 4 - Cross Curricular Opportunities<div id='ccotabs_".$lesson_num."_full' style='visibility:hidden;font-weight:bold'>Select Literacy Keywords, Citizenship, ICT, Numeracy and Risk Assessment</div></a></h3>".
			" <div style='height:400px' id='ccoDiv[".$lesson_num."]'>".
			" <div id=\"ccotabs_".$lesson_num."\" style=\"visibility:hidden;cursor:pointer;\">".
			" <ul id='cco_ul_".$lesson_num."'>".
			" </ul>".
			" </div>".
			" </div>".
			" <h3><a class='ui-widget' href=\"#\">Step 5 - Finish, Save & Print<div id='savetabs_".$lesson_num."_full' style='visibility:hidden;font-weight:bold'>Finish creating your unit and print off your plans</div></a></h3>".
			" <div id='saveDiv[".$lesson_num."]'>".
			" <div id='savetabs_".$lesson_num."' style='height:200px!important;'><table width=100% border='0' cellpadding='2' cellspacing='2'>".
			" <tr><td colspan=5><input name='exit_mode[".$lesson_num."]' id='exit_mode[".$lesson_num."]' type=hidden /></td></tr><tr>".
			" <td align=center valign=top width=20%><input alt=\"Save and Exit\" class=\"btn btn-m\" type=\"submit\" value=\"Save and Exit\" onclick='goHome();' /></td>".
			" <td align=center valign=top width=20%><input alt=\"Save and Continue\" class=\"btn btn-m\" type=\"submit\" value=\"Save & Continue\" onclick='submitAndUpdate(\"#storeRoom_".$lesson_num."\");' /></td>".
			" <td align=center valign=top width=20%><input alt=\"Save and Print\" class=\"btn btn-m\" type=\"submit\" value=\"Save & Print\" onclick='submitAndUpdate(\"#storeRoom_".$lesson_num."\");printPlan(".$lesson_num.",".$uow_id.")' /></td>".
			" <td align=center valign=top width=20%><a class=\"btn btn-m assessment\"><span>Assessment</span></a>".
                        " <fieldset id=\"assessment_menu_".$lesson_num."\" class=\"assessment_menu\"><ul><li><a href=\"javascript:mainPrintAssessment(1, ".$topic_id.", ".$level_id.",".$uow_id.")\">Class</a></li><li><a href=\"javascript:mainPrintAssessment(2, ".$topic_id.", ".$level_id.",".$uow_id.")\"'>Individual</a></li><li><a href=\"javascript:mainPrintAssessment(3, ".$topic_id.", ".$level_id.",".$uow_id.")\"'>Teacher</a></li></ul></fieldset></td></tr>".
                        " </table><div class=\"help\" style=\"margin-top:60px;\" onclick='javascript:showHelpDialog(\"exit\")'>help</div>".
			" </div></div>".
                        " <div id=\"lesson_help\" class=\"top_help\" style=\"margin-top:10px;position:relative;\" onclick='javascript:showHelpDialog(\"lesson-".$plan_type."\")'>help</div>".
                        " <script type=\"text/javascript\">".
			" drawObjectiveTabs(".$lesson_num.");".
			" drawActivityTabs(".$lesson_num.");".
			" drawCcoTabs(".$lesson_num.");".
                        " $(\".assessment\").click(function(e) {".
                        " e.preventDefault();".
                        " $(\"fieldset#assessment_menu_".$lesson_num."\").toggle();".
                        " $(\".assessment\").toggleClass(\"menu-open\");".
                        " });".
                        " $(\"fieldset#assessment_menu_".$lesson_num."\").mouseup(function() {".
                        "       return false".
                        " });".
                        " $(document).mouseup(function(e) {".
                        " if($(e.target).parent(\"a.assessment\").length==0) {".
                        " $(\".assessment\").removeClass(\"menu-open\");".
                        " $(\"fieldset#assessment_menu_".$lesson_num."\").hide();".
                        " }".
                        " });".
			" </script>";
}
function DrawTopics($topics)
{
	print	"<script type=\"text/javascript\">".
		 	" $(function() { $('#genreList').accordion({".
			" autoHeight: false,".
			" collapsible: true,".
			" header: 'h3',".
			" active: false".
			" });".
			" });</script>";
	print "<div id=\"genreList\">";
	while (list ($topic_id,$topic,$topic_genre,$genre_id,$genre) = mysqli_fetch_array($topics)) {
			if ($genre_id!=$last_genre_id) {
				if ($last_genre_id) print "</ul>"; 
				print "<h3><a href=\"#\">".$genre."</a></h3><ul class='ui-widget ui-widget-content ui-corner-all'>"; 
				$last_genre_id=$genre_id;}
				print "<li id=".$topic_id." onmouseover='highlightListSelected(this)' onmouseout='lowlightListSelected(this)' onclick='makeSelection(this,\"topic\")'>".$topic."</li>";
			}
		print "</div>";
}			
function CreateList($what,$things,$lesson_num,$topic_id,$data,$title,$plan_type)
{	
	if (!$things) echo "No ".$what." currrently defined";
	else {
	echo "<span class='ui-widget'>".$title."</span><br><br><ul class='ui-widget ui-widget-content ui-corner-all list_div'>";
	$i=1;
	$data_array=explode(',',$data);
	while (list($what_id,$what_name) = mysqli_fetch_array($things))
	{
		$cb_id=rand_str();
		if (!$what_name) {$what_name=$what_id;}
		if (in_array($what_id,$data_array)) {
			echo "<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" onclick=\"toggleUpdateField2Dim('".$what."',".$lesson_num.",".$i.",this)\" class='ui-widget' value=".$what_id." checked=true><label for='".$cb_id."'>   ".$what_name."</label>  </li>"; }
		else {
			echo "<li><input id='".$cb_id."' name='".$cb_id."' type=\"checkbox\" onclick=\"toggleUpdateField2Dim('".$what."',".$lesson_num.",".$i.",this)\" class='ui-widget' value=".$what_id."><label for='".$cb_id."'>   ".$what_name."</label> </li>"; }
		$i++;
 	} 
	echo "</ul><div class=\"help\" onclick='javascript:showHelpDialog(\"cco-".$plan_type."\")'>help</div>";
	}
}
// save data functions
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
 function GetPrintContent($lesson_num,$uow_id)
{

   include('mysqli_dbconnect.php');
	// first we get the unit of work details
        $unit=mysqli_query($tp,"select * from unit_of_work where id =$uow_id")  or die("Error reported while executing the statement: <br />MySQL reported: ".mysqli_error());;
	list($unit_id,$unit_description,$topic_id,$level_id,$teacher_id,$num_lessons,$public,$date_created)=mysqli_fetch_array($unit);
        $_SESSION[$lesson_num]['level']=$level_id;
        $_SESSION[$lesson_num]['title']=$unit_description;
   //get the topic details
        $topic_name=mysqli_query($tp,"select name from topic where id=$topic_id");
	list ($_SESSION[$lesson_num]['mysubject'])=mysqli_fetch_array($topic_name);
   // get the school, this may need some thought regarding setting their accounts up
        $school_name=mysqli_query($tp,"select school from school");
	list($_SESSION[$lesson_num]['school'])=mysqli_fetch_array($school_name);
   // get the teacher details, again they have to set this up in their accounts
	$mydetails=mysqli_query($tp,"select name, gender, school, postcode from users where id=$teacher_id");
	list($name,$gender,$school,$postcode)=mysqli_fetch_array($mydetails);
	$_SESSION[$lesson_num]['name']=$name;
        $_SESSION[$lesson_num]['school']=$school;
   // get the assistance details
        $lesson=mysqli_query($tp,"select id,set_lesson_id from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
        list ($my_lesson_id,$set_lesson_id)=mysqli_fetch_array($lesson);
		if($set_lesson_id) $lesson_id=$set_lesson_id; else $lesson_id=$my_lesson_id;
        $_SESSION[$lesson_num]['assistance']=mysqli_query($tp,"select ta,sen from lesson where id=$lesson_id");
  // get the theme for the lesson, the teacher notes and any evaluation guidance
	//$themes=mysqli_query($tp,"select lesson.theme_id,theme.theme, topic_theme.notes,evaluation.evaluation from lesson left join theme on lesson.theme_id=theme.id left join topic_theme on theme.id=topic_theme.theme_id left join topic_theme_evaluation on topic_theme_evaluation.theme_id=topic_theme.theme_id left join evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where lesson.id=$lesson_id and topic_theme.topic_id=$topic_id and topic_theme_evaluation.level=$level_id and evaluation.evaluation is not NULL order by topic_theme.notes desc");
        $themes=mysqli_query($tp,"select lesson.theme_id,theme.theme, topic_theme.notes from lesson left join theme on lesson.theme_id=theme.id left join topic_theme on theme.id=topic_theme.theme_id where lesson.id=$lesson_id and topic_theme.topic_id=$topic_id and topic_theme.level=$level_id order by topic_theme.notes desc");
        list($theme_id,$theme,$teacher_notes)=mysqli_fetch_array($themes);
        $_SESSION[$lesson_num]['theme']="Lesson ".$lesson_num." of ".$num_lessons." - ".$theme;
   // put the teachers notes into an array aqfter checking for encoding and the metohod they were stored
        if (checkBase64Encoded($teacher_notes)) $_SESSION[$lesson_num]['teacher_notes_arr']=unserialize(base64_decode($teacher_notes));
        else  $_SESSION[$lesson_num]['teacher_notes_arr']=unserialize($teacher_notes);
        if ( $_SESSION[$lesson_num]['teacher_notes_arr']==false)  $_SESSION[$lesson_num]['teacher_notes_arr']=explode('^',$teacher_notes);
//        $evaluations=mysqli_query($tp,"select lesson.theme_id,theme.theme, topic_theme.notes,evaluation.evaluation from lesson left join theme on lesson.theme_id=theme.id left join topic_theme on theme.id=topic_theme.theme_id left join topic_theme_evaluation on topic_theme_evaluation.theme_id=topic_theme.theme_id left join evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where lesson.id=$lesson_id and topic_theme.topic_id=$topic_id and topic_theme_evaluation.level=$level_id and evaluation.evaluation is not NULL order by topic_theme.notes desc");
        $evaluations=mysqli_query($tp,"select evaluation.evaluation from evaluation left join topic_theme_evaluation on topic_theme_evaluation.evaluation_id=evaluation.id where topic_theme_evaluation.topic_id=$topic_id and topic_theme_evaluation.level=$level_id and topic_theme_evaluation.theme_id=$theme_id and evaluation.evaluation is not NULL");
//        $evaluations=mysqli_query($tp,"select evaluation.evaluation from lesson left join theme on lesson.theme_id=theme.id left join topic_theme on theme.id=topic_theme.theme_id left join topic_theme_evaluation on topic_theme_evaluation.theme_id=topic_theme.theme_id left join evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where topic_theme.topic_id=$topic_id and topic_theme_evaluation.level=$level_id and evaluation.evaluation is not NULL order by evaluation.evaluation desc");
        list($evaluation)=mysqli_fetch_array($evaluations);
  // put the evaluation guidance in an array in the same way as teacher notes above
        //if (checkBase64Encoded($_SESSION[$lesson_num]['evaluation_arr'])) $_SESSION[$lesson_num]['evaluation_arr']=unserialize(base64_decode($evaluation));
        //else
        $_SESSION[$lesson_num]['evaluation_arr']=unserialize($evaluation);
        if ($_SESSION[$lesson_num]['evaluation_arr']==false) $_SESSION[$lesson_num]['evaluation_arr']=explode('?',$evaluation);
  // get the objectives for the lesson and store in an array
  		if($level_id!=0.0){
        $_SESSION[$lesson_num]['objectives']=mysqli_query($tp,"select objective_id,objective from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id where lesson.id=$lesson_id and objectives.nc='y' order by objectives.id");}
		else {$_SESSION[$lesson_num]['objectives']=mysqli_query($tp,"select objective_id,objective from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id where lesson.id=$lesson_id order by objectives.id");}
	$_SESSION[$lesson_num]['keywords']=mysqli_query($tp,"select keyword_id,keyword from lesson_keywords left join keywords on keywords.id=lesson_keywords.keyword_id left join lesson on lesson.id=lesson_keywords.lesson_id where lesson.id=$lesson_id");
	$_SESSION[$lesson_num]['icts']=mysqli_query($tp,"select ict_id,description from lesson_ict left join ICT on ICT.id=ict_id left join lesson on lesson.id=lesson_ict.lesson_id where lesson.id=$lesson_id");
	$_SESSION[$lesson_num]['numeracys']=mysqli_query($tp,"select numeracy_id,description from lesson_numeracy left join numeracy on numeracy.id=numeracy_id left join lesson on lesson.id=lesson_numeracy.lesson_id where lesson.id=$lesson_id");
	$_SESSION[$lesson_num]['citizenships']=mysqli_query($tp,"select citizenship_id,description from lesson_citizenship left join citizenship on citizenship.id=citizenship_id left join lesson on lesson.id=lesson_citizenship.lesson_id where lesson.id=$lesson_id");
	$_SESSION[$lesson_num]['risk_assessments']=mysqli_query($tp,"select ra_id,description from lesson_risk_assessment left join risk_assessment on risk_assessment.id=ra_id left join lesson on lesson.id=lesson_risk_assessment.lesson_id where lesson.id=$lesson_id");
	$_SESSION[$lesson_num]['equipment']=mysqli_query($tp,"select la_id,activity_id,lesson_activities.time as la_time,lesson_part.description as lesson_part,content.name as content_name,content.description as content_description,content.time as content_time, equipment.description as equipment from lesson_activities left join content on content.content_id=activity_id left join lesson on lesson.id=lesson_activities.lesson_id left join content_lesson_part on content_lesson_part.content_id = lesson_activities.activity_id left join lesson_part on lesson_part.id = content_lesson_part.lesson_part_id left join content_equipment on activity_id=content_equipment.content_id left join equipment on content_equipment.equipment_id=equipment.id where lesson.id=$lesson_id order by activity_num");
	$_SESSION[$lesson_num]['activities']=mysqli_query($tp,"select la_id,activity_id,lesson_activities.time as la_time,lesson_part.description as lesson_part,content.name as content_name,content.description as content_description,content.time as content_time from lesson_activities left join content on content.content_id=activity_id left join lesson on lesson.id=lesson_activities.lesson_id left join content_lesson_part on content_lesson_part.content_id = lesson_activities.activity_id left join lesson_part on lesson_part.id = content_lesson_part.lesson_part_id where lesson.id=$lesson_id order by activity_num");
	if ($_SESSION[$lesson_num]['activities'])
	{
		$act_num=1;
		$num_acts=mysqli_num_rows($_SESSION[$lesson_num]['activities']);
		while (list($la_id,$activity_id,$time,$lesson_part,$content_name,$content_description,$content_time)=mysqli_fetch_array($_SESSION[$lesson_num]['activities']))
		{
			if ($lesson_part) $lesson_part_string[$act_num]=$lesson_part;
                                $strands=mysqli_query($tp,"select strand_id,strand from lesson_activity_strand left join strand on strand.id=strand_id left join lesson_activities on lesson_activities.la_id=lesson_activity_strand.la_id where lesson_activity_strand.la_id = $la_id");
				if ($strands)
				{
					$_SESSION[$lesson_num]['strands'][$act_num]=$strands;
                                }
				$teaching_points=mysqli_query($tp,"SELECT point FROM point LEFT JOIN content_point ON content_point.point_id = point.id LEFT JOIN lesson_activity_point ON lesson_activity_point.point_id = point.id WHERE lesson_activity_point.la_id=$la_id and content_id = $activity_id ORDER BY point_num");
				if ($teaching_points)
				{
					$_SESSION[$lesson_num]['teaching_points'][$act_num]=$teaching_points;
                                }
				$hard_differentiations=mysqli_query($tp,"select diff_id,differentiation,difficulty from lesson_activity_differentiation left join differentiation on diff_id=differentiation.id left join lesson_activities on lesson_activities.la_id=lesson_activity_differentiation.la_id where lesson_activity_differentiation.la_id = $la_id and difficulty = 'H' order by difficulty desc");
				if ($hard_differentiations)
				{
					$_SESSION[$lesson_num]['hard_differentiations'][$act_num]=$hard_differentiations;
                                }
				$easy_differentiations=mysqli_query($tp,"select diff_id,differentiation,difficulty from lesson_activity_differentiation left join differentiation on diff_id=differentiation.id left join lesson_activities on lesson_activities.la_id=lesson_activity_differentiation.la_id where lesson_activity_differentiation.la_id = $la_id and difficulty = 'E' order by difficulty desc");
				if ($easy_differentiations)
				{
					$_SESSION[$lesson_num]['easy_differentiations'][$act_num]=$easy_differentiations;
                                }
				$_SESSION[$lesson_num]['progressions'][$act_num]=mysqli_query($tp,"select la_pr_id,pr_id,progression from lesson_activity_progression left join progression on progression.id=pr_id left join lesson_activities on lesson_activities.la_id=lesson_activity_progression.la_id where lesson_activity_progression.la_id = $la_id");
				if ($_SESSION[$lesson_num]['progressions'][$act_num])
				{
				       $_SESSION[$lesson_num]['num_progs'][$act_num]=mysqli_num_rows($_SESSION[$lesson_num]['progressions'][$act_num]);
                                        for ($i = 0 ; $i <= count($_SESSION[$lesson_num]['num_progs'][$act_num]) ; $i++)
                                        {
                                            list($la_pr_id,$progression_id,$progression)=mysqli_fetch_array($_SESSION[$lesson_num]['progressions'][$act_num]);
					    $_SESSION[$lesson_num]['prog_points'][$act_num][$i]=mysqli_query($tp,"select point_id,point from lesson_activity_progression_point left join lesson_activity_progression on lesson_activity_progression.la_pr_id=lesson_activity_progression_point.la_pr_id left join point on point.id=point_id where  lesson_activity_progression.la_id = $la_id and lesson_activity_progression.pr_id=$progression_id order by point.id desc");
                                            //$_SESSION[$lesson_num]['prog_points'][$act_num][$i]=mysqli_query($tp,"select point_id,point from lesson_activity_progression_point left join lesson_activity_progression on lesson_activity_progression.la_pr_id=lesson_activity_progression_point.la_pr_id left join point on point.id=point_id where  lesson_activity_progression_point.la_pr_id = $la_pr_id");
                                        }
				}
				$_SESSION[$lesson_num]['analysess'][$act_num]=mysqli_query($tp,"select analyses_id,content.name as analysis_title,content.description as analysis from lesson_activity_analyses left join content on content.content_id=analyses_id left join lesson_activities on lesson_activities.la_id=lesson_activity_analyses.la_id where lesson_activity_analyses.la_id = $la_id");
				if ($_SESSION[$lesson_num]['analysess'][$act_num])
				{
				      	$num_anals=mysqli_num_rows($_SESSION[$lesson_num]['analysess'][$act_num]);
                                        for ($i = 0 ; $i < $num_anals ; $i++)
                                            {
						list($analyses_id,$content_name,$content_description)=mysqli_fetch_array($_SESSION[$lesson_num]['analysess'][$act_num]);
                                                $_SESSION[$lesson_num]['anal_points'][$act_num][$i]=mysqli_query($tp,"select point_id,point from point left join content_point on content_point.point_id=point.id where content_point.content_id=$analyses_id");
                                            }
                                }
		$act_num++;
		}
                if (mysqli_num_rows($_SESSION[$lesson_num]['activities'])>0) mysqli_data_seek($_SESSION[$lesson_num]['activities'],0);
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
function rand_str($length = 32, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890')
{
    $chars_length = (strlen($chars) - 1);
    $string = $chars{rand(0, $chars_length)};
    for ($i = 1; $i < $length; $i = strlen($string))
    {
        $r = $chars{rand(0, $chars_length)};
        if ($r != $string{$i - 1}) $string .=  $r;
    }
    return $string;
}
function SetUpLessons($unit_id,$num_lessons,$lesson_type,$topic_id,$level_id,$set_id,$lesson_num)
{
	include('mysqli_dbconnect.php');
	if ($lesson_type=="newPlan")
	{
			for ($i=1;$i<=$num_lessons;$i++)
			{
                                SetUpThemes($unit_id,$i,$level_id);
                            
			}
        		

	}
        elseif ($lesson_type=="brandNewPlan")
	{
			for ($i=1;$i<=$num_lessons;$i++)
			{
				SetUpNewLessonThemes($unit_id,$i);
			}


	}
	elseif ($lesson_type=="setPlan")
	{
            if ($num_lessons>4)
            {
                $get_plans=list($set_plan_id)=mysqli_fetch_array(mysqli_query($tp,"select set_plan_id from set_plans where topic_id=$topic_id and level=$level_id and num_lessons=$num_lessons"));
			if (!$set_plan_id) echo "whoops!!";
			else 
				{
					$get_lessons=mysqli_query($tp,"select lesson_id,lesson_num from set_plan_lessons where set_plan_id=$set_plan_id order by lesson_num"); 
					while (list($lesson_id,$lesson_num)=mysqli_fetch_array($get_lessons))
						{
							SetUpSetLesson($lesson_id,$lesson_num,$level_id);
						}
				}
            }
        }
}
function SetUpThemes($unit_id,$l,$level_id)
{
    include('mysqli_dbconnect.php');
	$lessons=mysqli_query($tp,"select id,set_lesson_id from lesson where uow_id=$unit_id and lesson_num=$l") or die("Error reported while executing the statement: <br />MySQL reported: ".mysqli_error());
	while(list ($my_lesson_id,$set_lesson_id)=mysqli_fetch_array($lessons))
		{
			if($set_lesson_id) $lesson_id=$set_lesson_id; else $lesson_id=$my_lesson_id;
			echo "window.lessonIds[".$l."]=".$lesson_id.";";
			$themes=mysqli_query($tp,"select theme_id,theme.theme from lesson left join theme on theme_id=theme.id where lesson.id=$lesson_id") or die("Error reported while executing the statement: <br />MySQL reported: ".mysqli_error());
				while(list ($theme_id,$theme)=mysqli_fetch_array($themes))
				{
            		if(!is_null($theme_id))
            		{
						echo "window.themeIds[".$l."]=".$theme_id.";";
						echo "window.themes[".$l."]='".$theme."';";
					}
				}
		    $sens=mysqli_query($tp,"select ta,sen from lesson where id=$lesson_id");
            	if ($sens)
            	{
            		(list($ta,$sen)=mysqli_fetch_array($sens));
            			echo "window.ta[".$l."]='".$ta."';";
            			echo "window.sen[".$l."]='".$sen."';";
            	}
            echo "window.objectiveIds_array[".$l."]=new Array;";
            echo "window.objectiveIds[".$l."]=new Array;";
            echo "window.objectives[".$l."]=new Array;";
            echo "window.objectiveStrand[".$l."]=new Array;";
			if($level_id!=0.0){
            $objectives=mysqli_query($tp,"select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join objective_strand on lesson_objectives.objective_id=objective_strand.objective_id left join objective_topic on objective_topic.objective_id=lesson_objectives.objective_id where lesson.id=$lesson_id");}
			else{ $objectives=mysqli_query($tp,"select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join objective_strand on lesson_objectives.objective_id=objective_strand.objective_id left join objective_topic on objective_topic.objective_id=lesson_objectives.objective_id where lesson.id=$lesson_id UNION select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join topic_objectives on topic_objectives.objectives_id=lesson_objectives.objective_id where lesson.id=$lesson_id");}
            	$o=1;
            	$objective_array='';
            	if ($objectives)
            	{
            		while (list($objective_id,$objective,$strand_id)=mysqli_fetch_array($objectives))
                    	{
                            if ($o==1) $objective_array=$objective_id;
							if(!$strand_id) $strand_id=0;
                            else $objective_array=$objective_array.",".$objective_id;
                            echo "window.objectiveIds[".$l."].splice(".$objective_id.",0,".$objective_id.");";
                            echo "window.objectives[".$l."].splice(".$objective_id.",0,'".addslashes($objective)."');";
                            echo "window.objectiveStrand[".$l."].splice(".$objective_id.",0,".$strand_id.");";
                            $o++;
                    	}
            		echo "window.objectiveIds_array[".$l."]='".$objective_array."';";
            	}
		}
         
}
function SetUpBlankNewLesson($unit_id,$l)
{
    echo "window.objectiveIds_array[".$l."]=new Array;";
	echo "window.objectiveIds[".$l."]=new Array;";
	echo "window.objectives[".$l."]=new Array;";
	echo "window.objectiveStrand[".$l."]=new Array;";
	echo "window.keywords_array[".$l."]=new Array;";
	echo "window.keywords[".$l."]=new Array;";
	echo "window.ict_array[".$l."]=new Array;";
	echo "window.ict[".$l."]=new Array;";
	echo "window.numeracy_array[".$l."]=new Array;";
	echo "window.numeracy[".$l."]=new Array;";
	echo "window.citizenship_array[".$l."]=new Array;";
	echo "window.citizenship[".$l."]=new Array;";
	echo "window.risk_assessment_array[".$l."]=new Array;";
	echo "window.risk_assessment[".$l."]=new Array;";
	echo "window.activityIds[".$l."]=new Array;";
	echo "window.activityLps[".$l."]=new Array;";
	echo "window.time[".$l."]=new Array;";
	echo "window.activityNum[".$l."]=new Array;";
	echo "window.activityCount[".$l."]=new Array;";
	echo "window.strand[".$l."]=new Array;";
	echo "window.strand_array[".$l."]=new Array;";
	echo "window.teaching_point[".$l."]=new Array;";
	echo "window.teaching_point_array[".$l."]=new Array;";
	echo "window.differentiation[".$l."]=new Array;";
	echo "window.differentiation_array[".$l."]=new Array;";
	echo "window.progression[".$l."]=new Array;";
	echo "window.progression_array[".$l."]=new Array;";
	echo "window.progression_points[".$l."]=new Array;";
	echo "window.progression_points_array[".$l."]=new Array;";
	echo "window.analyses[".$l."]=new Array;";
	echo "window.analyses_array[".$l."]=new Array;";
	echo "window.analyses_points[".$l."]=new Array;";
	echo "window.analyses_points_array[".$l."]=new Array;";
}
function SetUpNewLesson($unit_id,$l,$theme_id,$level_id)
{
	include('mysqli_dbconnect.php');
	$lessons[$l]=mysqli_query($tp,"select id,set_lesson_id from lesson where uow_id=$unit_id and lesson_num=$l") or die("Error reported while executing the statement: <br />MySQL reported: ".mysqli_error());
	while(list ($my_lesson_id,$set_lesson_id)=mysqli_fetch_array($lessons[$l]))
		{
			if($set_lesson_id) $lesson_id=$set_lesson_id; else $lesson_id=$my_lesson_id;
			echo "window.lessonIds[".$l."]=".$lesson_id.";";
				
				if(!$theme_id)
					{   $themes[$l]=mysqli_query($tp,"select theme_id,theme.theme from lesson left join theme on theme_id=theme.id where lesson.id=$lesson_id") or die("Error reported while executing the statement: <br />MySQL reported: ".mysqli_error());
						while(list ($theme_id,$theme)=mysqli_fetch_array($themes[$l]))
					{
						echo "window.themeIds[".$l."]='".$theme_id."';";
						echo "window.themes[".$l."]='".$theme."';";
					}
					}
					else {
							echo "window.themeIds[".$l."]='".$theme_id."';";
					echo "window.themes[".$l."]='".$theme."';";
					}
				$sens[$l]=mysqli_query($tp,"select ta,sen from lesson where id=$lesson_id");
					if ($sens[$l])
					{
						(list($ta,$sen)=mysqli_fetch_array($sens));
						echo "window.ta[".$l."]='".$ta."';";
						echo "window.sen[".$l."]='".$sen."';";
					}
					echo "window.objectiveIds_array[".$l."]=new Array;";
				echo "window.objectiveIds[".$l."]=new Array;";
				echo "window.objectives[".$l."]=new Array;";
				echo "window.objectiveStrand[".$l."]=new Array;";
				if($level_id!=0.0){
            $objectives[$l]=mysqli_query($tp,"select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join objective_strand on lesson_objectives.objective_id=objective_strand.objective_id left join objective_topic on objective_topic.objective_id=lesson_objectives.objective_id where lesson.id=$lesson_id");}
			else{ $objectives[$l]=mysqli_query($tp,"select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join objective_strand on lesson_objectives.objective_id=objective_strand.objective_id left join objective_topic on objective_topic.objective_id=lesson_objectives.objective_id where lesson.id=$lesson_id UNION select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join topic_objectives on topic_objectives.objectives_id=lesson_objectives.objective_id where lesson.id=$lesson_id");}
				$o=1;
				$objective_array='';
				if ($objectives[$l])
				{
				while (list($objective_id,$objective,$strand_id)=mysqli_fetch_array($objectives[$l]))
					{
						if ($o==1) $objective_array=$objective_id;
						else $objective_array=$objective_array.",".$objective_id;
						if(!$strand_id) $strand_id=0;
                        /*			echo "objectiveIds[".$l."].splice(objectiveIds[".$l."].length,0,".$objective_id.");";
						echo "objectives[".$l."].splice(objectives[".$l."].length,0,'".addslashes($objective)."');";
						echo "objectiveStrand[".$l."].splice(objectiveStrand[".$l."].length,0,".$strand_id.");";*/
						echo "window.objectiveIds[".$l."].splice(".$objective_id.",0,".$objective_id.");";
						echo "window.objectives[".$l."].splice(".$objective_id.",0,'".addslashes($objective)."');";
						echo "window.objectiveStrand[".$l."].splice(".$objective_id.",0,".$strand_id.");";
						$o++;
					 }
				echo "window.objectiveIds_array[".$l."]='".$objective_array."';";
				}
				echo "window.keywords_array[".$l."]=new Array;";
				echo "window.keywords[".$l."]=new Array;";
				$keywords[$l]=mysqli_query($tp,"select keyword_id from lesson_keywords left join lesson on lesson.id=lesson_keywords.lesson_id where lesson.id=$lesson_id");
				$o=0;
				$keyword_array='';
				if ($keywords[$l])
				{
				while (list($keyword_id)=mysqli_fetch_array($keywords[$l]))
					{
						if ($o==0) $keyword_array=$keyword_id;
						else $keyword_array=$keyword_array.",".$keyword_id;
						echo "window.keywords[".$l."][".$keyword_id."]=".$keyword_id.";";
						$o++;
					}
				echo "window.keywords_array[".$l."]='".$keyword_array."';";
				}
				echo "window.ict_array[".$l."]=new Array;";
				echo "window.ict[".$l."]=new Array;";
				$ict[$l]=mysqli_query($tp,"select ict_id from lesson_ict left join lesson on lesson.id=lesson_ict.lesson_id where lesson.id=$lesson_id");
				$o=0;
				$ict_array='';
				if ($ict[$l])
				{
				while (list($ict_id)=mysqli_fetch_array($ict[$l]))
					{
						if ($o==0) $ict_array=$ict_id;
						else $ict_array=$ict_array.",".$ict_id;
						echo "window.ict[".$l."][".$ict_id."]=".$ict_id.";";
						$o++;
					}
				echo "window.ict_array[".$l."]='".$ict_array."';";
				}
				echo "window.numeracy_array[".$l."]=new Array;";
				echo "window.numeracy[".$l."]=new Array;";
				$numeracy[$l]=mysqli_query($tp,"select numeracy_id from lesson_numeracy left join lesson on lesson.id=lesson_numeracy.lesson_id where lesson.id=$lesson_id");
				$o=0;
				$numeracy_array='';
				if ($numeracy[$l])
				{
				while (list($numeracy_id)=mysqli_fetch_array($numeracy[$l]))
					{
						if ($o==0) $numeracy_array=$numeracy_id;
						else $numeracy_array=$numeracy_array.",".$numeracy_id;
						echo "window.numeracy[".$l."][".$numeracy_id."]=".$numeracy_id.";";
						$o++;
					}
				echo "window.numeracy_array[".$l."]='".$numeracy_array."';";
				}
				echo "window.citizenship_array[".$l."]=new Array;";
				echo "window.citizenship[".$l."]=new Array;";
				$citizenship[$l]=mysqli_query($tp,"select citizenship_id from lesson_citizenship left join lesson on lesson.id=lesson_citizenship.lesson_id where lesson.id=$lesson_id");
				$o=0;
				$citizenship_array='';
				if ($citizenship[$l])
				{
				while (list($citizenship_id)=mysqli_fetch_array($citizenship[$l]))
					{
						if ($o==0) $citizenship_array=$citizenship_id;
						else $citizenship_array=$citizenship_array.",".$citizenship_id;
						echo "window.citizenship[".$l."][".$citizenship_id."]=".$citizenship_id.";";
						$o++;
					}
				echo "window.citizenship_array[".$l."]='".$citizenship_array."';";
				}
				echo "window.risk_assessment_array[".$l."]=new Array;";
				echo "window.risk_assessment[".$l."]=new Array;";
				$risk_assessment[$l]=mysqli_query($tp,"select ra_id from lesson_risk_assessment left join lesson on lesson.id=lesson_risk_assessment.lesson_id where lesson.id=$lesson_id");
				$o=0;
				$risk_assessment_array='';
				if ($risk_assessment[$l])
				{
				while (list($risk_assessment_id)=mysqli_fetch_array($risk_assessment[$l]))
					{
						if ($o==0) $risk_assessment_array=$risk_assessment_id;
						else $risk_assessment_array=$risk_assessment_array.",".$risk_assessment_id;
						echo "window.risk_assessment[".$l."][".$risk_assessment_id."]=".$risk_assessment_id.";";
						$o++;
					}
				echo "window.risk_assessment_array[".$l."]='".$risk_assessment_array."';";
				}
				echo "window.activityIds[".$l."]=new Array;";
				echo "window.activityLps[".$l."]=new Array;";
				echo "window.time[".$l."]=new Array;";
				echo "window.activityNum[".$l."]=new Array;";
				echo "window.activityCount[".$l."]=new Array;";
				echo "window.strand[".$l."]=new Array;";
				echo "window.strand_array[".$l."]=new Array;";
				echo "window.teaching_point[".$l."]=new Array;";
				echo "window.teaching_point_array[".$l."]=new Array;";
				echo "window.differentiation[".$l."]=new Array;";
				echo "window.differentiation_array[".$l."]=new Array;";
				echo "window.progression[".$l."]=new Array;";
				echo "window.progression_array[".$l."]=new Array;";
				echo "window.progression_points[".$l."]=new Array;";
				echo "window.progression_points_array[".$l."]=new Array;";
				echo "window.analyses[".$l."]=new Array;";
				echo "window.analyses_array[".$l."]=new Array;";
				echo "window.analyses_points[".$l."]=new Array;";
				echo "window.analyses_points_array[".$l."]=new Array;";
				$activities[$l]=mysqli_query($tp,"select la_id,activity_id,time,activity_num,lesson_part.description from lesson_activities left join lesson on lesson.id=lesson_activities.lesson_id left join content_lesson_part on content_lesson_part.content_id = lesson_activities.activity_id left join lesson_part on lesson_part.id = content_lesson_part.lesson_part_id where lesson.id=$lesson_id  order by activity_num");
				$p=1;
				if ($activities[$l])
				{
				echo "window.activityCount[".$l."]=".mysqli_num_rows($activities[$l]).";";
					while (list($la_id,$activity_id,$time,$activity_num,$lesson_part)=mysqli_fetch_array($activities[$l]))
					{
						$o=$activity_id;
									echo "window.activityIds[".$l."][".$o."]=".$activity_id.";";
						echo "window.activityLps[".$l."][".$o."]='".$lesson_part."';";
						echo "window.time[".$l."][".$o."]='".$time."';";
			//			echo "activityNum[".$l."][".$activity_num."]='".$activity_id."';";
						echo "window.activityNum[".$l."][".$p."]=".$activity_id.";";
							echo "window.strand[".$l."][".$o."]=new Array;";
							echo "window.strand_array[".$l."][".$o."]=new Array;";
							$strands[$l]=mysqli_query($tp,"select strand_id from lesson_activity_strand left join lesson_activities on lesson_activities.la_id=lesson_activity_strand.la_id where lesson_activity_strand.la_id = $la_id");
							$s=0;
							$strand_array='';
							if ($strands[$l])
							{
								while (list($strand_id)=mysqli_fetch_array($strands[$l]))
								{
									if ($s==0) $strand_array=$strand_id;
									else $strand_array=$strand_array.",".$strand_id;
									echo "window.strand[".$l."][".$o."][".$strand_id."]=".$strand_id.";"; 
									$s++;
								}
							echo "window.strand_array[".$l."][".$o."]='".$strand_array."';";
							}
							echo "window.teaching_point[".$l."][".$o."]=new Array;";
							echo "window.teaching_point_array[".$l."][".$o."]=new Array;";
							$teaching_points[$l]=mysqli_query($tp,"select point_id from lesson_activity_point left join lesson_activities on lesson_activities.la_id=lesson_activity_point.la_id where lesson_activity_point.la_id = $la_id");
							$s=0;
							$teaching_point_array='';
							if ($teaching_points[$l])
							{
								while (list($teaching_point_id)=mysqli_fetch_array($teaching_points[$l]))
								{
									if ($s==0) $teaching_point_array=$teaching_point_id;
									else $teaching_point_array=$teaching_point_array.",".$teaching_point_id;
									echo "window.teaching_point[".$l."][".$o."][".$teaching_point_id."]=".$teaching_point_id.";"; 
									$s++;
								}
							echo "window.teaching_point_array[".$l."][".$o."]='".$teaching_point_array."';";
							}
							echo "window.differentiation[".$l."][".$o."]=new Array;";
							echo "window.differentiation_array[".$l."][".$o."]=new Array;";
							$differentiations[$l]=mysqli_query($tp,"select diff_id from lesson_activity_differentiation left join lesson_activities on lesson_activities.la_id=lesson_activity_differentiation.la_id where lesson_activity_differentiation.la_id = $la_id");
							$s=0;
							$differentiation_array='';
							if ($differentiations[$l])
							{
								while (list($differentiation_id)=mysqli_fetch_array($differentiations[$l]))
								{
									if ($s==0) $differentiation_array=$differentiation_id;
									else $differentiation_array=$differentiation_array.",".$differentiation_id;
									echo "window.differentiation[".$l."][".$o."][".$differentiation_id."]=".$differentiation_id.";"; 
									$s++;
								}
							echo "window.differentiation_array[".$l."][".$o."]='".$differentiation_array."';";
							}
							echo "window.progression[".$l."][".$o."]=new Array;";
							echo "window.progression_array[".$l."][".$o."]=new Array;";
							echo "window.progression_points[".$l."][".$o."]=new Array;";
							echo "window.progression_points_array[".$l."][".$o."]=new Array;";
							$progressions[$l]=mysqli_query($tp,"select la_pr_id,pr_id from lesson_activity_progression left join lesson_activities on lesson_activities.la_id=lesson_activity_progression.la_id where lesson_activity_progression.la_id = $la_id");
							$s=0;
							$progression_array='';
							if ($progressions[$l])
							{
								while (list($la_pr_id,$progression_id)=mysqli_fetch_array($progressions[$l]))
								{
									if ($s==0) $progression_array=$progression_id;
									else $progression_array=$progression_array.",".$progression_id;
									echo "window.progression[".$l."][".$o."][".$progression_id."]=".$progression_id.";";
										echo "window.progression_points[".$l."][".$o."][".$progression_id."]=new Array;"; 
										echo "window.progression_points_array[".$l."][".$o."][".$progression_id."]=new Array;"; 
										$prog_points[$l]=mysqli_query($tp,"select point_id from lesson_activity_progression_point left join lesson_activity_progression on lesson_activity_progression.la_pr_id=lesson_activity_progression_point.la_pr_id where lesson_activity_progression.la_id = $la_id and lesson_activity_progression.pr_id=$progression_id");
										$pp=0;
										$prog_point_array='';
										if ($prog_points[$l])
										{
											while (list($prog_point_id)=mysqli_fetch_array($prog_points[$l]))
											{
												if ($pp==0) $prog_point_array=$prog_point_id;
												else $prog_point_array=$prog_point_array.",".$prog_point_id;
												echo "window.progression_points[".$l."][".$o."][".$progression_id."][".$prog_point_id."]=".$prog_point_id.";";
												$pp++;
												}
											echo "window.progression_points_array[".$l."][".$o."][".$progression_id."]='".$prog_point_array."';";
										}
									$s++;
								}
							echo "window.progression_array[".$l."][".$o."]='".$progression_array."';";
							}
							echo "window.analyses[".$l."][".$o."]=new Array;";
							echo "window.analyses_array[".$l."][".$o."]=new Array;";
							echo "window.analyses_points[".$l."][".$o."]=new Array;";
							echo "window.analyses_points_array[".$l."][".$o."]=new Array;";
							$analysess[$l]=mysqli_query($tp,"select analyses_id from lesson_activity_analyses left join lesson_activities on lesson_activities.la_id=lesson_activity_analyses.la_id where lesson_activity_analyses.la_id = $la_id");
							$s=0;
							$analyses_array='';
							if ($analysess[$l])
							{
								while (list($analyses_id)=mysqli_fetch_array($analysess[$l]))
								{
									if ($s==0) $analyses_array=$analyses_id;
									else $analyses_array=$analyses_array.",".$analyses_id;
									echo "window.analyses[".$l."][".$o."][".$analyses_id."]=".$analyses_id.";"; 
									$s++;
										echo "window.analyses_points[".$l."][".$o."][".$analyses_id."]=new Array;"; 
										echo "window.analyses_points_array[".$l."][".$o."][".$analyses_id."]=new Array;"; 
			
										$anal_points[$l]=mysqli_query($tp,"select point_id from lesson_activity_analyses_point left join lesson_activity_analyses on lesson_activity_analyses.la_an_id=lesson_activity_analyses_point.la_an_id where lesson_activity_analyses.la_id = $la_id and lesson_activity_analyses.analyses_id=$analyses_id");
										$an=0;
										$anal_point_array='';
										if ($anal_points[$l])
										{
											while (list($anal_point_id)=mysqli_fetch_array($anal_points[$l]))
											{
												if ($an==0) $anal_point_array=$anal_point_id;
												else $anal_point_array=$anal_point_array.",".$anal_point_id;
												echo "window.analyses_points[".$l."][".$o."][".$analyses_id."][".$anal_point_id."]=".$anal_point_id.";";
												$an++;
												}
											echo "window.analyses_points_array[".$l."][".$o."][".$analyses_id."]='".$anal_point_array."';";
										}
								}
							echo "window.analyses_array[".$l."][".$o."]='".$analyses_array."';";
							}
						$p++;
					}
				}
	}
	//echo "window.lessonIds[".$l."]=".$my_lesson_id.";";
}
function SetUpSetLesson($lesson_id,$lesson_num,$level_id)
{
	include('mysqli_dbconnect.php');
	$l=$lesson_num;
	echo "window.lessonIds[".$l."]=".$lesson_id.";";
	$themes[$l]=mysqli_query($tp,"select theme_id,theme.theme from lesson left join theme on theme_id=theme.id where lesson.id=$lesson_id");
	while(list ($theme_id,$theme)=mysqli_fetch_array($themes[$l]))
		{ 
			echo "window.themeIds[".$l."]='".$theme_id."';";
			echo "window.themes[".$l."]='".$theme."';";
		}
	echo "window.objectiveIds_array[".$l."]=new Array;";
	echo "window.objectiveIds[".$l."]=new Array;";
	echo "window.objectives[".$l."]=new Array;";
	echo "window.objectiveStrand[".$l."]=new Array;";
	if($level_id!=0.0){
            $objectives[$l]=mysqli_query($tp,"select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join objective_strand on lesson_objectives.objective_id=objective_strand.objective_id left join objective_topic on objective_topic.objective_id=lesson_objectives.objective_id where lesson.id=$lesson_id");}
			else{ $objectives[$l]=mysqli_query($tp,"select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join objective_strand on lesson_objectives.objective_id=objective_strand.objective_id left join objective_topic on objective_topic.objective_id=lesson_objectives.objective_id where lesson.id=$lesson_id UNION select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join topic_objectives on topic_objectives.objectives_id=lesson_objectives.objective_id where lesson.id=$lesson_id");}
	$o=1;
	$objective_array='';
	if ($objectives[$l])
	{
	while (list($objective_id,$objective,$strand_id)=mysqli_fetch_array($objectives[$l]))
		{
			if ($o==1) $objective_array=$objective_id;
			else $objective_array=$objective_array.",".$objective_id;
			if(!$strand_id) $strand_id=0;
/*			echo "objectiveIds[".$l."].splice(objectiveIds[".$l."].length,0,".$objective_id.");";
			echo "objectives[".$l."].splice(objectives[".$l."].length,0,'".addslashes($objective)."');";
			echo "objectiveStrand[".$l."].splice(objectiveStrand[".$l."].length,0,".$strand_id.");";*/
			echo "window.objectiveIds[".$l."].splice(".$objective_id.",0,".$objective_id.");";
			echo "window.objectives[".$l."].splice(".$objective_id.",0,'".addslashes($objective)."');";
			echo "window.objectiveStrand[".$l."].splice(".$objective_id.",0,".$strand_id.");";
			$o++;
		}
	echo "window.objectiveIds_array[".$l."]='".$objective_array."';";
	}
	echo "window.keywords_array[".$l."]=new Array;";
	echo "window.keywords[".$l."]=new Array;";
	$keywords[$l]=mysqli_query($tp,"select keyword_id from lesson_keywords left join lesson on lesson.id=lesson_keywords.lesson_id where lesson.id=$lesson_id");
	$o=0;
	$keyword_array='';
	if ($keywords[$l])
	{
	while (list($keyword_id)=mysqli_fetch_array($keywords[$l]))
		{
			if ($o==0) $keyword_array=$keyword_id;
			else $keyword_array=$keyword_array.",".$keyword_id;
			echo "window.keywords[".$l."][".$keyword_id."]=".$keyword_id.";";
			$o++;
		}
	echo "window.keywords_array[".$l."]='".$keyword_array."';";
	}
	echo "window.ict_array[".$l."]=new Array;";
	echo "window.ict[".$l."]=new Array;";
	$ict[$l]=mysqli_query($tp,"select ict_id from lesson_ict left join lesson on lesson.id=lesson_ict.lesson_id where lesson.lesson.id=$lesson_id");
	$o=0;
	$ict_array='';
	if ($ict[$l])
	{
	while (list($ict_id)=mysqli_fetch_array($ict[$l]))
		{
			if ($o==0) $ict_array=$ict_id;
			else $ict_array=$ict_array.",".$ict_id;
			echo "window.ict[".$l."][".$ict_id."]=".$ict_id.";";
			$o++;
		}
	echo "window.ict_array[".$l."]='".$ict_array."';";
	}
	echo "window.numeracy_array[".$l."]=new Array;";
	echo "window.numeracy[".$l."]=new Array;";
	$numeracy[$l]=mysqli_query($tp,"select numeracy_id from lesson_numeracy left join lesson on lesson.id=lesson_numeracy.lesson_id where lesson.id=$lesson_id");
	$o=0;
	$numeracy_array='';
	if ($numeracy[$l])
	{
	while (list($numeracy_id)=mysqli_fetch_array($numeracy[$l]))
		{
			if ($o==0) $numeracy_array=$numeracy_id;
			else $numeracy_array=$numeracy_array.",".$numeracy_id;
			echo "window.numeracy[".$l."][".$numeracy_id."]=".$numeracy_id.";";
			$o++;
		}
	echo "window.numeracy_array[".$l."]='".$numeracy_array."';";
	}
	echo "window.citizenship_array[".$l."]=new Array;";
	echo "window.citizenship[".$l."]=new Array;";
	$citizenship[$l]=mysqli_query($tp,"select citizenship_id from lesson_citizenship left join lesson on lesson.id=lesson_citizenship.lesson_id where lesson.id=$lesson_id");
	$o=0;
	$citizenship_array='';
	if ($citizenship[$l])
	{
	while (list($citizenship_id)=mysqli_fetch_array($citizenship[$l]))
		{
			if ($o==0) $citizenship_array=$citizenship_id;
			else $citizenship_array=$citizenship_array.",".$citizenship_id;
			echo "window.citizenship[".$l."][".$citizenship_id."]=".$citizenship_id.";";
			$o++;
		}
	echo "window.citizenship_array[".$l."]='".$citizenship_array."';";
	}
	echo "window.risk_assessment_array[".$l."]=new Array;";
	echo "window.risk_assessment[".$l."]=new Array;";
	$risk_assessment[$l]=mysqli_query($tp,"select ra_id from lesson_risk_assessment left join lesson on lesson.id=lesson_risk_assessment.lesson_id where lesson.id=$lesson_id");
	$o=0;
	$risk_assessment_array='';
	if ($risk_assessment[$l])
	{
	while (list($risk_assessment_id)=mysqli_fetch_array($risk_assessment[$l]))
		{
			if ($o==0) $risk_assessment_array=$risk_assessment_id;
			else $risk_assessment_array=$risk_assessment_array.",".$risk_assessment_id;
			echo "window.risk_assessment[".$l."][".$risk_assessment_id."]=".$risk_assessment_id.";";
			$o++;
		}
	echo "window.risk_assessment_array[".$l."]='".$risk_assessment_array."';";
	}
	echo "window.activityIds[".$l."]=new Array;";
	echo "window.activityLps[".$l."]=new Array;";
	echo "window.time[".$l."]=new Array;";
	echo "window.activityNum[".$l."]=new Array;";
	echo "window.activityCount[".$l."]=new Array;";
	echo "window.strand[".$l."]=new Array;";
	echo "window.strand_array[".$l."]=new Array;";
	echo "window.teaching_point[".$l."]=new Array;";
	echo "window.teaching_point_array[".$l."]=new Array;";
	echo "window.differentiation[".$l."]=new Array;";
	echo "window.differentiation_array[".$l."]=new Array;";
	echo "window.progression[".$l."]=new Array;";
	echo "window.progression_array[".$l."]=new Array;";
	echo "window.progression_points[".$l."]=new Array;";
	echo "window.progression_points_array[".$l."]=new Array;";
	echo "window.analyses[".$l."]=new Array;";
	echo "window.analyses_array[".$l."]=new Array;";
	echo "window.analyses_points[".$l."]=new Array;";
	echo "window.analyses_points_array[".$l."]=new Array;";
	$activities[$l]=mysqli_query($tp,"select la_id,activity_id,time,activity_num,lesson_part.description from lesson_activities left join lesson on lesson.id=lesson_activities.lesson_id left join content_lesson_part on content_lesson_part.content_id = lesson_activities.activity_id left join lesson_part on lesson_part.id = content_lesson_part.lesson_part_id where lesson.id=$lesson_id order by activity_num");
	$p=1;
	if ($activities[$l])
	{
	echo "window.activityCount[".$l."]=".mysqli_num_rows($activities[$l]).";";
	while (list($la_id,$activity_id,$time,$activity_num,$lesson_part)=mysqli_fetch_array($activities[$l]))
		{
			$o=$activity_id;
			echo "window.activityIds[".$l."][".$o."]=".$activity_id.";";
			echo "window.activityLps[".$l."][".$o."]='".$lesson_part."';";
			echo "window.time[".$l."][".$o."]='".$time."';";
//			echo "activityNum[".$l."][".$activity_num."]='".$activity_id."';";
			echo "window.activityNum[".$l."][".$p."]=".$activity_id.";";
				echo "window.strand[".$l."][".$o."]=new Array;";
				echo "window.strand_array[".$l."][".$o."]=new Array;";
				$strands[$l]=mysqli_query($tp,"select strand_id from lesson_activity_strand left join lesson_activities on lesson_activities.la_id=lesson_activity_strand.la_id where lesson_activity_strand.la_id = $la_id");
				$s=0;
				$strand_array='';
				if ($strands[$l])
				{
					while (list($strand_id)=mysqli_fetch_array($strands[$l]))
					{
						if ($s==0) $strand_array=$strand_id;
						else $strand_array=$strand_array.",".$strand_id;
						echo "window.strand[".$l."][".$o."][".$strand_id."]=".$strand_id.";"; 
						$s++;
					}
				echo "window.strand_array[".$l."][".$o."]='".$strand_array."';";
				}
				echo "window.teaching_point[".$l."][".$o."]=new Array;";
				echo "window.teaching_point_array[".$l."][".$o."]=new Array;";
				$teaching_points[$l]=mysqli_query($tp,"select point_id from lesson_activity_point left join lesson_activities on lesson_activities.la_id=lesson_activity_point.la_id where lesson_activity_point.la_id = $la_id");
				$s=0;
				$teaching_point_array='';
				if ($teaching_points[$l])
				{
					while (list($teaching_point_id)=mysqli_fetch_array($teaching_points[$l]))
					{
						if ($s==0) $teaching_point_array=$teaching_point_id;
						else $teaching_point_array=$teaching_point_array.",".$teaching_point_id;
						echo "window.teaching_point[".$l."][".$o."][".$teaching_point_id."]=".$teaching_point_id.";"; 
						$s++;
					}
				echo "window.teaching_point_array[".$l."][".$o."]='".$teaching_point_array."';";
				}
				echo "window.differentiation[".$l."][".$o."]=new Array;";
				echo "window.differentiation_array[".$l."][".$o."]=new Array;";
				$differentiations[$l]=mysqli_query($tp,"select diff_id from lesson_activity_differentiation left join lesson_activities on lesson_activities.la_id=lesson_activity_differentiation.la_id where lesson_activity_differentiation.la_id = $la_id");
				$s=0;
				$differentiation_array='';
				if ($differentiations[$l])
				{
					while (list($differentiation_id)=mysqli_fetch_array($differentiations[$l]))
					{
						if ($s==0) $differentiation_array=$differentiation_id;
						else $differentiation_array=$differentiation_array.",".$differentiation_id;
						echo "window.differentiation[".$l."][".$o."][".$differentiation_id."]=".$differentiation_id.";"; 
						$s++;
					}
				echo "window.differentiation_array[".$l."][".$o."]='".$differentiation_array."';";
				}
				echo "window.progression[".$l."][".$o."]=new Array;";
				echo "window.progression_array[".$l."][".$o."]=new Array;";
				echo "window.progression_points[".$l."][".$o."]=new Array;";
				echo "window.progression_points_array[".$l."][".$o."]=new Array;";
				$progressions[$l]=mysqli_query($tp,"select la_pr_id,pr_id from lesson_activity_progression left join lesson_activities on lesson_activities.la_id=lesson_activity_progression.la_id where lesson_activity_progression.la_id = $la_id");
				$s=0;
				$progression_array='';
				if ($progressions[$l])
				{
					while (list($la_pr_id,$progression_id)=mysqli_fetch_array($progressions[$l]))
					{
						if ($s==0) $progression_array=$progression_id;
						else $progression_array=$progression_array.",".$progression_id;
						echo "window.progression[".$l."][".$o."][".$progression_id."]=".$progression_id.";";
							echo "window.progression_points[".$l."][".$o."][".$progression_id."]=new Array;"; 
							echo "window.progression_points_array[".$l."][".$o."][".$progression_id."]=new Array;"; 
							$prog_points[$l]=mysqli_query($tp,"select point_id from lesson_activity_progression_point left join lesson_activity_progression on lesson_activity_progression.la_pr_id=lesson_activity_progression_point.la_pr_id where lesson_activity_progression.la_id = $la_id and lesson_activity_progression.pr_id=$progression_id");
							$pp=0;
							$prog_point_array='';
							if ($prog_points[$l])
							{
								while (list($prog_point_id)=mysqli_fetch_array($prog_points[$l]))
								{
									if ($pp==0) $prog_point_array=$prog_point_id;
									else $prog_point_array=$prog_point_array.",".$prog_point_id;
									echo "window.progression_points[".$l."][".$o."][".$progression_id."][".$prog_point_id."]=".$prog_point_id.";";
									$pp++;
									}
								echo "window.progression_points_array[".$l."][".$o."][".$progression_id."]='".$prog_point_array."';";
							}
						$s++;
					}
				echo "window.progression_array[".$l."][".$o."]='".$progression_array."';";
				}
				echo "window.analyses[".$l."][".$o."]=new Array;";
				echo "window.analyses_array[".$l."][".$o."]=new Array;";
				echo "window.analyses_points[".$l."][".$o."]=new Array;";
				echo "window.analyses_points_array[".$l."][".$o."]=new Array;";
				$analysess[$l]=mysqli_query($tp,"select analyses_id from lesson_activity_analyses left join lesson_activities on lesson_activities.la_id=lesson_activity_analyses.la_id where lesson_activity_analyses.la_id = $la_id");
				$s=0;
				$analyses_array='';
				if ($analysess[$l])
				{
					while (list($analyses_id)=mysqli_fetch_array($analysess[$l]))
					{
						if ($s==0) $analyses_array=$analyses_id;
						else $analyses_array=$analyses_array.",".$analyses_id;
						echo "window.analyses[".$l."][".$o."][".$analyses_id."]=".$analyses_id.";"; 
						$s++;
							echo "window.analyses_points[".$l."][".$o."][".$analyses_id."]=new Array;"; 
							echo "window.analyses_points_array[".$l."][".$o."][".$analyses_id."]=new Array;"; 
							$anal_points[$l]=mysqli_query($tp,"select point_id from lesson_activity_analyses_point left join lesson_activity_analyses on lesson_activity_analyses.la_an_id=lesson_activity_analyses_point.la_an_id where lesson_activity_analyses.la_id = $la_id and lesson_activity_analyses.analyses_id=$analyses_id");
							$an=0;
							$anal_point_array='';
							if ($anal_points[$l])
							{
								while (list($anal_point_id)=mysqli_fetch_array($anal_points[$l]))
								{
									if ($an==0) $anal_point_array=$anal_point_id;
									else $anal_point_array=$anal_point_array.",".$anal_point_id;
									echo "window.analyses_points[".$l."][".$o."][".$analyses_id."][".$anal_point_id."]=".$anal_point_id.";";
									$an++;
									}
								echo "window.analyses_points_array[".$l."][".$o."][".$analyses_id."]='".$anal_point_array."';";
							}
					}
				echo "window.analyses_array[".$l."][".$o."]='".$analyses_array."';";
				}
			$p++;
		}
	}
} 
function SaveLesson($plan_type,$uow_id,$lesson_num,$what_next)
{
    include('mysqli_dbconnect.php');
	$getlessonnum=mysqli_query($tp,"select id from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
    if ($_POST['taout'][$lesson_num]) $ta=$_POST['taout'][$lesson_num]; else $ta='none';
    if ($_POST['senout'][$lesson_num]) $sen=$_POST['senout'][$lesson_num]; else $sen='none';
    $theme_id=$_POST['themeid'][$lesson_num];
    if($theme_id>0){
    if (mysqli_num_rows($getlessonnum)>0)
    {
        list ($lesson_id)=mysqli_fetch_array($getlessonnum);
        $updatelesson="update lesson set theme_id=$theme_id,ta='$ta',sen='$sen',set_lesson_id=NULL where id=$lesson_id";
        $updatelessonresult=mysqli_query($tp,$updatelesson) or die("Error reported while executing the statement: $updatelesson<br />MySQL reported: ".mysqli_error());
    }
    else
    {
    // instead of removing and reinserting I ought to create or update depending on
        if ($theme_id)
        {
            $createlesson="insert into lesson (uow_id,lesson_num,theme_id,ta,sen,set_lesson_id) values ($uow_id,$lesson_num,$theme_id,'$ta','$sen',NULL)";
            $createlessonresult=mysqli_query($tp,$createlesson) or die("Error reported while executing the statement: $createlesson<br />MySQL reported: ".mysqli_error());
            $lesson_id=mysqli_insert_id($tp);
        }
    }
    $removeoldobjectives=mysqli_query($tp,"delete from lesson_objectives where lesson_id=$lesson_id");
    if ($_POST['objectiveid'][$lesson_num])
    {
	foreach ($_POST['objectiveid'][$lesson_num] as $objective_id)
	{
		$createobjective="insert into lesson_objectives (lesson_id,objective_id) values ($lesson_id,$objective_id)";
		$createobjectiveresult=mysqli_query($tp,$createobjective) or die("Error reported while executing the statement: $createobjective<br />MySQL reported: ".mysqli_error());
	}
    }
    $removeoldict=mysqli_query($tp,"delete from lesson_ict where lesson_id=$lesson_id");
    if ($_POST['ict'][$lesson_num])
    {
	foreach ($_POST['ict'][$lesson_num] as $ict_id)
	{
		$createict="insert into lesson_ict (lesson_id,ict_id) values ($lesson_id,$ict_id)";
		$createictresult=mysqli_query($tp,$createict) or die("Error reported while executing the statement: $createict<br />MySQL reported: ".mysqli_error());
	}
    }
    $removeoldkeywords=mysqli_query($tp,"delete from lesson_keywords where lesson_id=$lesson_id");
    if ($_POST['keywords'][$lesson_num])
    {
	foreach ($_POST['keywords'][$lesson_num] as $keywords_id)
	{
		$createkeywords="insert into lesson_keywords (lesson_id,keyword_id) values ($lesson_id,$keywords_id)";
		$createkeywordsresult=mysqli_query($tp,$createkeywords) or die("Error reported while executing the statement: $createkeywords<br />MySQL reported: ".mysqli_error());
	}
    }
    $removeoldnumeracy=mysqli_query($tp,"delete from lesson_numeracy where lesson_id=$lesson_id");
    if ($_POST['numeracy'][$lesson_num])
    {
	foreach ($_POST['numeracy'][$lesson_num] as $numeracy_id)
	{
		$createnumeracy="insert into lesson_numeracy (lesson_id,numeracy_id) values ($lesson_id,$numeracy_id)";
		$createnumeracyresult=mysqli_query($tp,$createnumeracy) or die("Error reported while executing the statement: $createnumeracy<br />MySQL reported: ".mysqli_error());
	}
    }
    $removeoldrisk_assessment=mysqli_query($tp,"delete from lesson_risk_assessment where lesson_id=$lesson_id");
    if ($_POST['risk_assessment'][$lesson_num])
    {
	foreach ($_POST['risk_assessment'][$lesson_num] as $risk_assessment_id)
	{
		$createrisk_assessment="insert into lesson_risk_assessment (lesson_id,ra_id) values ($lesson_id,$risk_assessment_id)";
		$createrisk_assessmentresult=mysqli_query($tp,$createrisk_assessment) or die("Error reported while executing the statement: $createrisk_assessment<br />MySQL reported: ".mysqli_error());
	}
    }
    $removeoldcitizenship=mysqli_query($tp,"delete from lesson_citizenship where lesson_id=$lesson_id");
    if ($_POST['citizenship'][$lesson_num])
    {
	foreach ($_POST['citizenship'][$lesson_num] as $citizenship_id)
	{
		$createcitizenship="insert into lesson_citizenship (lesson_id,citizenship_id) values ($lesson_id,$citizenship_id)";
		$createcitizenshipresult=mysqli_query($tp,$createcitizenship) or die("Error reported while executing the statement: $createcitizenship<br />MySQL reported: ".mysqli_error());
	}
    }
    if ($_POST['activityid'][$lesson_num])
    {
	$removeoldactivity=mysqli_query($tp,"delete from lesson_activities where lesson_id=$lesson_id");
	foreach ($_POST['activityid'][$lesson_num] as $a => $activity_id)
	{
		if ($activity_id) {
		$time=$_POST['timeout'][$lesson_num][$a];
			foreach ($_POST['activitynum'][$lesson_num] as $n => $act_num) {
			if ($activity_id==$act_num)
				{$activity_num=$n;
				break; }
			}
		$createactivity="insert into lesson_activities (lesson_id,activity_id,time,activity_num) values ($lesson_id,$activity_id,'$time',$activity_num)";
		$createactivityresult=mysqli_query($tp,$createactivity) or die("Error reported while executing the statement: $createactivity<br />MySQL reported: ".mysqli_error());
		$la_id=mysqli_insert_id($tp);
		if ($_POST['teaching_point'][$lesson_num][$a])
		{
			foreach ($_POST['teaching_point'][$lesson_num][$a] as $teach_point_id)
			{
				$createteachpoint="insert into lesson_activity_point (la_id,point_id) values ($la_id,$teach_point_id)";
				$createteachpointresult=mysqli_query($tp,$createteachpoint) or die("Error reported while executing the statement: $createteachpoint<br />MySQL reported: ".mysqli_error());
			}
		}
		if ($_POST['strand'][$lesson_num][$a])
		{
			foreach ($_POST['strand'][$lesson_num][$a] as $strand_id)
			{
				$createstrand="insert into lesson_activity_strand (la_id,strand_id) values ($la_id,$strand_id)";
				$createstrandresult=mysqli_query($tp,$createstrand) or die("Error reported while executing the statement: $createstrand<br />MySQL reported: ".mysqli_error());
			}
		}
		if ($_POST['differentiation'][$lesson_num][$a])
		{
			foreach ($_POST['differentiation'][$lesson_num][$a] as $differentiation_id)
			{
				$createdifferentiation="insert into lesson_activity_differentiation (la_id,diff_id) values ($la_id,$differentiation_id)";
				$createdifferentiationresult=mysqli_query($tp,$createdifferentiation) or die("Error reported while executing the statement: $createdifferentiation<br />MySQL reported: ".mysqli_error());
			}
		}
		if ($_POST['analyses'][$lesson_num][$a])
		{
			foreach ($_POST['analyses'][$lesson_num][$a] as $analyses_id)
			{
				$createanalyses="insert into lesson_activity_analyses (la_id,analyses_id) values ($la_id,$analyses_id)";
				$createanalysesresult=mysqli_query($tp,$createanalyses) or die("Error reported while executing the statement: $createanalyses<br />MySQL reported: ".mysqli_error());
				$la_an_id=mysqli_insert_id($tp);
				if ($_POST['analyses_points'][$lesson_num][$a][$analyses_id])
				{
					foreach ($_POST['analyses_points'][$lesson_num][$a][$analyses_id] as $anal_point_id)
					{
					$createanalpoint="insert into lesson_activity_analyses_point (la_an_id,point_id) values ($la_an_id,$anal_point_id)";
					$createanalpointresult=mysqli_query($tp,$createanalpoint) or die("Error reported while executing the statement: $createanalpoint<br />MySQL reported: ".mysqli_error());
					}
				}
			}
		}
		if ($_POST['progression'][$lesson_num][$a])
		{
			foreach ($_POST['progression'][$lesson_num][$a] as $progression_id)
			{
				$createprogression="insert into lesson_activity_progression (la_id,pr_id) values ($la_id,$progression_id)";
				$createprogressionresult=mysqli_query($tp,$createprogression) or die("Error reported while executing the statement: $createprogression<br />MySQL reported: ".mysqli_error());
				$la_pr_id=mysqli_insert_id($tp);
				if ($_POST['progression_points'][$lesson_num][$a][$progression_id])
				{
					foreach ($_POST['progression_points'][$lesson_num][$a][$progression_id] as $prog_point_id)
					{
					$createprogpoint="insert into lesson_activity_progression_point (la_pr_id,point_id) values ($la_pr_id,$prog_point_id)";
					$createprogpointresult=mysqli_query($tp,$createprogpoint) or die("Error reported while executing the statement: $createprogpoint<br />MySQL reported: ".mysqli_error());
					}
				}
			}
		}
		}
        }
    }
    if (!$_POST['where_next']) echo "Your unit was last saved on: ".date('l jS \of F Y \a\t h:i:s A');
    else echo "&nbsp;";
    }
}
function GetHelp($help_topic)
{
    include('mysqli_dbconnect.php');
	$sql="select text from help where name='$help_topic'";
    $result=mysqli_query($tp,$sql);
    if(mysqli_num_rows($result)>0)
    {
    list($help)=mysqli_fetch_array($result);
    $help_array=unserialize(base64_decode($help));
    echo "<ul style='list-style-type:disc;margin-left:20px;line-height:20px;'>";
    foreach ($help_array as $help_point)
    {
        if($help_point){
        echo "<li style='padding-top:15px;'>".stripslashes($help_point)."</li>";
        }
    }
    echo "</ul>";}
else echo "no help for this topic";
}
function no_magic_quotes($query) {
        $data = explode("\\",$query);
        $cleaned = implode("",$data);
        return $cleaned;
}

function DeleteUnit($unit_id)
{
	include('mysqli_dbconnect.php');
	$my_id = $_SESSION['id'];
    $my_level = $_SESSION['userlevel'];
	$getdetails=mysqli_query($tp,"select id,num_lessons,teacher_id from unit_of_work where id = $unit_id");
	if($getdetails)
	{
		list($id,$num_lessons,$teacher_id)=mysqli_fetch_array($getdetails);
		if($teacher_id==$my_id){
				if($my_level==0){
					$response['result']=0;
					$response['detail']='Register';
					$response['more']='delete_lesson_limit';
					}
				else {
					if($deleteunit=mysqli_query($tp,"delete from unit_of_work where id = $unit_id"))
					{
						for($i=1;$i<=$num_lessons;$i++)
							{
								DeleteLesson($unit_id,$i,0);
							}
				
						$response['result']=1;
						$response['detail']="Unit Deleted";
						$response['more']='Press OK to return to the staffroom';
					}
					else {
						$response['result']=0;
						$response['detail']="could not delete, try again later";
						$response['more']='delete_lesson_limit';
					}
				}
				}
		 else {
				$response['result']=0;
				$response['detail']="Unit Cannot be Deleted";
				$response['more']="Something went wrong";
		 }
	}
	else {
		$response['result']=0;
		$response['detail']="Unit Cannot be Deleted";
		$response['more']="No Unit with that Name/ID";
	}
	print json_encode($response);
		
}
function DeleteLesson($uow_id,$lesson_num,$DeleteLesson)
{
    include('mysqli_dbconnect.php');
	$getlessonnum=mysqli_query($tp,"select id from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
    if (mysqli_num_rows($getlessonnum)>0)
    {
        list ($lesson_id)=mysqli_fetch_array($getlessonnum);
        $removeoldobjectives=mysqli_query($tp,"delete from lesson_objectives where lesson_id=$lesson_id");
        $removeoldict=mysqli_query($tp,"delete from lesson_ict where lesson_id=$lesson_id");
        $removeoldkeywords=mysqli_query($tp,"delete from lesson_keywords where lesson_id=$lesson_id");
        $removeoldnumeracy=mysqli_query($tp,"delete from lesson_numeracy where lesson_id=$lesson_id");
        $removeoldrisk_assessment=mysqli_query($tp,"delete from lesson_risk_assessment where lesson_id=$lesson_id");
        $removeoldcitizenship=mysqli_query($tp,"delete from lesson_citizenship where lesson_id=$lesson_id");
        $getlessonactivities=mysqli_query($tp,"select la_id from lesson_activities where lesson_id=$lesson_id");
        if (mysqli_num_rows($getlessonactivities)>0)
        {
            while (list ($la_id)=mysqli_fetch_array($getlessonactivities))
            {
                $deleteteachpoint=mysqli_query($tp,"delete from lesson_activity_point where la_id=$la_id");
                $deleteteachstrand=mysqli_query($tp,"delete from lesson_activity_strand where la_id=$la_id");
                $deletediffs=mysqli_query($tp,"delete from lesson_activity_differentiation where la_id=$la_id");
                $getprogressions=mysqli_query($tp,"select la_pr_id from lesson_activity_progression where la_id=$la_id");
                if(mysqli_num_rows($getprogressions)>0)
                {
                    while (list ($la_pr_id)=mysqli_fetch_array($getprogressions))
                    {
                        $deleteprogressionpoints=mysqli_query($tp,"delete from lesson_activity_progression_point where la_pr_id=$la_pr_id");
                    }
                }
                $deleteprogressions=mysqli_query($tp,"delete from lesson_activity_progression where la_id=$la_id");
                $getanals=mysqli_query($tp,"select la_pr_id from lesson_activity_analyses where la_id=$la_id");
                if(mysqli_num_rows($getanals)>0)
                {
                    while (list ($la_an_id)=mysqli_fetch_array($getanals))
                    {
                        $deleteanalpoints=mysqli_query($tp,"delete from lesson_activity_analyses_point where la_pr_id=$la_pr_id");
                    }
                }
                $deleteanals=mysqli_query($tp,"delete from lesson_activity_analyses where la_id=$la_id");
            }
            $removeoldactivity=mysqli_query($tp,"delete from lesson_activities where lesson_id=$lesson_id");
        }
        if($DeleteLesson) $removeoldlesson=mysqli_query($tp,"update lesson set theme_id=NULL, set_lesson_id=NULL,ta='none', sen='none' where lesson.id=$lesson_id");
		else  $removeoldlesson=mysqli_query($tp,"delete from lesson where lesson.id=$lesson_id");
    }
}
function year_to_level($year)
{
	switch($year) {
        case 1:
             return(1.00);
             break;	
		case 2:
             return(2.00);
             break;	
		case 3:
             return(2.50);
             break;	
		case 4:
             return(3.00);
             break;	
		case 5:
             return(3.50);
             break;	
		case 6:
             return(4.00);
             break;	
	}
}
function level_to_year($level)
{
	switch($level) {
        case 1.00:
             return(1);
             break;	
		case 2.00:
             return(2);
             break;	
		case 2.50:
             return(3);
             break;	
		case 3.00:
             return(4);
             break;	
		case 3.50:
             return(5);
             break;	
		case 4.00:
             return(6);
             break;	
		default:
			 return($level);	 
	}
}