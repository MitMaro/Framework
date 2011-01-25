<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Variable,
	\Framework\Logic\Type\Base
;

class LogicVariable_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Variable::__construct
	 * @covers \Framework\Logic\Variable::evaluate
	 * @covers \Framework\Logic\Variable::getName
	 */
	public function testAll() {
		$data = new Variable('VariableTestType', 'myVariable');
		
		$this->assertEquals(new VariableTestType(5), $data->evaluate(5));
		$this->assertEquals('myVariable', $data->getName());
	}
}

class VariableTestType extends Base {
	public function __construct($value) {
		$this->value = $value;
	}
}
