<?php
/**
 * <h4>Session Handling Class</h4>
 *
 * Sessions can be a bit of a pain to handle as arrays, this class gives access to the _SESSION
 * super global through a class interface. This class is entirely static due to the global nature
 * of the sessions in PHP.
 *
 * <h4>Once Variables</h4>
 * This class has the notion of once variables. That is variables that are stored in the session
 * until the end of the next session (page load). To do this the class uses a singleton-like pattern
 * to take advantage of the __destruct functionality.
 * 
 * @package  Framework\Session
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */
namespace Framework\Session;

class Session {
	
	/**
	 * Contains the once variables, that is variables that will be kept around for one extra request
	 * @var array
	 */
	private $once_variables;
	
	/**
	 * This class uses an internal Singleton to hook into the __destruct
	 * @var Session
	 */
	private static $instance;
	
	/**
	 * The namespace name
	 * @var string
	 */
	private static $namespace = "__global_namespace__";
	
	// this is a singleton-like class
	private function __construct() {}
	
	/**
	 * Starts the session, create a session object as well as perform any other initilizing task.
	 */
	public static function init() {
		if (!self::$instance instanceof Session) {
			session_start();
			self::$instance = new Session();
			
			// the namespace session place
			self::$instance->once_variables = array();
		}
	}
	
	/**
	 * Reset the application session
	 */
	public static function reset() {
		self::init();
		self::$instance->once_variables = array();
		$_SESSION[self::$namespace] = array();
	}
	
	/**
	 * Set a value in the session
	 *
	 * @param string $key The name of the value to assign
	 * @param mixed $value The value
	 * @param string $namespace (Optional) A namespace name, use to stop key clashes
	 */
	public static function set($key, $value, $namespace = '__namespace__') {
		self::init();
		if (!isset($_SESSION[self::$namespace][$namespace])) {
			$_SESSION[self::$namespace][$namespace] = array();
		}
		
		if ($key == null) {
			$_SESSION[self::$namespace][$namespace][] = $value;
		}
		else{
			$_SESSION[self::$namespace][$namespace][$key] = $value;
		}
	}
	
	/**
	 * Sets a one time variable, this variable will stick around for one extra
	 * session only (ie. the next page view)
	 *
	 * @param string $key The name of the value to assign
	 * @param mixed $value The value
	 * @param string $namespace (Optional) A namespace name, use to stop key clashes
	 */
	public static function setOnce($key, $value, $namespace = '__namespace__') {
		self::init();
		if (!isset(self::$instance->once_variables[$namespace])) {
			self::$instance->once_variables[$namespace] = array();
		}
		if ($key == null) {
			self::$instance->once_variables[$namespace][] = $value;
		}
		else {
			self::$instance->once_variables[$namespace][$key] = $value;
		}
	}
	
	/**
	 * Gets a value saved into the session
	 * 
	 * @param string $key The name of the value to retrieve
	 * @param mixed $default (Optional) A value to return if the request key does not exist
	 * @param string $namespace (Optional) A namespace name
	 *
	 * @return mixed The value for the key requested, the default value if the key was not found
	 *               and a default was given, else null 
	 */
	public static function get($key, $default = null, $namespace = '__namespace__') {
		self::init();
		// handle default values
		if (!is_null($default) && !isset($_SESSION[self::$namespace][$namespace][$key])) {
			return $default;
		}
		return $_SESSION[self::$namespace][$namespace][$key];
	}
	
	/**
	 * Gets a variable saved as a one time variable in the previous session
	 * 
	 * @param string $key The name of the value to retrieve
	 * @param mixed $default (Optional) A value to return if the request key does not exist
	 * @param string $namespace (Optional) A namespace name
	 *
	 * @return mixed The value for the key requested, the default value if the key was not found
	 *               and a default was given, else null 
	 */
	public static function getOnce($key, $default = null, $namespace = '__namespace__') {
		self::init();
		// handle default values
		if (!is_null($default) && !isset($_SESSION[self::$namespace]['__once__'][$namespace][$key])) {
			return $default;
		}
		return $_SESSION[self::$namespace]['__once__'][$namespace][$key];
	}
	
	/**
	 * Gets all values saved in the session
	 *
	 * @param string $namespace (Optional) A namespace
	 *
	 * @return array An array of key-value pairs
	 */
	public static function getAllValues($namespace = '__namespace__') {
		self::init();
		// handle default values
		if (isset($_SESSION[self::$namespace][$namespace])) {
			return $_SESSION[self::$namespace][$namespace];
		}
		return null;
	}
	
	/**
	 * Gets all once values saved in the session
	 *
	 * @param string $namespace (Optional) A namespace
	 *
	 * @return array An array of key-value pairs
	 */
	public static function getAllOnceValues($namespace = '__namespace__') {
		self::init();
		// handle default values
		if (isset($_SESSION[self::$namespace]['__once__'][$namespace])) {
			return $_SESSION[self::$namespace]['__once__'][$namespace];
		}
		return null;
	}
	
	/**
	 * Pushes this sessions once variables over to the next session
	 */
	public static function pushOnce() {
		self::init();
		foreach($_SESSION[self::$namespace]['__once__'] as $namespace => $values) {
			foreach($values as $key => $value) {
				self::setOnce($key, $value, $namespace);
			}
		}
	}
	
	/**
	 * Sets the global (application) session namespace
	 *
	 * @param $namespace The new name of the namespace
	 */
	public static function setNamespace($namespace) {
		self::$namespace = (string)$namespace;
	}
	
	/**
	 * Gets the global (application) session namespace
	 *
	 * @param $namespace The new name of the namespace
	 */
	public static function getNamespace() {
		return self::$namespace;
	}
	
	/**
	 * Closes the session, this method is safe to call is no session is started
	 */
	public static function close() {
		if (self::$instance instanceof Session) {
			self::$instance->__destruct();
		}
	}
	
	/**
	 * Saves the once variables into the session at script end
	 */
	public function __destruct() {
		if (self::$instance instanceof Session) {
			$_SESSION[self::$namespace]['__once__'] = self::$instance->once_variables;
			self::$instance = null;
		}

		session_write_close();
		$_SESSION[self::$namespace] = array();
	}
	
}

