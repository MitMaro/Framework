<?php
/**
 * @package  Framework\View\Renderer
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\View\Renderer;

use
	Framework\View\Data
;

interface RendererInterface {
	
	/**
	 * Render the template on the data
	 *
	 * @param mixed $template The template
	 * @param Data $data The data
	 */
	public function render($template, Data $data);
	
}
