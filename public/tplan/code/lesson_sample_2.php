<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/../library/tplan_config.php');
header('Content-Type: text/html; charset=ISO-8859-1');
if ($_GET['topic']=="football"){
    $lesson_num=12;
    $uow_id=29129;
}
if ($_GET['topic']=="hockey"){
    $lesson_num=1;
    $uow_id=29584;
}
if ($_GET['topic']=="cricket"){
    $lesson_num=1;
    $uow_id=3888;
}
if ($_GET['topic']=="tennis"){
    $lesson_num=1;
    $uow_id=28953;
}
if ($_GET['topic']=="rounders"){
    $lesson_num=1;
    $uow_id=29342;
}
if ($_GET['topic']=="athletics"){
    $lesson_num=1;
    $uow_id=29403;
}
if ($_GET['topic']=="gymnastics"){
    $lesson_num=1;
    $uow_id=3459;
}
include('lessonfunctions_2.php');
// reset variables
    $strContent='';
   
function ClearlessonSessionVars($lesson_num)
{
    $_SESSION[$lesson_num]['level']='';
    $_SESSION[$lesson_num]['title']='';
    $_SESSION[$lesson_num]['mysubject']='';
    $_SESSION[$lesson_num]['school']='';
    $_SESSION[$lesson_num]['name']='';
    $_SESSION[$lesson_num]['assistance']='';
    $_SESSION[$lesson_num]['theme']='';
    $_SESSION[$lesson_num]['teacher_notes_arr']='';
    $_SESSION[$lesson_num]['evaluation_arr']='';
    $_SESSION[$lesson_num]['objectives']='';
    $_SESSION[$lesson_num]['keywords']='';
    $_SESSION[$lesson_num]['icts']='';
    $_SESSION[$lesson_num]['numeracys']='';
    $_SESSION[$lesson_num]['citizenships']='';
    $_SESSION[$lesson_num]['risk_assessments']='';
    $_SESSION[$lesson_num]['equipment']='';
    $_SESSION[$lesson_num]['activities']='';
    $_SESSION[$lesson_num]['strands']='';
    $_SESSION[$lesson_num]['teaching_points']='';
    $_SESSION[$lesson_num]['hard_differentiations']='';
    $_SESSION[$lesson_num]['easy_differentiations']='';
    $_SESSION[$lesson_num]['progressions']='';
    $_SESSION[$lesson_num]['num_progs']='';
    $_SESSION[$lesson_num]['prog_points']='';
    $_SESSION[$lesson_num]['analysess']='';
    $_SESSION[$lesson_num]['anal_points']='';
    $summaryContent='';
    $activityContent[]='';
    $plenaryContent[]='';
    $actContent[]='';
    $evaluation_string='';
    $keywords_string='';
    $citizenships_string='';
    $numeracys_string='';
    $risk_assessments_string='';
    $icts_string='';
    $teacher_notes_string='';
    $content_string='';
    $equipment='';
    $old_difficulty='';
}
$file=basename(tempnam('/tmp','tmp'));
rename('/tmp/'.$file,FILE_ROOT.'/tmp/'.$file.'.pdf');
$htmlFile=FILE_ROOT.'/tmp/'.$file.'.html';
$pdfFile=FILE_ROOT.'/tmp/'.$file.'.pdf';
$browsePDF='../tmp/'.$file.'.pdf';
$pdfIn=fopen($htmlFile,'w') or die("can't open the file $htmlFile");
$pdfOut=fopen($pdfFile,'w') or die("can't open the file $pdfFile");
fclose($pdfOut);
$doc_header="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">
<html>
    <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=ISO-8859-1\">
        <title>Plan</title>
        <style>
            @page { size: A4 landscape;margin: 2pt 2pt 2pt 2pt }
        </style>
    </head>
    <body>";
$strContent=$strContent.$doc_header;

// get some data

if($lesson_num==0) {
    $print_all = "y";
    $num_lessons=GetNumLessons($uow_id);
    $lesson_num=1;
}
else {$num_lessons=$lesson_num;}
while($lesson_num<=$num_lessons){
ClearLessonSessionVars($lesson_num);
GetPrintContent($lesson_num,$uow_id);
//echo $uow_id." - ".$lesson_num;
//print_r($_SESSION[$lesson_num]);
$num_acts[$lesson_num]=mysqli_num_rows($_SESSION[$lesson_num]['activities']);
$equipment_arr=Array();
for ($act_num=1;$act_num<=$num_acts[$lesson_num];$act_num++)
{
    $activity_equipment=mysqli_fetch_array($_SESSION[$lesson_num]['equipment']);
    if ($activity_equipment) {
        if ($activity_equipment['equipment']) {
            if (!in_array($activity_equipment['equipment'],$equipment_arr)) {
            if (!isset($equipment)) $equipment=$activity_equipment['equipment'];
            else $equipment=$equipment.", ".$activity_equipment['equipment'];
            $equipment_arr[]=$activity_equipment['equipment'];}
            }
    }
//    print_r(mysqli_fetch_array($_SESSION[$lesson_num]['progressions'][$act_num]));
}
if((isset($print_all)=='y')&&($lesson_num==1)) $table_def="<TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=0>";
elseif (isset($print_all)=='y') $table_def="<TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=0 STYLE=\"page-break-before: always\">";
else $table_def="<TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=0>";
$summaryContent=$table_def;
$summaryContent=$summaryContent."
    <TR>
            <TD width=33%><img src=\"/img/bnb_logo_wide.jpg\" border=none
 style='background-repeat:repeat-y; top: 0;  z-index:-1; position:absolute;'></TD>
            <TD WIDTH=5% style='font-size: 12px; font-weight:bold; color:white;'>
			Name :
		</TD>
            <TD WIDTH=12% style='font-size: 12px; color:white;'>".
$_SESSION[$lesson_num]['name'].
           "</TD>
            <TD WIDTH=5% style='font-size: 12px; font-weight:bold; color:white;'>
			School :
		</TD>
            <TD WIDTH=12% style='font-size: 12px; color:white;'>".
$_SESSION[$lesson_num]['school'].
           "</TD>".
            //<TD width=33% align='right'><a href=\"send_pdf.php?file=".$file."&orientation=landscape\"><img src=\"../index_files/icon_printer.jpg\" border=none alt='create PDF file' title='create PDF file'></a><a href=\"/tplan/Lessons.php?unit_id=".$uow_id."&plan_type=".$plan_type."\"><img src=\"../index_files/icon_edit.jpg\" border=none alt='edit plan' title='edit plan'></a><a href=\"/tplan/main.php\"><img src=\"../index_files/icon_home.jpg\" border=none alt='return to start page' title='return to start page'></a></TD>
        "</TR>
    </TABLE>
<BR><BR><BR>
  <div style='padding-left:20px; padding-right:10px;'>
    <TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=0 CELLSPACING=0>
            <TR>
            	<TD WIDTH=10% style='background:#85b52d; color:white; font-weight:bold; font-size: 10px;'>
			Topic
		</TD>
		<TD WIDTH=10% style='font-size:10px;'>".
$_SESSION[$lesson_num]['mysubject'].
                "</TD>
                <TD WIDTH=5% style='background:#85b52d; color:white; font-weight:bold; font-size: 10px;'>
			Year
		</TD>
		<TD WIDTH=2% style='font-size:10px;'>".
level_to_year($_SESSION[$lesson_num]['level']).
                "</TD>
		<TD WIDTH=5% style='background:#85b52d; color:white; font-weight:bold; font-size: 10px;'>
			Theme
		</TD>
		<TD WIDTH=20% style='font-size:10px;'>".
$_SESSION[$lesson_num]['theme'].
		"</TD>
                <TD WIDTH=5% style='background:#85b52d; color:white; font-weight:bold; font-size: 10px;'>
			Title
		</TD>
		<TD WIDTH=48% style='font-size:10px;'>".
$_SESSION[$lesson_num]['title'].
                "</TD>
		
	</TR>
	<TR>
	<TD WIDTH=10% style='background:#85b52d; color:white; font-weight:bold; font-size: 10px;'>
			Learning Objectives
	</TD>
	<TD WIDTH=86% COLSPAN=7 VALIGN=TOP style='font-size: 10px;'>";
        $objectives_string="<ol style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
        while (list ($objective_id,$objective)=mysqli_fetch_array($_SESSION[$lesson_num]['objectives']))
		{
                    $objectives_string=$objectives_string."<li>".$objective."</li>";
                }
                $objectives_string=$objectives_string."</ol>";
$summaryContent=$summaryContent.$objectives_string.
		"</TD>
	</TR>
    </TABLE>
<BR>
    <TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0>
	<TR>
		
		
		<TD WIDTH=13% VALIGN=TOP style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>
			Teaching Assistant
		</TD>
		<TD WIDTH=20% VALIGN=TOP style='font-size:10px;'>";
 list($ta,$sen)=mysqli_fetch_array($_SESSION[$lesson_num]['assistance']); if ($ta) $summaryContent=$summaryContent.$ta; else $summaryContent=$summaryContent."none selected";
$summaryContent=$summaryContent."</TD>
                <TD WIDTH=13% VALIGN=TOP style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>
			Special	Education Needs
		</TD>
		<TD WIDTH=20% VALIGN=TOP style='font-size:10px;'>";
if ($sen) $summaryContent=$summaryContent.$sen; else $summaryContent=$summaryContent."none selected";
$summaryContent=$summaryContent."</TD>
	</TR>
    </TABLE>
<BR>
    <TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0>
	<TR VALIGN=TOP>
		<TD WIDTH=10% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>
			Literacy Keywords
		</TD>
		<TD WIDTH=23% style='font-size:10px;'>";
 if ($_SESSION[$lesson_num]['keywords']!='')
    {
		$item_num=1;
		while (list ($keyword_id,$keyword)=mysqli_fetch_array($_SESSION[$lesson_num]['keywords']))
		{
			if ($item_num==1) $keywords_string=$keyword;
			else $keywords_string=$keywords_string.", ".$keyword;
			$item_num++;
		}
	
	}
        else $keywords_string=$keywords_string."none selected";
        $summaryContent=$summaryContent.$keywords_string;
$summaryContent=$summaryContent."</TD>
		<TD WIDTH=10% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>
			Citizenship
		</TD>
		<TD WIDTH=23% style='font-size:10px;'>";
 if ($_SESSION[$lesson_num]['citizenships']!='')
    {
		$item_num=1;
		while (list ($citizenship_id,$citizenship)=mysqli_fetch_array($_SESSION[$lesson_num]['citizenships']))
		{
			if ($item_num==1) $citizenships_string=$citizenship;
			else $citizenships_string=$citizenships_string.", ".$citizenship;
			$item_num++;
		}
        
        }
        else $citizenships_string=$citizenships_string."none selected";
        $summaryContent=$summaryContent.$citizenships_string;
$summaryContent=$summaryContent."</TD>
                <TD WIDTH=10% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>
			Numeracy
		</TD>
		<TD WIDTH=23% style='font-size:10px;'>";
 if ($_SESSION[$lesson_num]['numeracys']!='')
    {
		$item_num=1;
		while (list ($numeracy_id,$numeracy)=mysqli_fetch_array($_SESSION[$lesson_num]['numeracys']))
		{
			if ($item_num==1) $numeracys_string=$numeracy;
			else $numeracys_string=$numeracys_string.", ".$numeracy;
			$item_num++;
		}
        
	}
        else $numeracys_string=$numeracys_string."none selected";
        $summaryContent=$summaryContent.$numeracys_string;
$summaryContent=$summaryContent."</TD>
	</TR>
	<TR VALIGN=TOP>
		
		<TD WIDTH=10% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>
			Risk Assessment
		</TD>
		<TD WIDTH=23% style='font-size:10px;'>";
 if ($_SESSION[$lesson_num]['risk_assessments']!='')
    {
		$risk_assessments_string="<ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                while (list ($risk_assessment_id,$risk_assessment)=mysqli_fetch_array($_SESSION[$lesson_num]['risk_assessments']))
		{
			$risk_assessments_string=$risk_assessments_string."<li>".$risk_assessment."</li>";
                }
                $risk_assessments_string=$risk_assessments_string."</ul>";
        }
        else $risk_assessments_string=$risk_assessments_string."none selected";
	
            $summaryContent=$summaryContent.$risk_assessments_string;
$summaryContent=$summaryContent."</TD>
                <TD WIDTH=10% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>
			ICT
		</TD>
                <TD WIDTH=23% VALIGN=TOP style='font-size:10px;'>";
 if ($_SESSION[$lesson_num]['icts']!='')
    {
		$item_num=1;
		while (list ($ict_id,$ict)=mysqli_fetch_array($_SESSION[$lesson_num]['icts']))
		{
                        if ($item_num==1) $icts_string=$ict;
                        else $icts_string=$icts_string.", ".$ict;
                             $item_num++;
                    
		}
	}
else $icts_string="none selected";

$summaryContent=$summaryContent.$icts_string;

$summaryContent=$summaryContent."</TD>
                <TD WIDTH=10% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>
			Equipment
		</TD>
		<TD WIDTH=23% VALIGN=TOP style='font-size:10px;'>".
$equipment."
		</TD>
	</TR>
    </TABLE>
<BR>
    <TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0 STYLE=\"page-break-after: always\">
	<TR>
		<TD WIDTH=14% HEIGHT=71 style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>
			Teacher	Notes
		</TD>
		<TD COLSPAN=3 WIDTH=86% VALIGN=TOP style='font-size:10px;'>";
$teacher_notes_arr=$_SESSION[$lesson_num]['teacher_notes_arr'];
$teacher_notes_string="<ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
for ($tn=0 ; $tn < count($teacher_notes_arr) ; $tn++)
	{
		if ($teacher_notes_arr[$tn]) {
                    if (substr($teacher_notes_arr[$tn],0,1)=="^"){
                       $teacher_notes_string=$teacher_notes_string."<li>".sp_utf2ascii(stripslashes(substr($teacher_notes_arr[$tn],1)))."</li>";
                    }
                    else{
                        $teacher_notes_string=$teacher_notes_string."<li>".sp_utf2ascii(stripslashes($teacher_notes_arr[$tn]))."</li>";
                    }
		}
	}
        $teacher_notes_string=$teacher_notes_string."<ul>";
        $summaryContent=$summaryContent.stripslashes($teacher_notes_string);
$summaryContent=$summaryContent."
        </TD>
        </TR>";
$summaryContent=$summaryContent."
    </TABLE>
<BR></div>";
$strContent=$strContent.$summaryContent;
// Activity Content
// for next loop for the actvities
$plenary=1;
$actContent='';
$diagram_titles=Array();
$diagram_images=Array();
for ($act_num=1;$act_num<=$num_acts[$lesson_num];$act_num++)
{
    // set some base stuff
    //$differentiation_str[$act_num]="No differentiation selected for this activity"; //set the strings to a default value in case there isn't anything there
    //$progression_str[$act_num]="No progression selected for this activity";
    //$analyses_str[$act_num]="No analysis selected for this activity";
    $progression_point_arr[$act_num]=Array();
    $num_progs=mysqli_num_rows($_SESSION[$lesson_num]['progressions'][$act_num]); //ascertain how many progressions there are
    $num_anals=mysqli_num_rows($_SESSION[$lesson_num]['analysess'][$act_num]); //ascertain how many anayses there are
    if ($num_progs!=0) mysqli_data_seek($_SESSION[$lesson_num]['progressions'][$act_num],0); // reset the mysql arrays
    if ($num_anals!=0) mysqli_data_seek($_SESSION[$lesson_num]['analysess'][$act_num],0);
    $activities=mysqli_fetch_array($_SESSION[$lesson_num]['activities']); // get the activities from the mysql array
    if ($activities['la_time']) $time=$activities['la_time']; else $time=$activities['content_time']; //see if the time has changed
    // check the encoding before unserializing the content description
    if (checkBase64Encoded($activities['content_description']))
	 {$content_line_arr[$act_num]=unserialize(base64_decode($activities['content_description']));	}
    else {$content_line_arr[$act_num]=unserialize($activities['content_description']);}
    // create the content list for this activity
    $content_string[$act_num]="<ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
    for ($i = 0 ; $i < count($content_line_arr[$act_num]) ; $i++)
	{
            if ($content_line_arr[$act_num][$i]){
                if (substr($content_line_arr[$act_num][$i],0,1)=="^"){
                    $content_string[$act_num]=$content_string[$act_num]."<li style='list-style-type: none'> &nbsp; &nbsp;".sp_utf2ascii(stripslashes(substr($content_line_arr[$act_num][$i],1)))."</li>";
                } else {
                    if (strlen($content_line_arr[$act_num][$i])>5) $content_string[$act_num]=$content_string[$act_num]."<li>".sp_utf2ascii(stripslashes($content_line_arr[$act_num][$i]))."</li>";
                }
            }
        }
        $content_string[$act_num]=$content_string[$act_num]."</ul>"; //close the content list
    //check if this is a plenary, we need to treat that differently
    if ($activities['lesson_part']!="Plenary")
    {
        // it isn't so we create an activity string for this activity
        $activityContent[$act_num]="<TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0 STYLE=\"page-break-inside: avoid\"><TR VALIGN=TOP><TD WIDTH=15% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>".
        $activities['lesson_part']."</TD><TD WIDTH=20% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>".
        sp_utf2ascii(stripslashes($activities['content_name']));
        // if there is a diagram put a link to it on the title bar
        /**if (file_exists("/var/www/html/peplanning/public/tplan/diagrams/".$activities['activity_id'].".gif"))
        {
            $activityContent[$act_num]=$activityContent[$act_num]."  -  <a href=\"../diagrams/".$activities['activity_id'].".gif\" target=_blank>diagram</a>";
            $diagram_titles[]=sp_utf2ascii(stripslashes($activities['content_name']));
            $diagram_images[]="../diagrams/".$activities['activity_id'].".gif";
        }**/
	// build the content for this activity adding the rows and celss for the table
        $activityContent[$act_num]=$activityContent[$act_num]."</TD><TD WIDTH=15% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>";
        if ($_SESSION[$lesson_num]['strands'][$act_num])
        {
            // there are so create a list for them
            $strand_str[$act_num]="Strand : ";
                while ($strands=mysqli_fetch_array($_SESSION[$lesson_num]['strands'][$act_num]))
                {
                    if ($strands['strand']) $strand_str[$act_num]=$strand_str[$act_num]." ".$strands['strand'];
                }
        }
        $activityContent[$act_num]=$activityContent[$act_num]."</TD><TD WIDTH=10% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>Duration : ".$time."</TD><TD WIDTH=40% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>Teaching Points</TD></TR><TR VALIGN=TOP><TD";
        if (file_exists("/var/www/html/peplanning/public/tplan/diagrams/".$activities['activity_id'].".gif"))
  $activityContent[$act_num]=$activityContent[$act_num]." ROWSPAN=3";
        $activityContent[$act_num]=$activityContent[$act_num]." COLSPAN=4 WIDTH=60% style='font-size:10px;'>".$content_string[$act_num]."</TD><TD WIDTH=34% style='font-size:10px;'>";
        //check if there are some teaching points
        if ($_SESSION[$lesson_num]['teaching_points'][$act_num])
        {
            // there are so create the list for them
            $teaching_points_str[$act_num]="<ul style='margin-left: -20px;#display:inline;#margin-left: 0px;'>";
                while ($teaching_points=mysqli_fetch_array($_SESSION[$lesson_num]['teaching_points'][$act_num]))
                {
                    if ($teaching_points['point']) $teaching_points_str[$act_num]=$teaching_points_str[$act_num]."<li>".sp_utf2ascii(stripslashes($teaching_points['point']))."</li>";
                }
            $teaching_points_str[$act_num]=$teaching_points_str[$act_num]."</ul>"; // close the list
        }
         if (file_exists(APPLICATION_BASE."/public/tplan/diagrams/".$activities['activity_id'].".gif"))
            {
            $teaching_points_str[$act_num]=$teaching_points_str[$act_num]."</TD><TR><TD WIDTH=40% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>Diagram</TD></TR><TR><TD><img src='/tplan/diagrams/".$activities['activity_id'].".gif' width='350' height='200'></TD></TR>";
            }
         else $teaching_points_str[$act_num]=$teaching_points_str[$act_num]."</TD>";
        // build the content for this activity adding the rows and celss for the table
        $activityContent[$act_num]=$activityContent[$act_num].$teaching_points_str[$act_num];
        //check if there are some strands
        // build the content for this activity adding the rows and celss for the table
        
        $activityContent[$act_num]=$activityContent[$act_num]."</TD></TR>";
        if (mysqli_num_rows($_SESSION[$lesson_num]['progressions'][$act_num])!=0)
        {
            $progression_str[$act_num]="<TR VALIGN=TOP><TD COLSPAN=4 WIDTH=55% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>Progression</TD><TD WIDTH=45% style='background:#85b52d; color:white; font-size: 10px;font-weight:bold;'>Teaching Points</TD></TR>";
                //                while ($progressions=mysqli_fetch_array($_SESSION[$lesson_num]['progressions'][$act_num]))
                for ($j=0;$j<$num_progs;$j++)
                {
                    $progression_str[$act_num]=$progression_str[$act_num]."<TR VALIGN=TOP><TD COLSPAN=4 WIDTH=55% style='font-size:10px;'><ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                    $progressions=mysqli_fetch_array($_SESSION[$lesson_num]['progressions'][$act_num]);
                    if (checkBase64Encoded($progressions['progression']))
                        {$progression_line_arr[$act_num]=unserialize(base64_decode($progressions['progression']));	}
                    else {$progression_line_arr[$act_num]=unserialize($progressions['progression']);}
                    for ($i = 0 ; $i < count($progression_line_arr[$act_num]) ; $i++)
                        {
                            if ($progression_line_arr[$act_num][$i])
                             if (strlen($progression_line_arr[$act_num][$i])>5) $progression_str[$act_num]=$progression_str[$act_num]."<li>".sp_utf2ascii(stripslashes($progression_line_arr[$act_num][$i]))."</li>";
                        }
                     $progression_str[$act_num]=$progression_str[$act_num]."</ul></TD>";
                     if ($_SESSION[$lesson_num]['prog_points'][$act_num][$j])
                        {
                           $progression_str[$act_num]=$progression_str[$act_num]."<TD WIDTH=45% style='font-size:10px;'><ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                           while ($prog_points=mysqli_fetch_array($_SESSION[$lesson_num]['prog_points'][$act_num][$j]))
                                {
                                   if ($prog_points['point'])
                                   {
                                        if (!in_array($prog_points['point'],$progression_point_arr[$act_num]))
                                        {
                                            $progression_str[$act_num]=$progression_str[$act_num]."<li>".sp_utf2ascii(stripslashes($prog_points['point']))."</li>";
                                        }
                                    }
                                }
                        }
                      $progression_str[$act_num]=$progression_str[$act_num]."</ul></TD></TR>";
                }
                $activityContent[$act_num]=$activityContent[$act_num].$progression_str[$act_num];
        }
        // Check for hard differentiations
        if (mysqli_num_rows($_SESSION[$lesson_num]['hard_differentiations'][$act_num])!=0)
        {
                // go through the differentiaions
                $hard_differentiation_str[$act_num]="<TR VALIGN=TOP><TD WIDTH=100% COLSPAN=5 style='background:#85b52d; color:white;font-weight:bold; font-size:10px;'>To make activity harder</TD></TR><TR VALIGN=TOP><TD COLSPAN=5 WIDTH=100% style='font-size:10px;'><ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                while ($hard_differentiations=mysqli_fetch_array($_SESSION[$lesson_num]['hard_differentiations'][$act_num]))
                    {
                        $hard_differentiation_str[$act_num]=$hard_differentiation_str[$act_num]."<li>".$hard_differentiations['differentiation']."</li>";
                    }
            $hard_differentiation_str[$act_num]=$hard_differentiation_str[$act_num]."</ul></TD></TR>";
        }
        $activityContent[$act_num]=$activityContent[$act_num].$hard_differentiation_str[$act_num];
        if (mysqli_num_rows($_SESSION[$lesson_num]['easy_differentiations'][$act_num])!=0)
        {
                // go through the differentiaions
                $easy_differentiation_str[$act_num]="<TR VALIGN=TOP><TD WIDTH=100% COLSPAN=5 style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>To make activity easier</TD></TR><TR VALIGN=TOP><TD COLSPAN=5 WIDTH=100% style='font-size:10px;'><ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                while ($easy_differentiations=mysqli_fetch_array($_SESSION[$lesson_num]['easy_differentiations'][$act_num]))
                    {
                        $easy_differentiation_str[$act_num]=$easy_differentiation_str[$act_num]."<li>".$easy_differentiations['differentiation']."</li>";
                    }
            $easy_differentiation_str[$act_num]=$easy_differentiation_str[$act_num]."</ul>";
        }
        $activityContent[$act_num]=$activityContent[$act_num].$easy_differentiation_str[$act_num];
        $activityContent[$act_num]=$activityContent[$act_num]."</TD></TR>";;
        if (mysqli_num_rows($_SESSION[$lesson_num]['analysess'][$act_num])!=0)
        {
            $j=0;
            while ($analysess=mysqli_fetch_array($_SESSION[$lesson_num]['analysess'][$act_num]))
                {
                    $analyses_str[$act_num]="</TD></TR><TR VALIGN=TOP><TD WIDTH=15% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>Analysis</TD><TD COLSPAN=4 WIDTH=85% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>".
                    sp_utf2ascii(stripslashes($analysess['analysis_title']))."</TD></TR>";
                    if (checkBase64Encoded($analysess['analysis']))
                        {$analyses_line_arr[$act_num]=unserialize(base64_decode($analysess['analysis']));	}
                    else {$analyses_line_arr[$act_num]=unserialize($analysess['analysis']);}
                    //while(list ($anal_point_id,$anal_point)=mysqli_fetch_array($_SESSION[$lesson_num]['anal_points'][$act_num][$j]))
                    //{
                    //    $anal_points[]=$anal_point;
                    //}
                    $analyses_str[$act_num]=$analyses_str[$act_num]."<TR VALIGN=TOP><TD WIDTH=100% COLSPAN=5 style='font-size:10px;'><ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                    for ($i = 0 ; $i <= count($analyses_line_arr[$act_num]) ; $i++)
                        {
                            if ($analyses_line_arr[$act_num][$i])
                            {
                             if (substr($analyses_line_arr[$act_num][$i],0,1)=="^")
                             {
                                $analyses_str[$act_num]=$analyses_str[$act_num]."<li> &nbsp; &nbsp;".sp_utf2ascii(stripslashes(substr($analyses_line_arr[$act_num][$i],1)))."</li>";
                             }
                             elseif (substr($analyses_line_arr[$act_num][$i],0,2)=='A.')
                             {
                                $analyses_str[$act_num]=$analyses_str[$act_num]."<li><i> - ".sp_utf2ascii(stripslashes(substr($analyses_line_arr[$act_num][$i],3)))."</i></li>";
                             }
                             elseif (substr($analyses_line_arr[$act_num][$i],0,2)=='Q.')
                             {
                                 $analyses_str[$act_num]=$analyses_str[$act_num]."<li>".sp_utf2ascii(stripslashes(substr($analyses_line_arr[$act_num][$i],3)))."</li>";
                             }
                             else
                             {
                                 $analyses_str[$act_num]=$analyses_str[$act_num]."<li>".sp_utf2ascii(stripslashes($analyses_line_arr[$act_num][$i]))."</li>";
                             }
                            }
                        }
                        $analyses_str[$act_num]=$analyses_str[$act_num]."</ul>";
                    $j++;
                }
           $activityContent[$act_num]=$activityContent[$act_num].$analyses_str[$act_num]."</TD></TR>";
        }
    $activityContent[$act_num]=$activityContent[$act_num]."</TD></TR></TABLE><BR>";
// this is the end of the plenary if-else
    }
    else {
        $activityContent[$act_num]="<TR><TD><TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0 STYLE=\"page-break-inside: avoid\"><TR VALIGN=TOP><TD WIDTH=30% COLSPAN=1 style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>".
        $activities['lesson_part']."</TD><TD WIDTH=70% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>Teaching Points</TD></TR></TR>";
        $activityContent[$act_num]=$activityContent[$act_num]."<TR VALIGN=TOP><TD WIDTH=30% style='font-size:10px;'>".
        $activities['content_name']."</TD><TD WIDTH=70% style='font-size:10px;'>";
        if ($_SESSION[$lesson_num]['teaching_points'][$act_num])
        {
            $teaching_points_str[$act_num]="<ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                while ($teaching_points=mysqli_fetch_array($_SESSION[$lesson_num]['teaching_points'][$act_num]))
                    {
                        if ($teaching_points['point']) $teaching_points_str[$act_num]=$teaching_points_str[$act_num]."<li>".sp_utf2ascii(stripslashes($teaching_points['point']))."</li>";
                    }
                $teaching_points_str[$act_num]=$teaching_points_str[$act_num]."</ul>";
        }
        $activityContent[$act_num]=$activityContent[$act_num].$teaching_points_str[$act_num]."</TD></TR>";
        $activityContent[$act_num]=$activityContent[$act_num]."</TABLE><BR>";
    }
    
    $actContent=$actContent.$activityContent[$act_num];
}
$strContent=$strContent.$actContent;
$strContent=$strContent."
    <TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0>
	<TR VALIGN=TOP>
		<TD WIDTH=100% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>
		Evaluation
                </TD>
        </TR>
        <TR VALIGN=TOP>
		<TD WIDTH=100% style='font-size:10px;'>";
$evaluation_arr=$_SESSION[$lesson_num]['evaluation_arr'];
$evaluation_string="  ".sp_utf2ascii(stripslashes($evaluation_arr[0]))."<br>";
for ($e=1 ; $e < count($evaluation_arr) ; $e++)
	{
		if ($evaluation_arr[$e]) {
		$evaluation_string=$evaluation_string."  -  <i>".sp_utf2ascii(stripslashes($evaluation_arr[$e]))."</i><br>";
		}
	}
        $strContent=$strContent.$evaluation_string;
$strContent=$strContent."</TD>
        </TR>
    </TABLE>
<BR>";
/**if($diagram_titles){

    $strContent=$strContent."<TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0 STYLE=\"page-break-before: always\">
	<TR>
		<TD WIDTH=33%% HEIGHT=5% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>"
			 .$diagram_titles[0].
		"</TD>
                <TD WIDTH=33%% HEIGHT=5% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>"
			.$diagram_titles[1].
		"</TD>
                <TD WIDTH=33%% HEIGHT=5% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>"
			.$diagram_titles[2].
		"</TD>
       </TR>
       <TR>
                <TD WIDTH=33%% HEIGHT=45% align=center valign=middle>";
			if ($diagram_images[0]) $strContent=$strContent."<img src='".$diagram_images[0]."' width='350' height='200'>";
		$strContent=$strContent."</TD>
                <TD WIDTH=33%% HEIGHT=45% align=center valign=middle>";
			if ($diagram_images[1]) $strContent=$strContent."<img src='".$diagram_images[1]."' width='350' height='200'>";
		$strContent=$strContent."</TD>
                <TD WIDTH=33%% HEIGHT=45% align=center valign=middle>";
			if ($diagram_images[2]) $strContent=$strContent."<img src='".$diagram_images[2]."' width='350' height='200'>";
		$strContent=$strContent."</TD>
        </TR>
	<TR>
		<TD WIDTH=33%% HEIGHT=5% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>"
			 .$diagram_titles[3].
		"</TD>
                <TD WIDTH=33%% HEIGHT=5% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>"
			.$diagram_titles[4].
		"</TD>
                <TD WIDTH=33%% HEIGHT=5% style='background:#85b52d; color:white; font-weight:bold; font-size:10px;'>"
			.$diagram_titles[5].
		"</TD>
       </TR>
       <TR>
                <TD WIDTH=33%% HEIGHT=45% align=center valign=middle>";
			if ($diagram_images[3]) $strContent=$strContent."<img src='".$diagram_images[3]."' width='350' height='200'>";
		$strContent=$strContent."</TD>
                <TD WIDTH=33%% HEIGHT=45% align=center valign=middle>";
			if ($diagram_images[4]) $strContent=$strContent."<img src='".$diagram_images[4]."' width='350' height='200'>";
		$strContent=$strContent."</TD>
                <TD WIDTH=33%% HEIGHT=45% align=center valign=middle>";
			if ($diagram_images[5]) $strContent=$strContent."<img src='".$diagram_images[5]."' width='350' height='200'>";
		$strContent=$strContent."</TD>
        </TR>
    </TABLE>";
}**/
$lesson_num++;
}
$strContent=$strContent."</body>
</html>
";// Send it to the screen
fwrite($pdfIn,$strContent);
fclose($pdfIn);
//echo $strContent;
if ($_GET['topic']=="demo") echo ("window.open('code/send_pdf.php?file=$file&orientation=landscape');");
//if ($_GET['topic']=="demo") echo ("alert('here');");
else echo $strContent;
// Clean up after ourselves
CleanFiles(FILE_ROOT."tmp/");
?>