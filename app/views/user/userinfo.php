<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GKGD智慧商贸管理系统</title>
    <!-- ================= Favicon ================== -->
    <!-- Styles -->
  
    <link href="<?php echo $skin.$css;?>lib/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $skin.$css;?>lib/themify-icons.css" rel="stylesheet">
    <link href="<?php echo $skin.$css;?>lib/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $skin.$css;?>style.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo $skin.$css;?>lib/treegrid/bootstrap-table.css">
    <link href="<?php echo $skin.$css;?>lib/sweetalert/sweetalert.css" rel="stylesheet">
    
    
    <link href="<?php echo $skin.$css;?>lib/bootstrapValidator.css" rel="stylesheet">
    <link href="<?php echo $skin.$css;?>lib/toastr/toastr.min.css" rel="stylesheet">
    <link href="<?php echo $skin . $css; ?>lib/select/bootstrap-select.css" rel="stylesheet">
   
    <link href="<?php echo $skin . $css; ?>lib/fileinput/fileinput.css" rel="stylesheet">
    
    <script src="<?php echo $skin.$js;?>lib/jquery.min.js"></script> 
	<!-- bootstrap -->
	<script src="<?php echo $skin.$js;?>lib/bootstrap.min.js"></script><!-- 弹出框 -->
	<script src="<?php echo $skin.$js;?>lib/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="<?php echo $skin.$js;?>lib/bootstrapValidator.js"></script>
	<script src="<?php echo $skin . $js; ?>lib/select/bootstrap-select.js"></script>
	<!-- 上传附件 -->
	<script src="<?php echo $skin . $js; ?>lib/fileinput/fileinput.js"></script>
	<script src="<?php echo $skin . $js; ?>lib/fileinput/fileinput_locale_zh.js"></script>
</head>
<body>
 <div class="main">
     <div class="page-header">
          <ol class="breadcrumb">
			<li><a href="#">首页</a></li>
			<li>基础数据</li>
			<li><a href="<?php echo site_url('user');?>">用户管理</a></li>
			<li class="active">用户信息</li>
		  </ol>
	</div>

	<section id="main-content">
          <div class="row">
               <div class="col-lg-6">
                   <div class="card alert">
                      <div class="card-body">
                          <ul class="list-group">
	                          <li  class="list-group-item list-group-item-warning">账户信息</li>
	                          <li  class="list-group-item">登录账号：<?php echo $username;?></li>
	                          <li  class="list-group-item">创建人：<?php echo $adduser;?></li>
	                          <li  class="list-group-item">注册时间：<?php echo date("Y年m月d日 H时i分",$registered);?></li>
	                          <li  class="list-group-item">最后登录时间：<?php echo date("Y年m月d日 H时i分",$last_login);?></li>
	                          <li  class="list-group-item">账号状态：<?php if($state == 1){echo "正常";}else{echo "被注销";}?></li>
                           </ul>
                       </div>
                    </div>
                </div>
                <div class="col-lg-6">
                   <div class="card alert">
                      <div class="card-body">
                          <ul class="list-group">
	                          <li  class="list-group-item list-group-item-warning">身份信息</li>
	                          <li  class="list-group-item">真实姓名：<?php echo $name;?>  性别：<?php if($sex == 1){echo "男";}elseif($sex == 2 ){echo "女";}else{echo "未知";}?></li>
	                          <li  class="list-group-item">所属组织：<?php echo $gname;?>   </li>
	                          <li  class="list-group-item">
	                          	角色：<?php echo $role.nbs(10);?>    入职时间：<?php echo $entry_date;?></li>
	                          <li  class="list-group-item">地址：<?php echo $address;?></li>
	                          <li  class="list-group-item">电话：<?php echo $tell.nbs(10);?>    邮箱：<?php echo $email;?></li>
	                         
                           </ul>
                       </div>
                    </div>
                </div>
                <div class="col-lg-12">
                   <div class="card alert">
                      <div class="card-body">
                      	  <?php 
                      	  
                      	  if($manage_area_select != ""){
                      	  ?>
                      	  <ul class="list-group">
	                          <li  class="list-group-item list-group-item-warning">跟单员信息</li>
	                          <li  class="list-group-item">
	                          	        分公司分配：
		                           <select class="selectpicker" data-style="btn-warning" id="dis_area" multiple data-live-search="true">
		                           	<?php echo $manage_area_select;?>
		                           </select>
		                           <button class="btn btn-warning btn-sm m-b-10 m-l-5 RoleOfdelete" onclick="change_mange_area()">
		                           		<i class="glyphicon glyphicon-user" style="color:#fff"></i>&nbsp;重新分配
                           		   </button>
	                          </li>
                           </ul>
                      	  <?php 	
                      	  }
                      	  ?>
                       </div>
                    </div>
                </div>
                
           </div>
     </section>
</div>
<div  class="panel panel-warning">
 	<div class="panel-heading">
 		<span>个人签名</span>
 	</div>
 	<div class="panel-body">
 		<div class="col-lg-12">
			 <form enctype="multipart/form-data">
				<div class="form-group">
					 <input type="file" class="file" id="unterschrift" name="unterschrift" multiple>
					<div id="errorBlock" class="help-block"></div>
				</div>
			</form>
		</div>
 	</div>
 	<div class="panel-footer">
 						
 	</div>
</div>  

<script type="text/javascript">

$(function() {
	 //初始化fileinput
	 var fileInput = new FileInput();
	 fileInput.Init("unterschrift", "<?php echo site_url('user/upload');?>");
});
	//初始化fileinput
var FileInput = function() {
	var oFile = new Object();
	//初始化fileinput控件（第一次初始化）
	oFile.Init = function(ctrlName, uploadUrl) {
		  var control = $('#' + ctrlName);
		  //初始化上传控件的样式
	  	  control.fileinput({
		   		language: 'zh', //设置语言
		   		uploadUrl: uploadUrl, //上传的地址
		   		allowedFileExtensions: ['jpg', 'png', 'gif'], //接收的文件后缀
		   		uploadAsync: true, //默认异步上传
		   		showUpload: false, //是否显示上传按钮
		   		showRemove: true, //显示移除按钮
		   		showCaption: true, //是否显示标题
		  		dropZoneEnabled: true, //是否显示拖拽区域
		   		//minImageWidth: 50, //图片的最小宽度
		   		//minImageHeight: 50,//图片的最小高度
		   		maxImageWidth: 1000,//图片的最大宽度
		   		maxImageHeight: 1000,//图片的最大高度
		   		//maxFileSize:0,//单位为kb，如果为0表示不限制文件大小
		   		//minFileCount: 0,
		   		maxFileCount: 10, //表示允许同时上传的最大文件个数
		   		enctype: 'multipart/form-data',
		   	 	elErrorContainer: '#errorBlock',
		  		browseClass: "btn btn-primary", //按钮样式: btn-default、btn-primary、btn-danger、btn-info、btn-warning  
		   		previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
		  });
		  //文件上传完成之后发生的事件
		  $("#unterschrift").on("fileuploaded", function(event, data, previewId, index) {
	alert(data);
		  });
	 }
	 return oFile; //这里必须返回oFile对象，否则FileInput组件初始化不成功
}; 


function change_mange_area(){
	var dis_area = $("#dis_area").val();
	
	 $.ajax({
         type: "POST", dataType: "json",
         url: "<?php echo site_url('user/change_manage_area/'.$uid);?>",//url
         data: {dis_area: dis_area},
         success: function (result) {
        	 if(result.mescode){
					swal({title: "修改成功!", type: "success"},
		                	function () {  $('#dis_area').selectpicker('refresh');
		                });
			}else{
					swal({title: "修改成功!", text:result.mess +"已经有分配",type: "error"});
			}
         },
         error: function () {
             swal({title: "对不起", text: "您没有该权限或者登陆超时！", type: "error"});
         }
     });
}
  
</script>
</body>

</html>