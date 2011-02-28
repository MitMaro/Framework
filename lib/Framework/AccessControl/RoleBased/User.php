<?php
/**
 * Describes a user
 * 
 * @package  Framework\AccessControl\RoleBased
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl\RoleBased;

class User implements ResourceInterface {
	
	/**
	 * A unique identifier for the user
	 * @var mixed
	 */
	protected $id;
	
	/**
	 * The roles associated with this user
	 * @var array An array of Framework\AccessControl\Role
	 */
	protected $roles = array();
	
	/**
	 * The permissions associated with this resource
	 * @var array An array of Framework\AccessControl\Permission
	 */
	protected $permissions = array();
	
	/**
	 * Internal cache of permissions
	 * @var array An array of Framework\AccessControl\Permission from $permissions and $roles
	 */
	protected $permissions_cache = null;
	
	/**
	 * Constructs a user with the given id
	 *
	 * @param mixed $id A unique identifier for this user
	 */
	public function __construct($id) {
		$this->id = $id;
	}
	
	/**
	 * Adds a role to this user
	 *
	 * @param \Framework\AccessControl\Role $role A Role object or an array of Role objects.
	 */
	public function addRoles($roles) {
		$this->permissions_cache = null;
		if (!is_array($roles)) {
			$roles = array($roles);
		}
		foreach ($roles as $role) {
			// set to false by default, makes the check later easier
			$this->roles[$role->getIdentifier()] = $role;
		}
	}
	/**
	 * Adds permissions to the user.
	 *
	 * @param Permission $permissions An array of Permission objects or a single permission object
	 */
	public function addPermissions($permissions) {
		$this->permissions_cache = null;
		if (!is_array($permissions)) {
			$permissions = array($permissions);
		}
		foreach ($permissions as $permission) {
			$this->permissions[$permission->getIdentifier()] = $permission;
		}
	}
	
	/**
	 * Returns the permissions associated with this user
	 *
	 * @return array An array of Framework\AccessControl\Permission objects
	 */
	public function getPermissions() {
		
		// check for cache hit
		if (!is_null($this->permissions_cache)) {
			return $this->permissions_cache;
		}
		
		$permissions = $this->permissions;
		
		// loop over ever role and thir permissions
		foreach ($this->roles as $role) {
			foreach($role->getPermissions() as $permission) {
				$id = $permission->getIdentifier();
				// if not in permission array just add
				if (!isset($permissions[$id])) {
					$permissions[$id] = $permission;
				}
				
				// if current permission is a deny, do nothing
				if ($permissions[$id]->getValue() == Permission::DENY) {
					continue;
				}
				
				// if permission is a hard deny override
				if ($permission->getValue() == Permission::DENY) {
					$permissions[$id] = $permission;
					continue;
				}
				
			}
		}
		
		$this->permissions_cache = $permissions;
		
		return $this->permissions_cache;
	}
	
	/**
	 * Get the unique identifier for the user
	 * @return mixed The unique identifier for this user
	 */
	public function getIdentifier() {
		return $this->id;
	}
	
	/**
	 * Get the roles associated with this user.
	 *
	 * @return array An array of Framework\AccessControl\Role objects
	 */
	public function getRoles() {
		return $this->roles;
	}
	
}
