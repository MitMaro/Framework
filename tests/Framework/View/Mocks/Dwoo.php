<?php

class Dwoo {
	
	public function get($_tpl, $data = array(), $_compiler = null, $_output = false) {

		$data_string = '';
		
		foreach($data->toArray() as $k => $d) {
			$data_string .= $k . $d;
		}
		
		return $_tpl . $data_string;
	}
	
}
