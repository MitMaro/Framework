<?php
/**
 * @category  Test
 * @package  Framework
 * @subpackage Test
 * @author  Tim Oram <mitmaro@mitmaro.ca>
 * @copyright  Copyright (c) 2010 Tim Oram (http://www.mitmaro.ca)
 * @license    http://www.opensource.org/licenses/mit-license.php  The MIT License
 */

namespace Framework\Tests\View\Renderer;

use
	Framework\View\Data\DwooData,
	Framework\View\Renderer\Dwoo
;

require_once realpath( __DIR__ . '/../Mocks/Dwoo.php');
require_once realpath( __DIR__ . '/../Mocks/DwooData.php');

class Dwoo_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\View\Renderer\Dwoo::render
	 */
	public function test_render() {
		$renderer = new Dwoo();
		
		$data = new DwooData();
		
		$data->foo = 'bar';
		
		$result = $renderer->render('FOO:BAR', $data);
		
		$this->assertEquals('FOO:BARfoobar', trim($result));
	}
	
	/**
	 * @covers \Framework\View\Renderer\Dwoo::__construct
	 */
	public function test_construct_basic() {
		$renderer = new Dwoo();
	}
	
	/**
	 * @covers \Framework\View\Renderer\Dwoo::__construct
	 */
	public function test_construct_full() {
		$renderer = new Dwoo(new \Dwoo());
	}
	
}
