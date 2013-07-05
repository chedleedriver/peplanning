<?php $userinfo=$database->getUserInfo($_SESSION['username']);?>
<ul id="menu">
    <li><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/index.php" id="nav-home">home</a></li>
    <li><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/createplan.php" id="nav-createplan">create plan</a></li>
    <li><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/myplans.php" id="nav-myplans">my plans</a></li>
    <li><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/myassessment.php" id="nav-myassessment">my assessment</a></li>
    <li><a href="#" id="nav-products">products&nbsp;&nbsp;<img src='<?php if (!empty($_SERVER['HTTPS'])) echo "https://".$_SERVER['SERVER_NAME']; else echo "http://".$_SERVER['SERVER_NAME']?>/tplan/images/toggle_down_light.png' border="0"/></a>
            <ul class="submenu">
            <li><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/peschool.php" id="nav-peschool">PEschool</a></li>
            <li><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/peteacher.php" id="nav-peteacher">PEteacher</a></li>
            <li><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/pecoach.php" id="nav-pecoach">PEcoach</a></li>
        </ul>
 </li>
    <li><a href="" id="nav-account"><? echo $_SESSION['username']?>&nbsp;&nbsp;<img src='<?php if (!empty($_SERVER['HTTPS'])) echo "https://".$_SERVER['SERVER_NAME']; else echo "http://".$_SERVER['SERVER_NAME']?>/tplan/images/toggle_down_light.png' border="0"/></a>
        <ul class="submenu">
            <li><a href="https://<?php echo $_SERVER['HTTP_HOST']?>/tplan/account.php">account</a></li>
            <? if ($userinfo['userlevel']==9) echo "<li><a href='http://".$_SERVER['SERVER_NAME']."/tplan/DB_Maintenance/index.php'>admin</a></li>";?>
            <li><a href="help.html">help</a></li>
            <li><a href="process.php">sign out</a></li>
        </ul>
    </li>
    <li><a href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/contact.php"s id="nav-contact">contact us</li>
</ul>
