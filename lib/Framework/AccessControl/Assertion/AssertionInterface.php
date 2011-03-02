<?php
/**
 * Assertion Interface
 * 
 * @package  Framework\AccessControl\Assertion
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl\Assertion;

interface AssertionInterface {
	
	/**
	 * Assert role can perform an action
	 *
	 * @param string $name The name of the assertion being called
	 * @param mixed $role The role to check assertion against
	 * @param mixed $data Additional data used by the assertion
	 */
	public function assert($name, $role, $data);
	
}
