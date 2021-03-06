<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends QW_Model {

	public function __construct() {
		parent::__construct ();
		$this->_table = $this->_tables ["auth"];
	}

	public function get_auths($offset=0,$eachpage=0,$sortOrder='',$search='') {
	
		return $this->get_by_field('',$search,$sortOrder,$offset,$eachpage);
	}
	
  	public function get_auth($search='') {
	
		return $this->get_by_field('',$search);
	}

	public function get_one_auth($bid)
	{
		return $this->get_by_field('*',array('id'=>$bid));
	}
	
	public function getMenu()
    {
        return $this->db->where("status=1 and is_menu=1")->order_by("sort", "asc")->get($this->_tables['auth'])->result_array();
    }


    public function delete_op($id)
    {
        //判断是否有子集
        $list = $this->db->get_where($this->_table, "parent_id in($id)")->result_array();
        if (count($list) > 0) {
            return array("code" => 1, "msg" => "该菜单下有子集菜单，不能删除");
        }
        $this->db->where("id in($id)");
        $this->db->delete($this->_table);
        return array("code" => 0, "msg" => "删除菜单成功");
    }
}

?>