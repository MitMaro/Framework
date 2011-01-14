<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */


require_once 'Framework/AccessControl/Permission.php';
require_once 'Framework/AccessControl/Resource.php';
require_once 'Framework/AccessControl/Role.php';
require_once 'Framework/AccessControl/User.php';

use
	\Framework\AccessControl\Permission,
	\Framework\AccessControl\User,
	\Framework\AccessControl\Role,
	\Framework\AccessControl\Resource
;

class AccessControl_Resource_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\AccessControl\Resource::__construct
	 * @covers \Framework\AccessControl\Resource::getId
	 */
	public function testConstructor() {
		
		$id = 'here be an id';
		
		$resource = new Resource($id);
		
		$this->assertEquals($id, $resource->getId());
	}
	
	/**
	 * @covers \Framework\AccessControl\Resource::addPermissions
	 * @covers \Framework\AccessControl\Resource::getPermissions
	 */
	public function testAddPermission() {
		$permissions = array(
			1 => new Permission(1),
			2 => new Permission(2),
			3 => new Permission(3),
			4 => new Permission(4),
		);
		
		$resource = new Resource(1);
		
		$resource->addPermissions($permissions);
		
		$this->assertEquals($permissions, $resource->getPermissions());
	}
	
	/**
	 * @covers \Framework\AccessControl\Resource::addPermissions
	 * @covers \Framework\AccessControl\Resource::getPermissions
	 */
	public function testAddPermission_NotArray() {
		$resource = new Resource(1);
		
		$resource->addPermissions(new Permission(4));
		
		$this->assertEquals(array(4 => new Permission(4)), $resource->getPermissions());
	}
	
	/**
	 * @covers \Framework\AccessControl\Resource::checkUserPermissions
	 */
	public function testCheckUserPermission_Allowed() {
		$user = new User('user1');
		$resource = new Resource(1);
		$role = new Role('role1');
		$permissions = array(
			1 => new Permission(1),
			2 => new Permission(2),
			3 => new Permission(3),
			4 => new Permission(4),
		);
		
		$role->addPermissions($permissions);
		$resource->addPermissions($permissions);
		
		$user->addRoles($role);
		
		$this->assertTrue($resource->checkUserPermissions($user));
	}
	
	/**
	 * @covers \Framework\AccessControl\Resource::checkUserPermissions
	 */
	public function testCheckUserPermission_Denied() {
		$user = new User('user1');
		$resource = new Resource(1);
		$role = new Role('role1');
		$permissions = array(
			1 => new Permission(1),
			2 => new Permission(2),
			3 => new Permission(3),
			4 => new Permission(4),
		);
		
		$resource->addPermissions($permissions);
		
		// remove a permission from the role
		unset($permissions[2]);
		
		$role->addPermissions($permissions);
		
		$user->addRoles($role);
		
		$this->assertFalse($resource->checkUserPermissions($user));
	}
}
