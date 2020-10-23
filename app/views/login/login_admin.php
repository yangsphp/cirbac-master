<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?= $web_site_title?></title>
<link rel="icon" href="favicon.ico" type="image/ico">
<meta name="keywords" content="<?= $web_site_keywords?>">
<meta name="description" content="<?= $web_site_description?>">
<meta name="author" content="Mr.Yang">
<link href="<?php echo $skin;?>new/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $skin;?>new/css/materialdesignicons.min.css" rel="stylesheet">
<link href="<?php echo $skin;?>new/css/style.min.css" rel="stylesheet">
<link href="<?php echo $skin;?>new/css/bootstrapValidator.css" rel="stylesheet">
<style>
body {
    display: -webkit-box;
    display: flex;
    -webkit-box-pack: center;
    justify-content: center;
    -webkit-box-align: center;
    align-items: center;
    height: 100%;
}
.login-box {
    display: table;
    table-layout: fixed;
    overflow: hidden;
    max-width: 700px;
}
.login-left {
    display: table-cell;
    position: relative;
    margin-bottom: 0;
    border-width: 0;
    padding: 45px;
}
.login-left .form-group:last-child {
    margin-bottom: 0px;
}
.login-right {
    display: table-cell;
    position: relative;
    margin-bottom: 0;
    border-width: 0;
    padding: 45px;
    width: 50%;
    max-width: 50%;
    background: #67b26f!important;
    background: -moz-linear-gradient(45deg,#67b26f 0,#4ca2cd 100%)!important;
    background: -webkit-linear-gradient(45deg,#67b26f 0,#4ca2cd 100%)!important;
    background: linear-gradient(45deg,#67b26f 0,#4ca2cd 100%)!important;
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#67b26f', endColorstr='#4ca2cd', GradientType=1 )!important;
}
.login-box .has-feedback.feedback-left .form-control {
    padding-left: 38px;
    padding-right: 12px;
}
.login-box .has-feedback.feedback-left .form-control-feedback {
    left: 0;
    right: auto;
    width: 38px;
    height: 38px;
    line-height: 38px;
    z-index: 4;
    color: #dcdcdc;
}
.login-box .has-feedback.feedback-left.row .form-control-feedback {
    left: 15px;
}
@media (max-width: 576px) {
  .login-right {
      display: none;
  }   
}
</style>
</head>
  
<body style="background-image: url(<?php echo $skin;?>new/images/login-bg-2.jpg); background-size: cover;">
<div class="bg-translucent p-10">
  <div class="login-box bg-white clearfix">
    <div class="login-left">
       <form id="loginform" method="post" action="#" >
        <div class="form-group has-feedback feedback-left">
          <input type="text" placeholder="请输入您的用户名" class="form-control" name="username" id="username" />
          <span class="mdi mdi-account form-control-feedback" aria-hidden="true"></span>
        </div>
        <div class="form-group has-feedback feedback-left">
          <input type="password" placeholder="请输入密码" class="form-control" id="password" name="password" />
          <span class="mdi mdi-lock form-control-feedback" aria-hidden="true"></span>
        </div>
      
        <div class="form-group">
          <label class="lyear-checkbox checkbox-primary m-t-10">
            <input type="checkbox"><span>5天内自动登录</span>
          </label>
        </div>
        <div class="form-group">
          <button class="btn btn-block btn-primary" type="button" id="btn-submit">立即登录</button>
        </div>
      </form>
    </div>
    <div class="login-right">
      <p><img src="<?php echo $skin;?>new/images/logo.png" class="m-b-md m-t-xs" alt="logo"></p>
      <p class="text-white m-tb-15">万物互联，数据互通</p>
      <p class="text-white"><?= $web_site_copyright?></p>
    </div>
  </div>
</div>
<script type="text/javascript" src="<?php echo $skin;?>new/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $skin;?>new/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $skin;?>new/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?php echo $skin;?>new/js/bootstrap-notify.min.js"></script>
<script type="text/javascript" src="<?php echo $skin;?>new/js/lightyear.js"></script>
<SCRIPT type="text/javascript">

$(document).ready(function() {
	
    $('#loginform').bootstrapValidator({
        //live: 'disabled',
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            username: {
                message: '用户名无效',
                validators: {
                    notEmpty: {
                        message: '用户名不能位空'
                    },
                    stringLength: {
                        min: 4,
                        max: 30,
                        message: '用户名必须大于4，小于30个字'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9_\.]+$/,
                        message: '用户名只能由字母、数字、点和下划线组成'
                    }
                }
            },
           
            password: {
                validators: {
                    notEmpty: {
                        message: '密码不能位空'
                    },
                    stringLength: {
                        min: 5,
                        max: 30,
                        message: '用户名必须大于5，小于30个字'
                    }
                }
            }
        }
    });


    
	$(document).keypress(function(event){
	  //回车码是13
	  	if(event.keyCode ==13){
			$("#btn-submit").trigger("click");
		}
	});
    $('#btn-submit').click(function() {
        if($('#loginform').bootstrapValidator('validate')){           
            lightyear.loading('show');
		    setTimeout(function() {		    	
		    	 $.ajax({
                        type: "POST",//方法类型
                        url: "<?php echo site_url('login/login_admin');?>",//url
                        dataType: "json",
                        data:$('#loginform').serialize(),
                        success: function (result) {
                        
                        	   if( result.message_id){ 
									lightyear.loading('hide');
					        		lightyear.notify('登录成功，页面即将自动跳转~', 'success', 3000);					    
									window.location.href="<?php echo site_url('manage/index'); ?>";
								}else{
									 lightyear.loading('hide');
					        		 lightyear.notify('登录失败', 'danger', 3000);						
								}
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            lightyear.notify('登录失败', 'danger', 3000);		
                        }
		          });
		    }, 1e3);			
        }
    });
});

</script>
</body>
</html>