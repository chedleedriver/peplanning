<?php session_start();
if(preg_match( "/MSIE/", $_SERVER['HTTP_USER_AGENT'])){
session_cache_limiter('private');
}
$tp = mysql_pconnect("localhost", "peplanning", "ferd1nand") or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db("peplanning", $tp);
if ($_GET['topic_id']) $topic_id=$_GET['topic_id']; else $topic_id=0;
if ($_GET['theme_id']) $theme_id=$_GET['theme_id']; else $theme_id=0;
if ($_GET['level_id']) $level_id=$_GET['level_id']; else $level_id=0;
if ($_GET['content_id']) $content_id=$_GET['content_id']; else $content_id=0;
if ($_GET['progression_id']) $progression_id=$_GET['progression_id']; else $progression_id=0;
if ($_GET['evaluation_id']) $evaluation_id=$_GET['evaluation_id']; else $evaluation_id=0;
if ($_GET['element_num']) $element_num=$_GET['element_num']; else $element_num=0;
if ($_GET['lesson_part_id']) $lesson_part_id=$_GET['lesson_part_id']; else $lesson_part_id=0;
if ($_GET['help_key']) $help_key=$_GET['help_key']; else $help_key="";
if ($_GET['what_to_add']) $what_to_add=$_GET['what_to_add'];else $what_to_add=0;
if ($_GET['what_to_add_id']) $what_to_add_id=$_GET['what_to_add_id'];else $what_to_add_id=0;
if ($_GET['what_to_remove']) $what_to_remove=$_GET['what_to_remove'];else $what_to_remove=0;
if ($_GET['what_to_remove_id']) $what_to_remove_id=$_GET['what_to_remove_id'];else $what_to_remove_id=0;
if ($_GET['GetData']) GetData($topic_id,$_GET['GetData'],$theme_id,$level_id,$content_id,$lesson_part_id,$element_num);
if ($_GET['GetXMLData']) GetXMLData($_GET['GetXMLData'], $topic_id, $level_id, $theme_id, $lesson_part_id, $content_id, $help_key);
if ($_GET['PutData']) {if ($_GET['PutData']=='topic') {$id=$topic_id;} elseif ($_GET['PutData']=='progression') {$id=$progression_id;} elseif ($_GET['PutData']=='evaluation') {$id=$evaluation_id;} else {$id=$content_id;} PutData($id,$_GET['PutData'],$what_to_add,$what_to_add_id,$_GET['progression_num'],$_GET['level']);}
if ($_GET['PutManyData']) {if ($_GET['PutManyData']=='topic') {$id=$topic_id;} elseif ($_GET['PutManyData']=='progression') {$id=$progression_id;} elseif ($_GET['PutManyData']=='evaluation') {$id=$evaluation_id;} else {$id=$content_id;} PutManyData($id,$_GET['PutManyData'],$what_to_add,$what_to_add_id,$_GET['progression_num'],$_GET['level']);}
if ($_GET['RemoveData']) {if ($_GET['RemoveData']=='topic') {$id=$topic_id;} elseif ($_GET['RemoveData']=='progression') {$id=$progression_id;} elseif ($_GET['RemoveData']=='evaluation') {$id=$evaluation_id;} else {$id=$content_id;} RemoveData($id,$_GET['RemoveData'],$what_to_remove,$what_to_remove_id,$_GET['progression_num'],$_GET['level']);}
if ($_GET['RemoveManyData']) {if ($_GET['RemoveManyData']=='topic') {$id=$topic_id;} elseif ($_GET['RemoveManyData']=='progression') {$id=$progression_id;} elseif ($_GET['RemoveManyData']=='evaluation') {$id=$evaluation_id;} else {$id=$content_id;} RemoveManyData($id,$_GET['RemoveManyData'],$what_to_remove,$what_to_remove_id,$_GET['progression_num'],$_GET['level']);}
if ($_GET['RemoveEvaluation']) RemoveEvaluation($_GET['evaluation_id'],$_GET['topic_id'],$_GET['theme_id'],$_GET['level']);
if ($_GET['GetStrandLevel']=="StrandLevel") GetStrandLevel($_GET['objective_id'],$_GET['topic_id']);
if ($_GET['GetLevel']=="Level") GetLevel($_GET['theme_id'],$_GET['topic_id']);
if ($_GET['UpdateStrandLevel']) UpdateStrandLevel($_GET['UpdateStrandLevel'],$_GET['id'],$_GET['objective_id'],$_GET['topic_id']);
if ($_GET['UpdateThemeLevel']) UpdateThemeLevel($_GET['id'],$_GET['theme_id'],$_GET['topic_id']);
if ($_GET['GetThemeImportance']) GetThemeImportance($_GET['theme_id'],$_GET['topic_id'],$_GET['level']);
if ($_GET['GetThemeNotes']) GetThemeNotes($_GET['theme_id'],$_GET['topic_id'],$_GET['level'],$_GET['importance']);
if ($_GET['GetThemeEvaluation']) GetThemeEvaluation($_GET['theme_id'],$_GET['topic_id'],$_GET['level'],$_GET['importance']);
if ($_GET['UpdateThemeLevelImportanceNotes']) UpdateThemeLevelImportanceNotes($_GET['level'],$_GET['theme_id'],$_GET['topic_id'],$_GET['importance'],$_GET['notes'],$_GET['evaluation']);
if ($_GET['DeleteTableItem']) DeleteTableItem($_GET['DeleteTableItem'],$_GET['id']);
if ($_GET['RemoveThemeLevel']) RemoveThemeLevel($_GET['RemoveThemeLevel'],$_GET['theme'],$_GET['level']);
//add to multi
if ($_GET['SaveUnitofWork']) SaveUnitofWork($_GET['topic_id'],$_GET['level_id'],$_GET['num_lessons'],$_GET['description']);
if ($_GET['GetObjectiveThemes']) get_objective_themes($_GET['GetObjectiveThemes'],$_GET['topic_id']);
/*********************************************************/
/********* Ali's functions ***************************/
/************************************************/
/*********************************************************/
/******** Helen's functions **************************/
/**************************************************/

function GetXMLData($what_to_get, $topic_id, $level_id, $theme_id, $lesson_part_id, $content_id, $help_key) {

    //Making the output be of type xml
    header('Content-Type: text/xml');
    header("Cache-Control: no-cache, must-revalidate");
    //A date in the past
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

    switch($what_to_get) {
         case 'help':
             GetHelpXML($help_key);
             break;
         case 'themes':
            GetThemesXML($topic_id, $level_id);
            break;
         case 'objectives':
             GetObjectivesXML($topic_id, $level_id);
             break;
         case 'topics':
             GetTopicsXML();
             break;
         case 'contents';
             GetContentsXML($topic_id, $level_id, $theme_id, $lesson_part_id);
             break;
        default:
            echo '<unfound>'.$what_to_get.'</unfound>';
            break;
    }
}


function GetTopicsXML()
{
    $sql="select topic.id as 'topic_id' , " .
    " topic.name as 'topic_name', " .
    " topic.description as 'topic_description', " .
    " topic.genre as 'genre_id', " .
    "genre.description as 'genre_name'" .
    " from topic " .
    "left join genre on genre.id=topic.genre";
	$topics=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());

    mysqlarray2xml($topics, 'topics', 'topic');
}

function GetObjectivesXML($topic_id, $level_id) {


    /*Objectives are limited by topic and level, and ordered by strand.
     * strand name, topic name, etc are also gathered for inclusion in the xml
     * sql command:
     */
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
           "where topic_objectives.topic_id=\"" . $topic_id . "\" " .
           " and ( $levelspecifyingstring ) " .
           "order by topic_objectives.strand_id, level.id";

    $objectives = mysql_query($sql) or die("Error reported while excecuting the statement; $sql<br />MySQL reportedL  ".mysql_error());

    mysqlarray2xml($objectives,'objectives','objective');
}

function GetHelpXML($help_key) {
    $sql = "select name as 'help_name', text as 'help_text' from help where name='" . $help_key . "'";

    $helps = mysql_query($sql) or die("Error reported while excecuting the statement; $sql<br />MySQL reportedL  ".mysql_error());

    mysqlarray2xml($helps,'helptopics','helptopic');
    
}

function GetThemesXML($topic_id, $level_id) {

     $levelspecifierstring;

     $levelspecifierstring = "topic_theme.level=$level_id " ;
    //select the themes based on topic and level
    $sql = "select theme.id as 'theme_id',theme.theme as 'theme_name', ".
           "theme.description as 'theme_description', topic_theme.level as 'level_id', " .
		   "topic_theme.importance as 'theme_importance', " .
		   "topic_theme.notes as 'theme_notes', ".
           "level.description 'level_name' " .
           "from topic_theme ".
           "left join theme on theme.id = topic_theme.theme_id ".
           "left join level on level.id = topic_theme.level " .
           "where topic_theme.topic_id=$topic_id and " .
            "($levelspecifierstring ) ".
            "order by topic_theme.importance "; // also order by early->late

    $themes=mysql_query($sql) or die("Error reported while excetung the statement; $sql<br />MySQL reportedL  ".mysql_error());

    mysqlarray2xml($themes, 'themes', 'theme');
}


function GetContentsXML($topic_id, $level_id, $theme_id, $lesson_part_id) {
     $levelspecifierstring;
     $level_ids = explode(":", $level_id);

     	switch ($level_id) {
		case "1.5":
		$levelspecifierstring = "topic_objectives.level_id=\"1\" or topic_objectives.level_id=\"2\"";
		break;
		case "2.5":
		$levelspecifierstring = "topic_objectives.level_id=\"2\" or topic_objectives.level_id=\"3\"";
		break;
		case "3.5":
		$levelspecifierstring = "topic_objectives.level_id=\"3\" or topic_objectives.level_id=\"4\"";
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
    " AND ( $levelspecifierstring ) " .
    " $limitbylessonpartstring   " .
    " ORDER BY content_lesson_part.lesson_part_id";

    $content=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());



    //echo "<sql>$sql</sql>";
    mysqlarray2xml($content, 'contents', 'content');

 }

 /**
  * Utility function - changes php-escaped characters to javascript escaped characters.
  *
  */
function phpstring2javascriptstring($string) {
    
    $newstring = preg_replace('#([\x00-\x1F])#e', '"\x" . sprintf("%02x", ord("\1"))', $string);
    $newstring = $str = str_replace(array('\\', "'"), array("\\\\", "\\'"), $newstring);
    return $newstring;
}

/** Utility function for packing the result of a mysql query into xml
 */
function mysqlarray2xml($array, $roottag='root', $elementtag='element') {
    echo "<" . $roottag . ">\n";
    $numberoffields = mysql_num_fields($array);
    while($row = mysql_fetch_array($array)){
        echo "<" . $elementtag . ">\n"   ;
        for ($i=0; $i< $numberoffields ; $i++) {
            $tagname = mysql_field_name($array, $i);
            echo "<" . $tagname . ">";
            echo $row[$tagname];
            echo "</" . $tagname . ">\n";
        }

        echo "</" . $elementtag . ">\n";
    }
    echo "</" . $roottag . ">\n";
}

/******************************************************/
/************* End of Helen's functions ***************/
/****************************************************/



function GetList($what,$id)
{
	global $data;
	if ($id) { 
		if ($what=="topic") $sql="select * from $what where genre_id in (select topic.genre from topic
where id=$id)";
		elseif ($what=="easy_differentiation") $sql = "select * from differentiation where difficulty='e' and genre_id in (select topic.genre from topic where id=$id) order by differentiation";
		elseif ($what=="hard_differentiation") $sql = "select * from differentiation where difficulty='h' and genre_id in (select topic.genre from topic where id=$id) order by differentiation";
		elseif (($what=="lesson_part") OR ($what=="equipment")) $sql = "select * from ".$what." left join topic_".$what." on topic_".$what.".".$what."_id = ".$what.".id where topic_".$what.".topic_id=".$id." order by description";
		elseif ($what=="keywords") $sql = "select * from ".$what." left join topic_".$what." on topic_".$what.".".$what."_id = ".$what.".id where topic_".$what.".topic_id=".$id." order by keyword";
		elseif ($what=="theme") $sql = "select DISTINCTROW theme.id,theme from theme left join topic_theme on theme.id = topic_theme.theme_id where topic_theme.topic_id=".$id." order by theme";
		elseif ($what=="objectives") $sql = "select * from ".$what." left join objective_topic on objective_topic.objective_id = objectives.id where objective_topic.topic_id=$id order by objective";
		elseif ($what=="point") $sql = "select * from ".$what." where genre_id in (select topic.genre from topic where id=$id) order by point";
		elseif ($what=="strand") $sql = "select * from $what order by $what";
		elseif ($what=="numeracy") $sql = "select * from $what order by description";
                elseif ($what=="ICT") $sql = "select * from $what order by description";
                elseif ($what=="risk_assessment") $sql = "select * from $what order by description";
		elseif ($what=="citizenship") $sql = "select * from $what order by description";
		elseif ($what=="level") $sql = "select * from $what order by id";
		else $sql = "select * from ".$what." left join topic_".$what." on topic_".$what.".".$what."_id = ".$what.".id where topic_".$what.".topic_id=".$id." order by ".$what;}
	else {
	if ($what=="easy_differentiation") $sql = "select * from differentiation where difficulty='e' order by differentiation";
	elseif ($what=="hard_differentiation") $sql = "select * from differentiation where difficulty='h' order by differentiation";
	elseif (($what=="lesson_part") OR ($what=="equipment") OR ($what=='level')) $sql = "select * from $what order by description";
	elseif ($what=="keywords") $sql = "select * from $what order by keyword";
	elseif ($what=="numeracy") $sql = "select * from $what order by description";
        elseif ($what=="ICT") $sql = "select * from $what order by description";
        elseif ($what=="risk_assessment") $sql = "select * from $what order by description";
	elseif ($what=="citizenship") $sql = "select * from $what order by description";
	else $sql = "select * from $what order by $what";}
	$data = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
	return $data;
}
function GetTopicList($what,$topic_id)
{
	global $data;
	$what_id=$what."_id";
	$topic_what="topic_".$what;
	$sql = "select * from $what left join $topic_what on $topic_what.$what_id = id where $topic_what.topic_id = $topic_id";
	if ($what=="theme") $sql = "select distinct(theme_id),theme.theme from topic_theme left join theme on topic_theme.theme_id=theme.id where topic_theme.topic_id = $topic_id";
	$data = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
	return $data; 
}
function TopicUpdate()
{
	$topic_id=$_POST['topic_id'];
	$topic_name=$_POST['topic_name'];
	$genre_id=$_POST['genre'];
	$result=mysql_query("select id from topic where name='$topic_name'");
	if ((!$topic_id) and (mysql_num_rows($result)==0))
	{$sql="insert into topic (name,genre) value ('$topic_name','$genre_id')";
	$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
	list($topic_id) = mysql_fetch_array(mysql_query("select last_insert_id()"));
	}
	else
	{list($topic_id) = mysql_fetch_array($result);}
	UpdateTopicElements("equipment",$_POST['equipment'],$topic_id);
	UpdateTopicElements("keywords",$_POST['keywords'],$topic_id);
	UpdateTopicElements("theme",$_POST['theme'],$topic_id);
	UpdateTopicElements("objectives",$_POST['objectives'],$topic_id);
	UpdateTopicElements("lesson_part",$_POST['lesson_part'],$topic_id);
	UpdateTopicElements("point",$_POST['point'],$topic_id);
//	echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/topic.php?mode=look&topic_id=".$topic_id."\">");
	echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/topic.php\">");
}
function UpdateTopicElements($element,$elements,$topic_id)
{
	$table="topic_".$element;
	foreach ($elements as $elements_id)
	{
	$sql="delete from $table where topic_id = $topic_id and ".$element."_id = $elements_id";
	$data = mysql_query($sql);
	$sql="insert into $table (topic_id, ".$element."_id) values ($topic_id, $elements_id)";
	$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
	}
}
function GetContentList($what,$content_id,$progression_id)
{
	global $data;
	$what_id=$what."_id";
	$content_what="content_".$what;
	if (!$progression_id){
                if ($what=="point")
                    {
                        $sql = "select * from $what left join $content_what on $content_what.$what_id = id where $content_what.content_id = $content_id order by point_num";
                     }
                else
                    {
                        $sql = "select * from $what left join $content_what on $content_what.$what_id = id where $content_what.content_id = $content_id";
                    }
                }
	else {
		if ($what=="differentiation") 
		{
			$sql = "select * from $what left join $content_what on $content_what.$what_id = id where $content_what.content_id = $content_id and difficulty='$progression_id'";
			}
		else
		{	
			$sql = "select * from point left join progression_point on progression_point.point_id = id where progression_point.progression_id = $progression_id"; 
		}
	}
	$data = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
	return $data; 
}
function GetTopic($topic_id)
{
	$sql="select id,name from topic where id = $topic_id";
	list($topic_topic_id,$topic_name) = mysql_fetch_array(mysql_query($sql)) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
}
function GetTopics()
{
	$sql="select id,name from topic";
	$topics=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('topics',$topics);
}
function GetIct()
{
	$sql="select id,description from ICT";
	$ict=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('ict',$ict);
}
function GetCitizenship()
{
	$sql="select id,description from citizenship";
	$citizenship=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('citizenship',$citizenship);
}
function GetNumeracy()
{
	$sql="select id,description from numeracy";
	$numeracy=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('numeracy',$numeracy);
}
function GetRisk_Assessment()
{
	$sql="select id,description from risk_assessment";
	$risk_assessment=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('risk_assessment',$risk_assessment);
}
function GetEquipment($topic_id)
{
	$sql="select equipment.id,description from equipment left join topic_equipment on equipment.id = topic_equipment.equipment_id where topic_equipment.topic_id=$topic_id";
	$equipment=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('equipment',$equipment);
}
function GetObjectives($topic_id)
{
	$sql="select objectives.id,objective from objectives left join topic_objectives on objectives.id = topic_objectives.objectives_id where topic_objectives.topic_id=$topic_id";
	$objectives=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('objectives',$objectives);
}
function GetAssessment($topic_id)
{
	$sql="select objectives.id,assessment from objectives left join topic_objectives on objectives.id = topic_objectives.objectives_id where topic_objectives.topic_id=$topic_id";
	$assessents=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('assessments',$assessents);
}
function GetKeywords($topic_id)
{
	$sql="select keywords.id,keyword from keywords left join topic_keywords on keywords.id = topic_keywords.keywords_id where topic_keywords.topic_id=$topic_id";
	$keywords=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('keywords',$keywords);
}
function GetPoints($topic_id)
{
	$sql="select point.id,point from point left join topic_point on  point.id = topic_point.point_id where topic_point.topic_id=$topic_id order by point";
	$points=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('points',$points);
}
function GetContentPoint($content_id)
{
	$sql="select point.id,point from point left join content_point on  point.id = content_point.point_id where content_point.content_id=$content_id order by point";
	$point=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('point',$point);
}
function GetDifferentiation($topic_id,$difficulty)
{
	list($genre)=mysql_fetch_array(mysql_query("select genre from topic where id=$topic_id"));
	$sql="select id, differentiation from differentiation where genre_id=$genre and difficulty='$difficulty'";
	$differentiation=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('differentiation',$differentiation);
}
function GetContentDifferentiation($content_id,$difficulty)
{
	$sql="select differentiation.id, differentiation from differentiation left join content_differentiation on differentiation.id = content_differentiation.differentiation_id where content_differentiation.content_id=$content_id and difficulty='$difficulty'";
	$differentiation=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('differentiation',$differentiation);
}
function GetContentStrand($content_id)
{
	$sql="select strand.id,strand from strand left join content_strand on  strand.id = content_strand.strand_id where content_strand.content_id=$content_id";
	$strand=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('strand',$strand);
}
function GetContentLevels($content_id)
{
	$sql="select level.id from level left join content_level on  level.id = content_level.level_id where content_level.content_id=$content_id";
	$level=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('level',$level);
}
function GetContentPoints($content_id)
{
	$sql="select point.id,point from point left join content_point on  point.id = content_point.point_id where content_point.content_id=$content_id";
	$point=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('point',$point);
}
function GetContentProgressionPoints($progression_id)
{
	$sql="select point.id,point from point left join progression_point on  point.id = progression_point.point_id where progression_point.progression_id=$progression_id";
	$point=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('progression_point',$point);
}
function GetThemes($topic_id)
{
	$sql="select DISTINCTROW theme.id,theme from theme left join topic_theme on theme.id = topic_theme.theme_id where topic_theme.topic_id=$topic_id";
	$themes=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('themes',$themes);
}
function GetObjectiveGenres($objective_id)
{
	$sql="select id, description from genre";
	$genres=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	if ($objective_id!=0)
		{$sql1="select genre.id from genre left join genre_objective on genre.id = genre_objective.genre_id where genre_objective.objective_id=$objective_id";
		 $genres1=mysql_query($sql1) or die("Error reported while executing the statement: $sql1<br />MySQL reported: ".mysql_error());
		 $obj_idx=0;
	     while (list ($id)=mysql_fetch_array($genres1))
		 {
		 	$objective_genres[$obj_idx]=$id;
			$obj_idx++;
			}
		}
	while (list($genre_id,$genre)=mysql_fetch_array($genres))
	{ 	echo "<option value=".$genre_id;
		if ($objective_genres) {if (in_array($genre_id,$objective_genres)) echo " selected";}
		echo ">".$genre."</option>";
	}
}	
function GetObjectiveThemes($objective_id)
{
	$sql="select DISTINCTROW theme.id,theme from theme";
	$themes=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	if ($objective_id!=0)
		{$sql1="select theme.id from theme left join theme_objective on theme.id = theme_objective.theme_id where theme_objective.objective_id=$objective_id";
		 $themes1=mysql_query($sql1) or die("Error reported while executing the statement: $sql1<br />MySQL reported: ".mysql_error());
		 $obj_idx=0;
	     while (list ($id)=mysql_fetch_array($themes1))
		 {
		 	$objective_themes[$obj_idx]=$id;
			$obj_idx++;
			}
		}
	while (list($theme_id,$theme)=mysql_fetch_array($themes))
	{ 	echo "<option value=".$theme_id;
		if ($objective_themes) {if (in_array($theme_id,$objective_themes)) echo " selected";}
		echo ">".$theme."</option>";
	}
}	
function GetTopicObjectives($objective_id)
{
	$sql="select topic.id,name from topic";
	$topics=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	if ($objective_id!=0)
		{$sql1="select topic_id from objectives where id=$objective_id";
		 $topics1=mysql_query($sql1) or die("Error reported while executing the statement: $sql1<br />MySQL reported: ".mysql_error());
                 list ($id)=mysql_fetch_array($topics1);}
	while (list($topic_id,$topic)=mysql_fetch_array($topics))
	{ 	echo "<option value=".$topic_id;
		if (($id) && ($id==$topic_id)) echo " selected";
		echo ">".$topic."</option>";
	}
}
function GetObjectiveTopics($objective_id)
{
	$sql="select  topic.id,name from topic";
	$topics=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	if ($objective_id!=0)
		{$sql1="select topic.id from topic left join objective_topic on topic.id = objective_topic.topic_id where objective_topic.objective_id=$objective_id";
		 $topics1=mysql_query($sql1) or die("Error reported while executing the statement: $sql1<br />MySQL reported: ".mysql_error());
         //        list ($id)=mysql_fetch_array($topics1);
		 $obj_idx=0;
		 while (list ($id)=mysql_fetch_array($topics1))
		 {
		 	$objective_topics[$obj_idx]=$id;
			$obj_idx++;
			}
		 }
	while (list($topic_id,$topic)=mysql_fetch_array($topics))
	{ 	echo "<option value=".$topic_id;
		//if (($id) && ($id==$topic_id)) echo " selected";
		if ($objective_topics) {if (in_array($topic_id,$objective_topics)) echo " selected";}
		echo ">".$topic."</option>";
	}
}
function GetContentThemes($content_id)
{
	$sql="select theme.id,theme from theme left join content_theme on theme.id = content_theme.theme_id where content_theme.content_id=$content_id";
	$themes=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('themes',$themes);
}
function GetContentStrands($content_id)
{
	$sql="select strand.id,strand from strand left join content_strand on  strand.id = content_strand.strand_id where content_strand.content_id=$content_id";
	$strand=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('strand',$strand);
}
function GetContentLessonParts($content_id)
{
	$sql="select lesson_part.id,description from lesson_part left join content_lesson_part on  lesson_part.id = content_lesson_part.lesson_part_id where content_lesson_part.content_id=$content_id";
	$lesson_part=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('lesson_part',$lesson_part);
}
function GetContentEquipment($content_id)
{
	$sql="select equipment.id,description from equipment left join content_equipment on  equipment.id = content_equipment.equipment_id where content_equipment.content_id=$content_id";
	$equipment=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('equipment',$equipment);
}
function GetLevels($topic_id=0)
{
	$sql="select id from level";
	$levels=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('levels',$levels);
}
function GetStrands($topic_id)
{
	$sql="select id,strand from strand";
	$strands=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('strands',$strands);
}
function GetLessonParts($topic_id)
{
	$sql="select id, description from lesson_part  left join topic_lesson_part on  lesson_part.id = topic_lesson_part.lesson_part_id where topic_lesson_part.topic_id=$topic_id";
	$lesson_parts=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('lesson_parts',$lesson_parts);
}
function GetContent($topic_id,$level_id,$theme_id,$lesson_part_id)
{
	$sql="select content.content_id,name from content left join (content_topic, content_theme, content_level, content_lesson_part) on (content.content_id = content_topic.content_id AND content.content_id = content_theme.content_id AND content.content_id = content_level.content_id AND content.content_id = content_lesson_part.content_id) WHERE content_topic.topic_id = $topic_id AND content_theme.theme_id = $theme_id AND content_level.level_id = $level_id AND content_lesson_part.lesson_part_id=$lesson_part_id";
	$content=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList('content',$content);
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
		echo "<option value=".$what_id." ondblclick=\"addSrcToDestList('".$what."')\">".$what_name."</option>";
 	} 
	}
}
function ContentDelete()
{
	$content_id=$_POST['content_id'];
	$sql="delete from content where content_id=$content_id";
	$delete = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	if ($_POST['level']) DeleteContentElements("level",$_POST['level'],$content_id);
	if ($_POST['point']) DeleteContentElements("point",$_POST['point'],$content_id);
	if ($_POST['strand']) DeleteContentElements("strand",$_POST['strand'],$content_id);
	if ($_POST['theme']) DeleteContentElements("theme",$_POST['theme'],$content_id);
	if ($_POST['topic']) DeleteContentElements("topic",$_POST['topic'],$content_id);
	if ($_POST['lesson_part']) DeleteContentElements("lesson_part",$_POST['lesson_part'],$content_id);
	if ($_POST['progression_id']) DeleteProgression($_POST['progression_id'],$content_id);
	echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/\">");
}
function ContentCreate()
{
	//print_r($_POST);
	//print_r($_FILES);
	$content_name=addslashes($_POST['content_name']);
	$description = base64_encode(serialize($_POST['description']));
	$time=$_POST['time'];
	$topic_id=$_POST['topic'];
	$sql="insert into content (name,description,time) values ('$content_name','$description','$time')";
	$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
	list($content_id) = mysql_fetch_array(mysql_query("select last_insert_id()"));
	if ($_POST['easy_differentiation']) UpdateContentElements("differentiation",$_POST['easy_differentiation'],$content_id);
	if ($_POST['hard_differentiation']) UpdateContentElements("differentiation",$_POST['hard_differentiation'],$content_id);
	if ($_POST['level']) UpdateContentElements("level",$_POST['level'],$content_id);
	if ($_POST['equipment']) UpdateContentElements("equipment",$_POST['equipment'],$content_id);
	if ($_POST['point']) UpdateContentElements("point",$_POST['point'],$content_id);
	if ($_POST['strand']) UpdateContentElements("strand",$_POST['strand'],$content_id);
	if ($_POST['theme']) UpdateContentElements("theme",$_POST['theme'],$content_id);
	if ($_POST['topic']) UpdateContentElements("topic",$_POST['topic'],$content_id);
	if ($_POST['lesson_part']) UpdateContentElements("lesson_part",$_POST['lesson_part'],$content_id);
	UpdateProgression($content_id);
	if ($_FILES['diagram']['tmp_name'])  
	 {$target_path='/var/www/html/tplan/diagrams/'.$content_id.'.gif';
		move_uploaded_file($_FILES['diagram']['tmp_name'], $target_path); }
	//echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/content_insert.php\">");
	//echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/content.php?mode=look&content_id=".$content_id."&topic=".$topic_id."\">");
}
function ResourceUpload()
{
    $content_id=$_POST['content_id'];           
    if ($_FILES['resource']['tmp_name'])
	 {
             $target_path=FILE_ROOT.RESOURCE_PATH.$content_id;
             if(!is_dir($target_path)) mkdir($target_path);
             $target_file=$target_path.random_string(8);
             move_uploaded_file($_FILES['resource']['tmp_name'], $target_file); 
             return $target_file;
         }
         else return "failed";
}
function UpdateContentResources()
{
    $cr_id=$_POST['cr_id'];
    $topic_id=$_POST['topic'];
    $content_id=$_POST['content_id'];           
    $description=$_POST['description'];
    if(isset($_POST['upload'])) {
        $location=ResourceUpload();
        $type=substr($_FILES['resource']['type'],12);
        $name=$_FILES['resource']['name'];
    }
    else {
        $type='url';
        $location=$_POST['link_url'];
        $name='url';
    }
    $update_sql="update content_resources set content_id=$content_id,description='$description',name='$name',location='$location',type='$type' where id=$cr_id";
    $update = mysql_query($update_sql) or die("Error reported while executing the statement: $update_sql<br />MySQL reported: ".mysql_error());
    echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/content_resources.php?mode=look&content_id=".$content_id."&topic=".$topic_id."\">");
}
function DeleteContentResources()
{
    $cr_id=$_POST['cr_id'];
    $topic_id=$_POST['topic'];
    $content_id=$_POST['content_id'];  
    $check_type=list($type,$location)=mysql_fetch_array(mysql_query("select type,location from content_resources where id=$cr_id"));
    if ($type!="url") unlink($location);
    $delete_sql="delete from content_resources where id=$cr_id";
    $delete = mysql_query($delete_sql) or die("Error reported while executing the statement: $delete_sql<br />MySQL reported: ".mysql_error());
    echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/content_resources.php?mode=look&content_id=".$content_id."&topic=".$topic_id."\">");
}    
function InsertContentResources()
{
    
    $topic_id=$_POST['topic'];
    $content_id=$_POST['content_id'];           
    $description=$_POST['description'];
    if(isset($_POST['upload'])) {
        $location=ResourceUpload();
        $type=substr($_FILES['resource']['type'],12);
        $name=$_FILES['resource']['name'];
    }
    else {
        $type='url';
        $location=$_POST['link_url'];
        $name='url';
    }
    $insert_sql="insert into content_resources (content_id,description,name,location,type) values ($content_id,'$description','$name','$location','$type')";
    $insert = mysql_query($insert_sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
    echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/content_resources.php?mode=look&content_id=".$content_id."&topic=".$topic_id."\">");
}
function random_string($l = 10){
    $c = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxwz0123456789";
    for(;$l > 0;$l--) $s .= $c{rand(0,strlen($c))};
    return str_shuffle($s);
}
function ContentUpdate()
{
//	print_r($_POST);
	//print_r($_FILES);
	$content_id=$_POST['content_id'];
	$content_name=addslashes($_POST['content_name']);
//	foreach ($_POST['description'] as $clean_description_line)
//		{
//			$clean_description_line=htmlspecialchars($clean_description_line,ENT_QUOTES);
//			print $clean_description_line.'<br>';
//		}
//	unset($clean_description_line);
//	foreach ($_POST['description'] as $description_line) {
//		$description_line=addslashes($description_line); }
	$description = base64_encode(serialize($_POST['description']));
	$time=$_POST['time'];
	$topic_id=$_POST['topic'];
	$sql="update content set name='$content_name', description='$description', time='$time' where content_id=$content_id";
	$update = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	if ($_FILES['diagram']['tmp_name'])
	 {
                $target_path='/var/www/html/tplan/diagrams/'.$content_id.'.gif';
                $target_rename='/var/www/html/tplan/diagrams/'.$content_id.'.old';
             //$target_path='/u01/PEplanning/tplan/diagrams/'.$content_id.'.gif';
             //$target_rename='/u01/PEplanning/tplan/diagrams/'.$content_id.'.old';
             if (file_exists($target_path)) rename($target_path,$target_rename);
		move_uploaded_file($_FILES['diagram']['tmp_name'], $target_path); }
	UpdateProgression($content_id);
        echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/content.php?mode=look&content_id=".$content_id."&topic=".$topic_id."\">");
}
function UpdateProgression($content_id)
{
	for ($i=0 ; $i < 4 ; $i++)
	{
		if (($_POST['progression'][$i][0]) OR ($_POST['progression'][$i][1]) OR ($_POST['progression'][$i][2]))
		{
		$progression=base64_encode(serialize($_POST['progression'][$i]));
		$progression_id=$_POST['progression_id'][$i];
		if ($_POST['progression_id'][$i]) {
			$sql="update progression set progression = '$progression' where id = $progression_id";
			$update = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); }
		else {
			$sql="insert into progression (progression) value ('$progression')";
			$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
			$progression_id = mysql_insert_id();
			$sql="insert into content_progression (content_id, progression_id) value ($content_id, $progression_id)";
			$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
			if ($_POST['progression_point'][$i])
				{ foreach ($_POST['progression_point'][$i] as $progression_point_id){
				$sql="delete from progression_point where progression_id = $progression_id and point_id = $progression_point_id";
				$data = mysql_query($sql);
				$sql="insert into progression_point (progression_id, point_id) values ($progression_id, $progression_point_id)";
				$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
					}
				}	
			}
		}
	}
}
function DeleteProgression($progression_id, $content_id)
{
	$sql="delete from progression where id=$progression_id";
	$data = mysql_query($sql);
	$sql="delete from content_progression where progression_id=$progression_id and content_id=$content_id";
	$data = mysql_query($sql);
	$sql="delete from progression_point where progression_id=$progression_id";
	$data = mysql_query($sql);
}
function UpdateContentElements($element,$elements,$content_id)
{
	$table="content_".$element;
	if (is_array($elements)) {
		foreach ($elements as $elements_id)
			{
			DoTheUpdate($element,$elements_id,$table,$content_id);
			}
		}
	else {
			$elements_id=$elements;
			DoTheUpdate($element,$elements_id,$table,$content_id);
		}
}
function DoTheUpdate($element,$elements_id,$table,$content_id)
{
	$sql="delete from $table where content_id = $content_id and ".$element."_id = $elements_id";
	$data = mysql_query($sql);
	$sql="insert into $table (content_id, ".$element."_id) values ($content_id, $elements_id)";
	$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
}
function DeleteContentElements($element,$elements,$content_id)
{
	$table="content_".$element;
	foreach ($elements as $elements_id)
	{
	$sql="delete from $table where content_id = $content_id and ".$element."_id = $elements_id";
	$data = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
	}
}
function GetData($topic_id,$data,$theme_id,$level_id,$content_id,$lesson_part_id,$element_num)
{
	switch ($data)
	{
		case 'topic':
			echo "<select id='topic' onchange=\"GetData('year')\"> <option value=\"Topic\">Topic</option>";
			GetTopics();
			echo "</select>";
			break;
		case 'year':
			echo "<select id=\"year\" name=\"year\" onchange=\"GetData('class')\"><option id=\"year\"></option><option id=\"1\">1</option><option id=\"2\">2</option><option id=\"3\">3</option><option id=\"4\">4</option><option id=\"5\">5</option><option id=\"6\">6</option></select>";
			break;
		case 'class':
			echo "<input type=\"text\" id=\"class\" name=\"class\" value=\"Class\" size=\"10\" onchange=\"GetData('level')\" />";
			break;
		case 'level':
			echo "<select id='level' onchange=\"GetData('theme')\"><option value=\"Level\">Level</option>";
			GetLevels($topic_id);
			echo "</select>";
			break;
		case 'theme':
			echo "<select id='theme' onchange=\"GetData('objectives');GetData('equipment');GetData('keywords');GetData('numeracy');GetData('citizenship');GetData('ict');GetData('risk_assessment');GetData('lesson_part');\"><option value=\"Theme\">Theme</option>";
			GetThemes($topic_id);
			echo "</select>";
			break;
		case 'objectives':
			echo "<select id='objectives_".$element_num."'><option value=\"Objective\">Objective</option>";
			GetObjectives($topic_id);
			echo "</select>";
			break;
		case 'equipment':
			echo "<select id='equipment' multiple=\"multiple\" size=\"10\"><option value=\"Equipment\">Equipment</option>";
			GetEquipment($topic_id);
			echo "</select>";
			break;
		case 'ict':
			echo "<select id='ict' multiple=\"multiple\" size=\"10\"><option value=\"ICT\">ICT</option>";
			GetIct();
			echo "</select>";
			break;
		case 'citizenship':
			echo "<select id='citizenship' multiple=\"multiple\" size=\"10\"><option value=\"Citizenship\">Citizenship</option>";
			GetCitizenship();
			echo "</select>";
			break;
		case 'risk_assessment':
			echo "<select id='risk_assessment' multiple=\"multiple\" size=\"10\"><option value=\"Risk Assessment\">Risk Assessment</option>";
			GetRisk_Assessment();
			echo "</select>";
			break;
		case 'numeracy':
			echo "<select id='numeracy' multiple=\"multiple\" size=\"10\"><option value=\"Numeracy\">Numeracy</option>";
			GetNumeracy();
			echo "</select>";
			break;
		case 'keywords':
			echo "<select id='keywords' multiple=\"multiple\" size=\"10\"><option value=\"Keywords\">Keywords</option>";
			GetKeywords($topic_id);
			echo "</select>";
			break;
		case 'lesson_part':
			echo "<select id='lesson_part_".$element_num."' onchange=\"GetData('content',".$element_num.")\"><option value=\"Lesson Part\">Lesson Part</option>";
			GetLessonParts($topic_id);
			echo "</select>";
			break;
		case 'content':
			echo "<select id='content_".$element_num."' onchange=\"GetData('point',".$element_num.")\"><option value=\"Content\">Content</option>";
			GetContent($topic_id,$level_id,$theme_id,$lesson_part_id);
			echo "</select>";
			break;
		case 'point':
			echo "<select id='point_".$element_num."' onchange=\"GetData('strand',".$element_num.")\"><option value=\"Teaching Point\">Teaching Point</option>";
			GetContentPoint($content_id);
			echo "</select>";
			break;
		case 'strand':
			echo "<select id='point_".$element_num."' onchange=\"GetData('time',".$element_num.")\"><option value=\"Strand\">Strand</option>";
			GetContentStrand($content_id);
			echo "</select>";
			break;
	}
} 
function PutData($id,$put_data,$what_to_add,$what_to_add_id,$progression_num,$level)
{
	if ($put_data=="evaluation")
	{
		$topic_id=$what_to_add_id;
		$theme_id=$progression_num;
		$sql="insert into topic_theme_evaluation (topic_id,theme_id,evaluation_id,level) values ($topic_id,$theme_id,$id,$level)";
		$insert=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
		$select_name = $what_to_add."_in";
		$select_sql="select id,evaluation from evaluation left join topic_theme_evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where topic_id=$topic_id and theme_id=$theme_id and level=$level";
	}
	elseif ($put_data=="topic") 
		{$table = "topic_".$what_to_add; $table_id = $what_to_add."_id";$topic_id=$id;
		$sql="insert into $table (topic_id,".$what_to_add."_id) values (".$topic_id.",".$what_to_add_id.")";
		$select_name = $what_to_add."_in";
		$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
		$select_sql = "select * from $what_to_add left join $table on $table.$table_id = id where $table.topic_id = $topic_id";
		if ($what_to_add=="theme") $select_sql = "select distinct(theme_id),theme.theme from topic_theme left join theme on topic_theme.theme_id=theme.id where topic_theme.topic_id = $topic_id";
		} 
	else {
		$content_id=$id;
		$id_field=$put_data."_id";
		if ($put_data=="progression"){ $what_to_add="progression_point";
			$table=$put_data."_point";
			$sql="insert into progression_point (progression_id,point_id) values (".$id.",".$what_to_add_id.")";
			$select_name = "progression_point_in[".$progression_num."]";
			$select_sql="select * from point left join progression_point on progression_point.point_id=id where progression_point.progression_id=$id";
			}
		elseif ($what_to_add=="easy_differentiation") 
			{ $table=$put_data."_differentiation"; 
			  $table_id = "differentiation_id";
			  $sql="insert into $table ($id_field,differentiation_id) values (".$id.",".$what_to_add_id.")"; 
			  $select_name = $what_to_add."_in";
			  $select_sql="select * from differentiation left join $table on $table.$table_id = id where $table.$id_field = $id and difficulty='e'";}
		elseif ($what_to_add=="hard_differentiation") 
			{ $table=$put_data."_differentiation"; 
			  $table_id = "differentiation_id";
			  $sql="insert into $table ($id_field,differentiation_id) values (".$id.",".$what_to_add_id.")"; 
			  $select_name = $what_to_add."_in";
			  $select_sql="select * from differentiation left join $table on $table.$table_id = id where $table.$id_field = $id and difficulty='h'";}
		else { $table = $put_data."_".$what_to_add;$table_id = $what_to_add."_id"; 
		$sql="insert into $table ($id_field,".$what_to_add."_id) values (".$id.",".$what_to_add_id.")";
		$select_sql = "select * from $what_to_add left join $table on $table.$table_id = id where $table.$id_field = $id";
		$select_name = $what_to_add."_in";
}
		$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
		}
	echo "<select name='".$select_name."' id='".$select_name."' size='10'>";
	$get_data = mysql_query($select_sql) or die("Error reported while executing the statement: $select_sql<br />MySQL reported: ".mysql_error()); 
	while (list($id,$name)=mysql_fetch_array($get_data)){
	if ($what_to_add=="theme")  {?>
<option onclick="GetLevel(<?php echo $id.",".$topic_id?>)" value=<?php echo $id?>><?php echo $name?></option>
<?php } elseif ($what_to_add=="evaluation")  {$description=unserialize($name);$name='';foreach ($description as $description_line)
{if ($description_line) $name=$name." ".$description_line;}
echo "<option value=".$id." ondblclick=\"RemoveEvaluation(".$id.",".$topic_id.",".$theme_id.",".$level.")\">".$name."</option>";
 } else	echo "<option value=".$id.">".$name."</option>";
	}
	echo "</select>";
}
function PutManyData($id,$put_data,$what_to_add,$what_to_add_ids,$progression_num,$level)
{
	if ($put_data=="evaluation")
	{
		$topic_id=$what_to_add_id;
		$theme_id=$progression_num;
		$sql="insert into topic_theme_evaluation (topic_id,theme_id,evaluation_id,level) values ($topic_id,$theme_id,$id,$level)";
		$insert=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
		$select_name = $what_to_add."_in";
		$select_sql="select id,evaluation from evaluation left join topic_theme_evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where topic_id=$topic_id and theme_id=$theme_id and level=$level";
	}
	elseif ($put_data=="topic")
		{$add_ids=explode(',',$what_to_add_ids);
                foreach ($add_ids as $what_to_add_id) {
                $table = "topic_".$what_to_add; $table_id = $what_to_add."_id";$topic_id=$id;
		$sql="insert into $table (topic_id,".$what_to_add."_id) values (".$topic_id.",".$what_to_add_id.")";
		$select_name = $what_to_add."_in";
		$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
		$select_sql = "select * from $what_to_add left join $table on $table.$table_id = id where $table.topic_id = $topic_id";
		if ($what_to_add=="theme") $select_sql = "select distinct(theme_id),theme.theme from topic_theme left join theme on topic_theme.theme_id=theme.id where topic_theme.topic_id = $topic_id";
		} }
	else {
		$content_id=$id;
		$id_field=$put_data."_id";
		if ($put_data=="progression"){ $what_to_add="progression_point";
			$table=$put_data."_point";
			$sql="insert into progression_point (progression_id,point_id) values (".$id.",".$what_to_add_id.")";
			$select_name = "progression_point_in[".$progression_num."]";
			$select_sql="select * from point left join progression_point on progression_point.point_id=id where progression_point.progression_id=$id";
			}
		elseif ($what_to_add=="easy_differentiation")
			{ $table=$put_data."_differentiation";
			  $table_id = "differentiation_id";
			  $sql="insert into $table ($id_field,differentiation_id) values (".$id.",".$what_to_add_id.")";
			  $select_name = $what_to_add."_in";
			  $select_sql="select * from differentiation left join $table on $table.$table_id = id where $table.$id_field = $id and difficulty='e'";}
		elseif ($what_to_add=="hard_differentiation")
			{ $table=$put_data."_differentiation";
			  $table_id = "differentiation_id";
			  $sql="insert into $table ($id_field,differentiation_id) values (".$id.",".$what_to_add_id.")";
			  $select_name = $what_to_add."_in";
			  $select_sql="select * from differentiation left join $table on $table.$table_id = id where $table.$id_field = $id and difficulty='h'";}
		else { $table = $put_data."_".$what_to_add;$table_id = $what_to_add."_id";
		$sql="insert into $table ($id_field,".$what_to_add."_id) values (".$id.",".$what_to_add_id.")";
		$select_sql = "select * from $what_to_add left join $table on $table.$table_id = id where $table.$id_field = $id";
		$select_name = $what_to_add."_in";
}
		$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
		}
	echo "<select name='".$select_name."' id='".$select_name."' size='10'>";
	$get_data = mysql_query($select_sql) or die("Error reported while executing the statement: $select_sql<br />MySQL reported: ".mysql_error());
	while (list($id,$name)=mysql_fetch_array($get_data)){
	if ($what_to_add=="theme")  {?>
<option onclick="GetLevel(<?php echo $id.",".$topic_id?>)" value=<?php echo $id?>><?php echo $name?></option>
<?php } elseif ($what_to_add=="evaluation")  {$description=unserialize($name);$name='';foreach ($description as $description_line)
{if ($description_line) $name=$name." ".$description_line;}
echo "<option value=".$id." ondblclick=\"RemoveEvaluation(".$id.",".$topic_id.",".$theme_id.",".$level.")\">".$name."</option>";
 } else	echo "<option value=".$id.">".$name."</option>";
	}
	echo "</select>";
}
function RemoveEvaluation($id,$topic_id,$theme_id,$level)
{
    $sql="delete from topic_theme_evaluation where topic_id=$topic_id and theme_id=$theme_id and evaluation_id=$id and level=$level";
	$insert=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	$select_sql="select id,evaluation from evaluation left join topic_theme_evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where topic_id=$topic_id and theme_id=$theme_id and level=$level";
        echo "<select name='evaluation_in' id='evaluation_in' size='10'>";
	$get_data = mysql_query($select_sql) or die("Error reported while executing the statement: $select_sql<br />MySQL reported: ".mysql_error()); 
	while (list($id,$name)=mysql_fetch_array($get_data)){
	$description=unserialize($name);$name='';foreach ($description as $description_line)
            {if ($description_line) $name=$name." ".$description_line;}
            echo "<option value=".$id." ondblclick=\"RemoveEvaluation(".$id.",".$topic_id.",".$theme_id.",".$level.")\">".$name."</option>";
            echo "</select>";
        }
}
function RemoveData($id,$remove_data,$what_to_remove,$what_to_remove_id,$progression_num,$level)
{
	if ($remove_data=="evaluation")
	{
		$topic_id=$what_to_remove_id;
		$theme_id=$progression_num;
		$sql="delete from topic_theme_evaluation where topic_id=$topic_id and theme_id=$theme_id and evaluation_id=$id and level=$level";
		$insert=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
		$select_name = $what_to_remove."_in";
		$select_sql="select id,evaluation from evaluation left join topic_theme_evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where topic_id=$topic_id and theme_id=$theme_id and level=$level";
	}
	elseif ($remove_data=="topic") 
		{	$table = "topic_".$what_to_remove; 
			$table_id = $what_to_remove."_id";
			$topic_id=$id;
			$select_name = $what_to_remove."_in";
			$sql="delete from $table where topic_id=$topic_id and ".$what_to_remove."_id = ".$what_to_remove_id;
			$delete = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
			$select_sql = "select * from $what_to_remove left join $table on $table.$table_id = id where $table.topic_id = $topic_id";
				if ($what_to_remove=="theme") $select_sql = "select distinct(theme_id),theme.theme from topic_theme left join theme on topic_theme.theme_id=theme.id where topic_theme.topic_id = $topic_id";
		} 
	else {
		$table_id = $what_to_remove."_id";
		$content_id=$id;
		$id_field=$remove_data."_id";
		if ($what_to_remove=="easy_differentiation")
			{ 	$table=$remove_data."_differentiation";
				$table_id="differentiation_id";
			    $select_name = $what_to_remove."_in";
				$sql="delete from $table where $id_field=$id and differentiation_id = ".$what_to_remove_id;
				$select_sql="select * from differentiation left join $table on $table.$table_id = id where $table.$id_field = $id and difficulty='e'";
			}	
		elseif ($what_to_remove=="hard_differentiation")
			{ 	$table=$remove_data."_differentiation";
				$table_id="differentiation_id";
			    $select_name = $what_to_remove."_in";
				$sql="delete from $table where $id_field=$id and differentiation_id = ".$what_to_remove_id;
				$select_sql="select * from differentiation left join $table on $table.$table_id = id where $table.$id_field = $id and difficulty='h'";
			}	
		elseif ($remove_data=="progression") 
			{	$what_to_remove="point";
				$table = $what_to_remove; 
				$sql="delete from progression_point where progression_id=$id and ".$what_to_remove."_id = ".$what_to_remove_id;
				$select_name = "progression_point_in[".$progression_num."]";
				$select_sql = "select * from $what_to_remove left join progression_point on progression_point.point_id = id where progression_point.progression_id = $id";
			} 
		else 
			{	$table = $remove_data."_".$what_to_remove; 
				$sql="delete from $table where $id_field=$id and ".$what_to_remove."_id = ".$what_to_remove_id;
				$select_sql = "select * from $what_to_remove left join $table on $table.$table_id = id where $table.$id_field = $id"; 
			} 
		}
	$delete = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
	echo "<select name='".$select_name."' id='".$select_name."' size='10'>";
	$get_data = mysql_query($select_sql) or die("Error reported while executing the statement: $select_sql<br />MySQL reported: ".mysql_error()); 
	while (list($id,$name)=mysql_fetch_array($get_data)){
	if (($what_to_remove=="theme") AND ($topic_id)) {?>
<option onclick="GetLevel(<?php echo $id.",".$topic_id?>)" value=<?php echo $id?>><?php echo $name?></option>
<?php } elseif ($what_to_remove=="evaluation")  {$description=unserialize($name);$name='';foreach ($description as $description_line)
{if ($description_line) $name=$name." ".$description_line;}
echo "<option value=".$id." ondblclick=\"RemoveEvaluation(".$topic_id.",'evaluation',".$id.",".$theme_id.",".$level.")\">".$name."</option>";
 } else	echo "<option value=".$id.">".$name."</option>";
	}
	echo "</select>";
}
function RemoveManyData($id,$remove_data,$what_to_remove,$what_to_remove_ids,$progression_num,$level)
{
	if ($remove_data=="evaluation")
	{
		$topic_id=$what_to_remove_id;
		$theme_id=$progression_num;
		$sql="delete from topic_theme_evaluation where topic_id=$topic_id and theme_id=$theme_id and evaluation_id=$id and level=$level";
		$insert=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
		$select_name = $what_to_remove."_in";
		$select_sql="select id,evaluation from evaluation left join topic_theme_evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where topic_id=$topic_id and theme_id=$theme_id and level=$level";
	}
	elseif ($remove_data=="topic")
		{      $remove_ids=explode(',',$what_to_remove_ids);
                        foreach ($remove_ids as $what_to_remove_id) {
                        $table = "topic_".$what_to_remove;
			$table_id = $what_to_remove."_id";
			$topic_id=$id;
			$select_name = $what_to_remove."_in";
			$sql="delete from $table where topic_id=$topic_id and ".$what_to_remove."_id = ".$what_to_remove_id;
			$delete = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
			$select_sql = "select * from $what_to_remove left join $table on $table.$table_id = id where $table.topic_id = $topic_id";
				if ($what_to_remove=="theme") $select_sql = "select distinct(theme_id),theme.theme from topic_theme left join theme on topic_theme.theme_id=theme.id where topic_theme.topic_id = $topic_id";
                        }}
	else {
		$table_id = $what_to_remove."_id";
		$content_id=$id;
		$id_field=$remove_data."_id";
		if ($what_to_remove=="easy_differentiation")
			{ 	$table=$remove_data."_differentiation";
				$table_id="differentiation_id";
			    $select_name = $what_to_remove."_in";
				$sql="delete from $table where $id_field=$id and differentiation_id = ".$what_to_remove_id;
				$select_sql="select * from differentiation left join $table on $table.$table_id = id where $table.$id_field = $id and difficulty='e'";
			}
		elseif ($what_to_remove=="hard_differentiation")
			{ 	$table=$remove_data."_differentiation";
				$table_id="differentiation_id";
			    $select_name = $what_to_remove."_in";
				$sql="delete from $table where $id_field=$id and differentiation_id = ".$what_to_remove_id;
				$select_sql="select * from differentiation left join $table on $table.$table_id = id where $table.$id_field = $id and difficulty='h'";
			}
		elseif ($remove_data=="progression")
			{	$what_to_remove="point";
				$table = $what_to_remove;
				$sql="delete from progression_point where progression_id=$id and ".$what_to_remove."_id = ".$what_to_remove_id;
				$select_name = "progression_point_in[".$progression_num."]";
				$select_sql = "select * from $what_to_remove left join progression_point on progression_point.point_id = id where progression_point.progression_id = $id";
			}
		else
			{	$table = $remove_data."_".$what_to_remove;
				$sql="delete from $table where $id_field=$id and ".$what_to_remove."_id = ".$what_to_remove_id;
				$select_sql = "select * from $what_to_remove left join $table on $table.$table_id = id where $table.$id_field = $id";
			}
		}
	$delete = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	echo "<select name='".$select_name."' id='".$select_name."' size='10'>";
	$get_data = mysql_query($select_sql) or die("Error reported while executing the statement: $select_sql<br />MySQL reported: ".mysql_error());
	while (list($id,$name)=mysql_fetch_array($get_data)){
	if (($what_to_remove=="theme") AND ($topic_id)) {?>
<option onclick="GetLevel(<?php echo $id.",".$topic_id?>)" value=<?php echo $id?>><?php echo $name?></option>
<?php } elseif ($what_to_remove=="evaluation")  {$description=unserialize($name);$name='';foreach ($description as $description_line)
{if ($description_line) $name=$name." ".$description_line;}
echo "<option value=".$id." ondblclick=\"RemoveEvaluation(".$topic_id.",'evaluation',".$id.",".$theme_id.",".$level.")\">".$name."</option>";
 } else	echo "<option value=".$id.">".$name."</option>";
	}
	echo "</select>";
}
function RemoveThemeLevel($topic_id,$theme_id,$level)
{
    $sql="delete from topic_theme where topic_id=$topic_id and theme_id = $theme_id and level=$level";
    $delete = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
    $select_sql = "select distinct(theme_id),theme.theme from topic_theme left join theme on topic_theme.theme_id=theme.id where topic_theme.topic_id = $topic_id";
    $get_data = mysql_query($select_sql) or die("Error reported while executing the statement: $select_sql<br />MySQL reported: ".mysql_error());
	echo "<select name='theme_in' id='theme_in' size='10'>";
        while (list($id,$name)=mysql_fetch_array($get_data)){
        echo "<option onclick=GetLevel(".$id.",".$topic_id.") value=".$id.">".$name."</option>";
        }
        echo "</select>";
}
function ChooseSomethingToEdit($what)
{
	$sql="select * from $what order by name";
	$whatdata=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList($what,$whatdata);
}		
function ChooseContentToEdit($what,$topic_id)
{
	$sql="select * from content where content_id IN (select content_id from content_topic where topic_id=$topic_id) order by name";
        //$sql="select content.content_id,name,level_id from content left join content_topic on content_topic.content_id=content.content_id left join content_level on content_level.content_id=content.content_id where content_topic.topic_id = $topic_id order by name";
		$whatdata=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList($what,$whatdata);
}		
function ChooseObjectiveToEdit($what,$topic_id)
{
	$sql="select * from objectives where id IN (select objectives_id from topic_objectives where topic_id=$topic_id) order by objective";
	$whatdata=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList($what,$whatdata);
}
function ChooseObjectiveToEdit2014($what)
{
	$sql="select objectives.id,objective from objectives where nc='y' order by objective, objectives.id";
	$whatdata=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	CreateList($what,$whatdata);
}
function GetStrandLevel($objective_id,$topic_id)
{
	$currentlysetsql="select strand_id,level_id from topic_objectives where topic_id=$topic_id and objectives_id=$objective_id";
	$currentsetdata=mysql_query($currentlysetsql) or die("Error reported while executing the statement: $currentlysetsql<br />MySQL reported: ".mysql_error());
	list ($set_strand_id,$set_level_id)=mysql_fetch_array($currentsetdata);
	$sql="select id,strand from strand";
	$stranddata=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	echo "<td><select name='strand' id='strand' size='1'><option onclick='UpdateStrand(this.value,".$objective_id.",".$topic_id.")' value=0>select strand</option>";
	while (list($strand_id,$strand)=mysql_fetch_array($stranddata)){
		if ($set_strand_id==$strand_id) {
		echo "<option onclick='UpdateStrand(this.value,".$objective_id.",".$topic_id.")' value=".$strand_id." selected>".$strand."</option>";}
		else {
		echo "<option onclick='UpdateStrand(this.value,".$objective_id.",".$topic_id.")' value=".$strand_id.">".$strand."</option>";}
	}
	echo "</td>";
	$sql="select id from level";
	$leveldata=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	echo "<td><select name='level' id='level' size='1'><option onclick='UpdateLevel(this.value,".$objective_id.",".$topic_id.")' value=0>select level</option>";
	while (list($level_id)=mysql_fetch_array($leveldata)){
		if ($set_level_id==$level_id) {
		echo "<option onclick='UpdateObjectiveLevel(this.value,".$objective_id.",".$topic_id.")' value=".$level_id." selected>".$level_id."</option>";}
		else {
		echo "<option onclick='UpdateObjectiveLevel(this.value,".$objective_id.",".$topic_id.")' value=".$level_id.">".$level_id."</option>";}
	}
	echo "</td>";
}
function UpdateStrandLevel($what,$id,$objective_id,$topic_id)
{
	$what_id=$what."_id";
	$sql="update topic_objectives set $what_id = $id where topic_id=$topic_id and objectives_id=$objective_id";	
	$updatedata=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	echo $sql;
}
function UpdateThemeLevel($id,$theme_id,$topic_id)
{
	$sql="update topic_theme set level = $id where topic_id=$topic_id and theme_id=$theme_id";	
	$updatedata=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	echo $sql."<br>".$updatedata;
}
function GetLevel($theme_id,$topic_id)
{
	$currentlysetsql="select level from topic_theme where topic_id=$topic_id and theme_id=$theme_id";
	$currentsetdata=mysql_query($currentlysetsql) or die("Error reported while executing the statement: $currentlysetsql<br />MySQL reported: ".mysql_error());
	list ($set_level_id)=mysql_fetch_array($currentsetdata);
	$sql="select id from level";
	$leveldata=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	echo "<td><select name='level' id='level' size='4'>";
	while (list($level_id)=mysql_fetch_array($leveldata)){
		if ($level_id==$set_level_id) {
		echo "<option onclick='GetThemeImportance(this.value,".$theme_id.",".$topic_id.")' value=".$level_id." selected>".$level_id."</option>";
		} else {
		echo "<option onclick='GetThemeImportance(this.value,".$theme_id.",".$topic_id.")' value=".$level_id.">".$level_id."</option>"; }
	}
	echo "</td><td><input type='button' id='remove_level' id='remove_level' onclick='RemoveFromLevel(".$topic_id.",".$theme_id.")' value='remove' /></td>";
}
function GetThemeImportance($theme_id,$topic_id,$level)
{
	$currentlysetsql="select importance from topic_theme where topic_id=$topic_id and theme_id=$theme_id and level=$level";
	$currentsetdata=mysql_query($currentlysetsql) or die("Error reported while executing the statement: $currentlysetsql<br />MySQL reported: ".mysql_error());
	$row="<table width='200'><tr>";
	list ($set_importance)=mysql_fetch_array($currentsetdata);
	$cell="<td><input type='text' id='importance' name='importance' value='".$set_importance."'><input type='button' value='next' onclick='GetThemeNotes(".$level.",".$theme_id.",".$topic_id.")'></td>";
	$row=$row.$cell;
  	$row=$row."</tr></table>";
	echo $row;
}
function GetThemeNotes($theme_id,$topic_id,$level,$importance)
{
	$currentlysetsql="select notes from topic_theme where topic_id=$topic_id and theme_id=$theme_id and level=$level";
	$currentsetdata=mysql_query($currentlysetsql) or die("Error reported while executing the statement: $currentlysetsql<br />MySQL reported: ".mysql_error());
	$row="<table width='200'>";
	list ($notes_in)=mysql_fetch_array($currentsetdata);
        if (checkBase64Encoded($notes_in)) $notes_out=unserialize(base64_decode($notes_in));
        else $notes_out=unserialize($notes_in);
//	$cell="<td><textarea id='notes' name='notes' cols='50' rows='5'>".$notes."</textarea></td>";
        $cell.="<tr><td><input type=\"text\" name=\"notes[0]\" size=\"128\" value=\"".stripslashes($notes_out[0])."\"/></td></tr>";
        $cell.="<tr><td><input type=\"text\" name=\"notes[1]\" size=\"128\" value=\"".stripslashes($notes_out[1])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[2]\" size=\"128\" value=\"".stripslashes($notes_out[2])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[3]\" size=\"128\" value=\"".stripslashes($notes_out[3])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[4]\" size=\"128\" value=\"".stripslashes($notes_out[4])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[5]\" size=\"128\" value=\"".stripslashes($notes_out[5])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[6]\" size=\"128\" value=\"".stripslashes($notes_out[6])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[7]\" size=\"128\" value=\"".stripslashes($notes_out[7])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[8]\" size=\"128\" value=\"".stripslashes($notes_out[8])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[9]\" size=\"128\" value=\"".stripslashes($notes_out[9])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[10]\" size=\"128\" value=\"".stripslashes($notes_out[10])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[11]\" size=\"128\" value=\"".stripslashes($notes_out[11])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[12]\" size=\"128\" value=\"".stripslashes($notes_out[12])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[13]\" size=\"128\" value=\"".stripslashes($notes_out[13])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[14]\" size=\"128\" value=\"".stripslashes($notes_out[14])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[15]\" size=\"128\" value=\"".stripslashes($notes_out[15])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[16]\" size=\"128\" value=\"".stripslashes($notes_out[16])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[17]\" size=\"128\" value=\"".stripslashes($notes_out[17])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[18]\" size=\"128\" value=\"".stripslashes($notes_out[18])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[19]\" size=\"128\" value=\"".stripslashes($notes_out[19])."\"/></td></tr>";
        $cell.="<tr><td><input type=\"text\" name=\"notes[20]\" size=\"128\" value=\"".stripslashes($notes_out[20])."\"/></td></tr>";
        $cell.="<tr><td><input type=\"text\" name=\"notes[21]\" size=\"128\" value=\"".stripslashes($notes_out[21])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[22]\" size=\"128\" value=\"".stripslashes($notes_out[22])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[23]\" size=\"128\" value=\"".stripslashes($notes_out[23])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[24]\" size=\"128\" value=\"".stripslashes($notes_out[24])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[25]\" size=\"128\" value=\"".stripslashes($notes_out[25])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[26]\" size=\"128\" value=\"".stripslashes($notes_out[26])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[27]\" size=\"128\" value=\"".stripslashes($notes_out[27])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[28]\" size=\"128\" value=\"".stripslashes($notes_out[28])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[29]\" size=\"128\" value=\"".stripslashes($notes_out[29])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[30]\" size=\"128\" value=\"".stripslashes($notes_out[30])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[31]\" size=\"128\" value=\"".stripslashes($notes_out[31])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[32]\" size=\"128\" value=\"".stripslashes($notes_out[32])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[33]\" size=\"128\" value=\"".stripslashes($notes_out[33])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[34]\" size=\"128\" value=\"".stripslashes($notes_out[34])."\"/></td></tr>";
	$cell.="<tr><td><input type=\"text\" name=\"notes[35]\" size=\"128\" value=\"".stripslashes($notes_out[35])."\"/></td></tr>";
	$row=$row.$cell;
  	$row=$row."</tr><tr><td><input type='button' value='next' onclick='GetThemeEvaluation(".$level.",".$theme_id.",".$topic_id.")'</td></tr></table>";
	echo $row;
}
function GetThemeEvaluation($theme_id,$topic_id,$level,$importance)
{
//	$currentlysetsql="select evaluation from topic_theme where topic_id=$topic_id and theme_id=$theme_id and level=$level";
	$currentlysetsql="select id,evaluation from evaluation left join topic_theme_evaluation on evaluation.id=topic_theme_evaluation.evaluation_id where topic_id=$topic_id and theme_id=$theme_id and level=$level";
	$currentsetdata=mysql_query($currentlysetsql) or die("Error reported while executing the statement: $currentlysetsql<br />MySQL reported: ".mysql_error());
	$availablesql="select id,evaluation from evaluation";
	$availabledata=mysql_query($availablesql) or die("Error reported while executing the statement: $availablesql<br />MySQL reported: ".mysql_error());
	$row="<table width='200'><tr>";
        $evaluation='';
//	list ($evaluation)=mysql_fetch_array($currentsetdata);
//	$cell="<td><textarea id='evaluation' name='evaluation' cols='50' rows='5'>".$evaluation."</textarea></td>";
	$selectto="<select name='evaluation_in' id='evaluation_in' multiple='multiple' size='10'>";
        $evaluation='';
		while (list($id,$evaluation_in) = mysql_fetch_array($currentsetdata))
		{
			$evaluation='';
                        $description=unserialize($evaluation_in);
                        foreach ($description as $description_line) {if ($description_line) $evaluation=$evaluation." ".$description_line;}
                        $selectto=$selectto."<option value=".$id." ondblclick=\"RemoveEvaluation(".$id.",".$topic_id.",".$theme_id.",".$level.")\">".$evaluation."</option>";
 		} 
	$cellto="<td id='evaluation_in_cell'>".$selectto."</select></td>";
	$row=$row.$cellto;
	$selectfrom="<select name='evaluation_out' id='evaluation_out' multiple='multiple' size='10'>";
		while (list($id,$evaluation_in) = mysql_fetch_array($availabledata))
		{
			$evaluation='';
                        $description=unserialize($evaluation_in);
                        foreach ($description as $description_line) {if ($description_line) $evaluation=$evaluation." ".$description_line;}
			$selectfrom=$selectfrom."<option value=".$id." ondblclick=\"AddEvaluation(".$topic_id.",'evaluation',".$id.",".$theme_id.",".$level.")\">".$evaluation."</option>";
 		} 
	$cellfrom="<td id='evaluation_out_cell'>".$selectfrom."</select></td>";
	$row=$row.$cellfrom;
  	$row=$row."</tr><tr><td><input name=\"theme\" type=\"hidden\" value=".$theme_id." /></td><td><input type='button' value='save' onclick='UpdateThemeLevelImportanceNotes(".$level.",".$theme_id.",".$topic_id.",".$importance.")'</td></tr></table>";
	echo $row;
}
function UpdateThemeLevelImportanceNotes()
{
	$level=$_POST['level'];
        $theme_id=$_POST['theme'];
        $topic_id=$_POST['topic_id'];
        $importance=$_POST['importance'];
        $notes=base64_encode(serialize($_POST['notes']));
        $sql="delete from topic_theme where topic_id = $topic_id and theme_id = $theme_id and level=$level";
	$data = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
	$sql="insert into topic_theme (topic_id, theme_id, level, importance, notes) values ($topic_id, $theme_id, $level, $importance, '$notes')";
	$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
	echo("<meta http-equiv=\"Refresh\" content=\"0;url=/tplan/DB_Maintenance/topic.php?mode=look&topic_id=".$topic_id."\">");
}
function DeleteTableItem($table,$id)
{
	$deletesql="delete from $table where id=$id";
	if ($table=='help') $deletesql="delete from help where name='$id'";
	if($table=='objectives') sub_delete('objective',$id);
	$deleteresult=mysql_query($deletesql) or die("Error reported while executing the statement: $deletesql<br />MySQL reported: ".mysql_error());
	echo $deleteresult;
}
// add to multi
function sub_delete($table_name,$id)
{
		switch($table_name){
			case 'objective':
			$j==3;
			$sub_table[0]='year';
			$sub_table[1]='strand';
			$sub_table[2]='topic_theme';
			for($i = 0;$i < $j;$i++){
				$sql="delete from ".$table_name."_".$sub_table[$i]." where ".$table_name."_id=".$id;
				$result=mysql_query($sql) or die(mysql_error());}
			break;
			}
			
}
function SaveUnitofWork($topic_id,$level_id,$num_lessons,$description)
{
	$teacher_id=$_SESSION['id'];
	$savesql="insert into unit_of_work (description, topic_id, level_id, teacher_id, num_lessons) values ('$description',$topic_id,$level_id,$teacher_id,$num_lessons)";
	$saveresult=mysql_query($savesql) or die("Error reported while executing the statement: $savesql<br />MySQL reported: ".mysql_error());
	echo mysql_insert_id();
}
function CreatePlan($theme_id, $description, $objectives_arr, $content_arr, $equipment, $keywords, $ICT, $numeracy, $sen, $citizenship, $risk_assessment, $uow_id)
{
	$createplansql="insert into plan (uow_id, theme_id, description, objectives, content, equipment, literacy_keywords, ICT, numeracy, sen, citizenship, risk_assessment) values ($uow_id, $theme_id, '$description', '$objectives_arr', '$content_arr', '$equipment', '$keywords', '$ICT', '$numeracy', '$sen', '$citizenship', '$risk_assessment')";
	$createplanresult=mysql_query($createplansql) or die("Error reported while executing the statement: $createplansql<br />MySQL reported: ".mysql_error());
}
function GetGenres($point_id)
{
	$sql="select id,description from genre";
	$result=mysql_query($sql);
	while (list($genre_id,$genre_description)=mysql_fetch_array($result)) {
	if ($point_id!=0) {$sql1="select genre_id from point where id=$point_id";list($point_genre_id)=mysql_fetch_array(mysql_query($sql1));}
	if ($point_genre_id==$genre_id) echo "<option selected=\"selected\" value=".$genre_id.">".$genre_description."</option>";
	else echo "<option value=".$genre_id.">".$genre_description."</option>";
	}
}
function GetObjectiveStrands($objective_id)
{
	if($objective_id!=0){
		$sql1="select strand_id from objective_strand where objective_id=$objective_id";
		$result1=mysql_query($sql1) or die(mysql_error());
		while(list($strand_id)=mysql_fetch_array($result1)){
			$strands[]=$strand_id;
		}
	}
	$sql="select id,strand from strand";
	$result=mysql_query($sql) or die(mysql_error());
	echo "<table>";
	while(list($strand_id,$strand)=mysql_fetch_array($result)){
		echo "<tr><td><input type='checkbox' name='strand_id[]' value=".$strand_id;
		if(in_array($strand_id,$strands)) echo " checked ";
		echo "></td><td><input type='text' size=128 value='".$strand."'></td></tr>";
	}
	echo "</table>";
}
function Update_objectives_strand($strands,$objective_id)
{
        $sql="delete from objective_strand where objective_id = $objective_id";
	$data = mysql_query($sql);
        if (is_array($strands)) {
		foreach ($strands as $strand)
			{
			do_the_update_objectives_strand($strand,$objective_id);
			}
		}
	else {
			$strand=$strands;
			do_the_update_objectives_year($strand,$objective_id);
		}

}
function do_the_update_objectives_strand($strand,$objective_id)
{
	$sql="insert into objective_strand (objective_id,strand_id) values ($objective_id,$strand)";
	$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
}
function Update_objectives_year($years,$objective_id)
{
        $sql="delete from objective_year where objective_id = $objective_id";
	$data = mysql_query($sql);
        if (is_array($years)) {
		foreach ($years as $year)
			{
			do_the_update_objectives_year($year,$objective_id);
			}
		}
	else {
			$year=$years;
			do_the_update_objectives_year($year,$objective_id);
		}

}
function do_the_update_objectives_year($year,$objective_id)
{
	$sql="insert into objective_year (objective_id,year) values ($objective_id,$year)";
	$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
}
function Update_theme_objectives($themes,$objective_id)
{
        $sql="delete from theme_objective where objective_id = $objective_id";
	$data = mysql_query($sql);
        if (is_array($themes)) {
		foreach ($themes as $theme_id)
			{
			do_the_update_theme_objectives($theme_id,$objective_id);
			}
		}
	else {
			$theme_id=$themes;
			do_the_update_theme_objectives($theme_id,$objective_id);
		}

}
function do_the_update_theme_objectives($theme_id,$objective_id)
{
	$sql="insert into theme_objective (theme_id,objective_id) values ($theme_id,$objective_id)";
	$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
}
function Update_topic_objectives($topics,$objective_id)
{
        $sql="delete from objective_topic where objective_id = $objective_id";
		$data = mysql_query($sql);
        if (is_array($topics)) {
		foreach ($topics as $topic_id)
			{
			do_the_update_topic_objectives($topic_id,$objective_id);
			}
		}
	else {
			$topic_id=$topics;
			do_the_update_topic_objectives($topic_id,$objective_id);
		}

}
function do_the_update_topic_objectives($topic_id,$objective_id)
{
	$sql="insert into objective_topic (topic_id,objective_id) values ($topic_id,$objective_id)";
	$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
}
function Update_genre_objectives($genres,$objective_id)
{
        $sql="delete from genre_objective where objective_id = $objective_id";
	$data = mysql_query($sql);
        if (is_array($genres)) {
		foreach ($genres as $genre_id)
			{
			do_the_update_genre_objectives($genre_id,$objective_id);
			}
		}
	else {
			$genre_id=$genres;
			do_the_update_theme_objectives($genre_id,$objective_id);
		}

}
function do_the_update_genre_objectives($genre_id,$objective_id)
{
	$sql="insert into genre_objective (genre_id,objective_id) values ($genre_id,$objective_id)";
	$insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error()); 
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
function ChoosePlanToMaintain()
{
	$sql="select id,description from unit_of_work where teacher_id=999999 order by description";
	$whatdata=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	while (list($what_id,$what_name) = mysql_fetch_array($whatdata))
	{
		if (!$what_name) $what_name=$what_id;
		echo "<option value=".$what_id.">".$what_name."</option>";
 	} 
}	
function save_set_plan()
{
	$description=$_POST['description'];
	$topic_id=$_POST['topic_id'];
	$level=$_POST['level'];
	for ($i=1;$i<=12;$i++)
	{
		$get_old_plan=mysql_query("select set_plan_id from set_plans where topic_id=$topic_id and level=$level and num_lessons=$i");
		list ($old_plan_id)=mysql_fetch_array($get_old_plan);
		$remove_old_plan=mysql_query("delete from set_plans where topic_id=$topic_id and level=$level and num_lessons=$i");
		$sql="insert into set_plans (topic_id,level,num_lessons) values ($topic_id,$level,$i)";
		$create_set_plan=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
		$set_plan_id=mysql_insert_id();
		$set_plan="set_plan_".$i;
                $lesson_number=0;
		for ($o=1;$o<=15;$o++)
			{
                                $field_id=$o."_".$i;
                                $lesson_id=$_POST[$field_id];
                                $field_name=$_POST[$field_id]."_".$i;
                                if ($_POST[$field_name])
                                {
                                    
                                    $lesson_num=$_POST[$field_name];
                                    if ($old_plan_id)
						{
							$remove_lessons=mysql_query("delete from set_plan_lessons where set_plan_id=$old_plan_id and lesson_num=$lesson_num");
						}
					$sql2="insert into set_plan_lessons (set_plan_id,lesson_id,lesson_num) values ($set_plan_id,$lesson_id,$lesson_num)";
					$create_set_lesson=mysql_query($sql2) or die("Error reported while executing the statement: $sql2<br />MySQL reported: ".mysql_error());
				$lesson_number++;
                                }
                        if ($lesson_number==$i) break;
			}
	}
}

function upload_content($topic)
{
  if ($_FILES['content_file']['tmp_name'])
  {
    $stream=fopen($_FILES['content_file']['tmp_name'],'r');
    $test=stream_get_contents($stream);
    // print the array of the csv file.
    //print_r(csvstring_to_array($test));
    $data_array=csvstring_to_array($test);
    for ($j=0;$j<count($data_array);$j++)
    {
        //print $data_array[$j][0]."<br>";
        $name=addslashes($data_array[$j][0]);
        $data_type="activity";
        $p=0;
        for ($i=1;$i<=count($data_array[$j]);$i++)
        {
            //print $data_array[$j][$i]."<br>";
            if ($data_array[$j][$i]=="progression")
            {
                $data_type="progression";
                $i++;
                $p++;
            }
            if ($data_type=="activity")
            {
                if ($data_array[$j][$i]) $sql_array[]=$data_array[$j][$i];
            }
            if ($data_type=="progression")
            {
                if ($data_array[$j][$i]) $prog_array[$p][]=$data_array[$j][$i];
            }
            
        }
        $sql_update=base64_encode(serialize($sql_array));
        unset($sql_array);
        $sql_update_string="insert into content (name,description) values ('$name','$sql_update')";
        $insert = mysql_query($sql_update_string) or die("Error reported while executing the statement: $sql_update_string<br />MySQL reported: ".mysql_error());
	list($content_id) = mysql_fetch_array(mysql_query("select last_insert_id()"));
        UpdateContentElements("topic",$topic,$content_id);
	for($r=1;$r<=4;$r++)
        {
            if ($prog_array[$r])
            {
                $prog_update[$r]=base64_encode(serialize($prog_array[$r]));
                $sql="insert into progression (progression) value ('$prog_update[$r]')";
                $insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
                $progression_id = mysql_insert_id();
                $sql="insert into content_progression (content_id, progression_id) value ($content_id, $progression_id)";
                $insert = mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
            }
            unset($prog_array[$r]);
        }
        print "Inserting ".$name."<br>";
        
        
    }
  }
}
function csvstring_to_array($string, $CSV_SEPARATOR = ',', $CSV_ENCLOSURE = '"', $CSV_LINEBREAK = "\n")
{
    $array1 = array();
    $array2= array();
    $array1=preg_split('#'.$CSV_LINEBREAK.'#',$string);
    for($i=0;$i<count($array1);$i++){
        for($o=0;$o<strlen($array1[$i]);$o++){
            if(preg_match('#^'.$CSV_ENCLOSURE.'#',substr($array1[$i],$o))){
                if(!preg_match('#^"(([^'.
                    $CSV_ENCLOSURE.']*('.
                    $CSV_ENCLOSURE.$CSV_ENCLOSURE
                    .')?[^'.$CSV_ENCLOSURE.']*)*)'.
                    $CSV_ENCLOSURE.$CSV_SEPARATOR.'#i',substr($array1[$i],$o,
                    strlen($array1[$i])),$mot)){
                        $mot[1]=substr(substr($array1[$i],$o,strlen($array1[$i])),1,-1);
                    }$o++;$o++;
            }
            else{if(!preg_match('#^([^'.$CSV_ENCLOSURE.$CSV_SEPARATOR.']*)'.$CSV_SEPARATOR.'#i',substr($array1[$i],$o,strlen($array1[$i])),$mot))
                    {
                    $mot[1]=substr($array1[$i],$o,strlen($array1[$i]));
                    }
                }
            $o=$o+strlen($mot[1]);
            $array2[$i][]=str_replace($CSV_ENCLOSURE.$CSV_ENCLOSURE,$CSV_ENCLOSURE,$mot[1]);
        }
    }
    return $array2;
}
function Re_Order_Points($content_id,$topic_id)
{
     for ($i=0;$i<$_POST['num_points'];$i++)
    {
        $point_num=$_POST['point_num'][$i];
        $point_id=$_POST['point_id'][$i];
        $sql="update content_point set point_num=$point_num where point_id=$point_id and content_id=$content_id";
        $reorder=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
    }
}
function get_objective_themes($objective_id,$topic_id)
{
	$year_sql="select year from objective_year where objective_id=$objective_id";
	$year_result=mysql_query($year_sql) or die(mysql_error());
	while(list($year)=mysql_fetch_array($year_result)){
		$years[]=$year;
	}
	foreach($years as $year){
	$level=year_to_level($year);
	$sql="select * from theme left join topic_theme on theme.id=theme_id where topic_id=$topic_id and level=$level order by theme.theme";
	$result=mysql_query($sql) or die($sql."<br>".mysql_error());
	$sql1="select theme_id from objective_topic_theme where objective_id=$objective_id and topic_id=$topic_id";
	$result1 = mysql_query($sql1) or die($sql1."<br>".mysql_error());
	if($result1) {
		while (list($theme_id)=mysql_fetch_array($result1)){
			$themes[]=$theme_id;
		}
	}
	echo "<table><tr><td><input type='hidden' name='year[]' value=".$year."></td><td><label>'Year ".$year."'</label></td></tr><tr><td><input type='hidden' name='topic_id' value=".$topic_id."></td></tr>";
	while(list($id,$theme,$description,$top_id,$theme_id,$level,$importance,$notes)=mysql_fetch_array($result)){
		echo "<tr><td><input type='checkbox' name='theme_id_".$year."[]' ";
		if(in_array($id,$themes)) echo " checked ";
		echo " value=".$id."></td>".
			 "<td><input type='text' size = '64' value='".$theme."'></td>".
			 "<td><input type='hidden' size = '1024' value='".$notes."' name='theme_notes_".$year."'></td></tr>";
	}
	echo "</table>";
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
?>
