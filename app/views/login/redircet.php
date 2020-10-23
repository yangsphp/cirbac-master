
<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>联网系统</title>
<link rel="icon" href="favicon.ico" type="image/ico">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<link href="<?php echo $skin;?>new/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $skin;?>new/css/materialdesignicons.min.css" rel="stylesheet">
<link href="<?php echo $skin;?>new/css/style.min.css" rel="stylesheet">

<script type="text/javascript" src="<?php echo $skin;?>new/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $skin;?>new/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $skin;?>new/js/main.min.js"></script>  
<script type="text/javascript">
     $(document).ready(function(){
    	 var value = 0;
         var time = 200;
    	//显示
    	 $("#login_out").modal();
    	 //隐藏
    	
      
       //进度条复位函数
       //function reset( ) {
        //value = 0
         //$("#prog").removeClass("progress-bar-success").css("width","0%").text("等待启动");
         //setTimeout(increment,5000);
       //}
       //百分数增加，0-30时为红色，30-60为黄色，60-90为蓝色，>90为绿色
       function increment( ) {
         value += 10;
         $("#prog").css("width",value + "%").text(value + "%");
         if (value>=0 && value<=30) {
           $("#prog").addClass("progress-bar-danger");
         }
         else if (value>=30 && value <=60) {
           $("#prog").removeClass("progress-bar-danger");
           $("#prog").addClass("progress-bar-warning");
         }
         else if (value>=60 && value <=90) {
           $("#prog").removeClass("progress-bar-warning");
           $("#prog").addClass("progress-bar-info");
         }
         else if(value >= 90 && value<100) {
           $("#prog").removeClass("progress-bar-info");
           $("#prog").addClass("progress-bar-success");
         }
         else{
           $("#login_out").modal('hide');
	       window.parent.location.href='<?php echo site_url('login/login_admin');?>';
           
         }
         st = setTimeout(increment,time);
       }
       increment();
       //进度条停止与重新开始
       //$("#stop").click(function () {
        // if ("stop" == $("#stop").val()) {
           //$("#prog").stop();
           //clearTimeout(st);
           //$("#prog").css("width","0%").text("等待启动");
           //$("#stop").val("start").text("重新开始");
         //} else if ("start" == $("#stop").val()) {
           //increment();
          // $("#stop").val("stop").text("停止");
        //}
      // });
       //进度条暂停与继续
       //$("#pause").click(function() {
         //if ("pause" == $("#pause").val()) {
           //$("#prog").stop();
           //clearTimeout(st);
           //$("#pause").val("goon").text("继续");
        // } else if ("goon" == $("#pause").val()) {
           //increment();
           //$("#pause").val("stop").text("暂停");
         //}
       //});
     });
   </script>
</head>
<body>
<div class="modal fade bs-example-modal-lg" tabindex="-1" id="login_out"  role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
	      <div class="modal-content">
		        <div class="modal-header">
		          	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		          	<h4 class="modal-title" id="myLargeModalLabel">页面跳转</h4>
		        </div>
		        <div class="modal-body">
	          		 <div class="progress">
			            <div id="prog" class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="100" aria-valuemax="100" style="width: 0%" >
			              <span class="sr-only">页面跳转中....</span>
			            </div>
			          </div>
		        </div>
		        <div class="modal-footer"></div>
	      </div>
    </div>
</div>
</body>

</html>