<? 
include ("lessonfunctions_2.php");
include_once('config.php');
header('Content-Type: text/html; charset=ISO-8859-1');
$get_requests_decoded=base64_decode($_REQUEST['p']);
$get_requests_array=unserialize($get_requests_decoded);
//print_r($get_requests_array);
$plan_type=$get_requests_array['plan_type'];
$admin_flag=$_GET['admin_flag'];
$mode=$get_requests_array['mode'];
$unit_id=$get_requests_array['unit_id'];
$lesson_number=$get_requests_array['lesson_num'];
$whoami=$get_requests_array['my_id'];
$user_level=$get_requests_array['my_level'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="/tplan/css/peplanning/jquery-ui-1.7.3.custom.css?<?=time()?>" rel="stylesheet" type="text/css" />
<link href="/tplan/css/unit.css?<?=time()?>" rel="stylesheet" type="text/css" />
<!--[if ie 6]>
<link href="/tplan/css/unit_ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
<link href="/tplan/css/splashscreen.css?<?=time()?>" rel="stylesheet" type="text/css" />
<style type="text/css"> 
	#splash{
		width: 200px;
		height: 100px;
		background-color: #b7cc79;
		position: absolute;
		z-index: 1200;
		border-right: 1px solid #aaa;
		border-bottom: 1px solid #aaa;
		border-top:1px solid #ccc;
		border-left:1px solid #ccc;
		color: #333;
		-moz-border-radius:4px;
                -khtml-border-radius:4px;
                -webkit-border-radius:4px;
                border-radius:4px;
                font-size:16px;
                font-family:"Lucida Grande",Verdana,Sans-serif;
	}
        .ui-accordion-content{ zoom: 1; }
</style>
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
<script language="JavaScript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js?<?=time()?>"></script>
<script language="JavaScript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js?<?=time()?>"></script>
<script language="JavaScript" type="text/javascript" src="http://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery.form.js?<?=time()?>"></script>
<script language="JavaScript" type="text/javascript" src="http://<?echo $_SERVER['SERVER_NAME']?>/js/jquery.alerts.js?<?=time()?>"></script>
<script language="JavaScript" type="text/javascript" src="http://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/planLoader.js?<?=time()?>"></script>
<script type="text/javascript">
<?if ($plan_type=="setPlanPrint") {
    $plan_type="setPlan";
    echo "window.alreadyBeen=1;";
}?>
window.userLevel=<?echo $user_level?>;
window.userId=<?echo $whoami?>;
window.unitId=<? echo $unit_id?>;
window.planType='<? echo $plan_type?>';
<? if ($lesson_number){ $lesson_selector=$lesson_number-1;}else{$lesson_selector=0;}?>
    window.lessonNumber=<? echo $lesson_selector; ?>;
$(document).ready(function(){
      canIEditThis(window.unitId,window.userId);
});
//$('#splash').corner('4px');
</script>
<!-- <script language="JavaScript" type="text/javascript" src="<? //echo DOC_ROOT?>js/planScripts.js"></script> -->
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
        <title>Unit of Work</title>
</head>

<body id="unitBody">
<!--<form id="lessons" name="lessons" action="save_plan.php?plan_type=<? echo $plan_type?>" method="post">-->
<div id="header">
</div>
<div id="leftcol">
</div>
<div id="target">
</div>
<div id="content" onselectstart="return false">
	<div id="howLong" style="width:300px; visibility:hidden">
	</div>
            <div id="tabs" style="visibility:hidden">
		<ul id='lessons_ul'>
		</ul>
            </div>
	<div id="progressionDialog" style="visibility:hidden">
	</div>
	<div id="differentiationDialog" style="visibility:hidden">
	</div>
	<div id="analysisDialog" style="visibility:hidden">
	</div>
        <div id="helpDialog" style="visibility:hidden">
	</div>
</div>
<div id="rightcol"></div>
<div id="storeArea" style="visibility:hidden"></div>
</body>
</html>
<? //} 
//else echo("<meta http-equiv=\"Refresh\" content=\"0;url=../tplan/main.php\">");?>