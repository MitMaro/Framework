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
	\Framework\AccessControl\RoleBased\User,
	\Framework\AccessControl\RoleBased\Role,
	\Framework\AccessControl\RoleBased\Resource
;

class Resource_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\AccessControl\RoleBased\Resource::__construct
	 * @covers \Framework\AccessControl\RoleBased\Resource::getIdentifier
	 */
	public function testConstructor() {
		
		$id = 'here be an id';
		
		$resource = new Resource($id);
		
		$this->assertEquals($id, $resource->getIdentifier());
	}
	
	/**
	 * @covers \Framework\AccessControl\RoleBased\Resource::addPermissions
	 * @covers \Framework\AccessControl\RoleBased\Resource::getPermissions
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
	 * @covers \Framework\AccessControl\RoleBased\Resource::addPermissions
	 * @covers \Framework\AccessControl\RoleBased\Resource::getPermissions
	 */
	public function testAddPermission_NotArray() {
		$resource = new Resource(1);
		
		$resource->addPermissions(new Permission(4));
		
		$this->assertEquals(array(4 => new Permission(4)), $resource->getPermissions());
	}
	
}
