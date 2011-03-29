<?php
/**
 * 
 */

class LightOpenId {
	
	protected $data = array();
	protected $trustRoot = '';
	protected $returnUrl = '';
	public $identity = array();
	
	public function validate() {
		return true;
	}
	
	public function getAttributes() {
		return array('abc' => 'def');
	}
	
}
