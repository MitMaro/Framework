<?php
/**
 * Role Interface
 * 
 * @package  Framework\AccessControl\RoleBased
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl\RoleBased;

interface RoleInterface {
	
	/**
	 * @param scalar $id The identifier for the role
	 */
	public function __construct($id);
	
	/**
	 * Gets the identitifer
	 *
	 * @return scalar The identifier on the role
	 */
	public function getIdentifier();
	
	/**
	 * Adds permissions to the role.
	 *
	 * @param Permission $permissions An array of Permission objects or a single permission object
	 */
	public function addPermissions($permissions);
	
	/**
	 * Returns the permissions associated with this role
	 *
	 * @return array An array of Framework\AccessControl\Permission objects
	 */
	public function getPermissions();
	
}
