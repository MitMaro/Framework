<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Scanner,
	\Framework\Logic\Type,
	\Framework\Logic\Operator,
	\Framework\Logic\OperatorInterface,
	\Framework\Logic\ExpressionInterface,
	\Framework\Logic\Delimiter
;

class LogicScanner_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Scanner::__construct
	 */
	public function test_construct() {
		new Scanner('abc');
	}
	
	/**
	 * @covers \Framework\Logic\Scanner::combineAndSortDelimiters
	 */
	public function test_combineAndSortDelimiters() {
		$scanner = new Scanner('');
		$this->assertEquals(
			array (
				1 => array (
					'(', ')', '[', ']', '!', '>', '<',
				),
				2 => array (
					'||', '&&', '>=', '<=', '==', '!='
				),
				3 => array (
					'===', '!==',
				)
			),
			$scanner->combineAndSortDelimiters()
		);
		// hit again to hit cache
		$scanner->combineAndSortDelimiters();
	}
	
	/**
	 * @covers \Framework\Logic\Scanner::skipWhitespace
	 */
	public function test_skipWhitespace() {
		$scanner = new Scanner('    abc');
		$this->assertEquals(4, $scanner->skipWhitespace());
	}
	
	/**
	 * @covers \Framework\Logic\Scanner::readNextToken
	 * @dataProvider readNextTokenData
	 */
	public function test_readNextToken_simple($string, $results) {
		$scanner = new Scanner($string);
		
		foreach ($results as $r) {
			$this->assertEquals(
				$r,
				$scanner->readNextToken()
			);
		}
	}
	
	public function readNextTokenData() {
		return array(
			array('', array(false)),
			array('a', array('a')),
			array('abc', array('abc')),
			array('a b', array('a', 'b')),
			array('abc def', array('abc', 'def')),
			array('"d e f"', array('d e f')),
			array('abc "d e f"', array('abc', 'd e f')),
			array('abc ""', array('abc', '')),
			array('abc "d e f" def', array('abc', 'd e f', 'def')),
			array('abc"d e f"', array('abc', 'd e f')),
			array('abc "def\""', array('abc', 'def"')),
			array('abc > def', array('abc', '>', 'def')),
			array('    abc > def   ', array('abc', '>', 'def')),
			array('abc > def   ', array('abc', '>', 'def')),
			array('abc     <       def', array('abc', '<', 'def')),
			array('abc	<def', array('abc', '<', 'def')),
			array('abc<	def', array('abc', '<', 'def')),
			array("abc\n<\ndef", array('abc', '<', 'def')),
			array('abc>def', array('abc', '>', 'def')),
			array('abc>=def', array('abc', '>=', 'def')),
			array('abc===def', array('abc', '===', 'def')),
			array('(abc def)', array('(', 'abc', 'def', ')')),
			array('( abc def)', array('(', 'abc', 'def', ')')),
			array('(abc def )', array('(', 'abc', 'def', ')')),
			array('(abc def)&&ghi', array('(', 'abc', 'def', ')', '&&', 'ghi')),
			array('(abc def) &&ghi', array('(', 'abc', 'def', ')', '&&', 'ghi')),
			// some invalid cases that the method should handle
			array('>', array('>')),
			array('>abc', array('>', 'abc')),
			array('()', array('(', ')')),
			// all the operators and delimiters
			array('|| && ! > < >= <= == != === !===', array ('||', '&&', '!', '>', '<', '>=', '<=', '==', '!=', '===', '!==')),
			array('( ) [ ]', array ('(', ')', '[', ']')),
		);
	}
	
	/**
	 * @covers \Framework\Logic\Scanner::readNextToken
	 * @expectedException \Framework\Logic\Exception\InvalidValue
	 * @dataProvider readNextTokenInvalidData
	 */
	public function test_readNextToken_invalid($string) {
		$scanner = new Scanner($string);
		$scanner->readNextToken();
	}
	
	public function readNextTokenInvalidData() {
		return array(
			array('"abc'), // invalid quoted string
		);
	}
	
	/**
	 * @covers \Framework\Logic\Scanner::tokenizeString
	 * @dataProvider tokenizeStringData
	 */
	public function test_tokenizeString_simple($string, $results) {
		$scanner = new Scanner($string);
		
		$this->assertEquals($results, $scanner->tokenizeString());
	}
	
	public function tokenizeStringData() {
		return array(
			array('integer 1',
				array(new Type\Integer(1)),
			),
			array('integer 1 > integer 2',
				array(
					new Type\Integer(1),
					new Operator\GreaterThan(),
					new Type\Integer(2),
				),
			),
			array('(integer 1 > integer 2) && (string abc == string cde)',
				array(
					new Delimiter('('),
					new Type\Integer(1),
					new Operator\GreaterThan(),
					new Type\Integer(2),
					new Delimiter(')'),
					new Operator\AndOperator(),
					new Delimiter('('),
					new Type\String('abc'),
					new Operator\Equals(),
					new Type\String('cde'),
					new Delimiter(')'),
				),
			),
		);
	}
	
	/**
	 * @covers \Framework\Logic\Scanner::tokenizeString
	 * @expectedException \Framework\Logic\Exception\InvalidValue
	 * @dataProvider tokenizeStringInvalidData
	 */
	public function test_tokenizeString_invalid($string) {
		$scanner = new Scanner($string);
		$scanner->tokenizeString();
	}
	
	public function tokenizeStringInvalidData() {
		return array(
			array('integer'), // not value
			array('abc 1'), // invalid type
		);
	}
	
	/**
	 * @covers \Framework\Logic\Scanner::addType
	 * @covers \Framework\Logic\Scanner::getTypes
	 */
	public function test_addType() {
		$scanner = new Scanner('');
		
		$scanner->addType('^', 'a_class_name');
		
		$types = $scanner->getTypes();
		
		$this->assertTrue(isset($types['^']));
		$this->assertEquals('a_class_name', $types['^']);
		
	}
	
	/**
	 * @covers \Framework\Logic\Scanner::addStatementDelimiter
	 * @covers \Framework\Logic\Scanner::getStatementDelimiter
	 */
	public function test_addStatementDelimiter() {
		$scanner = new Scanner('');
		
		$scanner->addStatementDelimiter('^');
		$scanner->addStatementDelimiter('^'); // add twice to test the no double insert
		
		$delimiters = $scanner->getStatementDelimiter();
		
		$this->assertEquals(1, count(array_keys($delimiters, '^')));
		
	}
	
	/**
	 * @covers \Framework\Logic\Scanner::addOperator
	 * @covers \Framework\Logic\Scanner::getOperators
	 */
	public function test_addOperator() {
		$scanner = new Scanner('');
		
		$scanner->addOperator('{', 'a_delimiter_class');
		
		$delimiter = $scanner->getOperators();
		
		$this->assertTrue(isset($delimiter['{']));
		$this->assertEquals('a_delimiter_class', $delimiter['{']);
	}
	
}
