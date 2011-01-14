<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

require_once 'Framework/AccessControl.php';
require_once 'Framework/AccessControl/Exception.php';
require_once 'Framework/AccessControl/Permission.php';
require_once 'Framework/AccessControl/Resource.php';
require_once 'Framework/AccessControl/Role.php';
require_once 'Framework/AccessControl/User.php';

use
	\Framework\AccessControl,
	\Framework\AccessControl\Permission,
	\Framework\AccessControl\Role,
	\Framework\AccessControl\Resource,
	\Framework\AccessControl\User
;

class AccessControl_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * Test addResourcePermissions and getResources
	 * @covers \Framework\AccessControl::addResourcePermissions
	 * @covers \Framework\AccessControl::getResources
	 */
	public function testAddResourcePermissions() {
		
		$resource = new Resource('id1');
		
		$permissions = array(
			1 => new Permission(1),
			2 => new Permission(2),
		);
		
		$accessControl = new AccessControl();
		
		$accessControl->addResourcePermissions($resource, $permissions);
		
		$resources = $accessControl->getResources();
		
		$this->assertEquals(1, count($resources));
		$this->assertEquals($permissions, $resources[$resource->getId()]->getPermissions());
		
		return $accessControl;
	}
	
	/**
	 * @covers \Framework\AccessControl::addResource
	 */
	public function testAddResource() {
		
		$resource = new Resource('id1');
		
		$accessControl = new AccessControl();
		
		$accessControl->addResource($resource);
		
		$resources = $accessControl->getResources();
		
		$this->assertEquals(1, count($resources));
		$this->assertTrue(isset($resources[$resource->getId()]));
		
	}
	
	/**
	 * @covers \Framework\AccessControl::verifyAccess
	 * @depends testAddResourcePermissions
	 */
	public function testVerifyAccess_Allowed(AccessControl $accessControl) {
		AccessControl::setDefaultAccess(false);
		
		$user = new User('u1');
		$role = new Role('r1');
		$role->addPermissions(array(
			1 => new Permission(1),
			2 => new Permission(2),
		));
		$user->addRoles($role);
		
		$this->assertTrue($accessControl->verifyAccess(new Resource('id1'), $user));
	}
	
	/**
	 * @covers \Framework\AccessControl::verifyAccess
	 * @depends testAddResourcePermissions
	 */
	public function testVerifyAccess_Denied(AccessControl $accessControl) {
		AccessControl::setDefaultAccess(true);
		
		$user = new User('u1');
		$user->addRoles(new Role('r1'));
		
		$this->assertFalse($accessControl->verifyAccess(new Resource('id1'), $user));
	}
	
	/**
	 * @covers \Framework\AccessControl::verifyAccess
	 * @depends testAddResourcePermissions
	 */
	public function testVerifyAccess_AllowedDefault(AccessControl $accessControl) {
		AccessControl::setDefaultAccess(true);
		
		$user = new User('u1');
		$user->addRoles(new Role('r1'));
		
		$this->assertTrue($accessControl->verifyAccess(new Resource('id2'), $user));
	}
	
	/**
	 * @covers \Framework\AccessControl::verifyAccess
	 * @depends testAddResourcePermissions
	 */
	public function testVerifyAccess_DeniedDefault(AccessControl $accessControl) {
		AccessControl::setDefaultAccess(false);
		
		$user = new User('u1');
		$user->addRoles(new Role('r1'));
		
		$this->assertFalse($accessControl->verifyAccess(new Resource('id2'), $user));
	}
	
	/**
	 * @covers \Framework\AccessControl::mirror
	 */
	public function testMirror_Regular() {
		$accessControl = new AccessControl();
		
		$resource = new Resource('id1');
		
		$accessControl->addResource($resource);
		
		$accessControl->mirror($resource->getId(), 'id2');
		
		$resources = $accessControl->getResources();
		
		$this->assertTrue(isset($resources['id1']));
		$this->assertTrue(isset($resources['id2']));
		
	}
	
	/**
	 * @covers \Framework\AccessControl::mirror
	 */
	public function testMirror_Switched() {
		$accessControl = new AccessControl();
		
		$resource = new Resource('id1');
		
		$accessControl->addResource($resource);
		
		$accessControl->mirror('id2', $resource->getId());
		
		$resources = $accessControl->getResources();
		
		$this->assertTrue(isset($resources['id1']));
		$this->assertTrue(isset($resources['id2']));
		
	}
	
	/**
	 * @covers \Framework\AccessControl::mirror
	 * @expectedException \Framework\AccessControl\Exception
	 */
	public function testMirror_Exception() {
		
		$accessControl = new AccessControl();
		
		$accessControl->mirror('id2', 'id1');
		
	}
	
	
	/**
	 * @covers \Framework\AccessControl::setDefaultAccess
	 * @covers \Framework\AccessControl::getDefaultAccess
	 */
	public function testSetGetDefaultAccess_True() {
		AccessControl::setDefaultAccess(true);
		$this->assertTrue(AccessControl::getDefaultAccess());
	}
	
	/**
	 * @covers \Framework\AccessControl::setDefaultAccess
	 * @covers \Framework\AccessControl::getDefaultAccess
	 */
	public function testSetGetDefaultAccess_False() {
		AccessControl::setDefaultAccess(false);
		$this->assertFalse(AccessControl::getDefaultAccess());
	}
	
	/**
	 * @covers \Framework\AccessControl::verifyUserResourceAccess
	 */
	public function testVerifyUserResourceAccess_True() {
		
		$permissions = array(
			1 => new Permission(1),
			2 => new Permission(2),
		);
		
		$resource = new Resource('id1');
		$resource->addPermissions($permissions);
		
		$user = new User('u1');
		$role = new Role('r1');
		$role->addPermissions($permissions);
		
		$user->addRoles($role);
		
		$this->assertTrue(AccessControl::verifyUserResourceAccess($user, $resource));
		
	}
	
	
	/**
	 * @covers \Framework\AccessControl::verifyUserResourceAccess
	 */
	public function testVerifyUserResourceAccess_False() {
		
		$permissions = array(
			1 => new Permission(1),
			2 => new Permission(2),
		);
		
		$resource = new Resource('id1');
		$resource->addPermissions($permissions);
		
		$user = new User('u1');
		
		$this->assertFalse(AccessControl::verifyUserResourceAccess($user, $resource));
		
	}
	
}
