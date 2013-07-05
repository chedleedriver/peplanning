<? include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
//include ("session.php"); //this is to check they are logged in, you will need this to get the login working
$topic=$_GET['topic'];
$level=$_GET['level'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="ltr" xml:lang="en-GB" xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">

    <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <title>PE Planning | My Plans</title>

    <link href="/tplan/css/peplanning/jquery-ui-1.7.3.custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="index_files/content.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="index_files/maincss.css" media="screen"/>
    </head>

    <body id="central" class="portal-page locale-en-GB portal-page js platform-windows">
    <script type="text/javascript" src="/tplan/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="/tplan/js/jquery-ui-1.7.2.custom.min.js"></script>
    <script type="text/javascript" src="/tplan/js/mainScripts.js"></script>
    <script type="text/javascript" src="/tplan/js/jquery.form.js"></script>
    <script>
    $(function() {
	$("#helpDialog").dialog({
				buttons: {  },
				modal:false,
				position:'top',
				width:600,
				minHeight:400,
				title:"Help",
				autoOpen:false
	 });

});
    </script>
    <div id="wrapper">
       <div id="doc" style="background: url(index_files/new_bg3.jpg) no-repeat;">
           <div style="position:absolute;top:30px;left:750px" id="topnav">
               <a href="/tplan/main.php" class="ui-widget">back to home page</a>
           </div>
           <div id="gettingstarted-featured" class="pager pager-with-tabs">
               <div class="gettingstarted-featured-contents" id="page-feature-learn" style="position:absolute;top:200px;left:25px">
                   <table border="0" width="800px">
                       <tr><td><h3>My Plans</h3></td>
                       <td> <div class="help" style="margin:0 0 20px 20px;position:absolute;right:120px;"><a href='javascript:showHelpDialog("freeplans")'>what do I do?&nbsp;</a><img src="/tplan/images/information.gif"></div></td>
                       </tr>
                       <tr>
                           <td align="left"colspan="2">
                               <div id="accordion2" class="basic" >
                                    <? GetMyFreeUnits($_GET['topic'],$_GET['level']);?>
                               </div>
                           </td>
                                              </tr>
                   </table>
                   
               </div>
           </div>
           <div id="helpDialog" style="display:none;" class="fix-z-index ui-corner-all">
                <!--<div id="contact_form">-->

                 </div>
       </div><!-- end #doc -->
    </div><!-- end #wrapper -->
    </body>
</html>