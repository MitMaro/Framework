<?php
/**
 * Describes a role
 * 
 * @package  Framework\AccessControl
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl;

class Role {
	
	/**
	 * A unique identifier for the role
	 * @var mixed
	 */
	protected $id;
	
	/**
	 * The permissions associated with this role
	 * @var array An array of Framework\AccessControl\Permission
	 */
	protected $permissions = array();
	
	/**
	 * Constructs a role with the given id
	 *
	 * @param mixed $id A unique identifier for this role
	 */
	public function __construct($id) {
		$this->id = $id;
	}
	
	/**
	 * Adds permissions to the role.
	 *
	 * @param Permission $permissions An array of Permission objects or a single permission object
	 */
	public function addPermissions($permissions) {
		if (!is_array($permissions)) {
			$permissions = array($permissions);
		}
		foreach ($permissions as $permission) {
			// set to false by default, makes the check later easier
			$this->permissions[$permission->getId()] = $permission;
		}
	}
	
	
	/**
	 * Returns the permissions associated with this role
	 *
	 * @return array An array of Framework\AccessControl\Permission objects
	 */
	public function getPermissions() {
		return $this->permissions;
	}
	
	/**
	 * Get the unique identifier for the role
	 * @return mixed The unique identifier for this role
	 */
	public function getId() {
		return $this->id;
	}
	
}
