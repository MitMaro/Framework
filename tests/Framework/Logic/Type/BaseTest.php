<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Type\Base
;

class LogicTypeBase_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Type\Base::__construct
	 * @covers \Framework\Logic\Type\Base::getValue
	 * @covers \Framework\Logic\Type\Base::evaluate
	 */
	public function test__construct() {
		$type = new MyType('abc');
		$this->assertEquals('abc', $type->getValue());
		$this->assertEquals('abc', $type->evaluate());
	}
}

class MyType extends Base {
	public function __construct($value) {
		$this->value = $value;
	}
}
