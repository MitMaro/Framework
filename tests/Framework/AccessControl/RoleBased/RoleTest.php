<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\AccessControl\RoleBased;

use
	\Framework\AccessControl\RoleBased\Permission,
	\Framework\AccessControl\RoleBased\Role
;

class AccessControl_Role_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\AccessControl\RoleBased\Role::__construct
	 * @covers \Framework\AccessControl\RoleBased\Role::getIdentifier
	 */
	public function testConstructor() {
		
		$id = 'here be an id';
		
		$role = new Role($id);
		
		$this->assertEquals($id, $role->getIdentifier());
	}
	
	/**
	 * @covers \Framework\AccessControl\RoleBased\Role::addPermissions
	 * @covers \Framework\AccessControl\RoleBased\Role::getPermissions
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
	 * @covers \Framework\AccessControl\RoleBased\Role::addPermissions
	 * @covers \Framework\AccessControl\RoleBased\Role::getPermissions
	 */
	public function testAddPermission_NotArray() {
		$role = new Role(1);

		$role->addPermissions(new Permission(4));
		
		$this->assertEquals(array(4 => new Permission(4)), $role->getPermissions());
	}
	
}
