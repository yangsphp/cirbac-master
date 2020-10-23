<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Log_model extends QW_Model {

	
	public function __construct() {
		parent::__construct ();
		$this->_table = $this->_tables ["logs"];
	}

}

?>