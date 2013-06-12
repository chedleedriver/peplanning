<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>

<body>
<div class="whitetitle">
		<form method=POST action='https://secure.nochex.com/'>
			<input type=hidden name ='merchant_id' value='peplanning'>
			<input type=hidden name ='amount' value='60.00'>
			<input type=hidden name ='description' value='PEteacher Subscription'>
			<input type=hidden name ='order_id' value='<? echo $order_id?>'>
			<input type=hidden name ='billing_address' value='<? echo $billing_address?>' />
			<input type=hidden name ='billing_postcode' value='<? echo $billing_postcode?>'>
			<input type=hidden name ='customer_phone_number' value='<? echo $tel?>'>
			<input type=hidden name ='email_address' value='<? echo $email?>' />
			<input type=submit class="bigredtitle" value='Click here to pay On-line' />
		</form>
		</div></body>
</html>
