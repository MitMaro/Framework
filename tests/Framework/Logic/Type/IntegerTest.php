<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Type\Integer
;

class LogicTypeInteger_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Type\Integer::__construct
	 */
	public function test__construct() {
		$type = new Integer('1');
		$this->assertEquals(1, $type->getValue());
		
		$type = new Integer(1);
		$this->assertEquals(1, $type->getValue());
		
		$type = new Integer(1.23);
		$this->assertEquals(1, $type->getValue());
		
		$type = new Integer(1.56);
		$this->assertEquals(1, $type->getValue());
		
		$type = new Integer('1.56');
		$this->assertEquals(1, $type->getValue());
	}
}
