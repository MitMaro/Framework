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
	Framework\Logic\Lexer,
	Framework\Logic\LexerInterface,
	Framework\Logic\ExpressionInterface,
	Framework\Logic\OperatorInterface
;

class Parser {
	
	protected $lexer;
	
	/**
	 * @param mixed $statement A statement as a string (which uses the default lexer) or a lexer
	 *                         with a string preloaded.
	 */
	public function __construct($statement = null) {
		
		if ($statement instanceof LexerInterface) {
			$this->lexer = $statement;
		} else {
			$this->lexer = new Lexer($statement);
		}
		
	}
	
	/**
	 * Parse the statement/tokens from the lexer and create a AST
	 *
	 * @param integer $depth (Optional) The depth in the statement, best not to change this without
	 *                                  good reason.
	 * @return \Framework\Logic\Statement The abstract syntax tree
	 */
	public function parseStatement($depth = 0) {
		
		$left = null;
		
		$token = $this->lexer->getNextToken();
		
		// false token here means a syntax error, either empty statement or unexpected end of stream
		if ($token === false) {
			if ($depth == 0) {
				throw new Exception\EmptyStatement("The statement provided is empty");
			}
			throw new Exception\EndOfData("An end of data occured when trying to parse a statement");
		}
		
		while ($token) {
			$right = null;
			$operator = null;
			
			// only find left side on the first pass
			if (is_null($left)) {
				// left side of statement or a unary opeartor
				if ($token instanceof VariableInterface || $token instanceof TypeInterface) {
					$left = $token;
				} else if ($token instanceof LeftDelimiter) { // sub statement
					$left = $this->parseStatement($depth + 1);
				} else if ($token instanceof UnaryOperatorInterface) {
					$operator = $token;
				} else {
					throw new Exception\InvalidToken("Invalid Token Provided - " . get_class($token));
				}
				
				// set token to null so the operator check below knows to read the next token
				$token = null; 
			}
			
			// if no operator then try to get one
			if (is_null($operator)) {
				// avoids reading the next token prematurely 
				if (is_null($token)) {
					$token = $this->lexer->getNextToken();
				}
				
				if ($token instanceof OperatorInterface) {
					$operator = $token;
				} else {
					if ($token === false) {
						throw new Exception\EndOfData(
							"An end of data occured when trying to find an operator"
						);
					}
					throw new Exception\InvalidToken(
						"Invalid Token Provided - " . get_class($token) . " - Expecting Operator"
					);
				}
			}
			
			// right hand side
			$token = $this->lexer->getNextToken();
			if ($token instanceof VariableInterface || $token instanceof TypeInterface) {
				$right = $token;
			} else if ($token instanceof LeftDelimiter) {
				$right = $this->parseStatement($depth + 1);
			} else {
				if ($token === false) {
					throw new Exception\EndOfData(
						"An end of data occured when trying to find an expression"
					);
				}
				throw new Exception\InvalidToken("Invalid Token Provided - " . get_class($token));
			}
			
			// if right is null then it is a unary operation
			if (is_null($left)) {
				$left = new Statement($operator, $right);
			} else {
				$left = new Statement($operator, $left, $right);
			}
			
			$token = $this->lexer->getNextToken();
			
			// if there was no right delimiter and we are in a nested statement
			if ($depth > 0 && $token === false) {
				throw new Exception\EndOfData(
					"An end of data occured when trying to end a statement"
				);
			}
			
			// statement done on finding of right delimiter
			if ($depth > 0 && $token instanceof RightDelimiter) {
				break;
			}
			
		}
		
		return $left;
	}
	
}
