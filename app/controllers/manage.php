<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );

class Manage extends QW_Controller {

	public function __construct() {
		parent::__construct ();
		//var_dump(get_class());exit();
	}

	public function index()
	{
	    $data= array();
	    $data['username'] = $this->session->userdata ( "username" );
	    $data['user_id'] = $this->session->userdata("user_id");
		$tables = $this->config->item('tables');
	    //获取导航栏
        $role = $this->db->select("r.name as role_name, r.auth")->from($tables['users']." as a")->join($tables['role']." as r", "r.id = a.role_code", "left")->where("a.state = 1 and a.id=".$data['user_id'])->get()->row_array();
        $where = "is_menu=1 and status=1";
        if ($data['user_id'] != 7) {
            $where .= " and id in({$role['auth']})";
        }
        $auth = $this->db->where($where)->order_by("sort", "asc")->get($tables['auth'])->result_array();
        $menuList = $this->getMenuTree($auth);

        //获取页面按钮id
        $menuIds = array();
        $where = "is_menu=0 and status=1";
        if ($data['user_id'] != 7) {
            $where .= " and id in({$role['auth']})";
        }
        $auth = $this->db->where($where)->order_by("sort", "asc")->get($tables['auth'])->result_array();
        foreach ($auth as $k => $v)
        {
            $menuIds[] = $v['id'];
        }
        $data['role_name'] = $role['role_name'];
        $this->session->set_userdata("menuIds", implode(',', $menuIds));
        $this->session->set_userdata("menuList", $menuList);
		$this->load->view('manage/man_index',$data);
	}

    function  get_main(){

        $this->load->view('manage/show_data');
    }
 
	
	public function login_out() {
		$this->session->sess_destroy ();
		redirect ( 'login/login_admin', 'refresh' );
	}
	
	function excell(){ //数据导出
	// $query = mb_convert_encoding("gb2312", "UTF-8", $query);if(!$query)return false;
		// Starting the PHPExcel library
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Hello1')->setCellValue('B1', 'world!')->setCellValue('C1', 'Hello');// Field names in the first row
		$fields = array("序号","姓名","电话","性别");
		$col = 0;
		foreach ($fields as $field){
			$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
			$col++;
		}
		// Fetching the table data
		$row = 2;
		$rows = array(
					array(1,"巩江伟","18535598955","男"),
					array(2,"巩江伟","18535598955","男"),
					array(3,"巩江伟","18535598955","男"),
		);
		foreach($rows as $data){
			$col = 0;
			foreach ($fields as $field){
				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data[$col]);
				$col++;
			}
			$row++;
		}
		$objPHPExcel->setActiveSheetIndex(0);
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');
		//发送标题强制用户下载文件
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Products_'.date('dMy').'.xlsx"');
		header('Cache-Control: max-age=0');
		//$objWriter->save('//file');
	}
	
	function read_csv(){
		//$url = "//192.168.253.67/abc/bcd.xlsx";
		$filename	=	'//192.168.249.224/ns_data/SC/SC_WB_Hans5201#_Hans5210_20200609091751640.csv';
		$handle		=	fopen($filename,'r');
		for($i = 1;$i<9;$i++){
			$row		=	fgetcsv($handle);
			
		}
	
	}

}

/* End of file: dashboard.php */
/* Location: application/controllers/admin/dashboard.php */