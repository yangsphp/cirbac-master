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
	    //获取导航栏
        $role = $this->db->select("r.name as role_name, r.auth")->from("users as a")->join("yang_role as r", "r.id = a.role_code", "left")->where("a.state = 1 and a.id=".$data['user_id'])->get()->row_array();
        $where = "is_menu=1 and status=1";
        if ($data['user_id'] != 7) {
            $where .= " and id in({$role['auth']})";
        }
        $auth = $this->db->where($where)->order_by("sort", "asc")->get('yang_auth')->result_array();
        $menuList = $this->getMenuTree($auth);

        //获取页面按钮id
        $menuIds = array();
        $where = "is_menu=0 and status=1";
        if ($data['user_id'] != 7) {
            $where .= " and id in({$role['auth']})";
        }
        $auth = $this->db->where($where)->order_by("sort", "asc")->get("yang_auth")->result_array();
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
		$my_class_name = get_class ( $this );
		if ($my_class_name == 'Run') {
	
			redirect ( 'Run/index' , 'refresh');
	
		} else {
			redirect ( 'login/login_admin', 'refresh' );
		}
	
	}

	function add_data(){
		
		//组织选择
		$get_group = "select  code,name from  org_stockorg";
		$groups = $this->fk1->get_db2($get_group);
		$data['groups']  = $groups;
		
		//物料分类		
		$get_meta = "select  code,name from  bd_marbasclass where length(code) = 2 ORDER BY code asc";
		$metas = $this->fk1->get_db2($get_meta);
		$data['metas']  = $metas;
		
		
		$this->load->view('manage/add_index',$data);
	}
	
	function insert_data(){
		$group = $_POST['group'];
		//$meta = $_POST['meta'];
		$code = $_POST['code'];
		$dataname = $_POST['dataname'];
		$data = array(
				'grouporg' => $group,
			   // 'meta'     => $meta,
				'code'    => $code,
				'dataname'    => $dataname
		);
		
		$resule =  $this->fk->insert($data);
		$mess = array('messcode' => $resule);
		echo json_encode($mess);
		
	}
	
	function change_data_state()
	{
		$state = $_POST['state'];
		$newinfo = array(
				'status' => $state
		);
		if(isset($_POST['id'])){
			$cid = $_POST['id'];
			$sign = $this->fk->update_data($cid, $newinfo,'id');
			if($sign) echo  1;
			else echo  0;
		}elseif(isset($_POST['ids'])){
			$ids = $_POST['ids'];
			$cids = explode(",",$ids);
			$id = 0;
			foreach($cids as $value){
				$id += $this->fk->update_data($value, $newinfo,'id');
			}
	
			$mess = array('messcode' => $id,'cids'=>$cids);
			echo json_encode($mess);
		}
	}
	
	function del_datas(){
		if(isset($_POST['id'])){
			$cid = $_POST['id'];
			$sign = $this->fk->delete_data($cid);
			if($sign)  $mess = array('messcode' => 1);
			else $mess = array('messcode' => 0);
			echo json_encode($mess);
		}elseif(isset($_POST['ids'])){
			$ids = $_POST['ids'];
			$cids = explode(",",$ids);
			$id = 0;
			foreach($cids as $value){
				$id += $this->fk->delete_data($value);
			}
			$mess = array('messcode' => $id);
			echo json_encode($mess);
		}
		 
	}
	
	function look_data($id){
		$datainfo = $this->fk->get_one_data($id);
		
		
		$data = array();
		
		if(strstr($datainfo['code'],"/")){
			
			$code = array_filter(explode("/", $datainfo['code']));
			foreach($code as $value){
				$con1 = "bd_material_v.code = '".$value."'"; //选择物料
				$con2 = " and ic_onhandnum.nonhandnum > 0 ";//限制数量
				$con3 = " and org_stockorg.code  = ".$datainfo['grouporg']; //选择组织
				$sql = "select
	    		    bd_material_v.name    as 物料名称,
	    		    bd_material_v.code    as 物料编码,
	    		    bd_material_v.materialspec  as 物料规格,
	    		    bd_material_v.materialtype  as  物料型号,
	    		    org_stockorg.name     as 所属组织,
				    bd_measdoc.name as  单位,
	    		    sum(ic_onhandnum.nonhandnum)  as 结存数量
	    		 from ic_onhandnum
	    		 LEFT  JOIN ic_onhanddim  ON ic_onhandnum.pk_onhanddim = ic_onhanddim.pk_onhanddim
	    		 LEFT  JOIN bd_material_v ON ic_onhanddim.cmaterialvid  = bd_material_v.pk_material
	    		 LEFT  JOIN org_stockorg  ON ic_onhanddim.pk_org = org_stockorg.pk_stockorg
				 LEFT  JOIN bd_measdoc    ON bd_material_v.pk_measdoc  =  bd_measdoc.pk_measdoc
	    		where ".$con1.$con2.$con3." group by bd_material_v.code,bd_material_v.name,bd_material_v.materialspec,bd_material_v.materialtype ,org_stockorg.name ,org_stockorg.code,bd_measdoc.name";
				$res=$this->fk1->get_db2($sql);
				if(!empty($res)){
					$data['onedata'][] = $res[0];
				}
				
			}
		}else{
			$con1 = "bd_material_v.code = '".$datainfo['code']."'"; //选择物料
			$con2 = " and ic_onhandnum.nonhandnum > 0 ";//限制数量
			$con3 = " and org_stockorg.code  = ".$datainfo['grouporg']; //选择组织
			$sql = "select
	    		    bd_material_v.name    as 物料名称,
	    		    bd_material_v.code    as 物料编码,
	    		    bd_material_v.materialspec  as 物料规格,
	    		    bd_material_v.materialtype  as  物料型号,
	    		    org_stockorg.name     as 所属组织,
				    bd_measdoc.name as  单位,
	    		    sum(ic_onhandnum.nonhandnum)  as 结存数量
	    		 from ic_onhandnum
	    		 LEFT  JOIN ic_onhanddim  ON ic_onhandnum.pk_onhanddim = ic_onhanddim.pk_onhanddim
	    		 LEFT  JOIN bd_material_v ON ic_onhanddim.cmaterialvid  = bd_material_v.pk_material
	    		 LEFT  JOIN org_stockorg  ON ic_onhanddim.pk_org = org_stockorg.pk_stockorg
				 LEFT  JOIN bd_measdoc    ON bd_material_v.pk_measdoc  =  bd_measdoc.pk_measdoc
	    		where ".$con1.$con2.$con3." group by bd_material_v.code,bd_material_v.name,bd_material_v.materialspec,bd_material_v.materialtype ,org_stockorg.name ,org_stockorg.code,bd_measdoc.name";
			$res=$this->fk1->get_db2($sql);
			$data['onedata'] = $res[0];
		} 
		
		$data['datainfo'] = $datainfo;
		//print_r($res[0]);
	    $this->load->view("manage/show_onedata",$data);
	
	}
	
	function error($error){
		$data['eid'] = $error;
		$data['error'] = array( '0' => "对不起，您没有该权限！", '1'=>"你有权限！",'-1'=>"对不起，您已登录超时！","-2"=>"对不起，您没有该权限！","-3"=>"对不起，该操作错误！");
		$this->load->view("manage/error",$data);
		
	}
	
	function read_flie($url=""){
		if(isset($_POST['dataname'])){
			$url = "//192.168.253.67/abc/bcd.xlsx";
			//$getcontent = file_get_contents($url);
			//如果出现中文乱码使用下面代码
			//$getcontent = mb_convert_encoding(file_get_contents($url), "utf-8","GBK");
			$getcontent = iconv("GB2312","UTF-8",file_get_contents($url));
			//$getcontent = iconv("UTF-8","GB2312",file_get_contents($url));
			//echo $getcontent;
			$mess = array('messcode' => $getcontent);
			echo $getcontent;
		}else{
			$this->load->view("manage/file_show");
		}
		
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