<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GKGD数据管理系统 - 老姜（JON）后台管理系统</title>
<link rel="shortcut icon" type="image/x-ico" href="www.gkgd.com/nxt/favicon.ico" />
<link rel="stylesheet" href="<?php echo $skin.$css;?>bootstrap.css" />
<script type="text/javascript" src="<?php echo $skin.$js;?>jquery1.9.0.min.js"></script>
<script type="text/javascript" src="<?php echo $skin.$js;?>bootstrap.min.js"></script>
<style type="text/css">
body{ background:#2e6492 no-repeat center 0px;}
.tit{ margin:auto; margin-top:170px; text-align:center; width:350px; padding-bottom:20px;}
.login-wrap{ width:220px; padding:30px 50px 0 330px; height:220px; background:#fff url(<?php echo $skin.$images;?>login/20150212154319.jpg) no-repeat 30px 40px; margin:auto; overflow: hidden;}
.login_input{ display:block;width:210px;}
.login_user{ background: url(<?php echo $skin.$images;?>login/input_icon_1.png) no-repeat 200px center; font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif}
.login_password{ background: url(<?php echo $skin.$images;?>login/input_icon_2.png) no-repeat 200px center; font-family:"Courier New", Courier, monospace}
.btn-login{ background:#40454B; box-shadow:none; text-shadow:none; color:#fff; border:none;height:35px; line-height:26px; font-size:14px; font-family:"microsoft yahei";}
.btn-login:hover{ background:#333; color:#fff;}
.copyright{ margin:auto; margin-top:10px; text-align:center; width:370px; color:#CCC}
@media (max-height: 700px) {.tit{ margin:auto; margin-top:100px; }}
@media (max-height: 500px) {.tit{ margin:auto; margin-top:50px; }}
</style>
</head>

<body>
<div class="tit"><img src="<?php echo $skin.$images;?>login/tit.png" alt="" /></div>
<div class="login-wrap">
   <form action="<?php echo site_url('login/login_admin'); ?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25" valign="bottom" colspan="2">登录账号：</td>
    </tr>
    <tr>
      <td style="color:red;line-height:20px" height="40"><input name="username" id="username" type="text" value="<?php echo set_value('username') ?>" class="login_input login_user"  /><?php echo form_error('username'); ?></td>
    </tr>
    <tr>
      <td height="25" valign="bottom" colspan="2">密码：</td>
    </tr>
    <tr>
      <td style="color:red;line-height:20px" height="40"><input type="password"  name="password" id="password"  class="login_input login_password" value="" /><?php echo form_error('password'); ?></td>
    </tr>
    <tr>
      <td height="40" valign="bottom" colspan="2">
      	 <input type="submit" class="btn btn-block btn-login"  name="login" value="登录"/>
      </td>
    </tr>
   
  </table>
</div>
<div class="copyright">建议使用IE8以上版本或谷歌浏览器</div>
</body>
</html>
