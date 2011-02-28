<?php
/**
 * Resource Interface
 * 
 * @package  Framework\AccessControl\RoleBased
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl\RoleBased;

interface ResourceInterface {
	
	/**
	 * Constructs a resource with the given resource id
	 *
	 * @param mixed $id A unique identifier for this resource
	 */
	public function __construct($id);
	
	/**
	 * Adds permissions to the resource.
	 *
	 * @param Permission $permissions An array of Permission objects or a single permission object
	 */
	public function addPermissions($permissions);
	
	/**
	 * Returns the permissions associated with this resource
	 *
	 * @return array An array of Framework\AccessControl\Permission objects
	 */
	public function getPermissions();
	
	/**
	 * Get the unique identifier for the resource
	 * 
	 * @return mixed The unique identifier for this resource
	 */
	public function getIdentifier();
	
}
