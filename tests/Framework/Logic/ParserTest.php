<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Parser,
	\Framework\Logic\Variable,
	\Framework\Logic\Type\Boolean,
	\Framework\Logic\Type\Float,
	\Framework\Logic\Type\Integer,
	\Framework\Logic\Type\String,
	\Framework\Logic\Statement,
	\Framework\Logic\LexerInterface,
	\Framework\Logic\Operator\AndOperator,
	\Framework\Logic\Operator\Equals,
	\Framework\Logic\Operator\GreaterEqualThan,
	\Framework\Logic\Operator\GreaterThan,
	\Framework\Logic\Operator\Identical,
	\Framework\Logic\Operator\LessEqualThan,
	\Framework\Logic\Operator\LessThan,
	\Framework\Logic\Operator\NotEquals,
	\Framework\Logic\Operator\NotIdentical,
	\Framework\Logic\Operator\NotOperator,
	\Framework\Logic\Operator\OrOperator
;

class LogicParser_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Parser::__construct
	 */
	public function test_construct() {
		new Parser('abc');
	}
	
	/**
	 * @covers \Framework\Logic\Parser::__construct
	 */
	public function test_construct_customLexer() {
		$parser = new Parser(new MyLogicLexer(''));
		
		$this->assertEquals(
			new Statement(
				new Equals(),
				new Integer(1),
				new Integer(2)
			),
			$parser->parseStatement()
		);
	}
	
	/**
	 * @covers \Framework\Logic\Parser::parseStatement
	 * @dataProvider parseStatementNestingData
	 */
	public function test_parseStatement_nesting($statement, $result) {
		$parser = new Parser($statement);
		
		$this->assertEquals($result, $parser->parseStatement());
	}
	
	public function parseStatementNestingData() {
		return array (
			array (
				'Integer 1 == Integer 2',
				new Statement(new Equals(), new Integer(1), new Integer(2))
			),
			array (
				'Integer 1 == Integer 2 == Integer 3',
				new Statement(
					new Equals(),
					new Statement(
						new Equals(),
						new Integer(1),
						new Integer(2)
					),
					new Integer(3)
				)
			),
			array (
				'(Integer 1 == Integer 2) == Integer 3',
				new Statement(
					new Equals(),
					new Statement(new Equals(), new Integer(1), new Integer(2)),
					new Integer(3)
				)
			),
			array (
				'(Integer 1 == Integer 2) == (Integer 3 > Integer 4)',
				new Statement(
					new Equals(),
					new Statement(new Equals(), new Integer(1), new Integer(2)),
					new Statement(new GreaterThan(), new Integer(3), new Integer(4))
				)
			),
			array (
				'(Integer 1 == Integer 2) == (Integer 3 > (Integer 4 < Integer 5))',
				new Statement(
					new Equals(),
					new Statement(new Equals(), new Integer(1), new Integer(2)),
					new Statement(
						new GreaterThan(),
						new Integer(3),
						new Statement(
							new LessThan(),
							new Integer(4),
							new Integer(5)
						)
					)
				)
			),
		);
	}
	
	/**
	 * @covers \Framework\Logic\Parser::parseStatement
	 * @dataProvider parseStatementUnaryData
	 */
	public function test_parseStatement_unary($statement, $result) {
		$parser = new Parser($statement);
		
		$this->assertEquals($result, $parser->parseStatement());
	}
	
	public function parseStatementUnaryData() {
		return array (
			array (
				'!Boolean true',
				new Statement(new NotOperator(), new Boolean(true))
			),
			array (
				'!(Integer 1 == Integer 2)',
				new Statement(
					new NotOperator(),
					new Statement(
						new Equals(),
						new Integer(1),
						new Integer(2)
					)
				)
			),
			array (
				'!Integer 1 == Integer 2',
				new Statement(
					new Equals(),
					new Statement(
						new NotOperator(),
						new Integer(1)
					),
					new Integer(2)
				)
			),
		);
	}
	
	/**
	 * @covers \Framework\Logic\Parser::parseStatement
	 * @dataProvider parseStatementOpertorsData
	 */
	public function test_parseStatement_operators($statement, $result) {
		$parser = new Parser($statement);
		
		$this->assertEquals($result, $parser->parseStatement());
	}
	
	public function parseStatementOpertorsData() {
		return array (
			array (
				'Boolean true && Boolean true',
				new Statement(new AndOperator(), new Boolean(true), new Boolean(true))
			),
			array (
				'Boolean true == Boolean true',
				new Statement(new Equals(), new Boolean(true), new Boolean(true))
			),
			array (
				'Boolean true >= Boolean true',
				new Statement(new GreaterEqualThan(), new Boolean(true), new Boolean(true))
			),
			array (
				'Boolean true > Boolean true',
				new Statement(new GreaterThan(), new Boolean(true), new Boolean(true))
			),
			array (
				'Boolean true === Boolean true',
				new Statement(new Identical(), new Boolean(true), new Boolean(true))
			),
			array (
				'Boolean true <= Boolean true',
				new Statement(new LessEqualThan(), new Boolean(true), new Boolean(true))
			),
			array (
				'Boolean true < Boolean true',
				new Statement(new LessThan(), new Boolean(true), new Boolean(true))
			),
			array (
				'Boolean true != Boolean true',
				new Statement(new NotEquals(), new Boolean(true), new Boolean(true))
			),
			array (
				'Boolean true !== Boolean true',
				new Statement(new NotIdentical(), new Boolean(true), new Boolean(true))
			),
			array (
				'! Boolean true',
				new Statement(new NotOperator(), new Boolean(true))
			),
			array (
				'Boolean true || Boolean true',
				new Statement(new OrOperator(), new Boolean(true), new Boolean(true))
			),
		);
	}
	
	/**
	 * @covers \Framework\Logic\Parser::parseStatement
	 * @dataProvider parseStatementTypesData
	 */
	public function test_parseStatement_types($statement, $result) {
		$parser = new Parser($statement);
		
		$this->assertEquals($result, $parser->parseStatement());
	}
	
	public function parseStatementTypesData() {
		return array (
			array (
				'Boolean true == Boolean false',
				new Statement(new Equals(), new Boolean(true), new Boolean(false))
			),
			array (
				'Float "1.0" == Float "1.1"',
				new Statement(new Equals(), new Float(1.0), new Float(1.1))
			),
			array (
				'Integer 1 == Integer 2',
				new Statement(new Equals(), new Integer(1), new Integer(2))
			),
			array (
				'String "abc" == String "def"',
				new Statement(new Equals(), new String("abc"), new String("def"))
			),
		);
	}
	
	/**
	 * @covers \Framework\Logic\Parser::parseStatement
	 */
	public function test_parseStatement_variables() {
		$parser = new Parser('Integer $aaa == Integer $bbb');
		
		$this->assertEquals(
			new Statement(
				new Equals(),
				new Variable(
					'Framework\Logic\Type\Integer',
					'aaa'
				),
				new Variable(
					'Framework\Logic\Type\Integer',
					'bbb'
				)
			),
			$parser->parseStatement()
		);
	}
	
	/**
	 * @covers \Framework\Logic\Parser::parseStatement
	 * @expectedException \Framework\Logic\Exception\EmptyStatement
	 */
	public function test_parseStatement_Exception_EmptyStatement() {
		$parser = new Parser('');
		$parser->parseStatement();
	}
	
	/**
	 * @covers \Framework\Logic\Parser::parseStatement
	 * @dataProvider parseStatementEndOfDataData
	 * @expectedException \Framework\Logic\Exception\EndOfData
	 */
	public function test_parseStatement_Exception_IncompleteStatement($statement) {
		$parser = new Parser($statement);
		$parser->parseStatement();
	}
	
	public function parseStatementEndOfDataData() {
		return array (
			array ('Integer 1'),
			array ('Integer 1 == ('),
			array ('Integer 1 =='),
			array ('Integer 1 == (Integer 1 == Integer 1'),
		);
	}
	
	/**
	 * @covers \Framework\Logic\Parser::parseStatement
	 * @dataProvider parseStatementInvalidTokenData
	 * @expectedException \Framework\Logic\Exception\InvalidToken
	 */
	public function test_parseStatement_Exception_InvalidToken($statement) {
		$parser = new Parser($statement);
		$parser->parseStatement();
	}
	
	public function parseStatementInvalidTokenData() {
		return array (
			array ('== Integer 1'),
			array ('Integer 1 Integer 1'),
			array ('Integer 1 == )'),
		);
	}
}

class MyLogicLexer implements LexerInterface {
	
	protected $index = 0;
	protected $tokens = array();
	
	public function __construct() {
		$this->tokens = array (
			new Integer(1),
			new Equals(),
			new Integer(2),
		);
	}
	
	public function getNextToken() {
		if ($this->index >= count($this->tokens)) {
			return false;
		}
		$this->index++;
		return $this->tokens[$this->index - 1];
	}
}
