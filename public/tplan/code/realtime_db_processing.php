<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/* all incoming requests will be of the type "GET"
 * ("POST" requests will be handled by batch_db_functions.php)
 * The first GET to test will be $_GET['toDo']
 * values = look, remove, put, change
 */
include('realtime_db_functions.php');
global $realtime_db_functions;

switch ($_GET['toDo']){
    case 'look':
        $answer=$realtime_db_functions->lookup($_GET['doWhat'],$_GET['withWhat']);
        echo $answer;
        break;
    case 'remove':
        $answer=$realtime_db_functions->deletefrom($_GET['doWhat'],$_GET['withWhat']);
         echo $answer;
       break;
    case 'put':
       $answer=$realtime_db_functions-> insertinto($_GET['doWhat'],$_GET['withWhat']);
        echo $answer;
        break;
    case 'change':
        $answer=$realtime_db_functions->updatein($_GET['doWhat'],$_GET['withWhat']);
        echo $answer;
        break;
}
?>
