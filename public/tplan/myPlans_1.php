<? include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="ltr" xml:lang="en-GB" xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">

    <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <title>PE Planning | My Plans</title>
    
    <link href="/tplan/css/peplanning/jquery-ui-1.7.3.custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="index_files/content.css" media="screen"/>
    
    </head>

    <!-- this section is complete -->

<body id="central" class="portal-page locale-en-GB portal-page js platform-windows">

<script type="text/javascript" type="text/javascript" src="/tplan/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" type="text/javascript" src="/tplan/js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" type="text/javascript" src="/tplan/js/jquery.layout-1.3.rc5.js"></script>
<script type="text/javascript" type="text/javascript" src="/tplan/js/jquery.bgiframe.min.js"></script>
<script type="text/javascript" type="text/javascript" src="/tplan/js/jquery.form.js"></script>
<script type="text/javascript" type="text/javascript" src="/tplan/js/debug.js"></script>
<script type="text/javascript" type="text/javascript" src="/tplan/js/mainScripts.js"></script>
<script type="text/javascript" type="text/javascript" src="/tplan/js/baseScripts.js"></script>
<script type="text/javascript" type="text/javascript">
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
        url:'code/basefunctions.php?GetAllMyUnits=1',         // override for form's 'action' attribute
        type:'post'              // 'get' or 'post', override for form's 'method' attribute
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
        //clearForm: true        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit

        // $.ajax options can be used here too, for example:
        //timeout:   3000
    };

    // bind form using 'ajaxForm'
    $('#filter_and_sort').ajaxForm(options);
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
</script>
<div id="wrapper">
    <table border="0" width="100%">
            <tr>
                <td align="left" width=75%>
                    <div id="accordion2" class="basic"><? if($session->logged_in) GetAllMyUnits('nofilter',$_SESSION['plan_order']);?>
                    </div>
                </td>
                <td align="left" valign="top" width=25%>
                    <form name="filter_and_sort" id="filter_and_sort" class="ui-widget-form">
                        <table width="100%" cellpadding="10px" cellspacing="10px">
                            <tr>
                                <td class="ui-widget-select-header" colspan="3" align="center">
                                    Filter and Sort Options
                                </td>
                            </tr>
                            <tr>
                                <td class="ui-widget-select-header">
                                    Filter:
                                </td>
                                 <td class="ui-widget-select-header">
                                     <select id="topic_filter" name="topic_filter" class="ui-widget-select">
                                          <option value="none">
                                             select topic
                                         </option><? GetTopics();?>
                                     </select>
                                </td>
                                 <td class="ui-widget-select-header">
                                    <select id="level_filter" name="level_filter" class="ui-widget-select">
                                          <option value="none">
                                             select level
                                         </option><? GetLevels();?>
                                     </select>
                                </td>
                            </tr>
                             <tr>
                                <td class="ui-widget-select-header">
                                    Sort:
                                </td>
                                 <td class="ui-widget-select-header">
                                     <select id="sorter" name="sorter" class="ui-widget-select">
                                          <option value="none">
                                             select sort order
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
                                <td class="ui-widget-select-header">
                                     <select id="up_or_down" name="up_or_down" class="ui-widget-select">
                                          <option value="none">
                                             select sort option
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
                            <tr>
                                <td class="ui-widget-select-header" colspan="3" align="center">
                                    <input type="submit" value="Refresh" class="ui-widget-select-button"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
         </table>
    </div>
</body>
</html>