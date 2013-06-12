<?
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
if (!$session->logged_in)
  {
     if (@$_SERVER['HTTPS'] !== "on") {
        $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        //echo '<meta http-equiv="refresh" content="0;url='.$redirect.'" />';
        redirect($redirect);
     }
   }
  else
  {
      if (@$_SERVER['HTTPS'] == "on") {
       $redirect= "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
       //echo '<meta http-equiv="refresh" content="0;url='.$redirect.'" />';
       redirect($redirect);
    }
  }
require('../blog/wp-blog-header.php');
$ie6 = "MSIE 6.0";
$ie7 = "MSIE 7.0";
$ie7 = "MSIE 8.0";
$browser = $_SERVER['HTTP_USER_AGENT'];
$browser = substr("$browser", 25, 8);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="ltr" xml:lang="en-GB" xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <title>PE Planning | Welcome to peplanning.org.uk</title>

        <link rel="stylesheet" type="text/css" href="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/peplanning/jquery-ui-1.7.3.custom.css?<?=time()?>"/>
        <link rel="stylesheet" type="text/css" href="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/maincss.css?<?=time()?>" media="screen"/>
        
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
    </head>

    <body id="central" class="portal-page locale-en-GB portal-page js platform-windows">
    <script type="text/javascript" src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.4.2.min.js?<?=time()?>"></script>
    <script type="text/javascript" src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jcarousellite_1.0.1c4.js?<?=time()?>"></script>
    <script type="text/javascript" src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>"></script>
    <script type="text/javascript" src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery.bgiframe.min.js?<?=time()?>"></script>
    <script type="text/javascript" src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery.corner.js?<?=time()?>"></script>
    <script type="text/javascript" src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/mainScripts.js?<?=time()?>"></script>
    <script type="text/javascript" src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/utilities.js?<?=time()?>"></script>
    <script type="text/javascript" src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/mainPager.js?<?=time()?>"></script>
    <script type="text/javascript" src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery.tipsy.min.js?<?=time()?>"></script>
<script type="text/javascript">
$(function() {
	$("#helpDialog").dialog({
				buttons: {  },
				modal:false,
				position:'top',
				width:600,
				minHeight:400,
				title:"Help",
				autoOpen:false
	 });

});

function clearinputText() {
      document.sform.user.value= "";
}
$('.fix-z-index').bgiframe();
$('#signin_menu').bgiframe();
$('.help').corner('5px');
//$('.signin').corner('5px');
$('#signin_menu').corner('5px');
$('.signin_input_div').corner('5px');
$('.signin_submit_div').corner('5px');
$('.signup_upgrade_div').corner('5px');
$('.signup_subscribe_div').corner('5px');
$('.signup_submit_div').corner('5px');
$('.take_and_shake_div').corner('5px');
$('.signin menu_open').corner('5px');
$('.selected').corner('top')
</script>
<script type="text/javascript">
        $(document).ready(function() {

            $(".signin").click(function(e) {
                e.preventDefault();
                $("fieldset#signin_menu").toggle();
                $(".signin").toggleClass("menu-open");
                //$(".signup_submit_div").toggle();
                //$("#newsticker-demo").toggle();
            });

            $("fieldset#signin_menu").mouseup(function() {
                return false
            });
            $(document).mouseup(function(e) {
                if($(e.target).parent("a.signin").length==0) {
                    $(".signin").removeClass("menu-open");
                    $("fieldset#signin_menu").hide();
                }
            });
            $(".teach_more").click(function(e) {
                e.preventDefault();
                $("fieldset#teacher_more").toggle();
                $(".teach_more").toggleClass("more-open");
            });

            $("fieldset#teacher_more").mouseup(function() {
                return false
            });
            $(document).mouseup(function(e) {
                if($(e.target).parent("a.teach_more").length==0) {
                    $(".teach_more").removeClass("more-open");
                    $("fieldset#teacher_more").hide();
                }
            });
            $(".head_more").click(function(e) {
                e.preventDefault();
                $("fieldset#headteacher_more").toggle();
                $(".head_more").toggleClass("more-open");
            });

            $("fieldset#headteacher_more").mouseup(function() {
                return false
            });
            $(document).mouseup(function(e) {
                if($(e.target).parent("a.head_more").length==0) {
                    $(".head_more").removeClass("more-open");
                    $("fieldset#headteacher_more").hide();
                }
            });
            $(".child_more").click(function(e) {
                e.preventDefault();
                $("fieldset#children_more").toggle();
                $(".child_more").toggleClass("more-open");
            });

            $("fieldset#children_more").mouseup(function() {
                return false
            });
            $(document).mouseup(function(e) {
                if($(e.target).parent("a.child_more").length==0) {
                    $(".child_more").removeClass("more-open");
                    $("fieldset#children_more").hide();
                }
            });
           $(function() {
            $(".newsticker-jcarousellite").jCarouselLite({
                vertical: false,
                visible:1,
                auto:5000,
                speed:5000,
                mousewheel:true
    });
});
        });
</script>

<script type="text/javascript">

</script>  

<script type='text/javascript'>
(function() {
('#forgot_username_link').tipsy({gravity: 'w'});
 });
</script>
<div id="wrapper">
        <div id="doc">
<? if (!$session->logged_in)   {
        if($browser != $ie6){
?>
            <div id="header">
            <table width="925">
                        <tr>
                            <td align="left" valign="top">
                                <img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/pep_logo.jpg" alt="logo" style="margin-left:-5px"/>
                            </td>
                         <td align="right" valign="top">
                             <table>
                                 <tr>
                                    <td align="right" valign="top">
                                        <div class="topnav">
                                             <a href="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/blog" target="_blank"><img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/wordpress-icon-20.png" alt="Read the latest news on PE Planning"/></a>
                                        </div>
                                    </td>
                                    <td align="right" valign="top">
                                        <div class="topnav">
                                             <a href="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://www.twitter.com/peplanning" target="_blank"><img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/social_tw.jpg" alt="Follow peplanning on Twitter"/></a>
                                        </div>
                                    </td>
                                    <td align="left" valign="top">
                                        <div class="topnav">
                                            <a href="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://www.facebook.com/pages/PEplanning/156516011058312" target="_blank"><img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/social_fb.jpg" alt="Find us on FaceBook"/></a>
                                        </div>
                                    </td>
                                    <td align="right" valign="top">
                                            <div class="topnav" style="width:200px;">
                                                <label>already got an account?</label>
                                            </div>
                                    </td>
                                      <td align="right" valign="top">
                                           <div class="topnav" style="width:100px;">
                                                <a href="#" class="signin"><span>sign in</span></a>
                                            </div>
                                            <fieldset id="signin_menu" class="fix-z-index">
                                                <form method="post" id="signin" action="process.php">
                                                    <label for="username">Username</label>
                                                    <div class="signin_input_div">
                                                        <input id="username" name="username" value="" title="username" tabindex="4" type="text" />
                                                    </div>
                                                    <label for="password">Password</label>
                                                    <div class="signin_input_div">
                                                        <input id="password" name="password" value="" title="password" tabindex="5" type="password" />
                                                    </div>
                                                    <div class="signin_submit_div">
                                                        <input id="signin_submit" value="Sign in" tabindex="6" type="submit" />
                                                    </div>
                                                    <input id="sublogin" name="sublogin" type="hidden" value="1" />
                                                    <a class="forgot" href="/tplan/code/resend_password.php">Forgot your password?</a>
                                                </form>
                                            </fieldset>
                                    </td>
                        <? } else {?>
                        
                                    <td align="right" valign="top">
                                        <div class="topnav"><label> already got an account?</label>
                                        </div>
                                    </td>
                                     <td align="right" valign="top">
                                        <div class="topnav">
                                             <a href="/tplan/code/login.php">sign in</a>
                                        </div>
                                    </td>
                        <? }?>
                                 </tr>
                                 <tr>
                                      <td colspan="5" align="right">
                                        <div  class="topnav">
                                            <div class="signup_submit_div"> <input alt="Sign up." class="btn btn-m" style="padding-right:35px;padding-top: 0px;" type="submit" value="Free Sign Up" onclick="document.location='https://<?echo $_SERVER['SERVER_NAME']?>/tplan/code/signup.php'" /></div>
                                        </div>
                                    </td>
                                 </tr>
                             </table>
                         </td>
                       </tr>
                         <tr>
 <!--                           <td align="left" valign="top" style="height:100px;">
                                       <?php
                                       $title="level_0_blurb";
                                       $page = get_page_by_title($title);
                                        $content = apply_filters('the_content', $page->post_content);
                                         echo $content; ?>
                           </td>
    -->
                             <td align="left" colspan="2">
                                 <div id=newsticker-demo>
                                     <div class="title"><label> What's new @ PE Planning?</label>
                                     </div>
                                     <div class="newsticker-jcarousellite">
                                         <ul>
                                          <?  
                                             // Get the last 4 posts.
                                             $myNewsNum = $_POST['newsnum'];
                                            query_posts('p='.$myNewsNum);
                                            while (have_posts()) : the_post(); ?>
                                            <li>
                                                <div class="info">
                                                <a href="http://<?echo $_SERVER['SERVER_NAME']?>/blog/?p=<? the_id(); ?>" target="_blank"><? the_title(); ?></a>
                                                 <span class="cat"><? the_content(); ?></span>
                                                     </div>
                                                     <div class="clear"></div>
                                            </li>
                                              <? endwhile;?>
                                         </ul>
                                     </div>
                                 </div>
                             </td>
                        </tr>
            </table>
            </div>
<? } else { $userinfo=$database->getUserInfo($_SESSION['username']);?>
            <div id="header">
            <table width="925">
                        <tr>
                            <td align="left" valign="top">
                                <img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/pep_logo.jpg" alt="logo" style="margin-left:-5px"/>
                            </td>
                         <td align="right" valign="top">
                             <table>
                                 <tr>
                                     <td align="right" valign="top">
                                        <div class="topnav">
                                             <a href="http://<?echo $_SERVER['SERVER_NAME']?>/blog" target="_blank"><img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/wordpress-icon-20.png" alt="Follow peplanning on Twitter"/></a>
                                        </div>
                                    </td>
                                    <td align="right" valign="top">
                                        <div class="topnav">
                                             <a href="http://www.twitter.com/peplanning" target="_blank"><img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/social_tw.jpg" alt="Follow peplanning on Twitter"/></a>
                                        </div>
                                    </td>
                                    <td align="left" valign="top">
                                        <div class="topnav">
                                            <a href="http://www.facebook.com/pages/PEplanning/156516011058312" target="_blank"><img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/social_fb.jpg" alt="Find us on FaceBook"/></a>
                                        </div>
                                    </td>
                                    <td align="right" valign="center">
                                        <div class="topnav">
                                        <? if ($userinfo['userlevel']==9) echo "<a href='http://".$_SERVER['SERVER_NAME']."/tplan/DB_Maintenance/index.php'>admin</a>&nbsp;|&nbsp";?>
                                        hello&nbsp;<a href="https://<?php echo $_SERVER['HTTP_HOST']?>/tplan/code/account.php"><? echo $_SESSION['username']?></a>&nbsp;|&nbsp<a href="process.php">sign out</a>&nbsp;|&nbsp<a href="main.php#help">help</a>
                                        </div>
                                    </td>
                                 </tr>
                                    <tr>
                                    <td colspan="4" align="right" valign="center">
                                        <div class="topnav">
                                <? if ($userinfo['userlevel']==1) {?><div class="signup_upgrade_div"><input alt="Upgrade" class="btn btn-m" style="padding-right:30px;padding-top: 0px;" type="submit" value="Subscribe" onclick="document.location='code/subscribe.php'" /></div><? }?>
                                        </div>
                                    </td>
                            </tr>
                             </table>
                         </td>
                        </tr>
                <tr>
<!--                           <td align="left" valign="top" style="height:100px;">
                                       <?php $title="level_".$userinfo['userlevel']."_blurb";
                                       $page = get_page_by_title($title);
                                        $content = apply_filters('the_content', $page->post_content);
                                         echo $content; ?>
                           </td>
-->                     <td align="left" style="height:100px;" colspan="2">
                                 <div id=newsticker-demo><div class="title"><label> What's new @ PE Planning?</label>
                                     </div>
                                     <div class="newsticker-jcarousellite">
                                         <ul>
                                          <?
                                             // Get the last 4 posts.
                                             $myNewsNum = $_POST['newsnum'];
                                            query_posts('p='.$myNewsNum);
                                            while (have_posts()) : the_post(); ?>
                                            <li>
                                                <div class="info">
                                                <a href="/blog/?p=<? the_id(); ?>" target="_blank"><? the_title(); ?></a>
                                                 <span class="cat"><? the_content(); ?></span>
                                                     </div>
                                                     <div class="clear"></div>
                                            </li>
                                              <? endwhile;?>
                                         </ul>
                                     </div>
                                 </div>
                             </td>
            </tr>
            </table>
</div>
 <?}?>
 
        
        <!-- pagination -->
        <div id="gettingstarted-feature" class="pager pager-with-tabs" style="position:relative">
            <ul id="gettingstarted-nav" class="pager-tabs">
                <li id="intro-link" class="first"><a href="#feature-intro">Welcome</a></li>
                <? if ($userinfo['userlevel']!=2){?><li id="plan-link" class="selected"><a href="#feature-plan">Create Plans</a></li><?php }?>
                <li id="plans-link" class="selected"><a href="#feature-plans">My Plans</a></li>
                <li id="assessment-link" class="selected"><a href="#feature-assessment">Assessment </a></li>
                 <li id="help-link" class="last"><a href="#help">Help </a></li>
            </ul>
            <!-- Tabbed Pages content - dynamically add or subtract pages -->
            <div class="pager-content">
            <div style="display:none;" class="gettingstarted-feature-contents" id="feature-intro">
                 <div class="col2">
                    <div id="welcome_container">
                        <div id="welcome_header">
                            <div class="header_text">Welcome to PE Planning. Find out how we can help you transform your PE lessons</div>
                        </div>
                        <div id="welcome_headmaster">
                            <div class="welcome_header">Headteachers</div>
                            <div class="welcome_image"><img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/female_head.jpg" border="none" /></div>
                            <div class="welcome_text">
                                <ul>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/headteacher.php">The whole school subscription option</a></li>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/headteacher.php">National Curriculum linked</a></li>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/headteacher.php">Differentiation, Progression, Assessment for Learning</a></li>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/headteacher.php">Cross Curricular links</a></li>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/headteacher.php">Cost effective</a></li>
                                </ul>
                                 <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/headteacher.php" class="welcome_more">read more...</a>
                            </div>
                            <div class="signup_subscribe_div" style="width:290px;margin:10px;height:40px;"><input alt="Upgrade" class="btn btn-m" type="submit" value="Subscribe" onclick="document.location='code/subscribe.php'" style="padding-left:100px;font-size:20px;" /></div>
                        </div>
                        <div id="welcome_teacher">
                        <div class="welcome_header">Teachers</div>
                        <div class="welcome_image"><img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/2_teachers.jpg" border="none" /></div>
                        <div class="welcome_text">
                            <ul>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/teacher.php">The individual teacher subscription option</a></li>
                                   <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/teacher.php">Save hours of planning time</a></li>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/teacher.php">Providing tools and confidence in PE delivery</a></li>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/teacher.php">Very easy to use</a></li>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/teacher.php">Editable to suit your pupil needs</a></li>
                                </ul>
                             <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/teacher.php" class="welcome_more">read more...</a>
                        </div>
                            <div class="signup_subscribe_div" style="width:270px;margin:10px;height:40px;"><input alt="Upgrade" class="btn btn-m" type="submit" value="Subscribe" onclick="document.location='code/subscribe.php'" style="padding-left:90px;font-size:20px;" /></div>
                        </div>
                        <div id="welcome_all">
                            <div class="welcome_header">Children</div>
                            <div class="welcome_image"><img src="<?if (!empty($_SERVER['HTTPS'])) echo 'https'; else echo 'http';?>://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/children.jpg" border="none" /></div>
                            <div class="welcome_text">
                                 <ul>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/children.php">Better learning outcome for every child</a></li>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/children.php">Appropriately selected activities</a></li>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/children.php">Meet needs of individual pupils</a></li>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/children.php">Engaging, educational and fun</a></li>
                                    <li><a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/children.php">Assessment for Learning tools</a></li>
                                </ul>
                                 <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/children.php" class="welcome_more">read more...</a>
                            </div>
                            <div class="signup_subscribe_div" style="width:290px;margin:10px;height:40px;"><input alt="Upgrade" class="btn btn-m" type="submit" value="Subscribe" onclick="document.location='code/subscribe.php'" style="padding-left:100px;font-size:20px;" /></div>
                        </div>
                        <div id="footer_headmaster">
                             <div class="footer_text">
                               <p style="*margin-right:5px;"><b>"brilliant and innovative resource…”</b> - Trish Gavins, Headteacher  (Whetley Primary School )<a href="#" class="head_more"><span>read more...</span></a></p>
                               <fieldset id="headteacher_more" class="fix-z-index"><p>"I'm really impressed with the website. It provides a brilliant and innovative resource for any adult teaching PE, whatever their level of expertise. It allows teachers to produce tailor made high quality PE planning with a wide range of fun sports activities that really work in practice with the children. It is quick and easy to use and can save hours of planning time. The expert advice and specialist knowledge within the lesson plans ensure that teachers can plan for differentiation and progression. I would highly recommend the website as a planning tool for PE."</p></fieldset>
                            </div>
                             
                        </div>
                        <div id="footer_teacher">
                             <div class="footer_text">
                                <p style="*margin-right:5px;"><b>“This resource has enabled me to teach PE with confidence...”</b> - Laura Cawood, Teacher (Princeville Primary School)<a href="#" class="teach_more"><span>read more...</span></a></p>
                                <fieldset id="teacher_more" class="fix-z-index"><p>"PE Planning has made a massive difference to me and my class.  I can now give my class high quality PE lessons with very little subject knowledge, I found the set plan option suited me better at first but now I create my own unique lessons using the custom option, I had no idea I could teach my class what a ‘fling throw’ is!! This resource has enabled me to teach PE with confidence."</p></fieldset>
                             </div>

                        </div>
                        <div id="footer_all">
                             <div class="footer_text">
                                 <p style="*margin-right:5px;"><b>“tools to differentiate and support each individual child…”</b> – Richard Logan, Director (Sports (UK) Ltd)<a href="#" class="child_more"><span>read more...</span></a></p>
                                 <fieldset id="children_more" class="fix-z-index"><p>"My company provides PE to many primary schools throughout the north of England.  I insist on all my PE Coaches using the PE Planning website as it ensures that all aspects of National Curriculum PE are covered.  Over the years I have learnt that my clients’ priority is providing the best for every child at every level, the PE Planning website provides the tools to differentiate and support each individual child regardless of their natural ability."</p></fieldset>
                                </div>

                        </div>
                    </div>
                     
                </div>
           </div><!-- end tab4-->

<? if ($userinfo['userlevel']!=2){?>
            <!-- tab 1 - select lessons -->
                <div style="display: none;" class="gettingstarted-feature-contents" id="feature-plan">
                    <div class="col2">
                        <form name="myform" method="post">
                           <table>
                                <tr>
                                    <td>
                                        <h3>Step 1.&nbsp;&nbsp;</h3>
                                    </td>
                                    <td>
                                        <h4>At what National Curriculum level are you going to teach this unit of work?&nbsp;&nbsp;</h4>
                                    </td>
                                    <td>
                                        <h4>
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
                                        </h4>
                                    </td>
                                </tr>
                            </table>
                             <table>
                                <tr>
                                    <td>
                                        <h3>Step 2.&nbsp;&nbsp;</h3>
                                    </td>
                                    <td>
                                        <h4> Select an activity :&nbsp;&nbsp;</h4>
                                    </td>
                                    <td>
                                        <div id="topic">
                                        <h4>
                                            <select name="sel_topic" id ="sel_topic" size="1">
                                                <? if ($session->logged_in){?>
                                                <option value="0">Select Level</option>
                                                <?php }else{?>
                                                <option value="0">Sign In</option>
                                                <?php }?>
                                            </select>
                                        </h4>
                                        </div>
                                    </td>
                              </tr>
                           </table>
                           <table>
                                <tr>
                                    <td>
                                        <h3>Step 3.&nbsp;&nbsp;
                                        </h3>
                                    </td>
                                    <td>
                                        <h4> Enter the number of lessons to be delivered in this unit of work:&nbsp;&nbsp;</h4>
                                    </td>
                                    <td id="num_lessons_cell">
                                        <h4><select name="numLessons" id="numLessons">
                                                <? if ($session->logged_in){?>
                                                <option value="0">Select Level</option>
                                                <?php }else{?>
                                                <option value="0">Sign In</option>
                                                <?php }?>
                                                </select><br />
                                        </h4>
                                    </td>
                                    
                                 </tr>
                            </table>
                            <table>
                                <tr valign="middle">
                                    <td>
                                        <h3>Step 4.&nbsp;&nbsp;</h3>
                                    </td>
                                    <td>
                                        <h4>Give your unit of work a title: eg. Class 3A Hockey:&nbsp;&nbsp;</h4>
                                    </td>
                                    <td>
                                        <h4>
                                            <input type="text" size="30" maxlength="50" name="description" id="description"/>
                                        </h4>
                                    </td>
                                </tr>
                            </table>
                            <table>
                                <tr>
                                   <td width="240px">
                                        <h3>Step 5.&nbsp;&nbsp;</h3>
                                    </td>
                                    <td valign="middle" width="240px">
                                                    <? if ($session->logged_in){?>
                                                    <div class="predesigned_div"><input alt="Preset" class="btn btn-go" type="button" value="" onclick="javascript:takeAndShake('setPlan')"  style="width:240px;height:116px;font-size:20px;text-align: center;padding-right: 100px;white-space: normal;" /></div>
                                                    <?} else {?>
                                                    <div class="sign_up_div"><input alt="Free Sign Up" class="btn btn-m" type="button" value="" onclick="document.location='https://<?php echo $_SERVER['HTTP_HOST']?>/tplan/code/signup.php'"  style="width:240px;height:116px;font-size:20px;text-align: center;padding-right: 100px;white-space: normal;" /></div><? }?>
                                    </td>
                                    <td>
                                        <h4>&nbsp;&nbsp;or&nbsp;&nbsp;</h4>
                                    </td>
                                    <td  valign="middle" width="240px">
                                                    <? if ($session->logged_in){?>
                                                    <div class="create_your_own_div"><input alt="Upgrade" class="btn btn-go" type="button" value="" onclick="javascript:takeAndShake('newPlan')"  style="width:240px;height:116px;font-size:20px;text-align: center;padding-right: 100px;white-space: normal;" /></div>
                                                    <?} else {?>
                                                    <div class="sign_up_div"><input alt="Free Sign Up" class="btn btn-m" type="button" value="" onclick="document.location='https://<?php echo $_SERVER['HTTP_HOST']?>/tplan/code/signup.php'"  style="width:240px;height:116px;font-size:20px;text-align: center;padding-right: 100px;white-space: normal;" /></div><? }?>
                                    </td>
                                    <td  valign="middle" width="240px">
                                        <div class="help"><a href='javascript:showHelpDialog("steps")'>help</a></div>
                                    </td>
                                  
                                </tr>
                            </table>
                        </form>
                    </div><!--end of div col2 -->
                    
                    
                <div id="passwordDialog" style="display:none" class="fix-z-index">
                <!--<div id="contact_form">-->
                
                 </div>
                <div id="helpDialog" style="display:none;" class="fix-z-index ui-corner-all">
                <!--<div id="contact_form">-->

                 </div>
               </div> <!-- end pager content -->
<?php }?>
            <!-- tab 2 - plans -->
         
        <div style="display:none;" class="gettingstarted-feature-contents" id="feature-plans">
            <div class="col2">
                <div id="accordion2" class="basic">
                    <? if ($session->logged_in)   { GetMyUnits();?>

                         <script type="text/javascript">
                                $('#accordion2').accordion('destroy').accordion({
                                autoHeight: false,
                                collapsible: true,
                                active: 0,
                                header: 'h4',
                                icons: { 'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s' },
                                animated: 'bounceslide',
                                //navigation: true,
                                clearStyle: true
                                });
                                </script>
                
                
                    <? } else {?>
                    <label>Your high quality PE lesson plans will be here once you <a href="https://<?php echo $_SERVER['HTTP_HOST']?>/tplan/code/signup.php">register</a> to use the system</label>
                    <? }?>
                    </div>
                </div>
    	</div>

                <!-- tab 3 - assessment -->
       <div style="display:none;" class="gettingstarted-feature-contents" id="feature-assessment">
            <div class="col2">
                <div id="accordion3" class="basic">
                   <? if ($session->logged_in)   { GetMyAssessments();?>

                         <script type="text/javascript">
                                $('#accordion3').accordion('destroy').accordion({
                                autoHeight: false,
                                collapsible: true,
                                active: 0,
                                header: 'h4',
                                icons: { 'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s' },
                                animated: 'bounceslide',
                                navigation: true,
                                clearStyle: true
                            });
                                </script>
                        
                       
                    <? } else {?>
                    <label>Your PE lesson Assessment options will be here once you <a href="https://<?php echo $_SERVER['HTTP_HOST']?>/tplan/code/signup.php">register</a> to use the system</label>
                    <? }?>
                       </div>
                    </div>
                </div>
                <div style="display:none;" class="gettingstarted-feature-contents" id="help">
                <div class="col2">
                <?php
                        $page = get_page_by_title('help');
                        $content = apply_filters('the_content', $page->post_content);
                        echo $content;
                ?>
                </div>
    	</div>

            </div> <!-- end #pagination -->
        </div><!-- end #doc -->
    <div style="position:relative" id="links">
        <table style="width:924px;background:#829f5e">
            <tr>
                <td valign="top" style="padding-left:50px;">
                   <table>
                        <tr>
                            <th>
                                Enrolment
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <a href="https://<?php echo $_SERVER['HTTP_HOST']?>/tplan/code/signup.php">Free Trial</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="https://<?php echo $_SERVER['HTTP_HOST']?>/tplan/code/subscribe.php">Subscription in Full</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/pricesandservices.php" target="_BLANK">Prices and Services</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/termsandconditions.php">Terms of Use</a>
                            </td>
                        </tr>
                   </table>
                </td>
                <td valign="top">
                   <table>
                        <tr>
                            <th>
                                National Curriculum
                            </th>
                        </tr>
                        <tr>
                            <td><a href="http://curriculum.qcda.gov.uk/key-stages-1-and-2/subjects/physical-education/keystage1/index.aspx" TARGET="_blank">Current NCPE Key stage 1</a>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="http://curriculum.qcda.gov.uk/key-stages-1-and-2/subjects/physical-education/keystage2/index.aspx" TARGET="_blank">Current NCPE Key stage 2</a>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="http://www.education.gov.uk" TARGET="_blank">Department for Education (DfE)</a>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="http://www.qcda.gov.uk" TARGET="_blank">QCDA</a>
                            </td>
                        </tr>
                    </table>
                </td>
                <td valign="top">
                    <table>
                        <tr>
                            <th>
                               Example Plans
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/lesson_sample.php?topic=cricket" target="_BLANK">Cricket Level 1</a>
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/lesson_sample.php?topic=gymnastics" target="_BLANK">Gymnastics Level 1/2</a>
                            </td>
                        </tr>
                       <tr>
                            <td>
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/lesson_sample.php?topic=tennis" target="_BLANK">Tennis Level 2</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/lesson_sample.php?topic=hockey" target="_BLANK">Hockey Level 2/3</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/lesson_sample.php?topic=rounders" target="_BLANK">Rounders Level 3</a>
                            </td>
                        </tr>
                         <tr>
                            <td>
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/lesson_sample.php?topic=athletics" target="_BLANK">Athletics Level 3/4</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/lesson_sample.php?topic=football" target="_BLANK">Football Level 4</a>
                            </td>
                        </tr>
                    </table>
                </td>
 <td valign="top">
                    <table>
                        <tr>
                            <th>
                               Assistance
                            </th>
                        </tr>
                        <tr>
                            <td>
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/help.html" target="_BLANK">Help</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/faq.html" target="_BLANK">Frequently Asked Questions</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/aboutus.html" target="_BLANK">About Us</a>
                            </td>
                        </tr>
                    </table>
                </td>

                
            </tr>
            <tr>
               <td colspan="2" align="left" valign="bottom" style="padding-left:50px;">
                   <table border=0>
                        <tr>
                            <td id="small_links">Contacts: T. 01274 777 800&nbsp;|&nbsp;<a href="mailto:sales@peplanning.org.uk">E. sales@peplanning.org.uk</a>
                            </td>                                        
                        </tr>
                  </table>
              </td>
              <td colspan="2" align="left" valign="bottom">
                   <table border=0>
                        <tr>
                            <td id="small_links">Copyright PEPLANNING 2010. All rights reserved&nbsp;|&nbsp;<a href="http://<?php echo $_SERVER['HTTP_HOST']?>/tplan/termsandconditions.php">Terms of Use</a>&nbsp;|&nbsp;<a href="http://www.itfacilitas.co.uk" TARGET="_blank">Powered by IT Facilitas</a>
                            </td>                                        
                        </tr>
                  </table>
              </td> 
           </tr>
      </table>
    </div>
</div>
</div>
</body>
</html>
