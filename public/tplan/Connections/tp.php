<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_tp = "localhost";
$database_tp = "tplan";
$username_tp = "tp";
$password_tp = "enquiry";
$tp = mysql_pconnect($hostname_tp, $username_tp, $password_tp) or trigger_error(mysql_error(),E_USER_ERROR); 
?>