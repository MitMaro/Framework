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

class Statement implements ExpressionInterface {
	
	/**
	 * The left expression
	 *
	 * @var ExpressionInterface
	 */
	protected $left;
	
	/**
	 * The right expression
	 *
	 * @var ExpressionInterface
	 */
	protected $right;
	
	/**
	 * The operator to perform
	 *
	 * @var OperatorInterface
	 */
	protected $operator;
	
	/**
	 * The cached value of this statement
	 *
	 * @var mixed
	 */
	protected $cachedValue = null;
	
	/**
	 * Make a new statement consisting of a operator and a left and right expression
	 *
	 * @param OperatorInterface $operator An operator
	 * @param ExpressionInterface $left The left side expression
	 * @param ExpressionInterface $right The right side expression
	 */
	public function __construct(OperatorInterface $operator, ExpressionInterface $left, ExpressionInterface $right = null) {
		$this->operator = $operator;
		$this->left = $left;
		$this->right = $right;
	}
	
	/**
	 * Get the left side expression
	 *
	 * @return ExpressionInterface
	 */
	public function getLeftExpression() {
		return $this->left;
	}
	
	/**
	 * Get the right side expression
	 *
	 * @return ExpressionInterface
	 */
	public function getRightExpression() {
		return $this->right;
	}
	
	/**
	 * Get the operator
	 *
	 * @return OperatorInterface
	 */
	public function getOperator() {
		return $this->operator;
	}
	
	/**
	 * Evaluate the statement
	 *
	 * @return mixed The result of the evaluation
	 */
	public function evaluate() {
		// check for a cached value
		if (is_null($this->cachedValue)) {
			$this->cachedValue = $this->operator->execute($this->left, $this->right);
		}
		return $this->cachedValue;
	}
}
