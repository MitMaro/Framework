<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\AccessControl\RoleBased;

use
	\Framework\AccessControl\RoleBased\Role,
	\Framework\AccessControl\RoleBased\Permission,
	\Framework\AccessControl\RoleBased\User
;

class AccessControl_User_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\AccessControl\RoleBased\User::__construct
	 * @covers \Framework\AccessControl\RoleBased\User::getIdentifier
	 */
	public function testConstructor() {
		
		$id = 'here be an id';
		
		$user = new User($id);
		
		$this->assertEquals($id, $user->getIdentifier());
	}
	
	/**
	 * @covers \Framework\AccessControl\RoleBased\User::addRoles
	 * @covers \Framework\AccessControl\RoleBased\User::getRoles
	 */
	public function testAddRole() {
		$roles = array(
			1 => new Role(1),
			2 => new Role(2),
			3 => new Role(3),
			4 => new Role(4),
		);
		
		$user = new User(1);
		
		$user->addRoles($roles);
		
		$this->assertEquals($roles, $user->getRoles());
	}
	
	/**
	 * @covers \Framework\AccessControl\RoleBased\User::addRoles
	 * @covers \Framework\AccessControl\RoleBased\User::getRoles
	 */
	public function testAddRole_NotArray() {
		$user = new User(1);

		$user->addRoles(new Role(4));
		
		$this->assertEquals(array(4 => new Role(4)), $user->getRoles());
	}
	
	/**
	 * @covers \Framework\AccessControl\RoleBased\User::addPermissions
	 * @covers \Framework\AccessControl\RoleBased\User::getPermissions
	 */
	public function testAddGetPermissions() {
		$user = new User(1);
		
		$permission = new Permission(1);

		$user->addPermissions($permission);
		
		$this->assertEquals(array(1 => $permission), $user->getPermissions());
	}
	
	/**
	 * @covers \Framework\AccessControl\RoleBased\User::getPermissions
	 */
	public function testGetPermissions_OnRoles() {
		$user = new User(1);
		
		$role1 = new Role(1);
		$role2 = new Role(2);
		
		$role1->addPermissions(
			array(
				new Permission(1, Permission::ALLOW),
				new Permission(2, Permission::ALLOW),
				new Permission(3, Permission::DENY),
				new Permission(4, Permission::DENY),
				new Permission(5, Permission::SOFT_DENY),
			)
		);
		
		$role2->addPermissions(
			array(
				new Permission(1, Permission::DENY),
				new Permission(3, Permission::ALLOW),
				new Permission(6, Permission::ALLOW),
			)
		);
		
		$user->addRoles(array($role1, $role2));
		
		$result = array(
				1 => new Permission(1, Permission::DENY),
				2 => new Permission(2, Permission::ALLOW),
				3 => new Permission(3, Permission::DENY),
				4 => new Permission(4, Permission::DENY),
				5 => new Permission(5, Permission::SOFT_DENY),
				6 => new Permission(6, Permission::ALLOW),
		);
		
		$this->assertEquals($result, $user->getPermissions());
		
		// twice to test permissions cache
		$this->assertEquals($result, $user->getPermissions());
	}
	
	
}
