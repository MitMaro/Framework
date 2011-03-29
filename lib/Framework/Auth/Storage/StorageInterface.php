<?php
/**
 * @package  Framework\Auth\Storage
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Auth\Storage;

interface StorageInterface {
	
	/**
	 * Returns the contents of storage
	 *
	 * @return mixed
	 */
	public function read();

	/**
	 * Returns true if and only if storage is empty
	 *
	 * @return boolean
	 */
	public function isEmpty();
	
	/**
	 * Writes some data to the storage
	 *
	 * @param mixed $contents
	 */
	public function write($data);

	/**
	 * Clears data from the storage
	 */
	public function clear();
}
