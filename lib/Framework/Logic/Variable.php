<?php
/**
 * @package  Framework\Logic
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Logic;

class Variable implements VariableInterface {
	
	/**
	 * The type of this variable
	 *
	 * @var mixed
	 */
	protected $type;
	
	/**
	 * The name of the variable
	 *
	 * @var mixed
	 */
	protected $name;
	
	/**
	 * Contruct a variable with a type class name and the variable name
	 *
	 * @param string $type The type class name
	 * @param scalar $name The variable name
	 */
	public function __construct($type, $name) {
		$this->type = $type;
		$this->name = $name;
	}
	
	/**
	 * The evaluation of a type is it's value
	 *
	 * @param mixed $value The value to pass to the type object
	 * @return \Framework\Logic\TypeInterface A value of the variables type given the value
	 */
	public function evaluate($value) {
		return new $this->type($value);
	}
	
	/**
	 * Get the name of the variable
	 *
	 * @return scalar The name of the variable
	 */
	public function getName() {
		return $this->name;
	}
}
