<?php
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | Products</title>
        <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" media="screen"/>
    </head>
    <body id="products">
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>"></script>
   <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>"></script>
<?php include("header.php")?>
    <div id="friends-doc"  class="friends">
      <h1>What our customers think</h1>
                              <p>"I'm really impressed with the website. It provides a brilliant and innovative resource for any adult teaching PE, whatever their level of expertise. It allows teachers to produce tailor made high quality PE planning with a wide range of fun sports activities that really work in practice with the children. It is quick and easy to use and can save hours of planning time. The expert advice and specialist knowledge within the lesson plans ensure that teachers can plan for differentiation and progression. I would highly recommend the website as a planning tool for PE."</p><h2> - Trish Gavins, Headteacher (Whetley Primary School)</h2>
                               <p>"PE Planning has made a massive difference to me and my class.  I can now give my class high quality PE lessons with very little subject knowledge, I found the set plan option suited me better at first but now I create my own unique lessons using the custom option, I had no idea I could teach my class what a ‘fling throw’ is!! This resource has enabled me to teach PE with confidence."</p><h2> - Laura Cawood, Teacher (Princeville Primary School)</h2>
                               <p>"Having worked in Primary school PE for the past seven years, I am always on the lookout for teaching resources that provide fresh and stimulating activities. PE Planning enables me to access a range of sports with so many activities for each. The way they have linked their activities to the National Curriculum is very reassuring, it is the best resource I have found by far. "</p><h2> – Ben Foster, PE Development Officer</h2>
                               <p>"PEplanning really understand National Curriculum and PE, their units of work are fantastic"</p><h2> – Jo Hayden, CompleteKidz</h2>
                               <p>"I am a PE Coach currently working in a primary school teaching from Reception pupils through to Year 6. The PE Planning website is very useful as it provides a huge range of activity options in different sports. It allows me to differentiate between plans through picking and choosing which activities I want to do, as well enabling me to ensure I am reaching the appropriate National Curriculum level for each particular class."</p><h2>Jessica Baker, PE Coach - Thornbury Primary School</h2>
                               <p>"PE planning gives me confidence to teach sports which I know very little about, the endless amount of activities means I can keep PE fresh and engaging. "</p><h2> - Jenna Mudd, Victoria Primary School</h2>
    </div>
     <?php include("footer.php")?>
    </body>
</html>