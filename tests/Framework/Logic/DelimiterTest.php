<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\Delimiter
;

class LogicDelimiter_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\Delimiter::__construct
	 * @covers \Framework\Logic\Delimiter::getDelimiterString
	 */
	public function test_construct() {
		$delimiter = new Delimiter('%');
		
		$this->assertEquals('%', $delimiter->getDelimiterString());
	}
}
