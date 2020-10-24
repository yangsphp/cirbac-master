<?php

class Acl
{

    private $url_model;//所访问的模块，如：music
    private $url_method;//所访问的方法，如：create
    private $url_param;//url所带参数 可能是 1 也可能是 id=1&name=test
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->library('session');
        //会话过滤
        function filter()
        {
            $url = $_SERVER['PHP_SELF'];
            $arr = explode('/', $url);
            $arr = array_slice($arr, array_search('index.php', $arr) + 1, count($arr));
            $this->url_model = isset($arr[0]) ? $arr[0] : '';
            $this->url_method = isset($arr[1]) ? $arr[1] : 'index';
            $this->url_param = isset($arr[2]) ? $arr[2] : '';
        }

       
    }

    //权限过滤
    function testUrl($role_name)
    {
    	//$filename = "/usr/local/something.txt";
    	$handle = fopen($file, "r");//读取二进制文件时，需要将第二个参数设置成'rb'
    	
    	//通过filesize获得文件大小，将整个文件一下子读到一个字符串中
    	$contents = fread($handle, filesize ($file));
    	fclose($handle);
    	
    	$this->CI->load->config('acl');
        $acl = $this->CI->config->item('acl');
        $role = $acl[$role_name];
        $acl_info = $this->CI->config->item('acl_info');

        if (array_key_exists($this->url_model, $role) && in_array($this->url_method, $role[$this->url_model])) {
            ;
        } else {
            //无权限，给出提示，跳转url
            $this->CI->session->set_flashdata('info', $acl_info[$role_name]['info']);
            redirect($acl_info[$role_name]['return_url']);
        }
    }

    function testUrl2()
    {
        //这是另外一种权限过滤方法
        //$urlList = $this->CI->session->userdata('aclList');
        //$url = $_SERVER['PHP_SELF'];
        //if (in_array($url,$urlList))
        // {
        //有权限
        // } else{
        //如果用户没有权限
        // echo"<script>alert('没有访问权限');history.go(-1);</script>";
        //  exit;
        //  }
    }

    function role()
    {
    	$url = $_SERVER['PHP_SELF'];
    	$arr = explode('/', $url);
    	if(!isset($arr[array_search('index.php', $arr) + 2])){
    		$arr[array_search('index.php', $arr) + 1] = "manage";
    		$arr[array_search('index.php', $arr) + 2] = "index";
    		
    	}
    	$cur_url = $arr[array_search('index.php', $arr) + 1]."/".$arr[array_search('index.php', $arr) + 2];
    	
        if (!isset($_SESSION['username']) ) {
        	
        }else{
        	//echo $_SESSION['username']; 
        	$username = $_SESSION['username'];
        	$per='./app/config/per.php';
        	$per_file = fopen($per, "r");//读取二进制文件时，需要将第二个参数设置成'rb'
        	$contents = unserialize($this->mb_unserialize(fread($per_file,filesize($per))));
        	fclose($per_file);
        	
        	$per_urls='./app/config/per_urls.php';
        	$per_urls_file = fopen($per_urls, "r");
        	$url_contents = unserialize($this->mb_unserialize(fread($per_urls_file,filesize($per_urls))));
        	fclose($per_urls_file);
        	//通过filesize获得文件大小，将整个文件一下子读到一个字符串中
        	
        	if(array_key_exists($username,$contents) || $username == "admin" ){
        		if( (!in_array($cur_url,$url_contents)) || $username == "admin" ||  strpos($contents[$username],$cur_url) !== false  ){
        			//echo $cur_url;
        			//redirect($cur_url);
        		}else{
        			//show_error("");
        			redirect("manage/error/0");
        		}
        	}else{
        		redirect("manage/error/-2");     
        	}
        	
        }

    }

    function mb_unserialize($str)
    {
        return preg_replace_callback('#s:(\d+):"(.*?)";#s', function ($match) {
            return 's:' . strlen($match[2]) . ':"' . $match[2] . '";';
        }, $str);
    }
}

?>
