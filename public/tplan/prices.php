<?php
include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>PE Planning | Prices and Services</title>
        <link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/css/indexcss.css?<?=time()?>" media="screen"/>
    </head>
    <body id="prices">
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-1.5.1.js?<?=time()?>"></script>
    <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/indexScripts.js?<?=time()?>"></script>
   <script type="text/javascript" src="http://<?php echo $_SERVER['SERVER_NAME']?>/tplan/js/jquery-ui-1.8.1.custom.min.js?<?=time()?>"></script>
<?php include("header.php")?>
    <div id="friends-doc"  class="friends">
      <h1>Prices and Services</h1>
      <h2>How to Subscribe</h2>
      <p>You can subscribe to any of PEplannings products by clicking ‘Buy Me’ button on the product page of the service you wish to purchase</p>
      <p>OR</p>
      <p>Alternatively call us on 01535 649 403 and we can complete your subscription for you</p>
      <h2>Subscription costs</h2>
      <h2><u>PEschool</u></h2>
      <p>
      <ul>
          <li>1 from entry school (7 classes) - £175 annual subscription</li>
          <li>2 from entry school (14 classes) - £350 annual subscription</li>
          <li>3 form entry school (21 classes) - £525 annual subscription</li>
      </ul>
      </p>
      <p><i>** Please note if your school does not fit into one of the above categories specific quotes are available upon request – call Matthew on 01535 649 403</i></p>
      <h2><u>PEteacher</u></h2>
      <p style="margin-left:20px">PEteacher is £60* + VAT</p>
      <p><i>** Payment for PEteacher can be set up on a direct debit basis (£5 per month) or payment can be made in full up front</i></p>
      <h2><u>PEcoach</u></h2>
      <p style="margin-left:20px">PEcoach is a flexible resource and the costs will reflect the coach or coaching organisations requirements. Quotations are available upon request – <b>call Matthew on 01535 649 403</b></p>
      <p><i>** For PEschool and PEcoach subscriptions an invoice will be raised when all user accounts have been set up and payment is due 21days after the invoice date</i></p>
    </div>
     <?php include("footer.php")?>
    </body>
</html>