<?php
/**
 * @package  Framework\Auth\Adapter
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Auth\Adapter;

interface AdapterInterface {
	/**
	 * Performs an authentication attempt
	 *
	 * @return Framework\Auth\Result
	 */
	public function authenticate();
}
