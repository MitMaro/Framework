<?php
/**
 * Role Based Role Has Assertion
 * 
 * @package  Framework\AccessControl\Assertion\RoleBased
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl\Assertion\RoleBased;

use
	Framework\AccessControl\Assertion\AssertionInterface,
	Framework\AccessControl\RoleBased\Permission
;

class RoleHasPermissions implements AssertionInterface {
	
	/**
	 * Assert that the provided role has required pemrissions
	 *
	 * @param string $name The name of the assertion being called
	 * @param mixed $role The role to check permissions against
	 * @param mixed $required_permissions The required permissions
	 */
	public function assert($name, $role, $required_permissions) {
		
		if (!is_array($required_permissions)) {
			$required_permissions = array($required_permissions);
		}
		
		$permissions = $role->getPermissions();
		
		// check that the requested permissions are on the role and are not denied
		foreach ($required_permissions as $permission) {
			
			// if role doesn't have permission then it's a soft deny
			if (!isset($permissions[$permission->getIdentifier()])) {
				return false;
			}
			
			$permission = $permissions[$permission->getIdentifier()];
			
			// check for a hard deny
			if ($permission->getValue() == Permission::DENY) {
				return false;
			}
			
			// check for soft deny
			if ($permission->getValue() == Permission::SOFT_DENY) {
				return false;
			}
			
		}
		
		// getting here means every permission was found and not denied
		return true;
	}
}
