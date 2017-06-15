<?php
/**
* Handle Paypal payment notification and update users Alma accounts.
* Called back by Paypal after finishing payment.
* Reference: https://github.com/paypal/pdt-code-samples/blob/master/paypal_pdt.php
*/
require_once "configure.php";
require_once "pdtlistener.php";
require_once "almaUpdate.php";


$refresh = 6;
$message = "";

/**
* Call Paypal with first-time returned token and get transaction detail.
*/
if (isset($_GET['tx']) && !empty($_GET['tx'])) {
	$tx = $_GET['tx'];
	$req = 'cmd=_notify-synch';
	$req .= "&tx=$tx&at=$auth_token";

	$listener = new PdtListener();
	$res = $listener->getResult($req);


	if(!$res){
	    //HTTP ERROR
	        $message = 'Please contact librarians for assistance.';
	}else{
	    // Process Paypal's transaction detail, get user Primo ID.
	    $lines = explode("\n", trim($res));
	    $keyarray = array();
	    if (strcmp ($lines[0], "SUCCESS") == 0) {
	        for ($i = 1; $i < count($lines); $i++) {
	            $temp = explode("=", $lines[$i],2);
	            $keyarray[urldecode($temp[0])] = urldecode($temp[1]);
	        }
	    // process payment
	    $amount = $keyarray['payment_gross'];
	    $custom = $keyarray['custom'];
	    $uid = '';

	    if (isset($custom) && !empty($custom))
	    {	//get patrons ID from custom field, slice up the prefix XXXX
	    	$uidarray = explode("XXXX", $custom);
			$uid = $uidarray[1];
	    }

		//Update users Alma account balance.
	    $alma = new AlmaUpdate();
		$response = $alma->updateFine($uid);
		$result = simplexml_load_string($response);
		//print_r($result);

		if (isset($result['total_sum']))
		{	$fees = trim($result['total_sum']);

			if ($fees == 0)
			{   $message = "Thank you for your payment. Your transaction has been completed, and a receipt for your payment has been emailed to you. You will be redirected back to OneSearch.\n";

			} else
			{   $message = "Your balance is $".$fee.". You will be redirected to OneSearch.\n";

			}

		} else {
			if (isset($result->errorsExist) && $result->errorsExist)
			{
				$err = (string) $result->errorList->error->errorCode;
				$errorMessage = (string) $result->errorList->error->errorMessage;
				switch ($err) {
					case '401861' :
					$message = "$errorMessage Please try again.\n";
					break;
					default:
					$message = "Sorry, something is wrong. Please contact our librarians for update errors.\n";
				}
			} else {
				$message = "Sorry, please contact our librarians for update assistance.\n";

			}
		}

	  } else if (strcmp ($lines[0], "FAIL") == 0) {
	        $message = "Paypal process failed!";

	  }
	} // end of PDT process

} else {
	 $message = "Paypal process doesn't respond with token!\n";

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>SJSU OneSearch King Library Pay Fine Message.</title>
	<style>
	body {
		font-family: Source Sans Pro,Helvetica Neue,Helvetica,Arial,sans-serif;
    	font-size: 15px;
    }

    #content {
		padding-left: 15%;
		padding-top: 15%;
    }

    #message {
		font-size: 18px;
    }
	</style>
</head>
<body>
<div id="banner">
	<img class="logo-image" src="https://sjsu-primo.hosted.exlibrisgroup.com/primo-explore/custom/01CALS_SJO/img/library-logo.png" alt="The library Logo">
</div>

<div id='content'>
<div id='message'>
<?php
	echo $message;
?>
</div>
</div>
</body>
</html>

<?php

/**
* Redirect user back to Primo site.
*/
//echo ("redirect to Primo site.\n");
header("Refresh: $refresh; url=$primo_return");


?>
