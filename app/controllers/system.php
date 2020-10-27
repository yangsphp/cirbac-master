<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System extends QW_Controller
{
	public function __construct() {
		parent::__construct ();
		$this->load->model("System_model", 'System');
	}
	
	public function index()
    {
		$config = $this->System->getConfigs('basic');
        $this->load->view('system/index', $config);
    }
	
	public function add_op()
	{
		$type = $this->input->post('type');
		$post = $this->input->post('post');
		$result = $this->System->insert_config($type, $post);
		if ($result) {
			die(json_encode(array("code" => 0, "msg" => "设置成功")));
		}
		die(json_encode(array("code" => 1, "msg" => "设置失败")));
	}
	
	public function upload()
	{
		$config = $this->System->getConfigs('upload');
        $this->load->view('system/upload', $config);
	}
}