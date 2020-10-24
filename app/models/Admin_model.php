<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends QW_Model {

	public function __construct() {
		parent::__construct ();
		$this->_table = $this->_tables ["users"];
	}

	public function get_users($offset=0,$eachpage=0,$sortOrder='',$search='') {
	    $join = array($this->_tables ["role"]." as role", 'role.id = '.$this->_table.'.role_code');
		return $this->get_by_field($this->_table.'.*, role.name as role_name',$search,$sortOrder,$offset,$eachpage, '', '', $join);
	}
  	public function get_user($search='') {
		return $this->get_by_field('',$search);
	}
	
	public function update_user($bid,$data) {
		return $this->update($bid,$data,'id');
	}
	public function get_one_user($bid)
	{
		return $this->get_by_field('',array('id'=>$bid));
	}
	public function delete_users($id) 
	{
        $this->db->where("id in ($id)");
		return $this->db->delete($this->_table);
	}

    public function insertAdmin($post)
    {
        return $this->db->insert($this->_table, $post);
    }

    public function getRole() {
        return $this->db->get($this->_tables ["role"])->result_array();
    }
	
	public function check_user ($username) {
		$condition = array ("username" => $username );
		$this->db->select()->from( $this->_table )->where( $condition );
		$query = $this->db->get ();
		if ($query->num_rows () < 1) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function check_password($username, $password) {
		$condition = array ("username" => $username, "password" => $password );
		$this->db->select ()->from ( $this->_table  )->where ( $condition );
		$query = $this->db->get ();
		if ($query->num_rows () == 1) {
			return TRUE;
		} else {
			return FALSE;
		}

	}

	public function get_admin($username, $password) {
		$condition = array ("username" => $username, "password" => $password );
		$this->db->select ()->from ( $this->_table  )->where ( $condition )->where('state = 1');
		$query = $this->db->get ();
		if ($query->num_rows () == 1) {
			$row = $query->row_array ();
			return $row;
		} else {
			return FALSE;
		}
	}
}

?>