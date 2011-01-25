<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Operator\OrOperator
;

class LogicOpeartorOr_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Operator\OrOperator::execute
	 */
	public function testAll() {
		$operator = new OrOperator();
		$this->assertTrue($operator->execute(true, true));
		$this->assertTrue($operator->execute(true, false));
		$this->assertTrue($operator->execute(false, true));
		$this->assertFalse($operator->execute(false, false));
	}
	
}

