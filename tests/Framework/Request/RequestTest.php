<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Tests\Request;

use
	\Framework\Request\Request,
	\Framework\Controller\Controller,
	\Framework\Session\Session,
	\Framework\View\View
;

class Request_Test extends \PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Request\Request::addUrlPatterns
	 * @covers \Framework\Request\Request::getUrlPatternMap
	 */
	public function testAddUrlPatterns_valid() {
		$request = new Request();
		$request->addUrlPatterns(array('abc' => 'def.ghi'));
		
		$this->assertEquals(
			array('abc' => array('class' => 'def', 'method' => 'ghi')),
			$request->getUrlPatternMap()
		);
		
		$request->addUrlPatterns(array(
			'def' => 'abc2.def',
			'cde' => 'abc.def',
			'abc' => 'abc.def'
		));
		
		$this->assertEquals(
			array(
				'def' => array('class' => 'abc2', 'method' => 'def'),
				'cde' => array('class' => 'abc', 'method' => 'def'),
				'abc' => array('class' => 'abc', 'method' => 'def'),
			),
			$request->getUrlPatternMap()
		);
		
	}
	
	/**
	 * @covers \Framework\Request\Request::addUrlPatterns
	 * @covers \Framework\Request\Request::getUrlPatternMap
	 */
	public function testAddUrlPatterns_validArray() {
		$request = new Request();
		$controller = new TestController($request, new View());
		
		$request->addUrlPatterns(array('abc' => array($controller, 'testAction')));
		
		$this->assertEquals(
			array(
				'abc' => array('class' => $controller, 'method' => 'testAction'),
			),
			$request->getUrlPatternMap()
		);
	}
	
	/**
	 * @covers \Framework\Request\Request::addUrlPatterns
	 * @expectedException \Framework\Request\Exception
	 */
	public function testAddUrlPatterns_invalidPattern() {
		$request = new Request();
		$request->addUrlPatterns(array(false => 'abc.def'));
	}
	
	/**
	 * @covers \Framework\Request\Request::addUrlPatterns
	 * @expectedException \Framework\Request\Exception
	 */
	public function testAddUrlPatterns_invalidHandler() {
		$request = new Request();
		$request->addUrlPatterns(array('abc' => false));
	}
	
	/**
	 * @covers \Framework\Request\Request::addUrlPatterns
	 * @expectedException \Framework\Request\Exception
	 */
	public function testAddUrlPatterns_invalidHandlerString() {
		$request = new Request();
		$request->addUrlPatterns(array('abc' => 'abc'));
	}
	
	/**
	 * @covers \Framework\Request\Request::resolveUrl
	 * @expectedException \Framework\Request\Exception
	 */
	public function testResolveUrl_NoUrlNoAutoFind() {
		$request = new Request();
		$request->resolveUrl();
	}
	
	/**
	 * @covers \Framework\Request\Request::resolveUrl
	 */
	public function testResolveUrl_TestGlobalsPATH_INFO() {
		$request = new Request();
		$request->addUrlPatterns(array('/abc/' => 'abc.def'));
		$_SERVER['PATH_INFO'] = 'abc';
		
		$this->assertEquals(
			array(
				'handler' => array(
					'class' => 'abc',
					'method' => 'def'
				),
				'params' => array()
			),
			$request->resolveUrl()
		);
	}
	
	/**
	 * @covers \Framework\Request\Request::resolveUrl
	 */
	public function testResolveUrl_TestGlobalsREQUEST_URI() {
		$request = new Request();
		$request->addUrlPatterns(array('/def/' => 'abc.def'));
		unset($_SERVER['PATH_INFO']); // to be sure
		$_SERVER['REQUEST_URI'] = 'def';
		
		$this->assertEquals(
			array(
				'handler' => array(
					'class' => 'abc',
					'method' => 'def'
				),
				'params' => array()
			),
			$request->resolveUrl()
		);
	}
	
	/**
	 * @covers \Framework\Request\Request::resolveUrl
	 */
	public function testResolveUrl_NoMatch() {
		$request = new Request();
		$request->addUrlPatterns(array('/abc/' => 'abc.def'));
		
		$this->assertFalse($request->resolveUrl('def'));
	}
	
	/**
	 * @covers \Framework\Request\Request::resolveUrl
	 */
	public function testResolveUrl_Params() {
		$request = new Request();
		$request->addUrlPatterns(array('#abc/(?<id>[0-9]+)#' => 'abc.def'));
		
		
		$this->assertEquals(
			array(
				'handler' => array(
					'class' => 'abc',
					'method' => 'def'
				),
				'params' => array('id' => '12', 1 => '12')
			),
			$request->resolveUrl('abc/12')
		);
	}
	
	/**
	 * @covers \Framework\Request\Request::setParams
	 * @covers \Framework\Request\Request::getParams
	 */
	public function testSetParams_GETOnly() {
		$request = new Request();
		$_GET = array(
			'abc' => 'def'
		);
		$request->setParams();
		$this->assertEquals(
			array(
				'abc' => 'def'
			),
			$request->getParams()
		);
	}
	
	/**
	 * @covers \Framework\Request\Request::addParam
	 * @covers \Framework\Request\Request::setParams
	 * @covers \Framework\Request\Request::getParams
	 */
	public function testSetParams_AddGETAndPOST() {
		$request = new Request();
		$_GET = array(
			'a' => '2',
			'c' => '3',
			'd' => '4'
		);
		$_POST = array(
			'd' => '5',
			'e' => '6'
		);
		$request->addParam('a', '0');
		$request->addParam('b', '1');
		$request->setParams();
		$this->assertEquals(
			array(
				'b' => '1',
				'a' => '2',
				'c' => '3',
				'd' => '5',
				'e' => '6'
			),
			$request->getParams()
		);
	}
	
	/**
	 * @covers \Framework\Request\Request::addParam
	 * @covers \Framework\Request\Request::getParam
	 */
	public function testSetParams_GetParamExists() {
		$request = new Request();
		
		$request->addParam('a', '1');
		$this->assertEquals('1', $request->getParam('a'));
	}
	
	/**
	 * @covers \Framework\Request\Request::addParam
	 * @covers \Framework\Request\Request::getParam
	 */
	public function testSetParams_GetParamNotExists() {
		$request = new Request();
		
		$this->assertNull($request->getParam('a'));
		$this->assertEquals('1', $request->getParam('a', '1'));
	}
	
	/**
	 * @covers \Framework\Request\Request::addParam
	 * @covers \Framework\Request\Request::hasParam
	 */
	public function testHasParams() {
		$request = new Request();
		
		$request->addParam('a', '1');
		
		$this->assertTrue($request->hasParam('a'));
		$this->assertFalse($request->hasParam('b'));
	}
	
	/**
	 * @covers \Framework\Request\Request::getReferrer
	 */
	public function testGetReferrer_NotFound() {
		$request = new Request();
		
		$this->assertFalse($request->getReferrer());
		$this->assertEquals('abc', $request->getReferrer('abc'));
		
	}
	
	/**
	 * @covers \Framework\Request\Request::getReferrer
	 */
	public function testGetReferrer_Global() {
		$request = new Request();
		$_SERVER['HTTP_REFERER'] = 'def';
		$this->assertEquals('def', $request->getReferrer());
		
	}
	
	/**
	 * @covers \Framework\Request\Request::getReferrer
	 * @covers \Framework\Request\Request::setReferrer
	 */
	public function testSetReferrerGetReferrer_Session() {
		Session::close();
		Session::init();
		$request = new Request();
		$request->setReferrer('unittest referrer');
		Session::close();
		Session::init();
		$this->assertEquals(
			'unittest referrer',
			$request->getReferrer()
		);
		
	}
	
	/**
	 * @covers \Framework\Request\Request::isAjax
	 */
	public function testIsAjax_IsNot() {
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'notajax';
		$this->assertFalse(Request::isAjax());
		
	}
	
	/**
	 * @covers \Framework\Request\Request::isAjax
	 */
	public function testIsAjax_Is() {
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'xmlhttprequest';
		$this->assertTrue(Request::isAjax());
	}
	
	/**
	 * @covers \Framework\Request\Request::beginRequest
	 */
	public function testBeginRequest_FullMock() {
		$request = new Request();
		$view = $this->getMock('\Framework\View\View', array('render'));
		$controller = $this->getMock(
			'\Framework\Tests\Request\TestController',
			array(
				'_preInit',
				'_init',
				'_postInit',
				'_preAction',
				'testAction',
				'_postAction',
				'_preRender',
				'_postRender',
				'_preShutdown',
				'_shutdown',
				'_postShutdown'
			),
			array(&$request, &$view)
		);
		$controller->expects($this->once())->method('_preInit');
		$controller->expects($this->once())->method('_init');
		$controller->expects($this->once())->method('_postInit');
		$controller->expects($this->once())->method('_preAction');
		$controller->expects($this->once())->method('testAction');
		$controller->expects($this->once())->method('_postAction');
		$controller->expects($this->once())->method('_preRender');
		$controller->expects($this->once())->method('_postRender');
		$controller->expects($this->once())->method('_preShutdown');
		$controller->expects($this->once())->method('_shutdown');
		$controller->expects($this->once())->method('_postShutdown');
		$view->expects($this->once())->method('render');
			
		$request->addUrlPatterns(array('/abc/' => array($controller, 'testAction')));
		
		$request->beginRequest('abc');
	}
	
	/**
	 * @covers \Framework\Request\Request::beginRequest
	 */
	public function testBeginRequest_ConstructClass() {
		$request = new Request();
		$request->addUrlPatterns(array('/abc/' => '\Framework\Tests\Request\TestController.testAction'));
		$request->beginRequest('abc');
	}
	
}

class TestController extends Controller {
	
	public function testAction() {
		$this->getView()->setTemplate(realpath(__DIR__ . '/../../data/Request/template.tmpl'));
	}
}
