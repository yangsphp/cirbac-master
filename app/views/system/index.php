<?php $this->load->view('common/header')?>
<div class="container-fluid p-t-15">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <ul class="nav nav-tabs page-tabs">
          <li class="active"> <a href="#!">基本</a> </li>
		  <!--
          <li> <a href="lyear_pages_config_system.html">系统</a> </li>
		  -->
          <li> <a href="<?php echo site_url('system/upload')?>">上传</a> </li>
		  
        </ul>
        <div class="tab-content">
          <div class="tab-pane active">
            
            <form action="#!" method="post" name="config-basic-form" class="config-basic-form">
              <div class="form-group">
                <label for="web_site_title">网站标题</label>
                <input class="form-control" type="text" id="web_site_title" name="post[web_site_title]" value="<?= @$web_site_title?>" placeholder="请输入站点标题" >
              </div>
			  <!--
              <div class="form-group">
                <label for="web_site_logo">LOGO图片</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="web_site_logo" id="web_site_logo" value="/home/images/logo.png" />
                  <div class="input-group-btn"><button class="btn btn-default" type="button">上传图片</button></div>
                </div>
              </div>
			  -->
              <div class="form-group">
                <label for="web_site_keywords">站点关键词</label>
                <input class="form-control" type="text" id="web_site_keywords" name="post[web_site_keywords]" value="<?= @$web_site_keywords?>" placeholder="请输入站点关键词" >
                <small class="help-block">网站搜索引擎关键字</small>
              </div>
              <div class="form-group">
                <label for="web_site_description">站点描述</label>
                <textarea class="form-control" id="web_site_description" rows="5" name="post[web_site_description]" placeholder="请输入站点描述" ><?= @$web_site_description?></textarea>
                <small class="help-block">网站描述，有利于搜索引擎抓取相关信息</small>
              </div>
              <div class="form-group">
                <label for="web_site_copyright">版权信息</label>
                <input class="form-control" type="text" id="web_site_copyright" name="post[web_site_copyright]" value="<?= @$web_site_copyright?>" placeholder="请输入版权信息" >
              </div>
			  
			  <!--
			  
              <div class="form-group">
                <label for="web_site_icp">备案信息</label>
                <input class="form-control" type="text" id="web_site_icp" name="web_site_icp" value="" placeholder="请输入备案信息" >
                <small class="help-block">调用方式：<code>config('web_site_icp')</code></small>
              </div>
			  
              <div class="form-group">
                <label class="btn-block" for="web_site_status">站点开关</label>
                <label class="lyear-switch switch-solid switch-primary">
                  <input type="checkbox" checked="">
                  <span></span>
                </label>
                <small class="help-block">站点关闭后将不能访问，后台可正常登录</small>
              </div>
			  -->
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
	 $.ajax({
		  type: "POST",//方法类型
		  url: "<?php echo site_url('system/add_op');?>",
		  data: $('.config-basic-form').serialize(),
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