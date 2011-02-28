<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\AccessControl\Assertion\Logic;

use
	\Framework\AccessControl\Assertion\Logic\Statement,
	\Framework\AccessControl\Logic\Permission,
	\Framework\Logic
;

class Statement_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\AccessControl\Assertion\Logic\Statement::assert
	 */
	public function testAssert() {
		
		$assertion = new Statement();
		
		$data = new Logic\DataProvider\Hashmap();
		$data->addVariable('a', true);
		$data->addVariable('b', true);
		
		$statement = new Logic\Statement(
			new Logic\Operator\AndOperator(),
			new Logic\Variable('\Framework\Logic\Type\Boolean', 'a'),
			new Logic\Variable('\Framework\Logic\Type\Boolean', 'b'),
			$data
		);
		
		$permission = new Permission('id', $statement);
		
		$this->assertTrue($assertion->assert(null, $permission));
	}
}
