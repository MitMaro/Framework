<?php
/**
 * Logic Statement Assertion
 * 
 * @package  Framework\AccessControl\Assertion\Logic
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl\Assertion\Logic;

use
	Framework\AccessControl\AssertionInterface,
	Framework\AccessControl\RoleBased\Permission
;

class Statement implements AssertionInterface {
	
	/**
	 * Assert that the provided role has required pemrissions
	 *
	 * @param string $name The name of the assertion being called
	 * @param mixed $statement The statement
	 * @param mixed $data_provider The data
	 */
	public function assert($name, $permission, $data_provider = null) {
		
		$permission->setDataProvider($data_provider);
		return $permission->getValue();
		
	}
}
