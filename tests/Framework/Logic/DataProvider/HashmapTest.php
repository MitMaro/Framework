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
	public function testGetAddVaraible() {
		$data = new Hashmap();
		
		$data->addVariable('abc', 'def');
		
		$this->assertEquals('def', $data->getVariable('abc'));
		$this->assertNull($data->getVariable('ghi'));
	}
	
	/**
	 * @covers \Framework\Logic\DataProvider\Hashmap::getVariables
	 */
	public function testGetVaraibles() {
		$data = new Hashmap();
		
		$data->addVariable('abc', 'def');
		$data->addVariable('ghi', 'jkl');
		
		$result = array (
			'abc' => 'def',
			'ghi' => 'jkl'
		);
		
		$this->assertEquals($result, $data->getVariables());
	}
	
	/**
	 * @covers \Framework\Logic\DataProvider\Hashmap::offsetGet
	 * @covers \Framework\Logic\DataProvider\Hashmap::offsetSet
	 */
	public function testArrayAccessGetSet() {
		$data = new Hashmap();
		
		$data['abc'] = 'def';
		
		$this->assertEquals('def', $data['abc']);
	}
	
	/**
	 * @covers \Framework\Logic\DataProvider\Hashmap::offsetExists
	 */
	public function testArrayAccessExists() {
		$data = new Hashmap();
		
		$data['abc'] = 'def';
		
		$this->assertTrue(isset($data['abc']));
		$this->assertFalse(isset($data['def']));
	}
	
	/**
	 * @covers \Framework\Logic\DataProvider\Hashmap::offsetUnset
	 */
	public function testArrayAccessUnset() {
		$data = new Hashmap();
		
		$data['abc'] = 'def';
		
		unset($data['abc']);
		
		$this->assertEquals(null, $data['abc']);
		
	}
	
	/**
	 * @covers \Framework\Logic\DataProvider\Hashmap::merge
	 */
	public function testMerge() {
		$data = new Hashmap();
		$data['a'] = 'z';
		$data['b'] = 'y';
		
		$data2 = new Hashmap();
		$data2['b'] = 'x';
		$data2['c'] = 'w';
		
		$data->merge($data2);
		
		$results = array (
			'a' => 'z',
			'b' => 'x',
			'c' => 'w'
		);
		
		$this->assertEquals($results, $data->getVariables());
		
	}
}
