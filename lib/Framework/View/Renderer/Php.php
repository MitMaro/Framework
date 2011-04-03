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
	Framework\View\Data,
	Framework\View\Exception
;

class Php implements RendererInterface {
	
	/**
	 * Render the template file with the provided data
	 *
	 * @param string $template The template file path
	 * @param Data $data The data provider
	 * @throws Exception\Renderer if the template does not exist
	 */
	public function render($template, Data $data) {
		
		// have all the 
		foreach ($data->toArray() as $key => $value) {
			$this->$key = $value;
		}
		
		if (file_exists($template)) {
			require $template;
		} else {
			throw new Exception\Renderer('The template ' . $template . ' not found.');
		}
		
	}
	
}
