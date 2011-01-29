<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Type\Boolean
;

class LogicTypeBoolean_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Type\Boolean::__construct
	 */
	public function test__construct() {
		$type = new Boolean(true);
		$this->assertTrue($type->getValue());
		
		$type = new Boolean(1);
		$this->assertTrue($type->getValue());
		
		$type = new Boolean('true');
		$this->assertTrue($type->getValue());
		
		$type = new Boolean(false);
		$this->assertFalse($type->getValue());
		
		$type = new Boolean(0);
		$this->assertFalse($type->getValue());
		
		$type = new Boolean('false');
		$this->assertFalse($type->getValue());
	}
}
