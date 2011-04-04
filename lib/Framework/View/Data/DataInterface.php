<?php
/**
 * @package  Framework\View\Data
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\View\Data;

interface DataInterface extends \ArrayAccess {
	
	/**
	 * Magic method to get a variable value from the data object
	 * 
	 * @param sting $name The name of the property you are tring to get
	 */
	public function __get($name);
	
	/**
	 * Magic method to set a value on a variable
	 *
	 * @param sting $name The name of the variable
	 * @param mixed $value The value to set to the variable
	 */
	public function __set($name, $value);
	
	/**
	 * @return array The data as an array
	 */
	public function toArray();
}
