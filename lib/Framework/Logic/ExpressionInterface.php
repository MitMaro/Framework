<?php
/**
 * @package  Framework\Logic
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\Logic;

interface ExpressionInterface {
	/**
	 * Evaluate the expression
	 * @param DataProviderInterface $variable_providver (Optional) The data provider for the statement
	 */
	public function evaluate(DataProviderInterface $variable_data_provider = null);
}
