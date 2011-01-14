<?php
/**
 * @category  Autoloader
 * @package  Framework
 * @subpackage Autoloader
 * @version  0.1.0
 * @author  Tim Oram <mitmaro@mitmaro.ca>
 * @copyright  Copyright (c) 2010 Tim Oram (http://www.mitmaro.ca)
 * @license    http://www.opensource.org/licenses/mit-license.php  The MIT License
 */

namespace Framework;

class Autoloader {
	
	/**
	 * An array of namespaces, directories key value pairs
	 * @var array
	 */
	protected $namespaces = array();
	
	/**
	 * Loads framework classes
	 *
	 * @param string $class The class name
	 */
	public function classLoader($class) {
		
		$namespace = explode('\\', trim($class, '\\'));
		$file = array_pop($namespace) . '.php';
		
		$path = '';
		
		$top = array_shift($namespace);
		
		if (array_key_exists($top, $this->namespaces)) {
			foreach ($this->namespaces[$top] as $path) {
				
				// look for replace tokens (ie. :1, :2, :3)
				if (preg_match_all('#:[0-9]+#', $path, $matches) > 0) {
					// for all the matches found replace the number of the token with the values
					// of the namespace at that index
					foreach ($matches[0] as $m) {
						if (isset($namespace[(int)trim($m, ':') - 1])) {
							$path = str_replace($m, $namespace[(int)trim($m, ':') - 1], $path);
						}
					}
				}
				// no matches assume, default to doing a simple implode
				else if (count($namespace) > 0) {
					$path = $path . implode('/', $namespace) . '/';
				}
				
				// load the file above if it exists
				if (self::fileExists($path . $file)) {
					include $path . $file;
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	 * Adds a namespace, directory key value pair
	 *
	 * @param String $namespace The namespace to handle
	 * @param String $directory The directory to add
	 */
	public function addNamespace($namespace, $directory) {
		if (!isset($this->namespaces[(string)$namespace])) {
			$this->namespaces[(string)$namespace] = array();
		}
		$this->namespaces[(string)$namespace][] = rtrim($directory, '/') . '/';
	}
	
	/**
	 * Clears all directories on a namespace
	 *
	 * @param String $namespace The namespace to handle
	 */
	public function clearNamespace($namespace) {
		unset($this->namespaces[(string)$namespace]);
	}
	
	/**
	 * Returns the namespace map array
	 *
	 * @return array The namespace map array
	 */
	public function getNamespaceMap() {
		return $this->namespaces;
	}
	
	/**
	 * Check if a file can be found on the include path
	 *
	 * @param string $file A file with an optional path
	 *
	 * @return boolean True is file found, otherwise false
	 * 
	 */
	public static function fileExists($file) {
		// catch paths that don't require the include path (ie. absolute path)
		if (is_file($file)) {
			return true;
		}
		foreach(explode(PATH_SEPARATOR, get_include_path()) as $path) {
			if (is_file($path . '/' . $file)) {
				return true;
			}
		}
		return false;
	}
	
}
