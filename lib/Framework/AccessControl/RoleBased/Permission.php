<?php
/**
 * Describes a permission
 * 
 * @package  Framework\AccessControl\RoleBased
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl\RoleBased;

class Permission implements PermissionInterface {
	
	/**
	 * A unique identifier for the permission
	 * @var mixed
	 */
	protected $id;
	
	/**
	 * The value of the permission
	 * @var SOFT_DENY|DENY|ALLOW A value constant
	 */
	protected $value;
	
	/**
	 * Constructs a permission with the given id
	 *
	 * @param mixed $id A unique identifier for this permission
	 */
	public function __construct($id, $value = self::ALLOW) {
		$this->id = $id;
		$this->value = $value;
	}
	
	/**
	 * Get the unique identifier for the permission
	 * @return mixed The unique identifier for this permission
	 */
	public function getIdentifier() {
		return $this->id;
	}
	
	/**
	 * Gets the permissions value
	 */
	public function getValue() {
		return $this->value;
	}
}
