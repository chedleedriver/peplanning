<?php  session_start();
//virtual('/tplan/Connections/tp.php');
//echo "here";
include('session.php');
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include ("functions.php");
$mode=$_GET['mode'];
$content_id=$_GET['content_id'];
$topic_id=$_GET['topic'];
$cr_id=$_GET['cr_id'];
if ($mode=="resource_edit")
{
    list($cr_id,$c_id,$description,$name,$location,$type)=mysql_fetch_array(mysql_query("select * from content_resources where id=$cr_id")) or die ("<br />MySQL reported: ".mysql_error());
}
if ($mode=="look")
	{ 	$sql="select name,description,time from content where content_id = $content_id";
	list($content_name,$content_description,$content_time) = mysql_fetch_array(mysql_query($sql)) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
        $resource_sql="select * from content_resources where content_id = $content_id";
	$resource_results = mysql_query($resource_sql) or die("Error reported while executing the statement: $resource_sql<br />MySQL reported: ".mysql_error());
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="../code/javascripts.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Content Resources</title>
</head>
<body>
<form method="post" name="form1" action="content_resources.php?mode=update" enctype="multipart/form-data">
    <input type="hidden" name="content_id" value="<? echo $content_id?>" size="4" /><input type="hidden" name="topic" id="topic" value="<? echo $topic_id?>" /><input type="hidden" name="cr_id" value="<? echo $cr_id?>" size="4" />
  <table align="center">
<? if ($mode=="look")
{?>
    <tr valign="baseline">
      <td nowrap="true" align="right">Name:</td>
      <td><input type="text" name="content_name" value="<? echo $content_name?>" size="32" maxlength="1024"/></td>
    </tr>
      <tr>
      <td><label>Resource Description</label></td>
      <td colspan="4"><input name="description" type="text" id="description" size="100" value="<?php echo $description?>"/></td>
      </tr>
      <tr valign="baseline">
      <td nowrap="true" align="right">Upload Resource</td>
      <td><input name="resource" type="file" id="resource"  value="<?php echo $name?>"/> </td>
      <td nowrap="true" align="right">Or Add Resource Link</td>
            <td><label>URL</label></td>
      <td><input name="link_url" type="text" id="link_url" size="50" value="<?php echo $location?>"/></td>
	  
     </tr>
      <tr>
          <td></td>
           <td><input type="submit" name="upload" value="upload" /></td>
           <td></td>
           <td></td>
        <td><input type="submit" name="add_link" value="add" /></td>
</tr>
 <tr>
<td><input type="button" id="return" onclick="ReturnTo('index',0)" value="return to menu" /></td>
</tr>
  </table>
    <table border="2" align="center">
        <tr>
            <td colspan="7">
                <label>Current Resources</label>
            </td>
        </tr>
        <tr>
            <td>id</td>
            <td>content</td>
            <td>Description</td>
            <td>Name</td>
            <td>Location</td>
            <td>Type</td>
        </tr>
        <?php while (list($cr_id,$c_id,$description,$name,$location,$type)=mysql_fetch_array($resource_results))
        {?>
        <tr>
            <td><a href="#" onclick='javascript:editContentResource(<?php echo $topic_id.",".$content_id.",".$cr_id?>)'><?php echo $cr_id?></a></td>
            <td><?php echo $c_id?></td>
            <td><?php echo $description?></td>
            <td><?php echo $name?></td>
            <td><?php echo $location?></td>
            <td><?php echo $type?></td>
        </tr>
        <?php }
}
        elseif ($mode=="resource_edit"){ ?>
      <tr>
      <td><label>Resource Description</label></td>
      <td colspan="4"><input name="description" type="text" id="description" size="100" value="<?php echo $description?>"/></td>
      </tr>
      <tr valign="baseline">
      <?php if($type!="url"){?>    
      <td nowrap="true" align="right">Upload Resource</td>
      <td><input name="resource" type="file" id="resource"/> </td>
      <td nowrap="true" align="right">Current File Name : </td>
            <td><label><?php echo $name?></label></td>
      <td></td>
      <?php }
      if($type=="url"){?>
            <td nowrap="true" align="right">Add Resource Link</td>
      <td></td>
      <td nowrap="true" align="right"></td>
            <td><label>URL</label></td>
      <td><input name="link_url" type="text" id="link_url" size="50" value="<?php if($type=='url') echo $location?>"/></td>
<?php }?>
     </tr>
      <tr>
          <td></td>
           <td>
               <?php if($type!="url"){?>    
               <input type="submit" name="upload" value="upload" />
               <?php } if($type=="url"){?>
               <input type="submit" name="update_link" value="update" />
               <?php } ?>
           </td>
           <td></td>
           <td><input type="submit" name="delete" value="delete" /></td>
        <td></td>
</tr>
 <tr>
<td><input type="button" id="return" onclick="ReturnTo('index',0)" value="return to menu" /></td>
</tr>
</table>
</form>
</body>
</html>
<?php }

    else {
    if ($mode=="update") {
     if (isset($_POST['update_link'])) UpdateContentResources();
     elseif (isset($_POST['delete'])) DeleteContentResources();
     else InsertContentResources ();
    }
   }
}