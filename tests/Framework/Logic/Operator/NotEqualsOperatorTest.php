<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Operator\NotEquals
;

class LogicOpeartorNotEquals_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Operator\NotEquals::execute
	 */
	public function testAll() {
		$operator = new NotEquals();
		$this->assertFalse($operator->execute('1', 1));
		$this->assertFalse($operator->execute('1', '1.00'));
		$this->assertTrue($operator->execute('abc', 123));
	}
	
}

