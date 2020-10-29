<?php
/**
 * Created by PhpStorm.
 * User: Mr.Yang
 * Date: 2020/10/14
 * Time: 10:02
 * QQ: 2575404985
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class QW_Controller extends CI_Controller
{
	public $setting = array();
    public function __construct()
    {
        parent::__construct();
        //检查是否登录
        if ($this->is_logined_in() == FALSE) {
            $my_class_name = get_class($this);
            if ($my_class_name != 'Login') {
                if ($my_class_name == 'Manage') {
                    redirect("login/login_admin");
                } else {
                    redirect("login/redircet");
                }
            }
        }else{
            $this->getButtons();
        }
		$this->getConfigs();
		//$this->upload();
    }

    /**
     * 设置权限按钮
     */
    public function getButtons()
    {
        $class = strtolower(get_class($this));
        $tables = $this->config->item("tables");
        $menuIds = $this->session->userdata("menuIds");
        $where = "status = 1 and is_menu = 0 and url like '%$class%'";
        if ($menuIds) {
            $where .= " and id in($menuIds)";
        }
        $auth = $this->db->select('id, name, url')->from($tables['auth'])->where($where)->get()->result_array();
        $button_array = array();
        foreach ($auth as $k => $v) {
            $button_array[] = $v['name'];
        }
        $this->load->vars(array('buttons' => $button_array));
    }
	
	public function uploadFile($file)
	{
		$userid = $this->session->userdata('user_id');
		$tables = $this->config->item("tables");
		$upload_table = $tables['upload_'.($userid%10)];
		var_dump($userid);
		var_dump($this->setting);
		echo $upload_table;exit;
	}
	
	/**
	* 获取基本配置
	*/
	public function getConfigs()
	{
		$this->load->model("System_model", 'System');
		$config = $this->System->getConfigs();
		$this->load->vars($config);
		$this->setting = $config;
	}

    /**
     * 渲染左侧菜单数据
     * @param $data
     * @param int $parent_id
     * @return array
     */
    protected function getMenuTree($data, $parent_id = 0)
    {
        $tree = array();
        foreach ($data as $k => $v) {
            if ($v["parent_id"] == $parent_id) {
                unset($data[$k]);
                if (!empty($data)) {
                    $children = $this->getMenuTree($data, $v["id"]);
                    if (!empty($children)) {
                        $v["submenu"] = $children;
                    }
                }
                $tree[] = $v;
            }
        }
        return $tree;
    }
	
	/**
     * @param $data
     * @param int $parent_id
     * @param int $level
     * @return array
     */
    function getCategory2($data, $parent_id = 0, $level = 0)
    {
        static $tree = array();
        foreach ($data as $k => $v) {
            if ($v["parent_id"] == $parent_id) {
                $v["level"] = $level;
                $tree[] = $v;
                $this->getCategory2($data, $v["id"], $level + 1);
            }
        }
        return $tree;
    }
	
	function getCategory1($data, $parent_id = 0)
    {
        $tree = array();
        foreach ($data as $k => $v) {
            if ($v["parent_id"] == $parent_id) {
                unset($data[$k]);
                if (!empty($data)) {
                    $children = $this->getCategory1($data, $v["id"]);
                    if (!empty($children)) {
                        $v["_child"] = $children;
                    }
                }
                $tree[] = $v;
            }
        }
        return $tree;
    }

    public function is_logined_in()
    {
        if ($this->session->userdata("login_in") == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('user/login_admin', 'refresh');
    }

}