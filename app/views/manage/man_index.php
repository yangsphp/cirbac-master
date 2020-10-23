<!DOCTYPE html>
<html lang="zh">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title>仓库管理系统系统</title>
<link rel="icon" href="favicon.ico" type="image/ico">
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="">
<link href="<?php echo $skin;?>new/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo $skin;?>new/css/materialdesignicons.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $skin;?>new/js/bootstrap-multitabs/multitabs.min.css">
<link href="<?php echo $skin;?>new/css/style.min.css" rel="stylesheet">
</head>
<?php
    $menuList = $this->session->userdata("menuList");
?>
<body>
<div class="lyear-layout-web">
  <div class="lyear-layout-container">
    <!--左侧导航-->
    <aside class="lyear-layout-sidebar">
      
      <!-- logo -->
      <div id="logo" class="sidebar-header">
        <a href="index.html"><img src="<?php echo $skin;?>new/images/logo-sidebar.png" title="LightYear" alt="LightYear" /></a>
      </div>
      <div class="lyear-layout-sidebar-scroll"> 
        
        <nav class="sidebar-main">
          <ul class="nav nav-drawer">
            <li class="nav-item active"> 
            	<a class="multitabs" href="<?php echo site_url('manage/get_main');?>"><i class="mdi mdi-home"></i> <span>系统首页</span></a> 
            </li>
            <?php foreach ($menuList as $k => $v) {?>
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-palette"></i> <span><?php echo $v['name']?></span></a>
              <?php if(isset($v['submenu'])){?>
              <ul class="nav nav-subnav">
                <?php foreach ($v['submenu'] as $key => $value) {?>
                <li> <a class="multitabs" href="<?php echo site_url($value['url']);?>"><?php echo $value['name']?></a> </li>
                <?php }?>
              </ul>
              <?php }?>
            </li>
            <?php }?>
            <!--
            <li class="nav-item nav-item-has-subnav">
              <a href="javascript:void(0)"><i class="mdi mdi-palette"></i> <span>生产管理</span></a>
              <ul class="nav nav-subnav">
                <li> <a class="multitabs" href="<?php echo site_url('produce/index');?>">生产指令</a> </li>
                <li> <a class="multitabs" href="<?php echo site_url('order/index');?>">预约入库</a> </li>
              
              </ul>
            </li>-->
          </ul>
        </nav>
        
        <div class="sidebar-footer">
          <p class="copyright">Copyright &copy; 2020. <a target="_blank" href="http://lyear.itshubao.com">LaoJiang</a> All rights reserved.</p>
        </div>
      </div>
      
    </aside>
    <!--End 左侧导航-->
    
    <!--头部信息-->
    <header class="lyear-layout-header">
      
      <nav class="navbar navbar-default">
        <div class="topbar">
          
          <div class="topbar-left">
            <div class="lyear-aside-toggler">
              <span class="lyear-toggler-bar"></span>
              <span class="lyear-toggler-bar"></span>
              <span class="lyear-toggler-bar"></span>
            </div>
          </div>
          
          <ul class="topbar-right">
            <li class="dropdown dropdown-profile">
              <a href="javascript:void(0)" data-toggle="dropdown">
                <img class="img-avatar img-avatar-48 m-r-10" src="<?php echo $skin;?>new/images/users/avatar.jpg" alt="" />
                <span>
                <?php echo @$username;?>
                <span class="caret"></span></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-right">
                <li> <a class="multitabs" data-url="lyear_pages_profile.html" href="javascript:void(0)"><i class="mdi mdi-account"></i> 个人信息</a> </li>
                <li> <a class="multitabs" data-url="lyear_pages_edit_pwd.html" href="javascript:void(0)"><i class="mdi mdi-lock-outline"></i> 修改密码</a> </li>
                <li> <a href="javascript:void(0)"><i class="mdi mdi-delete"></i> 清空缓存</a></li>
                <li class="divider"></li>
                <li> <a href="<?php echo site_url('manage/login_out');?>"><i class="mdi mdi-logout-variant"></i> 退出登录</a> </li>
              </ul>
            </li>
            <!--切换主题配色-->
		    <li class="dropdown dropdown-skin">
			  <span data-toggle="dropdown" class="icon-palette"><i class="mdi mdi-palette"></i></span>
			  <ul class="dropdown-menu dropdown-menu-right" data-stopPropagation="true">
			    <li class="drop-title"><p>LOGO</p></li>
				<li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="logo_bg" value="default" id="logo_bg_1">
                    <label for="logo_bg_1"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_2" id="logo_bg_2">
                    <label for="logo_bg_2"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_3" id="logo_bg_3">
                    <label for="logo_bg_3"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_4" id="logo_bg_4">
                    <label for="logo_bg_4"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_5" id="logo_bg_5" checked>
                    <label for="logo_bg_5"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_6" id="logo_bg_6">
                    <label for="logo_bg_6"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_7" id="logo_bg_7">
                    <label for="logo_bg_7"></label>
                  </span>
                  <span>
                    <input type="radio" name="logo_bg" value="color_8" id="logo_bg_8">
                    <label for="logo_bg_8"></label>
                  </span>
				</li>
				<li class="drop-title"><p>头部</p></li>
				<li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="header_bg" value="default" id="header_bg_1">
                    <label for="header_bg_1"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_2" id="header_bg_2">
                    <label for="header_bg_2"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_3" id="header_bg_3">
                    <label for="header_bg_3"></label>
                  </span>
                  <span>
                    <input type="radio" name="header_bg" value="color_4" id="header_bg_4">
                    <label for="header_bg_4"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_5" id="header_bg_5" checked>
                    <label for="header_bg_5"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_6" id="header_bg_6">
                    <label for="header_bg_6"></label>                      
                  </span>                                                    
                  <span>                                                     
                    <input type="radio" name="header_bg" value="color_7" id="header_bg_7">
                    <label for="header_bg_7"></label>
                  </span>
                  <span>
                    <input type="radio" name="header_bg" value="color_8" id="header_bg_8">
                    <label for="header_bg_8"></label>
                  </span>
				</li>
				<li class="drop-title"><p>侧边栏</p></li>
				<li class="drop-skin-li clearfix">
                  <span class="inverse">
                    <input type="radio" name="sidebar_bg" value="default" id="sidebar_bg_1" >
                    <label for="sidebar_bg_1"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_2" id="sidebar_bg_2">
                    <label for="sidebar_bg_2"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_3" id="sidebar_bg_3">
                    <label for="sidebar_bg_3"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_4" id="sidebar_bg_4">
                    <label for="sidebar_bg_4"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_5" id="sidebar_bg_5" checked>
                    <label for="sidebar_bg_5"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_6" id="sidebar_bg_6">
                    <label for="sidebar_bg_6"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_7" id="sidebar_bg_7">
                    <label for="sidebar_bg_7"></label>
                  </span>
                  <span>
                    <input type="radio" name="sidebar_bg" value="color_8" id="sidebar_bg_8">
                    <label for="sidebar_bg_8"></label>
                  </span>
				</li>
			  </ul>
			</li>
            <!--切换主题配色-->
          </ul>
          
        </div>
      </nav>
      
    </header>
    <!--End 头部信息-->
    
    <!--页面主要内容-->
    <main class="lyear-layout-content">
      
      <div id="iframe-content" ></div>
      
    </main>
    <!--End 页面主要内容-->
  </div>
</div>

<script type="text/javascript" src="<?php echo $skin;?>new/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $skin;?>new/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo $skin;?>new/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $skin;?>new/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="<?php echo $skin;?>new/js/bootstrap-multitabs/multitabs.js"></script>
<script type="text/javascript" src="<?php echo $skin;?>new/js/index.min.js"></script>
<script type="text/javascript" >
	// 选项卡
    $('#iframe-content').multitabs({
        iframe : true,
        nav: {
            backgroundColor: '#ffffff',
            maxTabs : 35, // 选项卡最大值
        },
        init : [{
            type : 'main',
            title : '首页',
            url : "<?php echo site_url('manage/get_main');?>"
        }]
    });
</script>
</body>
</html>