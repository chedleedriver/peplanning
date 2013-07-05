<?php
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | PEcoach</title>
        <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" media="screen"/>
    </head>
    <body id="products">
    <script type="text/javascript"src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>"></script>
   <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>"></script>
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
    <div id="doc"  class="products">
        <table width="100%">
        <tr>
        <td align="center" valign="middle">
        <table width="925px">
            <tr>
                <td colspan="2">
                    <h1>
                        PEcoach
                    </h1>
                </td>
            </tr>
            <tr>
                <td width="20%">
                    <img src="images/pe-coach-photo.jpg"  border="0" />
                </td>
                <td width="80%">
                    <p>
                        Our experience delivering PE in schools gives us the understanding of the importance of high quality lesson planning. Our unique resource not only creates comprehensive lesson plans, it also produces teacher and pupil assessment for learning to compliment all units of work.</p>
                    <p>
                        With PEcoach you get a flexible approach to meet your requirements. We can facilitate the needs of the individual Coach or provide established Sports Coach companies with a PE planning resource which provides much more than just activities.
                    </p>
                 </td>
            </tr>
        </table>
        </td>
        </tr>
       <tr>
        <td align="center" valign="middle">
        <table width="925px">
           <tr>
                <td>
                    
                    <p>Using PEcoach is easy, you tell us the national curriculum level the children are working at and the sport you wish to teach. Our unique resource will then create comprehensive, high quality lesson plans which you can teach with confidence, safe in the knowledge that every activity will allow the children to learn and develop. Choose to plan one off lessons or full schemes of work, it’s so quick and easy with PEcoach.</p>
                    <p>
                       PEcoach is full of National curriculum linked activities, with differentiation and progressions throughout allowing you or your coaching staff to teach with confidence, keeping all children fully involved in the learning process by being engaged and challenged in a fun way.
                    </p>
                </td>
            </tr>
         </table>
        </td>
        </tr>
       <tr>
        <td align="center" valign="middle">
        <table width="925px">
           <tr>
                <td width="80%">
                    <p>PEcoach is flexible and can be tailored to meet your needs.
                    </p>
                    <p>Ring us on 01535 649 403 or email <a href="mailto:matt@peplanning.org.uk">matt@peplanning.org.uk</a> for more information
                    </p>
                    <h2>
                        This way we can provide you with the best possible solution to planning your PE.
                    </h2>
                </td>
                <td width="20%" rowspan="2">
                    <img src="images/clipboard_200.png"  border="0" />
                </td>
            </tr>
           <tr>
                <td width="80%">
                    <table>
                        <tr>
                            <td valign="middle" align="right"> <a href="createplan-demo.php"><img src="images/tryme.png" border="0"/>.</a> </td>
                            <td width="50px;"></td>
                             <td valign="middle" align="left"> <a href="subscribe_coach.php"><img src="images/buyme.png" border="0"/>.</a> </td>
                        </tr>
                    </table>
                </td>
               <td></td>
            </tr>
        </table>
        </td>
        </tr>
       </table>
 </div>
     <?php include("footer.php")?>
    </body>
</html>