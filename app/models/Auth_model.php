<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends QW_Model {

	public function __construct() {
		parent::__construct ();
		$this->_table = $this->_tables ["yang_auth"];
	}

	public function get_auths($offset=0,$eachpage=0,$sortOrder='',$search='') {
	
		return $this->get_by_field('',$search,$sortOrder,$offset,$eachpage);
	}
  	public function get_auth($search='') {
	
		return $this->get_by_field('',$search);
	}
	public function update_auth($bid,$data) {
		return $this->update($bid,$data,'id');
	}
	public function get_one_auth($bid)
	{
		return $this->get_by_field('',array('id'=>$bid));
	}
	public function delete_auths($bid) 
	{
		return $this->delete($bid,'id');
	}
	public function getMenu()
    {
        return $this->db->where("status=1 and is_menu=1")->order_by("sort", "asc")->get($this->_tables['yang_auth'])->result_array();
    }

    public function insertauth($post)
    {
        $post['date_entered'] = date("Y-m-d H:i:s", time());
        return $this->insert($post);
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