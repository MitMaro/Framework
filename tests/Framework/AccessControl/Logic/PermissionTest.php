<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\AccessControl\Logic;

use
	\Framework\AccessControl\Logic\Permission,
	\Framework\AccessControl\Assertion\Logic\Statement,
	\Framework\Logic
	
;

class Permission_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\AccessControl\Logic\Permission::__construct
	 * @covers \Framework\AccessControl\Logic\Permission::getIdentifier
	 * @covers \Framework\AccessControl\Logic\Permission::getValue
	 */
	public function testConstructAndGetId() {
		
		$id = 'id';
		
		$statement = new Logic\Statement(
			new Logic\Operator\AndOperator(),
			new Logic\Type\Boolean(true),
			new Logic\Type\Boolean(true)
		);
		$permission = new Permission($id, $statement);
		
		$this->assertEquals($id, $permission->getIdentifier());
		$this->assertTrue($permission->getValue());
	}
	
	/**
	 * @covers \Framework\AccessControl\Logic\Permission::setDataProvider
	 */
	public function testSetDataProvider() {
		
		$statement = new Logic\Statement(
			new Logic\Operator\AndOperator(),
			new Logic\Type\Boolean(true),
			new Logic\Type\Boolean(true)
		);
		
		$permission = new Permission('id', $statement);
		
		$permission->setDataProvider(new Logic\DataProvider\Hashmap());
		
	}
	
}

