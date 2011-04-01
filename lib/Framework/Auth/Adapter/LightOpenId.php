<?php
/**
 * Provides a interface to the LightOpenId library that impliments the AdapterInterface
 *
 * @package  Framework\Auth\Adapter
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 * @depends <a href="http://code.google.com/p/lightopenid/">LightOpenId Library</a>
 */

namespace Framework\Auth\Adapter;

use
	Framework\Auth\Result
;

class LightOpenId extends \LightOpenId implements AdapterInterface {
	
	// Attribute Exchange keys
	
	/**
	 * @static
	 * @final
	 * @var AX Username flag
	 */
	const AX_USERNAME = 'namePerson/friendly';
	
	/**
	 * @static
	 * @final
	 * @var AX Email flag
	 */
	const AX_EMAIL = 'contact/email';
	
	/**
	 * @static
	 * @final
	 * @var AX Full Name flag
	 */
	const AX_FULL_NAME = 'namePerson';
	
	/**
	 * @static
	 * @final
	 * @var AX Birthdate flag
	 */
	const AX_BIRTH_DATE = 'birthDate';
	
	/**
	 * @static
	 * @final
	 * @var AX Gender flag
	 */
	const AX_GENDER = 'person/gender';
	
	/**
	 * @static
	 * @final
	 * @var AX Postal/Zip flag
	 */
	const AX_POSTAL_CODE = 'contact/postalCode/home';
	
	/**
	 * @static
	 * @final
	 * @var AX Postal/Zip flag
	 */
	const AX_ZIP_CODE = 'contact/postalCode/home'; // duplidate of AX_POSTAL_CODE
	
	/**
	 * @static
	 * @final
	 * @var AX Country flag
	 */
	const AX_COUNTRY = 'contact/country/home';
	
	/**
	 * @static
	 * @final
	 * @var AX Language flag
	 */
	const AX_LANGUAGE = 'pref/language';
	
	/**
	 * @static
	 * @final
	 * @var AX TimeZone flag
	 */
	const AX_TIMEZONE = 'pref/timezone';
	
	/**
	 * Construct the Adapter
	 *
	 * @param array $data (Optional, Default: _GET + _POST) The data to work on
	 * @param string $trustRoot (Optional, Default: HTTP_HOST) The trusted root
	 * @param string $returnUrl (Optional, Default: Current URI) The url to redirect back to
	 *
	 * @throws ErrorException if curl_init or https stream doesn't exist
	 */
	public function __construct($data = null, $trust_root = null, $return_url = null) {
		// this constructor completely overrides the LightOpenId constructor to remove
		// the dependency on _GET, _POST and _SERVER
		
		if (is_null($trust_root)) {
			$this->trustRoot = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
		} else {
			$this->trustRoot = $trust_root;
		}
		
		if (is_null($return_url)) {
			$uri = rtrim(preg_replace('#((?<=\?)|&)openid\.[^&]+#', '', $_SERVER['REQUEST_URI']), '?');
			$this->returnUrl = $this->trustRoot . $uri;
		} else {
			$this->returnUrl = $return_url;
		}
		
		// if not data was provided, use the GET and POST super global
		if (is_null($data)) {
			$this->data = $_POST + $_GET;
		} else {
			$this->data = $data;
		}
	
	}
	
	/**
	 * Performs an authentication attempt
	 *
	 * @param Framework\Auth\Result $result (Optional) Override the result class that is returned
	 *
	 * @return Framework\Auth\Result
	 */
	public function authenticate(Result $result = null) {
		
		// create a default result object if none given
		if (is_null($result)) {
			$result = new Result();
		}
		
		if ($this->validate()) {
			$result->setAuthenticated(true);
			$result->setIdentity($this->identity + $this->getAttributes());
		}
		
		return $result;
	}
	
	/**
	 * Get the raw data (ie. POST and GET data)
	 *
	 * @return array The raw data
	 */
	public function getRawData() {
		return $this->data;
	}
	
	/**
	 * Get the trust root
	 *
	 * @return string The trust root
	 */
	public function getTrustRoot() {
		return $this->trustRoot;
	}
	
	/**
	 * Get the return url
	 *
	 * @return string The return url
	 */
	public function getReturnUrl() {
		return $this->returnUrl;
	}
}
