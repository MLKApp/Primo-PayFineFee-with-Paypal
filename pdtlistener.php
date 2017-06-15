<?php
/**
* PayPal PDT Listener
*
* A class to listen for and handle Payment Data Transfer (PDT) from
* the PayPal server.
*/
require_once "curlConnect.php";

class PdtListener extends CurlConnect{

    private $paypal_url = 'https://www.paypal.com/cgi-bin/webscr';
    //private $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';

/**
* Get Result
*
* Returns the entire response from PayPal as a string including all the
* HTTP headers.
*
* @return string
*/
    public function getResult($req) {
    	//echo $this->paypal_url.'-'.$req."<br/>";
    	$this->curlCall($this->paypal_url, $req, 'POST');
	    return $this->getResponse();
    }

} // End of class pdtListener

?>