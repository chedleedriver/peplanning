<?php include ("lessonfunctions.php");
include_once('config.php');
include("session.php");
$unit_id=$_GET['unit_id'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" type="text/css" href="index_files/content.css" media="screen">
  </head>
  <body>
 <table border="1">
    <thead>
        <tr>
            <th colspan="3">How to Enable Pop-ups</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><b>Internet Explorer</b></td>
            <td><b>Mozilla Firefox</b></td>
            <td><b>Google Chrome</b></td>
        </tr>
        <tr>
            <td valign="top"><ol>
                    <li>Go to the Tools menu and click on “Pop-up Blocker”</li>
                    <li>Click on "Pop-up Blocker settings"</li>
                    <li>Type www.peplanning.org.uk</li>
                    <li>Click "Add"</li>
                    <li>Close the window</li>
               </ol>
            </td>
            <td valign="top"><ol><li>Go to the Tools menu and click on “Options”</li>
                    <li>Click on "Content"</li>
                   <li>Click on “Exceptions”</li>
                    <li>Type www.peplanning.org.uk</li>
                    <li>Click “Allow”</li>
                    <li>Close the window</li>
                    </ol>
            </td>
            <td valign="top"><ol><li>Click on the 'spanner' icon and click on "Options"</li>
                    <li>Click on "Under the Hood/Bonnet"</li>
                    <li>Click on "Content settings"</li>
                    <li>Click on "Pop-ups"</li>
                    <li>Click on "Exceptions"</li>
                    <li>Click on "Add"</li>
                    <li>Type www.peplanning.org.uk</li>
                    <li>Click "Ok"</li>
                    <li>Close the window</li>
                    </ol>
            </td>
        </tr>
        <tr><td align="center" colspan="3">Once you have made the changes to your browser settings <a href='/tplan/Lessons.php?unit_id=<?echo $unit_id?>&plan_type=newPlan'>click here to return to you plan</a>
            </td></tr>
    </tbody>
</table>
  </body>
</html>
