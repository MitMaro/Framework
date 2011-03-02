<?php
/**
 * A simple yet powerful namespace based autoloader for php.
 *
 *
 * <h4>Basic Usage</h4>
 * The most basic usage of the autoloader is to map a namespace to a directory like so:
 * 
 * <pre>
 *     $autoloader = new \Framework\Autoloader();
 *     $autoloader->addNamespace('MyNameSpace', '/path/to/namespace/root/')
 * </pre>
 *
 * This will autoload all classes that begin with the namespace MyNameSpace to that directory using
 * the remainder of the namespace to figure out the path. That is, using the autoloader setup from
 * above, the class '\MyNameSpace\Admin\User' would map to '/path/to/namespace/root/Admin/User.php'.
 *
 * <h4>Mutltiple Directories Per Namespace</h4>
 * It is possible to add mulitple directories to a namespace by calling the addNamespace method
 * on the same name space more than once. For example:
 * 
 * <pre>
 *     $autoloader = new \Framework\Autoloader();
 *     $autoloader->addNamespace('MyNameSpace', '/path/to/namespace/root/')
 *     $autoloader->addNamespace('MyNameSpace', '/second/path/to/namespace/root/')
 * </pre>
 *
 * Using this setup the autoloader will first look into the first directory provided and if it is
 * unable to find the file it will move on to the next directory.
 *
 *
 * <h4>Advanced Usage: Patterns</h4>
 * Another way to use the autoloader is by using the simple pattern matching system. You provide
 * tokens in the path when you register the namespace that will be replaced using values from the
 * class namespace. Here is an example that explains the power of this system.
 *
 * Assume you have a directory structure like this:
 * 
 * <pre>
 *   | MyProject
 *   |    -> modules
 *   |       -> Admin
 *   |           -> controllers
 *   |                 -> Home.php           (class: \MyProject\Admin\Home)
 *   |                 -> AccessControl.php  (class: \MyProject\Admin\AccessControl)
 * </pre>
 *
 * Lets assume you want to autoload the controllers in the modules folder. We know that the basic
 * autoloader would not work because the controllers folder is not in the namespace, that is the
 * namespace is not like '\MyProject\Admin\controllers\Home'. To overcome this problem you can write
 * a pattern to auto add the controllers directory dynamically.
 * 
 * <pre>
 *     $autoloader = new \Framework\Autoloader();
 *     $autoloader->addNamespace('MyProject', '/path/to/MyProject/modules/:1/controllers/')
 * </pre>
 *
 * If you now tried to autoload the \MyProject\Admin\AccessControl is would now map to the directory
 * '/path/to/MyProject/modules/Admin/controllers/AccessControl.php' instead of
 * '/path/to/MyProject/modules/Admin/AccessControl.php'.
 * 
 * @package  Framework\AccessControl
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
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
