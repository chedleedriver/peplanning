<?php
$hostname_tp = "localhost";
$database_tp = "peplanning";
$username_tp = "peplanning";
$password_tp = "ferd1nand";
$tp = mysql_pconnect($hostname_tp, $username_tp, $password_tp) or trigger_error(mysql_error(),E_USER_ERROR); 
?>
