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
$progression_id=$_GET['progression_id'];
$progression_num=$_GET['progression_num'];
$what[0]="equipment";
$what[1]="keywords";
$what[2]="objectives";
$what[3]="theme";
$what[4]="lesson_part";
$what[5]="point";
//print_r($_POST);
if (isset($_POST['update']))
	{ ContentUpdate();
}
if (isset($_POST['delete']))
	{ ContentDelete();
}
if (isset($_POST['duplicate']))
	{ ContentCreate();
}
if ($mode=="look")
	{ 	$sql="select name,description,time from content where content_id = $content_id";
	list($content_name,$content_description,$content_time) = mysql_fetch_array(mysql_query($sql)) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
} else $list_in_id=$mode."_in"; $list_out_id=$mode."_out";
$topic_id=$_GET['topic'];
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="../code/javascripts.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Content Creation</title>
</head>
<body>
<form method="post" name="form1" action="content.php?mode=update" enctype="multipart/form-data">
  <table align="center">
<? if ($mode=="look")
{?>
    <tr valign="baseline">
      <td nowrap="true" align="right">Name:</td>
      <td><input type="text" name="content_name" value="<? echo $content_name?>" size="32" maxlength="1024"/><input type="hidden" name="content_id" value="<? echo $content_id?>" size="4" /><input type="hidden" name="topic" id="topic" value="<? echo $topic_id?>" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="true" align="right">Description:</td>
	  <td>
	  <table>
	  <?  
	  if (checkBase64Encoded($content_description)) 
	  { 
	  	$description=unserialize(base64_decode($content_description));
	  }
	  else 
	  {
	  	$description=unserialize($content_description);
	  }

?>
      <tr><td><input type="text" name="description[0]" size="128" value="<? echo htmlspecialchars(stripslashes($description[0]))?>" /></td></tr>
      <tr><td><input type="text" name="description[1]" size="128" value="<? echo htmlspecialchars(stripslashes($description[1]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[2]" size="128" value="<? echo htmlspecialchars(stripslashes($description[2]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[3]" size="128" value="<? echo htmlspecialchars(stripslashes($description[3]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[4]" size="128" value="<? echo htmlspecialchars(stripslashes($description[4]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[5]" size="128" value="<? echo htmlspecialchars(stripslashes($description[5]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[6]" size="128" value="<? echo htmlspecialchars(stripslashes($description[6]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[7]" size="128" value="<? echo htmlspecialchars(stripslashes($description[7]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[8]" size="128" value="<? echo htmlspecialchars(stripslashes($description[8]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[9]" size="128" value="<? echo htmlspecialchars(stripslashes($description[9]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[10]" size="128" value="<? echo htmlspecialchars(stripslashes($description[10]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[11]" size="128" value="<? echo htmlspecialchars(stripslashes($description[11]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[12]" size="128" value="<? echo htmlspecialchars(stripslashes($description[12]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[13]" size="128" value="<? echo htmlspecialchars(stripslashes($description[13]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[14]" size="128" value="<? echo htmlspecialchars(stripslashes($description[14]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[15]" size="128" value="<? echo htmlspecialchars(stripslashes($description[15]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[16]" size="128" value="<? echo htmlspecialchars(stripslashes($description[16]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[17]" size="128" value="<? echo htmlspecialchars(stripslashes($description[17]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[18]" size="128" value="<? echo htmlspecialchars(stripslashes($description[18]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[19]" size="128" value="<? echo htmlspecialchars(stripslashes($description[19]))?>" /></td></tr>
      <tr><td><input type="text" name="description[20]" size="128" value="<? echo htmlspecialchars(stripslashes($description[20]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[21]" size="128" value="<? echo htmlspecialchars(stripslashes($description[21]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[22]" size="128" value="<? echo htmlspecialchars(stripslashes($description[22]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[23]" size="128" value="<? echo htmlspecialchars(stripslashes($description[23]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[24]" size="128" value="<? echo htmlspecialchars(stripslashes($description[24]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[25]" size="128" value="<? echo htmlspecialchars(stripslashes($description[25]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[26]" size="128" value="<? echo htmlspecialchars(stripslashes($description[26]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[27]" size="128" value="<? echo htmlspecialchars(stripslashes($description[27]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[28]" size="128" value="<? echo htmlspecialchars(stripslashes($description[28]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[29]" size="128" value="<? echo htmlspecialchars(stripslashes($description[29]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[30]" size="128" value="<? echo htmlspecialchars(stripslashes($description[30]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[31]" size="128" value="<? echo htmlspecialchars(stripslashes($description[31]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[32]" size="128" value="<? echo htmlspecialchars(stripslashes($description[32]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[33]" size="128" value="<? echo htmlspecialchars(stripslashes($description[33]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[34]" size="128" value="<? echo htmlspecialchars(stripslashes($description[34]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[35]" size="128" value="<? echo htmlspecialchars(stripslashes($description[35]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[36]" size="128" value="<? echo htmlspecialchars(stripslashes($description[36]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[37]" size="128" value="<? echo htmlspecialchars(stripslashes($description[37]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[38]" size="128" value="<? echo htmlspecialchars(stripslashes($description[38]))?>"  /></td></tr>
      <tr><td><input type="text" name="description[39]" size="128" value="<? echo htmlspecialchars(stripslashes($description[39]))?>"  /></td></tr>
   </table>
	</td>
	</tr>
  	  <? 
	  $sql="select * from progression left join content_progression on id=progression_id where content_id=$content_id";
	  $result=mysql_query($sql) or die("Error reported while executing the statement: $sql<br />MySQL reported: ".mysql_error());
	  for ($i=0 ; $i < 4 ; $i++)
	  {list($progression_id[$i],$content_progression[$i]) = mysql_fetch_array($result);
	  if (checkBase64Encoded($content_progression[$i]))
	  { 
	  	$progression[$i]=unserialize(base64_decode($content_progression[$i]));
	  }
	  else 
	  {
	  	$progression[$i]=unserialize($content_progression[$i]);
	  }
	  ?>
    <tr valign="baseline">
      <td nowrap="true" align="right">Progression</td>
	  <td>
	  <table>
      <tr><td><input type="hidden" id="progression_id[<? echo $i?>]" name="progression_id[<? echo $i?>]" value="<? echo $progression_id[$i]?>" /></td>
</tr>
      <tr><td><input type="text" name="progression[<? echo $i?>][0]" size="128" maxlength="1024"  value="<? echo htmlspecialchars(stripslashes($progression[$i][0]))?>"  /></td>
</tr>
      <tr><td><input type="text" name="progression[<? echo $i?>][1]" size="128" maxlength="1024"  value="<? echo htmlspecialchars(stripslashes($progression[$i][1]))?>"  /></td>
</tr>
      <tr><td><input type="text" name="progression[<? echo $i?>][2]" size="128" maxlength="1024"  value="<? echo htmlspecialchars(stripslashes($progression[$i][2]))?>"  /></td>
	  </tr>
    <tr><td><input type="text" name="progression[<? echo $i?>][3]" size="128" maxlength="1024"  value="<? echo htmlspecialchars(stripslashes($progression[$i][3]))?>"  /></td>
	  </tr>
    <tr><td><input type="text" name="progression[<? echo $i?>][4]" size="128" maxlength="1024"  value="<? echo htmlspecialchars(stripslashes($progression[$i][4]))?>"  /></td>
	  </tr>
    <tr><td><input type="text" name="progression[<? echo $i?>][5]" size="128" maxlength="1024"  value="<? echo htmlspecialchars(stripslashes($progression[$i][5]))?>"  /></td>
	  </tr>
    </table>
	</td>
	</tr>
        <tr valign="baseline">	 
	  <td><input name="progression_point_button" id="progression_point_button" type="button" value="progression_point" onclick="ChangeContentProgressionList(this.value,<? if ($progression_id[$i]) echo $progression_id[$i]; else echo 0?>,<? echo $content_id?>,<? echo $i?>,<? echo $topic_id?>)" /></td>
      <td><select name="progression_point[<? echo $i?>]" size="5" multiple="multiple">
        <? if (($mode=="look") and ($progression_id[$i])) GetContentProgressionPoints($progression_id[$i]); else GetPoints($topic_id); 
		?>
      </select>      </td>

    </tr> <?  }?>
    <tr valign="baseline">
      <td nowrap="true" align="right"><input name="easy_differentiation_button" id="easy_differentiation_button" type="button" value="easy_differentiation" onclick="ChangeContentList(this.value,<? echo $content_id?>,<? echo $topic_id?>)" /></td>
      <td><select name="easy_differentiation[]" size="5" multiple="multiple">
        <? if ($mode=="look") GetContentDifferentiation($content_id,"e"); else GetDifferentiation($topic_id,"e");?>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="true" align="right"><input name="hard_differentiation_button" id="hard_differentiation_button" type="button" value="hard_differentiation" onclick="ChangeContentList(this.value,<? echo $content_id?>,<? echo $topic_id?>)" /></td>
      <td><select name="hard_differentiation[]" size="5" multiple="multiple">
        <? if ($mode=="look") GetContentDifferentiation($content_id,"h"); else GetDifferentiation($topic_id,"h");?>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="true" align="right">Time:</td>
      <td><input type="text" name="time" value="<? echo $content_time?>" size="10"/></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="true" align="right"><input name="point_button" id="point_button" type="button" value="point" onclick="ChangeContentList(this.value,<? echo $content_id?>,<? echo $topic_id?>)" /></td>
      <td><select name="point[]" size="5" multiple="multiple">
        <? if ($mode=="look") GetContentPoints($content_id); else GetPoints($topic_id);?>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="true" align="right"><input name="level_button" id="level_button" type="button" value="level" onclick="ChangeContentList(this.value,<? echo $content_id?>,<? echo $topic_id?>)" /></td>
      <td nowrap="true" align="right"><input name="level_button" id="level_button" type="button" value="level" onclick="ChangeContentList(this.value,<? echo $content_id?>,<? echo $topic_id?>)" /></td>
      <td><select name="level[]" size="5" multiple="multiple">
        <? if ($mode=="look") GetContentLevels($content_id); else GetLevels($topic_id);?>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="true" align="right"><input name="theme_button" id="theme_button" type="button" value="theme" onclick="ChangeContentList(this.value,<? echo $content_id?>,<? echo $topic_id?>)" /></td>
      <td><select name="theme[]" size="5" multiple="multiple">
        <? if ($mode=="look") GetContentThemes($content_id); else GetThemes($topic_id);?>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="true" align="right"><input name="strand_button" id="strand_button" type="button" value="strand" onclick="ChangeContentList(this.value,<? echo $content_id?>,<? echo $topic_id?>)" /></td>
      <td><select name="strand[]" size="5" multiple="multiple">
		<? if ($mode=="look") GetContentStrands($content_id); else GetStrands($topic_id); ?>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap="true" align="right"><input name="lesson_part_button" id="lesson_part_button" type="button" value="lesson_part" onclick="ChangeContentList(this.value,<? echo $content_id?>,<? echo $topic_id?>)" /></td>
      <td><select name="lesson_part[]" size="5" multiple="multiple">
		<? if ($mode=="look") GetContentLessonParts($content_id); else GetLessonParts($topic_id); ?>
      </select>      </td>
    </tr>
     <tr valign="baseline">
      <td nowrap="true" align="right"><input name="equipment" id="equipment_button" type="button" value="equipment" onclick="ChangeContentList(this.value,<? echo $content_id?>,<? echo $topic_id?>)" /></td>
      <td><select name="equipment[]" size="5" multiple="multiple">
		<? if ($mode=="look") GetContentEquipment($content_id); else GetEquipment($topic_id); ?>
      </select>      </td>
    </tr>
     <tr valign="baseline">
      <td nowrap="true" align="right">Upload Diagram </td>
      <td><input name="diagram" type="file" id="diagram" /> </td>
     </tr>
      <tr>
          <td nowrap="true" align="right">&nbsp;</td>
	  <td><img src='<? echo "../diagrams/".$content_id.".gif"?>' /></td>
    </tr>
 <? if ($mode=="look"){?>   <tr valign="baseline">
     <tr>
      
      <td colspan="2"><input type="submit" name="update" value="Update record"/><input type="submit" name="delete" value="Delete record"/><input type="submit" name="duplicate" value="Duplicate record"/></td>
    </tr>
<tr>
<td><input type="button" id="return" onclick="ReturnTo('index',0)" value="return to menu" /></td>
</tr>
<? }
}
else {
?>
<tr>
<td id="<? echo $list_in_id."_cell"?>"><select name="<? echo $list_in_id; if ($mode=='progression_point') echo "[".$progression_num."]"?>" id="<? echo $list_in_id; if ($mode=='progression_point') echo "[".$progression_num."]"?>" size="10">
<? if ($mode=='progression_point') GetContentList('progression',$content_id,$progression_id); 
   elseif ($mode=='easy_differentiation') GetContentList('differentiation',$content_id,'e');
   elseif ($mode=='hard_differentiation') GetContentList('differentiation',$content_id,'h');
   else GetContentList($mode,$content_id,$progression_id);
while (list($id,$name)=$list=mysql_fetch_array($data)) {?>
<option value="<? echo $id?>"><? echo $name?></option>
<? }?>
</select>
</td>
<td id="<? echo $list_out_id."_cell"?>"><select name="<? echo $list_out_id; if ($mode=='progression_point') echo "[".$progression_num."]"?>"  id="<? echo $list_out_id; if ($mode=='progression_point') echo "[".$progression_num."]"?>" size="10">
<? if ($mode=='progression_point') GetList ('point',$topic_id); 
   else GetList($mode,$topic_id);
while (list($id,$name)=$list=mysql_fetch_array($data)) {?>
<option value="<? echo $id?>"><? echo $name?></option>
<? }?>
</select>
</td>
</tr>
<? }if (($mode!="look") AND ($mode!="create")) {
if ($progression_id) {?>
<tr>
<td><input type="button" id="remove" onclick="RemoveFromProgList(<? echo $progression_id.",'progression_point','progression',".$progression_num?>)" value="remove" /></td>
<td><input type="button" id="add" onclick="AddToProgList(<? echo $progression_id.",'progression_point','progression',".$progression_num?>)" value="add" /></td>
</tr>
<tr>
<td><input type="button" id="return" onclick="editContent(<? echo $topic_id?>,<? echo $content_id?>)" value="return" /></td>
</tr>
<? } else {?>
 <?php if ($mode=="point") { ?><tr><td><input type="button" id="order" onclick="orderPoints(<? echo $content_id.",'".$mode."',".$topic_id?>)" value="order" /></td></tr><?php }?>
<tr>
<td><input type="button" id="remove" onclick="RemoveFromList(<? echo $content_id.",'".$mode."','content',0"?>)" value="remove" /></td>
<td><input type="button" id="add" onclick="AddToList(<? echo $content_id.",'".$mode."','content',0"?>)" value="add" /></td>
</tr>
<tr>
<td><input type="button" id="return" onclick="editContent(<? echo $topic_id?>,<? echo $content_id?>)" value="return" /></td>
</tr>
<? }}?>
  </table>
  <input type="hidden" name="MM_insert" value="form1"/>
</form>
</body>
</html>
<?}
