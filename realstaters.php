<?php 
/**
 *  Copyright 2011 Realstaters
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this work except in compliance with the License.
 * You may obtain a copy of the License in the LICENSE file, or at:
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
if (! function_exists ( 'curl_init' ) || ! function_exists ( 'json_decode' )) {
	throw new Exception ( 'Realstaters API needs the CURL PHP extension and JSON PHP extension.' );
}
/**
 * Class Realstaters
 * Wraps HTTP calls 
 * @author Christian David Ibarguen R <christiandavid@realstaters.com>
 */
class RealstatersApiException extends Exception {
	/**
	 * API Error
	 */
	protected $error;
	
	/**
	 * Make a new API Exception
	 * @param Array $error the error from the API
	 */
	public function __construct($error) {
		$this->error = $error;
		$code = (is_array ( $error ) && isset ( $error ['code'] )) ? $error ['code'] : 0;
		if (isset ( $error ['msg'] )) {
			$msg = $error ['msg'];
		} else {
			$msg = 'Unknown Error. Check getError()';
		}
		parent::__construct ( $msg, $code );
	}
	
	/**
	 * Return the associated error object returned by the API server.
	 * @returns Array the error from the API server
	 */
	public function getError() {
		return $this->error;
	}
	
	/**
	 * Returns the type for the error
	 * @return String
	 */
	public function getType() {
		if (is_array ( $this->error ) && isset ( $this->error ['error'] )) {
			$error = $this->error ['error'];
			if (is_string ( $error )) {
				return $error;
			} else if (is_array ( $error )) {
				if (isset ( $error ['type'] )) {
					return $error ['type'];
				}
			}
		}
		return 'Exception';
	}
	
	/**
	 * To make debugging easier.
	 * @returns String the string representation of the error
	 */
	public function __toString() {
		$type = $this->getType () . ': ';
		if ($this->code != 0) {
			$type .= $this->code . ': ';
		}
		return $type . $this->error;
	}
}

class Realstaters {
	/**
	 * Version.
	 */
	const VERSION = '1.1';
	
	/**
	 * The Realstaters API domain.
	 */
	protected $url = 'http://api.realstaters.com/v1/';
	
	/**
	 * Indicates the API Key
	 */
	protected $apiKey;

	/**
	 * Indicates if a test
	 */
	public $test;
	
	/**
	 * Indicates the method to send data.
	 */
	protected $method;
	
	/**
	 * List of data parameters
	 */
	protected $params;
	
	/**
	 * The response from realstaters.
	 */
	protected $responseData;
	
	/**
	 * Constructor, sets logis options
	 * @param String $api
	 * @param String $method GET, POST, PUT, DELETE
	 */
	public function __construct($api = false, $method = 'GET') {
		$this->params = $this->apiKey = $api;
		$this->method = $method;
		$this->responseData = null;
		$this->test = null;
	}
	
	/**
	 * Sets the parameters
	 * @param Array $params
	 */
	public function setData($params) {
		try {
			if (! is_array ( $params )) {
				throw new RealstatersApiException ( 'Invalid params input.  Array expected' );
			}
			$this->params = array_merge ( ( array ) $this->params, ( array ) $params );
		} catch ( RealstatersApiException $e ) {
			throw $e;
		}
	}
	
	/**
	 * Return the parameters to send the server.
	 * @returns Array the parameters to send
	 */
	public function getData() {
		return $this->params;
	}
	
	/**
	 * Sets the method
	 * @param String $method GET, POST, PUT, DELETE
	 */
	public function setMethod($method) {
		$this->method = $method;
	}
	
	/**
	 * Check the apiKey and clean data
	 */
	public function checkApi() {
		if( !isset ( $this->params ['apiKey'] )){
			$this->responseData = null;
			$this->setData($this->apiKey);
		}
		if( $this->test ){
			$this->setData($this->test);
		}
	}
	
	/**
	 * Makes an HTTP request to the server
	 * @throws RealstatersApiException
	 * @return Boolean
	 */
	public function makeRequest() {
		$this->checkApi();
		$return = false;
		if ($this->buildParams ()) {
			$ch = curl_init ();
			try {
				switch (strtoupper ( $this->method )) {
					case 'GET' :
						$return = $this->makeRequestGet ( $ch );
						break;
					case 'POST' :
						$return = $this->makeRequestPost ( $ch );
						break;
					case 'PUT' :
						$return = $this->makeRequestPut ( $ch );
						break;
					case 'DELETE' :
						$return = $this->makeRequestDelete ( $ch );
						break;
					default :
						throw new RealstatersApiException ( 'Current method (' . $this->method . ') is an invalid REST Method.' );
				}
			} catch ( RealstatersApiException $e ) {
				curl_close ( $ch );
				throw $e;
			}
		}
		return $return;
	}
	/**
	 * Build the parameters to HTTP request
	 * @param String $params the data to make the request to
	 * @return Boolean
	 */
	protected function buildParams() {
		if (is_array ( $this->params ) && isset ( $this->params ['apiKey'] )) {
			$this->params = http_build_query ( $this->params, null, '&' );
			return true;
		} else {
			self::errorLog ( 'There is not an API key' );
			return false;
		}
	}
	
	/**
	 * Default options for curl.
	 * @param CurlHandler $ch
	 */
	protected function setCurlOpts(&$ch) {
		curl_setopt ( $ch, CURLOPT_URL, $this->url );
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, array ('Accept: application/json' ) );
		curl_setopt ( $ch, CURLOPT_ENCODING, 'UTF-8' );
		curl_setopt ( $ch, CURLOPT_USERAGENT, 'realstaters-' . self::VERSION );
	}
	
	/**
	 * Makes an HTTP request
	 * @param CurlHandler $ch
	 * @return Boolean
	 */
	protected function makeRequestGet($ch) {
		return $this->execute ( $ch );
	}
	
	/**
	 * Makes an HTTP request using POST Method
	 * @param CurlHandler $ch
	 * @return Boolean
	 */
	protected function makeRequestPost($ch) {
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $this->params );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		return $this->execute ( $ch );
	}
	
	/**
	 * Makes an HTTP request using PUT Method
	 * @param CurlHandler $ch
	 * @return Boolean
	 */
	protected function makeRequestPut($ch) {
		$fileData = tmpfile ();
		fwrite ( $fileData, $this->params );
		fseek ( $fileData, 0 );
		curl_setopt ( $ch, CURLOPT_PUT, true );
		curl_setopt ( $ch, CURLOPT_INFILE, $fileData );
		curl_setopt ( $ch, CURLOPT_INFILESIZE, strlen ( $this->params ) );
		
		$return = $this->execute ( $ch );
		fclose ( $fileData );
		return $return;
	}
	
	/**
	 * Makes an HTTP request using DELETE Method
	 * @param CurlHandler $ch
	 * @return Boolean
	 */
	protected function makeRequestDelete($ch) {
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $this->params );
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'DELETE' );
		return $this->execute ( $ch );
	}
	
	/**
	 * Execute the call to the webservice
	 * @param CurlHandler $ch
	 * @return Boolean
	 */
	protected function execute(&$ch) {
		$this->setCurlOpts ( $ch );
		$this->responseData = curl_exec ( $ch );
		$this->params = null;
		if ($this->responseData === false) {
			$e = new RealstatersApiException(array(
		        'code' => curl_errno($ch),
		        'error'      => array(
		          'message' => curl_error($ch),
		          'type'    => 'CurlException',
		        ),
		    ));
			curl_close ( $ch );
			throw $e;
			return false;
		} else {
			curl_close ( $ch );
			return true;
		}
	}
	
	/**
	 * Return the associated object returned by the API server.
	 * @returns json the data
	 */
	public function getResponseData() {
		return json_decode ( $this->responseData );
	}
	
	/**
	 * Prints to the error log if you aren't in command line mode.
	 * @param String log message
	 */
	protected static function errorLog($msg) {
		// if you are not running in a CLI environment
		if (php_sapi_name () != 'cli') {
			error_log ( $msg );
		}
	}
}
?>