<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\Controller;

use
	\Framework\Controller\Controller,
	\Framework\Request\Request,
	\Framework\View\View
;

class Controller_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Controller\Controller::__construct
	 * @covers \Framework\Controller\Controller::getRequest
	 * @covers \Framework\Controller\Controller::getView
	 */
	public function testConstruct() {
		$view = new View();
		$request = new Request();
		
		$controller = new Controller($request, $view);
	}
	
	/**
	 * @covers \Framework\Controller\Controller::getRequest
	 * @covers \Framework\Controller\Controller::getView
	 */
	public function testGetRequest() {
		$view = new View();
		$request = new Request();
		
		$controller = new Controller($request, $view);
		
		$this->assertEquals('Framework\Request\Request', get_class($controller->getRequest()));
		$this->assertEquals('Framework\View\View', get_class($controller->getView()));
	}
	
	/**
	 * @covers \Framework\Controller\Controller::_preInit
	 * @covers \Framework\Controller\Controller::_init
	 * @covers \Framework\Controller\Controller::_postInit
	 * @covers \Framework\Controller\Controller::_preAction
	 * @covers \Framework\Controller\Controller::_postAction
	 * @covers \Framework\Controller\Controller::_preRender
	 * @covers \Framework\Controller\Controller::_postRender
	 * @covers \Framework\Controller\Controller::_preShutdown
	 * @covers \Framework\Controller\Controller::_shutdown
	 * @covers \Framework\Controller\Controller::_postShutdown
	 */
	public function testHooks() {
		$this->assertTrue(method_exists('Framework\Controller\Controller', '_preInit'));
		$this->assertTrue(method_exists('Framework\Controller\Controller', '_init'));
		$this->assertTrue(method_exists('Framework\Controller\Controller', '_postInit'));
		$this->assertTrue(method_exists('Framework\Controller\Controller', '_preAction'));
		$this->assertTrue(method_exists('Framework\Controller\Controller', '_postAction'));
		$this->assertTrue(method_exists('Framework\Controller\Controller', '_preRender'));
		$this->assertTrue(method_exists('Framework\Controller\Controller', '_postRender'));
		$this->assertTrue(method_exists('Framework\Controller\Controller', '_preShutdown'));
		$this->assertTrue(method_exists('Framework\Controller\Controller', '_shutdown'));
		$this->assertTrue(method_exists('Framework\Controller\Controller', '_postShutdown'));
		
		$view = new View();
		$request = new Request();
		
		$controller = new Controller($request, $view);
		
		// just need to make sure these eixsts
		$controller->_preInit();
		$controller->_init();
		$controller->_postInit();
		$controller->_preAction();
		$controller->_postAction();
		$controller->_preRender();
		$controller->_postRender();
		$controller->_preShutdown();
		$controller->_shutdown();
		$controller->_postShutdown();
	}
	
}
