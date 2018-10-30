<?php
/**
* Primo retrun URL to return users back to their Primo account pages.
* Replace [] with your campus data.
*/
$primo_return = 'https://[YOUR PRIMO SITE]/primo-explore/account?vid=[YOUR PRIMO CAMPUS VID]&sortby=rank&lang=en_US&section=overview';

/**
* Paypal buy now button html query string.
* Replace [] with your buy now button html query string.
*/
$ppvars = "[This is buy now paypal button html query string]";
$ppvars .= "&return=https://[Your Apache/PHP server]/[path to script]/pdt.php";

/**
* Paypal Identity token for Payment Data Transfer.
* Replace [] with your Paypal Payment Data Transfer Identity token.
*/
$auth_token = "[YOUR PAYPAL Payment Data Transfer Identity token]";


?>
