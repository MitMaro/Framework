<?php
/**
 * @package  Framework\Logic\DataProvider
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http:/ /www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Logic\DataProvider;

class Hashmap implements \Framework\Logic\DataProviderInterface {
	
	/**
	 * The data array
	 *
	 * @var array
	 */
	protected $data = array();
	
	/**
	 * Get the variable by name
	 *
	 * @param scalar $name The name of the variable
	 * @return mixed The value
	 */
	public function getVariable($name) {
		if (isset($this->data[$name])) {
			return $this->data[$name];
		}
		return null;
	}
	
	/**
	 * Get the variables
	 *
	 * @return mixed All the varaibles
	 */
	public function getVariables() {
		return $this->data;
	}
	
	/**
	 * Add a variable
	 *
	 * @param scalar $name The name
	 * @param mixed $value The value
	 */
	public function addVariable($name, $value) {
		$this->data[$name] = $value;
	}
	
	/**
	 * Merge another variable provider into this one, overwritting existing values
	 *
	 * @param scalar $name The name
	 * @param mixed $value The value
	 */
	public function merge(self $variable_provider) {
		foreach($variable_provider->getVariables() as $name => $value) {
			$this->addVariable($name, $value);
		}
	}
	
	/**
	 * Returns true is the variable exists
	 * 
	 * @param string $name The name
	 * @return boolean True is the property exists, false if not
	 */
	public function offsetExists($name)
	{
		return isset($this->data[$name]);
	}
	
	/**
	 * Get a variable
	 * 
	 * @param string $name The name of the property
	 * @return mixed Returns the value of the property requested
	 */
	public function offsetGet($name)
	{
		return $this->getVariable($name);
	}
	
	/**
	 * Unset the variable
	 *
	 * @param scalar $name The name
	 */
	public function offsetUnset($name) {
		unset($this->data[$name]);
	}
	
	/**
	 * Add a variable
	 *
	 * @param scalar $name The name
	 * @param mixed $value The value
	 */
	public function offsetSet($name, $value) {
		$this->addVariable($name, $value);
	}
	
}
