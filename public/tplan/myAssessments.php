<? include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
//include ("session.php"); //this is to check they are logged in, you will need this to get the login working
if ($_GET['assessType']==1) $assess_type="Class";
if ($_GET['assessType']==2) $assess_type="Individual";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="ltr" xml:lang="en-GB" xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">

    <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <title>PE Planning | My Assessments</title>

    <link href="/tplan/css/peplanning/jquery-ui-1.7.3.custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="index_files/content.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="index_files/maincss.css" media="screen"/>
    </head>

    <body id="central" class="portal-page locale-en-GB portal-page js platform-windows">
    <script type="text/javascript" src="/tplan/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="/tplan/js/jquery-ui-1.7.2.custom.min.js"></script>
    <script type="text/javascript" src="/tplan/js/mainScripts.js"></script>
    <script type="text/javascript" src="/tplan/js/jquery.form.js"></script>
    <script type="text/javascript">

$(document).ready( function() {
                var $accord2=$("#accordion2").accordion({
                autoHeight: false,
                collapsible: true,
                active: false,
                header: 'h4',
                icons: { 'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s' },
                animated: 'bounceslide',
                navigation: true,
                clearStyle: true,
                alwaysOpen: false
        });
        var options = {
        target:        '#accordion2',   // target element(s) to be updated with server response
        //beforeSubmit:  showRequest,  // pre-submit callback
        //success:       showResponse  // post-submit callback
        success:    refeshAccordion,
        // other available options:
        url:'code/basefunctions.php?GetAllMyAssessments=1',         // override for form's 'action' attribute
        type:'post'              // 'get' or 'post', override for form's 'method' attribute
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
        //clearForm: true        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit

        // $.ajax options can be used here too, for example:
        //timeout:   3000
    };

    // bind form using 'ajaxForm'
    //$('#filter_and_sort').ajaxForm(options);
    $('#filter_and_sort').submit(function() {
        // inside event callbacks 'this' is the DOM element so we first
        // wrap it in a jQuery object and then invoke ajaxSubmit
        $(this).ajaxSubmit(options);

        // !!! Important !!!
        // always return false to prevent standard browser submit and page navigation
        return false;
    });
    $('#sorter').change(function() {
       $('#filter_and_sort').ajaxSubmit(options);
        return false;
    });
    $('#up_or_down').change(function() {
       $('#filter_and_sort').ajaxSubmit(options);
        return false;
    });
    $('#topic_filter').change(function() {
       $('#filter_and_sort').ajaxSubmit(options);
        return false;
    });
    $('#level_filter').change(function() {
       $('#filter_and_sort').ajaxSubmit(options);
        return false;
    });
});
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
function refeshAccordion(responseText, statusText, xhr, $form)
{
    //alert(responseText);
    $('#accordion2').accordion('destroy').accordion({
                autoHeight: false,
                collapsible: true,
                active: false,
                header: 'h4',
                icons: { 'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s' },
                animated: 'bounceslide',
                navigation: true,
                clearStyle: true,
                alwaysOpen: false
        });
}
function clearinputText() {
      document.sform.user.value= "";
}
function clearinputText2() {
      document.signup.user.value= "";
      document.signup.email.value= "";
      document.signup.pass.value= "";
}

</script>

    <div id="wrapper">
       <div id="doc" style="background: url(index_files/new_bg3.jpg) no-repeat;">
           <div style="position:absolute;top:30px;left:750px" id="topnav">
               <a href="/tplan/main.php#feature-assessment" class="ui-widget">back to home page</a>&nbsp|&nbsp<a href="process.php" class="ui-widget">sign out</a>
           </div>
           <div id="gettingstarted-featured" class="pager pager-with-tabs">
               <div class="gettingstarted-featured-contents" id="page-feature-learn" style="position:absolute;top:200px;left:25px">
                   <table border="0" width="800px">
                       <tr><td><h3>My&nbsp;<? echo $assess_type?>&nbsp;Assessments</h3></td>
                       <td> <div class="help" style="margin:0 0 20px 20px;position:absolute;right:120px;"><a href='javascript:showHelpDialog("allassessments")'>what do I do?&nbsp;</a><img src="/tplan/images/information.gif"></div></td>
                       </tr>
                       <tr>
                           <td align="left" colspan="2">
                               
                               <div id="accordion2" class="basic" >
                                    <? GetAllMyAssessments ($_GET['assessType']);?>
                               </div>
                           </td>
                        <!--<td align="center" valign="top">
                        <form id="filter_and_sort" class="ui-widget-form" action="">
                            <table cellpadding="2px" cellspacing="2px">
                                <tr>
                                    <td colspan="2">
                                        Filter and Sort Options
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Topic Filter :
                                    </td>
                                    <td>
                                        <select id="topic_filter" name="topic_filter">
                                            <option value="none">make selection</option>
                                            <? GetTopics();?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Level Filter :
                                    </td>
                                    <td>
                                        <select id="level_filter" name="level_filter">
                                            <option value="none">make selection</option>
                                            <? GetLevels();?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Sort order :
                                    </td>
                                    <td>
                                        <select id="sorter" name="sorter">
                                            <option value="none">
                                             make selection
                                            </option>
                                            <option value="date_created">
                                             Date
                                            </option>
                                            <option value="topic_id">
                                             Topic
                                            </option>
                                            <option value="level_id">
                                             Level
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                    Sort option :
                                    </td>
                                    <td>
                                        <select id="up_or_down" name="up_or_down">
                                            <option value="none">
                                             make selection
                                            </option>
                                            <option value="ASC">
                                             Ascending
                                            </option>
                                            <option value="DESC">
                                             Descending
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        </td>-->
                       </tr>
                   </table>
                   <script type="text/javascript">
                    $('#accordion2').accordion('destroy').accordion({
                    autoHeight: false,
                    collapsible: true,
                    active: false,
                    header: 'h4',
                    icons: { 'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s' },
                    animated: 'bounceslide',
                    navigation: true,
                    clearStyle: true,
                    alwaysOpen: false});
                   </script>
               </div>
           </div>
           <div id="helpDialog" style="display:none;" class="fix-z-index ui-corner-all">
                <!--<div id="contact_form">-->

                 </div>
       </div><!-- end #doc -->
    </div><!-- end #wrapper -->
    </body>
</html>