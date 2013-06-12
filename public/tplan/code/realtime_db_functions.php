<?php
/* 
 * This is a function file to interact with the database for all realtime transactions
 *
 */
include("constants.php");
class MySQLDB
{
   var $connection;         //The MySQL database connection

    function MySQLDB(){
      /* Make connection to database */
      $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
      mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
     }
     /*
      * The functions
      */
     function lookup($what,$with){
            switch ($what){
                case 'username':
                    $table='users';
                    $field='username';
                    $sql = "SELECT $field FROM $table WHERE $field = '$with'";
                   break;
                case 'school':
                    $table='school';
                    $field='school';
                    $sql = "SELECT $field FROM $table WHERE $field = '$with'";
                    break;
                }
            /*
             * Do the check
             */
             $result=mysql_query($sql, $this->connection) or die(mysql_error());
            return mysql_num_rows($result);
      }

}
$realtime_db_functions = new MySQLDB;
?>
