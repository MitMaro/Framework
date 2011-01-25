<?php
/**
 * @package  Framework\Logic\Operator
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Logic\Operator;

use
	Framework\Logic\OperatorInterface,
	Framework\Logic\ExpressionInterface
;

class LessThan implements OperatorInterface {

	/**
	 * Execute the operator on the expressions
	 *
	 * @param mixed $left The left hand of the operation
	 * @param mixed $right The right hand of the operation
	 * 
	 * @return boolean The value of the operation
	 */
	public function execute($left, $right = null) {
		return $left < $right;
	}
}
