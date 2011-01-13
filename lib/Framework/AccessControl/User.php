<?php
/**
 * Describes a user
 * 
 * @package  Framework\AccessControl
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl;

class User {
	
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
		if (!is_array($roles)) {
			$roles = array($roles);
		}
		foreach ($roles as $role) {
			// set to false by default, makes the check later easier
			$this->roles[$role->getId()] = $role;
		}
	}
	
	public function getId() {
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
