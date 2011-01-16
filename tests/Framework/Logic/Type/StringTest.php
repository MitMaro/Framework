<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Type\String
;

class LogicTypeString_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Type\String::__construct
	 */
	public function test__construct() {
		$type = new String('abc');
		$this->assertEquals('abc', $type->getValue());
		
		$type = new String(1.00);
		$this->assertEquals('1.00', $type->getValue());
		
		$type = new String(3);
		$this->assertEquals('3', $type->getValue());
	}
}
