<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class System_model extends QW_Model {

	public function __construct() {
		parent::__construct ();
		$this->_table = $this->_tables ["config"];
	}
	
	public function getConfigs($type = '') 
	{
		if($type) {
			$this->db->where('type', $type);
		}
		$data = $this->db->get($this->_table)->result_array();
		$config = array();
		foreach($data as $k => $v) {
			$config[$v['key']] = $v['value'];
		}
		return $config;
	}
	
	public function insert_config($type, $post) {
		$this->delete($type, 'type');
		foreach($post as $k => $v) {
			$data = array(
				'type' => $type,
				'key'  => $k,
				'value' => $v
			);
			$this->insert($data);
		}
		return true;
	}
}

?>