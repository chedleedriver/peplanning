<?
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="ltr" xml:lang="en-GB" xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
    <head>       
    </head>
    <body>    
    <? echo("<table><tr><td><a href=\"myAssessments.php?assessType=1\"><input type=\"image\" src=\"index_files/class.jpg\"  class=\"ui-button\"/></a></td><td><h3><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"myAssessments.php?assessType=1\">Class Assessment</a></h3></td></tr>
                        <tr><td><a href=\"myAssessments.php?assessType=2\"><input type=\"image\" src=\"index_files/individual.jpg\"  class=\"ui-button\"/></a></td><td><h3><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"myAssessments.php?assessType=2\">Individual Assessment</a></h3></td></tr>
                        <tr><td><input type=\"image\" src=\"index_files/teacher.jpg\" class=\"ui-button\"/></td><td><h3><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"\">Teacher Assessment</a></h3></td></tr>
                        </table>");
                 ?>
</body>
</html>