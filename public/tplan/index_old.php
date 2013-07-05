<?php
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
require('../blog/wp-blog-header.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | Welcome to peplanning.org.uk</title>
        <link rel="stylesheet" type="text/css" href="http://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/peplanning/jquery-ui-1.7.3.custom.css"/>
        <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" media="screen"/>
    </head>
    <body id="home">
    <script type="text/javascript"src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jcarousellite_1.0.1c4.js?<?=time()?>"></script>
<script type="text/javascript">
        /* google analytics*/
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-16957975-1']);
        _gaq.push(['_trackPageview']);

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
 
        </script>
    <script type="text/javascript">
        $(document).ready(function() {
        $(function() {
            $(".newsticker-jcarousellite").jCarouselLite({
                vertical: true,
                visible:1,
                auto:5000,
                speed:5000,
                mousewheel:true
                });
            });
        });
</script>
    <?php include("header.php")?>
    <div id="doc">
        <table width="1000px" id="doc-table" cellspacing="0" cellpadding="5" height="100%">
            <tr>
                <td class="leftcol" width="70%" valign="top" rowspan="4">
                 <table cellpadding="10">
                 <tr>
                <td height="100px" colspan="2" valign="top">
                    <h1>
                        <b>PEplanning</b> the best place for all your primary school PE lesson plans
                    </h1>
                    
                </td>
                </tr>
             <tr>
                <td height="125px" width="170px"><a href="peschool.php"><img src="images/pe-school-photo.jpg"  border="0"/></a></td>
                <td valign="middle" class="productblurb">
                    <table>
                        <tr>
                            <td colspan="3"><h6><b>PEschool</b> is the PE lesson planning application for the whole school. Each teacher has their own personal account from which they can create exciting, stimulating and rewarding lesson plans for each and everyone of their children. <a href="peschool.php"> read more...</a></h6></td>
                        </tr>
                            <tr>
                                <td valign="middle" align="left"> <a href="register.php"><img src="images/tryme.png" border="0"/>.</a> </td>
                                <td width="50px;"></td>
                                <td valign="middle" align="right"> <a href="subscribe_school.php"><img src="images/buyme.png" border="0"/>.</a> </td>
                            </tr>
                     </table>
                </td>
            </tr>
            <tr>
                 <td height="125px" width="170px"><a href="peteacher.php"><img src="images/pe-teacher-photo.jpg"  border="0"/></a></td>
                 <td valign="middle" class="productblurb">
                     <table>
                            <tr>
                                <td colspan="3"><h6><b>PEteacher</b> is the PE lesson planning application for the individual. Just the thing for a busy teacher, in minutes you can produce all the lesson plans you need ready to teach.<a href="peteacher.php"> read more...</a></h6></td>
                            </tr>
                            <tr>
                                <td valign="middle" align="left"> <a href="register.php"><img src="images/tryme.png" border="0"/>.</a> </td>
                                <td width="50px;"></td>
                                <td valign="middle" align="right"> <a href="subscribe_teacher.php"><img src="images/buyme.png" border="0"/>.</a> </td>
                            </tr>
                     </table>
                </td>
            </tr>
            <tr>
                <td height="125px" width="170px"><a href="pecoach.php"><img src="images/pe-coach-photo.jpg" border="0"/></a></td>
                <td valign="middle" class="productblurb">
                    <table>
                        <tr>
                            <td colspan="3"><h6><b>PEcoach</b> is the PE lesson planning application for the professional coach delivering physical education in primary school settings.<a href="pecoach.php"> read more...</a></h6></td>
                            <tr>
                                <td valign="middle" align="left"> <a href="register.php"><img src="images/tryme.png" border="0"/>.</a> </td>
                                <td width="50px;"></td>
                                <td valign="middle" align="right"> <a href="subscribe_coach.php"><img src="images/buyme.png" border="0"/>.</a> </td>
                            </tr>
                     </table>
                </td>
            </tr>
       </table>
                </td>
                <td class="rightcol" width="30%" valign="top" height="15px"><h6><b>Not sure what to do?</b></h6></td>
             </tr>
             <tr>
               <td class="rightcol"  width="30%" valign="top" height="180px"><h6>How to create a plan</h6><a href="demo.php?demo_id=vkme5FWClr4"><img src="http://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/demo.png" alt="demo" border="0"/></a></td>
            </tr>
            <tr>
                <td class="rightcol" width="30%" valign="top" height="180px"><h6>How to print a plan</h6><a href="demo.php?demo_id=kn9pBloMW40"><img src="http://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/demo-print.png" alt="demo" border="0"/></a></td>
            </tr>
            <tr>
                <td width="30%" valign="top" height="180px"><h6>How to edit a plan</h6><a href="demo.php?demo_id=023Hn_c3wm8"><img src="http://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/demo-edit.png" alt="demo" border="0"/></a></td>
            </tr>
       </table>
    </div>
    <?php include("footer.php")?>
    </body>
</html>
