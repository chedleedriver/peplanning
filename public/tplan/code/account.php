<?php
if(@$_SERVER['HTTPS'] == false)
  {
     $redirect= "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
     header("Location: $redirect");
     print $redirect;
  }
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=8">

    <script type="text/javascript">
//<![CDATA[
(function(g){var a=location.href.split("#!")[1];if(a){window.location.hash = "";g.location.pathname = g.HBR = a.replace(/^([^/])/,"/$1");}})(window);
//]]>
</script>
    <script type="text/javascript" charset="utf-8">
      if (!twttr) {
        var twttr = {}
      }

      // Benchmarking load time.
      // twttr.timeTillReadyUnique = '1285847576-15368-41672';
      // twttr.timeTillReadyStart = new Date().getTime();
    </script>

        <script type="text/javascript">
//<![CDATA[
var page={};var onCondition=function(D,C,A,B){D=D;A=A?Math.min(A,5):5;B=B||100;if(D()){C()}else{if(A>1){setTimeout(function(){onCondition(D,C,A-1,B)},B)}}};
//]]>
</script>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<meta content="en-us" http-equiv="Content-Language" />
<meta content="no" http-equiv="imagetoolbar" />
<meta content="width = 780" name="viewport" />
<meta content="4FTTxY4uvo0RZTMQqIyhh18HsepyJOctQ+XTOu1zsfE=" name="verify-v1" />
<meta content="1" name="page" />
<meta content="NOODP" name="robots" />
<meta content="n" name="session-loggedin" />
<meta content="" name="page-user-screen_name" />
    <title id="page_title">PE Planning | Change Your Account</title>
<link href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/pep-https.css" media="screen" rel="stylesheet" type="text/css" />
<link href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/geo-https.css" media="screen" rel="stylesheet" type="text/css" />
<link href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/buttons_new-https.css" media="screen" rel="stylesheet" type="text/css" />
        <style type="text/css">

        body { background: #FFFFFF; }



    </style>
      <link href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/signupflow-https.css" media="screen, projection" rel="stylesheet" type="text/css" />

  </head>

  <body class="account chrome" id="new">    <div class="fixed-banners">


    </div>
    <script type="text/javascript">
//<![CDATA[
if (window.top !== window.self) {document.write = "";window.top.location = window.self.location; setTimeout(function(){document.body.innerHTML='';},1);window.self.onload=function(evt){document.body.innerHTML='';};}
//]]>
</script>



    




    <div id="container" class="subpage">
            <span id="loader" style="display:none"><img alt="Loader" src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/loader.gif" /></span>
      <div class="clearfix no-nav" id="header">
  <a href="<?if ($session->logged_in)echo 'http://';else echo 'https://';echo $_SERVER['SERVER_NAME']?>/tplan/main.php" title="PEPlanning / Home" accesskey="1" id="logo">
          <img alt="peplanning.org.uk" src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/index_files/bnb_logo.jpg" />
  </a>
  </div>





      <div class="content-bubble-arrow"></div>



        <table cellspacing="0" class="columns">
          <tbody>
            <tr>
              <td id="content" class="round-left column wide">
                                <div class="wrapper">




<div class="content-heading">
  <div class="heading">
<? if (!$session->logged_in) {?>
    <p class="sign-in">
      You must be signed in to make changes <a href="/tplan/code/login.html">Sign in</a>.
    </p>
    <? } else {
    $userinfo=$database->getUserInfo($_SESSION['username']);
    ?>
    <p class="sign-in">
      need a new password?&nbsp;<a href="/tplan/code/password.php">Change Password</a>.
    </p>
    <h2>Change Your Settings</h2>
   <? if ($_SESSION['useredit']) {?><p>Changes have been successfully saved</p><a href="/tplan/main.php">click here to return to the start page</a><?$_SESSION['useredit']=false;}
   ?>

  </div>
</div>

<div id="signup-form" class="">
  <form action="/tplan/process.php" method="post"><div style="margin:0;padding:0"><input name="subedit" type="hidden" value="1" /></div>
    <input id="follow" name="follow" type="hidden" />
    <fieldset>
      <table class="input-form">
        <? if ($_GET['error']){ ?>
      <tr>
          <th></th>
         <td>
            <label class="error">
                <? echo base64_decode($_GET['error']);
                 ?>
            </label>
         </td>
      </tr>
      <? }?>
      <tr class="full-name">
          <th>
            <label for="user_name">Full name</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="user_name" maxlength="40" name="name" size="20" tabindex="1" type="text" value="<? echo $userinfo['name']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter your first and last name
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error">
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              Your full name will appear on your plans and assessments
            </span>
          </td>
        </tr>
        <!--<tr class="screen-name">
          <th>
            <label for="user_screen_name">Username</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="user_screen_name" maxlength="15" name="user" size="15" tabindex="2" type="text" />
          </td>
          <td class="col-help">
            <div class="label-box info">
              <span id="screen_name_info">Pick a unique name.</span>
              <span id="avail_screenname_check_indicator" style="display:none">
                <img alt="Indicator_arrows_circle" src="/tplan/images/indicator_arrows_circle.gif" /> Checking availability...
              </span>
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error">

            </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span id="screen_name_url" class="field-desc">
                 You will sign onto PE Planning with your username
              </span>
          </td>
        </tr>
        <tr>
          <th>
            <label for="user_password">Password</label>
          </th>
          <td class="col-field">

              <input autocomplete="off" class="text_field" id="user_password" name="password" size="30" tabindex="3" type="password" />

          </td>
          <td class="col-help">
            <div class="label-box password-meter">
              <span>6 characters or more (be tricky!)</span>
            </div>
          </td>
        </tr>-->
        <tr class="email">
          <th>
            <label for="user_email">Email</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="user_email" name="email" size="30" tabindex="4" type="text" value="<? echo $userinfo['email']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              <span id="email_info">We'll send you a confirmation</span>
              <span id="avail_email_check_indicator" style="display:none">
                <img alt="Indicator_arrows_circle" src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/images/indicator_arrows_circle.gif" /> Checking availability...
              </span>
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error">

            </div>
          </td>
        </tr>
         <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              This information will only be used by PE Planning Limited.
            </span>
          </td>
        </tr>
       <tr class="school-name">
          <th>
            <label for="school_name">School name</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="school_name" maxlength="20" name="school" size="20" tabindex="6" type="text" value="<? echo $userinfo['school']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter the name of your school
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error">
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              This information will only be used by PE Planning Limited.
            </span>
          </td>
        </tr>
        <tr class="postcode">
          <th>
            <label for="postcode">Postcode</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="postcode" maxlength="20" name="postcode" size="20" tabindex="7" type="text" value="<? echo $userinfo['postcode']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter your postcode
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error">
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              This information will only be used by PE Planning Limited.
            </span>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <input alt="Update my account." class="btn btn-m" id="user_create_submit" tabindex="8" type="submit" value="Update my account" />          </td>
        </tr>
        <tr class="email-updates">
          <th></th>
          <td colspan="2" class="col-field">
            <input id="user_send_email_newsletter" name="send_email_newsletter" tabindex="9" type="checkbox" <?if ($userinfo['newsletter']==1) echo 'checked="yes"';?>/>
              <label for="user_send_email_newsletter">
                please send me email updates!
              </label>
          
          </td>
        </tr>
      </table>
    </fieldset>

    
</form></div>
</div></td</tr>
</tbody>
</table>
<hr />
</div>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/pep-https.js" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery.tipsy.min.js" type="text/javascript"></script>
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/gears_init.js" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/mustache.js" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/geov1.js" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/api.js" type="text/javascript"></script>

  <script type="text/javascript">
//<![CDATA[
  twttr.BANNED_PASSWORDS = ["000000","111111","11111111","112233","121212","123123","123456","1234567","12345678","123456789","131313","232323","654321","666666","696969","777777","7777777","8675309","987654","aaaaaa","abc123","abc123","abcdef","abgrtyu","access","access14","action","albert","alberto","alexis","alejandra","alejandro","amanda","amateur","america","andrea","andrew","angela","angels","animal","anthony","apollo","apples","arsenal","arthur","asdfgh","asdfgh","ashley","asshole","august","austin","badboy","bailey","banana","barney","baseball","batman","beatriz","beaver","beavis","bigcock","bigdaddy","bigdick","bigdog","bigtits","birdie","bitches","biteme","blazer","blonde","blondes","blowjob","blowme","bond007","bonita","bonnie","booboo","booger","boomer","boston","brandon","brandy","braves","brazil","bronco","broncos","bulldog","buster","butter","butthead","calvin","camaro","cameron","canada","captain","carlos","carter","casper","charles","charlie","cheese","chelsea","chester","chicago","chicken","cocacola","coffee","college","compaq","computer","cookie","cooper","corvette","cowboy","cowboys","crystal","cumming","cumshot","dakota","dallas","daniel","danielle","debbie","dennis","diablo","diamond","doctor","doggie","dolphin","dolphins","donald","dragon","dreams","driver","eagle1","eagles","edward","einstein","erotic","estrella","extreme","falcon","fender","ferrari","firebird","fishing","florida","flower","flyers","football","forever","freddy","freedom","fucked","fucker","fucking","fuckme","fuckyou","gandalf","gateway","gators","gemini","george","giants","ginger","golden","golfer","gordon","gregory","guitar","gunner","hammer","hannah","hardcore","harley","heather","helpme","hentai","hockey","hooters","horney","hotdog","hunter","hunting","iceman","iloveyou","internet","iwantu","jackie","jackson","jaguar","jasmine","jasper","jennifer","jeremy","jessica","johnny","johnson","jordan","joseph","joshua","junior","justin","killer","knight","ladies","lakers","lauren","leather","legend","letmein","letmein","little","london","lovers","maddog","madison","maggie","magnum","marine","mariposa","marlboro","martin","marvin","master","matrix","matthew","maverick","maxwell","melissa","member","mercedes","merlin","michael","michelle","mickey","midnight","miller","mistress","monica","monkey","monkey","monster","morgan","mother","mountain","muffin","murphy","mustang","naked","nascar","nathan","naughty","ncc1701","newyork","nicholas","nicole","nipple","nipples","oliver","orange","packers","panther","panties","parker","password","password","password1","password12","password123","patrick","peaches","peanut","pepper","phantom","phoenix","player","please","pookie","porsche","prince","princess","private","purple","pussies","qazwsx","qwerty","qwertyui","rabbit","rachel","racing","raiders","rainbow","ranger","rangers","rebecca","redskins","redsox","redwings","richard","robert","roberto","rocket","rosebud","runner","rush2112","russia","samantha","sammy","samson","sandra","saturn","scooby","scooter","scorpio","scorpion","sebastian","secret","sexsex","shadow","shannon","shaved","sierra","silver","skippy","slayer","smokey","snoopy","soccer","sophie","spanky","sparky","spider","squirt","srinivas","startrek","starwars","steelers","steven","sticky","stupid","success","suckit","summer","sunshine","superman","surfer","swimming","sydney","tequiero","taylor","tennis","teresa","tester","testing","theman","thomas","thunder","thx1138","tiffany","tigers","tigger","tomcat","topgun","toyota","travis","trouble","trustno1","tucker","turtle","twitter","united","vagina","victor","victoria","viking","voodoo","voyager","walter","warrior","welcome","whatever","william","willie","wilson","winner","winston","winter","wizard","xavier","xxxxxx","xxxxxxxx","yamaha","yankee","yankees","yellow","zxcvbn","zxcvbnm","zzzzzz"];
      page.controller_name = 'AccountController';
      page.action_name = 'new';
      twttr.form_authenticity_token = '650461213e1c9f3f36de0623a820c833edbc9c31';
      $.ajaxSetup({ data: { authenticity_token: '650461213e1c9f3f36de0623a820c833edbc9c31' } });

      // FIXME: Reconcile with the kinds on the Status model.
      twttr.statusKinds = {
        UPDATE: 1,
        SHARE: 2
      };
      twttr.ListPerUserLimit = 20;




//]]>
</script>

        <!-- BEGIN google analytics -->

  <script type="text/javascript">
        /* google analytics */
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-16957975-1']);
        _gaq.push(['_trackPageview']);

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        </script>

  <!-- END google analytics -->




    <div id="notifications"></div>





<? }?>
  </body>

</html> 