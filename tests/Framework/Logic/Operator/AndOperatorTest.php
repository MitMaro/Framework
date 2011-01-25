<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Operator\AndOperator
;

class LogicOpeartorAnd_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Operator\AndOperator::execute
	 */
	public function testAll() {
		$operator = new AndOperator();
		
		$this->assertTrue($operator->execute(true, true));
		$this->assertFalse($operator->execute(true, false));
		$this->assertFalse($operator->execute(false, true));
		$this->assertFalse($operator->execute(false, false));
	}
	
}

