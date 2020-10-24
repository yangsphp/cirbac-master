<?php
if (!defined('BASEPATH'))
    exit ('No direct script access allowed');

class Database extends QW_Controller{
	public function __construct()
    {
        parent::__construct();
        $this->load->model("Database_model", 'Database');
    }
	public function index()
    {
        $this->load->view('database/index', null);
    }
	
	public function show_database()
    {
        $alldatabases = $this->Database->get_database();
        $infos = array('total' => count($alldatabases), 'rows' => $alldatabases);
        echo json_encode($infos, JSON_NUMERIC_CHECK);
    }
	
	public function show_back()
	{
		$search = '1=1';
        $eachpage = isset($_POST['limit']) ? $_POST['limit'] : 10;
        $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
        $sortOrder = isset($_POST['sort']) ? $_POST['sort'] . " " . $_POST['sortOrder'] : "";
        $allbacks = $this->Database->get_backs($offset, $eachpage, $sortOrder, $search);
        $infos = array('total' => count($this->Database->get_backs("", "", "", $search)), 'rows' => $allbacks);
        echo json_encode($infos, JSON_NUMERIC_CHECK);
	}
	
	public function repair_op()
	{
		$table = $this->input->post("table");
        if ($table) {
            $this->Database->repair($table);
            die(json_encode(array("code" => 0, "msg" => "修复表{$table}成功")));
        }
        die(json_encode(array("code" => 1, "msg" => "修复表{$table}失败")));
	}
	
	public function optimize_op()
    {
        $table = $this->input->post("table");
        if ($table) {
            $this->Database->optimize($table);
            die(json_encode(array("code" => 0, "msg" => "优化表{$table}成功")));
        }
        die(json_encode(array("code" => 1, "msg" => "优化表{$table}失败")));
    }
	
	public function back_op()
    {
        $table = $this->input->post("table");
        $table = explode(',', $table);
        $result = $this->Database->backup($table);
        if ($result) {
            die(json_encode(array("code" => 0, "msg" => "备份成功")));
        }
        die(json_encode(array("code" => 1, "msg" => "备份失败")));
    }
	
	public function dict()
    {
        $table = $this->input->get("table");
        $dict = $this->Database->dict($table);
        $data['table'] = $table;
		$data['dict'] = $dict;
        $html = $this->load->view('database/dict', $data, true);
        echo json_encode(array("title" => $table, "html" => $html));
    }
	
	public function dict_op()
    {
        $table = $this->input->post("table");
        $field = $this->input->post("Field");
        $type = $this->input->post("Type");
        if ($table) {
            //修改
            $result = $this->Database->update_table($table, $field, $type);
            if ($result) {
                die(json_encode(array("code" => 0, "msg" => "修改字典成功")));
            }
            die(json_encode(array("code" => 1, "msg" => "修改字典失败")));
        }
        die(json_encode(array("code" => 1, "msg" => "数据表不存在")));
    }
	
	public function data()
	{
		$this->load->view('database/data', null);
	}
	
	public function callback_op()
    {
        $id = $this->input->post("id");
        $back = $this->Database->getBackUpById($id);
        $this->db->trans_start();
        $file = fopen(FCPATH . $back['path'], 'rb');
        $table_array = explode(",", $back['table']);
        foreach ($table_array as $table) {
            $this->db->query("truncate $table");
        }
        while (($sql = fgets($file, 4096)) !== false) {
            if (strpos($sql, '--') === false){
                $this->db->query($sql);
            }
        }
        fclose($file);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            die(json_encode(array("code" => 1, "msg" => "数据还原失败")));
        }
        $this->db->trans_commit();
        die(json_encode(array("code" => 0, "msg" => "数据还原成功")));

    }
	
	public function delete_op()
    {
        $id = $this->input->post("id");
        $result = $this->Database->delete_op($id);
        if ($result) {
            die(json_encode(array("code" => 0, "msg" => "删除备份成功")));
        }
        die(json_encode(array("code" => 1, "msg" => "删除备份失败")));
    }
}