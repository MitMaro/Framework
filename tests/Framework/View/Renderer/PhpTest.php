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
	Framework\View\Data\Data,
	Framework\View\Renderer\Php
;

class Php_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\View\Renderer\Php::render
	 */
	public function test_render_full() {
		$renderer = new Php();
		
		$data = new Data();
		
		$data->foo = 'bar';
		
		ob_start();
		$renderer->render(realpath(__DIR__ . '/../../../data/View/template.tmpl'), $data);
		$result = ob_get_clean();
		
		$this->assertEquals('This is some template data. Var: bar', trim($result));
	}
	
	/**
	 * @covers \Framework\View\Renderer\Php::render
	 * @expectedException \Framework\View\Exception\Renderer
	 */
	public function test_render_error() {
		$renderer = new Php();
		
		$renderer->render('does not exist', new Data());
	}
}
