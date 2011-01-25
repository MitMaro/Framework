<?php
/**
 * @package  Framework\Logic
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http:/ /www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Logic;

interface DataProviderInterface {
	
	/**
	 * Get the value associated with the name provided
	 *
	 * @param mixed $name The name
	 * @return mixed The value
	 */
	public function getVariable($name);
	
}
