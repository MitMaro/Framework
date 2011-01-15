<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Controller,
	\Framework\Request,
	\Framework\View
;

class Controller_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Controller::__construct
	 * @covers \Framework\Controller::getRequest
	 * @covers \Framework\Controller::getView
	 */
	public function testConstruct() {
		$view = new \Framework\View();
		$request = new \Framework\Request();
		
		$controller = new Controller($request, $view);
	}
	
	/**
	 * @covers \Framework\Controller::getRequest
	 * @covers \Framework\Controller::getView
	 */
	public function testGetRequest() {
		$view = new \Framework\View();
		$request = new \Framework\Request();
		
		$controller = new Controller($request, $view);
		
		$this->assertEquals('Framework\Request', get_class($controller->getRequest()));
		$this->assertEquals('Framework\View', get_class($controller->getView()));
	}
	
	/**
	 * @covers \Framework\Controller::_preInit
	 * @covers \Framework\Controller::_init
	 * @covers \Framework\Controller::_postInit
	 * @covers \Framework\Controller::_preAction
	 * @covers \Framework\Controller::_postAction
	 * @covers \Framework\Controller::_preRender
	 * @covers \Framework\Controller::_postRender
	 * @covers \Framework\Controller::_preShutdown
	 * @covers \Framework\Controller::_shutdown
	 * @covers \Framework\Controller::_postShutdown
	 */
	public function testHooks() {
		$this->assertTrue(method_exists('Framework\Controller', '_preInit'));
		$this->assertTrue(method_exists('Framework\Controller', '_init'));
		$this->assertTrue(method_exists('Framework\Controller', '_postInit'));
		$this->assertTrue(method_exists('Framework\Controller', '_preAction'));
		$this->assertTrue(method_exists('Framework\Controller', '_postAction'));
		$this->assertTrue(method_exists('Framework\Controller', '_preRender'));
		$this->assertTrue(method_exists('Framework\Controller', '_postRender'));
		$this->assertTrue(method_exists('Framework\Controller', '_preShutdown'));
		$this->assertTrue(method_exists('Framework\Controller', '_shutdown'));
		$this->assertTrue(method_exists('Framework\Controller', '_postShutdown'));
		
		$view = new \Framework\View();
		$request = new \Framework\Request();
		
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
