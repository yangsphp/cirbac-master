<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Logs_model extends QW_Model {

	
	public function __construct() {
		parent::__construct ();
		$this->_table = $this->_tables ["logs"];
	}
	
	public function get_logs($offset=0,$eachpage=0,$sortOrder='',$search='') {
	
		return $this->get_by_field('',$search,$sortOrder,$offset,$eachpage);
	}
}

?>