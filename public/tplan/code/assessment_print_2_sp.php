<?
// reset variables
header('Content-Type: text/html; charset=ISO-8859-1');
$assess_id = $_GET['assess_id'];
$topic_id = $_GET['topic_id'];
$level_id = $_GET['level_id'];
$unit_id = $_GET['unit_id'];
$ajax=$_GET['ajax'];
include('lessonfunctions_2.php');
$strContent='';
$pdfContent='';
if ($assess_id==1) $orientation="portrait";
if ($assess_id==2) $orientation="landscape";
$file=basename(tempnam('/tmp','tmp'));
rename('/tmp/'.$file,FILE_ROOT.'tmp/'.$file.'.pdf');
$htmlFile=FILE_ROOT.'/tmp/'.$file.'.html';
$pdfFile=FILE_ROOT.'/tmp/'.$file.'.pdf';
$browsePDF='../tmp/'.$file.'.pdf';
$pdfIn=fopen($htmlFile,'w') or die("can't open the file $htmlFile");
$pdfOut=fopen($pdfFile,'w') or die("can't open the file $pdfFile");
fclose($pdfOut);
$doc_header="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
                    <html dir=\"ltr\" xml:lang=\"en-GB\" xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en-GB\">
                    <head>
                        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
                        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=8\" />
                        <title>Assessment</title>
                        <link rel=\"stylesheet\" type=\"text/css\" href=\"/tplan/index_files/assessment.css\" media=\"screen\"/>

                    </head>
                    <body>";
      
        //get some data
        $myLevel_id = $level_id;
        $myLevel_idplus = $myLevel_id+1;
        $myTopic_id = $topic_id;
        $GetMySport=mysql_query("select name from topic where id=$topic_id");
        list($mySport) = mysql_fetch_array($GetMySport);
        
        // line 40 - separating which SQL command runs on assess_id
        if($assess_id == 1)
        {
        if ($myLevel_id==1.5) $criteria="(topic_objectives.level_id=1 or topic_objectives.level_id=2)";
        elseif ($myLevel_id==2.5) $criteria="(topic_objectives.level_id=2 or topic_objectives.level_id=3)";
        elseif ($myLevel_id==3.5) $criteria="(topic_objectives.level_id=3 or topic_objectives.level_id=4)";
        else $criteria="topic_objectives.level_id=$myLevel_id";
        $sql1="SELECT assessment
         FROM objectives
         LEFT JOIN topic_objectives
         ON objectives.id=topic_objectives.objectives_id
         WHERE $criteria
         AND topic_objectives.topic_id=$myTopic_id
         ORDER BY topic_objectives.objectives_id";
         $result1 = mysql_query($sql1);
            if (!$result1)
               {
                  die('Invalid query: '. mysql_error());
               }
         }
        if($assess_id == 2)
        {
        $sql2="select assessment from tplan.objectives left join tplan.lesson_objectives on tplan.lesson_objectives.objective_id = tplan.objectives.id left join tplan.lesson on tplan.lesson.id = tplan.lesson_objectives.lesson_id where tplan.lesson.uow_id=$unit_id";
        $result2 = mysql_query($sql2);
           if (!$result2)
              {
                  die('Invalid query: '. mysql_error());
              }
        }
        if($assess_id == 3)
        {
        $sql3="select objective,theme,lesson_num,name,level_id from tplan.objectives left join tplan.lesson_objectives on tplan.lesson_objectives.objective_id = tplan.objectives.id left join tplan.lesson on tplan.lesson.id = tplan.lesson_objectives.lesson_id left join tplan.theme on tplan.theme.id = tplan.lesson.theme_id left join tplan.unit_of_work on tplan.lesson.uow_id = tplan.unit_of_work.id left join tplan.topic on tplan.unit_of_work.topic_id = tplan.topic.id where tplan.lesson.uow_id=$unit_id order by lesson_num";
        }
        $pdfContent=$pdfContent.$doc_header;
        $pdfContent=$pdfContent."
        <table id='container_table'>
            <tr>
                <td width=100% align='left'>
                    <table cellpadding=\"25\" border=0 style=\" font-size:25pt; color : #b7cc79; font-weight: bold; background:url('/tplan/index_files/assessment/classprint_header.jpg') no-repeat;\" width='1090' align='left'>
                        <tr>
                            <td align='center' valign='middle'>
                                What Level am I in $mySport?                                
                            </td>
                         </tr>
                     </table>
                 </td>
            </tr>
            <tr>
            <td width='1090'>";
        
        $strContent=$strContent.$doc_header;
        $strContent=$strContent."
        <table id='container_table'>
            <tr>
                <td width='1090' align='right'>
                    <table width=100% cellpadding=0 cellspacing=0>
                        <tr>
                            <td width=33% align='right'>
                                <a href=\"/tplan/code/send_pdf_2.php?file=".$file."&orientation=".$orientation."\"><img src=\"/tplan/index_files/icon_pdf.jpg\" border=none alt='create PDF file' title='create PDF file'></a>
                            </td>
                        </tr>
                        <tr>
                            <td width=100% align='left'>";

                                if($assess_id == '2')
                                {
                                
                                $strContent_add="<table border='0' align='right'>
                                    <tr>
                                        <td align='right'>
                                            <img src='/tplan/index_files/assessment/name.class.date.jpg'/>                                                                                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </td>
                                    </tr>
                                </table>";
                                $strContent=$strContent.$strContent_add;
                                }
                                $strContent_post="<table border=0 style=\" font-size:25pt; color : #b7cc79; font-weight: bold; background:url('/tplan/index_files/assessment/classprint_header.jpg') no-repeat;\" width='1090' align='left'>
                                    <tr>
                                        <td align='center' valign='middle'>
                                            <br>
                                                What Level am I in $mySport?                                            
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td width='1090'>";
                                $strContent=$strContent.$strContent_post;
                    if($assess_id == 1)
                    { // class assessment
                    $mySummaryContent=
                    "<table width=100% CELLPADDING=0 CELLSPACING=0>
                        <tr>
                            <td width='1090' align='left'>";
                               
                            $summaryContent=$summaryContent.$mySummaryContent;
                            if($myLevel_id>2)
                            {
                            $levelSummaryContent=
                                //"<img src='/tplan/index_files/assessment/title.jpg'/>"."<br>".
                                //"<img src='/tplan/index_files/assessment/titletxt.jpg'/>".
                                "<table style=\"font-size:14pt; color:#f1a95a\">
                                    <tr>
                                        <td>
                                            <b>Read these questions and think of which box is the best answer for you to tick. Be honest and don't worry if you do not tick many or even any of the green boxes, your teacher will help you to improve on any of the skills you cannot yet achieve.</b>
                                        </td>
                                    </tr>
                                </table>".
                                "</td>
                                <td width='190' align='right'>".
                                "<img src='/tplan/index_files/assessment/notyet3.jpg'/>".
                                "</td>";
                                $summaryContent=$summaryContent.$levelSummaryContent;
                            }
                            else
                            {
                            $levelSummaryContent=
                                //"<img src='/tplan/index_files/assessment/title.jpg'/>".
                                //"<img src='/tplan/index_files/assessment/titletxt.jpg'/>".
                                "<table style=\"font-size:14pt; color:#f1a95a\">
                                    <tr>
                                        <td>
                                            <b>Which is the best answer for you? Read each question and tick either 'NOT YET' or 'YES I CAN'</b>
                                        </td>
                                    </tr>
                                </table>".
                                "</td>
                                <td width='150' align='right'>".
                                "<img src='/tplan/index_files/assessment/notyet2.jpg'/>".
                                "</td>";
                            $summaryContent=$summaryContent.$levelSummaryContent;
                            }
                            $liveContent=
                            "</tr>
                            <table>".
                            "<table style=\"font-size:16pt; color:#5a5a5a\" border='0' align='left'>";
                            $summaryContent=$summaryContent.$liveContent;
                            while($row = mysql_fetch_array( $result1 ))
                            {
                            // Print out the contents of each row into a table
                            $myLiveContent=
                            "<tr>
                            <td width='950'>".
                            //"<font size='6'>".
                            $row['assessment'].
                            "</td>";
                            $summaryContent=$summaryContent.$myLiveContent;
                            if($myLevel_id>2)
                            {
                            $myLiveSummaryContent=
                            "<td>
                                <img src=\"/tplan/index_files/assessment/boxes.jpg\" align=\"right\"/>
                            </td>";
                            $summaryContent=$summaryContent.$myLiveSummaryContent;
                            }
                            else
                            {
                            $myLiveSummaryContent=
                            "<td>
                                <img src=\"/tplan/index_files/assessment/tickbox.gif\" align=\"right\"/>
                            </td>";
                            $summaryContent=$summaryContent.$myLiveSummaryContent;
                            }
                            }// end while
                            $tablefix2=
                            "</tr>
                            </table>
                            </td>
                            </tr>
                            <tr>
                            <td width=1090>";
                            $summaryContent=$summaryContent.$tablefix2;


                            if($myLevel_id<3){
                            $greenclass=
                            "<table border=0 width='1090' align='left' style=\"font-size:large;background:url('/tplan/index_files/assessment/greenh94.jpg') no-repeat;page-break-inside: avoid\">".
                                "<tr>
                                    <td>".
                                        "<b>Have you ticked most the 'YES I CAN' boxes?</b>".
                                            "<br>".
                                                "Well Done! You are achieving Level: $myLevel_id in $mySport.".
                                            "<br>". "Now look at the Level: $myLevel_idplus questions.".
                                            "<br><br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>";
                    $summaryContent=$summaryContent.$greenclass;

                    /* red */
                    $redlevel=
                    "<tr>
                        <td width=1090>
                            <table border=0 width=1090 align='left' style=\"font-size:large;background:url('/tplan/index_files/assessment/redh94.jpg') no-repeat;page-break-inside: avoid\">".
                        "<tr>
                            <td>".
                                "<b>Have you ticked most of the 'NOT YET' boxes?</b>".
                                "<br>".
                                "Keep trying! You are working hard to achieve Level: $myLevel_id in $mySport. ".
                                "<br><br><br>".
                            "</td>
                        </tr>
                    </table>
                </td>
            </tr>";
            $summaryContent=$summaryContent.$redlevel;
            }
            else{
                /* CHANGES ALL OUTPUT FOR LOWER 3 BOXES*/
                if($myLevel_id>2)
                {
                    if($myLevel_id>3)
                    {
                        //GREEN CLASS LEVEL 4
                        $greenclass=
                            "<table border=0 width='1090' align='left' style=\"font-size:large;background:url('/tplan/index_files/assessment/greenh94.jpg') no-repeat;page-break-inside: avoid\">".
                                "<tr>
                                    <td>".
                                        "<b>If you have ticked all of the 'ALL OF THE TIME' boxes:</b>".
                                            "<br>".
                                                "Well Done! You have achieved Level: $myLevel_id in $mySport.".
                                            "<br>".                                                
                                            "<br><br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>";
                    $summaryContent=$summaryContent.$greenclass;
                    }
                    else{
                    //GREEN CLASS LEVEL 3
                    $greenclass=
                            "<table border=0 width='1090' align='left' style=\"font-size:large;background:url('/tplan/index_files/assessment/greenh89.jpg') no-repeat;page-break-inside: avoid\">".
                                "<tr>
                                    <td>".
                                        "<b>If you have ticked all of the 'ALL OF THE TIME' boxes:</b>".
                                            "<br>".
                                                "Well Done! You have achieved Level: $myLevel_id in $mySport.".
                                            "<br>".
                                                "Now look at the Level: $myLevel_idplus questions.".
                                            "<br><br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>";
                    $summaryContent=$summaryContent.$greenclass;
                    }

                    $amberlevel=
                    "<tr>
                        <td width='1090'>
                            <table width='1090' align='left' style=\"font-size:large;background:url('/tplan/index_files/assessment/amberh110.jpg') no-repeat;page-break-inside: avoid\">".
                                "<tr>
                                    <td>".
                                        "<b>If you have ticked some 'SOME OF THE TIME' boxes and some 'ALL OF THE TIME' boxes;</b>".
                                        "<br>".
                                        "Well Done! You are nearly achieving Level: $myLevel_id in $mySport."."<br>".
                                        "Now look at the questions where you ticked the 'SOME OF THE TIME' boxes and think of what you need to do to improve that skill. Talk to your class-mates and teacher about different ways to improve the skill.</b>".
                                        "<br><br>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>";
                    $summaryContent=$summaryContent.$amberlevel;

                    $redlevel=
                    "<tr>
                        <td width=1090>
                            <table border=0 width=1090 align='left' style=\"font-size:large;background:url('/tplan/index_files/assessment/redh112.jpg') no-repeat;page-break-inside: avoid\">".
                                "<tr>
                                    <td>".
                                        "<b>Have you ticked most of the 'NOT YET' boxes?</b>".
                                        "<br>".
                                        "Keep trying! You are working hard to achieve Level: $myLevel_id in $mySport. ".
                                        "<br>
                                         Now look at the questions and think of what you need to do to improve that skill. Talk to your class-mates and teacher about different ways to improve the skill.<br><br>".
                                     "</td>
                                </tr>
                            </table>
                         </td>
                    </tr>";
                    $summaryContent=$summaryContent.$redlevel;
                }// end if >level2
            }
            }
            if($assess_id == 2)
            { //individual assessment
            $indivSummary=
            "<tr>
                <td width='1090'>
                    <table>".
                        "<tr>
                            <td width='280' align='left'>";
            $summaryContent=$summaryContent.$indivSummary;
                if($myLevel_id>2)
                {
                    $levelSummaryContent=
                                "<img src='/tplan/index_files/assessment/title.jpg'/>"."<br>".
                                "<img src='/tplan/index_files/assessment/titletxt.jpg'/>".
                            "</td>
                            <td width='190' align='left'>".
                                "<img src='/tplan/index_files/assessment/boxes_titles.jpg'/>".
                            "</td>
                            <td>".
                                "<img src='/tplan/index_files/assessment/ifbox.jpg' align='right'/>";
            $summaryContent=$summaryContent.$levelSummaryContent;
                }
                else
                {
                    $levelSummaryContent=
                                "<img src='/tplan/index_files/assessment/title.jpg'/>".
                                "<img src='/tplan/index_files/assessment/titletxt.jpg'/>".
                            "</td>
                            <td width='160' align='center'>".
                                "<img src='/tplan/index_files/assessment/notyet.jpg'/>".
                            "</td>
                            <td>".
                                "<img src='/tplan/index_files/assessment/ifbox.jpg' align='right'/>";
            $summaryContent=$summaryContent.$levelSummaryContent;
                }
            $tablefix3=
                            "</td>
                        </tr>";
            $summaryContent=$summaryContent.$tablefix3;
            // returns all rows in SQL query with addition of graphics
                while($row = mysql_fetch_array( $result2 ))
                {
                    $myLiveContent2=
                        "<tr>
                            <td width='280'>".
                    $row['assessment'].
                            "</td>";
            $summaryContent=$summaryContent.$myLiveContent2;
                    if($myLevel_id>2)
                    {
                        $myLiveSummaryContent2=
                            "<td>
                                <img src=\"/tplan/index_files/assessment/boxes.jpg\" align=\"right\"/>
                            </td>";
            $summaryContent=$summaryContent.$myLiveSummaryContent2;
                    }
                    else
                    {
                        $myLiveSummaryContent2=
                            "<td>
                                <img src=\"/tplan/index_files/assessment/tickbox.gif\" align=\"right\"/>
                            </td>";
            $summaryContent=$summaryContent.$myLiveSummaryContent2;
                    }
            $boxes2=
                            "<td>
                                <img src=\"/tplan/index_files/assessment/write_grey.jpg\" align=\"right\"/>
                            </td>".
                            "
                        </tr>";
            $summaryContent=$summaryContent.$boxes2;
            }// end while

             $summaryContent=$summaryContent."</table>";

            /* green */
            if($myLevel_id>2)
            {
                if($myLevel_id>3)
                {
                $green2=
                "<tr>
                    <td width='1090'>
                        <table border=0 style=\"background:url('/tplan/index_files/assessment/greenh70.jpg') no-repeat;page-break-inside: avoid\" width=1090 align='left'>".
                            "<tr>
                                <td>".
                                    "<b>Have you ticked all the 'YES I CAN' boxes?</b>".
                                    "<br>".
                                    "You have achieved Level: $myLevel_id".
                                    "<br>".
                                    
                                    "<br><br><br>
                                </td>
                            </tr>
                        </table>";
                    //</td>
                //</tr>";
                }
                else{
                    $green2=
                        "<tr>
                            <td width='1090'>
                                <table border=0 style=\"background:url('/tplan/index_files/assessment/greenh70.jpg') no-repeat;page-break-inside: avoid\" width=1090 align='left'>".
                                    "<tr>
                                        <td>".
                                            "<b>Have you ticked all the 'YES I CAN' boxes?</b>".
                                                "<br>".
                                                    "You have achieved Level: $myLevel_id".
                                                    "<br>".
                                                    "Now look at the questions in Level: $myLevel_idplus".
                                                    "<br><br><br>
                                        </td>
                                    </tr>
                                </table>";
                    //</td>
                //</tr>";

                }
             $summaryContent=$summaryContent.$green2;
             $amber2=
             "<tr>
                <td width=1090>
                    <table width='1090' border=0 style=\"background:url('/tplan/index_files/assessment/amberh70.jpg') no-repeat;page-break-inside: avoid\" align='left'>".
                        "<tr>
                            <td>".
                                "<b>Have you ticked all the 'SOMETIMES' and 'YES I CAN' boxes?</b>".
                                "<br>".
                                "Well Done! You have almost achieved Level: $myLevel_id".
                                "<br>".
                                "Now look at the questions where you ticked the 'SOME OF THE TIME' boxes and think of what you need to do to improve that skill."."<br>"."Talk to your class-mates and teacher about different ways to improve the skill."."<br>".
                                "<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>";
            $summaryContent=$summaryContent.$amber2;
            $red2=
            "<tr>
                <td width=1090>
                    <table border='0' width='1090' style=\"background:url('/tplan/index_files/assessment/redh70.jpg') no-repeat;page-break-inside: avoid\" align='left'>".
                        "<tr>
                            <td>".
                                "<b>Have you ticked most of the 'NOT YET' boxes?</b>".
                                "<br>".
                                "Keep trying! You are working hard to achieve Level: $myLevel_id. "."<br>".
                                "Now look at the questions and think of what you need to do to improve that skill."."<br>"."Talk to your class-mates and teacher about different ways to improve the skill.".
                                "<br><br>".
                            "</td>
                        </tr>".
                    "</table>
                </td>
            </tr>";
           $summaryContent=$summaryContent.$red2;
           } //end if > level2
           else
           {
           $green2=
           "<tr>
                <td width=1090>
                    <table border=0 style=\"background:url('/tplan/index_files/assessment/greenh70.jpg') no-repeat;page-break-inside: avoid\" width='1090' align='left'>".
                        "<tr>
                            <td>".
                                "<b>Have you ticked all the 'YES I CAN' boxes?</b>".
                                "<br>".
                                "You have achieved Level: $myLevel_id".
                                "<br>".
                                "Now look at the questions in Level: $myLevel_idplus".
                                "<br><br><br>
                            </td>
                        </tr>
                    </table>
                
            ";
           $summaryContent=$summaryContent.$green2;
           $red2=
           "<tr>
                <td width=1090>
                    <table border=0 style=\"background:url('/tplan/index_files/assessment/redh70.jpg') no-repeat;page-break-inside: avoid\" width='1090' align='left'>".
                        "<tr>
                            <td>".
                                "<b>Have you ticked most of the 'NOT YET' boxes?</b>".
                                "<br>".
                                "Keep trying! You are working hard to achieve Level: $myLevel_id. "."<br>".
                                "Now look at the questions and think of what you need to do to improve that skill."."<br>"." Talk to your class-mates and teacher about different ways to improve the skill.".
                                "<br><br>".                
                            "</tr>
                        ".
                    "</table>
                
            ";
            $summaryContent=$summaryContent.$red2;                
            }
            }//endif
            if($assess_id == 3){
                $sql3=base64_encode($sql3);
                $teacherContent="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
                    <html dir=\"ltr\" xml:lang=\"en-GB\" xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en-GB\">
                    <head>
                        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\"/>
                        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=8\" />
                        <title>Teacher Assessment</title>
                        <link rel=\"stylesheet\" type=\"text/css\" href=\"/tplan/index_files/assessment.css\" media=\"screen\"/>

                    </head>
                    <body>
                        <div class=\"teacher\">
                        <table cellpadding=\"20\" cellspacing=\"10\" class=\"teacher\">
                            <tr>
                                <td> <a href=\"/\" title=\"PEPlanning / Home\" accesskey=\"1\" id=\"logo\">
                                        </a>
                                </td>
                                <td valign=\"middle\" align=\"right\"><a href=\"/tplan/code/teacher_assessment_2.php?sql=$sql3\" class=\"ui-widget\">download teacher assessment form&nbsp|&nbsp</a>
                               	</td>
                            </tr>
                                    <tr>
                                        <td colspan=2>In order to use the Teacher Assessment Module most effectively, please follow these instructions:</td>
                                    </tr>
                                    <tr>
                                        <td colspan=2>1. Click on the link above to download the Teacher Assessment Form</td>
                                    </tr>
                                    <tr>
                                        <td colspan=2>2. When prompted choose to save or open the spreadsheet</td>
                                    </tr>
                                    <tr>
                                        <td colspan=2>3. If you chose to save the file go to that location and open it</td>
                                    </tr>
                                    <tr>
                                        <td colspan=2>4. Enter the names of the children in your class accross the top of the sheet</td>
                                    </tr>
                                    <tr>
                                        <td colspan=2>5. Enter the NC Level attained in the appropriate cell for each child</td>
                                    </tr>
                                    <tr>
                                        <td colspan=2>6. When you have completed this save the file to the appropriate location on your local hard drive/school file server</td>
                                    </tr>
                                    <tr>
                                        <td colspan=2><b>Please Note, we do not store any information about the children you are teaching in the PE Planning system</b></td>
                                    </tr>
                                    </table>
                        </div>
                      </body>
                    </html>";
                 echo $teacherContent;
             }
        $summaryContent=$summaryContent."
        
        </body>
        </html>
        ";
        $pdfContent=$pdfContent.$summaryContent;
        $strContent=$strContent.$summaryContent;
        // Send it to the screen
        if ($assess_id!=3)
        {
        echo $strContent;
        fwrite($pdfIn,$pdfContent);
        fclose($pdfIn);
        // Clean up after ourselves
        CleanFiles(FILE_ROOT."tmp/");
        }
?>