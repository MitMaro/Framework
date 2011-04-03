<?php
/**
 * @category  Test
 * @package  Framework
 * @subpackage Test
 * @author  Tim Oram <mitmaro@mitmaro.ca>
 * @copyright  Copyright (c) 2010 Tim Oram (http://www.mitmaro.ca)
 * @license    http://www.opensource.org/licenses/mit-license.php  The MIT License
 */

namespace Framework\Tests\View;

use
	Framework\View\Data
;

class Data_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\View\Data::__get
	 * @covers \Framework\View\Data::__set
	 */
	public function test_getSet() {
		$data = new Data();
		
		$data->foo = 'bar';
		$data->__set('bar', 'foo');
		
		$this->assertEquals('bar', $data->foo);
		$this->assertEquals('foo', $data->bar);
	}
	
	/**
	 * @covers \Framework\View\Data::offsetExists
	 */
	public function test_offsetExists() {
		$data = new Data();
		
		$data->foo = 'bar';
		
		$this->assertTrue(isset($data['foo']));
		$this->assertTrue($data->offsetExists('foo'));
	}
	
	/**
	 * @covers \Framework\View\Data::offsetGet
	 */
	public function test_offsetGet() {
		$data = new Data();
		
		$data->foo = 'bar';
		
		$this->assertEquals('bar', $data['foo']);
		$this->assertEquals('bar', $data->offsetGet('foo'));
	}
	
	/**
	 * @covers \Framework\View\Data::offsetUnset
	 */
	public function test_offsetUnset() {
		$data = new Data();
		
		$data->foo = 'bar';
		$data->bar = 'foo';
		
		unset($data['foo']);
		
		$data->offsetUnset('bar');
		
		$this->assertNull($data->foo);
		$this->assertNull($data->bar);
	}
	
	/**
	 * @covers \Framework\View\Data::offsetSet
	 */
	public function test_offsetSet() {
		$data = new Data();
		
		$data['foo'] = 'bar';
		$data->offsetSet('bar', 'foo');
		
		$this->assertEquals('bar', $data->foo);
		$this->assertEquals('foo', $data->bar);
	}
	
	/**
	 * @covers \Framework\View\Data::toArray
	 */
	public function test_toArray() {
		$data = new Data();
		
		$data->foo = 'bar';
		$data->bar = 'foo';
		
		$this->assertEquals(array ('foo' => 'bar', 'bar' => 'foo'), $data->toArray());
	}
	
}
