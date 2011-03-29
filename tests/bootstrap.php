<?php
/**
 * @package  Framework\Test
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

// provides $cfg array
// use config.php unless it is not found, then fall back to the distributed file
if (file_exists(__DIR__ . '/config.php')) {
	require_once 'config.php';
} else {
	require_once 'config.dist.php';
}

// add site's server path (root) to include path
set_include_path(
	realpath($cfg['project_root']) . PATH_SEPARATOR .
	get_include_path()
);


require_once 'Framework/Autoloader/Autoloader.php';
$autoloader = new \Framework\Autoloader\Autoloader();
$autoloader->addNamespace('Framework', 'Framework/');
spl_autoload_register(array($autoloader, 'classLoader'));

date_default_timezone_set('America/St_Johns');
