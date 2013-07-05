<?php
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | Contact Us</title>
        <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" media="screen"/>
    </head>
    <body id="contact">
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>"></script>
   <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>"></script>
<?php include("header.php")?>
<div id="friends-doc"  class="friends">
<div class="colmask doublepage">
	<div class="colleft">
		<div class="col1"> 
         <h1>Contact Us</h1>
        <h2>We are here to help</h2>
        <p>You may find you require some guidance or have questions relating to a particular area of PEplanning. We are always available to help, please contact us on the details below:</p>
        <p>Contact telephone number</p>
        <p style="margin-left:20px">01535 644777 or 01535 649403</p>
        <p>Email enquiries:</p>
        <p style="margin-left:20px">General Enquiries</p>
        <a style="margin-left:40px" href="mailto:matt@peplanning.org.uk">Matt@PEPlanning.org.uk</a>
        <p style="margin-left:20px">Sales Enquiries</p>
        <a style="margin-left:40px" href="mailto:matt@peplanning.org.uk">Matthew.Dykes@PEPlanning.org.uk</a>
        <p style="margin-left:20px">Content/How to use Enquiries</p>
        <a style="margin-left:40px" href="mailto:richard.logan@peplanning.org.uk">Richard.Logan@PEPlanning.org.uk</a>
        <p style="margin-left:20px">IT Support</p>
        <a style="margin-left:40px" href="mailto:steve@peplanning.org.uk">Steve@PEPlanning.org.uk</a>
        <p>Address:</p>
        <p style="margin-left:20px;margin-bottom:0">Unit E</p> 
         <p style="margin-left:20px;margin-top:0;margin-bottom:0">Hawkcliffe Works</p>
        <p style="margin-left:20px;margin-top:0;margin-bottom:0">Hebden Road</p>
        <p style="margin-left:20px;margin-top:0;margin-bottom:0">Oxenhope</p>
        <p style="margin-left:20px;margin-top:0;margin-bottom:0">West Yorkshire</p>
        <p style="margin-left:20px;margin-top:0;margin-bottom:0">BD22 9SY</p>        
     
                </div>
        <div class="col2" style="*margin-top:1.5em;">
        <!--            <img src="images/collage.jpg" border="0"/>-->
        </div>
    </div>
</div>
</div>
     <?php include("footer.php")?>
    </body>
</html>