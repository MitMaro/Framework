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
	 * Add a variable
	 *
	 * @param scalar $name The name
	 * @param mixed $value The value
	 */
	public function addVariable($name, $value) {
		$this->data[$name] = $value;
	}
	
}
