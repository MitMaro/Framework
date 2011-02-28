<?php
/**
 * @package  Framework\Logic\Type
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Logic\Type;

use
	Framework\Logic\TypeInterface,
	Framework\Logic\ExpressionInterface,
	Framework\Logic\DataProviderInterface
;

abstract class Base implements TypeInterface {
	
	/**
	 * The interal value of this type
	 *
	 * @var mixed
	 */
	protected $value;
	
	/**
	 * Get the php value of the object
	 */
	public function getValue() {
		return $this->value;
	}
	
	/**
	 * The evaluation of a type is it's value
	 * @param DataProviderInterface $variable_providver (Optional) The data provider for the statement
	 */
	public function evaluate(DataProviderInterface $variable_data_provider = null) {
		return $this->getValue();
	}
	
	abstract public function __construct($value);
	
}
