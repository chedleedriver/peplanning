<?php
/* to run this you need to put this in the url:
 * http://localhost/tplan/DB_Maintenance/move_unit.php?username=athleticslevel4.0&from=peplanning-dev&to=localhost&database_from=tplan&database_to=tplan
 * You also need to do this via mysql
 * mysqldump -u tp -p tplan progression_point lesson_part ICT citizenship differentiation equipment evaluation genre genre_description keywords level numeracy objectives point progression risk_assessment set_plan_lessons set_plans strand theme theme_objective topic topic_description topic_equipment topic_keywords topic_numeracy topic_risk_assessment topic_ICT topic_citizenship topic_lesson_part topic_objectives topic_point topic_theme topic_theme_evaluation content content_differentiation content_equipment content_lesson_part content_level content_point content_progression content_strand content_theme content_topic content_resources | mysql --host=192.168.38.170 -C tplan
 *
 */
$tp = mysql_pconnect($_GET['from'], "tp", "enquiry") or die(mysql_error()." - ".$_GET['from']);
mysql_select_db($_GET['database_from'], $tp) or die(mysql_error()." - ".$_GET['database_from']);
$username=$_GET['username'];
$get_user_id=mysql_query("select id,password,userlevel from users where username='$username'") or die(mysql_error());
if (mysql_num_rows($get_user_id)>0)
{
    list($user_id,$password,$userlevel)=mysql_fetch_array($get_user_id);
    $got_units=mysql_query("select unit_of_work.id,unit_of_work.description,topic_id,level_id,num_lessons,topic.name from unit_of_work left join topic on topic.id=unit_of_work.topic_id where unit_of_work.teacher_id=$user_id") or die(mysql_error());
        if (mysql_num_rows($got_units)>0)
            {
                while(list($unit_id,$description,$topic_id,$level_id,$num_lessons,$topic)=mysql_fetch_array($got_units))
                {
                    echo "</br>Getting Unit - ".$unit_id." - ".$description."</br>";
                        for ($i=1;$i<=$num_lessons;$i++)
                              {
                                echo "</br>Getting Lesson - ".$i." of ".$num_lessons."</br>";
                                $lessons[$i]=mysql_query("select id from lesson where uow_id=$unit_id and lesson_num=$i") or die(mysql_error());
                                $themes[$i]=mysql_query("select theme_id,theme.theme from lesson left join theme on theme_id=theme.id where uow_id=$unit_id and lesson.lesson_num=$i") or die(mysql_error());
                                $sens[$i]=mysql_query("select ta,sen from lesson where uow_id=$unit_id and lesson_num=$i") or die(mysql_error());
                                $objectives[$i]=mysql_query("select lesson_objectives.objective_id,objective,strand_id from lesson_objectives left join lesson on lesson.id=lesson_objectives.lesson_id left join objectives on lesson_objectives.objective_id=objectives.id left join topic_objectives on topic_objectives.objectives_id=lesson_objectives.objective_id where lesson.uow_id=$unit_id and lesson.lesson_num=$i") or die(mysql_error());
                                $keywords[$i]=mysql_query("select keyword_id from lesson_keywords left join lesson on lesson.id=lesson_keywords.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$i") or die(mysql_error());
                                $ict[$i]=mysql_query("select ict_id from lesson_ict left join lesson on lesson.id=lesson_ict.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$i") or die(mysql_error());
                                $numeracy[$i]=mysql_query("select numeracy_id from lesson_numeracy left join lesson on lesson.id=lesson_numeracy.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$i") or die(mysql_error());
                                $citizenship[$i]=mysql_query("select citizenship_id from lesson_citizenship left join lesson on lesson.id=lesson_citizenship.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$i") or die(mysql_error());
                                $risk_assessment[$i]=mysql_query("select ra_id from lesson_risk_assessment left join lesson on lesson.id=lesson_risk_assessment.lesson_id where lesson.uow_id=$unit_id and lesson.lesson_num=$i") or die(mysql_error());
                                $activities[$i]=mysql_query("select la_id,activity_id,time,activity_num,lesson_part.description from lesson_activities left join lesson on lesson.id=lesson_activities.lesson_id left join content_lesson_part on content_lesson_part.content_id = lesson_activities.activity_id left join lesson_part on lesson_part.id = content_lesson_part.lesson_part_id where lesson.uow_id=$unit_id and lesson.lesson_num=$i order by activity_num") or die(mysql_error());
                                if ($activities[$i])
                                {
                                $a=1;
                                echo "Getting Activity - ".$a;
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
                                        echo ",".$a;
                                        }
                                }
                            }
                            /* Save the Unit*/
                            $tp = mysql_pconnect($_GET['to'], "tp", "enquiry") or trigger_error(mysql_error(),E_USER_ERROR);
                            mysql_select_db($_GET['database_to'], $tp) or die(mysql_error());;
                            $get_user_id=mysql_query("select id,userlevel from users where username='$username'");
                            if (mysql_num_rows($get_user_id)==1){
                            list($user_id,$userlevel)=mysql_fetch_array($get_user_id);}
                            else {$create_user=mysql_query("insert into users (username,password,userlevel) values ('$username','$password',$userlevel)");
                                $user_id=mysql_insert_id();
                            }
                            $savesql="insert into unit_of_work (description, topic_id, level_id, teacher_id, num_lessons) values ('$description',$topic_id,$level_id,$user_id,$num_lessons)";
                            $saveresult=mysql_query($savesql) or die("Error reported while executing the statement: $savesql<br />MySQL reported: ".mysql_error());
                            $unit_id=mysql_insert_id();
                            echo "</br>Saving Unit ".$unit_id." - ".$description."</br>";
                            // Save the lessons
                            for ($j=1;$j<=$num_lessons;$j++)
                            {
                                echo "</br>Saving Lesson - ".$j." of ".$num_lessons."</br>";
                                list($theme_id)=mysql_fetch_array($themes[$j]);if (!$theme_id) $theme_id=0;
                                list($ta,$sen)=mysql_fetch_array($sens[$j]);
                                $createlesson="insert into lesson (uow_id,lesson_num,theme_id,ta,sen) values ($unit_id,$j,$theme_id,'$ta','$sen')";
                                $createlessonresult=mysql_query($createlesson) or die(mysql_error().$createlesson);
                                $lesson_id=mysql_insert_id();
                                echo "Saving Lesson ".$j." id : ".$lesson_id."</br>";
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
                                echo "Saving Activity - ".$a;
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
                                        echo ",".$a;
                                    }
                                }
                            }
                        $tp = mysql_pconnect($_GET['from'], "tp", "enquiry") or trigger_error(mysql_error(),E_USER_ERROR);
                    mysql_select_db($_GET['database_from'], $tp) or die(mysql_error()." - ".$_GET['database_from']);
                }
            }
            else {
                echo "No units for ".$username." in database ".$_GET['database_from']." on ".$_GET['from'];
            }
        } else {
            echo "No user - ".$username." in database ".$_GET['database_from']." on ".$_GET['from'];
     }
?>
