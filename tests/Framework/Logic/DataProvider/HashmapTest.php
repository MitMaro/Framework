<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Logic\DataProvider\Hashmap
;

class LogicDataProviderHashmap_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Logic\DataProvider\Hashmap::addVariable
	 * @covers \Framework\Logic\DataProvider\Hashmap::getVariable
	 */
	public function testGetAdd() {
		$data = new Hashmap();
		
		$data->addVariable('abc', 'def');
		
		$this->assertEquals('def', $data->getVariable('abc'));
		$this->assertNull($data->getVariable('ghi'));
	}
}
