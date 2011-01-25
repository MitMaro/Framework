<?php
/**
 * @package  Framework\Logic
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http:/ /www.opensource.org/licenses/mit-license.php">The MIT License</a>
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
	 * Make a new statement consisting of a operator and a left and right expression
	 *
	 * @param OperatorInterface $operator An operator
	 * @param ExpressionInterface $left The left side expression
	 * @param ExpressionInterface $right The right side expression
	 * @param DataProviderInterface $data_provider The data provider for the statement
	 */
	public function __construct(OperatorInterface $operator, $left, $right = null) {
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
	 * @param DataProviderInterface $variable_providver (Optional) The data provider for the statement
	 * @return mixed The result of the evaluation
	 */
	public function evaluate($variable_providver = null) {
		
		// handle variables
		if ($this->left instanceof VariableInterface) {
			$data = $variable_providver->getVariable($this->left->getName());
			$left = $this->left->evaluate($data)->evaluate($variable_providver);
		} else {
			$left = $this->left->evaluate($variable_providver);
		}
		if ($this->right instanceof VariableInterface) {
			$data = $variable_providver->getVariable($this->right->getName());
			$right = $this->right->evaluate($data)->evaluate($variable_providver);
		} else if (!is_null($this->right)) {
			$right = $this->right->evaluate($variable_providver);;
		} else {
			$right = null;
		}
		
		return $this->operator->execute($left, $right);
	}
}
