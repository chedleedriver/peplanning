<?php
session_start();
include_once($_SERVER["DOCUMENT_ROOT"] . '/../library/tplan_config.php'); 
include("session.php");
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else {
include('mysqli_dbconnect.php');
include ("functions.php");
$get_objectives=mysqli_query($tp, 'select * from objectives order by id,genre_id')or die("Error reported while executing the statement: <br />MySQL reported: ".mysqli_error());
while (list($objective_id,$objective,$assessment,$genre_id,$topic_id)=mysqli_fetch_array($get_objectives))
{ 
        print $objective_id." - ".$genre_id."<br>";
        print "insert into genre_objective (genre_id,objective_id) values ($genre_id,$objective_id)";
        $put_em_in=mysqli_query($tp, "insert into genre_objective (genre_id,objective_id) values ($genre_id,$objective_id)");
}

}
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
