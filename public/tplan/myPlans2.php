<? include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="ltr" xml:lang="en-GB" xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">

    <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <title>PE Planning | My Plans</title>
    
    <link href="/tplan/css/peplanning/jquery-ui-1.7.2.custom.css" rel="stylesheet" type="text/css" />
    <link href="/tplan/css/peplanning/jquery-ui-1.7.3.custom.css" rel="stylesheet" type="text/css" />
    
    <script type="text/javascript" src="index_files/util.htm"></script>
    <link rel="stylesheet" type="text/css" href="index_files/reset-fonts-grids.css">
    <link rel="stylesheet" type="text/css" href="index_files/template.css" media="screen">
    <link rel="stylesheet" type="text/css" href="index_files/content.css" media="screen">

    <script type="text/javascript" src="index_files/yahoo-dom-event.js"></script>
    <script type="text/javascript" src="index_files/container_core-min.js"></script>
    <link rel="stylesheet" type="text/css" href="index_files/portal-page.css" media="screen">
    <link rel="stylesheet" type="text/css" href="index_files/getting-started3.css" media="screen">

    </head>

    <!-- this section is complete -->

<body id="central" class="portal-page locale-en-GB portal-page js platform-windows">

<script language="JavaScript" type="text/javascript" src="/tplan/js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="/tplan/js/jquery-ui-1.7.2.custom.min.js"></script>
<script language="JavaScript" type="text/javascript" src="/tplan/js/jquery.layout-1.3.rc5.js"></script>
<script language="JavaScript" type="text/javascript" src="/tplan/js/jquery.bgiframe.min.js"></script>

<script language="JavaScript" type="text/javascript" src="/tplan/js/debug.js"></script>
<script language="JavaScript" type="text/javascript" src="/tplan/js/mainScripts.js"></script>
<script language="JavaScript" type="text/javascript" src="/tplan/js/baseScripts.js"></script>
<script language="JavaScript" type="text/javascript">
$(function() {
	$("#loginDialog").dialog({
				modal:true,
				width:350,
				title:" Sign in to PE Planning",
				dialogClass:'information',
				autoOpen:false
	 });
});
$(function() {
	$("#registerDialog").dialog({
				modal:true,
				width:740,
				title:"Sign Up to PE Planning",
                               	dialogClass:'information',
                                bgiframe: true,
				autoOpen:false
	 });
});

$(function() {
	$("#registerDialog").dialog({
				modal:true,
				width:500,
				title:"Register for PE Planning",
                                dialogClass:'information',
				autoOpen:false
	 });
});


$(function() {
	$("#informationDialog").dialog({
				modal:false,
				width:500,
				title:"Information",
				dialogClass:'information',
				autoOpen:false
	 });
});
$(function() {
	$("#changelogDialog").dialog({
				modal:false,
				width:500,
				title:"System Changes",
				dialogClass:'information',
				autoOpen:false
	 });
});
$(function() {
	$("#contactDialog").dialog({
				modal:true,
				width:250,
				title:"Contact Us",
				dialogClass:'information',
				autoOpen:false
	 });
});
$(function() {
	$("#passwordDialog").dialog({
				modal:true,
				width:450,
				title:"Password Reset for the Planning System",
				dialogClass:'information',
				autoOpen:false
	 });
});
$(function() {
	$("#accountDialog").dialog({
				modal:true,
				width:500,
				title:"Edit your Account Settings",
				dialogClass:'information',
				autoOpen:false
	 });
});
$(function() {
	$('#genreList').accordion({
			autoHeight: false,
			collapsible: true,
			header: 'h3',
			active: false
			 });
});

$(document).ready( function() {
                var $accord2=$("#accordion2").accordion({
                autoHeight: false,
                collapsible: true,
                active: false,
                header: 'h4',
                navigation: true,
                clearStyle: true,
                alwaysOpen: false
        });
});


function clearinputText() {
      document.sform.user.value= "";
}
function clearinputText2() {
      document.signup.user.value= "";
      document.signup.email.value= "";
      document.signup.pass.value= "";
}
   

function setOptions(chosen) {
var selbox = document.myform.topic;

selbox.options.length = 0;
if (chosen == " ") {
  selbox.options[selbox.options.length] = new Option('Please select one of the previous options above first',' ');

}
if (chosen == "1") {
  selbox.options[selbox.options.length] = new Option('Athletics','athletics');

}
if (chosen == "2") {
  selbox.options[selbox.options.length] = new Option('Dance','dance');

}
if (chosen == "3") {
  selbox.options[selbox.options.length] = new Option('Gymnastics','gymnastics');

}
if (chosen == "4") {
  selbox.options[selbox.options.length] = new Option('Hockey','37');
  selbox.options[selbox.options.length] = new Option('Football','38');
  selbox.options[selbox.options.length] = new Option('Rugby','rugby');
  selbox.options[selbox.options.length] = new Option('Basketball','basketball');
  selbox.options[selbox.options.length] = new Option('Netball','netball');
}
if (chosen == "5") {
  selbox.options[selbox.options.length] = new Option('Badminton','badminton');
  selbox.options[selbox.options.length] = new Option('Volleyball','volleyball');
  selbox.options[selbox.options.length] = new Option('Tennis','52');
}
if (chosen == "6") {
  selbox.options[selbox.options.length] = new Option('Orienteering','orienteering');
  selbox.options[selbox.options.length] = new Option('Problem solving','problem solving');
}
if (chosen == "7") {
  selbox.options[selbox.options.length] = new Option('Cricket','cricket');
  selbox.options[selbox.options.length] = new Option('Rounders','rounders');
  selbox.options[selbox.options.length] = new Option('Trigolf','tri-golf');
}
}
</script>


<!--<table align="center" style="width:1000px" height="50px" border=1 cellpadding=0 cellspacing=0>
            <tr align="right">
            <td align="center"><a href="/tplan/main.php"><img src="/tplan/index_files/b2home.jpg" alt="back to homepage"></a>&nbsp;&nbsp;&nbsp;</td>
                                  <td align="center"><img src="/tplan/index_files/vline.jpg"> &nbsp;&nbsp;&nbsp;</td>
                                  <td align="center"><a href="process.php"><img src="/tplan/index_files/signout.jpg">&nbsp;&nbsp;&nbsp;</td>
                                              </tr></table>-->

    <div id="wrapper">

        <!-- table code goes here -->

        <table width="985" height="125"  cellpadding="10" cellspacing="10" align="center" border="0">
            <tr><td align="center" style="background: url(index_files/new_bg3.jpg) no-repeat;">

            <!-- table code is here -->
            <br>
            <table align="right" style="width:250px" height="20px" border=0 cellpadding=0 cellspacing=0>
            <!--<tr align="right"><br><br><br>-->
            <td align="right"><a href="/tplan/main.php"><img src="/tplan/index_files/b2home.jpg" alt="back to homepage"></a>&nbsp;&nbsp;&nbsp;</td>
            <td width="10px"align="right"><img src="/tplan/index_files/vline.jpg"> &nbsp;&nbsp;&nbsp;</td>
            <td align="right"><a href="process.php"><img src="/tplan/index_files/signout.jpg">&nbsp;&nbsp;&nbsp;</td>
            </tr></table>

                    <table width="300" height="125" border="0" cellpadding="0" cellspacing="0" align="center">
                        <!--<tr align="right">-->
                            <!-- <td align="right"> -->

                           
                  
                        <td align="center">
                            <br><br>
                            <!-- <form action="process.php" method="POST" name="sform"> -->
                            <?
                            /* User has already logged in */

                            if($session->logged_in){

                            ?>
                                

                    <?
                    //."<table align=\"right\" cellpadding=0 cellspacing=0><tr><td><br><br><br><br><br><br><br><br><a href=\"userinfo.php?user=$session->username\">My Account </a></table>"
                    //."<table align=\"right\" cellpadding=0 cellspacing=0><tr><td><br><br><br><br><br><br><br><br><a href=\"useredit.php\">Edit Account &nbsp;&nbsp; </a></table> ";
                    //."<table align=\"right\" cellpadding=0 cellspacing=0><tr><td><a href=\"process.php\">Sign out</a>&nbsp;&nbsp;</table>";

                    //echo
                    }
                    ?>
                         <!-- </form> -->
                    <form action="process.php" method="POST" name="sform">

                    <?
                    /* User has already logged in */

                    if($session->logged_in){

                    echo "<table style=\"height:18px\" align=\"right\" cellpadding=0 cellspacing=0><tr valign=\"bottom\">";
                    //.<td valign=\"bottom\"><h5><br><br><br><br><br><br><br><br>Welcome <b>$session->username</b><br> you are logged in. &nbsp;<br><br> <a href=\"process.php\"> sign out</a> </table>" ;
                    //."<table align=\"right\" cellpadding=0 cellspacing=0><tr><td><br><br><br><br><br><br><br><br><a href=\"userinfo.php?user=$session->username\">My Account </a></table>"
                    //."<table align=\"right\" cellpadding=0 cellspacing=0><tr><td><br><br><br><br><br><br><br><br><a href=\"useredit.php\">Edit Account &nbsp;&nbsp; </a></table> ";
                    //."<table align=\"right\" cellpadding=0 cellspacing=0><tr><td><a href=\"process.php\">Sign out</a>&nbsp;&nbsp;</table>";

                    //echo
                    }
                    else{ }    ?>
                </form>
                </td></tr></table>
       </td></tr></table>

    <div id="doc">

         <!-- <div id="main-feature"></div> --><br>

<!-- pagination -->
<div id="gettingstarted-feature" class="pager pager-with-tabs">

    	

        <!-- Tabbed Pages content - dynamically add or subtract pages -->
	<!-- tabs - 1 & 2 & 3 -->

	<div class="pager-content">
            <br><br>
        <!-- tab 2 plans -->

        <div style="display: none;" border="1" class="gettingstarted-feature-contents" id="page-feature-learn">
            <script type="text/javascript"> </script>
            <div class="col2">
            <div id="accordion2" class="basic">
                <table border="0" width="240" align="right">
               <? if($session->logged_in) GetAllMyUnits();?>
                    
                    <td align="left"><br></td>
                </table>
            </div>
                
            </div>
    	    </div>

	<!-- tab 3 assessment -->

        
</div> <!-- end #pagination -->

    </div><!-- end #doc -->
    </div><!-- end #wrapper -->

    
    </div>
    </div>
    </div>

    <script type="text/javascript" src="index_files/utilities.js"></script>
    <script type="text/javascript" src="index_files/sean-pager.htm"></script>

</div>
</div>
</body>
</html>