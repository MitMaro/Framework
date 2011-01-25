<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Statement,
	\Framework\Logic\Variable,
	\Framework\Logic\DataProvider\Hashmap,
	\Framework\Logic\Operator\AndOperator,
	\Framework\Logic\Operator\NotOperator,
	\Framework\Logic\Type\Boolean
;

class LogicStatement_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Statement::__construct
	 * @covers \Framework\Logic\Statement::getRightExpression
	 * @covers \Framework\Logic\Statement::getLeftExpression
	 * @covers \Framework\Logic\Statement::getOperator
	 */
	public function test__construct() {
		
		$operator = new AndOperator();
		$leftExpression = new Boolean(true);
		$rightExpression = new Boolean(false);
		
		$statement = new Statement($operator, $leftExpression, $rightExpression);
		
		$this->assertEquals($operator, $statement->getOperator());
		$this->assertEquals($leftExpression, $statement->getLeftExpression());
		$this->assertEquals($rightExpression, $statement->getRightExpression());
		
	}
	
	/**
	 * @covers \Framework\Logic\Statement::evaluate
	 */
	public function test_SimpleExpressions() {
		
		$operator = new AndOperator();
		$trueExpression = new Boolean(true);
		$falseExpression = new Boolean(false);
		
		$statement = new Statement($operator, $trueExpression, $trueExpression);
		$this->assertTrue($statement->evaluate());
		
		$statement = new Statement($operator, $trueExpression, $falseExpression);
		$this->assertFalse($statement->evaluate());
		
		$statement = new Statement($operator, $falseExpression, $falseExpression);
		$this->assertFalse($statement->evaluate());
		
		$statement = new Statement($operator, $falseExpression, $trueExpression);
		$this->assertFalse($statement->evaluate());
		
	}
	
	/**
	 * @covers \Framework\Logic\Statement::evaluate
	 */
	public function test_NotStatement() {
		
		$operator = new NotOperator();
		$trueExpression = new Boolean(true);
		
		$statement = new Statement($operator, $trueExpression);
		$this->assertFalse($statement->evaluate());
	}
	
	/**
	 * @covers \Framework\Logic\Statement::evaluate
	 */
	public function test_CompoundStatement() {
		
		$operator = new AndOperator();
		$trueExpression = new Boolean(true);
		$falseExpression = new Boolean(false);
		$trueStatement = new Statement($operator, $trueExpression, $trueExpression);
		$falseStatement = new Statement($operator, $falseExpression, $falseExpression);
		$notStatement = new Statement(new NotOperator(), $falseExpression);
		
		$statement = new Statement($operator, $trueStatement, $trueStatement);
		$this->assertTrue($statement->evaluate());
		
		$statement = new Statement($operator, $trueStatement, $falseStatement);
		$this->assertFalse($statement->evaluate());
		
		$statement = new Statement($operator, $falseStatement, $trueStatement);
		$this->assertFalse($statement->evaluate());
		
		$statement = new Statement($operator, $falseStatement, $falseStatement);
		$this->assertFalse($statement->evaluate());
		
		$statement = new Statement($operator, $trueStatement, $notStatement);
		$this->assertTrue($statement->evaluate());
		
	}
	
	/**
	 * @covers \Framework\Logic\Statement::evaluate
	 */
	public function test_VariablesStatement() {
		$statement = new Statement(
			new AndOperator(),
			new Variable('\Framework\Logic\Type\Boolean', 'abc'),
			new Variable('\Framework\Logic\Type\Boolean', 'def')
		);
		
		$data = new Hashmap();
		$data->addVariable('abc', true);
		$data->addVariable('def', true);
		$this->assertTrue($statement->evaluate($data));
		
		$data->addVariable('abc', true);
		$data->addVariable('def', false);
		$this->assertFalse($statement->evaluate($data));
		
		$data->addVariable('abc', false);
		$data->addVariable('def', false);
		$this->assertFalse($statement->evaluate($data));
		
	}
	
}
