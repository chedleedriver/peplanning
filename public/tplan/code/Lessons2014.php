<?php 
include_once($_SERVER["DOCUMENT_ROOT"] . '/../library/tplan_config.php');
include ("lessonfunctions_2.php");
header('Content-Type: text/html; charset=ISO-8859-1');
$get_requests_decoded=base64_decode($_REQUEST['p']);
$get_requests_array=unserialize($get_requests_decoded);
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
<link href="/css/jquery-ui-1.7.3.custom.css?<?php echo time()?>" rel="stylesheet" type="text/css" />
<link href="/css/unit.css?<?php echo time()?>" rel="stylesheet" type="text/css" />
<link href="/css/splashscreen.css?<?php echo time()?>" rel="stylesheet" type="text/css" />
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

<script language="JavaScript" type="text/javascript" src="http://code.jquery.com/jquery-1.8.0.min.js?<?php echo time()?>"></script>
<script language="JavaScript" type="text/javascript" src="http://code.jquery.com/ui/1.8.23/jquery-ui.min.js?<?php echo time()?>"></script>
<script language="JavaScript" type="text/javascript" src="http://<?php echo  $_SERVER['SERVER_NAME']?>/js/jquery.form.js?<?php echo time()?>"></script>
<script language="JavaScript" type="text/javascript" src="http://<?php echo  $_SERVER['SERVER_NAME']?>/js/jquery.splashq.js?<?php echo time()?>"></script>
<script language="JavaScript" type="text/javascript" src="http://<?php echo  $_SERVER['SERVER_NAME']?>/js/jquery.alerts.js?<?php echo time()?>"></script>
<script language="JavaScript" type="text/javascript" src="http://<?php echo  $_SERVER['SERVER_NAME']?>/js/main.js?<?php echo time()?>"></script>
<script language="JavaScript" type="text/javascript" src="http://<?php echo  $_SERVER['SERVER_NAME']?>/js/planLoader2014.js?<?php echo time()?>"></script>
<script language="JavaScript" type="text/javascript"> 
		var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-31237723-1']);
        _gaq.push(['_trackPageview']);

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })(); 
</script>
<script type="text/javascript">
<?php if ($plan_type=="setPlanPrint") {
    $plan_type="setPlan";
    echo "window.alreadyBeen=1;";
}?>
window.userLevel=<?php echo  $user_level?>;
window.userId=<?php echo  $whoami?>;
window.unitId=<?php echo $unit_id?>;
window.planType='<?php echo $plan_type?>';
<?php if ($lesson_number){ $lesson_selector=$lesson_number-1;}else{$lesson_selector=0;}?>
    window.lessonNumber=<?php echo $lesson_selector; ?>;
	
$(document).ready(function(){
      canIEditThis(window.unitId,window.userId);
});
</script>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
        <title>Unit of Work</title>
</head>

<body id="unitBody" bgcolor="#AACC37">
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
