<?php
include_once('../code/config.php');
$get_analysis=mysql_query('select * from lesson_activity_analyses order by la_id,analyses_id')or die("Error reported while executing the statement: <br />MySQL reported: ".mysql_error());
$last_la=0;
$last_an=0;
while (list($la_an_id,$la_id,$an_id)=mysql_fetch_array($get_analysis))
{ 
    if (($la_id==$last_la)&&($an_id==$last_an))
    {
        print $la_an_id."-".$la_id." - ".$an_id."<br>";
       $get_rid=mysql_query("delete from lesson_activity_analyses where la_an_id=$la_an_id");
    }
            $last_la=$la_id;
        $last_an=$an_id;

   }


/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
