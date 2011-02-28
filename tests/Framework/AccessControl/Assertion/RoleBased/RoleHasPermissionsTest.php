<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\AccessControl\Assertion\RoleBased;

use
	\Framework\AccessControl\Assertion\RoleBased\RoleHasPermissions,
	\Framework\AccessControl\RoleBased\Permission,
	\Framework\AccessControl\RoleBased\Role
;

class RoleHasPermissions_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\AccessControl\Assertion\RoleBased\RoleHasPermissions::assert
	 * @dataProvider assertProvider
	 */
	public function testAssert($role_permissions, $required_permissions, $result) {
		
		$role = new Role('test');
		
		$role->addPermissions($role_permissions);
		
		$assertion = new RoleHasPermissions();
		
		$this->assertEquals($result, $assertion->assert(null, $role, $required_permissions));
	}
	
	public function assertProvider() {
		$data = array();
		
		// basic allow
		$data[] = array (
			array (
				new Permission('a', Permission::ALLOW)
			),
			new Permission('a'),
			true
		);
		// test soft deny (not set)
		$data[] = array (
			array (
				new Permission('a', Permission::ALLOW)
			),
			array (
				new Permission('a'),
				new Permission('b'),
			),
			false
		);
		// test soft deny
		$data[] = array (
			array (
				new Permission('a', Permission::SOFT_DENY)
			),
			array (
				new Permission('a'),
			),
			false
		);
		// test hard deny
		$data[] = array (
			array (
				new Permission('a', Permission::DENY)
			),
			array (
				new Permission('a'),
			),
			false
		);
		return $data;
	}
	
	
}

