<?php
/**
 * Describes a permission
 * 
 * @package  Framework\AccessControl
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl;

class Permission {
	
	/**
	 * A unique identifier for the permission
	 * @var mixed
	 */
	protected $id;
	
	/**
	 * Constructs a permission with the given id
	 *
	 * @param mixed $id A unique identifier for this permission
	 */
	public function __construct($id) {
		$this->id = $id;
	}
	
	/**
	 * Get the unique identifier for the permission
	 * @return mixed The unique identifier for this permission
	 */
	public function getId() {
		return $this->id;
	}
	
}
