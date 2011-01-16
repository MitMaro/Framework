<?php
/**
 * @package  Framework
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 * @dependencies
 * <ul>
 *     <li>\Framework\Controller</li>
 *     <li>\Framework\Session (Optional)</li>
 * </ul>
 */

namespace Framework;

class Request {

	/**
	 * An associative array of parameters
	 * @var array
	 */
	protected $params = array();
	
	/**
	 * An associative array of url mappers in the format (pattern => callback)
	 */
	protected $url_maps = array();
	
	/**
	 * Handle a request
	 *
	 * @param string $url (Optional) The request URL, set to override the auto dectection
	 */
	public function beginRequest($url = null) {
		$callback = $this->resolveUrl($url);
		$this->setParams();
		
		if (class_exists('\Framework\Session')) {
			$this->setReferrer($url);
		}
		
		// if a controller object was passed in, use it directly
		if (is_object($callback['handler']['class'])) {
			$class = $callback['handler']['class'];
			$view = $class->getView();
		}
		else {
			$class_name = $callback['handler']['class'];
			$view = new View();
			$class = new $class_name($this, $view);
		}
		
		$method_name = $callback['handler']['method'];
		
		// create the controller, and run
		$class->_preInit();
		$class->_init();
		$class->_postInit();
		$class->_preAction();
		call_user_func_array(array($class, $method_name), $callback['params']);
		$class->_postAction();
		$class->_preRender();
		$class->getView()->render();
		$class->_postRender();
		$class->_preShutdown();
		$class->_shutdown();
		$class->_postShutdown();
	}
	
	/**
	 * Adds patterns to the url pattern mapper
	 *
	 * @param array $patterns An array of key value pairs in the form (pattern => class.method)
	 */
	public function addUrlPatterns($patterns) {
		
		// loop over the array of key value pairs, validating and adding to the url map
		foreach ($patterns as $pattern => $handler) {
			
			// valid pattern
			if (!is_string($pattern)) {
				throw new Request\Exception('The pattern provided is invalid, must be a valid regular expression');
			}
			
			if (is_array($handler)) {
				$parts = $handler;
			}
			else if(is_string($handler)) {
				$parts = explode('.', $handler);
			}
			else {
				throw new Request\Exception('The handler provided is invalid.');
			}
			
			// valid handler
			if (count($parts) != 2) {
				throw new Request\Exception('The handler provided is invalid.');
			}
			$this->url_maps[$pattern] = array('class' => $parts[0], 'method' => $parts[1]);
		}
	}
	
	/**
	 * Get the url patterns
	 *
	 * @return array The url patterns array
	 */
	public function getUrlPatternMap() {
		return $this->url_maps;
	}
	
	/**
	 * Resolve a url to a callable php function
	 *
	 * @param string $url An optional url string, if not provided will 
	 */
	public function resolveUrl($url = false) {
		
		// if no url was provided get it from the _SERVER super global
		if (!$url) {
			if (isset($_SERVER['PATH_INFO'])) {
				$url = $_SERVER['PATH_INFO'];
			}
			else if (isset($_SERVER['REQUEST_URI'])) {
				$url = $_SERVER['REQUEST_URI'];
			}
			else {
				throw new Request\Exception('Was unable to retrive URL from _SERVER super global');
			}
		}
		
		// $params will contain any subpattern matches found in the regular expression
		$params = array();
		foreach ($this->url_maps as $pattern => $handler) {
			if (preg_match($pattern, $url, $params)) {
				unset($params[0]); // remove the global match
				return array('handler' => $handler, 'params' => $params);
			}
		}
		return false;
		
	}
	
	/**
	 * Set the parameters from the request
	 */
	public function setParams() {
		$this->params = array_merge($this->params, $_GET);
		$this->params = array_merge($this->params, $_POST);
	}
	
	/**
	 * Get the parameters of the request
	 *
	 * @return array An array of parameter key-value pairs
	 */
	public function getParams() {
		return $this->params;
	}
	
	/**
	 * Get a single parameter from the request
	 *
	 * @param string $name The key of the parameter
	 * @param string $default (optional) A default value to return, defaults to null
	 *
	 * @return mixed The value associated with the key provided or the default value if key is not found
	 */
	public function getParam($name, $default = null) {
		// check availablity and type
		if (isset($this->params[$name])) {
			return $this->params[$name];
		}
		return $default;
	}
	
	/**
	 * Add a parameter to the list of parameters
	 *
	 * @param string $name The name of the parameter
	 * @param mixed $value The value of the parameter
	 */
	public function addParam($name, $value) {
		$this->params[$name] = $value;
	}
	
	/**
	 * Check is parameter of $name exists
	 *
	 * @param string $name The parameter name
	 *
	 * @return boolean True is the parameter exists, otherwise false
	 */
	public function hasParam($name) {
		return isset($this->params[$name]);
	}
	
	/**
	 * Get the referrer
	 *
	 * @param string $default (optional) The default referrer
	 *
	 * @return string The referrer or the default to if one could not be found and the default was provided, false otherwise.
	 */
	public function getReferrer($default = false) {
		
		// try the one stored by this application first
		
		// merge in pushed over request params when supplied
		if (class_exists('\Framework\Session')) {
			$referrer = Session::getOnce('referrer', false, '__FRAMEWORK__');
			if ($referrer) {
				return $referrer;
			}
		}
		
		if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
			return $_SERVER['HTTP_REFERER'];
		}
		
		return $default;
	}
	
	/**
	 * Sets the referrer
	 *
	 * @param string $url The url of the referrer
	 */
	public function setReferrer($url) {
		// save referreral
		Session::setOnce('referrer', $url, '__FRAMEWORK__');
		
	}
	
	/**
	 * Determine if the request was an ajax based request, this is supported
	 * by all the major libaries, the correct header should be added if using
	 * xmlHttpRequest directly.
	 *
	 * @return boolean True if the request is a AJAX based request, otherwise false
	 */
	public static function isAjax() {
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	}
	
}
