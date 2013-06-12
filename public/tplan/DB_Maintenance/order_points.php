<?php
include_once('../code/config.php');
$get_points=mysql_query('select name,content_point.content_id,point_id,point from content_point left join point on point.id=point_id left join content on content.content_id=content_point.content_id order by content_point.content_id')or die("Error reported while executing the statement: <br />MySQL reported: ".mysql_error());
$last_ci=0;
$last_cp=0;
while (list($name,$c_id,$cp_id,$point)=mysql_fetch_array($get_points))
{ 
    if ($c_id==$last_ci)
    {
        $point_num++;
    }
   else 
   {
       $point_num=1;
       if ($point) print "<br>";
   }
        if (($point)&&($name)) print $name."  -  ".$point_num.". ".$cp_id." - ".$point."<br>";
        $order_points=mysql_query("update content_point set point_num=$point_num where content_id=$c_id and point_id=$cp_id");
        //print "update content_point set point_num=$point_num where content_id=$c_id and point_id=$cp_id <br>";
        $last_ci=$c_id;
        $last_cp=$cp_id;
   }


/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
