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
	Framework\Logic\OperatorInterface,
	Framework\Logic\DataProviderInterface,
	Framework\Logic\Exception\UndefinedVariable
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
	 * The global variable provider
	 *
	 * @static
	 * @var \Framework\Logic\DataProviderInterface
	 */
	protected static $variable_data_provider = null;
	
	/**
	 * The local variable provider
	 *
	 * @static
	 * @var \Framework\Logic\DataProviderInterface
	 */
	protected $local_variable_data_provider = null;
	
	/**
	 * Make a new statement consisting of a operator and a left and right expression
	 *
	 * @param OperatorInterface $operator An operator
	 * @param ExpressionInterface $left The left side expression
	 * @param ExpressionInterface $right The right side expression
	 * @param DataProviderInterface $data_provider The data provider for the statement
	 */
	public function __construct(
		OperatorInterface $operator,
		$left,
		$right = null,
		DataProviderInterface $variable_data_provider = null
	) {
		$this->operator = $operator;
		$this->left = $left;
		$this->right = $right;
		$this->local_variable_data_provider = $variable_data_provider;
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
	 * @param DataProviderInterface $variable_data_provider (Optional) The data provider for the statement
	 * @return mixed The result of the evaluation
	 */
	public function evaluate(DataProviderInterface $variable_data_provider = null) {
		
		// merge the statement local variables into the varaibles passed down
		if (is_null($variable_data_provider)) {
			$variable_data_provider = $this->local_variable_data_provider;
		} else if (!is_null($this->local_variable_data_provider)){
			$variable_data_provider->merge($this->local_variable_data_provider);
		}
		
		// handle variables
		if ($this->left instanceof VariableInterface) {
			if (isset($variable_data_provider[$this->left->getName()])) {
				$data = $variable_data_provider[$this->left->getName()];
			} else if (isset(self::$variable_data_provider[$this->left->getName()])) {
				$data = self::$variable_data_provider[$this->left->getName()];
			} else {
				throw new UndefinedVariable('The variable, ' . $this->left->getName() . ', is undefined.');
			}
			$left = $this->left->evaluate($data)->evaluate($variable_data_provider);
		} else {
			$left = $this->left->evaluate($variable_data_provider);
		}
		if ($this->right instanceof VariableInterface) {
			if (isset($variable_data_provider[$this->right->getName()])) {
				$data = $variable_data_provider[$this->right->getName()];
			} else if (isset(self::$variable_data_provider[$this->right->getName()])) {
				$data = self::$variable_data_provider[$this->right->getName()];
			} else {
				throw new UndefinedVariable('The variable, ' . $this->right->getName() . ', is undefined.');
			}
			$right = $this->right->evaluate($data)->evaluate($variable_data_provider);
		} else if (!is_null($this->right)) {
			$right = $this->right->evaluate($variable_data_provider);
		} else {
			$right = null;
		}
		
		return $this->operator->execute($left, $right);
	}
	
	/**
	 * Set the global variable provider
	 *
	 * @param DataProviderInterface $variable_data_provider
	 */
	public static function setGlobalVariableProvider(DataProviderInterface $variable_data_provider) {
		self::$variable_data_provider = $variable_data_provider;
	}
}
