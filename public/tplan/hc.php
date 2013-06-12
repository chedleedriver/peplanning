<?php
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | Helen Clitheroe</title>
        <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" media="screen"/>
    </head>
    <body id="products">
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>"></script>
   <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>"></script>
<?php include("header.php")?>
    <div id="friends-doc"  class="friends">
      <h1>Helen Clitheroe, Olympic Athlete</h1>
      <h2>Helen is a 2 times Olympic Athlete, the current European 3000M Champion and the current 3000M Steeplechase British record holder</h2>
      <p>&quot;I was lucky to be inspired by my Primary School teacher, Frank Green, to start running as an 8 year old he set me on a pathway which has been the focus of my life, to become a champion athlete and to compete for my country.&quot;</p>
      <p>&quot;PE Planning is a fantastic tool which will ensure that all the children in your school will get an opportunity to receive quality PE lessons and achieve their potential in sport&quot;</p>
      <img style="margin-top:1.5em;margin-left:3em" border="0" src="http://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/hc.jpg"/>
      <p style="font-size: x-small">Picture courtesy of Mark Shearman</p>
    </div>
     <?php include("footer.php")?>
    </body>
</html>