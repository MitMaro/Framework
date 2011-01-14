<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

require_once 'Framework/AccessControl/Role.php';
require_once 'Framework/AccessControl/User.php';

use
	\Framework\AccessControl\Role,
	\Framework\AccessControl\User
;

class AccessControl_User_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * Test constructor and getId
	 * @covers \Framework\AccessControl\User::__construct
	 * @covers \Framework\AccessControl\User::getId
	 */
	public function testConstructor() {
		
		$id = 'here be an id';
		
		$user = new User($id);
		
		$this->assertEquals($id, $user->getId());
	}
	
	/**
	 * Test addRoles and getRoles
	 * @covers \Framework\AccessControl\User::addRoles
	 * @covers \Framework\AccessControl\User::getRoles
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
	 * Test addRoles and getRoles
	 * @covers \Framework\AccessControl\User::addRoles
	 * @covers \Framework\AccessControl\User::getRoles
	 */
	public function testAddRole_NotArray() {
		$user = new User(1);

		$user->addRoles(new Role(4));
		
		$this->assertEquals(array(4 => new Role(4)), $user->getRoles());
	}
	
}
