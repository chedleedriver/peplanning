<?php
include_once('../code/functions.php');
$content_id=$_GET['content_id'];
$mode=$_GET['mode'];
$topic=$_GET['topic'];
if ($mode=="reorder") Re_Order_Points($content_id,$topic_id);
$get_points=mysql_query("select id,point,point_num from content_point left join point on point.id=point_id where content_id=$content_id order by point_num")or die("Error reported while executing the statement: <br />MySQL reported: ".mysql_error());
$num_points=0;?>
<form name="point_order" action="points_order.php?mode=reorder&content_id=<?php echo $content_id?>&topic=<?php echo $topic?>" method="POST">
   <table>
    <tr>
        <td>
            Point Num
        </td>
        <td>
            Point
        </td>
    </tr>
<?php while (list($point_id,$point,$point_num)=mysql_fetch_array($get_points))
{ 
     ?>
    <tr>
        <td>
            <input size="10" name="point_num[]" id="point_num[]" value="<?php echo $point_num?>"/>
        </td>
        <td>
            <input size="100" name="point[]" id="point[]" value="<?php echo $point?>"/><input type="hidden" name="point_id[]" id="point_id[]" value="<?php echo $point_id?>"/>
        </td>
    </tr>
<?php 
$num_points++;
}?>
    <tr>
        <td>
            <input type="submit" value="set order"><input type="hidden" name="num_points" id="num_points" value="<?php echo $num_points?>"/>
        </td>
        <td>
            <input type="button" value="return" onclick="javascript:document.location=('content.php?mode=point&content_id=<?php echo $content_id?>&topic=<?php echo $topic?>')">
        </td>
    </tr>
</table>
</form>