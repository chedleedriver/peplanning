<?php
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | PEteacher</title>
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
    <div id="doc"  class="products"">
        <table width="100%">
        <tr>
        <td align="center" valign="middle">
        <table width="950px">
            <tr>
                <td colspan="2">
                    <h1>
                        PEteacher
                    </h1>
                </td>
            </tr>
            <tr>
                <td width="20%">
                    <img src="images/pe-teacher-photo.jpg"  border="0" />
                </td>
                <td width="80%">
                    <p>
                        Making sure PE is relevant, fun and engaging is our passion, so let us do your planning for you! We believe all the plans in our resource are a reflection of us, that’s why we strive to ensure every child has an enjoyable and engaging experience through inspirational PE.
                    </p>
                    <p>
                        Finding the activities which actually work and can be easily delivered is always going to be a challenge….. but not with us! All you need to do is  tell us the national curriculum level your children are working at and the sport you wish to teach then we'll do the hard work for you!
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

                    <p>The individual teacher subscription cost is £60 + £12 VAT, a total of £72 per annum</p>
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
                    
                    <p>Whether it be a one off PE lesson or a full unit of work, you will get a comprehensive, high quality plan which you can teach with confidence. Every activity will be relevant to the level of your children, with ways to progress or differentiate activities you can be sure to meet all their needs. </p>
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
                              <td valign="middle" align="left"> <a href="subscribe_teacher.php"><img src="images/buyme.png" border="0"/>.</a> </td>
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