<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends QW_Model {

	public function __construct() {
		parent::__construct ();
		$this->_table = $this->_tables ["users"];
	}

	public function get_users($offset=0,$eachpage=0,$sortOrder='',$search='') {
	    $join = array('yang_role', 'yang_role.id = users.role_code');
		return $this->get_by_field('users.*, yang_role.name as role_name',$search,$sortOrder,$offset,$eachpage, '', '', $join);
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
		return $this->db->delete('users');
	}

    public function insertAdmin($post)
    {
        return $this->db->insert("users", $post);
    }

    public function getRole() {
        return $this->db->get('yang_role')->result_array();
    }
}

?>