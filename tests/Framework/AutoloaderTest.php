<?php
/**
 * @category  Test
 * @package  Framework
 * @subpackage Test
 * @author  Tim Oram <mitmaro@mitmaro.ca>
 * @copyright  Copyright (c) 2010 Tim Oram (http://www.mitmaro.ca)
 * @license    http://www.opensource.org/licenses/mit-license.php  The MIT License
 */

use
	\Framework\Autoloader
;

class Autoloader_Test extends PHPUnit_Framework_TestCase {
	
	public function setUp() {
		$this->autoloader = new Autoloader();
		$this->autoloader->addNamespace(
			'UnitTesting',
			realpath(__DIR__ . '/../data/autoloader/UnitTesting/')
		);
		$this->autoloader->addNamespace(
			'UnitTesting',
			realpath(__DIR__ . '/../data/autoloader/UnitTesting') . '/:2/:1'
		);
	}
	
	/**
	 * @covers \Framework\Autoloader::fileExists
	 */
	public function testFileExists_True() {
		$oldPath = get_include_path();
		set_include_path(realpath(dirname(__FILE__) . '/../data/autoloader'));
		$this->assertTrue(Autoloader::fileExists('/TestFile.php')); // with path
		set_include_path($oldPath);
		
		$path = realpath(__DIR__ . '/../data/autoloader/UnitTesting/');
		$this->assertTrue(Autoloader::fileExists($path . '/TestClass.php')); // no path
		
	}
	
	/**
	 * @covers \Framework\Autoloader::fileExists
	 */
	public function testFileExists_False() {
		$this->assertFalse(Autoloader::fileExists('NotAFile.php'));
	}
	
	/**
	 * @covers \Framework\Autoloader::classLoader
	 */
	public function testClassLoader_NotHandledNamespace() {
		$this->assertFalse($this->autoloader->classLoader('\NotHandled\TestClass'));
	}
	
	/**
	 * @covers \Framework\Autoloader::classLoader
	 */
	public function testClassLoader_Top() {
		$this->assertTrue($this->autoloader->classLoader('\UnitTesting\TestClass'));
	}
	
	/**
	 * @covers \Framework\Autoloader::classLoader
	 */
	public function testClassLoader_Nested() {
		$this->assertTrue($this->autoloader->classLoader('\UnitTesting\Folder\TestClass2'));
	}
	
	/**
	 * @covers \Framework\Autoloader::classLoader
	 */
	public function testClassLoader_Pattern() {
		$this->assertTrue($this->autoloader->classLoader('\UnitTesting\NS1\NS2\TestClass3'));
	}
	
	/**
	 * @covers \Framework\Autoloader::classLoader
	 */
	public function testClassLoader_SkipNonFramework() {
		$this->assertFalse($this->autoloader->classLoader('NOT_A_CLASS\UnitTesting\TestClass'));
	}
	
	/**
	 * @covers \Framework\Autoloader::addNamespace
	 * @covers \Framework\Autoloader::clearNamespace
	 * @covers \Framework\Autoloader::getNamespaceMap
	 */
	public function testAddClearGetNamespaceMap() {
		$autoloader = new Autoloader();
		$autoloader->addNamespace('a', '1');
		$autoloader->addNamespace('a', '2');
		$autoloader->addNamespace('b', '3');
		$autoloader->addNamespace('b', '4');
		$this->assertEquals(
			array('a' => array ('1/', '2/'), 'b' => array ('3/', '4/')),
			$autoloader->getNamespaceMap()
		);
		$autoloader->clearNamespace('a');
		$this->assertEquals(
			array('b' => array ('3/', '4/')),
			$autoloader->getNamespaceMap()
		);
	}
	
}
