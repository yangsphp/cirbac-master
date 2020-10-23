<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends QW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Admin_model", 'Admin');
    }

    public function index()
    {
        $this->load->view('admin/index');
    }

    public function show_user()
    {
		$search = $this->input->post('search') ? 'username like "%'.$this->input->post('search').'%"' : '';
        $eachpage = isset($_POST['limit']) ? $_POST['limit'] : 10;
        $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
        $sortOrder = isset($_POST['sort']) ? $_POST['sort'] . " " . $_POST['sortOrder'] : "";
        $allusers = $this->Admin->get_users($offset, $eachpage, $sortOrder, $search);
        foreach ($allusers as $key => $value) {
            $value['registered'] = date('Y-m-d H:i:s', $value['registered']);
            $value['last_login'] = date('Y-m-d H:i:s', $value['last_login']);
            $allusers[$key] = $value;
        }
        $infos = array('total' => count($this->Admin->get_users("", "", "", $search)), 'rows' => $allusers);

        echo json_encode($infos, JSON_NUMERIC_CHECK);
    }

    public function add()
    {
        $id = $this->input->get("id");
        $info = array();
        $title = "添加用户";
        if ($id) {
            $title = "修改用户";
            //获取数据
            $data = $this->Admin->get_one_user($id);
            $info = $data[0];
        }
        $role = $this->Admin->getRole();
        $data['data'] = $info;
        $data['role'] = $role;
        $data['id'] = $id;
        $html = $this->load->view('admin/add', $data, true);
        echo json_encode(array("title" => $title, "html" => $html));
    }

    public function validate()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('post[password]', '用户密码', 'trim|required|min_length[5]', array("required" => "请输入%s", "min_length" => "%s长度最少5位"));
        $this->form_validation->set_rules('post[rpassword]', '用户密码', 'required|trim|matches[post[password]]', array("required" => "请再次输入%s", "matches" => "两次输入%s不一致"));
        if ($this->form_validation->run() == FALSE) {
            $errors = explode("\n", validation_errors());
            die(json_encode(array("code" => -1, "msg" => strip_tags($errors[0]))));
        }
    }

    public function add_op()
    {
        $id = $this->input->post("id");
        $post = $this->input->post("post");
        $post['username'] = trim($post['username']);
        $this->load->library('form_validation');
        $this->form_validation->set_rules('post[role_code]', '角色', 'required|trim', array("required" => "请选择%s"));
        $this->form_validation->set_rules('post[username]', '用户名称', 'required|trim', array("required" => "请输入%s"));
        if ($this->form_validation->run() == FALSE) {
            $errors = explode("\n", validation_errors());
            die(json_encode(array("code" => -1, "msg" => strip_tags($errors[0]))));
        }
        if ($id) {
            if ($post['password']) {
                $this->validate();
                //要求修改密码
                //$post['salt'] = $this->random(5);
                $post['password'] = do_hash($post['password'], 'md5');
            } else {
                unset($post['password']);
            }
            unset($post['rpassword']);
            $admin = $this->db->get_where("users", "username='{$post['username']}' and id != $id")->row_array();
            if ($admin) {
                die(json_encode(array("code" => 1, "msg" => "用户已经存在")));
            }
            //修改
            $post['id'] = $id;
            $result = $this->Admin->update_user($id, $post);
            if ($result) {
                die(json_encode(array("code" => 0, "msg" => "修改用户成功")));
            }
            die(json_encode(array("code" => 1, "msg" => "修改用户失败")));
        } else {
            $this->validate();
            $admin = $this->db->get_where("users", array('username' => trim($post['username'])))->row_array();
            if ($admin) {
                die(json_encode(array("code" => 1, "msg" => "用户已经存在")));
            }
            //添加
            $post['registered'] = $post['last_login'] = time();
            $post['password'] = do_hash($post['password'], 'md5');
            unset($post['rpassword']);
            $result = $this->Admin->insertAdmin($post);
            if ($result) {
                die(json_encode(array("code" => 0, "msg" => "添加用户成功")));
            }
            die(json_encode(array("code" => 1, "msg" => "添加用户失败")));
        }
    }

    public function delete_op()
    {
        $id = $this->input->post("id");
        $result = $this->Admin->delete_users($id);
        if ($result) {
            die(json_encode(array("code" => 0, "msg" => "删除用户成功")));
        }
        die(json_encode(array("code" => 1, "msg" => "删除用户失败")));
    }

}