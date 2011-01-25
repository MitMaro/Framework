<?php
/**
 * @package  Framework\Logic
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Logic;

interface VariableInterface {
	
	/**
	 * The evaluation of a type is it's value
	 *
	 * @param mixed $value The value
	 * @return \Framework\Logic\TypeInterface A value of the variables type given the value
	 */
	public function evaluate($value);
	
	/**
	 * Contruct a variable with a type class name and the variable name
	 *
	 * @param string $type The type class name
	 * @param stirng $name The variable name
	 */
	public function __construct($type, $name);
	
	/**
	 * Get the name of the variable
	 *
	 * @return scalar The name of the variable
	 */
	public function getName();
	
}
