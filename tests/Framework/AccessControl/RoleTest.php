<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\AccessControl\Permission,
	\Framework\AccessControl\Role
;

class AccessControl_Role_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * Test constructor and getId
	 * @covers \Framework\AccessControl\Role::__construct
	 * @covers \Framework\AccessControl\Role::getId
	 */
	public function testConstructor() {
		
		$id = 'here be an id';
		
		$role = new Role($id);
		
		$this->assertEquals($id, $role->getId());
	}
	
	/**
	 * Test addPermission and getPermissions
	 * @covers \Framework\AccessControl\Role::addPermissions
	 * @covers \Framework\AccessControl\Role::getPermissions
	 */
	public function testAddPermission() {
		$permissions = array(
			1 => new Permission(1),
			2 => new Permission(2),
			3 => new Permission(3),
			4 => new Permission(4),
		);
		
		$role = new Role(1);
		
		$role->addPermissions($permissions);
		
		$this->assertEquals($permissions, $role->getPermissions());
	}
	
	/**
	 * Test addPermission and getPermissions
	 * @covers \Framework\AccessControl\Role::addPermissions
	 * @covers \Framework\AccessControl\Role::getPermissions
	 */
	public function testAddPermission_NotArray() {
		$role = new Role(1);

		$role->addPermissions(new Permission(4));
		
		$this->assertEquals(array(4 => new Permission(4)), $role->getPermissions());
	}
	
}
