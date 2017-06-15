<?php
/**
* CURL Connection
*
* A class to use CURL to connect to Destination.
*/
class CurlConnect {

	private $response_status = '';
	private $response = '';

	public function curlCall($url, $data = '', $action = 'GET', $header = array("Connection: close")) {

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $action);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

			if ($action == 'POST')
			{
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			}

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

			$this->response = curl_exec($ch);
			$this->response_status = strval(curl_getinfo($ch, CURLINFO_HTTP_CODE));

			if ($this->response === false || $this->response_status == '0') {
					$errno = curl_errno($ch);
					$errstr = curl_error($ch);
					echo("cURL $action error in update: [$errno] $errstr");
			}

			curl_close($ch);

	}


/**
* Get Response
*
* Returns the entire response from Destination as a string including all the
* HTTP headers.
*
* @return string
*/
    public function getResponse() {
	    return $this->response;
    }


/**
* Get Response Status
*
* Returns the HTTP response status code from Destination. This should be "200"
* if the post back was successful.
*
* @return string
*/
    public function getResponseStatus() {
	    return $this->response_status;
    }


} // End of class CurlConnect

?>