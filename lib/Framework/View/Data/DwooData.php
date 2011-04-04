<?php
/**
 * @package  Framework\View\Data
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\View\Data;

class DwooData extends \Dwoo_Data implements DataInterface {
	
	// ## Start ArrayAccess Implementation
	
	/**
	 * Returns true if there is a value for the given variable name
	 * 
	 * @param string $name The name of the variable
	 * @return boolean True is the value exists, false if not
	 */
	public function offsetExists($offset)
	{
		return isset($this->data[$offset]);
	}
	
	/**
	 * Returns a value of a variable
	 * 
	 * @param string $name The name of the variable
	 * 
	 * @return mized Returns the value of the property requested
	 */
	public function offsetGet($offset)
	{
		return $this->__get($offset);
	}
	
	/**
	 * Unset a variable
	 *
	 * @param string $offset The name of a variable
	 */
	public function offsetUnset($offset) {
		unset($this->data[$offset]);
	}
	
	/**
	 * The set a value on a variable
	 *
	 * @param sting $name The name of the variable
	 * @param mixed $value The value to set to the variable
	 */
	public function offsetSet($offset, $value) {
		$this->__set($offset, $value);
	}
	
	// ## End ArrayAccess Implementation
	
	/**
	 * @return array The data as an array
	 */
	public function toArray() {
		return $this->getData();
	}
}
