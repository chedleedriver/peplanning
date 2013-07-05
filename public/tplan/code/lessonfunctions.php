<? // functions file to store PHP basic functions
// version 1
// created on 10/9/11
//
if(preg_match( "/MSIE/", $_SERVER['HTTP_USER_AGENT'])){
session_cache_limiter('private');  
}  
session_start();
include_once('config.php');
// Main decision area for what function to run
$_GET['GetThemes'] = (isset($_GET['GetThemes']) ? $_GET['GetThemes'] : 'default');
$_GET['GetSetLessons'] = (isset($_GET['GetSetLessons']) ? $_GET['GetSetLessons'] : 'default');
$_GET['GetObjectives'] = (isset($_GET['GetObjectives']) ? $_GET['GetObjectives'] : 'default');
$_GET['GetActivities'] = (isset($_GET['GetActivities']) ? $_GET['GetActivities'] : 'default');
$_GET['DrawPlanPage'] = (isset($_GET['DrawPlanPage']) ? $_GET['DrawPlanPage'] : 'default');
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
$_GET['GetHelp'] = (isset($_GET['GetHelp']) ? $_GET['GetHelp'] : 'default');
$_GET['lesson_id'] = (isset($_GET['lesson_id']) ? $_GET['lesson_id'] : 0);
if ($_GET['GetThemes']!='default') GetThemes($_GET['GetThemes'],$_GET['topic_id'],$_GET['level'],$_GET['description'],$_GET['num_lessons'],$_GET['plan_type']);
if ($_GET['GetSetLessons']!='default') GetSetLessons($_GET['GetSetLessons'],$_GET['topic_id'],$_GET['level'],$_GET['description'],$_GET['num_lessons'],$_GET['plan_type']);
if ($_GET['GetObjectives']!='default') GetObjectives($_GET['GetObjectives'],$_GET['lesson_num'],$_GET['topic_id'],$_GET['level'],$_GET['theme_id']);
if ($_GET['GetActivities']!='default') GetActivities($_GET['GetActivities'],$_GET['lesson_num'],$_GET['topic_id'],$_GET['level'],$_GET['theme_id'],$_GET['plan_type']);
if ($_GET['DrawPlanPage']!='default') DrawPlanPage($_GET['DrawPlanPage'],$_GET['theme_id'],$_GET['topic_id'],$_GET['level'],$_GET['uow_id'],$_GET['objectives'],$_GET['lesson_id'],$_GET['plan_type']);
if ($_GET['GetData']!='default') GetData($_GET['GetData'],$_GET['lesson_num'],$_GET['topic_id'],$_GET['data'],$_GET['plan_type']);
if ($_GET['SaveUnitofWork']!='default') SaveUnitofWork($_GET['topic_id'],$_GET['level_id'],$_GET['num_lessons'],$_GET['description']);
if ($_GET['GetActivity']!='default') GetActivity($_GET['GetActivity'],$_GET['lesson_num'],$_GET['content_id'],$_GET['strands'],$_GET['teaching_points'],$_GET['time'],$_GET['plan_type'],$_GET['topic_status'],$_GET['topic_id'],$_GET['theme_id'],$_GET['level']);
if ($_GET['GetDifferentiation']!='default') GetDifferentiation($_GET['GetDifferentiation'],$_GET['content_id'],$_GET['obj_num'],$_GET['differentiations']);
if ($_GET['GetProgression']!='default') GetProgression($_GET['GetProgression'],$_GET['content_id'],$_GET['obj_num'],$_GET['progressions'],$_GET['progression_points']);
if ($_GET['GetAnalysis']!='default') GetAnalysis($_GET['GetAnalysis'],$_GET['content_id'],$_GET['obj_num'],$_GET['topic_id'],$_GET['level'],$_GET['theme_id'],$_GET['analyses'],$_GET['analyses_points']);
if ($_GET['GetProgressionPoints']!='default') ShowProgressionPoints($_GET['progression_id']);
if ($_GET['PrintPlan']!='default') Print_a_Plan($_GET['PrintPlan'],$_GET['ajax']);
if ($_GET['GetUnit']!='default') GetUnit($_GET['GetUnit']);
if ($_GET['SetUpLessons']!='default') SetUpLessons($_GET['SetUpLessons'],$_GET['num_lessons'],$_GET['lesson_type'],$_GET['topic_id'],$_GET['level_id'],$_GET['original_type'],$_GET['lesson_num']);
if ($_GET['SaveLesson']!='default') SaveLesson($_GET['plan_type'],$_GET['uow_id'],$_GET['lesson_num'],$_GET['SaveLesson']);
if ($_GET['GetHelp']!='default') GetHelp($_GET['GetHelp']);
//functions start here
// get the data functions
function reload($destination) {
    $reload = 'Location: ' . $destination;
    header($reload);
}
function GetThemes($lesson_num,$topic_id,$level_id,$description,$num_lessons,$plan_type)
{
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

    $themes=mysql_query($sql) or die("Error reported while excetung the statement; $sql<br />MySQL reportedL  ".mysql_error());
	DrawThemes($themes,$lesson_num,$plan_type);
}
function GetObjectives($obj_num,$lesson_num,$topic_id,$level_id,$theme_id,$uow_id,$lesson_objectives)
{
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

    $objectives = mysql_query($sql) or die("Error reported while excecuting the statement; $sql<br />MySQL reportedL  ".mysql_error());
	DrawObjectives($obj_num,$lesson_num,$objectives,$uow_id,$lesson_objectives);
}
function GetActivities($obj_num,$lesson_num,$topic_id,$level_id,$theme_id,$plan_type)
{
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
	" AND lesson_part.description NOT IN ('Discussion','EI Discussion','KUFH Discussion','Core Task') ".
    " AND content_level.level_id= $level_id " .
    " $limitbylessonpartstring   " .
    " ORDER BY lesson_part.order";

    $activities=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	DrawActivities($obj_num,$lesson_num,$activities,$plan_type);
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
$sql="select name,description,time from content where content_id=$content_id";
	$content=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	list($content_name,$content_description,$time) = mysql_fetch_array($content);
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
	$check_differentiation=mysql_num_rows(mysql_query("select * from content_differentiation where content_id=$content_id"));
	$check_progression=mysql_num_rows(mysql_query("select * from content_progression where content_id=$content_id"));
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
                    " AND lesson_part.description IN ('Discussion','EI Discussion','KUFH Discussion') ".
                    " AND ( $levelspecifierstring ) ";
	$check_analysis=mysql_num_rows(mysql_query($analysis_sql));
	$equipment_query="select equipment.description from equipment left join content_equipment on content_equipment.equipment_id = equipment.id where content_equipment.content_id=$content_id";
	$equipment=mysql_query($equipment_query) or die("Error reported while executing the statement: $equipment_query<br />MySQL reported: ".mysql_error());
	if ($equipment) 
	{
		$e=0;
		while (list($equipment_description)=mysql_fetch_array($equipment))
		{ 	if ($e==0) $equipment_string=$equipment_description;
			else $equipment_string=$equipment_string.", ".$equipment_description;
			$e++;
		}
	}
	$sql="select point.id,point from point left join content_point on content_point.point_id=point.id where content_point.content_id=$content_id order by point_num";
	$point=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	if ($point)
		{
			$what='teaching_point';
			$point_list="<ul class='ui-widget'>";
			$arr_index=$obj_num-1;
			$i=1;
			$data_array=explode(',',$teaching_points);
			while (list($what_id,$what_name) = mysql_fetch_array($point))
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
	$strand=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	if ($strand)
		{
			$what='strand';
			$strand_list="<ul class='ui-widget'>";
			$arr_index=$obj_num-1;
			$i=1;
			$data_array=explode(',',$strands);
			while (list($what_id,$what_name,$description) = mysql_fetch_array($strand))
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
		$image_file=FILE_ROOT.DIAGRAM_PATH.$content_id.".gif";
		//$image_file="/u01/development/PEPlanning/trunk/tplan/diagrams/".$content_id.".gif";
		if (!file_exists($image_file)) $image_file="diagrams/no-image.png";
		else $image_file="diagrams/".$content_id.".gif";
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
	$topic=mysql_query("select name from topic where id=$topic_id");
        list($topic_name)=mysql_fetch_array($topic);
        $teacher_name=$topic_name."level".$level_id;
	$lessons=mysql_query("select lesson.id,theme.id,theme.theme,topic_theme.notes".
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
function GetUnit($unit_id)
{
		$username=$_SESSION['username'];
                $get_user_id=mysql_query("select id,userlevel from users where username='$username'");
                list($user_id,$userlevel)=mysql_fetch_array($get_user_id);
                if ($userlevel==9){
                    $got_unit=mysql_query("select topic_id,level_id,num_lessons,topic.name,topic.status,original_type from unit_of_work left join topic on topic.id=unit_of_work.topic_id where unit_of_work.id=$unit_id");
                }
                else {
                    $got_unit=mysql_query("select topic_id,level_id,num_lessons,topic.name,topic.status,original_type from unit_of_work left join topic on topic.id=unit_of_work.topic_id where unit_of_work.id=$unit_id and (unit_of_work.teacher_id=$user_id or public='y')");
                }
                if ($got_unit)
                {
                    if (mysql_num_rows($got_unit)!=0)
                    {
                        list($topic_id,$level_id,$num_lessons,$topic,$topic_status,$original_type)=mysql_fetch_array($got_unit);
                        echo ($topic_id."^".$level_id."^".$num_lessons."^".$topic."^".$topic_status."^".$original_type."^".$userlevel);
                    }
                    else
                    {
                    echo 'no';
                    }
                }
}
function GetLessons($unit_id)
{
	$getplans="select * from plan where uow_id = $unit_id";
	$gotplans=mysql_query($getplans) or die("Error reported while executing the statement: $getplanid<br />MySQL reported: ".mysql_error());
	for ($p = 1 ; $p < count(mysql_fetch_array($gotplans)) ; $p++)
	{
		list ($id, $uow_id, $theme_id, $description, $objectives, $content, $lesson_parts, $content_point, $differentiation, $progression, $content_strand, $content_images, $content_time, $content_equipment, $keywords, $ICT, $numeracy, $sen, $citizenship, $risk_assessment,$ta)=mysql_fetch_array($gotplans); 
		
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
	$sql="select id,description from ICT  left join topic_ICT on ICT.id=ICT_id where topic_id=$topic_id order by description";
	$ict=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('ict',$ict,$lesson_num,$topic_id,$icts,"Select any ICT opportunities you can incorporate into your lesson",$plan_type);
}
function GetCitizenship($lesson_num,$topic_id,$citizenships,$plan_type)
{
	$sql="select id,description from citizenship left join topic_citizenship on citizenship.id=citizenship_id where topic_id=$topic_id order by description";
	$citizenship=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('citizenship',$citizenship,$lesson_num,$topic_id,$citizenships,"Select appropriate citizenship links for your lesson",$plan_type);
}
function GetNumeracy($lesson_num,$topic_id,$numeracys,$plan_type)
{
	$sql="select id,description from numeracy left join topic_numeracy on numeracy.id=numeracy_id where topic_id=$topic_id order by description";
	$numeracy=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('numeracy',$numeracy,$lesson_num,$topic_id,$numeracys,"Select appropriate numeracy links for your lesson",$plan_type);
}
function GetRisk_Assessment($lesson_num,$topic_id,$risk_assessments,$plan_type)
{
	$sql="select id,description from risk_assessment left join topic_risk_assessment on risk_assessment.id=risk_assessment_id where topic_id=$topic_id order by description";
	$risk_assessment=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('risk_assessment',$risk_assessment,$lesson_num,$topic_id,$risk_assessments,"Select the appropriate safety checks to be carried out prior to your lesson",$plan_type);
}
function GetKeywords($lesson_num,$topic_id,$keywordss,$plan_type)
{
	$sql="select keywords.id,keyword from keywords left join topic_keywords on keywords.id = topic_keywords.keywords_id where topic_keywords.topic_id=$topic_id order by keyword";
	$keywords=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('keywords',$keywords,$lesson_num,$topic_id,$keywordss,"Select appropriate keywords for your lesson",$plan_type);
}
function GetDifferentiation($lesson_num,$content_id,$obj_num,$differentiations)
{
	$sql="select differentiation.id,differentiation,difficulty from differentiation left join content_differentiation on content_differentiation.differentiation_id = differentiation.id where content_differentiation.content_id = $content_id order by difficulty";
	$differentiation=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
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
			while (list($what_id,$what_name,$how_hard) = mysql_fetch_array($differentiation))
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
	$sql="select progression.id,progression from progression left join content_progression on content_progression.progression_id = progression.id where content_progression.content_id = $content_id";
	$progression=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
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
			while (list($what_id,$what_name) = mysql_fetch_array($progression))
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
						$points=mysql_query("select id,point from point left join  progression_point on point.id = progression_point.point_id  where progression_point.progression_id = $what_id order by point.id desc") or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
						$point_list[$progress_index]="<h3><a class='ui-widget' href=\"#\">Teaching Points</a></h3><br><ul class='ui-widget' >";
						while (list ($point_id,$point)=mysql_fetch_array($points))
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
	" AND lesson_part.description IN ('Discussion','EI Discussion','KUFH Discussion') ".
    " AND ( $levelspecifierstring ) " .
    " ORDER BY content_lesson_part.lesson_part_id";

    $activities=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
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
			while (list($content_id,$content_name,$content_description,$content_time,$level_id,$level_name,$lesson_part_id,$lesson_part_name) = mysql_fetch_array($activities))
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
					$points=mysql_query("select id,point from point left join  content_point on point.id = content_point.point_id  where content_point.content_id = $content_id") or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
						$point_list[$content_index]="<h3><a class='ui-widget' href=\"#\">Teaching Points</a></h3><br><ul class='ui-widget'>";
						while (list ($point_id,$point)=mysql_fetch_array($points))
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
	$sql="select point.id,point from point left join progression_point on progression_point.point_id=point.id  where progression_point.progression_id=$progression_id";
	$point=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	if ($point)
		{
			" <div class='ui-widget ui-widget-content'>"; 
			$what='teaching_point';
			$point_list="<ul>";
			$arr_index=$obj_num-1;
			$lesson_teaching_points=explode(';',$teaching_points);
			$i=1;
			$data_array=explode(',',$lesson_teaching_points[$arr_index]);
			while (list($what_id,$what_name) = mysql_fetch_array($point))
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
	$user_level=$_SESSION['userlevel'];
	$theme_ids=array();
	$theme_descriptions=array();
	$theme_index=0;
        if ($plan_type=="brandNewPlan") $draw_function="drawNewLessonLayout";
        if ($plan_type=="newPlan") $draw_function="drawLessonLayout";
	print "<table width=100% border='0' cellpadding='2' cellspacing='2' class='ui-widget'>".
		" <tr>". 
		" <td width=40% valign='top' class=\"ui-widget\">";
	print "<div id=\"listcol[".$lesson_num."]\" class=\"ui-widget\"><b>Select a different theme for each lesson in your Unit of Work:</b><br><br><ul class='ui-widget'>";
	while (list($theme_id,$theme,$theme_description,$level,$importance,$notes)=mysql_fetch_array($themes)) {
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
	while (list($lesson_id,$theme_id,$theme,$theme_notes)=mysql_fetch_array($lessons)) {
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
	while (list ($objective_id, $objective,$topic_id,$topic_name,$strand_id,$strand,$strand_description,$level_id,$level_name) = mysql_fetch_array($objectives)) 
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
	while (list ($content_id,$content_name,$content_description,$content_time,$level_id,$level_name,$lesson_part_id,$lesson_part_order,$lesson_part_name) = mysql_fetch_array($activities)) {
			if ($lesson_part_id!=$last_lesson_part_id) {
				if ($last_lesson_part_id!=0) print "</ul>";
				print "<h6><a class='ui-widget' href=\"#\">".$lesson_part_name."</a></h6><ul class='ui-widget ui-widget-content'>"; 
				$last_lesson_part_id=$lesson_part_id;}
//				if ($content_id!=$last_content_id){
					print "<li class='ui-widget' id=\"li_".$content_id."_".$obj_num."[".$lesson_num."]\" value=\"".$content_id."\"". 
					" onclick='changeActivityTabAndMoveOn(this,\"acttabs_".$lesson_num."\",\"".$lesson_part_name."\",\"activityid\",".$lesson_num.",".$obj_num.")'".
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
        $tab_index=$lesson_num-1;
	if ($lesson_id)
	{ 
		echo "<script type=\"text/javascript\">";
		SetUpSetLesson($lesson_id,$lesson_num);
		echo "</script>";
		$tas=mysql_query("select ta from lesson where id=$lesson_id");
		$sens=mysql_query("select SEN from lesson where id=$lesson_id");
                if ((!$lesson_objectives)||($lesson_objectives=='undefined'))
                {
                    $objectives=mysql_query("select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join topic_objectives on topic_objectives.objectives_id=lesson_objectives.objective_id where lesson.id=$lesson_id");
                    $o=1;
                    $objective_array='';
                    if ($objectives)
                        {
                            while (list($objective_id,$objective,$strand_id)=mysql_fetch_array($objectives))
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
		echo "<script type=\"text/javascript\">";
            	SetUpNewLesson($uow_id,$lesson_num);
		echo "</script>";
		$tas=mysql_query("select ta from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
		$sens=mysql_query("select SEN from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
            }
            else
             {
		echo "<script type=\"text/javascript\">";
            	SetUpNewLessonThemes($uow_id,$lesson_num);
		echo "</script>";
		$tas=mysql_query("select ta from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
		$sens=mysql_query("select SEN from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
            }
	}
	list($ta)=mysql_fetch_array($tas);
	list($sen)=mysql_fetch_array($sens);
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
	while (list ($topic_id,$topic,$topic_genre,$genre_id,$genre) = mysql_fetch_array($topics)) {
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
	while (list($what_id,$what_name) = mysql_fetch_array($things))
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
function SaveUnitofWork($topic_id,$level_id,$num_lessons,$description)
{
	$teacher_id=$_SESSION['id'];
	$savesql="insert into unit_of_work (description, topic_id, level_id, teacher_id, num_lessons) values ('$description',$topic_id,$level_id,$teacher_id,$num_lessons)";
	$saveresult=mysql_query($savesql) or die("Error reported while executing the statement: $savesql<br />MySQL reported: ".mysql_error());
	//echo mysql_insert_id();
}
function Create_a_Plan($uow_id, $theme_id, $description, $objectives_arr, $content_arr, $content_strand_arr, $content_point_arr, $content_differentiation_arr, $content_progression_arr, $content_progression_point_arr, $content_analyses_arr, $times, $keywords_arr, $ict_arr, $numeracy_arr, $ta, $sen, $citizenship_arr, $risk_assessment_arr, $i, $preview)
{
	$createplansql="insert into plan (uow_id, theme_id, description, objectives, content, teaching_points, differentiation, progression, progression_points, analyses, strands, times, literacy_keywords, ICT, numeracy, ta, sen, citizenship, risk_assessment) values ($uow_id, $theme_id, '$description', '$objectives_arr', '$content_arr', '$content_point_arr', '$content_differentiation_arr', '$content_progression_arr', '$content_progression_point_arr', '$content_analyses_arr', '$content_strand_arr',  '$times',  '$keywords_arr', '$ict_arr', '$numeracy_arr', '$ta', '$sen', '$citizenship_arr', '$risk_assessment_arr')";
	$createplanresult=mysql_query($createplansql) or die("Error reported while executing the statement: $createplansql<br />MySQL reported: ".mysql_error());
	if (isset($preview)) Print_a_Plan(mysql_insert_id());
}
// misc functions
function Print_a_Plan($lesson_id,$ajax)
{	
	$unit=mysql_query("select * from unit_of_work where id IN (select uow_id from lesson where id=$lesson_id)")  or die("Error reported while executing the statement: <br />MySQL reported: ".mysql_error());;
	list($unit_id,$unit_description,$topic_id,$level,$teacher_id,$num_lessons,$public,$date_created)=mysql_fetch_array($unit);
	$mysubject=list ($subject_name)=mysql_fetch_array(mysql_query("select name from topic where id=$topic_id"));
	$school=list($school_name)=mysql_fetch_array(mysql_query("select name from school"));
	$mydetails=mysql_query("select first_name, last_name, gender, year, class from users where id=$teacher_id");
	list($first_name,$last_name,$gender,$year,$class)=mysql_fetch_array($mydetails);
	$name=$first_name." ".$last_name;
	$assistance=list($ta,$sen)=mysql_fetch_array(mysql_query("select ta,sen from lesson where id=$lesson_id"));
	$themes=mysql_query("select lesson.theme_id,theme.theme, topic_theme.notes,evaluation.evaluation from lesson left join theme on lesson.theme_id=theme.id left join topic_theme on theme.id=topic_theme.theme_id left join topic_theme_evaluation on topic_theme_evaluation.theme_id=topic_theme.theme_id left join evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where lesson.id=$lesson_id and topic_theme.topic_id=$topic_id order by topic_theme.notes desc");
	list($theme_id,$theme,$teacher_notes,$evaluation)=mysql_fetch_array($themes);
        if (checkBase64Encoded($teacher_notes)) $teacher_notes_arr=unserialize(base64_decode($teacher_notes));
        else $teacher_notes_arr=unserialize($teacher_notes);
        if ($teacher_notes_arr==false) $teacher_notes_arr=explode('^',$teacher_notes);
	for ($tn=0 ; $tn < count($teacher_notes_arr) ; $tn++)
	{
		if ($teacher_notes_arr[$tn]) {
		$teacher_notes_string=$teacher_notes_string."  ".sp_utf2ascii(stripslashes($teacher_notes_arr[$tn]))."\n";
		}
	}
	//$evaluation_arr=explode('?',$evaluation);
	//$evaluation_string=$evaluation_arr[0]."\n\n";
	//$evaluation_sub_string_arr=explode('–',$evaluation_arr[1]);
        $evaluation_sub_string_arr=unserialize($evaluation);
        if ($evaluation_sub_string_arr==false) $evaluation_sub_string_arr=explode('?',$evaluation);
	for ($i=0;$i<count($evaluation_sub_string_arr);$i++)
	{ if ($evaluation_sub_string_arr[$i]) $evaluation_string=$evaluation_string.sp_utf2ascii($evaluation_sub_string_arr[$i])."\n\n";}

	$objectives=mysql_query("select objective_id,objective from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id where lesson.id=$lesson_id");
	if ($objectives)
	{
		$item_num=1;
		$objective_string='';
		while (list ($objective_id,$objective)=mysql_fetch_array($objectives))
		{
			$objective_string=$objective_string.$item_num.". ".$objective."\n";
			$item_num++;
		}
	}
	$keywords=mysql_query("select keyword_id,keyword from lesson_keywords left join keywords on keywords.id=lesson_keywords.keyword_id left join lesson on lesson.id=lesson_keywords.lesson_id where lesson.id=$lesson_id");
	if ($keywords)
	{
		$item_num=1;
		$keywords_string='';
		while (list ($keyword_id,$keyword)=mysql_fetch_array($keywords))
		{
			if ($item_num==1) $keywords_string=$keyword;
			else $keywords_string=$keywords_string.", ".$keyword;
			$item_num++;
		}
	}
	$icts=mysql_query("select ict_id,description from lesson_ict left join ICT on ICT.id=ict_id left join lesson on lesson.id=lesson_ict.lesson_id where lesson.id=$lesson_id");
	if ($icts)
	{
		$item_num=1;
		$ict_string='';
		while (list ($ict_id,$ict)=mysql_fetch_array($icts))
		{
			if ($item_num==1) $ict_string=$ict;
			else $ict_string=$ict_string.", ".$ict;
			$item_num++;
		}
	}
	$numeracys=mysql_query("select numeracy_id,description from lesson_numeracy left join numeracy on numeracy.id=numeracy_id left join lesson on lesson.id=lesson_numeracy.lesson_id where lesson.id=$lesson_id");
	if ($numeracys)
	{
		$item_num=1;
		$numeracy_string='';
		while (list ($numeracy_id,$numeracy)=mysql_fetch_array($numeracys))
		{
			if ($item_num==1) $numeracy_string=$numeracy;
			else $numeracy_string=$numeracy_string.", ".$numeracy;
			$item_num++;
		}
	}
	$citizenships=mysql_query("select citizenship_id,description from lesson_citizenship left join citizenship on citizenship.id=citizenship_id left join lesson on lesson.id=lesson_citizenship.lesson_id where lesson.id=$lesson_id");
	if ($citizenships)
	{
		$item_num=1;
		$citizenship_string='';
		while (list ($citizenship_id,$citizenship)=mysql_fetch_array($citizenships))
		{
			if ($item_num==1) $citizenship_string=$citizenship; 
			else $citizenship_string=$citizenship_string.", ".$citizenship;
			$item_num++;
		}
	}
	$risk_assessments=mysql_query("select ra_id,description from lesson_risk_assessment left join risk_assessment on risk_assessment.id=ra_id left join lesson on lesson.id=lesson_risk_assessment.lesson_id where lesson.id=$lesson_id");
	if ($risk_assessments)
	{
		$item_num=1;
		$risk_assessment_string='';
		while (list ($risk_assessment_id,$risk_assessment)=mysql_fetch_array($risk_assessments))
		{
			if ($item_num==1) $risk_assessment_string=$risk_assessment;
			else $risk_assessment_string=$risk_assessment_string.", ".$risk_assessment;
			$item_num++;
		}
	}
	$activities=mysql_query("select la_id,activity_id,lesson_activities.time,lesson_part.description,content.name,content.description,content.time from lesson_activities left join content on content.content_id=activity_id left join lesson on lesson.id=lesson_activities.lesson_id left join content_lesson_part on content_lesson_part.content_id = lesson_activities.activity_id left join lesson_part on lesson_part.id = content_lesson_part.lesson_part_id where lesson.id=$lesson_id order by activity_num");
	if ($activities)
	{
		$act_num=1;
		$image_num=1;
		$equipment_num=0;
		$equipment_ids=array();
		$num_acts=mysql_num_rows($activities);
		while (list($la_id,$activity_id,$time,$lesson_part,$content_name,$content_description,$content_time)=mysql_fetch_array($activities))
		{
			if (file_exists(FILE_ROOT.DIAGRAM_PATH.$activity_id.".gif")) $image_string[$act_num]=FILE_ROOT.DIAGRAM_PATH.$activity_id.".gif";
				if (file_exists(FILE_ROOT.DIAGRAM_PATH.$activity_id.".gif")) { $image[$act_num]=$image_num; $images[$image_num][title]=$content_name; $images[$image_num][image_name]= FILE_ROOT.DIAGRAM_PATH.$activity_id.".gif"; $image_num++;}
			if (!$time) $time=$content_time;
			if ($time) $time_string[$act_num]="\n".$time;
			if ($content_description)
			{
				$content_string[$act_num]=sp_utf2ascii($content_name);
//				$content_string[$act_num]=$content_name;
//				$content_line_arr[$act_num]=unserialize($content_description);
	  			if (checkBase64Encoded($content_description)) 
	  				{ 
	  					$content_line_arr[$act_num]=unserialize(base64_decode($content_description));
	  				}
	  			else 
	  				{
	  					$content_line_arr[$act_num]=unserialize($content_description);
	  				}
				for ($i = 0 ; $i < count($content_line_arr[$act_num]) ; $i++)
					{
					if ($content_line_arr[$act_num][$i])
//						$content_string[$act_num]=$content_string[$act_num]."\n".chr(149)."  ".stripslashes(utf2ascii($content_line_arr[$act_num][$i]));
						$content_string[$act_num]=$content_string[$act_num]."\n".chr(149)."  ".sp_utf2ascii(stripslashes($content_line_arr[$act_num][$i]));
					}
				//$content_string[$act_num]=utf2ascii($content_string[$act_num]);
				if ($image[$act_num]) $content_string[$act_num]=$content_string[$act_num]."\n\n"."See appendix ".$image[$act_num]." for diagram of this activity";
			}
			if ($lesson_part) $lesson_part_string[$act_num]=$lesson_part;
			$equipment_query="select equipment.id,equipment.description from equipment left join content_equipment on content_equipment.equipment_id = equipment.id where content_equipment.content_id=$activity_id";
			$equipment=mysql_query($equipment_query) or die("Error reported while executing the statement: $equipment_query<br />MySQL reported: ".mysql_error());
			if ($equipment) 
			{
			$e=0;
			while (list($equipment_id,$equipment_description)=mysql_fetch_array($equipment))
			{ 	
				if (!in_array($equipment_id,$equipment_ids))
					{
						if ($e==0) $equipment_string[$act_num]=$equipment_description;
						else $equipment_string[$act_num]=$equipment_string[$act_num].", ".$equipment_description;
						$e++;
						$equipment_ids[$equipment_num]=$equipment_id;
						$equipment_num++;
					}
			}
			}
				$strands=mysql_query("select strand_id,strand from lesson_activity_strand left join strand on strand.id=strand_id left join lesson_activities on lesson_activities.la_id=lesson_activity_strand.la_id where lesson_activity_strand.la_id = $la_id");
				if ($strands)
				{
					while (list($strand_id,$strand)=mysql_fetch_array($strands))
					{
						$strand_string[$act_num]=$strand_string[$act_num]."\n".$strand;
					}
				}
				$teaching_points=mysql_query("select point_id,point from lesson_activity_point left join point on point.id=point_id left join lesson_activities on lesson_activities.la_id=lesson_activity_point.la_id where lesson_activity_point.la_id = $la_id");
				if ($teaching_points)
				{
					while (list($point_id,$point)=mysql_fetch_array($teaching_points))
					{
						if ($point) {
						$teaching_points_string[$act_num]=$teaching_points_string[$act_num]."\n".chr(149)."  ".sp_utf2ascii($point);
						}
					}
					if ($teaching_points_string[$act_num]) $teaching_points_string[$act_num]="\nActivity Points\n".$teaching_points_string[$act_num];
				}
				$differentiations=mysql_query("select diff_id,differentiation,difficulty from lesson_activity_differentiation left join differentiation on diff_id=differentiation.id left join lesson_activities on lesson_activities.la_id=lesson_activity_differentiation.la_id where lesson_activity_differentiation.la_id = $la_id order by difficulty desc");
				if ($differentiations)
				{
					while (list($diff_id,$differentiation,$difficulty)=mysql_fetch_array($differentiations))
					{
						if ($difficulty=="H") $diff_string="harder"; else $diff_string="easier";
                                                if ($difficulty!=$old_difficulty) { $differentiations_string[$act_num]=$differentiations_string[$act_num]."\n"."\n\n To make activity ".$diff_string;$old_difficulty=$difficulty;}
                                                $differentiations_string[$act_num]=$differentiations_string[$act_num]."\n".chr(149)."  ".sp_utf2ascii($differentiation);
                                        }
				}
				$progressions=mysql_query("select la_pr_id,pr_id,progression from lesson_activity_progression left join progression on progression.id=pr_id left join lesson_activities on lesson_activities.la_id=lesson_activity_progression.la_id where lesson_activity_progression.la_id = $la_id");
				if ($progressions)
				{
					while (list($la_pr_id,$progression_id,$progression)=mysql_fetch_array($progressions))
					{
	  					if (checkBase64Encoded($progression)) 
	  						{ 
	  							$progressions_arr[$act_num]=unserialize(base64_decode($progression));
	  						}
	  					else 
	  						{
	  							$progressions_arr[$act_num]=unserialize($progression);
	  						}
//						$progressions_arr[$act_num]=unserialize($progression);
						for ($i = 0 ; $i < count($progressions_arr[$act_num]) ; $i++)
							{
							if ($progressions_arr[$act_num][$i])
								$progressions_string[$act_num]=$progressions_string[$act_num]."\n".chr(149)."  ".sp_utf2ascii($progressions_arr[$act_num][$i]);
							}
							$prog_points=mysql_query("select point_id,point from lesson_activity_progression_point left join lesson_activity_progression on lesson_activity_progression.la_pr_id=lesson_activity_progression_point.la_pr_id left join point on point.id=point_id where  lesson_activity_progression.la_id = $la_id and lesson_activity_progression.pr_id=$progression_id");
							if ($prog_points)
							{
								while (list($prog_point_id,$prog_point)=mysql_fetch_array($prog_points))
								{
									if ($prog_point) {
									$prog_points_string[$progression_id]=$prog_points_string[$progression_id]."\n".chr(149)." ".sp_utf2ascii($prog_point);
//									$prog_points_string[$act_num]=$prog_points_string[$act_num]."\n".chr(149)." ".$prog_point;
									}
								}
							}
					$prog_points_string[$act_num]=$prog_points_string[$act_num]."\n".$prog_points_string[$progression_id];
					}
				}
				$analysess=mysql_query("select analyses_id,content.name,content.description from lesson_activity_analyses left join content on content.content_id=analyses_id left join lesson_activities on lesson_activities.la_id=lesson_activity_analyses.la_id where lesson_activity_analyses.la_id = $la_id");
				if ($analysess)
				{
					while (list($analyses_id,$content_name,$content_description)=mysql_fetch_array($analysess))
					{
	  					if (checkBase64Encoded($progression)) 
	  						{ 
	  							$analyses_arr[$act_num]=unserialize(base64_decode($content_description));
	  						}
	  					else 
	  						{
	  							$analyses_arr[$act_num]=unserialize($content_description);
	  						}
						
						$analyses_string[$act_num]="\n\n".sp_utf2ascii($content_name)."\n";
						for ($i = 0 ; $i < count($analyses_arr[$act_num]) ; $i++)
							{
							if ($analyses_arr[$act_num][$i]) {
								$analyses_string[$act_num]=$analyses_string[$act_num]."\n".chr(149)."  ".sp_utf2ascii($analyses_arr[$act_num][$i]);
								}
							}
// points selected, now use all points							$anal_points=mysql_query("select point_id,point from lesson_activity_analyses_point left join point on point_id=point.id left join lesson_activity_analyses on lesson_activity_analyses.la_an_id=lesson_activity_analyses_point.la_an_id where lesson_activity_analyses.analyses_id=$analyses_id");
							$anal_points=mysql_query("select point_id,point from point left join content_point on content_point.point_id=point.id where content_point.content_id=$analyses_id");
							if ($anal_points)
							{
								while (list($anal_point_id,$anal_point)=mysql_fetch_array($anal_points))
								{
									$anal_points_string[$analyses_id]=$anal_points_string[$analyses_id]."\n".chr(149)."  ".sp_utf2ascii($anal_point);
//									$anal_points_string[$act_num]=$anal_points_string[$act_num]."\n".$anal_point;
								}
							}
					$anal_points_string[$act_num]=$anal_points_string[$act_num]."\n".$anal_points_string[$analyses_id];
					}
				}
		if ($equipment_string[$act_num]) 
			{
			if (!$equipment_list) $equipment_list=$equipment_string[$act_num];
			else $equipment_list=$equipment_list.",".$equipment_string[$act_num];
			}
		$act_num++;
		}
	}
	$today=date("d-m-Y");
	$pdf=new PDF();
        $pdf->SetCreator('PE Planning',true);
	$pdf->SetAutoPageBreak('on',15); 
	$pdf->SetTopMargin(5);
	$pdf->SetLeftMargin(5);
	$pdf->SetRightMargin(5);
	$pdf->Addpage('L','A4');
	$pdf->SetFillColor(183,204,153);
	$pdf->SetFont('Arial','B',11);
	$pdf->SetWidths(array(100,80,30,30,30));
	$pdf->colourRow(array('School','Topic','Year','Name','Level'),"y");
	$pdf->SetWidths(array(100,80,30,30,30));
	$pdf->SetFillColor(0);
	$pdf->SetFont('Arial','',10);
	$pdf->Row(array($school_name,$subject_name,$year,$name,$level),"y");
	$pdf->SetWidths(array(270));
	$pdf->SetFillColor(183,204,153);
	$pdf->SetFont('Arial','B',11);
	$pdf->colourRow(array('Theme'),"y");
	$pdf->SetWidths(array(270));
	$pdf->SetFillColor(0);
	$pdf->SetFont('Arial','',10);
	$pdf->Row(array($theme),"y");
	$pdf->SetWidths(array(120,75,75));
	$pdf->SetFillColor(183,204,153);
	$pdf->SetFont('Arial','B',11);
	$pdf->colourRow(array('Learning Objectives','Equipment','Teaching Assistance'),"y");
	$pdf->SetWidths(array(120,75,75));
	$pdf->SetFillColor(0);
	$pdf->SetFont('Arial','',10);
	$pdf->Row(array($objective_string,$equipment_list,$ta),"y");
	if ($keywords_string)
	{
		$pdf->SetFillColor(183,204,153);
		$pdf->SetFont('Arial','B',11);
		$pdf->SetWidths(array(270));
		$pdf->colourRow(array('Literacy Keywords'),"y");
		$pdf->SetFillColor(0);
		$pdf->SetFont('Arial','',10);
		$pdf->SetWidths(array(270));
		$pdf->Row(array($keywords_string),"y");
	}
	if ($citizenship_string)
	{
		$pdf->SetFillColor(183,204,153);
		$pdf->SetFont('Arial','B',11);
		$pdf->SetWidths(array(270));
		$pdf->colourRow(array('Citizenship'),"y");
		$pdf->SetFillColor(0);
		$pdf->SetFont('Arial','',10);
		$pdf->SetWidths(array(270));
		$pdf->Row(array($citizenship_string),"y");
	}
	if ($numeracy_string)
	{
		$pdf->SetFillColor(183,204,153);
		$pdf->SetFont('Arial','B',11);
		$pdf->SetWidths(array(270));
		$pdf->colourRow(array('Numeracy'),"y");
		$pdf->SetFillColor(0);
		$pdf->SetFont('Arial','',10);
		$pdf->SetWidths(array(270));
		$pdf->Row(array($numeracy_string),"y");
	}
	if ($ict_string)
	{
		$pdf->SetFillColor(183,204,153);
		$pdf->SetFont('Arial','B',11);
		$pdf->SetWidths(array(270));
		$pdf->colourRow(array('ICT'),"y");
		$pdf->SetFillColor(0);
		$pdf->SetFont('Arial','',10);
		$pdf->SetWidths(array(270));
		$pdf->Row(array($ict_string),"y");
	}
	if ($sen)
	{
		$pdf->SetFillColor(183,204,153);
		$pdf->SetFont('Arial','B',11);
		$pdf->SetWidths(array(270));
		$pdf->colourRow(array('Special Educational Needs'),"y");
		$pdf->SetFillColor(0);
		$pdf->SetFont('Arial','',10);
		$pdf->SetWidths(array(270));
		$pdf->Row(array($sen),"y");
	}
	if ($risk_assessment_string)
	{
		$pdf->SetFillColor(183,204,153);
		$pdf->SetFont('Arial','B',11);
		$pdf->SetWidths(array(270));
		$pdf->colourRow(array('Risk Assessment'),"y");
		$pdf->SetFillColor(0);
		$pdf->SetFont('Arial','',10);
		$pdf->SetWidths(array(270));
		$pdf->Row(array($risk_assessment_string),"y");
	}
	$pdf->SetFillColor(183,204,153);
	$pdf->SetFont('Arial','B',11);
	$pdf->SetWidths(array(270));
	$pdf->colourRow(array('Teacher Notes'),"y");
	$pdf->SetFillColor(0);
	$pdf->SetFont('Arial','',10);
	$pdf->SetWidths(array(270));
	$pdf->Row(array($teacher_notes_string),"y");
	$pdf->SetFillColor(183,204,153);
	$pdf->SetFont('Arial','B',10);
//	$pdf->SetWidths(array(30,70,30,20,15,35,35,35));
//	$pdf->Row(array('Lesson Part','Content','Teaching Points','Strand','Time','Differentiation','Progression','Analysis'),"y");
//	$pdf->SetFillColor(0);
//	$pdf->SetFont('Arial','',10);
//	for ($r = 1 ; $r <= $num_acts ; $r++) {
//			$pdf->SetWidths(array(30,70,30,20,15,35,35,35));
//			$pdf->Row(array($lesson_part_string[$r],$content_string[$r],$teaching_points_string[$r],$strand_string[$r],$time_string[$r],$differentiations_string[$r],$progressions_string[$r],$analyses_string[$r]),"y");
//	}
	$pdf->Addpage('L','A4');
	$pdf->SetWidths(array(30,147,70,20,18));	
	$pdf->colourRow(array('Lesson Part','Content','Teaching Points','Strand','Duration'),"y");
	$pdf->SetFillColor(0);
	$pdf->SetFont('Arial','',10);
	$where_y=$pdf->GetY();
	for ($r = 1 ; $r <= $num_acts ; $r++) {
			$pdf->SetWidths(array(30,147,70,20,18));
			if ($differentiations_string[$r]) $content_string[$r]=$content_string[$r]."\n\n Activity Differentiation".$differentiations_string[$r];
			if ($progressions_string[$r]) $content_string[$r]=$content_string[$r]."\n\n  Activity Progression".$progressions_string[$r];
			if ($analyses_string[$r]) $content_string[$r]=$content_string[$r]."\n\n Activity Analysis".$analyses_string[$r];
			if ($prog_points_string[$r]) $prog_points_string[$r]="\n\nProgression Points".$prog_points_string[$r];
			if ($anal_points_string[$r]) $anal_points_string[$r]="\n\nAnalysis Points".$anal_points_string[$r];
			$teaching_points_string[$r]=$teaching_points_string[$r].$prog_points_string[$r].$anal_points_string[$r];
			$pdf->Row(array($lesson_part_string[$r],$content_string[$r],$teaching_points_string[$r],$strand_string[$r],$time_string[$r]),"y");
//			if ($act_y) $start_y=$act_y;
//			$pdf->SetXY(10,$start_y);
//			$pdf->Multicell(40,5,$lesson_part_string[$r],1);
//			$pdf->SetXY(50,$start_y);
//			$pdf->Multicell(80,5,$content_string[$r],1);
//			$diff_y=$pdf->GetY();
//			$pdf->SetXY(50,$diff_y);
//			if ($differentiations_string[$r]) $pdf->Multicell(80,5,$differentiations_string[$r],1);
//			$prog_y=$pdf->GetY();
//			$pdf->SetXY(50,$prog_y);
//			if ($progressions_string[$r]) $pdf->Multicell(80,5,$progressions_string[$r],1);
//			$anal_y=$pdf->GetY();
//			$pdf->SetXY(50,$anal_y);
//			if ($analyses_string[$r]) $pdf->Multicell(80,5,$analyses_string[$r],1);
//			$act_y=$pdf->GetY();
//			$where_x=$pdf->GetX();
//			$where_y=$pdf->GetY();
//			$pdf->SetXY(130,$start_y);
//			$pdf->Multicell(40,5,$teaching_points_string[$r],1);
//			$pdf->SetXY(130,$prog_y);
//			$pdf->Multicell(40,5,$prog_points_string[$r],1);
//			$pdf->SetXY(130,$anal_y);
//			$pdf->Multicell(40,5,$anal_points_string[$r],1);
//			$pdf->SetXY(170,$start_y);
//			$pdf->Multicell(20,5,$strand_string[$r],1);
//			$pdf->SetXY(190,$start_y);
//			$pdf->Multicell(30,5,$time_string[$r],1);
	}
	$pdf->Ln();
	$pdf->SetFillColor(183,204,153);
	$pdf->SetFont('Arial','B',11);
	$pdf->SetWidths(array(285));
	$pdf->colourRow(array('Evaluation'),"y");
	$pdf->SetFillColor(0);
	$pdf->SetFont('Arial','',10);
	$pdf->SetWidths(array(285));
	$pdf->Row(array($evaluation_string),"y");
	$pdf->SetFont('Arial','I',10);
	if (is_array($images))
	{	
		for ($i=1;$i<=count($images);$i++)
		{
			if (($i==1) OR ($i==5) OR ($i==9) OR ($i==13)) { $pdf->Addpage('L'); }
			$image_title="Appendix ".$i." - ".$images[$i][title];
			if (($i==1) OR ($i==5) OR ($i==9) OR ($i==13)) {
			$pdf->Cell(150,10,$image_title);
			$pdf->Image($images[$i][image_name],5,20,135,70,'gif'); }
			if (($i==2) OR ($i==6) OR ($i==10) OR ($i==14)) {
			$pdf->Cell(150,10,$image_title);
			$pdf->Image($images[$i][image_name],150,20,130,70,'gif'); }
			if (($i==3) OR ($i==7) OR ($i==11) OR ($i==15)) {
			$pdf->SetY(105);
			$pdf->Cell(150,10,$image_title);
			$pdf->Image($images[$i][image_name],5,120,130,70,'gif'); }
			if (($i==4) OR ($i==8) OR ($i==12) OR ($i==16)) {
			$pdf->SetXY(155,105);
			$pdf->Cell(150,10,$image_title);
			$pdf->Image($images[$i][image_name],150,120,130,70,'gif'); }
			
		}	
	}
	$file=basename(tempnam('/tmp','tmp'));
	rename('/tmp/'.$file,FILE_ROOT.'tmp/'.$file.'.pdf');
	$file.='.pdf';
	$sysfile=FILE_ROOT.'tmp/'.$file;
	$outfile=DOC_ROOT.'tmp/'.$file;
	$pdf->Output($sysfile);
	if ($ajax=='y') echo $outfile;
	else echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\"><html xmlns=\"http://www.w3.org/1999/xhtml\"><head><meta http-equiv='Content-Type' content='text/html; charset=UTF-8' /> <SCRIPT>var url = '".$outfile."';var height = (600);var options = 'scrollbars,0,location=yes,resizable,width=900, height=700';window.open(url,'SearchWindow',options);</SCRIPT></head></html>";
	CleanFiles(FILE_ROOT."tmp/");
//	echo("<meta http-equiv=\"Refresh\" content=\"0;url=../welcome.php\">");
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
//        $evaluations=mysql_query("select lesson.theme_id,theme.theme, topic_theme.notes,evaluation.evaluation from lesson left join theme on lesson.theme_id=theme.id left join topic_theme on theme.id=topic_theme.theme_id left join topic_theme_evaluation on topic_theme_evaluation.theme_id=topic_theme.theme_id left join evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where lesson.id=$lesson_id and topic_theme.topic_id=$topic_id and topic_theme_evaluation.level=$level_id and evaluation.evaluation is not NULL order by topic_theme.notes desc");
        $evaluations=mysql_query("select evaluation.evaluation from evaluation left join topic_theme_evaluation on topic_theme_evaluation.evaluation_id=evaluation.id where topic_theme_evaluation.topic_id=$topic_id and topic_theme_evaluation.level=$level_id and topic_theme_evaluation.theme_id=$theme_id and evaluation.evaluation is not NULL");
//        $evaluations=mysql_query("select evaluation.evaluation from lesson left join theme on lesson.theme_id=theme.id left join topic_theme on theme.id=topic_theme.theme_id left join topic_theme_evaluation on topic_theme_evaluation.theme_id=topic_theme.theme_id left join evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where topic_theme.topic_id=$topic_id and topic_theme_evaluation.level=$level_id and evaluation.evaluation is not NULL order by evaluation.evaluation desc");
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
function SetUpLessons($unit_id,$num_lessons,$lesson_type,$topic_id,$level_id,$original_type,$lesson_num)
{
	if ($lesson_type=="newPlan")
	{
			for ($i=1;$i<=$num_lessons;$i++)
			{
				SetUpNewLesson($unit_id,$i);
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
                $get_plans=list($set_plan_id)=mysql_fetch_array(mysql_query("select set_plan_id from set_plans where topic_id=$topic_id and level=$level_id and num_lessons=$num_lessons"));
			if (!$set_plan_id) echo "whoops!!";
			else 
				{
					$get_lessons=mysql_query("select lesson_id,lesson_num from set_plan_lessons where set_plan_id=$set_plan_id order by lesson_num"); 
					while (list($lesson_id,$lesson_num)=mysql_fetch_array($get_lessons))
						{
							SetUpSetLesson($lesson_id,$lesson_num);
						}
				}
            }
        }
}
function SetUpNewLessonThemesOriginal($unit_id,$l)
{
	$lessons=mysql_query("select id from lesson where uow_id=$unit_id and lesson_num=$l") or die("Error reported while executing the statement: <br />MySQL reported: ".mysql_error());
	while(list ($lesson_id)=mysql_fetch_array($lessons))
		{
			echo "lessonIds[".$l."]=".$lesson_id.";";
		}
	$themes=mysql_query("select theme_id,theme.theme from lesson left join theme on theme_id=theme.id where uow_id=$unit_id and lesson.lesson_num=$l") or die("Error reported while executing the statement: <br />MySQL reported: ".mysql_error());
	while(list ($theme_id,$theme)=mysql_fetch_array($themes))
		{
			echo "themeIds[".$l."]=".$theme_id.";";
			echo "themes[".$l."]='".$theme."';";
		}
	$sens=mysql_query("select ta,sen from lesson where id=$lesson_id");
        if ($sens)
        {
            (list($ta,$sen)=mysql_fetch_array($sens));
            echo "ta[".$l."]=".$ta.";";
            echo "sen[".$l."]=".$sen.";";
        }
        echo "objectiveIds_array[".$l."]=new Array;";
	echo "objectiveIds[".$l."]=new Array;";
	echo "objectives[".$l."]=new Array;";
	echo "objectiveStrand[".$l."]=new Array;";
	$objectives=mysql_query("select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join topic_objectives on topic_objectives.objectives_id=lesson_objectives.objective_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l");
	$o=1;
	$objective_array='';
	if ($objectives)
	{
	while (list($objective_id,$objective,$strand_id)=mysql_fetch_array($objectives))
		{
			if ($o==1) $objective_array=$objective_id;
			else $objective_array=$objective_array.",".$objective_id;
/*			echo "objectiveIds[".$l."].splice(objectiveIds[".$l."].length,0,".$objective_id.");";
			echo "objectives[".$l."].splice(objectives[".$l."].length,0,'".addslashes($objective)."');";
			echo "objectiveStrand[".$l."].splice(objectiveStrand[".$l."].length,0,".$strand_id.");";*/
			echo "objectiveIds[".$l."].splice(".$objective_id.",0,".$objective_id.");";
			echo "objectives[".$l."].splice(".$objective_id.",0,'".addslashes($objective)."');";
			echo "objectiveStrand[".$l."].splice(".$objective_id.",0,".$strand_id.");";
			$o++;
		}
	echo "objectiveIds_array[".$l."]='".$objective_array."';";
	}
	echo "keywords_array[".$l."]=new Array;";
	echo "keywords[".$l."]=new Array;";
	$keywords=mysql_query("select keyword_id from lesson_keywords left join lesson on lesson.id=lesson_keywords.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l");
	$o=0;
	$keyword_array='';
	if ($keywords)
	{
	while (list($keyword_id)=mysql_fetch_array($keywords))
		{
			if ($o==0) $keyword_array=$keyword_id;
			else $keyword_array=$keyword_array.",".$keyword_id;
			echo "keywords[".$l."][".$keyword_id."]=".$keyword_id.";";
			$o++;
		}
	echo "keywords_array[".$l."]='".$keyword_array."';";
	}
	echo "ict_array[".$l."]=new Array;";
	echo "ict[".$l."]=new Array;";
	$ict=mysql_query("select ict_id from lesson_ict left join lesson on lesson.id=lesson_ict.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l");
	$o=0;
	$ict_array='';
	if ($ict)
	{
	while (list($ict_id)=mysql_fetch_array($ict))
		{
			if ($o==0) $ict_array=$ict_id;
			else $ict_array=$ict_array.",".$ict_id;
			echo "ict[".$l."][".$ict_id."]=".$ict_id.";";
			$o++;
		}
	echo "ict_array[".$l."]='".$ict_array."';";
	}
	echo "numeracy_array[".$l."]=new Array;";
	echo "numeracy[".$l."]=new Array;";
	$numeracy=mysql_query("select numeracy_id from lesson_numeracy left join lesson on lesson.id=lesson_numeracy.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l");
	$o=0;
	$numeracy_array='';
	if ($numeracy)
	{
	while (list($numeracy_id)=mysql_fetch_array($numeracy))
		{
			if ($o==0) $numeracy_array=$numeracy_id;
			else $numeracy_array=$numeracy_array.",".$numeracy_id;
			echo "numeracy[".$l."][".$numeracy_id."]=".$numeracy_id.";";
			$o++;
		}
	echo "numeracy_array[".$l."]='".$numeracy_array."';";
	}
	echo "citizenship_array[".$l."]=new Array;";
	echo "citizenship[".$l."]=new Array;";
	$citizenship=mysql_query("select citizenship_id from lesson_citizenship left join lesson on lesson.id=lesson_citizenship.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l");
	$o=0;
	$citizenship_array='';
	if ($citizenship)
	{
	while (list($citizenship_id)=mysql_fetch_array($citizenship))
		{
			if ($o==0) $citizenship_array=$citizenship_id;
			else $citizenship_array=$citizenship_array.",".$citizenship_id;
			echo "citizenship[".$l."][".$citizenship_id."]=".$citizenship_id.";";
			$o++;
		}
	echo "citizenship_array[".$l."]='".$citizenship_array."';";
	}
	echo "risk_assessment_array[".$l."]=new Array;";
	echo "risk_assessment[".$l."]=new Array;";
	$risk_assessment=mysql_query("select ra_id from lesson_risk_assessment left join lesson on lesson.id=lesson_risk_assessment.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l");
	$o=0;
	$risk_assessment_array='';
	if ($risk_assessment)
	{
	while (list($risk_assessment_id)=mysql_fetch_array($risk_assessment))
		{
			if ($o==0) $risk_assessment_array=$risk_assessment_id;
			else $risk_assessment_array=$risk_assessment_array.",".$risk_assessment_id;
			echo "risk_assessment[".$l."][".$risk_assessment_id."]=".$risk_assessment_id.";";
			$o++;
		}
	echo "risk_assessment_array[".$l."]='".$risk_assessment_array."';";
	}
}
function SetUpNewLessonThemes($unit_id,$l)
{
        echo "objectiveIds_array[".$l."]=new Array;";
	echo "objectiveIds[".$l."]=new Array;";
	echo "objectives[".$l."]=new Array;";
	echo "objectiveStrand[".$l."]=new Array;";
	echo "keywords_array[".$l."]=new Array;";
	echo "keywords[".$l."]=new Array;";
	echo "ict_array[".$l."]=new Array;";
	echo "ict[".$l."]=new Array;";
	echo "numeracy_array[".$l."]=new Array;";
	echo "numeracy[".$l."]=new Array;";
	echo "citizenship_array[".$l."]=new Array;";
	echo "citizenship[".$l."]=new Array;";
	echo "risk_assessment_array[".$l."]=new Array;";
	echo "risk_assessment[".$l."]=new Array;";
	echo "activityIds[".$l."]=new Array;";
	echo "activityLps[".$l."]=new Array;";
	echo "time[".$l."]=new Array;";
	echo "activityNum[".$l."]=new Array;";
	echo "activityCount[".$l."]=new Array;";
	echo "strand[".$l."]=new Array;";
	echo "strand_array[".$l."]=new Array;";
	echo "teaching_point[".$l."]=new Array;";
	echo "teaching_point_array[".$l."]=new Array;";
	echo "differentiation[".$l."]=new Array;";
	echo "differentiation_array[".$l."]=new Array;";
	echo "progression[".$l."]=new Array;";
	echo "progression_array[".$l."]=new Array;";
	echo "progression_points[".$l."]=new Array;";
	echo "progression_points_array[".$l."]=new Array;";
	echo "analyses[".$l."]=new Array;";
	echo "analyses_array[".$l."]=new Array;";
	echo "analyses_points[".$l."]=new Array;";
	echo "analyses_points_array[".$l."]=new Array;";
}
function SetUpNewLesson($unit_id,$l)
{
	$lessons=mysql_query("select id from lesson where uow_id=$unit_id and lesson_num=$l") or die("Error reported while executing the statement: <br />MySQL reported: ".mysql_error());
	while(list ($lesson_id)=mysql_fetch_array($lessons))
		{
			echo "lessonIds[".$l."]=".$lesson_id.";";
		}
	$themes=mysql_query("select theme_id,theme.theme from lesson left join theme on theme_id=theme.id where uow_id=$unit_id and lesson.lesson_num=$l") or die("Error reported while executing the statement: <br />MySQL reported: ".mysql_error());
	while(list ($theme_id,$theme)=mysql_fetch_array($themes))
		{
			echo "themeIds[".$l."]=".$theme_id.";";
			echo "themes[".$l."]='".$theme."';";
		}
	$sens=mysql_query("select ta,sen from lesson where id=$lesson_id");
        if ($sens)
        {
            (list($ta,$sen)=mysql_fetch_array($sens));
            echo "ta[".$l."]=".$ta.";";
            echo "sen[".$l."]=".$sen.";";
        }
        echo "objectiveIds_array[".$l."]=new Array;";
	echo "objectiveIds[".$l."]=new Array;";
	echo "objectives[".$l."]=new Array;";
	echo "objectiveStrand[".$l."]=new Array;";
	$objectives=mysql_query("select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join topic_objectives on topic_objectives.objectives_id=lesson_objectives.objective_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l");
	$o=1;
	$objective_array='';
	if ($objectives)
	{
	while (list($objective_id,$objective,$strand_id)=mysql_fetch_array($objectives))
		{
			if ($o==1) $objective_array=$objective_id;
			else $objective_array=$objective_array.",".$objective_id;
/*			echo "objectiveIds[".$l."].splice(objectiveIds[".$l."].length,0,".$objective_id.");";
			echo "objectives[".$l."].splice(objectives[".$l."].length,0,'".addslashes($objective)."');";
			echo "objectiveStrand[".$l."].splice(objectiveStrand[".$l."].length,0,".$strand_id.");";*/
			echo "objectiveIds[".$l."].splice(".$objective_id.",0,".$objective_id.");";
			echo "objectives[".$l."].splice(".$objective_id.",0,'".addslashes($objective)."');";
			echo "objectiveStrand[".$l."].splice(".$objective_id.",0,".$strand_id.");";
			$o++;
		}
	echo "objectiveIds_array[".$l."]='".$objective_array."';";
	}
	echo "keywords_array[".$l."]=new Array;";
	echo "keywords[".$l."]=new Array;";
	$keywords=mysql_query("select keyword_id from lesson_keywords left join lesson on lesson.id=lesson_keywords.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l");
	$o=0;
	$keyword_array='';
	if ($keywords)
	{
	while (list($keyword_id)=mysql_fetch_array($keywords))
		{
			if ($o==0) $keyword_array=$keyword_id;
			else $keyword_array=$keyword_array.",".$keyword_id;
			echo "keywords[".$l."][".$keyword_id."]=".$keyword_id.";";
			$o++;
		}
	echo "keywords_array[".$l."]='".$keyword_array."';";
	}
	echo "ict_array[".$l."]=new Array;";
	echo "ict[".$l."]=new Array;";
	$ict=mysql_query("select ict_id from lesson_ict left join lesson on lesson.id=lesson_ict.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l");
	$o=0;
	$ict_array='';
	if ($ict)
	{
	while (list($ict_id)=mysql_fetch_array($ict))
		{
			if ($o==0) $ict_array=$ict_id;
			else $ict_array=$ict_array.",".$ict_id;
			echo "ict[".$l."][".$ict_id."]=".$ict_id.";";
			$o++;
		}
	echo "ict_array[".$l."]='".$ict_array."';";
	}
	echo "numeracy_array[".$l."]=new Array;";
	echo "numeracy[".$l."]=new Array;";
	$numeracy=mysql_query("select numeracy_id from lesson_numeracy left join lesson on lesson.id=lesson_numeracy.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l");
	$o=0;
	$numeracy_array='';
	if ($numeracy)
	{
	while (list($numeracy_id)=mysql_fetch_array($numeracy))
		{
			if ($o==0) $numeracy_array=$numeracy_id;
			else $numeracy_array=$numeracy_array.",".$numeracy_id;
			echo "numeracy[".$l."][".$numeracy_id."]=".$numeracy_id.";";
			$o++;
		}
	echo "numeracy_array[".$l."]='".$numeracy_array."';";
	}
	echo "citizenship_array[".$l."]=new Array;";
	echo "citizenship[".$l."]=new Array;";
	$citizenship=mysql_query("select citizenship_id from lesson_citizenship left join lesson on lesson.id=lesson_citizenship.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l");
	$o=0;
	$citizenship_array='';
	if ($citizenship)
	{
	while (list($citizenship_id)=mysql_fetch_array($citizenship))
		{
			if ($o==0) $citizenship_array=$citizenship_id;
			else $citizenship_array=$citizenship_array.",".$citizenship_id;
			echo "citizenship[".$l."][".$citizenship_id."]=".$citizenship_id.";";
			$o++;
		}
	echo "citizenship_array[".$l."]='".$citizenship_array."';";
	}
	echo "risk_assessment_array[".$l."]=new Array;";
	echo "risk_assessment[".$l."]=new Array;";
	$risk_assessment=mysql_query("select ra_id from lesson_risk_assessment left join lesson on lesson.id=lesson_risk_assessment.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l");
	$o=0;
	$risk_assessment_array='';
	if ($risk_assessment)
	{
	while (list($risk_assessment_id)=mysql_fetch_array($risk_assessment))
		{
			if ($o==0) $risk_assessment_array=$risk_assessment_id;
			else $risk_assessment_array=$risk_assessment_array.",".$risk_assessment_id;
			echo "risk_assessment[".$l."][".$risk_assessment_id."]=".$risk_assessment_id.";";
			$o++;
		}
	echo "risk_assessment_array[".$l."]='".$risk_assessment_array."';";
	}
	echo "activityIds[".$l."]=new Array;";
	echo "activityLps[".$l."]=new Array;";
	echo "time[".$l."]=new Array;";
	echo "activityNum[".$l."]=new Array;";
	echo "activityCount[".$l."]=new Array;";
	echo "strand[".$l."]=new Array;";
	echo "strand_array[".$l."]=new Array;";
	echo "teaching_point[".$l."]=new Array;";
	echo "teaching_point_array[".$l."]=new Array;";
	echo "differentiation[".$l."]=new Array;";
	echo "differentiation_array[".$l."]=new Array;";
	echo "progression[".$l."]=new Array;";
	echo "progression_array[".$l."]=new Array;";
	echo "progression_points[".$l."]=new Array;";
	echo "progression_points_array[".$l."]=new Array;";
	echo "analyses[".$l."]=new Array;";
	echo "analyses_array[".$l."]=new Array;";
	echo "analyses_points[".$l."]=new Array;";
	echo "analyses_points_array[".$l."]=new Array;";
	$activities=mysql_query("select la_id,activity_id,time,activity_num,lesson_part.description from lesson_activities left join lesson on lesson.id=lesson_activities.lesson_id left join content_lesson_part on content_lesson_part.content_id = lesson_activities.activity_id left join lesson_part on lesson_part.id = content_lesson_part.lesson_part_id where lesson.uow_id=$unit_id and lesson.lesson_num=$l order by activity_num");
	$p=1;
	if ($activities)
	{
	echo "activityCount[".$l."]=".mysql_num_rows($activities).";";
        while (list($la_id,$activity_id,$time,$activity_num,$lesson_part)=mysql_fetch_array($activities))
		{
			$o=$activity_id;
                        echo "activityIds[".$l."][".$o."]=".$activity_id.";";
			echo "activityLps[".$l."][".$o."]='".$lesson_part."';";
			echo "time[".$l."][".$o."]='".$time."';";
//			echo "activityNum[".$l."][".$activity_num."]='".$activity_id."';";
			echo "activityNum[".$l."][".$p."]=".$activity_id.";";
				echo "strand[".$l."][".$o."]=new Array;";
				echo "strand_array[".$l."][".$o."]=new Array;";
				$strands=mysql_query("select strand_id from lesson_activity_strand left join lesson_activities on lesson_activities.la_id=lesson_activity_strand.la_id where lesson_activity_strand.la_id = $la_id");
				$s=0;
				$strand_array='';
				if ($strands)
				{
					while (list($strand_id)=mysql_fetch_array($strands))
					{
						if ($s==0) $strand_array=$strand_id;
						else $strand_array=$strand_array.",".$strand_id;
						echo "strand[".$l."][".$o."][".$strand_id."]=".$strand_id.";"; 
						$s++;
					}
				echo "strand_array[".$l."][".$o."]='".$strand_array."';";
				}
				echo "teaching_point[".$l."][".$o."]=new Array;";
				echo "teaching_point_array[".$l."][".$o."]=new Array;";
				$teaching_points=mysql_query("select point_id from lesson_activity_point left join lesson_activities on lesson_activities.la_id=lesson_activity_point.la_id where lesson_activity_point.la_id = $la_id");
				$s=0;
				$teaching_point_array='';
				if ($teaching_points)
				{
					while (list($teaching_point_id)=mysql_fetch_array($teaching_points))
					{
						if ($s==0) $teaching_point_array=$teaching_point_id;
						else $teaching_point_array=$teaching_point_array.",".$teaching_point_id;
						echo "teaching_point[".$l."][".$o."][".$teaching_point_id."]=".$teaching_point_id.";"; 
						$s++;
					}
				echo "teaching_point_array[".$l."][".$o."]='".$teaching_point_array."';";
				}
				echo "differentiation[".$l."][".$o."]=new Array;";
				echo "differentiation_array[".$l."][".$o."]=new Array;";
				$differentiations=mysql_query("select diff_id from lesson_activity_differentiation left join lesson_activities on lesson_activities.la_id=lesson_activity_differentiation.la_id where lesson_activity_differentiation.la_id = $la_id");
				$s=0;
				$differentiation_array='';
				if ($differentiations)
				{
					while (list($differentiation_id)=mysql_fetch_array($differentiations))
					{
						if ($s==0) $differentiation_array=$differentiation_id;
						else $differentiation_array=$differentiation_array.",".$differentiation_id;
						echo "differentiation[".$l."][".$o."][".$differentiation_id."]=".$differentiation_id.";"; 
						$s++;
					}
				echo "differentiation_array[".$l."][".$o."]='".$differentiation_array."';";
				}
				echo "progression[".$l."][".$o."]=new Array;";
				echo "progression_array[".$l."][".$o."]=new Array;";
				echo "progression_points[".$l."][".$o."]=new Array;";
				echo "progression_points_array[".$l."][".$o."]=new Array;";
				$progressions=mysql_query("select la_pr_id,pr_id from lesson_activity_progression left join lesson_activities on lesson_activities.la_id=lesson_activity_progression.la_id where lesson_activity_progression.la_id = $la_id");
				$s=0;
				$progression_array='';
				if ($progressions)
				{
					while (list($la_pr_id,$progression_id)=mysql_fetch_array($progressions))
					{
						if ($s==0) $progression_array=$progression_id;
						else $progression_array=$progression_array.",".$progression_id;
						echo "progression[".$l."][".$o."][".$progression_id."]=".$progression_id.";";
							echo "progression_points[".$l."][".$o."][".$progression_id."]=new Array;"; 
							echo "progression_points_array[".$l."][".$o."][".$progression_id."]=new Array;"; 
							$prog_points=mysql_query("select point_id from lesson_activity_progression_point left join lesson_activity_progression on lesson_activity_progression.la_pr_id=lesson_activity_progression_point.la_pr_id where lesson_activity_progression.la_id = $la_id and lesson_activity_progression.pr_id=$progression_id");
							$pp=0;
							$prog_point_array='';
							if ($prog_points)
							{
								while (list($prog_point_id)=mysql_fetch_array($prog_points))
								{
									if ($pp==0) $prog_point_array=$prog_point_id;
									else $prog_point_array=$prog_point_array.",".$prog_point_id;
									echo "progression_points[".$l."][".$o."][".$progression_id."][".$prog_point_id."]=".$prog_point_id.";";
									$pp++;
									}
								echo "progression_points_array[".$l."][".$o."][".$progression_id."]='".$prog_point_array."';";
							}
						$s++;
					}
				echo "progression_array[".$l."][".$o."]='".$progression_array."';";
				}
				echo "analyses[".$l."][".$o."]=new Array;";
				echo "analyses_array[".$l."][".$o."]=new Array;";
				echo "analyses_points[".$l."][".$o."]=new Array;";
				echo "analyses_points_array[".$l."][".$o."]=new Array;";
				$analysess=mysql_query("select analyses_id from lesson_activity_analyses left join lesson_activities on lesson_activities.la_id=lesson_activity_analyses.la_id where lesson_activity_analyses.la_id = $la_id");
				$s=0;
				$analyses_array='';
				if ($analysess)
				{
					while (list($analyses_id)=mysql_fetch_array($analysess))
					{
						if ($s==0) $analyses_array=$analyses_id;
						else $analyses_array=$analyses_array.",".$analyses_id;
						echo "analyses[".$l."][".$o."][".$analyses_id."]=".$analyses_id.";"; 
						$s++;
							echo "analyses_points[".$l."][".$o."][".$analyses_id."]=new Array;"; 
							echo "analyses_points_array[".$l."][".$o."][".$analyses_id."]=new Array;"; 

							$anal_points=mysql_query("select point_id from lesson_activity_analyses_point left join lesson_activity_analyses on lesson_activity_analyses.la_an_id=lesson_activity_analyses_point.la_an_id where lesson_activity_analyses.la_id = $la_id and lesson_activity_analyses.analyses_id=$analyses_id");
							$an=0;
							$anal_point_array='';
							if ($anal_points)
							{
								while (list($anal_point_id)=mysql_fetch_array($anal_points))
								{
									if ($an==0) $anal_point_array=$anal_point_id;
									else $anal_point_array=$anal_point_array.",".$anal_point_id;
									echo "analyses_points[".$l."][".$o."][".$analyses_id."][".$anal_point_id."]=".$anal_point_id.";";
									$an++;
									}
								echo "analyses_points_array[".$l."][".$o."][".$analyses_id."]='".$anal_point_array."';";
							}
					}
				echo "analyses_array[".$l."][".$o."]='".$analyses_array."';";
				}
			$p++;
		}
	}
}
function SetUpSetLesson($lesson_id,$lesson_num)
{
	$l=$lesson_num;
	echo "lessonIds[".$l."]=".$lesson_id.";";
	$themes=mysql_query("select theme_id,theme.theme from lesson left join theme on theme_id=theme.id where lesson.id=$lesson_id");
	while(list ($theme_id,$theme)=mysql_fetch_array($themes))
		{ 
			echo "themeIds[".$l."]=".$theme_id.";";
			echo "themes[".$l."]='".$theme."';";
		}
	echo "objectiveIds_array[".$l."]=new Array;";
	echo "objectiveIds[".$l."]=new Array;";
	echo "objectives[".$l."]=new Array;";
	echo "objectiveStrand[".$l."]=new Array;";
	$objectives=mysql_query("select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join topic_objectives on topic_objectives.objectives_id=lesson_objectives.objective_id where lesson.id=$lesson_id");
	$o=1;
	$objective_array='';
	if ($objectives)
	{
	while (list($objective_id,$objective,$strand_id)=mysql_fetch_array($objectives))
		{
			if ($o==1) $objective_array=$objective_id;
			else $objective_array=$objective_array.",".$objective_id;
/*			echo "objectiveIds[".$l."].splice(objectiveIds[".$l."].length,0,".$objective_id.");";
			echo "objectives[".$l."].splice(objectives[".$l."].length,0,'".addslashes($objective)."');";
			echo "objectiveStrand[".$l."].splice(objectiveStrand[".$l."].length,0,".$strand_id.");";*/
			echo "objectiveIds[".$l."].splice(".$objective_id.",0,".$objective_id.");";
			echo "objectives[".$l."].splice(".$objective_id.",0,'".addslashes($objective)."');";
			echo "objectiveStrand[".$l."].splice(".$objective_id.",0,".$strand_id.");";
			$o++;
		}
	echo "objectiveIds_array[".$l."]='".$objective_array."';";
	}
	echo "keywords_array[".$l."]=new Array;";
	echo "keywords[".$l."]=new Array;";
	$keywords=mysql_query("select keyword_id from lesson_keywords left join lesson on lesson.id=lesson_keywords.lesson_id where lesson.id=$lesson_id");
	$o=0;
	$keyword_array='';
	if ($keywords)
	{
	while (list($keyword_id)=mysql_fetch_array($keywords))
		{
			if ($o==0) $keyword_array=$keyword_id;
			else $keyword_array=$keyword_array.",".$keyword_id;
			echo "keywords[".$l."][".$keyword_id."]=".$keyword_id.";";
			$o++;
		}
	echo "keywords_array[".$l."]='".$keyword_array."';";
	}
	echo "ict_array[".$l."]=new Array;";
	echo "ict[".$l."]=new Array;";
	$ict=mysql_query("select ict_id from lesson_ict left join lesson on lesson.id=lesson_ict.lesson_id where lesson.lesson.id=$lesson_id");
	$o=0;
	$ict_array='';
	if ($ict)
	{
	while (list($ict_id)=mysql_fetch_array($ict))
		{
			if ($o==0) $ict_array=$ict_id;
			else $ict_array=$ict_array.",".$ict_id;
			echo "ict[".$l."][".$ict_id."]=".$ict_id.";";
			$o++;
		}
	echo "ict_array[".$l."]='".$ict_array."';";
	}
	echo "numeracy_array[".$l."]=new Array;";
	echo "numeracy[".$l."]=new Array;";
	$numeracy=mysql_query("select numeracy_id from lesson_numeracy left join lesson on lesson.id=lesson_numeracy.lesson_id where lesson.id=$lesson_id");
	$o=0;
	$numeracy_array='';
	if ($numeracy)
	{
	while (list($numeracy_id)=mysql_fetch_array($numeracy))
		{
			if ($o==0) $numeracy_array=$numeracy_id;
			else $numeracy_array=$numeracy_array.",".$numeracy_id;
			echo "numeracy[".$l."][".$numeracy_id."]=".$numeracy_id.";";
			$o++;
		}
	echo "numeracy_array[".$l."]='".$numeracy_array."';";
	}
	echo "citizenship_array[".$l."]=new Array;";
	echo "citizenship[".$l."]=new Array;";
	$citizenship=mysql_query("select citizenship_id from lesson_citizenship left join lesson on lesson.id=lesson_citizenship.lesson_id where lesson.id=$lesson_id");
	$o=0;
	$citizenship_array='';
	if ($citizenship)
	{
	while (list($citizenship_id)=mysql_fetch_array($citizenship))
		{
			if ($o==0) $citizenship_array=$citizenship_id;
			else $citizenship_array=$citizenship_array.",".$citizenship_id;
			echo "citizenship[".$l."][".$citizenship_id."]=".$citizenship_id.";";
			$o++;
		}
	echo "citizenship_array[".$l."]='".$citizenship_array."';";
	}
	echo "risk_assessment_array[".$l."]=new Array;";
	echo "risk_assessment[".$l."]=new Array;";
	$risk_assessment=mysql_query("select ra_id from lesson_risk_assessment left join lesson on lesson.id=lesson_risk_assessment.lesson_id where lesson.id=$lesson_id");
	$o=0;
	$risk_assessment_array='';
	if ($risk_assessment)
	{
	while (list($risk_assessment_id)=mysql_fetch_array($risk_assessment))
		{
			if ($o==0) $risk_assessment_array=$risk_assessment_id;
			else $risk_assessment_array=$risk_assessment_array.",".$risk_assessment_id;
			echo "risk_assessment[".$l."][".$risk_assessment_id."]=".$risk_assessment_id.";";
			$o++;
		}
	echo "risk_assessment_array[".$l."]='".$risk_assessment_array."';";
	}
	echo "activityIds[".$l."]=new Array;";
	echo "activityLps[".$l."]=new Array;";
	echo "time[".$l."]=new Array;";
	echo "activityNum[".$l."]=new Array;";
	echo "activityCount[".$l."]=new Array;";
	echo "strand[".$l."]=new Array;";
	echo "strand_array[".$l."]=new Array;";
	echo "teaching_point[".$l."]=new Array;";
	echo "teaching_point_array[".$l."]=new Array;";
	echo "differentiation[".$l."]=new Array;";
	echo "differentiation_array[".$l."]=new Array;";
	echo "progression[".$l."]=new Array;";
	echo "progression_array[".$l."]=new Array;";
	echo "progression_points[".$l."]=new Array;";
	echo "progression_points_array[".$l."]=new Array;";
	echo "analyses[".$l."]=new Array;";
	echo "analyses_array[".$l."]=new Array;";
	echo "analyses_points[".$l."]=new Array;";
	echo "analyses_points_array[".$l."]=new Array;";
	$activities=mysql_query("select la_id,activity_id,time,activity_num,lesson_part.description from lesson_activities left join lesson on lesson.id=lesson_activities.lesson_id left join content_lesson_part on content_lesson_part.content_id = lesson_activities.activity_id left join lesson_part on lesson_part.id = content_lesson_part.lesson_part_id where lesson.id=$lesson_id order by activity_num");
	$p=1;
	if ($activities)
	{
	echo "activityCount[".$l."]=".mysql_num_rows($activities).";";
	while (list($la_id,$activity_id,$time,$activity_num,$lesson_part)=mysql_fetch_array($activities))
		{
			$o=$activity_id;
			echo "activityIds[".$l."][".$o."]=".$activity_id.";";
			echo "activityLps[".$l."][".$o."]='".$lesson_part."';";
			echo "time[".$l."][".$o."]='".$time."';";
//			echo "activityNum[".$l."][".$activity_num."]='".$activity_id."';";
			echo "activityNum[".$l."][".$p."]=".$activity_id.";";
				echo "strand[".$l."][".$o."]=new Array;";
				echo "strand_array[".$l."][".$o."]=new Array;";
				$strands=mysql_query("select strand_id from lesson_activity_strand left join lesson_activities on lesson_activities.la_id=lesson_activity_strand.la_id where lesson_activity_strand.la_id = $la_id");
				$s=0;
				$strand_array='';
				if ($strands)
				{
					while (list($strand_id)=mysql_fetch_array($strands))
					{
						if ($s==0) $strand_array=$strand_id;
						else $strand_array=$strand_array.",".$strand_id;
						echo "strand[".$l."][".$o."][".$strand_id."]=".$strand_id.";"; 
						$s++;
					}
				echo "strand_array[".$l."][".$o."]='".$strand_array."';";
				}
				echo "teaching_point[".$l."][".$o."]=new Array;";
				echo "teaching_point_array[".$l."][".$o."]=new Array;";
				$teaching_points=mysql_query("select point_id from lesson_activity_point left join lesson_activities on lesson_activities.la_id=lesson_activity_point.la_id where lesson_activity_point.la_id = $la_id");
				$s=0;
				$teaching_point_array='';
				if ($teaching_points)
				{
					while (list($teaching_point_id)=mysql_fetch_array($teaching_points))
					{
						if ($s==0) $teaching_point_array=$teaching_point_id;
						else $teaching_point_array=$teaching_point_array.",".$teaching_point_id;
						echo "teaching_point[".$l."][".$o."][".$teaching_point_id."]=".$teaching_point_id.";"; 
						$s++;
					}
				echo "teaching_point_array[".$l."][".$o."]='".$teaching_point_array."';";
				}
				echo "differentiation[".$l."][".$o."]=new Array;";
				echo "differentiation_array[".$l."][".$o."]=new Array;";
				$differentiations=mysql_query("select diff_id from lesson_activity_differentiation left join lesson_activities on lesson_activities.la_id=lesson_activity_differentiation.la_id where lesson_activity_differentiation.la_id = $la_id");
				$s=0;
				$differentiation_array='';
				if ($differentiations)
				{
					while (list($differentiation_id)=mysql_fetch_array($differentiations))
					{
						if ($s==0) $differentiation_array=$differentiation_id;
						else $differentiation_array=$differentiation_array.",".$differentiation_id;
						echo "differentiation[".$l."][".$o."][".$differentiation_id."]=".$differentiation_id.";"; 
						$s++;
					}
				echo "differentiation_array[".$l."][".$o."]='".$differentiation_array."';";
				}
				echo "progression[".$l."][".$o."]=new Array;";
				echo "progression_array[".$l."][".$o."]=new Array;";
				echo "progression_points[".$l."][".$o."]=new Array;";
				echo "progression_points_array[".$l."][".$o."]=new Array;";
				$progressions=mysql_query("select la_pr_id,pr_id from lesson_activity_progression left join lesson_activities on lesson_activities.la_id=lesson_activity_progression.la_id where lesson_activity_progression.la_id = $la_id");
				$s=0;
				$progression_array='';
				if ($progressions)
				{
					while (list($la_pr_id,$progression_id)=mysql_fetch_array($progressions))
					{
						if ($s==0) $progression_array=$progression_id;
						else $progression_array=$progression_array.",".$progression_id;
						echo "progression[".$l."][".$o."][".$progression_id."]=".$progression_id.";";
							echo "progression_points[".$l."][".$o."][".$progression_id."]=new Array;"; 
							echo "progression_points_array[".$l."][".$o."][".$progression_id."]=new Array;"; 
							$prog_points=mysql_query("select point_id from lesson_activity_progression_point left join lesson_activity_progression on lesson_activity_progression.la_pr_id=lesson_activity_progression_point.la_pr_id where lesson_activity_progression.la_id = $la_id and lesson_activity_progression.pr_id=$progression_id");
							$pp=0;
							$prog_point_array='';
							if ($prog_points)
							{
								while (list($prog_point_id)=mysql_fetch_array($prog_points))
								{
									if ($pp==0) $prog_point_array=$prog_point_id;
									else $prog_point_array=$prog_point_array.",".$prog_point_id;
									echo "progression_points[".$l."][".$o."][".$progression_id."][".$prog_point_id."]=".$prog_point_id.";";
									$pp++;
									}
								echo "progression_points_array[".$l."][".$o."][".$progression_id."]='".$prog_point_array."';";
							}
						$s++;
					}
				echo "progression_array[".$l."][".$o."]='".$progression_array."';";
				}
				echo "analyses[".$l."][".$o."]=new Array;";
				echo "analyses_array[".$l."][".$o."]=new Array;";
				echo "analyses_points[".$l."][".$o."]=new Array;";
				echo "analyses_points_array[".$l."][".$o."]=new Array;";
				$analysess=mysql_query("select analyses_id from lesson_activity_analyses left join lesson_activities on lesson_activities.la_id=lesson_activity_analyses.la_id where lesson_activity_analyses.la_id = $la_id");
				$s=0;
				$analyses_array='';
				if ($analysess)
				{
					while (list($analyses_id)=mysql_fetch_array($analysess))
					{
						if ($s==0) $analyses_array=$analyses_id;
						else $analyses_array=$analyses_array.",".$analyses_id;
						echo "analyses[".$l."][".$o."][".$analyses_id."]=".$analyses_id.";"; 
						$s++;
							echo "analyses_points[".$l."][".$o."][".$analyses_id."]=new Array;"; 
							echo "analyses_points_array[".$l."][".$o."][".$analyses_id."]=new Array;"; 
							$anal_points=mysql_query("select point_id from lesson_activity_analyses_point left join lesson_activity_analyses on lesson_activity_analyses.la_an_id=lesson_activity_analyses_point.la_an_id where lesson_activity_analyses.la_id = $la_id and lesson_activity_analyses.analyses_id=$analyses_id");
							$an=0;
							$anal_point_array='';
							if ($anal_points)
							{
								while (list($anal_point_id)=mysql_fetch_array($anal_points))
								{
									if ($an==0) $anal_point_array=$anal_point_id;
									else $anal_point_array=$anal_point_array.",".$anal_point_id;
									echo "analyses_points[".$l."][".$o."][".$analyses_id."][".$anal_point_id."]=".$anal_point_id.";";
									$an++;
									}
								echo "analyses_points_array[".$l."][".$o."][".$analyses_id."]='".$anal_point_array."';";
							}
					}
				echo "analyses_array[".$l."][".$o."]='".$analyses_array."';";
				}
			$p++;
		}
	}
} 
function SaveLesson($plan_type,$uow_id,$lesson_num,$what_next)
{
    $getlessonnum=mysql_query("select id from lesson where uow_id=$uow_id and lesson_num=$lesson_num");
    if ($_POST['taout'][$lesson_num]) $ta=$_POST['taout'][$lesson_num]; else $ta='none';
    if ($_POST['senout'][$lesson_num]) $sen=$_POST['senout'][$lesson_num]; else $sen='none';
    $theme_id=$_POST['themeid'][$lesson_num];
    if (mysql_num_rows($getlessonnum)>0)
    {
        list ($lesson_id)=mysql_fetch_array($getlessonnum);
        $updatelesson="update lesson set theme_id=$theme_id,ta='$ta',sen='$sen' where id=$lesson_id";
        $updatelessonresult=mysql_query($updatelesson) or die("Error reported while executing the statement: $updatelesson<br />MySQL reported: ".mysql_error());
    }
    else
    {
    // instead of removing and reinserting I ought to create or update depending on
        if ($theme_id)
        {
            $createlesson="insert into lesson (uow_id,lesson_num,theme_id,ta,sen) values ($uow_id,$lesson_num,$theme_id,'$ta','$sen')";
            $createlessonresult=mysql_query($createlesson) or die("Error reported while executing the statement: $createlesson<br />MySQL reported: ".mysql_error());
            $lesson_id=mysql_insert_id();
        }
    }
    $removeoldobjectives=mysql_query("delete from lesson_objectives where lesson_id=$lesson_id");
    if ($_POST['objectiveid'][$lesson_num])
    {
	foreach ($_POST['objectiveid'][$lesson_num] as $objective_id)
	{
		$createobjective="insert into lesson_objectives (lesson_id,objective_id) values ($lesson_id,$objective_id)";
		$createobjectiveresult=mysql_query($createobjective) or die("Error reported while executing the statement: $createobjective<br />MySQL reported: ".mysql_error());
	}
    }
    $removeoldict=mysql_query("delete from lesson_ict where lesson_id=$lesson_id");
    if ($_POST['ict'][$lesson_num])
    {
	foreach ($_POST['ict'][$lesson_num] as $ict_id)
	{
		$createict="insert into lesson_ict (lesson_id,ict_id) values ($lesson_id,$ict_id)";
		$createictresult=mysql_query($createict) or die("Error reported while executing the statement: $createict<br />MySQL reported: ".mysql_error());
	}
    }
    $removeoldkeywords=mysql_query("delete from lesson_keywords where lesson_id=$lesson_id");
    if ($_POST['keywords'][$lesson_num])
    {
	foreach ($_POST['keywords'][$lesson_num] as $keywords_id)
	{
		$createkeywords="insert into lesson_keywords (lesson_id,keyword_id) values ($lesson_id,$keywords_id)";
		$createkeywordsresult=mysql_query($createkeywords) or die("Error reported while executing the statement: $createkeywords<br />MySQL reported: ".mysql_error());
	}
    }
    $removeoldnumeracy=mysql_query("delete from lesson_numeracy where lesson_id=$lesson_id");
    if ($_POST['numeracy'][$lesson_num])
    {
	foreach ($_POST['numeracy'][$lesson_num] as $numeracy_id)
	{
		$createnumeracy="insert into lesson_numeracy (lesson_id,numeracy_id) values ($lesson_id,$numeracy_id)";
		$createnumeracyresult=mysql_query($createnumeracy) or die("Error reported while executing the statement: $createnumeracy<br />MySQL reported: ".mysql_error());
	}
    }
    $removeoldrisk_assessment=mysql_query("delete from lesson_risk_assessment where lesson_id=$lesson_id");
    if ($_POST['risk_assessment'][$lesson_num])
    {
	foreach ($_POST['risk_assessment'][$lesson_num] as $risk_assessment_id)
	{
		$createrisk_assessment="insert into lesson_risk_assessment (lesson_id,ra_id) values ($lesson_id,$risk_assessment_id)";
		$createrisk_assessmentresult=mysql_query($createrisk_assessment) or die("Error reported while executing the statement: $createrisk_assessment<br />MySQL reported: ".mysql_error());
	}
    }
    $removeoldcitizenship=mysql_query("delete from lesson_citizenship where lesson_id=$lesson_id");
    if ($_POST['citizenship'][$lesson_num])
    {
	foreach ($_POST['citizenship'][$lesson_num] as $citizenship_id)
	{
		$createcitizenship="insert into lesson_citizenship (lesson_id,citizenship_id) values ($lesson_id,$citizenship_id)";
		$createcitizenshipresult=mysql_query($createcitizenship) or die("Error reported while executing the statement: $createcitizenship<br />MySQL reported: ".mysql_error());
	}
    }
    if ($_POST['activityid'][$lesson_num])
    {
	$removeoldactivity=mysql_query("delete from lesson_activities where lesson_id=$lesson_id");
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
		$createactivityresult=mysql_query($createactivity) or die("Error reported while executing the statement: $createactivity<br />MySQL reported: ".mysql_error());
		$la_id=mysql_insert_id();
		if ($_POST['teaching_point'][$lesson_num][$a])
		{
			foreach ($_POST['teaching_point'][$lesson_num][$a] as $teach_point_id)
			{
				$createteachpoint="insert into lesson_activity_point (la_id,point_id) values ($la_id,$teach_point_id)";
				$createteachpointresult=mysql_query($createteachpoint) or die("Error reported while executing the statement: $createteachpoint<br />MySQL reported: ".mysql_error());
			}
		}
		if ($_POST['strand'][$lesson_num][$a])
		{
			foreach ($_POST['strand'][$lesson_num][$a] as $strand_id)
			{
				$createstrand="insert into lesson_activity_strand (la_id,strand_id) values ($la_id,$strand_id)";
				$createstrandresult=mysql_query($createstrand) or die("Error reported while executing the statement: $createstrand<br />MySQL reported: ".mysql_error());
			}
		}
		if ($_POST['differentiation'][$lesson_num][$a])
		{
			foreach ($_POST['differentiation'][$lesson_num][$a] as $differentiation_id)
			{
				$createdifferentiation="insert into lesson_activity_differentiation (la_id,diff_id) values ($la_id,$differentiation_id)";
				$createdifferentiationresult=mysql_query($createdifferentiation) or die("Error reported while executing the statement: $createdifferentiation<br />MySQL reported: ".mysql_error());
			}
		}
		if ($_POST['analyses'][$lesson_num][$a])
		{
			foreach ($_POST['analyses'][$lesson_num][$a] as $analyses_id)
			{
				$createanalyses="insert into lesson_activity_analyses (la_id,analyses_id) values ($la_id,$analyses_id)";
				$createanalysesresult=mysql_query($createanalyses) or die("Error reported while executing the statement: $createanalyses<br />MySQL reported: ".mysql_error());
				$la_an_id=mysql_insert_id();
				if ($_POST['analyses_points'][$lesson_num][$a][$analyses_id])
				{
					foreach ($_POST['analyses_points'][$lesson_num][$a][$analyses_id] as $anal_point_id)
					{
					$createanalpoint="insert into lesson_activity_analyses_point (la_an_id,point_id) values ($la_an_id,$anal_point_id)";
					$createanalpointresult=mysql_query($createanalpoint) or die("Error reported while executing the statement: $createanalpoint<br />MySQL reported: ".mysql_error());
					}
				}
			}
		}
		if ($_POST['progression'][$lesson_num][$a])
		{
			foreach ($_POST['progression'][$lesson_num][$a] as $progression_id)
			{
				$createprogression="insert into lesson_activity_progression (la_id,pr_id) values ($la_id,$progression_id)";
				$createprogressionresult=mysql_query($createprogression) or die("Error reported while executing the statement: $createprogression<br />MySQL reported: ".mysql_error());
				$la_pr_id=mysql_insert_id();
				if ($_POST['progression_points'][$lesson_num][$a][$progression_id])
				{
					foreach ($_POST['progression_points'][$lesson_num][$a][$progression_id] as $prog_point_id)
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
    if (!$_POST['where_next']) echo "Your unit was last saved on: ".date('l jS \of F Y \a\t h:i:s A');
    else echo "&nbsp;";

}
function GetHelp($help_topic)
{
    $sql="select text from help where name='$help_topic'";
    $result=mysql_query($sql);
    if(mysql_num_rows($result)>0)
    {
    list($help)=mysql_fetch_array($result);
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
