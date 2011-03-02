<?php
/**
 * @package  Framework\Test
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

require 'config.php';

// add site's server path (root) to include path
set_include_path(
	realpath($cfg['project_root']) . PATH_SEPARATOR .
	$cfg['pear_path']
);


require_once 'Framework/Autoloader/Autoloader.php';
$autoloader = new \Framework\Autoloader\Autoloader();
$autoloader->addNamespace('Framework', 'Framework/');
spl_autoload_register(array($autoloader, 'classLoader'));
