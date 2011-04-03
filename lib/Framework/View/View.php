<?php
/**
 * @package  Framework\View
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\View;

use
	Framework\View\Renderer\Php,
	Framework\View\Renderer\RendererInterface,
	Framework\View\Data,
	Framework\View\Exception
;

class View {
	
	/**
	 * @var Framework\View\Renderer\RendererInterface The renderer
	 */
	protected $renderer;
	
	/**
	 * @var Framework\View\Data The template data
	 */
	protected $data;
	
	/**
	 * @var mixed The template, passed directly to the renderer
	 */
	protected $template = null;
	
	/**
	 * @param RendererInterface $renderer (Optional, Defualt: Php) The template renderer
	 * @param Data $data (Optional) The data provider
	 */
	public function __construct(RendererInterface $renderer = null, Data $data = null) {
		
		if (is_null($renderer)) {
			$this->renderer = new Php();
		} else {
			$this->renderer = $renderer;
		}
		
		if (is_null($data)) {
			$this->data = new Data();
		} else {
			$this->data = $data;
		}
		
	}
	
	/**
	 * Render the template using the renderer
	 *
	 * @return mixed Returns what ever the renderer returns
	 * @throws Exception\View if no template is given
	 */
	public function render() {
		if (!is_null($this->template)) {
			return $this->renderer->render($this->template, $this->data);
		}
		
		throw new Exception\View('Template is not set');
	}
	
	/**
	 * @param mixed $template The template
	 */
	public function setTemplate($template) {
		$this->template = $template;
	}
	
	/**
	 * @return mixed The template
	 */
	public function getTemplate() {
		return $this->template;
	}
	
	/**
	 * Sets a template data variable, proxies to the data provider
	 *
	 * @param string The variable name
	 * @param mixed The value
	 */
	public function __set($name, $value) {
		$this->data[$name] = $value;
	}
	
	/**
	 * Get a template variable, proxies to the data provider
	 *
	 * @param string $name The name of the variable
	 * 
	 * @return mixed The value
	 */
	public function __get($name) {
		return $this->data[$name];
	}
}
