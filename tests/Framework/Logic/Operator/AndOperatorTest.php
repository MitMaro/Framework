<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Type\Boolean,
	\Framework\Logic\Operator\AndOperator
;

class LogicOpeartorAnd_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Operator\AndOperator::execute
	 */
	public function testAll() {
		$operator = new AndOperator();
		$this->assertTrue($operator->execute(new Boolean(true), new Boolean(true)));
		$this->assertFalse($operator->execute(new Boolean(true), new Boolean(false)));
		$this->assertFalse($operator->execute(new Boolean(false), new Boolean(true)));
		$this->assertFalse($operator->execute(new Boolean(false), new Boolean(false)));
	}
	
}

