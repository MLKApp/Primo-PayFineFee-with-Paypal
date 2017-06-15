<?php
/**
* Update user account with Alma API
*
* A class to handle discover/update user account fines/fees with Alma API.
*/
require_once "curlConnect.php";

class AlmaUpdate extends CurlConnect{

	private $alma_api = 'https://api-na.hosted.exlibrisgroup.com/almaws/v1/';
	private $apikey  = '[YOUR ALMA APIKEY]';

	private $request = '';
	private $uri = '';
	private $data = '';

/**
* Update Fines/Fees
*
* Returns update response from Alma API in XML format.
*
* @return string
*/
	public function updateFine($uid, $amount='ALL') {
			$alma_api_cat = $this->alma_api."users/$uid/fees/all";
			$this->uri = $alma_api_cat;
			$this->data = json_encode(array("user_id_type" => "all_unique", "op" => "pay", "amount" => "ALL", "method" => "ONLINE", "comment" => "", "external_transaction_id" => ""));
			$queryParams = '?' . urlencode('user_id_type') . '=' . urlencode('all_unique') . '&' . urlencode('op') . '=' . urlencode('pay') . '&' . urlencode('amount') . '=' . urlencode($amount) . '&' . urlencode('method') . '=' . urlencode('ONLINE');
			$this->request = $queryParams .'&' . urlencode('apikey') . '=' . urlencode($this->apikey);
			//echo $this->uri.$this->request."<br/>";
			//echo $this->data."<br/>";
			$this->curlCall($this->uri.$this->request, '', 'POST',array('Content-Type: application/json'));
			return $this->getResponse();
    }

/**
* Get Fines/Fees
*
* Returns Fines/fees response from Alma API in XML format.
*
* @return string
*/
	public function getFine($uid) {
			$alma_api_cat = $this->alma_api."users/$uid/fees";
			$this->uri = $alma_api_cat;
			$this->request = '?' . urlencode('user_id_type') . '=' . urlencode('all_unique') . '&' . urlencode('status') . '=' . urlencode('ACTIVE') . '&' . urlencode('apikey') . '=' . urlencode($this->apikey);
			//echo $this->uri.$this->request."<br/>";
			$this->curlCall($this->uri.$this->request);
			return $this->getResponse();
	}


} // End of class AlmaUpdate


?>
