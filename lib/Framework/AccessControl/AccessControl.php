<?php
/**
 * @package  Framework\AccessControl
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl;

use
	Framework\AccessControl\Assertion\AssertionInterface,
	Framework\AccessControl\Exception\InvalidAssertion
;

class AccessControl {
	
	/**
	 * Assertions as key-value of assertion names and classes
	 * @var array
	 */
	protected $assertions = array();
	
	/**
	 * Add an assertion
	 * 
	 * @param string $name The name of the assertion
	 * @param mixed $class The name of a assertion class or an instance of one
	 * 
	 */
	public function addAssertion($name, $class) {
		
		if ($class instanceof AssertionInterface) {
			$this->assertions[$name] = $class;
		} else {
			$this->assertions[$name] = new $class();
		}
		
	}
	
	/**
	 * Check if an assertion is true for the given asset
	 *
	 * @param mixed $assertion The name of a assertion class or an instance of one
	 * @param mixed $asset The asset to use in the assertion
	 * @param mixed $data The data to pass to the assertion
	 *
	 * @return boolean True if the assertion was allowed, otherwise false
	 */
	public function isAllowed($assertion, $asset, $data = null) {
		if (!$assertion instanceof AssertionInterface) {
			if (isset($this->assertions[$assertion])) {
				$name = $assertion;
				$assertion = $this->assertions[$assertion];
			} else {
				throw new InvalidAssertion("Assertion could not be found");
			}
		} else {
			$name = get_class($assertion);
		}
		
		return $assertion->assert($name, $asset, $data);
	}
	
}
