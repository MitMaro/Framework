<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Type\String,
	\Framework\Logic\Type\Integer,
	\Framework\Logic\Operator\Equals
;

class LogicOpeartorEquals_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Operator\Equals::execute
	 */
	public function testAll() {
		$operator = new Equals();
		$this->assertTrue($operator->execute(new String('1'), new Integer(1)));
		$this->assertTrue($operator->execute(new String('1'), new String('1')));
		$this->assertTrue($operator->execute(new String('123abc'), new Integer(123)));
	}
	
}

