<?php include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
//session_start();
//print_r($_SESSION['form_errors']);
//print_r($_SESSION['form_values']);
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
    <title id="page_title">PE Planning | Subscribe</title>
<link href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/pep-https.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css" />
<link href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/geo-https.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css" />
<link href="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/css/buttons_new-https.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css" />
        <style type="text/css">

        body { background: #FFFFFF; }



    </style>
      <link href="/tplan/css/subscribe.css?<?=time()?>" media="screen, projection" rel="stylesheet" type="text/css" />

  </head>

  <body class="account chrome" id="new">    <div class="fixed-banners">


    </div>
    <script type="text/javascript">
//<![CDATA[
if (window.top !== window.self) {document.write = "";window.top.location = window.self.location; setTimeout(function(){document.body.innerHTML='';},1);window.self.onload=function(evt){document.body.innerHTML='';};}
//]]>
</script>
<div id="container" class="subpage">
            <span id="loader" style="display:none"><img alt="Loader" src="/tplans/images/loader.gif" /></span>
     <div class="clearfix no-nav" id="header">
            <a href="/tplan/main.php" title="PEPlanning / Home" accesskey="1" id="logo">
            <img alt="peplanning.org.uk" src="/tplan/index_files/bnb_logo.jpg" />
            </a>
    </div>
<div class="content-heading">
  <div class="heading">
    <h2>Subscription Order Form</h2>
   
  </div>
</div>
<div class="content-section">
<div id="signup-form" class="">
  <form action="/tplan/process.php" method="post" id="subscribe"><div style="margin:0;padding:0"><input name="subscribe" type="hidden" value="1" /></div>
    <fieldset>
      <table class="input-form">
        <tr class="school-name">
          <th>
            <label for="school_name">School Name</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="school_name" maxlength="64" name="school" size="30" tabindex="2" type="text" value="<? echo $_SESSION['form_values']['school']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter the name of your school.
             </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['school_name']?>

            </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span id="schoolname_url" class="field-desc">

              </span>
          </td>
        </tr>
        <tr class="school-name">
          <th>
            <label for="address-1">Address</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="address-1" maxlength="128" name="address-1" size="30" tabindex="2" type="text" value="<? echo $_SESSION['form_values']['address-1']?>" />
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter the address of your school
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['address-1']?>
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
             
            </span>
          </td>
        </tr>
        <tr class="school-name">
          <th>
            <label for="address-2"></label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="address-2" maxlength="128" name="address-2" size="30" tabindex="3" type="text" value="<? echo $_SESSION['form_values']['address-2']?>" />
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter the address of your school
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['address-1']?>
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              
            </span>
          </td>
        </tr>
        <tr class="school-name">
          <th>
            <label for="address-3"></label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="address-3" maxlength="128" name="address-3" size="30" tabindex="4" type="text" value="<? echo $_SESSION['form_values']['address-3']?>" />
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter the address of your school
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['address-1']?>
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              
            </span>
          </td>
        </tr>
        <tr class="postcode">
          <th>
            <label for="user_postcode">Postcode</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="user_postcode" maxlength="20" name="postcode" size="20" tabindex="5" type="text" value="<? echo $_SESSION['form_values']['postcode']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter your postcode
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['user_postcode']?>
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
             
            </span>
          </td>
        </tr>
       <tr class="telephone">
          <th>
            <label for="telephone">Telephone</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="telephone" maxlength="20" name="telephone" size="20" tabindex="6" type="text" value="<? echo $_SESSION['form_values']['telephone']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter your contact number
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['telephone']?>
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
              
            </span>
          </td>
        </tr>
         <tr class="email">
          <th>
            <label for="user_email">Email</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="user_email" name="email" size="30" maxlength="128" tabindex="7" type="text" value="<? echo $_SESSION['form_values']['email']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              <span id="email_info">We'll send you a confirmation</span>
              <span id="avail_email_check_indicator" style="display:none">
                <img alt="Indicator_arrows_circle" src="https://<?echo $_SERVER['SERVER_NAME']?>/tplans/images/indicator_arrows_circle.gif" /> Checking availability...
              </span>
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['user_email']?></div>
          </td>
        </tr>
         <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
             
            </span>
          </td>
        </tr>
         <tr class="full-name">
          <th>
            <label for="user_name">Contact name</label>
          </th>
          <td class="col-field">
            <input autocomplete="off" class="text_field" id="user_name" maxlength="64" name="name" size="32" tabindex="8" type="text" value="<? echo $_SESSION['form_values']['name']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter your first and last name
            </div>
            <div class="label-box good">
              Ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['user_name']?></div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
             
            </span>
          </td>
        </tr>
         <tr class="class-num">
          <th>
            <label for="class-num">Subscription Costs</label>
          </th>
          <td class="col-field">
            <input onchange="calculateCosts(this.id)" autocomplete="off" class="text_field" id="class-num" maxlength="20" name="class-num" size="20" tabindex="9" type="text" value="<? echo $_SESSION['form_values']['class-num']?>"/><input name="total_cost" id="total_cost" type="hidden" value="<? echo $_SESSION['form_values']['total_cost']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Enter the number of classes in school from reception onwards
            </div>
            <div class="label-box good">
              <div id="cost"></div>
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['class-num']?>
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">
                
            </span>
          </td>
        </tr>
         <tr class="sub-from">
          <th>
            <label for="sub-from">Subscription From</label>
          </th>
          <td class="col-field">
            <input class="text_field" id="sub-from" maxlength="20" name="sub-from" size="20" tabindex="10" type="text" value="<? echo date("d-m-Y",mktime(0, 0, 0, date("m"), date("d")+2, date("Y")))?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              when do you want to subscribe from?
            </div>
            <div class="label-box good">
            ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['sub-from']?>
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">

            </span>
          </td>
        </tr>
        <tr class="sub-to">
          <th>
            <label for="sub-to">Subscription To</label>
          </th>
          <td class="col-field">
            <input onchange="calculateCosts(this.id)" autocomplete="off" class="text_field" id="sub-to" maxlength="20" name="sub-to" size="20" tabindex="10" type="text" value="<? echo date("d-m-Y",mktime(0, 0, 0, date("m"), date("d")+1, date("Y")+1))?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              Must be at least 12 months later
            </div>
            <div class="label-box good">
             ok
            </div>
            <div class="label-box error"><? echo $_SESSION['form_errors']['sub-to']?>
                          </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <span class="field-desc">

            </span>
          </td>
        </tr>
        <tr class="email-updates">
          <th></th>
          <td colspan="2" class="col-field">
            <div id="invoice"  class="side-section"> <p class="explanation">An invoice for the total subscription cost will be sent to your school address after the first day of the subscription period.  Payment is due within 21 days of the invoice date.</p></div>
        </td>
        </tr>
        <tr class="email-updates">
          <th></th>
          <td colspan="2" class="col-field">
            <div class="side-section">
                <p class="explanation">This is a subscription order and not the sale of goods</p>
                 <p class="explanation">This is not a VAT invoice.</p>
                  <p class="explanation">Please read <a href="termsandconditions.php">Terms & Conditions of Use</a> set out on the home page</p>
            </div><!-- close side-section div-->
          </td>
        </tr>
        <tr class="email-updates">
          <th></th>
          <td colspan="2" class="col-field">
            <div id="scoop"><input id="agree_to_terms" name="agree_to_terms" tabindex="10" type="checkbox" value="1" />
              <label for="agree_to_terms">
               This subscription order is not subject to cancellation by the client. By checking this box you confirm that you have read and accepted the <a href="termsandconditions.php">Terms & Conditions of Use</a> of the Website www.peplanning.org.uk as set out on the homepage of www.peplanning.org.uk.
              </label>
            </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <input alt="I accept. Create my account." class="btn btn-m" id="subscribe_submit" tabindex="11" type="submit" value="Subscribe" /> </td>
        </tr>
      </table>
    </fieldset>
</form>
</div><!-- close sign-up form div-->
</div><!-- close content-section div-->
  
</div><!-- close container div-->
<hr />
</div>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.3.2.min.js?<?=time()?>" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/pep-https.js?<?=time()?>" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery.tipsy.min.js?<?=time()?>" type="text/javascript"></script>
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/gears_init.js?<?=time()?>" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/mustache.js?<?=time()?>" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/geov1.js?<?=time()?>" type="text/javascript"></script>
<script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/api.js?<?=time()?>" type="text/javascript"></script>
<? if ($_SESSION['form_errors']){?>
<script type="text/javascript">
    $("#signup-form").addClass('validated-by-backend');
    <? foreach($_SESSION['form_errors'] as $field_name) {
        echo "$('#".array_search($field_name,$_SESSION['form_errors'])."').wrap('<div class=\"fieldWithErrors\" />');";
        }?>
    </script>
<? }?>
<script type="text/javascript">
    function calculateCosts(fromField)
    {
        var numClasses=document.getElementById('class-num').value;
        var year1=document.getElementById('sub-from').value.substr(8,2);
        var year2=document.getElementById('sub-to').value.substr(8,2);
        var numYears=year2-year1;
        if (fromField=='class-num'){
        totalCost=(numClasses*25);
        $('#cost').html('<p class="explanation">'+numClasses+' classes = <b>£'+totalCost+'</b> per year</p>');}
        if (fromField=='sub-to'){
        totalCost=(numClasses*25)*numYears;
        $('#cost').html('<p class="explanation">'+numClasses+' classes for '+numYears+' years = <b>£'+totalCost+'</b></p>');}
        $('#total_cost').val(totalCost);
        $('#invoice').show;
        //alert(totalCost);
    }
    $(document).ready(function() {
    $("#subscribe").submit(function(e) {
        if (e.originalEvent.explicitOriginalTarget.id == "subscribe_submit") {
            if (document.getElementById('agree_to_terms').checked) {
                return true;
            }
            else{
                alert('You must agree to the terms and conditions before proceeding');
                e.preventDefault();
                return false;
            }
        }
    });

    return;
});
</script>
  <script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/subscribe.js?<?=time()?>" type="text/javascript"></script>
 <!-- <script src="/tplan/js/captcha_dialog.js?1285813196" type="text/javascript"></script>

      <script type="text/javascript">
        var RecaptchaOptions = {
           theme: 'custom',
           lang: 'en',
           custom_theme_widget: 'recaptcha_widget'
        };
      </script>
      <script type="text/javascript" src="https://api-secure.recaptcha.net/challenge?k=6Lcjfb0SAAAAAH5HChhuYKfLNE4J49WBVycC19ki&lang=en"></script>

-->

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
<!--<script type="text/javascript">
//<![CDATA[

      $( function () {

  $("#signup-form form").data("captchaValid", false);
  (function() {
    var oldHeight = $("#tos").css("height");
    $("#tos").click(function(e) {
      var $tos = $(e.target);
      $tos.animate({height: (($tos.css("height") == oldHeight) ? "12em" : oldHeight)}, "fast");
    });
  })();
  $('p.sign-in a').scribe({ bucket: "v1", event_name: "create_account_sign_in" }, 'www_ab_tests', { filter: 'new_signup_flow' });
  $('p.finish-signup a').scribe({ bucket: "v1", event_name: "create_account_finish_signup" }, 'www_ab_tests', { filter: 'new_signup_flow' });
  $('#header #logo').scribe({ bucket: "v1", event_name: "create_account_logo" }, 'www_ab_tests', { filter: 'new_signup_flow' });
(function(){function b(){var c=location.href.split("#!")[1];if(c){window.location.hash = "";window.location.pathname = c.replace(/^([^/])/,"/$1");}else return true}var a="onhashchange"in window;if(!a&&window.setAttribute){window.setAttribute("onhashchange","return;");a=typeof window.onhashchange==="function"}if(a)$(window).bind("hashchange",b);else{var d=function(){b()&&setTimeout(d,250)};setTimeout(d,250)}}());
      });

//]]>
</script>
-->
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






  </body>

</html>
<? unset($_SESSION['form_errors']);