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
	Framework\View\Data\DataInterface,
	Framework\View\Exception
;

class Dwoo implements RendererInterface {
	
	/**
	 * @param \Dwoo $dwoo (Optional) A custom dwoo instance
	 */
	public function __construct(\Dwoo $dwoo = null) {
		if (is_null($dwoo)) {
			$this->dwoo = new \Dwoo();
		} else {
			$this->dwoo = $dwoo; 
		}
	}
	
	/**
	 * Render the template file with the provided data
	 *
	 * @param string $template The template file path
	 * @param Data $data The data provider
	 * @throws Exception\Renderer if the template does not exist
	 */
	public function render($template, DataInterface $data) {
		
		return $this->dwoo->get($template, $data);
		
	}
	
}
