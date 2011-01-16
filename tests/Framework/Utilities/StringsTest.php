<?php
/**
 * @package  Framework/Test
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2011 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

use
	\Framework\Utilities\Strings
;

class UtilitiesStrings_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \Framework\Utilities\Strings::startsWith
	 */
	public function teststartsWith() {
	}
	/**
	 * @covers \Framework\Utilities\Strings::endsWith
	 */
	public function test_endsWith_MatchCaseSensitive()
	{
		$this->assertTrue(Strings::endsWith("abcdefgh", "fgh"));
	}
	
	/**
	 * @covers \Framework\Utilities\Strings::endsWith
	 */
	public function test_endsWith_NoMatchCaseSensitive()
	{
		$this->assertFalse(Strings::endsWith("abcdefgh", "fGh"));
	}
	/**
	 * @covers \Framework\Utilities\Strings::endsWith
	 */
	public function test_endsWith_MatchCaseInsensitive()
	{
		$this->assertTrue(Strings::endsWith("abcdefgh", "fGh", true));
	}
	
	/**
	 * @covers \Framework\Utilities\Strings::endsWith
	 */
	public function test_endsWith_NoMatchCaseInsensitive()
	{
		$this->assertFalse(Strings::endsWith("abcdefgh", "fghI", true));
	}
	
	
	/**
	 * @covers \Framework\Utilities\Strings::startsWith
	 */
	public function test_startsWith_MatchCaseSensitive()
	{
		$this->assertTrue(Strings::startsWith("abcdefgh", "abc"));
	}
	
	/**
	 * @covers \Framework\Utilities\Strings::startsWith
	 */
	public function test_startsWith_NoMatchCaseSensitive()
	{
		$this->assertFalse(Strings::startsWith("abcdefgh", "aBc"));
	}
	/**
	 * @covers \Framework\Utilities\Strings::startsWith
	 */
	public function test_startsWith_MatchCaseInsensitive()
	{
		$this->assertTrue(Strings::startsWith("abcdefgh", "aBc", true));
	}
	
	/**
	 * @covers \Framework\Utilities\Strings::startsWith
	 */
	public function test_startsWith_NoMatchCaseInsensitive()
	{
		$this->assertFalse(Strings::startsWith("abcdefgh", "zAbc", true));
	}
	
	/**
	 * @covers \Framework\Utilities\Strings::random
	 */
	public function test_random_NoChars()
	{
		$this->assertEquals(5, strlen(Strings::random(5)));
	}
	
	/**
	 * @covers \Framework\Utilities\Strings::random
	 */
	public function test_random_Chars()
	{
		$word = Strings::random(5, array('a'));
		$this->assertEquals('a', $word[0]);
		$this->assertEquals('a', $word[1]);
		$this->assertEquals('a', $word[2]);
		$this->assertEquals('a', $word[3]);
		$this->assertEquals('a', $word[4]);
		
	}
}
