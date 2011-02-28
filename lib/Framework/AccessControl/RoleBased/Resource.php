<?php
/**
 * Describes a resource
 * 
 * @package  Framework\AccessControl\RoleBased
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl\RoleBased;

class Resource implements ResourceInterface {
	
	/**
	 * A unique identifier for the resource
	 * @var mixed
	 */
	protected $id;
	
	/**
	 * The permissions associated with this resource
	 * @var array An array of Framework\AccessControl\Permission
	 */
	protected $permissions = array();
	
	/**
	 * Constructs a resource with the given resource id
	 *
	 * @param mixed $id A unique identifier for this resource
	 */
	public function __construct($id) {
		$this->id = $id;
	}
	
	/**
	 * Adds permissions to the resource.
	 *
	 * @param Permission $permissions An array of Permission objects or a single permission object
	 */
	public function addPermissions($permissions) {
		if (!is_array($permissions)) {
			$permissions = array($permissions);
		}
		foreach ($permissions as $permission) {
			$this->permissions[$permission->getIdentifier()] = $permission;
		}
	}
	
	/**
	 * Returns the permissions associated with this resource
	 *
	 * @return array An array of Framework\AccessControl\Permission objects
	 */
	public function getPermissions() {
		return $this->permissions;
	}
	
	/**
	 * Get the unique identifier for the resource
	 * @return mixed The unique identifier for this resource
	 */
	public function getIdentifier() {
		return $this->id;
	}
	
}
