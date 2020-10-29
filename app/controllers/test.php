<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends QW_Controller
{
	public function __construct() {
		parent::__construct ();
	}
	
	public function index()
    {
		$config = $this->System->getConfigs('basic');
        $this->load->view('test/index', $config);
    }
	
	public function add_op()
	{
		$path = './upload/file/'.date('Y-m-d').'/';
		if(!file_exists($path)) {
			mkdir($path);
		}
		
        $config['upload_path'] = $path;
        $config['allowed_types'] = str_replace(',', '|', $this->setting['upload_file_ext']);
        $config['max_size'] = $this->setting['upload_file_size'] * 1024;
		
        $this->load->library('upload', $config);
		if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            die(json_encode(array("code" => 1, "error" => $error)));
        } else {
			$upload_info = $this->upload->data();
			$data = array(
				'url' => trim($path, '.').$upload_info['file_name'],
				'size' => $upload_info['file_size'],
				'ext' => $upload_info['image_type'],
				'width' => $upload_info['image_width'],
				'height' => $upload_info['image_height'],
				'username' => $this->session->userdata('username'),
				'date_entered' => date('Y-m-d H:i:s', time()),
			);
			$userid = $this->session->userdata('user_id');
			$tables = $this->config->item("tables");
			$upload_table = $tables['upload_'.($userid%10)];
			$this->db->insert($upload_table, $data);
            die(json_encode(array("code" => 0, "path" => $data['url'])));
        }
	}
	
	public function upload()
	{
		$config = $this->System->getConfigs('upload');
        $this->load->view('system/upload', $config);
	}
}