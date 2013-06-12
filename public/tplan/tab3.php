<? include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="ltr" xml:lang="en-GB" xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
    <head>
       
    </head>
    <body>
    
    <?php GetMyAssessments('nofilter',$_SESSION['plan_order']);?>

        <script type="text/javascript">
        $('#accordion3').accordion('destroy').accordion({
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
        //alert('script run')
        </script>

        <div><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="myAssessments.php"><h3><u>view all Assessments</u></h3></a></div>

</body>
</html>