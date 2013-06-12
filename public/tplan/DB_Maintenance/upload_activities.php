<?php  session_start();
virtual('/tplan/Connections/tp.php');
include('session.php');
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include ("functions.php");
if (($_GET['mode']=="update")&&($_POST['topic'])) { upload_content($_POST['topic']);
echo "<input type=\"button\" id=\"return\" onclick=\"history.go(-2)\" value=\"return to menu\" />";
}
else {
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="../code/javascripts.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Content Upload</title>
</head>
<body>
<form method="post" name="form1" action="upload_activities.php?mode=update" enctype="multipart/form-data">
    <table>
        <tr>
            <td><select name="topic" id="topic" size="10">
                <? GetTopics(); ?>
                </select>
            </td>
        </tr>
        <tr valign="baseline">
      <td nowrap align="right">Upload Diagram </td>
      <td><input name="content_file" type="file" id="content_file" /> </td>
	  <td><img src=<? echo "../diagrams/".$content_id.".gif"?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" name="update" value="Upload"></td>
    </tr>
    <tr>
    <td><input type="button" id="return" id="return" onclick="ReturnTo('index',0)" value="return to menu" /></td>
    </tr>
    </table>
</form>
</body>
</html>
<? }}