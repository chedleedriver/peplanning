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
    <script type="text/javascript"src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery.cycle.lite.js?<?=time()?>"></script>
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
    <div id="doc">
 <div class="colmask fullpage">
	<div class="col1" style="text-align:center">
		<!-- Column 1 start -->
		<h2 style="color:#829F5E;">Partners</h2>
		<p>PE Planning are very proud to work with some of the very best organisations involved in technology, education and sport</p>
		<!-- Column 1 end -->
	</div>
</div>
   <div class="colmask leftshade">
	<div class="colleft">
		<div class="col1"  style="text-align:center">
			<!-- Column 1 start -->
                        <p><a href="http://www.viglen.co.uk/viglen/Sector/Schools/schools.aspx?GUID=18510739729" target="_blank"><img src="images/viglen.png" border="0"/></a></p>
                         <a class="quotes-links" href="http://www.viglen.co.uk/viglen/Sector/Schools/schools.aspx?GUID=18510739729" target="_blank">Viglen</a>
			<!-- Column 1 end -->
		</div>
		<div class="col2"  style="text-align:center;">
			<!-- Column 2 start -->
                        <p><a href="http://www.itfacilitas.co.uk" target="_blank"><img src="images/itf.png" border="0"/></a></p>
                         <a class="quotes-links" href="http://www.itfacilitas.co.uk" target="_blank">IT Facilitas</a>
			<!-- Column 2 end -->
		</div>
	</div>
    </div>
    <div class="colmask rightshade">
	<div class="colleft">
		<div class="col1"  style="text-align:center">
			<!-- Column 1 start -->
                        <p><a href="http://www.sportsuk.org.uk" target="_blank"><img src="images/sportsuk.png" border="0"/></a></p>
                        <a class="quotes-links" href="http://www.sportsuk.org.uk" target="_blank">Sports UK</a>
			<!-- Column 1 end -->
		</div>
		<div class="col2"  style="text-align:center;">
			<!-- Column 2 start -->
                        <p> <a href="http://www.5-a-day.tv" target="_blank"><img src="images/5-a-dayTV_logo.jpg" border="0"/></a></p>
                        <a class="quotes-links" href="http://www.5-a-day.tv" target="_blank">5-a-Day</a>
			<!-- Column 2 end -->
		</div>
	</div>
    </div>
<div class="colmask fullpage">
	<div class="col1" style="text-align:center">
		<!-- Column 1 start -->
		<h2 style="color:#829F5E;">Like to be a partner?</h2>
		<p>If you would be interested in becoming a partner or would like to find out more about our partnership programme then contact <a href="mailto:steve@peplanning.org.uk" class="quotes-links">steve@peplanning.org.uk</a> or ring him on 0161 929 2039</p>
		<!-- Column 1 end -->
	</div>
</div>
    </div>
    <?php include("footer.php")?>
    </body>
</html>
