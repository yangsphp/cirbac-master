<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );


class QW_Form_validation extends CI_Form_validation {
	
	function run($module = '', $group = '') {
		if ($group != '') {
			$rules = $this->CI->config->item ( $group );
			if (is_array ( $rules )) {
				$this->set_rules ( $rules );
			}
		} else {
			$rules = $this->CI->config->item ( $this->CI->router->method );
			if (is_array ( $rules )) {
				$this->set_rules ( $rules );
			}
		}
		if (is_object ( $module )) {
			$this->CI = & $module;
		}
		return parent::run ( $group );
	}
}
?>