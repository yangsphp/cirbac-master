<?php $this->load->view('common/header')?>
<div class="container-fluid p-t-15">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <ul class="nav nav-tabs page-tabs">
          <li class="active"> <a href="#!">文件上传</a> </li>
		  <!--
          <li> <a href="lyear_pages_config_system.html">系统</a> </li>
		  -->
          <li> <a href="<?php echo site_url('system/upload')?>">上传</a> </li>
		  
        </ul>
        <div class="tab-content">
          <div class="tab-pane active">
            
            <form action="#!" method="post" name="config-basic-form" class="config-basic-form">
              <div class="form-group">
                <label for="web_site_title">文件上传</label>
                <input type="file" id="example-file-input" name="file">
              </div>
              <div class="form-group">
				<input type="hidden" name="type" value="basic"/>
                <button id="basic-save" type="button" class="btn btn-primary m-r-5">确 定</button>
              </div>
            </form>
            
          </div>
        </div>

      </div>
    </div>
    
  </div>
  
</div>
<?php $this->load->view('common/footer')?>
<script type="text/javascript" src="<?php echo $skin; ?>new/js/main.min.js"></script>
<script>
$('#basic-save').click(function(){
	lightyear.loading('show');
	setTimeout(function() {
		var files = $('#example-file-input').prop('files');
		var data = new FormData();
        data.append('file', files[0]);
		 $.ajax({
			  type: "POST",//方法类型
			  url: "<?php echo site_url('test/add_op');?>",
			  data: data,
			  processData: false,
              contentType: false,
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