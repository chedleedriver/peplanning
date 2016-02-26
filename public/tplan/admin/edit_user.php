<?php 
include_once($_SERVER["DOCUMENT_ROOT"] . '/../library/tplan_config.php'); 
include("session.php");
include('functions.php');
$userinfo=$database->getUserInfo($_GET['user']);
$unitinfo=$database->getUserUnitInfo($userinfo['id']);
//print_r($userinfo);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <form action="process.php" method="POST">
<table align="left" border="0" cellspacing="10" cellpadding="3">


<tr>
<td>New Password:</td>
<td><input type="password" name="newpass" maxlength="30" value=""></td>
<td></td>
</tr>
<tr>
<td>Name:</td>
<td><input type="text" name="name" maxlength="30" value="<?php echo $userinfo['name']?>"/>
</td>

<td></td>
</tr>
<tr>
<td>Telephone:</td>
<td><input type="text" name="telephone" maxlength="30" value="<?php echo $userinfo['telephone']?>">
</td>
<td></td>
</tr>
<tr>
<td>School:</td>
<td><input type="text" name="school" maxlength="30" value="<?php echo $userinfo['school']?>
">
</td>
<td></td>
</tr>
<tr>

<td>Postcode:</td>
<td><input type="text" name="postcode" maxlength="30" value="<?php echo $userinfo['postcode']?>
">
</td>
<td></td>
</tr>
<tr>
<td>Email:</td>
<td><input type="text" name="email" size="30" maxlength="80" value="<?php echo $userinfo['email']?>
">
</td>
<td></td>
</tr>
<tr>
<td>Newsletter:</td>
<td><input type="text" name="newsletter" size="30" maxlength="80" value="<?php echo $userinfo['newsletter']?>
">
</td>
<td></td>
</tr></tr>
<tr>
<td>Access Level (9=admin):</td>
<td><input type="text" name="userlevel" size="30" maxlength="80" value="<?php echo $userinfo['userlevel']?>
">
</td>
<td></td>
</tr>
<tr>
<td>Activation</td>
<td><input type="text" name="activation" size="30" maxlength="80" value="<?php echo $userinfo['activation']?>
">
</td>
<td></td>
</tr>
<tr>
<td>Number of Plans:</td>
<td><?php echo count($unitinfo)?>

</td>
<td></td>
</tr>
<tr><td colspan="2" align="right">
<input type="hidden" name="subotheredit" value="1">
<input type="hidden" name="username" value="<?php echo  $userinfo['username']?>">
<input type="submit" value="Save Settings"></td></tr>
<tr><td colspan="3" align="left">
        <table>
            <tr>
                <td>
                   id
                </td>
                <td>
                   description
                </td>
                <td>
                   num_lessons
                </td>
                <td>
                  date_created
                </td>
            </tr>
            <?php for ($i=0;$i<=count($unitinfo);$i++)
            {?>
            <tr>
                <td>
                   <a href="../Lessons.php?unit_id=<?php echo  $unitinfo[$i]['id']?>&plan_type=newPlan"><?php echo  $unitinfo[$i]['id'];?></a>
                </td>
                <td>
                   <?php echo  $unitinfo[$i]['description'];?>
                </td>
                <td>
                   <?php echo  $unitinfo[$i]['num_lessons'];?>
                </td>
                <td>
                   <?php echo  $unitinfo[$i]['date_created'];?>
                </td>
            </tr>
            <?php }?>
        </table>
    </td></tr>
</table>
</form>
    </body>
</html>
