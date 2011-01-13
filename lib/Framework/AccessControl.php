<?php
/**
 * @category  AccessControl
 * @package  Framework
 * @subpackage AccessControl
 * @version  0.1.0
 * @author  Tim Oram <mitmaro@mitmaro.ca>
 * @copyright  Copyright (c) 2010 Tim Oram (http://www.mitmaro.ca)
 * @license    http://www.opensource.org/licenses/mit-license.php  The MIT License
 */

namespace Framework;

class AccessControl {
	
	/**
	 * @var array An array or resources
	 */
	protected $resources = array();
	
	/**
	 * @var boolean Default allow or deny
	 */
	protected static $default_access = false;
	
	/**
	 * Adds permission(s) to a resource
	 *
	 * @param AccessControl\Resource $resource The Resource object
	 * @param AccessControl\Permission $permissions A Permission object or an array of Permission objects
	 */
	public function addResourcePermissions(AccessControl\Resource $resource, $permissions) {
		if (!isset($this->resources[$resource->getId()])) {
			$this->resources[$resource->getId()] = $resource;
		}
		$this->resources[$resource->getId()]->addPermissions($permissions);
	}
	
	/**
	 * Adds a resource
	 *
	 * @param AccessControl\Resource $resource The resource object
	 */
	public function addResource(AccessControl\Resource $resource) {
		$this->resources[$resource->getId()] = $resource;
	}
	
	/**
	 * Get the array of resources
	 * @return array An array of resource objects
	 */
	public function getResources() {
		return $this->resources;
	}
	
	/**
	 * Verify that a user has access to a resource
	 * @param \Framework\AccessControl\Resource $resource The resource object
	 * @param \Framework\AccessControl\User $user The user object
	 * @return boolean True is allowed access, false otherwise
	 */
	public function verifyAccess(AccessControl\Resource $resource, AccessControl\User $user) {
		if(isset($this->resources[$resource->getId()])) {
			return $this->resources[$resource->getId()]->checkUserPermissions($user);
		}
		return self::$default_access;
	}
	
	/**
	 * Makes one resource act as if it was the other
	 * 
	 * @param mixed $resource_id The source resource id
	 * @param mixed $mirror_resource_ids A resource id or an array of resource ids to make a mirror
	 */
	public function mirror($resource_id, $mirror_resource_ids) {
		if (isset($this->resources[$resource_id])) {
			if (!is_array($mirror_resource_ids)) {
				$mirror_resource_ids = array($mirror_resource_ids);
			}
			foreach($mirror_resource_ids as $r) {
				$this->resources[$r] = $this->resources[$resource_id];
			}
			return;
		}
		elseif (isset($this->resources[$mirror_resource_ids])) {
			if (!is_array($resource_id)) {
				$resource_id = array($resource_id);
			}
			foreach($resource_id as $r) {
				$this->resources[$r] = $this->resources[$mirror_resource_ids];
			}
			return;
		}
		throw new AccessControl\Exception('Mirror Failed: Resource ' . $resource_id. ' does not exist');
	}
	
	/**
	 * Set default access
	 *
	 * @param boolean $grant Value of the default access (Optional, Default: true)
	 */
	
	public static function setDefaultAccess($grant = true) {
		self::$default_access = (bool)$grant;
	}
	
	/**
	 * Get default access
	 *
	 * @return bool The current default access value
	 */
	public static function getDefaultAccess() {
		return self::$default_access;
	}
	
	/**
	 * Check if the provided user can access the given resource
	 *
	 * @param AccessControl\User $user The user object
	 * @param AccessControl\Resource $user The resource object
	 */
	public static function verifyUserResourceAccess(AccessControl\User $user, AccessControl\Resource $resource) {
		return $resource->checkUserPermissions($user);
	}
	
}
