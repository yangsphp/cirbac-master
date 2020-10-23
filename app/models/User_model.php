<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends QW_Model {

	public function __construct() {
		parent::__construct ();
		$this->_table = $this->_tables ["users"];
	}

	public function get_users($offset=0,$eachpage=0,$sortOrder='',$search='') {
		return $this->get_by_field('',$search,$sortOrder,$offset,$eachpage);
	}

	public function get_users_count($search) {
		return $this->count($search);
	}
	public function get_users_search($search) {
		$join = array('userinfo','users.id = userinfo.uid');
		return $this->get_by_field('',$search,'','','','','',$join);
	}
	public function get_one_user($uid) {
		$join = array('userinfo','users.id = userinfo.uid');
		$user =  $this->get_by_field('','id = '.$uid,'','','','','',$join);
		
		return $user[0];
	}


	public function update_userinfo($uid,$data) {
		return $this->update($uid,$data,'id');
	}
	public function get_one_userinfo($username)
	{
		return $this->get_by_field('',array('username'=>$username));
	}
	
	public function get_user_by_role()
	{
		return $this->get_by_field('role_code');
	}
	public function delete_user($uid) {
		return $this->delete($uid,'id');
	}

	public function edit($id) {
		$this->form_validation->set_rules ( 'username', 'Username', 'trim|required|min_length[4]|max_length[40]|callback_username_check' );
		$this->form_validation->set_rules ( 'password', 'Password', 'trim|required|min_length[4]|max_length[12]' );
		$this->form_validation->set_rules ( 'remember', 'Remember Me' );
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