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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | Subscribe</title>
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css"/>
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/pep-https.css?<?=time()?>" media="screen" rel="stylesheet" type="text/css" />
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/geo-https.css<?=time()?>" media="screen" rel="stylesheet" type="text/css" />
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/buttons_new-https.css<?=time()?>" media="screen" rel="stylesheet" type="text/css" />
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/signupflow-https.css?<?=time()?>" media="screen, projection" rel="stylesheet" type="text/css" />
        <link href="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/subscribe.css?<?=time()?>" media="screen, projection" rel="stylesheet" type="text/css" />
    </head>
    <body id="login">
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/pep-https.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery.tipsy.min.js?<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/mustache.js<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/geov1.js<?=time()?>" type="text/javascript"></script>
    <script src="https://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/api.js<?=time()?>" type="text/javascript"></script>
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
<?php include("header.php")?>
<div id="subscribe-doc"  class="subscribe">
<div class="content-heading">
  <div class="heading">
     <h2>PEschool Order Form</h2>

  </div>
</div>

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
            <label for="class-num">Number of Classes</label>
          </th>
          <td class="col-field">
            <input onchange="calculateCosts(this.id)" autocomplete="off" class="text_field" id="class-num" maxlength="20" name="class-num" size="20" tabindex="9" type="text" value="<? echo $_SESSION['form_values']['class-num']?>"/><input name="total_cost" id="total_cost" type="hidden" value="<? echo $_SESSION['form_values']['total_cost']?>"/>
          </td>
          <td class="col-help">
            <div class="label-box info">
              When you enter the number of classes in school we will calculate the cost
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
               This subscription order is not subject to cancellation by the client. By checking this box you confirm that you have read and accepted the <a href="termsandconditions.php">Terms & Conditions of Use</a> of the Website www.peplanning.org.uk as set out on the homepage of www.peplanning.org.uk
              </label>
            </div>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan="2">
            <input alt="I accept. Create my account." value="" id="subscribe_submit" tabindex="11" type="submit"  class="create-subscription" /> </td>
        </tr>
      </table>
    </fieldset>
</form>
</div>
</div>
     <?php include("footer.php")?>
<?php if ($_SESSION['form_errors']){?>
    <script type="text/javascript">
    $("#signup-form").addClass('validated-by-backend');
    <?php foreach($_SESSION['form_errors'] as $field_name) {
        echo "$('#".array_search($field_name,$_SESSION['form_errors'])."').wrap('<div class=\"fieldWithErrors\" />');";
        }?>
    </script>
<?php }?>
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
  <script src="https://<?echo $_SERVER['SERVER_NAME']?>/tplan/js/subscribe.js?<?=time()?>" type="text/javascript"></script></body>
</html>
<?php unset($_SESSION['form_errors']);?>