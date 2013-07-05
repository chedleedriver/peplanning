<?php
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
$demo_id=$_GET['demo_id'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | Demonstration</title>
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
       <?php include("header.php")?>
    <div id="doc-demo">
        <table width="100%">
            <tr>
                <td width="15%">
                    <h6>How to create a plan</h6><a href="demo.php?demo_id=Knc9Mws5_i4"><img src="http://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/demo.png" alt="demo" border="0"/></a>
                </td>
                <td width="85%" rowspan="3" valign="top">
                        <iframe  width="900" height="540" src=<?php echo "http://www.youtube.com/embed/".$demo_id."?wmode=transparent&rel=0&amp;hd=1"?> frameborder="0"></iframe>
                       <p>Now you know how, why not <a class="quotes-links" href="createplan-demo.php">try creating a plan yourself</a> or if you have seen enough and you are ready you could <a class="quotes-links" href="register.php">  register for PE Planning  </a> otherwise, for <a class="quotes-links" href="index.php"> everything else</a>,  you can return to the main site</p>
                </td>

            </tr>
            <tr>
                <td width="15%">
                    <h6>How to print a plan</h6><a href="demo.php?demo_id=kn9pBloMW40"><img src="http://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/demo-print.png" alt="demo" border="0"/></a>
                </td>
            </tr>
            <tr>
                <td width="15%">
                    <h6>How to edit a plan</h6><a href="demo.php?demo_id=023Hn_c3wm8"><img src="http://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/demo-edit.png" alt="demo" border="0"/></a>
                </td>
            </tr>
        </table>
    </div>
    <?php include("footer.php")?>
    </body>
</html>
