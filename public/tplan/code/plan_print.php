<?
if(ereg( "MSIE", $_SERVER['HTTP_USER_AGENT'])){
session_cache_limiter('private');
}
header('Content-Type: text/html; charset=ISO-8859-1');
include ("session.php");
$lesson_num=$_GET['lesson_num'];
$uow_id=$_GET['unit_id'];
if ($_GET['first_print']==1) $plan_type="setPlanPrint";
else $plan_type="newPlan";
$ajax=$_GET['ajax'];
include('basefunctions.php');
// reset variables
$strContent='';
$pdfContent='';
$summaryContent='';
$activityContent='';
$_SESSION['level']='';
$_SESSION['mysubject']='';
//$_SESSION['school']='';
$_SESSION['name']='';
$_SESSION['assistance']='';
$_SESSION['theme']='';
$_SESSION['teacher_notes_arr']='';
$_SESSION['evaluation_arr']='';
$_SESSION['objectives']='';
$_SESSION['keywords']='';
$_SESSION['icts']='';
$_SESSION['numeracys']='';
$_SESSION['citizenships']='';
$_SESSION['strands']='';
$_SESSION['teaching_points']='';
$_SESSION['differentiations']='';
$_SESSION['progressions']='';
$_SESSION['analysess']='';
$_SESSION['prog_points']='';
$_SESSION['anal_points']='';
$keywords_string='';
$teacher_notes_string='';
$equipment='';
$old_difficulty='';
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
// get some data
GetPrintContent($lesson_num,$uow_id);
$num_acts=mysql_num_rows($_SESSION['activities']);
$equipment_arr=Array();
for ($act_num=1;$act_num<=$num_acts;$act_num++)
{
    $activity_equipment=mysql_fetch_array($_SESSION['equipment']);
    if ($activity_equipment) {
        if ($activity_equipment['equipment']) {
            if (!in_array($activity_equipment['equipment'],$equipment_arr)) {
            if (!$equipment) $equipment=$activity_equipment['equipment'];
            else $equipment=$equipment.", ".$activity_equipment['equipment'];
            $equipment_arr[]=$activity_equipment['equipment'];}
            }
    }
//    print_r(mysql_fetch_array($_SESSION['progressions'][$act_num]));
}
$pdfContent=$pdfContent.$doc_header;
$strContent=$strContent.$doc_header;
$summaryContent="
    <TABLE WIDTH=100% CELLPADDING=0 CELLSPACING=0>
        <TR>
            <TD width=33%><img src=\"../images/logo_letterhead.jpg\" border=none></TD>
            <TD WIDTH=5% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Name :
		</TD>
            <TD WIDTH=12% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>".
$_SESSION['name'].
           "</TD>
            <TD WIDTH=5% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			School :
		</TD>
            <TD WIDTH=12% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>".
$_SESSION['school'].
           "</TD>".
            //<TD width=33% align='right'><a href=\"send_pdf.php?file=".$file."&orientation=landscape\"><img src=\"../index_files/icon_printer.jpg\" border=none alt='create PDF file' title='create PDF file'></a><a href=\"/tplan/Lessons.php?unit_id=".$uow_id."&plan_type=".$plan_type."\"><img src=\"../index_files/icon_edit.jpg\" border=none alt='edit plan' title='edit plan'></a><a href=\"/tplan/main.php\"><img src=\"../index_files/icon_home.jpg\" border=none alt='return to start page' title='return to start page'></a></TD>
        "</TR>
    </TABLE>
<BR>
    <TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=0 CELLSPACING=0>
            <TR>
            	<TD WIDTH=10% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Topic
		</TD>
		<TD WIDTH=10% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>".
$_SESSION['mysubject'].
                "</TD>
                <TD WIDTH=5% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Level
		</TD>
		<TD WIDTH=2% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>".
$_SESSION['level'].
                "</TD>
		<TD WIDTH=5% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Theme
		</TD>
		<TD WIDTH=25% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>".
$_SESSION['theme'].
		"</TD>
                <TD WIDTH=5% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Title
		</TD>
		<TD WIDTH=43% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>".
$_SESSION['title'].
                "</TD>
		
	</TR>
	<TR>
	<TD WIDTH=10% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Learning Objectives
	</TD>
	<TD WIDTH=86% COLSPAN=7 VALIGN=TOP style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>";
        $objectives_string="<ol style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
        while (list ($objective_id,$objective)=mysql_fetch_array($_SESSION['objectives']))
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
		
		
		<TD WIDTH=13% VALIGN=TOP style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Teaching Assistant
		</TD>
		<TD WIDTH=20% VALIGN=TOP style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>";
 list($ta,$sen)=mysql_fetch_array($_SESSION['assistance']); if ($ta) $summaryContent=$summaryContent.$ta; else $summaryContent=$summaryContent."none selected";
$summaryContent=$summaryContent."</TD>
                <TD WIDTH=13% VALIGN=TOP style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Special	Education Needs
		</TD>
		<TD WIDTH=20% VALIGN=TOP style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>";
if ($sen) $summaryContent=$summaryContent.$sen; else $summaryContent=$summaryContent."none selected";
$summaryContent=$summaryContent."</TD>
	</TR>
    </TABLE>
<BR>
    <TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0>
	<TR VALIGN=TOP>
		<TD WIDTH=10% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Literacy Keywords
		</TD>
		<TD WIDTH=23% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>";
 if ($_SESSION['keywords'])
    {
		$item_num=1;
		while (list ($keyword_id,$keyword)=mysql_fetch_array($_SESSION['keywords']))
		{
			if ($item_num==1) $keywords_string=$keyword;
			else $keywords_string=$keywords_string.", ".$keyword;
			$item_num++;
		}
	$summaryContent=$summaryContent.$keywords_string;
	}
        else $summaryContent=$summaryContent."none selected";
$summaryContent=$summaryContent."</TD>
		<TD WIDTH=10% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Citizenship
		</TD>
		<TD WIDTH=23% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>";
 if ($_SESSION['citizenships'])
    {
		$item_num=1;
		while (list ($citizenship_id,$citizenship)=mysql_fetch_array($_SESSION['citizenships']))
		{
			if ($item_num==1) $citizenships_string=$citizenship;
			else $citizenships_string=$citizenships_string.", ".$citizenship;
			$item_num++;
		}
        $summaryContent=$summaryContent.$citizenships_string;
        }
        else $summaryContent=$summaryContent."none selected";
$summaryContent=$summaryContent."</TD>
                <TD WIDTH=10% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Numeracy
		</TD>
		<TD WIDTH=23% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>";
 if ($_SESSION['numeracys'])
    {
		$item_num=1;
		while (list ($numeracy_id,$numeracy)=mysql_fetch_array($_SESSION['numeracys']))
		{
			if ($item_num==1) $numeracys_string=$numeracy;
			else $numeracys_string=$numeracys_string.", ".$numeracy;
			$item_num++;
		}
        $summaryContent=$summaryContent.$numeracys_string;
	}
        else $summaryContent=$summaryContent."none selected";
$summaryContent=$summaryContent."</TD>
	</TR>
	<TR VALIGN=TOP>
		
		<TD WIDTH=10% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Risk Assessment
		</TD>
		<TD WIDTH=23% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>";
 if ($_SESSION['risk_assessments'])
    {
		$risk_assessments_string="<ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                while (list ($risk_assessment_id,$risk_assessment)=mysql_fetch_array($_SESSION['risk_assessments']))
		{
			$risk_assessments_string=$risk_assessments_string."<li>".$risk_assessment."</li>";
                }
                $risk_assessments_string=$risk_assessments_string."</ul>";
        $summaryContent=$summaryContent.$risk_assessments_string;
	}
        else $summaryContent=$summaryContent."none selected";
$summaryContent=$summaryContent."</TD>
                <TD WIDTH=10% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			ICT
		</TD>
                <TD WIDTH=23% VALIGN=TOP style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>";
 if ($_SESSION['icts'])
    {
		$item_num=1;
		while (list ($ict_id,$ict)=mysql_fetch_array($_SESSION['icts']))
		{
			if ($item_num==1) $icts_string=$ict;
			else $icts_string=$icts_string.", ".$ict;
			$item_num++;
		}
	$summaryContent=$summaryContent.$icts_string;
	}
        else $summaryContent=$summaryContent."none selected";
$summaryContent=$summaryContent."</TD>
                <TD WIDTH=10% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Equipment
		</TD>
		<TD WIDTH=23% VALIGN=TOP style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>".
$equipment."
		</TD>
	</TR>
    </TABLE>
<BR>
    <TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0 STYLE=\"page-break-after: always\">
	<TR>
		<TD WIDTH=14% HEIGHT=71 style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
			Teacher	Notes
		</TD>
		<TD COLSPAN=3 WIDTH=86% VALIGN=TOP style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>";
$teacher_notes_arr=$_SESSION['teacher_notes_arr'];
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
<BR>";
$pdfContent=$pdfContent.$summaryContent;
$strContent=$strContent.$summaryContent;
// Activity Content
// for next loop for the actvities
$plenary=1;
$diagram_titles=Array();
$diagram_images=Array();
for ($act_num=1;$act_num<=$num_acts;$act_num++)
{
    // set some base stuff
    //$differentiation_str[$act_num]="No differentiation selected for this activity"; //set the strings to a default value in case there isn't anything there
    //$progression_str[$act_num]="No progression selected for this activity";
    //$analyses_str[$act_num]="No analysis selected for this activity";
    $progression_point_arr[$act_num]=Array();
    $num_progs=mysql_num_rows($_SESSION['progressions'][$act_num]); //ascertain how many progressions there are
    $num_anals=mysql_num_rows($_SESSION['analysess'][$act_num]); //ascertain how many anayses there are
    if ($num_progs!=0) mysql_data_seek($_SESSION['progressions'][$act_num],0); // reset the mysql arrays
    if ($num_anals!=0) mysql_data_seek($_SESSION['analysess'][$act_num],0);
    $activities=mysql_fetch_array($_SESSION['activities']); // get the activities from the mysql array
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
                    $content_string[$act_num]=$content_string[$act_num]."<li style='list-style-type: none'> &nbsp; &nbsp; &#45; &nbsp; &nbsp;".sp_utf2ascii(stripslashes(substr($content_line_arr[$act_num][$i],1)))."</li>";
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
        $activityContent[$act_num]="<TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0 STYLE=\"page-break-inside: avoid\"><TR VALIGN=TOP><TD WIDTH=15% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>".
        $activities['lesson_part']."</TD><TD WIDTH=20% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>".
        sp_utf2ascii(stripslashes($activities['content_name']));
        // if there is a diagram put a link to it on the title bar
        if (file_exists(FILE_ROOT.DIAGRAM_PATH.$activities['activity_id'].".gif"))
        {
            $activityContent[$act_num]=$activityContent[$act_num]."  -  <a href=\"".HOME_URL.DOC_ROOT.DIAGRAM_PATH.$activities['activity_id'].".gif\" target=_blank>diagram</a>";
            $diagram_titles[]=sp_utf2ascii(stripslashes($activities['content_name']));
            $diagram_images[]="../diagrams/".$activities['activity_id'].".gif";
        }
	// build the content for this activity adding the rows and celss for the table
        $activityContent[$act_num]=$activityContent[$act_num]."</TD><TD WIDTH=15% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>";
        if ($_SESSION['strands'][$act_num])
        {
            // there are so create a list for them
            $strand_str[$act_num]="Strand : ";
                while ($strands=mysql_fetch_array($_SESSION['strands'][$act_num]))
                {
                    if ($strands['strand']) $strand_str[$act_num]=$strand_str[$act_num]." ".$strands['strand'];
                }
        }
        $activityContent[$act_num]=$activityContent[$act_num].$strand_str[$act_num]."</TD><TD WIDTH=10% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>Duration : ".$time."</TD><TD WIDTH=40% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>Teaching Points</TD></TR><TR VALIGN=TOP><TD COLSPAN=4 WIDTH=60% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>".
        $content_string[$act_num]."</TD><TD WIDTH=34% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>";
        //check if there are some teaching points
        if ($_SESSION['teaching_points'][$act_num])
        {
            // there are so create the list for them
            $teaching_points_str[$act_num]="<ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                while ($teaching_points=mysql_fetch_array($_SESSION['teaching_points'][$act_num]))
                {
                    if ($teaching_points['point']) $teaching_points_str[$act_num]=$teaching_points_str[$act_num]."<li>".sp_utf2ascii(stripslashes($teaching_points['point']))."</li>";
                }
            $teaching_points_str[$act_num]=$teaching_points_str[$act_num]."</ul>"; // close the list
        }
        // build the content for this activity adding the rows and celss for the table
        $activityContent[$act_num]=$activityContent[$act_num].$teaching_points_str[$act_num]."</TD>";
        //check if there are some strands
        // build the content for this activity adding the rows and celss for the table
        
        $activityContent[$act_num]=$activityContent[$act_num]."</TD></TR>";
        if (mysql_num_rows($_SESSION['progressions'][$act_num])!=0)
        {
            $progression_str[$act_num]="<TR VALIGN=TOP><TD COLSPAN=4 WIDTH=55% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>Progression</TD><TD WIDTH=45% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>Teaching Points</TD></TR>";
                //                while ($progressions=mysql_fetch_array($_SESSION['progressions'][$act_num]))
                for ($j=0;$j<$num_progs;$j++)
                {
                    $progression_str[$act_num]=$progression_str[$act_num]."<TR VALIGN=TOP><TD COLSPAN=4 WIDTH=55% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'><ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                    $progressions=mysql_fetch_array($_SESSION['progressions'][$act_num]);
                    if (checkBase64Encoded($progressions['progression']))
                        {$progression_line_arr[$act_num]=unserialize(base64_decode($progressions['progression']));	}
                    else {$progression_line_arr[$act_num]=unserialize($progressions['progression']);}
                    for ($i = 0 ; $i <= count($progression_line_arr[$act_num]) ; $i++)
                        {
                            if ($progression_line_arr[$act_num][$i])
                            if (strlen($progression_line_arr[$act_num][$i])>5) $progression_str[$act_num]=$progression_str[$act_num]."<li>".sp_utf2ascii(stripslashes($progression_line_arr[$act_num][$i]))."</li>";
                        }
                     $progression_str[$act_num]=$progression_str[$act_num]."</ul></TD>";
                     if ($_SESSION['prog_points'][$act_num][$j])
                        {
                           $progression_str[$act_num]=$progression_str[$act_num]."<TD WIDTH=45% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'><ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                           while ($prog_points=mysql_fetch_array($_SESSION['prog_points'][$act_num][$j]))
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
        if (mysql_num_rows($_SESSION['hard_differentiations'][$act_num])!=0)
        {
                // go through the differentiaions
                $hard_differentiation_str[$act_num]="<TR VALIGN=TOP><TD WIDTH=100% COLSPAN=5 style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>To make activity harder</TD></TR><TR VALIGN=TOP><TD COLSPAN=5 WIDTH=100% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'><ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                while ($hard_differentiations=mysql_fetch_array($_SESSION['hard_differentiations'][$act_num]))
                    {
                        $hard_differentiation_str[$act_num]=$hard_differentiation_str[$act_num]."<li>".$hard_differentiations['differentiation']."</li>";
                    }
            $hard_differentiation_str[$act_num]=$hard_differentiation_str[$act_num]."</ul></TD></TR>";
        }
        $activityContent[$act_num]=$activityContent[$act_num].$hard_differentiation_str[$act_num];
        if (mysql_num_rows($_SESSION['easy_differentiations'][$act_num])!=0)
        {
                // go through the differentiaions
                $easy_differentiation_str[$act_num]="<TR VALIGN=TOP><TD WIDTH=100% COLSPAN=5 style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>To make activity easier</TD></TR><TR VALIGN=TOP><TD COLSPAN=5 WIDTH=100% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'><ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                while ($easy_differentiations=mysql_fetch_array($_SESSION['easy_differentiations'][$act_num]))
                    {
                        $easy_differentiation_str[$act_num]=$easy_differentiation_str[$act_num]."<li>".$easy_differentiations['differentiation']."</li>";
                    }
            $easy_differentiation_str[$act_num]=$easy_differentiation_str[$act_num]."</ul>";
        }
        $activityContent[$act_num]=$activityContent[$act_num].$easy_differentiation_str[$act_num];
        $activityContent[$act_num]=$activityContent[$act_num]."</TD></TR>";;
        if (mysql_num_rows($_SESSION['analysess'][$act_num])!=0)
        {
            $j=0;
            while ($analysess=mysql_fetch_array($_SESSION['analysess'][$act_num]))
                {
                    $analyses_str[$act_num]=$analyses_str[$act_num]."</TD></TR><TR VALIGN=TOP><TD WIDTH=15% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>Analysis</TD><TD COLSPAN=4 WIDTH=85% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>".
                    sp_utf2ascii(stripslashes($analysess['analysis_title']))."</TD></TR>";
                    if (checkBase64Encoded($analysess['analysis']))
                        {$analyses_line_arr[$act_num]=unserialize(base64_decode($analysess['analysis']));	}
                    else {$analyses_line_arr[$act_num]=unserialize($analysess['analysis']);}
                    //while(list ($anal_point_id,$anal_point)=mysql_fetch_array($_SESSION['anal_points'][$act_num][$j]))
                    //{
                    //    $anal_points[]=$anal_point;
                    //}
                    $analyses_str[$act_num]=$analyses_str[$act_num]."<TR VALIGN=TOP><TD WIDTH=100% COLSPAN=5 style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'><ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
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
        if ($plenary==1)
        {
            $plenaryContent[$act_num]="<TR><TD><TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0 STYLE=\"page-break-inside: avoid\"><TR VALIGN=TOP><TD WIDTH=100% COLSPAN=2 style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>".
            $activities['lesson_part']."</TD></TR>";
        }
        $plenaryContent[$act_num]=$plenaryContent[$act_num]."<TR VALIGN=TOP><TD WIDTH=30% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>".
        $activities['content_name']."</TD><TD WIDTH=70% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>";
        $activityContent[$act_num]=$activityContent[$act_num].$plenaryContent[$act_num];
        if ($_SESSION['teaching_points'][$act_num])
        {
            $teaching_points_str[$act_num]="<ul style='margin-left: -20px;#display:inline;#margin-left: 0px'>";
                while ($teaching_points=mysql_fetch_array($_SESSION['teaching_points'][$act_num]))
                    {
                        if ($teaching_points['point']) $teaching_points_str[$act_num]=$teaching_points_str[$act_num]."<li>".sp_utf2ascii(stripslashes($teaching_points['point']))."</li>";
                    }
                $teaching_points_str[$act_num]=$teaching_points_str[$act_num]."</ul>";
        }
        $activityContent[$act_num]=$activityContent[$act_num].$teaching_points_str[$act_num]."</TD></TR>";
    if ($act_num==$num_acts) {
    $activityContent[$act_num]=$activityContent[$act_num]."</TD></TR></TABLE><BR>";}
    $plenary++;
    }
    $actContent=$actContent.$activityContent[$act_num];
}
$pdfContent=$pdfContent.$actContent;
$strContent=$strContent.$actContent;
$strContent=$strContent."
    <TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0>
	<TR VALIGN=TOP>
		<TD WIDTH=100% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>
		Evaluation
                </TD>
        </TR>
        <TR VALIGN=TOP>
		<TD WIDTH=100% style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:normal;'>";
$evaluation_arr=$_SESSION['evaluation_arr'];
$evaluation_string=$evaluation_string."  ".sp_utf2ascii(stripslashes($evaluation_arr[0]))."<br>";
for ($e=1 ; $e <= count($evaluation_arr) ; $e++)
	{
		if ($evaluation_arr[$e]) {
		$evaluation_string=$evaluation_string."  -  <i>".sp_utf2ascii(stripslashes($evaluation_arr[$e]))."</i><br>";
		}
	}
        $strContent=$strContent.$evaluation_string;
$strContent=$strContent."</TD>
        </TR>
    </TABLE>
<BR>
    <TABLE WIDTH=100% BORDER=1 BORDERCOLOR=\"#b7cc79\" CELLPADDING=2 CELLSPACING=0 STYLE=\"page-break-before: always\">
	<TR>
		<TD WIDTH=33%% HEIGHT=5% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>"
			 .$diagram_titles[0].
		"</TD>
                <TD WIDTH=33%% HEIGHT=5% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>"
			.$diagram_titles[1].
		"</TD>
                <TD WIDTH=33%% HEIGHT=5% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>"
			.$diagram_titles[2].
		"</TD>
       </TR>
       <TR>
                <TD WIDTH=33%% HEIGHT=45% align=center valign=middle style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>";
			if ($diagram_images[0]) $strContent=$strContent."<img src='".$diagram_images[0]."' width='350' height='200'>";
		$strContent=$strContent."</TD>
                <TD WIDTH=33%% HEIGHT=45% align=center valign=middle style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>";
			if ($diagram_images[1]) $strContent=$strContent."<img src='".$diagram_images[1]."' width='350' height='200'>";
		$strContent=$strContent."</TD>
                <TD WIDTH=33%% HEIGHT=45% align=center valign=middle style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>";
			if ($diagram_images[2]) $strContent=$strContent."<img src='".$diagram_images[2]."' width='350' height='200'>";
		$strContent=$strContent."</TD>
        </TR>
	<TR>
		<TD WIDTH=33%% HEIGHT=5% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>"
			 .$diagram_titles[3].
		"</TD>
                <TD WIDTH=33%% HEIGHT=5% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>"
			.$diagram_titles[4].
		"</TD>
                <TD WIDTH=33%% HEIGHT=5% style='background:#d2e0a9;font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>"
			.$diagram_titles[5].
		"</TD>
       </TR>
       <TR>
                <TD WIDTH=33%% HEIGHT=45% align=center valign=middle style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>";
			if ($diagram_images[3]) $strContent=$strContent."<img src='".$diagram_images[3]."' width='350' height='200'>";
		$strContent=$strContent."</TD>
                <TD WIDTH=33%% HEIGHT=45% align=center valign=middle style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>";
			if ($diagram_images[4]) $strContent=$strContent."<img src='".$diagram_images[4]."' width='350' height='200'>";
		$strContent=$strContent."</TD>
                <TD WIDTH=33%% HEIGHT=45% align=center valign=middle style='font-family: Verdana, Arial, Helvetica, sans-serif;font-size: 10px;font-weight:bold;'>";
			if ($diagram_images[5]) $strContent=$strContent."<img src='".$diagram_images[5]."' width='350' height='200'>";
		$strContent=$strContent."</TD>
        </TR>
    </TABLE>
</body>
</html>
";
$pdfContent=$pdfContent."
</body>
</html>
";
// Send it to the screen
//echo $strContent;
fwrite($pdfIn,$strContent);
fclose($pdfIn);
echo("window.open('code/send_pdf.php?".time()."&file=$file&orientation=landscape')");
// Clean up after ourselves
CleanFiles(FILE_ROOT."tmp/");
?>