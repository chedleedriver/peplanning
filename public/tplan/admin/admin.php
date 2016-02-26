<?php
/**
 * Admin.php
 *
 * This is the Admin Center page. Only administrators
 * are allowed to view this page. This page displays the
 * database table of users and banned users. Admins can
 * choose to delete specific users, delete inactive users,
 * ban users, update user levels, etc.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 */
include_once($_SERVER["DOCUMENT_ROOT"] . '/../library/tplan_config.php'); 
include("session.php");
/**
 * displayUsers - Displays the users database table in
 * a nicely formatted html table.
 */
function displayUsers(){
   global $database;
   $q = "SELECT id,name,username,userlevel,email,school,activation,postcode,timestamp,how,what "
       ."FROM ".TBL_USERS." ORDER BY timestamp DESC,username";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysqli_num_rows($result);
   if(!$result || ($num_rows < 0)){
      echo "Error displaying info";
      return;
   }
   if($num_rows == 0){
      echo "Database table empty";
      return;
   }
   /* Display table contents */
   echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Username</b></td><td><b>Level</b></td><td><b>Plans</b></td><td><b>Name</b></td><td><b>School</b></td><td><b>Postcode</b></td><td><b>Email</b></td><td><b>Last Active</b></td><td><b>Activated</b><td><b>How they heard</b><td><b>What are they</b></td></tr>\n";
   for($i=0; $i<$num_rows; $i++){
      $id  = $database->mysqli_result($result,$i,"id");
      $name  = $database->mysqli_result($result,$i,"name");
      $uname  = $database->mysqli_result($result,$i,"username");
      $ulevel = $database->mysqli_result($result,$i,"userlevel");
      $email  = $database->mysqli_result($result,$i,"email");
      $school  = $database->mysqli_result($result,$i,"school");
      $postcode  = $database->mysqli_result($result,$i,"postcode");
      $activation  = $database->mysqli_result($result,$i,"activation");
      $time  = date("F dS, Y H:i",$database->mysqli_result($result,$i,"timestamp"));
      $how = $database->mysqli_result($result,$i,"how");
      $what = $database->mysqli_result($result,$i,"what");
      $num_plans=mysqli_num_rows($database->query("select id from unit_of_work where teacher_id=$id"));
      echo "<tr><td><a href='edit_user.php?user=$uname'>$uname</td><td>$ulevel</td><td>$num_plans</td><td>$name</td><td>$school</td><td>$postcode</td><td>$email</td><td>$time</td><td>$activation</td><td>$how</td><td>$what</td></tr>\n";
   }
   echo "</table><br>\n";
}

/**
 * displayBannedUsers - Displays the banned users
 * database table in a nicely formatted html table.
 */
function displayBannedUsers(){
   global $database;
   $q = "SELECT username,timestamp "
       ."FROM ".TBL_BANNED_USERS." ORDER BY username";
   $result = $database->query($q);
   /* Error occurred, return given name by default */
   $num_rows = mysqli_num_rows($result);
   if(!$result || ($num_rows < 0)){
      echo "Error displaying info";
      return;
   }
   if($num_rows == 0){
      echo "Database table empty";
      return;
   }
   /* Display table contents */
   echo "<table align=\"left\" border=\"1\" cellspacing=\"0\" cellpadding=\"3\">\n";
   echo "<tr><td><b>Username</b></td><td><b>Time Banned</b></td></tr>\n";
   for($i=0; $i<$num_rows; $i++){
      $uname = $database->mysqli_result($result,$i,"username");
      $time  = date("F dS, Y H:i",$database->mysqli_result($result,$i,"timestamp"));

      echo "<tr><td>$uname</td><td>$time</td></tr>\n";
   }
   echo "</table><br>\n";
}
/**
 * User not an administrator, redirect to main page
 * automatically.
 */
if(!$session->isAdmin()){
   header("Location: ../main.php");
}
else{
/**
 * Administrator is viewing page, so display all
 * forms.
 */
?>
<html>
<title>PE Planning | Account Administrator</title>
<body>
<h1>Admin Center</h1>
<font size="5" color="#ff0000">
<b>::::::::::::::::::::::::::::::::::::::::::::</b></font>
<font size="4">Logged in as <b><?php echo $session->username; ?></b></font><br><br>
Back to [<a href="index.php">Main Admin Page</a>]<br><br>
<?php
if($form->num_errors > 0){
   echo "<font size=\"4\" color=\"#ff0000\">"
       ."!*** Error with request, please fix</font><br><br>";
}
?>
<table align="left" border="0" cellspacing="5" cellpadding="5">
<tr><td>
<?php
/**
 * Display Users Table
 */
?>
<h3>Users Table Contents:</h3>
<?php
displayUsers();
?>
</td></tr>
<tr>
<td>
<?php echo "</td></tr><tr><td align=\"center\"><br><br>";
echo "<b>Member Total:</b> ".$database->getNumMembers()."<br>";
echo "There are $database->num_active_users registered members and ";
echo "$database->num_active_guests guests viewing the site.<br><br>";

include("view_active.php");
?>
</td></tr>
<tr>
<td>
<br>
<?php
/**
 * Update User Level
 */
?>

<?php
/**
 * Delete User
 */
?>
<h3>Delete User</h3>
<?php echo $form->error("deluser"); ?>
<form action="adminprocess.php" method="POST">
Username:<br>
<input type="text" name="deluser" maxlength="128" value="<?php echo $form->value("deluser"); ?>">
<input type="hidden" name="subdeluser" value="1">
<input type="submit" value="Delete User">
</form>
</td>
</tr>
<tr>
<td><hr></td>
</tr>
<tr>
<td>
<?php
/**
 * Delete Inactive Users
 */
?>
<h3>Delete Inactive Users</h3>
This will delete all users (not administrators), who have not logged in to the site<br>
within a certain time period. You specify the days spent inactive.<br><br>
<table>
<form action="adminprocess.php" method="POST">
<tr><td>
Days:<br>
<select name="inactdays">
<option value="3">3
<option value="7">7
<option value="14">14
<option value="30">30
<option value="100">100
<option value="365">365
</select>
</td>
<td>
<br>
<input type="hidden" name="subdelinact" value="1">
<input type="submit" value="Delete All Inactive">
</td>
</form>
</table>
</td>
</tr>
<tr>
<td><hr></td>
</tr>
<tr>
<td>
<?php
/**
 * Ban User
 */
?>
<h3>Ban User</h3>
<?php echo $form->error("banuser"); ?>
<form action="adminprocess.php" method="POST">
Username:<br>
<input type="text" name="banuser" maxlength="30" value="<?php echo $form->value("banuser"); ?>">
<input type="hidden" name="subbanuser" value="1">
<input type="submit" value="Ban User">
</form>
</td>
</tr>
<tr>
<td><hr></td>
</tr>
<tr><td>
<?php
/**
 * Display Banned Users Table
 */
?>
<h3>Banned Users Table Contents:</h3>
<?php
displayBannedUsers();
?>
</td></tr>
<tr>
<td><hr></td>
</tr>
<tr>
<td>
<?php
/**
 * Delete Banned User
 */
?>
<h3>Delete Banned User</h3>
<?php echo $form->error("delbanuser"); ?>
<form action="adminprocess.php" method="POST">
Username:<br>
<input type="text" name="delbanuser" maxlength="30" value="<?php echo $form->value("delbanuser"); ?>">
<input type="hidden" name="subdelbanned" value="1">
<input type="submit" value="Delete Banned User">
</form>
</td>
</tr>
</table>
</body>
</html>
<?php }
?>

