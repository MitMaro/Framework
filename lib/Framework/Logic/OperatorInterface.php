<?php
/**
 * @package  Framework\Logic
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Logic;

use
	Framework\Logic\ExpressionInterface,
	Framework\Logic\OperatorInterface
;

interface OperatorInterface {
	
	/**
	 * Execute the operator on the expressions
	 *
	 * @param ExpressionInterface $left The left hand of the operation
	 * @param ExpressionInterface $right (Optional) The right hand of the operation, optional for
	 *                                   operations that do not need a right side of the operation.
	 * 
	 * @return boolean The value of the operation
	 */
	public function execute(ExpressionInterface $left, ExpressionInterface $right = null);
	
}
