<?php
include_once($_SERVER["DOCUMENT_ROOT"] . '/../library/tplan_config.php'); 

include("constants.php");
      
class MySQLDB
{
   var $connection;         //The MySQL database connection
   var $num_active_users;   //Number of active users viewing site
   var $num_active_guests;  //Number of active guests viewing site
   var $num_members;        //Number of signed-up users
   /* Note: call getNumMembers() to access $num_members! */

   /* Class constructor */
   function MySQLDB(){
      /* Make connection to database */
      $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME) or die(mysqli_error());
	  if(!$this->connection){die('Failed to connect to server: (' . mysqli_connect_errno() . ') ');}
      //mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
      
      /**
       * Only query database to find out number of members
       * when getNumMembers() is called for the first time,
       * until then, default value set.
       */
      $this->num_members = -1;
      
      if(TRACK_VISITORS){
         /* Calculate number of users at site */
         $this->calcNumActiveUsers();
      
         /* Calculate number of guests at site */
         $this->calcNumActiveGuests();
      }
   }

   /**
    * confirmUserPass - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given password is the same password in the database
    * for that user. If the user doesn't exist or if the
    * passwords don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserPass($username, $password){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }
      /* Verify that user is in database */
      $q = "SELECT password,activation FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      if(!$result || (mysqli_num_rows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve password from result, strip slashes */
      $dbarray = mysqli_fetch_array($result);
      $dbarray['password'] = stripslashes($dbarray['password']);
      $password = stripslashes($password);
      //echo "database=".$dbarray['password']."<br>";
      //echo "form=".$password."<br>";
      /* Validate that password is correct */
      if($dbarray['password'] != $password){
         return 1; //Indicates password failure
      }
      elseif($dbarray['activation']){
         return 2; //Indicates activation failure
      }
      else{
         return 0; //Success! Username,password and activation confirmed
      }
   }
   function getActivationCode($username){
      $q = "SELECT email,activation FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      if(!$result || (mysqli_num_rows($result) < 1)){
         return 1; //Indicates username failure
      }
      else {
          $dbarray = mysqli_fetch_array($result);
          return $dbarray['email'].",".$dbarray['activation'];
      }

   }
   /**
    * confirmUserID - Checks whether or not the given
    * username is in the database, if so it checks if the
    * given userid is the same userid in the database
    * for that user. If the user doesn't exist or if the
    * userids don't match up, it returns an error code
    * (1 or 2). On success it returns 0.
    */
   function confirmUserID($username, $userid){
      /* Add slashes if necessary (for query) */
      if(!get_magic_quotes_gpc()) {
	      $username = addslashes($username);
      }

      /* Verify that user is in database */
      $q = "SELECT userid FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      if(!$result || (mysqli_num_rows($result) < 1)){
         return 1; //Indicates username failure
      }

      /* Retrieve userid from result, strip slashes */
      $dbarray = mysqli_fetch_array($result);
      $dbarray['userid'] = stripslashes($dbarray['userid']);
      $userid = stripslashes($userid);

      /* Validate that userid is correct */
      if($userid == $dbarray['userid']){
         return 0; //Success! Username and userid confirmed
      }
      else{
         return 2; //Indicates userid invalid
      }
   }
   
   /**
    * usernameTaken - Returns true if the username has
    * been taken by another user, false otherwise.
    */
   function usernameTaken($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT username FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      return (mysqli_num_rows($result) > 0);
   }

   function emailTaken($email){
      if(!get_magic_quotes_gpc()){
         $email = addslashes($email);
      }
      $q = "SELECT username FROM ".TBL_USERS." WHERE email = '$email'";
      $result = mysqli_query($this->connection, $q);
      return (mysqli_num_rows($result) > 0);
   }
   function emailOnDatabase($email,$user){
      if(!get_magic_quotes_gpc()){
         $email = addslashes($email);
      }
      $q = "SELECT username FROM ".TBL_USERS." WHERE email = '$email' and username = '$user'";
      $result = mysqli_query($this->connection, $q);
      return (mysqli_num_rows($result) > 0);
   }/**
    * usernameBanned - Returns true if the username has
    * been banned by the administrator.
    */
   function usernameBanned($username){
      if(!get_magic_quotes_gpc()){
         $username = addslashes($username);
      }
      $q = "SELECT username FROM ".TBL_BANNED_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      return (mysqli_num_rows($result) > 0);
   }
   
   /**
    * addNewUser - Inserts the given (username, password, email)
    * info into the database. Appropriate user level is set.
    * Returns true on success, false otherwise.
    */
   function addNewUser($name, $username, $password, $email, $telephone, $school, $postcode, $newsletter, $how, $what, $activation){
      $time = time();
      /* If admin sign up, give admin user level */
      if(strcasecmp($username, ADMIN_NAME) == 0){
         $ulevel = ADMIN_LEVEL;
      }else{
         $ulevel = USER_LEVEL;
      }
      $q = "INSERT INTO ".TBL_USERS." (name,username,password,userlevel,email,telephone,school,postcode,activation,timestamp,newsletter,how,what) VALUES ('$name','$username', '$password', $ulevel, '$email','$telephone', '$school', '$postcode', '$activation', $time, '$newsletter','$how','$what')";
      return mysqli_query($this->connection, $q);
   }
   function addNewSubscribedUser( $username, $password, $email,$name, $telephone, $school, $postcode,$ulevel){
      $time = time();
     $q = "INSERT INTO ".TBL_USERS." (name,username,password,userlevel,email,telephone,school,postcode,timestamp) VALUES ('$name','$username', '$password', $ulevel, '$email','$telephone', '$school', '$postcode', $time)";
      return mysqli_query($this->connection, $q);
   }
   function addNewSchool($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$total_cost,$classnum,$subfrom,$subto,$licence){
      $time = time();

      $q = "INSERT INTO school (school,address1,address2,address3,email,telephone,postcode,contact,total_cost,classnum,subfrom,subto,licence) VALUES ('$school','$address1','$address2','$address3','$email','$telephone','$postcode','$name','$total_cost','$classnum','$subfrom','$subto','$licence')";
      $result=mysqli_query($this->connection, $q);
      if ($result==1) return mysqli_insert_id($this->connection);
   }
   function addNewTeacher($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$total_cost,$subfrom,$subto,$licence){
      $time = time();

      $q = "INSERT INTO school (school,address1,address2,address3,email,telephone,postcode,contact,total_cost,subfrom,subto,licence) VALUES ('$school','$address1','$address2','$address3','$email','$telephone','$postcode','$name','$total_cost','$subfrom','$subto','$licence')";
      return mysqli_query($this->connection, $q);
   }
   function addNewCoach($school,$address1,$address2,$address3,$email,$telephone,$postcode,$name,$subfrom,$subto,$licence){
      $time = time();

      $q = "INSERT INTO school (school,address1,address2,address3,email,telephone,postcode,contact,subfrom,subto,licence) VALUES ('$school','$address1','$address2','$address3','$email','$telephone','$postcode','$name','$subfrom','$subto','$licence')";
      return mysqli_query($this->connection, $q);
   }
   /**
    * updateUserField - Updates a field, specified by the field
    * parameter, in the user's row of the database.
    */
   function updateUserField($username, $field, $value){
      $q = "UPDATE ".TBL_USERS." SET ".$field." = '$value' WHERE username = '$username'";
      if($field=="activation") $q = "UPDATE ".TBL_USERS." SET ".$field." = NULL WHERE username = '$username'";
      return mysqli_query($this->connection, $q);
   }
   
   /**
    * getUserInfo - Returns the result array from a mysql
    * query asking for all information stored regarding
    * the given username. If query fails, NULL is returned.
    */
   function getUserInfo($username){
      $q = "SELECT * FROM ".TBL_USERS." WHERE username = '$username'";
      $result = mysqli_query($this->connection, $q);
      /* Error occurred, return given name by default */
      if(!$result || (mysqli_num_rows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }
   function getUserInfobyEmail($email){
      $q = "SELECT * FROM ".TBL_USERS." WHERE email = '$email'";
      $result = mysqli_query($this->connection, $q);
      /* Error occurred, return given name by default */
      if(!$result || (mysqli_num_rows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }
   function getUserUnitInfo($user_id){
      $q = "SELECT * FROM unit_of_work WHERE teacher_id = $user_id order by date_created";
      $result = mysqli_query($this->connection, $q);
      /* Error occurred, return given name by default */
      if(!$result || (mysqli_num_rows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      for ($i=0;$i<mysqli_num_rows($result);$i++)
      {
       $dbarray[]=mysqli_fetch_array($result);
      }
      return $dbarray;
   }
  function getSchoolInfo($school_id){
      $q = "SELECT * FROM school WHERE id = $school_id";
      $result = mysqli_query($this->connection, $q);
      /* Error occurred, return given name by default */
      if(!$result || (mysqli_num_rows($result) < 1)){
         return NULL;
      }
      /* Return result array */
      $dbarray = mysqli_fetch_array($result);
      return $dbarray;
   }
  /**
    * getNumMembers - Returns the number of signed-up users
    * of the website, banned members not included. The first
    * time the function is called on page load, the database
    * is queried, on subsequent calls, the stored result
    * is returned. This is to improve efficiency, effectively
    * not querying the database when no call is made.
    */
   function getNumMembers(){
      if($this->num_members < 0){
         $q = "SELECT * FROM ".TBL_USERS;
         $result = mysqli_query($this->connection, $q);
         $this->num_members = mysqli_num_rows($result);
      }
      return $this->num_members;
   }
   
   /**
    * calcNumActiveUsers - Finds out how many active users
    * are viewing site and sets class variable accordingly.
    */
   function calcNumActiveUsers(){
      /* Calculate number of users at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_USERS;
      $result = mysqli_query($this->connection, $q);
      $this->num_active_users = mysqli_num_rows($result);
   }
   
   /**
    * calcNumActiveGuests - Finds out how many active guests
    * are viewing site and sets class variable accordingly.
    */
   function calcNumActiveGuests(){
      /* Calculate number of guests at site */
      $q = "SELECT * FROM ".TBL_ACTIVE_GUESTS;
      $result = mysqli_query($this->connection, $q);
      $this->num_active_guests = mysqli_num_rows($result);
   }
   
   /**
    * addActiveUser - Updates username's last active timestamp
    * in the database, and also adds him to the table of
    * active users, or updates timestamp if already there.
    */
   function addActiveUser($username, $time){
      $q = "UPDATE ".TBL_USERS." SET timestamp = '$time' WHERE username = '$username'";
      mysqli_query($this->connection, $q);
      
      if(!TRACK_VISITORS) return;
      $q = "REPLACE INTO ".TBL_ACTIVE_USERS." VALUES ('$username', '$time')";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveUsers();
   }
   
   /* addActiveGuest - Adds guest to active guests table */
   function addActiveGuest($ip, $time){
      if(!TRACK_VISITORS) return;
      $q = "REPLACE INTO ".TBL_ACTIVE_GUESTS." VALUES ('$ip', '$time')";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveGuests();
   }
   
   /* These functions are self explanatory, no need for comments */
   
   /* removeActiveUser */
   function removeActiveUser($username){
      if(!TRACK_VISITORS) return;
      $q = "DELETE FROM ".TBL_ACTIVE_USERS." WHERE username = '$username'";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveUsers();
   }
   
   /* removeActiveGuest */
   function removeActiveGuest($ip){
      if(!TRACK_VISITORS) return;
      $q = "DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE ip = '$ip'";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveGuests();
   }
   
   /* removeInactiveUsers */
   function removeInactiveUsers(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-USER_TIMEOUT*60;
      $q = "DELETE FROM ".TBL_ACTIVE_USERS." WHERE timestamp < $timeout";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveUsers();
   }

   /* removeInactiveGuests */
   function removeInactiveGuests(){
      if(!TRACK_VISITORS) return;
      $timeout = time()-GUEST_TIMEOUT*60;
      $q = "DELETE FROM ".TBL_ACTIVE_GUESTS." WHERE timestamp < $timeout";
      mysqli_query($this->connection, $q);
      $this->calcNumActiveGuests();
   }
   
   /**
    * query - Performs the given query on the database and
    * returns the result, which may be false, true or a
    * resource identifier.
    */
   function query($query){
      return mysqli_query($this->connection, $query);
   }
   function mysqli_result($res, $row, $field=0) { 
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
	}
};

/* Create database connection */
$database = new MySQLDB;
?>
