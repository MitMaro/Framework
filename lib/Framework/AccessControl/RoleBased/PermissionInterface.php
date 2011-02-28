<?php
/**
 * Permission Interface
 * 
 * @package  Framework\AccessControl\RoleBased
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl\RoleBased;

interface PermissionInterface {
	
	/**
	 * @static
	 * @final
	 * @var const A soft deny
	 */
	const SOFT_DENY = 0;
	
	/**
	 * @static
	 * @final
	 * @var const A hard deny
	 */
	const DENY = 1;
	
	/**
	 * @static
	 * @final
	 * @var const An allow
	 */
	const ALLOW = 2;
	
	/**
	 * Constructs a permission with the given id
	 *
	 * @param mixed $id A unique identifier for this permission
	 * @param SOFT_DENY|DENY|ALLOW $value The value of this permission
	 */
	public function __construct($id, $value = self::ALLOW);
	
	/**
	 * Get the unique identifier for the permission
	 * @return mixed The unique identifier for this permission
	 */
	public function getIdentifier();
	
	/**
	 * Gets the permissions value
	 * @returns SOFT_DENY|DENY|ALLOW
	 */
	public function getValue();
}
