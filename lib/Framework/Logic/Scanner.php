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

class Scanner {
	
	/**
	 * Types mapping
	 * @var array
	 */
	protected $types = array();
	
	/**
	 * Operator mappings
	 * @var array
	 */
	protected $operators = array();
	
	/**
	 * Statement delimiters mapping
	 *
	 * @var array
	 */
	protected $statement_delimiters = array();
	
	/**
	 * Characters that are considered whitespace
	 *
	 * @var array
	 */
	protected $white_space_characters = array(
		' ', "\t", "\n",
	);
	
	/**
	 * Characters that break tokens
	 *
	 * @var array
	 */
	protected $delimiters = array (
		'(', ')', '[', ']', '>', '<', '|', '&', '=', '!', ' ', "\t", "\n", "'", '"',
	);
	
	/**
	 * Cache of delimtiers that are sorted
	 *
	 * @var array
	 */
	private $sorted_delimiters = null;
	
	/**
	 * The position in the string during parse
	 * 
	 * @var integer
	 */
	protected $index = 0;
	
	/**
	 * The string to parse
	 *
	 * @var string
	 */
	protected $str = '';
	
	/**
	 * The length of $str
	 *
	 * @var integer
	 */
	protected $str_length = 0;
	
	/**
	 * The tokens after parsing is complete
	 *
	 * @var array
	 */
	protected $tokens = array();
	
	/**
	 * @param string $string The data string to parse
	 */
	public function __construct($string) {
		// some default maps, done here because __NAMESPACE__ can not be used above
		
		// types
		$this->types['integer'] = __NAMESPACE__ . '\Type\Integer';
		$this->types['float'] = __NAMESPACE__ . '\Type\Float';
		$this->types['string'] = __NAMESPACE__ . '\Type\String';
		$this->types['boolean'] = __NAMESPACE__ . '\Type\Boolean';
		
		// opeartors
		$this->operators['||'] = __NAMESPACE__ . '\Operator\OrOperator';
		$this->operators['&&'] = __NAMESPACE__ . '\Operator\AndOperator';
		$this->operators['!'] = __NAMESPACE__ . '\Operator\NotOperator';
		$this->operators['>'] = __NAMESPACE__ . '\Operator\GreaterThan';
		$this->operators['<'] = __NAMESPACE__ . '\Operator\LessThan';
		$this->operators['>='] = __NAMESPACE__ . '\Operator\GreaterEqualThan';
		$this->operators['<='] = __NAMESPACE__ . '\Operator\LessEqualThan';
		$this->operators['=='] = __NAMESPACE__ . '\Operator\Equals';
		$this->operators['!='] = __NAMESPACE__ . '\Operator\NotEquals';
		$this->operators['==='] = __NAMESPACE__ . '\Operator\Identical';
		$this->operators['!=='] = __NAMESPACE__ . '\Operator\NotIdentical';
		
		// delimiters
		$this->statement_delimiters['('] = __NAMESPACE__ . '\Delimiter';
		$this->statement_delimiters[')'] = __NAMESPACE__ . '\Delimiter';
		$this->statement_delimiters['['] = __NAMESPACE__ . '\Delimiter';
		$this->statement_delimiters[']'] = __NAMESPACE__ . '\Delimiter';
		
		$this->str = $string;
		$this->str_length = strlen($string);
	}
	
	/**
	 * Add a type. This method will override existing types
	 *
	 * @param string $name The name of the type that is used in the expression
	 * @param string $type The name of the class
	 */
	public function addType($name, $type) {
		$this->type_map[$name] = $type;
	}
	
	/**
	 * Get types map.
	 *
	 * @param array
	 */
	public function getTypes() {
		return $this->type_map;
	}
	
	/**
	 * Add a new statement delimiter
	 *
	 * @param string $delimiter The new delimiter string
	 */
	public function addStatementDelimiter($delimiter) {
		// existing delimter, skip
		if (in_array($delimiter, $this->statement_delimiters)) {
			return;
		}
		
		$this->statement_delimiters[] = $delimiter;
		
		// add the first character to the delimters array
		if (!in_array($delimiter[0], $this->delimiters)) {
			$this->delimiters[] = $delimiter[0];
		}
		
	}
	
	/**
	 * Get the statement delimters
	 *
	 * @return array
	 */
	public function getStatementDelimiter() {
		return $this->statement_delimiters;
	}
	
	/**
	 * Add an operator
	 * 
	 * @param string $name The name of the operator that is used in the expression
	 * @param string $type The name of the operator class
	 */
	public function addOperator($name, $class) {
		$this->operators[$name] = $class;
		
		// add the first character to the delimters array
		if (!in_array($name[0], $this->delimiters)) {
			$this->delimiters[] = $name[0];
		}
	}
	
	/**
	 * Get the operators
	 *
	 * @return array A list of the operators
	 */
	public function getOperators() {
		return $this->operators;
	}
	
	/**
	 * Skip any white space characters immediately after the index
	 *
	 * @return integer The current position of the index
	 */
	public function skipWhitespace() {
		while (true) {
			// check for the end of the string or the character is not a whitespace character
			if (
				$this->index >= $this->str_length ||
				!in_array($this->str[$this->index], $this->white_space_characters)
			) {
				break;
			}
			$this->index++;
		}
		return $this->index;
	}
	
	/**
	 * Read from the string the next token
	 *
	 * @return string The token read
	 */
	public function readNextToken() {
		$this->skipWhitespace();
		$start_index = $this->index;
		
		$delimiter_sets = $this->combineAndSortDelimiters();
		
		while (true) {
			
			// end of file found
			if ($this->index >= $this->str_length) {
				// if nothing to return
				if ($start_index == $this->index) {
					break;
				} else {
					return substr($this->str, $start_index, $this->index - $start_index);
				}
			}
			
			$char = $this->str[$this->index];
			
			// get contents of quoted values
			if ($this->index == $start_index && in_array($char, array('"', "'"))) {
				
				while (true) {
					$this->index++;
					// we reached the end of the file, we should not have
					if ($this->index >= $this->str_length) {
						break;
					}
					
					// end of token
					if (
						in_array($this->str[$this->index], array('"', "'")) &&
						$this->str[$this->index - 1] != '\\'
					) {
						$this->index++;
						$token = substr($this->str, $start_index + 1, $this->index - $start_index - 2);
						// remove any escaped quotes
						return str_replace(array('\\"', "\\'"), array('"', "'"), $token);
					}
				}
				throw new Exception\InvalidValue("End of data while looking for matching quote");
			}
			
			// delimiters are broken into sets by size to speed things up
			for ($size = count($delimiter_sets); $size > 0; $size--) {
				
				$set = $delimiter_sets[$size];
				
				// make sure there is enough string left to grab the necessary sub string
				if ($this->index + $size - 1 >= $this->str_length) {
					continue;
				}
				// get the characters to match against
				$chars = substr($this->str, $start_index, $size);
				// if the next character is a statement delimiter
				if (in_array($chars, $set)) {
					// if the delimiter is the next token
					$this->index += $size;
					return substr($this->str, $start_index, $this->index - $start_index);
					
				}
			}
			
			// if the next character is a delimter
			if (in_array($char, $this->delimiters)) {
				return substr($this->str, $start_index, $this->index - $start_index);
			}
			$this->index++;
		}
		return false;
	}
	
	/**
	 * Combine and sort by length the various delimters into one array
	 *
	 * @return array The sorted delimiters
	 */
	public function combineAndSortDelimiters() {
		
		// check for cache
		if (!is_null($this->sorted_delimiters)) {
			return $this->sorted_delimiters;
		}
		
		// merge the delimters into one array
		$delimiters = array_merge(
			array_keys($this->statement_delimiters),
			array_keys($this->operators)
		);
		
		// loop over and sort the delimiters
		$optimized_delimters = array();
		foreach ($delimiters as $delimiter) {
			$length = strlen($delimiter);
			
			if (!isset($optimized_delimters[$length])) {
				$optimized_delimters[$length] = array();
			}
			$optimized_delimters[$length][] = $delimiter;
		}
		
		$this->sorted_delimiters = $optimized_delimters;
		return $this->sorted_delimiters;
	}
	
	/**
	 * Tokenize the string, changing each string token into a class
	 *
	 * @return array
	 */
	public function tokenizeString() {
		while (($token = $this->readNextToken()) !== false) {
			
			// we have a type
			if (isset($this->types[$token])) {
				$type = $this->types[$token];
				$value = $this->readNextToken();
				if ($value === false) {
					throw new Exception\InvalidValue("A type was found but no value followed");
				}
				$this->tokens[] = new $type($value);
				continue;
			}
			
			// handle delimiters
			if (isset($this->statement_delimiters[$token])) {
				$this->tokens[] = new $this->statement_delimiters[$token]($token);
				continue;
			}
			
			// handle operators
			if (isset($this->operators[$token])) {
				$this->tokens[] = new $this->operators[$token]($token);
				continue;
			}
			throw new Exception\InvalidValue("Unknwon type provided: $token");
		}
		return $this->tokens;
	}
	
}
