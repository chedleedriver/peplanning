<?php
$sql = "insert into users (name, username, password, school, postcode, userlevel, email, subscribed, num_logins) values ('No Login','rlogan321@o2.co.uk','b5cb2733480a844796184e4d3744354c','my school','sk1 1ks',4,'rlogan321@o2.co.uk',".strtotime('-30 day').",3);";
echo $sql."<br>";
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
