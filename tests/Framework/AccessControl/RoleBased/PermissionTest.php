<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\AccessControl\RoleBased;

use
	\Framework\AccessControl\RoleBased\Permission
;

class Permission_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\AccessControl\RoleBased\Permission::__construct
	 * @covers \Framework\AccessControl\RoleBased\Permission::getIdentifier
	 * @covers \Framework\AccessControl\RoleBased\Permission::getValue
	 */
	public function testConstructAndGetId() {
		
		$id = 'here be an id';
		
		$permission = new Permission($id, Permission::DENY);
		
		$this->assertEquals($id, $permission->getIdentifier());
		$this->assertEquals(Permission::DENY, $permission->getValue());
	}
	
}

