<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Role_model extends QW_Model {

	public function __construct() {
		parent::__construct ();
		$this->_table = $this->_tables ["yang_role"];
	}

	public function get_roles($offset=0,$eachpage=0,$sortOrder='',$search='') {
	
		return $this->get_by_field('',$search,$sortOrder,$offset,$eachpage);
	}
	
  	public function get_role($search='') {
	
		return $this->get_by_field('',$search);
	}
	
	public function update_role($bid,$data) {
		return $this->update($bid,$data,'id');
	}
	
	public function get_one_role($bid)
	{
		return $this->get_by_field('',array('id'=>$bid));
	}

	public function getMenu()
    {
        return $this->db->where("status=1")->order_by("sort", "asc")->get($this->_tables['yang_auth'])->result_array();
    }

    public function delete_op($id)
    {
        //判断是否有子集
        $list = $this->db->get_where($this->_tables['users'], "role_code in($id)")->result_array();
        if (count($list) > 0) {
            return array("code" => 1, "msg" => "该角色下有用户，不能删除");
        }
        $this->db->where("id in($id)");
        $this->db->delete($this->_table);
        return array("code" => 0, "msg" => "删除角色成功");
    }
}

?>