<?php


//
// STEP 1 - be polite and acknowledge PayPal's notification
//

header('HTTP/1.1 200 OK');

//
// STEP 2 - create the response we need to send back to PayPal for them to confirm that it's legit
//

$resp = 'cmd=_notify-validate';
foreach ($_POST as $parm => $var) 
	{
	$var = urlencode(stripslashes($var));
	$resp .= "&$parm=$var";
	}
	
// STEP 3 - Extract the data PayPal IPN has sent us, into local variables 

  $item_name        = $_POST['item_name'];
  $item_number      = $_POST['item_number'];
  $payment_status   = $_POST['payment_status'];
  $payment_amount   = $_POST['mc_gross'];
  $payment_currency = $_POST['mc_currency'];
  $txn_id           = $_POST['txn_id'];
  $receiver_email   = $_POST['receiver_email'];
  $payer_email      = $_POST['payer_email'];
  $record_id	 	= $_POST['custom'];
  $date = date('Y-m-d H:i:s');
  $servername = "localhost";
  $username = "root";
  $password = "gypd0231";
  $dbname = "mydb";
  
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if (!$conn) {
  	die("Connection failed: " . mysqli_connect_error());
  } 
  // Create database
  $sql=("INSERT INTO payments(payment_amount,payment_status,txnid,payer_email,createdtime )
  values(".$payment_amount.",'".$payment_status."','".$txn_id."','".$payer_email."','".$date."')");
  if ($conn->query($sql) === TRUE) {
  	echo "New record created successfully";
  } else {
  	echo "Error: " . $sql . "<br>" . $conn->error;
  }


// STEP 4 - Get the HTTP header into a variable and send back the data we received so that PayPal can confirm it's genuine

$httphead = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$httphead .= "Content-Type: application/x-www-form-urlencoded\r\n";
$httphead .= "Content-Length: " . strlen($resp) . "\r\n\r\n";
 
 // Now create a ="file handle" for writing to a URL to paypal.com on Port 443 (the IPN port)

$errno ='';
$errstr='';
 
$fh = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

// STEP 5 - Nearly done.  Now send the data back to PayPal so it can tell us if the IPN notification was genuine
 
 if (!$fh) {

           } 
		   
// Connection opened, so spit back the response and get PayPal's view whether it was an authentic notification		   
		   
else 	{
           fputs ($fh, $httphead . $resp);
		   while (!feof($fh))
				{
				$readresp = fgets ($fh, 1024);
				if (strcmp ($readresp, "VERIFIED") == 0) 
					{

					}
 
				else if (strcmp ($readresp, "INVALID") == 0) 
					{
 
 
					}
				}
fclose ($fh);
		}
//
//
// STEP 6 - Pour yourself a cold one.
//
//

?>