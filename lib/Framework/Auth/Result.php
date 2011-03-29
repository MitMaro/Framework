<?php
/**
 * @package  Framework\Auth
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Auth;

class Result  {
	
	/**
	 * @var string A message for a failure
	 */
	protected $message = false;
	
	/**
	 * @var mixed The identity of the authentication
	 */
	protected $identity = null;
	
	/**
	 * @var boolean If authenticated or not
	 */
	protected $authenticated = false;
	
	/**
	 * Set the message
	 *
	 * @param string $message The message
	 */
	public function setMessage($message) {
		$this->message = $message;
	}
	
	/**
	 * Get the message
	 *
	 * @return string The message or a default message if no identity is provided
	 */
	public function getMessage() {
		
		// if there is a message
		if ($this->message !== false) {
			return $this->message;
		}
		
		// no identity provide a default message
		if (is_null($this->identity)) {
			return 'Identity has not been set';
		}
		
	}
	
	/**
	 * Set the identity
	 *
	 * @param mixed $identity The identity
	 */
	public function setIdentity($identity) {
		$this->identity = $identity;
	}
	
	/**
	 * Get the identity
	 *
	 * @return mixed The identity
	 */
	public function getIdentity() {
		return $this->identity;
	}
	
	/**
	 * Set if the authentication was successful or not
	 *
	 * $param boolean $value (Optional, Default: true) The authentication value
	 */
	public function setAuthenticated($value = true) {
		$this->authenticated = $value;
	}
	
	/**
	 * Was the authentication successful or not
	 *
	 * @return boolean True is authentication was successful, false otherwise
	 */
	public function isAuthenticated() {
		return (bool)$this->authenticated;
	}
	
}
