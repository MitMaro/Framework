<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Type\Boolean,
	\Framework\Logic\Operator\NotOperator
;

class LogicOpeartorNot_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Operator\NotOperator::execute
	 */
	public function testAll() {
		$operator = new NotOperator();
		$this->assertFalse($operator->execute(new Boolean(true), null));
		$this->assertTrue($operator->execute(new Boolean(false), null));
	}
	
}

