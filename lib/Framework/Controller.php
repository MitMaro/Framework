<?php
/**
 * @package  Framework
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 * @dependencies
 * <ul>
 *     <li>\Framework\Request</li>
 *     <li>\Framework\View</li>
 * </ul>
 */

namespace Framework;

class Controller {
	
	/**
	 * The request object attached to this controller
	 * @var Request
	 */
	protected $request;
	
	/**
	 * The view object associated with this controller
	 * @var View
	 */
	protected $view;
	
	/**
	 * @param Request $request A request object
	 * @param View $view A view object
	 */
	public function __construct(Request &$request, View &$view) {
		$this->request = $request;
		$this->view = $view;
	}
	
	/**
	 * Pre Init hook.
	 */
	public function _preInit() {}
	
	/**
	 * Controller initilization method.
	 */
	public function _init() {}
	
	/**
	 * Post init hook.
	 */
	public function _postInit() {}
	
	/**
	 * Pre action hook. This is called immediately before the user defined action.
	 */
	public function _preAction() {}
	
	/**
	 * Post action hook. This is called immediately after the user defined action.
	 */
	public function _postAction() {}
	
	/**
	 * Pre render hook.
	 */
	public function _preRender() {}
	
	/**
	 * Post render hook.
	 */
	public function _postRender() {}
	
	/**
	 * Pre shutdown hook.
	 */
	public function _preShutdown() {}
	
	/**
	 * Controller shutdown method 
	 */
	public function _shutdown() {}
	
	/**
	 * Post shutdown hook.
	 */
	public function _postShutdown() {}
	
	/**
	 * Return the request attached to the controller
	 *
	 * @return \Framework\Request The request object.
	 */
	public function getRequest() {
		return $this->request;
	}
	
	/**
	 * Return the request attached to the controller
	 *
	 * @return \Framework\Request The request object.
	 */
	public function getView() {
		return $this->view;
	}
}
