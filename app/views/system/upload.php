<?php $this->load->view('common/header')?>
<!--标签插件-->
<link rel="stylesheet" href="<?php echo $skin; ?>new/js/jquery-tags-input/jquery.tagsinput.min.css">
<div class="container-fluid p-t-15">
  
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <ul class="nav nav-tabs page-tabs">
          <li > <a href="#!">基本</a> </li>
		  <!--
          <li> <a href="lyear_pages_config_system.html">系统</a> </li>
		  -->
          <li class="active"> <a href="<?php echo site_url('system/upload')?>">上传</a> </li>
		  
        </ul>
        <div class="tab-content">
          <div class="tab-pane active">
            
            <form action="#!" method="post" name="config-upload-form" class="config-upload-form">
              <div class="form-group">
                <label for="upload_file_ext">允许上传的文件类型</label>
                <input class="js-tags-input form-control" type="text" id="upload_file_ext" name="post[upload_file_ext]" value="<?= @$upload_file_ext?>" >
                <small class="help-block">多个后缀用逗号隔开，不填写则不限制类型</small>
              </div>
              <div class="form-group">
                <label for="upload_file_size">允许上传大小限制</label>
                <input class="form-control" type="text" id="upload_file_size" name="post[upload_file_size]" value="<?php echo @$upload_file_size ? @$upload_file_size : 0?>" placeholder="请输入文件上传大小限制" >
                <small class="help-block">0为不限制大小，单位：kb</small>
              </div>
              <div class="form-group">
				<input type="hidden" name="type" value="upload"/>
                <button type="button" class="btn btn-primary m-r-5" id="upload-save">确 定</button>
              </div>
            </form>
            
          </div>
        </div>

      </div>
    </div>
    
  </div>
  
</div>
<?php $this->load->view('common/footer')?>
<!--标签插件-->
<script src="<?php echo $skin; ?>new/js/jquery-tags-input/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo $skin; ?>new/js/main.min.js"></script>
<script>
$('#upload-save').click(function(){
	lightyear.loading('show');
	setTimeout(function() {               
	 $.ajax({
		  type: "POST",//方法类型
		  url: "<?php echo site_url('system/add_op');?>",
		  data: $('.config-upload-form').serialize(),
		  dataType: 'json',
		  success: function (result) {
			  if(result.code == 0){ 
				  lightyear.notify(result.msg, 'success', 3000); 
			  }else{
				  lightyear.notify(result.msg, 'danger', 3000);            
			  }
		  },
		  error: function (XMLHttpRequest, textStatus, errorThrown) {
			 lightyear.notify('对不起，添加失败', 'danger', 3000);
		  },
		  complete: function() {
			lightyear.loading('hide');
		  }
		});
	}, 1e3);
});
</script>