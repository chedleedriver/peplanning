<?php
include_once('../code/config.php');
$get_keywords=mysql_query('select * from lesson_keywords order by lesson_id,keyword_id')or die("Error reported while executing the statement: <br />MySQL reported: ".mysql_error());
$last_lesson=0;
$last_keyword=0;
while (list($lesson_id,$keyword_id)=mysql_fetch_array($get_keywords))
{ 
    if (($lesson_id==$last_lesson)&&($keyword_id==$last_keyword))
    {
        print $lesson_id." - ".$keyword_id."<br>";
        print "delete from lesson_keywords where lesson_id=".$lesson_id." and keyword_id=".$keyword_id." limit 1";
       $get_rid=mysql_query("delete from lesson_keywords where lesson_id=$lesson_id and keyword_id=$keyword_id limit 1");
    }
            $last_lesson=$lesson_id;
        $last_keyword=$keyword_id;

   }


/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
