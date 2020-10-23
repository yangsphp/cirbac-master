<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Auth extends QW_Controller{
	public function __construct()
    {
        parent::__construct();
        $this->load->model("Auth_model", 'Auth');
        $this->lang->load("auth");
    }
	public function index()
    {
        $this->load->view('auth/index', null);
    }

    public function show_auth()
    {
        $search = '1 = 1';
        $allauths = $this->getCategory2($this->Auth->get_auth($search));
		foreach ($allauths as $k => $v) {
            $allauths[$k]['name'] = "|--" . str_repeat("--", $v['level'] * 2) . $v['name'];
            $allauths[$k]['icon'] = "<i class='" . $v['icon'] . "'></i>";
            if (!$v['url']) {
                $allauths[$k]['url'] = "#";
            } else {
                $allauths[$k]['url'] = $v['url'];
            }
        }
        $infos = array('total' => count($this->Auth->get_auth($search)), 'rows' => $allauths);
        echo json_encode($infos, JSON_NUMERIC_CHECK);
    }

    public function add()
    {
        $title = $this->lang->line("add_auth_title");
        $id = $this->input->get("id");
        $info = array('is_menu' => 1);
        if ($id) {
            $title = $this->lang->line("edit_auth_title");
            //获取数据
            $data = $this->Auth->get_one_auth($id);
            $info = $data[0];
        }
        $menu = $this->getCategory2($this->Auth->getMenu());
		//var_dump($info);
        $data['data'] = $info;
        $data['menu'] = $menu;
        $data['id'] = $id;
        $html = $this->load->view('auth/add', $data, true);
        echo json_encode(array("title" => $title, "html" => $html));
    }

    public function add_op()
    {
        $id = $this->input->post("id");
        $post = $this->input->post("post");
        $this->load->library('form_validation');
        $this->form_validation->set_rules('post[name]', '菜单名称', 'required', array("required" => "请输入%s"));
        if ($this->form_validation->run() == FALSE) {
            die(json_encode(array("code" => -1, "msg" => strip_tags(validation_errors()))));
        }
        if ($id) {
            //修改
            $post['id'] = $id;
            $result = $this->Auth->update_auth($id, $post);
            if ($result) {
                die(json_encode(array("code" => 0, "msg" => $this->lang->line("edit_auth_ok"))));
            }
            die(json_encode(array("code" => 1, "msg" => $this->lang->line("edit_auth_error"))));
        } else {
            //添加
            $result = $this->Auth->insert($post);
            if ($result) {
                die(json_encode(array("code" => 0, "msg" => $this->lang->line("add_auth_ok"))));
            }
            die(json_encode(array("code" => 1, "msg" => $this->lang->line("add_auth_error"))));
        }
    }

    public function delete_op()
    {
        $id = $this->input->post("id");
        $result = $this->Auth->delete_op($id);
        if ($result['code'] == 0) {
            die(json_encode(array("code" => 0, "msg" => $result['msg'])));
        }
        die(json_encode(array("code" => 1, "msg" => $result['msg'])));
    }
}