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
	Framework\View\View,
	Framework\View\Renderer\RendererInterface,
	Framework\View\Data\Data,
	Framework\View\Data\DataInterface
;

class View_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\View\View::__construct
	 */
	public function test_construct_plain() {
		$view = new View();
	}
	
	/**
	 * @covers \Framework\View\View::__construct
	 */
	public function test_construct_full() {
		
		$view = new View(new TestRenderer(), new Data());
	}
	
	/**
	 * @covers \Framework\View\View::__get
	 * @covers \Framework\View\View::__set
	 */
	public function test_getSet() {
		
		$view = new View();
		$view->foo = 'bar';
		$view->__set('bar', 'foo');
		
		$this->assertEquals('bar', $view->foo);
		$this->assertEquals('bar', $view->__get('foo'));
		
	}
	
	/**
	 * @covers \Framework\View\View::setTemplate
	 * @covers \Framework\View\View::getTemplate
	 */
	public function test_getSetTemplate() {
		$view = new View();
		$view->setTemplate('foobar');
		$this->assertEquals('foobar', $view->getTemplate());
		
	}
	
	/**
	 * @covers \Framework\View\View::setRenderer
	 * @covers \Framework\View\View::getRenderer
	 */
	public function test_getSetRenderer() {
		$view = new View();
		$view->setRenderer(new TestRenderer());
		$this->assertEquals('Framework\Tests\View\TestRenderer', get_class($view->getRenderer()));
		
	}
	
	/**
	 * @covers \Framework\View\View::render
	 * @expectedException \Framework\View\Exception\View
	 */
	public function test_render_nonExistantTemplate() {
		$view = new View();
		$view->render();
	}
	
	/**
	 * @covers \Framework\View\View::render
	 */
	public function test_render_complete() {
		$view = new View(new TestRenderer());
		$view->setTemplate('My Template');
		
		$view->foo = bar;
		
		$view->bar = foo;
		
		$this->assertEquals('My Templatefoobarbarfoo', $view->render());
	}
}


class TestRenderer implements RendererInterface {
	public function render($template, DataInterface $data) {
		
		$data_string = '';
		
		foreach($data->toArray() as $k => $d) {
			$data_string .= $k . $d;
		}
		
		return $template . $data_string;
	}
}
