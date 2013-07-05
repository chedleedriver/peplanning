<?php
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | PEschool</title>
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
    <div id="doc"  class="products" style="height:850px;">
        <table width="100%">
        <tr>
        <td align="center" valign="middle">
        <table width="950px">
            <tr>
                <td colspan="2">
                    <h1>
                        PEschool
                    </h1>
                </td>
            </tr>
            <tr>
                <td width="20%">
                    <img src="images/pe-school-photo.jpg"  border="0" />
                </td>
                <td width="80%">
                    <p>
                        With PEschool everyone in school can enjoy a PE planning resource full of National Curriculum linked activities. Our carefully constructed lesson plans are easy to follow, with differentiation and progressions throughout giving your teaching staff the confidence to deliver high quality lessons in all sports. Our plans are designed to keep all children fully involved in the learning process by being engaged and challenged in a fun way.</p>
                 </td>
            </tr>
        </table>
        </td>
        </tr>
       <tr>
        <td align="center" valign="middle">
        <table width="950px">
           <tr>
                <td>
                    
                    <p>Using PEschool is easy, you tell us the national curriculum level your children are working at, the sport you wish to teach and our unique resource will then create a comprehensive lesson plan you can teach with confidence, safe in the knowledge that every activity will allow the children to learn and develop.</p>
                    <p>
                        What’s more each plan or unit of work is fully editable allowing you to tailor your lessons to suit the individual needs of your children. That’s not all, our unique resource will also create teacher and pupil assessment for learning to compliment all lesson plans or units of work.
                    </p>
                </td>
            </tr>
         </table>
        </td>
        </tr>
<tr>
        <td align="center" valign="middle">
        <table width="950px">
           <tr>
                <td>
                    <p>Prices</p>
                    <ul class="price-list">
                        <li>1 Form Entry Schools - £175 + VAT.</li>
                        <li>2 Form Entry Schools - £350 + VAT.</li>
                        <li>3 Form Entry Schools - £525 + VAT.</li>
                        <li>For mixed form entry schools, please contact Matthew on 01535 649 403.</li>
                    </ul>
                </td>
            </tr>
         </table>
        </td>
        </tr>
       <tr>
        <td align="center" valign="middle">
        <table width="950px">
           <tr>
                <td width="80%">
                    <p>We are committed to what we do, constantly updating our resource, adding new sports and topics as well as further developing our existing content to provide you with the complete PE resource.
                    </p>
                    <p>Ring us on 01535 649 403 or email <a href="mailto:matt@peplanning.org.uk">matt@peplanning.org.uk</a> for more information
                    </p>
                    <h2>
                        With PEPlanning on board, planning and teaching PE will never be the same again.
                    </h2>
                </td>
                <td width="20%">
                    <img src="images/clipboard_200.png"  border="0" />
                </td>
            </tr>
           <tr>
                <td width="80%">
                    <table>
                        <tr>
                            <td valign="middle" align="right"> <a href="createplan-demo.php"><img src="images/tryme.png" border="0"/>.</a> </td>
                            <td width="50px;"></td>
                            <td valign="middle" align="left"> <a href="subscribe_school.php"><img src="images/buyme.png" border="0"/>.</a> </td>
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