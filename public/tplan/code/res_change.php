<?php

$tp = mysql_pconnect("localhost", "tp", "enquiry") or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db("tplan", $tp);
$res_types=  mysql_fetch_array(mysql_query("select type from content_resources"));
foreach ($res_types as $res_type){
    if ($res_type!='url'){
    print $res_type." - ".substr($res_type,12)."<br>";
    $sub_res_type=substr($res_type,12);
    $update=mysql_query("update content_resources set type='pdf' where type!='url'");
    }
}
?>
