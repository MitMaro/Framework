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

class Identical implements OperatorInterface {

	/**
	 * Execute the operator on the expressions
	 *
	 * @param ExpressionInterface $left The left hand of the operation
	 * @param ExpressionInterface $right The right hand of the operation
	 * 
	 * @return boolean The value of the operation
	 */
	public function execute(ExpressionInterface $left, ExpressionInterface $right = null) {
		return $left->evaluate() === $right->evaluate();
	}
}
