<?php
/**
 * @package  Framework
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Utilities;

class Strings {
	
	/**
	 * Check if the haystack string begins with the needle
	 *
	 * @param string $haystack The string to search in
	 * @param string $needle The string to search for
	 * @param boolean $caseInsensitive If true do a case insensitive search
	 */
	public static function startsWith($haystack, $needle, $caseInsensitive = false) {
		// if doing case-insensitive
		if ($caseInsensitive){
			return (strcasecmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
		}
		return (strcmp(substr($haystack, 0, strlen($needle)), $needle) === 0);
	}
	
	/**
	 * Check if the haystack string ends with the needle
	 *
	 * @param string $haystack The string to search in
	 * @param string $needle The string to search for
	 * @param boolean $caseInsensitive If true do a case insensitive search
	 */
	public static function endsWith($haystack, $needle, $caseInsensitive = false) {
		// if doing case-insensitive
		if ($caseInsensitive){
			return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
		}
		return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)), $needle) === 0);
	}
	
	/**
	 * Generates a random string
	 *
	 * @param integer $length The length of the generated string
	 * @param array $chars (Optional) An array of allowed characters
	 */
	public static function random($length, $chars = null) {
		if ($chars == null) {
			$chars = array(
				'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p',
				'q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F',
				'G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V',
				'W','X','Y','Z','0','1','2','3','4','5','6','7','8','9'
			);
		}
		
		$chars_max = count($chars) - 1;
		$str = '';
		for ($i = 0; $i < $length; $i++) {
			$str .= $chars[rand(0, $chars_max)];
		}
		return $str;
	}
}
