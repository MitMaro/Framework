<?php
/**
 * @package  Framework\AccessControl
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Auth;

class Auth {
	
	protected $adapter;
	protected $storage;
	
	public function __construct(Adapter\AdapterInterface $adapter, Storage\StorageInterface $storage = null) {
		
		$this->adapter = $adapter;
		
		if (is_null($storage)) {
			$this->storage = new Storage\Session('identity');
		} else {
			$this->storage = $storage;
		}
		
	}
	
	public function authenticate() {
		
		$result = $this->adapter->authenticate();
	
		if ($result->isAuthenticated()) {
			$this->storage->write($result->getIdentity());
		}
	
		return $result;
	}
	
	/**
	* Returns the identity from storage or null if not available
	*
	* @return mixed|null
	*/
	public function getIdentity() {
		
		if ($this->storage->isEmpty()) {
			return null;
		}
		
		return $this->storage->read();
	}
}
