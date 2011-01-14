<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

require_once 'Framework/AccessControl/Permission.php';

use
	\Framework\AccessControl\Permission
;

class AccessControl_Permission_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\AccessControl\Permission::__construct
	 * @covers \Framework\AccessControl\Permission::getId
	 */
	public function testConstructAndGetId() {
		
		$id = 'here be an id';
		
		$permission = new Permission($id);
		
		$this->assertEquals($id, $permission->getId());
	}
	
}
