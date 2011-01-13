<?php
/**
 * Describes a resource
 * 
 * @package  Framework\AccessControl
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl;

class Resource {
	
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
			$this->permissions[$permission->getId()] = $permission;
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
	public function getId() {
		return $this->id;
	}
	
	/**
	 * Checks is the supplied user has the permissions to access this resource
	 *
	 * @param User $user The user object to check against
	 * @return boolean True is user has access, false otherwise
	 */
	public function checkUserPermissions(User $user) {
		$required = $this->permissions;
		foreach ($user->getRoles() as $role) {
			foreach ($role->getPermissions() as $permission) {
				// if the supplied permission is required, remove it
				if (isset($required[$permission->getId()])) {
					unset($required[$permission->getId()]);
				}
			}
			// short circuit return true is the required permissions were all found
			if (count($required) == 0) {
				return true;
			}
		}
		
		// if the number of elements in the $required array is not 0
		// then there was a missing permission
		return count($required) == 0;
	}
	
}
