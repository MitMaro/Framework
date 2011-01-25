<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Operator\LessThan
;

class LogicOpeartorLessThan_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Operator\LessThan::execute
	 */
	public function testAll() {
		$operator = new LessThan();
		$this->assertFalse($operator->execute(1, 1));
		$this->assertFalse($operator->execute(2, 1));
		$this->assertTrue($operator->execute(1, 2));
	}
	
}

