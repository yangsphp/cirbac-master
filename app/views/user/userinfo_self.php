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
	<script type="text/javascript" src='<?php echo $skin . $js; ?>upload/jquery.js'></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $skin . $js; ?>upload/css/webuploader.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $skin . $js; ?>upload/css/diyUpload.css">
	<script type="text/javascript" src="<?php echo $skin . $js; ?>upload/js/webuploader.html5only.min.js"></script>
	<script type="text/javascript" src="<?php echo $skin . $js; ?>upload/js/diyUpload.js"></script>
		
</head>
<body>
 <div class="main">
     <div class="page-header">
          <ol class="breadcrumb">
			<li><a href="#">首页</a></li>
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
               
           </div>
     </section>
</div>
<div  class="panel panel-warning">
 	<div class="panel-heading">
 		<span>个人签名</span>
 	</div>
 	<div class="panel-body">
 		<div class="col-lg-12">
 		<?php 
 		if($sign_url != ""){
 		?>
 		<img src="<?php echo base_url();?>file/qm/<?php echo $sign_url;?>" height="65px">
 		<button class="btn btn-warning btn-sm" onclick="delete_img()" style="margin:0 5px;">
               <i class="glyphicon glyphicon-user" style="color:#fff"></i>&nbsp;删除
        </button>
 		<?php 	
 		}else{
 		?>	
 		<div id="box"><div id="test" ></div></div>
		<?php 
 		}
 		?>
 			
			 
		</div>
 	</div>
 	<div class="panel-footer">
 						
 	</div>
</div>  

<script type="text/javascript">

$('#test').diyUpload({
	url:"<?php echo site_url('user/upload');?>",
	success:function( data ) {
		 var url = "<?php echo site_url('user/userinfo_self/'.$id);?>";
	     window.location.href = url;
	},
	error:function( err ) {
		console.info( err );	
		
	}
});
function delete_img(){
	swal({title: "您确定要删除吗？",type: "warning",
        showCancelButton: true,confirmButtonColor: "#DD6B55",
        confirmButtonText: "确定",closeOnConfirm: false,showLoaderOnConfirm: true,
        }, function () {
            setTimeout(function () {
                $.ajax({
                    type: "POST",//方法类型
                    dataType: "json",//预期服务器返回的数据类型
                    url: "<?php echo site_url('user/delete_img/'.$id);?>",
                    success: function (result) {
                    	  if(result.messcode > 0 ){
                    		  swal({title: "操作成功!", type: "success"},function(){
                    			  var url = "<?php echo site_url('user/userinfo_self/'.$id);?>";
                    			     window.location.href = url;
                        	});
                          }else{
                              swal({title: "删除失败!", type: "error"});
                          }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        swal({title: "对不起", text: XMLHttpRequest.statusText   , type: "error"});
                    }
                });
            }, 1000);
        });
}
</script>
</body>

</html>