<?php
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | Create a Plan</title>
        <link rel="stylesheet" type="text/css" href="http://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/peplanning/jquery-ui-1.7.3.custom.css"/>   
        <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" media="screen"/>
    </head>
    <body id="createplan">
   <script type="text/javascript"src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>"></script>
     <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>"></script>
<script type="text/javascript">
        /* google analytics */
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-16957975-1']);
        _gaq.push(['_trackPageview']);

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        </script>
<?php include("header.php")?>
    <div id="doc"  class="create_a_plan">
<form name="myform" method="post">
    <table width="90%" class="create_a_plan">
        <tr>
            <td height="100px">
                           <table width="100%">
                                <tr>
                                    <td width="10%">
                                        <h3>Step 1.</h3>
                                    </td>
                                    <td width="60%">
                                        <h5>At what National Curriculum level are you going to teach this unit of work?</h5>
                                    </td>
                                    <td width="30%">
                                        <h5>
                                            <select name="level" id="level" onchange="getSomeTopics(0);">
                                                <? if ($session->logged_in){?>
                                                <option value="99">Select Level</option>
                                                <option value="0.0">Foundation</option>
                                                <option value="1.0">Level 1</option>
                                                <option value="1.5">Level 1/2</option>
                                                <option value="2.0">Level 2</option>
                                                <option value="2.5">Level 2/3</option>
                                                <option value="3.0">Level 3</option>
                                                <option value="3.5">Level 3/4</option>
                                                <option value="4.0">Level 4</option>
                                                <?php }else{?>
                                                <option value="0">Sign In</option>
                                                <?php }?>
                                            </select>
                                        </h5>
                                    </td>
                                </tr>
                            </table>
            </td>
        </tr>
        <tr>
            <td height="100px">
                             <table width="100%">
                                <tr>
                                    <td width="10%">
                                        <h3>Step 2.</h3>
                                    </td>
                                    <td width="60%">
                                        <h5> Select an activity :</h5>
                                    </td>
                                    <td width="30%">
                                        <div id="topic">
                                        <h5>
                                            <select name="sel_topic" id ="sel_topic" size="1">
                                                <? if ($session->logged_in){?>
                                                <option value="0">Select Level</option>
                                                <?php }else{?>
                                                <option value="0">Sign In</option>
                                                <?php }?>
                                            </select>
                                        </h5>
                                        </div>
                                    </td>
                              </tr>
                           </table>
             </td>
        </tr>
        <tr>
            <td height="100px">
                          <table width="100%">
                                <tr>
                                    <td width="10%">
                                        <h3>Step 3.</h3>
                                    </td>
                                    <td width="60%">
                                        <h5> Enter the number of lessons to be delivered in this unit of work:</h5>
                                    </td>
                                    <td  width="30%" id="num_lessons_cell">
                                        <h5><select name="numLessons" id="numLessons">
                                                <? if ($session->logged_in){?>
                                                <option value="0">Select Level</option>
                                                <?php }else{?>
                                                <option value="0">Sign In</option>
                                                <?php }?>
                                                </select><br />
                                        </h5>
                                    </td>

                                 </tr>
                            </table>
             </td>
        </tr>
        <tr>
            <td height="100px">
                           <table width="100%">
                                <tr valign="middle">
                                    <td width="10%">
                                        <h3>Step 4.</h3>
                                    </td>
                                    <td width="30%">
                                        <h5>Give your unit of work a title:</h5>
                                    </td>
                                    <td width="60%">
                                        <h5>
                                            <input type="text" size="60" maxlength="80" name="description" id="description"/>
                                        </h5>
                                    </td>
                                </tr>
                            </table>
              </td>
        </tr>
        <tr>
            <td height="100px">
                          <table width="100%">
                                <tr>
                                   <td width="10%">
                                        <h3>Step 5.</h3>
                                    </td>
                                    <td valign="middle" width="30%">
                                           <input type="button" value="" alt="Preset" class="predesigned_div" onclick="javascript:takeAndShake('setPlan')"/>
                                    </td>
                                    <td  valign="middle" width="30%">
                                                    <input type="button" value="" alt="create your own" class="create_your_own_div" onclick="javascript:takeAndShake('newPlan')"/>
                                    </td>
                                </tr>
                            </table>
              </td>
        </tr>
        <tr>
            <td height="100px">
                <table width="100%">
                    <tr>
                        <td align="right">
                            <div class="help" onclick="javascript:showHelpDialog('steps')"></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
    </div>
     <?php include("footer.php")?>
    </body>
</html>