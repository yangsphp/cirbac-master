<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Role extends QW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Role_model", 'Role');
        $this->lang->load("role");
    }

    public function index()
    {
        $this->load->view('role/index', null);
    }

    public function show_role()
    {
        $search = $this->input->post('search') ? 'name like "%'.$this->input->post('search').'%"' : '';
        $eachpage = isset($_POST['limit']) ? $_POST['limit'] : 10;
        $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
        $sortOrder = isset($_POST['sort']) ? $_POST['sort'] . " " . $_POST['sortOrder'] : "";
        $allroles = $this->Role->get_roles($offset, $eachpage, $sortOrder, $search);
        $infos = array('total' => count($this->Role->get_roles("", "", "", $search)), 'rows' => $allroles);
        echo json_encode($infos, JSON_NUMERIC_CHECK);
    }

    public function add()
    {
        $title = $this->lang->line("add_role_title");
        $id = $this->input->get("id");
        $info = array('is_menu' => 1);
        if ($id) {
            $title = $this->lang->line("edit_role_title");
            //获取数据
            $data = $this->Role->get_one_role($id);
            $info = $data[0];
            $info['auth'] = explode(",", $info['auth']);
        }
        $menu = $this->getCategory1($this->Role->getMenu());
        $data['data'] = $info;
        $data['menu'] = $menu;
        $data['id'] = $id;
        $html = $this->load->view('role/add', $data, true);
        echo json_encode(array("title" => $title, "html" => $html));
    }

    public function add_op()
    {
        $id = $this->input->post("id");
        $post = $this->input->post("post");
        $this->load->library('form_validation');
        $this->form_validation->set_rules('post[name]', '名称', 'required', array("required" => "请输入角色%s"));
        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array("code" => -1, "msg" => strip_tags(validation_errors()))));
        }
        if (count(@$post['auth']) == 0) {
            die(json_encode(array("code" => -1, "msg" => "请选择菜单")));
        }
		$post['auth'] = implode(",", $post['auth']);
        if ($id) {
            //修改
            $post['id'] = $id;
            $result = $this->Role->update_role($id, $post);
            if ($result) {
                die(json_encode(array("code" => 0, "msg" => $this->lang->line("edit_role_ok"))));
            }
            die(json_encode(array("code" => 1, "msg" => $this->lang->line("edit_role_error"))));
        } else {
            //添加
			$post['date_entered'] = date("Y-m-d H:i:s", time());
            $result = $this->Role->insert($post);
            if ($result) {
                die(json_encode(array("code" => 0, "msg" => $this->lang->line("add_role_ok"))));
            }
            die(json_encode(array("code" => 1, "msg" => $this->lang->line("add_role_error"))));
        }
    }

    public function delete_op()
    {
        $id = $this->input->post("id");
        if ($id == 1) {
            die(json_encode(array("code" => 1, "msg" => '超级管理员不能被删除')));
        }
        $result = $this->Role->delete_op($id);
        if ($result['code'] == 0) {
            die(json_encode(array("code" => 0, "msg" => $result['msg'])));
        }
        die(json_encode(array("code" => 1, "msg" => $result['msg'])));
    }
}