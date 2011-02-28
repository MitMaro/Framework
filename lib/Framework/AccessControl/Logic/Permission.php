<?php
/**
 * Access Control Logic Permission
 * 
 * @package  Framework\AccessControl\Logic
 * @version  0.1.0
 * @author  Tim Oram (mitmaro@mitmaro.ca)
 * @copyright  Copyright 2010 Tim Oram (<a href="http://www.mitmaro.ca">www.mitmaro.ca</a>)
 * @license  <a href="http://www.opensource.org/licenses/mit-license.php">The MIT License</a>
 */

namespace Framework\AccessControl\Logic;

use
	Framework\Logic\Statement,
	Framework\Logic\DataProviderInterface
;

class Permission {
	
	/**
	 * A unique identifier for the permission
	 * @var mixed
	 */
	protected $id;
	
	/**
	 * The logic statement
	 * @var \Framework\Logic\Statement
	 */
	protected $statement;
	
	/**
	 * The data for the statement
	 * @var \Framework\Logic\DataProviderInterface
	 */
	protected $data_provider;
	
	/**
	 * Constructs a permission with the given id
	 *
	 * @param mixed $id A unique identifier for this permission
	 * @param \Framework\Logic\Statement $logic_statement The logical statement attached to this permission
	 * @param \Framework\Logic\DataProviderInterface $data The data provider
	 */
	public function __construct($id, Statement $logic_statement, DataProviderInterface $data_provider = null) {
		$this->id = $id;
		$this->statement = $logic_statement;
		$this->data_provider = $data_provider;
	}
	
	/**
	 * Get the unique identifier for the permission
	 * @return mixed The unique identifier for this permission
	 */
	public function getIdentifier() {
		return $this->id;
	}
	
	/**
	 * Set the data provider to be passed to the statement
	 * @param \Framework\Logic\DataProviderInterface $data The data provider
	 */
	public function setDataProvider($data_provider = null) {
		$this->data_provider = $data_provider;
	}
	
	/**
	 * Gets the permissions value
	 */
	public function getValue() {
		return $this->statement->evaluate();
	}
}
