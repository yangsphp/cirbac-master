<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Logs extends QW_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Logs_model", 'Logs');
    }

    public function index()
    {
        $this->load->view('Logs/index', null);
    }

    public function show_logs()
    {
		$search = " 1=1 ";
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$keyword = $this->input->post('search');
		if($start_date) {
			$search .= " and logindate >= ".strtotime($start_date);
		}
		if($end_date) {
			$search .= " and logindate <= ".strtotime($end_date);
		}
		if($keyword) {
			$search .= ' and username like "%'.$keyword.'%"';
		}
        $eachpage = isset($_POST['limit']) ? $_POST['limit'] : 10;
        $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
        $sortOrder = isset($_POST['sort']) ? $_POST['sort'] . " " . $_POST['sortOrder'] : "";
        $allLogs = $this->Logs->get_logs($offset, $eachpage, $sortOrder, $search);
		//echo $this->db->last_query();exit;
		foreach($allLogs as $k => $v) {
			$allLogs[$k]['logindate'] = date('Y-m-d H:i:s', $v['logindate']);
		}
        $infos = array('total' => count($this->Logs->get_logs("", "", "", $search)), 'rows' => $allLogs);
        echo json_encode($infos, JSON_NUMERIC_CHECK);
    }
	
	
	//============================
	

    public function add()
    {
        $title = $this->lang->line("add_Logs_title");
        $id = $this->input->get("id");
        $info = array('is_menu' => 1);
        if ($id) {
            $title = $this->lang->line("edit_Logs_title");
            //获取数据
            $data = $this->Logs->get_one_Logs($id);
            $info = $data[0];
            $info['auth'] = explode(",", $info['auth']);
        }
        $menu = $this->getCategory1($this->Logs->getMenu());
        $data['data'] = $info;
        $data['menu'] = $menu;
        $data['id'] = $id;
        $html = $this->load->view('Logs/add', $data, true);
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
            $result = $this->Logs->update_Logs($id, $post);
            if ($result) {
                die(json_encode(array("code" => 0, "msg" => $this->lang->line("edit_Logs_ok"))));
            }
            die(json_encode(array("code" => 1, "msg" => $this->lang->line("edit_Logs_error"))));
        } else {
            //添加
			$post['date_entered'] = date("Y-m-d H:i:s", time());
            $result = $this->Logs->insert($post);
            if ($result) {
                die(json_encode(array("code" => 0, "msg" => $this->lang->line("add_Logs_ok"))));
            }
            die(json_encode(array("code" => 1, "msg" => $this->lang->line("add_Logs_error"))));
        }
    }

    public function delete_op()
    {
        $id = $this->input->post("id");
        if ($id == 1) {
            die(json_encode(array("code" => 1, "msg" => '超级管理员不能被删除')));
        }
        $result = $this->Logs->delete_op($id);
        if ($result['code'] == 0) {
            die(json_encode(array("code" => 0, "msg" => $result['msg'])));
        }
        die(json_encode(array("code" => 1, "msg" => $result['msg'])));
    }
}