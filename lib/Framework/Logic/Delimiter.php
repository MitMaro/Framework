<?php
/**
 * @package  Framework\Logic
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Logic;

class Delimiter {
	
	/**
	 * The delimiter string
	 *
	 * @var string
	 */
	protected $delimiter;
	
	/**
	 * Create a delimter
	 *
	 * @param string The delimiter value
	 */
	public function __construct($delimiter) {
		$this->delimiter = $delimiter;
	}
	
	/**
	 * Get the delimiter string
	 *
	 * @return string The delimiter string
	 */
	public function getDelimiterString() {
		return $this->delimiter;
	}
}
