<?php
/**
 * @package  Framework\Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

require_once 'Framework/Request.php';
require_once 'Framework/Request/Exception.php';

use
	\Framework\Request
;

class Request_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Request::addUrlPatterns
	 * @covers \Framework\Request::getUrlPatternMap
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
	 * @covers \Framework\Request::addUrlPatterns
	 * @expectedException \Framework\Request\Exception
	 */
	public function testAddUrlPatterns_invalidPattern() {
		$request = new Request();
		$request->addUrlPatterns(array(false => 'abc.def'));
	}
	
	/**
	 * @covers \Framework\Request::addUrlPatterns
	 * @expectedException \Framework\Request\Exception
	 */
	public function testAddUrlPatterns_invalidHandler() {
		$request = new Request();
		$request->addUrlPatterns(array('abc' => 'abc'));
	}
	
	/**
	 * @covers \Framework\Request::resolveUrl
	 * @expectedException \Framework\Request\Exception
	 */
	public function testResolveUrl_NoUrlNoAutoFind() {
		$request = new Request();
		$request->resolveUrl();
	}
	
	/**
	 * @covers \Framework\Request::resolveUrl
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
	 * @covers \Framework\Request::resolveUrl
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
	 * @covers \Framework\Request::resolveUrl
	 */
	public function testResolveUrl_NoMatch() {
		$request = new Request();
		$request->addUrlPatterns(array('/abc/' => 'abc.def'));
		
		$this->assertFalse($request->resolveUrl('def'));
	}
	
	/**
	 * @covers \Framework\Request::resolveUrl
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
	 * @covers \Framework\Request::setParams
	 * @covers \Framework\Request::getParams
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
	 * @covers \Framework\Request::addParam
	 * @covers \Framework\Request::setParams
	 * @covers \Framework\Request::getParams
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
	 * @covers \Framework\Request::addParam
	 * @covers \Framework\Request::getParam
	 */
	public function testSetParams_GetParamExists() {
		$request = new Request();
		
		$request->addParam('a', '1');
		$this->assertEquals('1', $request->getParam('a'));
	}
	
	/**
	 * @covers \Framework\Request::addParam
	 * @covers \Framework\Request::getParam
	 */
	public function testSetParams_GetParamNotExists() {
		$request = new Request();
		
		$this->assertNull($request->getParam('a'));
		$this->assertEquals('1', $request->getParam('a', '1'));
	}
	
	/**
	 * @covers \Framework\Request::addParam
	 * @covers \Framework\Request::hasParam
	 */
	public function testHasParams() {
		$request = new Request();
		
		$request->addParam('a', '1');
		
		$this->assertTrue($request->hasParam('a'));
		$this->assertFalse($request->hasParam('b'));
	}
	
	/**
	 * @covers \Framework\Request::getReferrer
	 */
	public function testGetReferrer_NotFound() {
		$request = new Request();
		
		$this->assertFalse($request->getReferrer());
		$this->assertEquals('abc', $request->getReferrer('abc'));
		
	}
	
	/**
	 * @covers \Framework\Request::getReferrer
	 */
	public function testGetReferrer_Global() {
		$request = new Request();
		$_SERVER['HTTP_REFERER'] = 'def';
		$this->assertEquals('def', $request->getReferrer());
		
	}
	
	/**
	 * @covers \Framework\Request::isAjax
	 */
	public function testIsAjax_IsNot() {
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'notajax';
		$this->assertFalse(Request::isAjax());
		
	}
	
	/**
	 * @covers \Framework\Request::isAjax
	 */
	public function testIsAjax_Is() {
		$_SERVER['HTTP_X_REQUESTED_WITH'] = 'xmlhttprequest';
		$this->assertTrue(Request::isAjax());
	}
	
}
