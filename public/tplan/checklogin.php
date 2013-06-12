<? include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working

 if($session->logged_in){
         echo('imin');
      }
      else{
          echo('imout');
      }
?>