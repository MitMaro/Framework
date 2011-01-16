<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Type\Float
;

class LogicTypeFloat_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Type\Float::__construct
	 */
	public function test__construct() {
		$type = new Float('1');
		$this->assertEquals(1.00, $type->getValue());
		
		$type = new Float(1.00);
		$this->assertEquals(1, $type->getValue());
		
		$type = new Float(1.23);
		$this->assertEquals(1.23, $type->getValue());
		
		$type = new Float('1.56');
		$this->assertEquals(1.56, $type->getValue());
	}
}
