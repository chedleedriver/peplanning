<?php  session_start();
virtual('/tplan/Connections/tp.php');
include('session.php');
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include ("functions.php");
$mode=$_GET['mode'];
if ($mode=="update")
	{ ContentCreate();
}
if ($mode=="look")
	{ GetContent($content_id);
}
$topic=$_GET['topic'];
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Content Creation</title>
</head>
<script src="../code/javascripts.js"></script>
<body>
<form method="post" name="form1" action="content_insert.php?mode=update" enctype="multipart/form-data">
  <table align="center">
<?php if (!$topic)
{?>
    <tr valign="baseline">
      <td nowrap align="right">Topic</td>
      <td><select name="point[]" size="5" multiple="multiple" onclick="ReloadForm(this)">
        <?php GetTopics();?>
      </select>      </td>
    </tr>
<tr>
<td><input type="button" id="return" id="return" onclick="ReturnTo('index',0)" value="return to menu" /></td>
</tr>

<?php }
else {?>
    <tr valign="baseline">
      <td nowrap align="right">Name:</td>
      <td><input type="text" name="content_name" value="<?php echo $content_name?>" size="32" maxlength="1024"><input type="hidden" name="content_id" value="<?php echo $content_id?>" size="4" /><input type="hidden" name="topic" id="topic" value="<?php echo $topic?>"</td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Description:</td>
	  <td colspan="2">
	  <table>
      <tr><td><input type="text" name="description[0]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[1]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[2]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[3]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[4]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[5]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[6]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[7]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[8]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[9]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[10]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[11]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[12]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[13]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[14]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[15]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[16]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[17]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[18]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[16]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[17]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[18]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[19]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[20]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[21]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[22]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[23]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[24]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[25]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[26]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[27]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[28]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[29]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[30]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[31]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[32]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[33]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[34]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[35]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[36]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[37]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[38]" size="128" /></td></tr>
      <tr><td><input type="text" name="description[39]" size="128" /></td></tr>
     </table>
	</td>
	</tr>
    <tr valign="baseline">
      <td nowrap align="right">Progression 1</td>
	  <td colspan="2">
	  <table>
  	   <tr><td></td>
</tr>
      <tr><td><input type="text" name="progression[0][1]" size="128" maxlength="1024" /></td>
</tr>
      <tr><td><input type="text" name="progression[0][2]" size="128" maxlength="1024"  /></td>
</tr>
      <tr><td><input type="text" name="progression[0][3]" size="128" maxlength="1024"  /></td>
	  </tr>
          <tr><td><input type="text" name="progression[0][4]" size="128" maxlength="1024" /></td>
</tr>
      <tr><td><input type="text" name="progression[0][5]" size="128" maxlength="1024"  /></td>
</tr>
      <tr><td><input type="text" name="progression[0][6]" size="128" maxlength="1024"  /></td>
	  </tr>
    </table>
	</td>
	</tr>
        <tr valign="baseline">	 
	  <td nowrap align="right">Progression Point</td>
      <td><select name="progression_point[0][]" size="5" multiple="multiple"><?php GetPoints($topic);?>
      </select>      </td>

    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Progression 2</td>
	  <td colspan="2">
	  <table>
  	   <tr><td></td>
</tr>
      <tr><td><input type="text" name="progression[1][1]" size="128" maxlength="1024"  /></td>
</tr>
      <tr><td><input type="text" name="progression[1][2]" size="128" maxlength="1024"  /></td>
</tr>
      <tr><td><input type="text" name="progression[1][3]" size="128" maxlength="1024"  /></td>
	  </tr>
    <tr><td><input type="text" name="progression[1][4]" size="128" maxlength="1024" /></td>
</tr>
      <tr><td><input type="text" name="progression[1][5]" size="128" maxlength="1024"  /></td>
</tr>
      <tr><td><input type="text" name="progression[1][6]" size="128" maxlength="1024"  /></td>
	  </tr>
          </table>
	</td>
	</tr>
        <tr valign="baseline">	 
	  <td nowrap align="right">Progression Point</td>
      <td><select name="progression_point[1][]" size="5" multiple="multiple"><?php GetPoints($topic);?>
      </select>      </td>

    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Progression 3</td>
	  <td colspan="2">
	  <table>
  	   <tr><td></td>
</tr>
      <tr><td><input type="text" name="progression[2][1]" size="128" maxlength="1024"  /></td>
</tr>
      <tr><td><input type="text" name="progression[2][2]" size="128" maxlength="1024"  /></td>
</tr>
      <tr><td><input type="text" name="progression[2][3]" size="128" maxlength="1024"  /></td>
	  </tr>
          <tr><td><input type="text" name="progression[2][4]" size="128" maxlength="1024" /></td>
</tr>
      <tr><td><input type="text" name="progression[2][5]" size="128" maxlength="1024"  /></td>
</tr>
      <tr><td><input type="text" name="progression[2][6]" size="128" maxlength="1024"  /></td>
	  </tr>
    </table>
	</td>
	</tr>
        <tr valign="baseline">	 
	  <td nowrap align="right">Progression Point</td>
      <td><select name="progression_point[2][]" size="5" multiple="multiple"><?php GetPoints($topic);?>
      </select>      </td>

    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Progression 4</td>
	  <td colspan="2">
	  <table>
  	   <tr><td></td>
</tr>
      <tr><td><input type="text" name="progression[3][1]" size="128" maxlength="1024"  /></td>
</tr>
      <tr><td><input type="text" name="progression[3][2]" size="128" maxlength="1024"  /></td>
</tr>
      <tr><td><input type="text" name="progression[3][3]" size="128" maxlength="1024"  /></td>
	  </tr>
          <tr><td><input type="text" name="progression[3][4]" size="128" maxlength="1024" /></td>
</tr>
      <tr><td><input type="text" name="progression[3][5]" size="128" maxlength="1024"  /></td>
</tr>
      <tr><td><input type="text" name="progression[30][6]" size="128" maxlength="1024"  /></td>
	  </tr>
    </table>
	</td>
	</tr>
        <tr valign="baseline">	 
	  <td nowrap align="right">Progression Point</td>
      <td><select name="progression_point[3][]" size="5" multiple="multiple"><?php GetPoints($topic);?>
      </select>      </td>

    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Differentiation</td>
      <td><select name="easy_differentiation[]" size="5" multiple="multiple">
        <?php GetDifferentiation($topic,"e");?>
      </select>      </td>
      <td><select name="hard_differentiation[]" size="5" multiple="multiple">
        <?php GetDifferentiation($topic,"h");?>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Time:</td>
      <td colspan="2"><input type="text" name="time" value="" size="10"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Point</td>
      <td colspan="2"><select name="point[]" size="5" multiple="multiple">
        <?php GetPoints($topic);?>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Level</td>
      <td colspan="2"><select name="level[]" size="5" multiple="multiple">
        <?php GetLevels($topic);?>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Theme</td>
      <td colspan="2"><select name="theme[]" size="5" multiple="multiple">
        <?php GetThemes($topic);?>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Strand</td>
      <td><select name="strand[]" size="5" multiple="multiple">
		<?php GetStrands($topic); ?>
      </select>      </td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Lesson Part </td>
      <td colspan="2"><select name="lesson_part[]" size="5" multiple="multiple">
		<?php GetLessonParts($topic); ?>
      </select>      </td>
    </tr>
     <tr valign="baseline">
      <td nowrap align="right">Equipment </td>
      <td colspan="2"><select name="equipment[]" size="5" multiple="multiple">
		<?php GetEquipment($topic); ?>
      </select>      </td>
    </tr>
    </tr>
     <tr valign="baseline">
      <td nowrap align="right">Upload Diagram </td>
      <td colspan="2"><input name="diagram" type="file" id="diagram" /> </td>
    </tr>
   <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td colspan="2"><input type="submit" value="Insert record"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
<?php }?>
</form>
</body>
</html>
<?php }