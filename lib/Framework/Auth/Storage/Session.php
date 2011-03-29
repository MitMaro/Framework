<?php
/**
 * @package  Framework\Auth\Storage
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Auth\Storage;

class Session implements StorageInterface {
	
	/**
	 * @static
	 * @final
	 * @var const The default namespace to use in the session
	 */
	const DEFAULT_SESSION_NAMESPACE = '__FRAMEWORK_AUTH_STORAGE__';
	
	/**
	 * @var scalar The namespace to use in the session
	 */
	protected $namespace;
	
	/**
	 * @var scalar The name of the variable to use in the session
	 */
	protected $name;
	
	/**
	 * @param scalar $name The name of the storage
	 * @param scalar $namespace (Optional) The session namespace to use
	 */
	public function __construct($name, $namespace = self::DEFAULT_SESSION_NAMESPACE) {
		$this->name = $name;
		$this->namespace = $namespace;
	}
	
	/**
	 * Returns the contents of storage
	 *
	 * @return mixed The contents of the storage or null
	 */
	public function read() {
		return \Framework\Session\Session::get($this->name, null, $this->namespace);
	}

	/**
	 * Writes some data to the storage
	 *
	 * @param mixed $data
	 */
	public function write($data) {
		\Framework\Session\Session::set($this->name, $data, $this->namespace);
	}

	/**
	 * Clears data from the storage
	 */
	public function clear() {
		\Framework\Session\Session::set($this->name, null, $this->namespace);
	}
	
	/**
	 * Returns true if the storage is empty
	 *
	 * @return boolean
	 */
	public function isEmpty() {
		return count(\Framework\Session\Session::get($this->name, null, $this->namespace)) === 0;
	}
}
