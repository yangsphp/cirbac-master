<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GKGD智慧商贸管理系统</title>
    <!-- ================= Favicon ================== -->
    <!-- Styles -->

    <link href="<?php echo $skin . $css; ?>lib/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $skin . $css; ?>lib/themify-icons.css" rel="stylesheet">
    <link href="<?php echo $skin . $css; ?>lib/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $skin . $css; ?>style.css" rel="stylesheet">
    <link href="<?php echo $skin . $css; ?>lib/select/bootstrap-select.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $skin . $css; ?>lib/treegrid/bootstrap-table.css">
    <link href="<?php echo $skin . $css; ?>lib/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="<?php echo $skin . $css; ?>lib/bootstrapValidator.css" rel="stylesheet">
    <link href="<?php echo $skin . $css; ?>lib/toastr/toastr.min.css" rel="stylesheet">

</head>
<body>
<div class="main">
    <div class="page-header">
        <ul class="breadcrumb">
            <li><a href="#">首页</a></li>
            <li>基础数据</li>
            <li class="active">用户管理</li>
        </ul>
    </div>
    <section id="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card alert">
                    <div class="jsgrid-table-panel">
                        <table id="userinfo" data-toolbar="#footbar" data-search="true"
                               data-show-columns="true" data-mobile-responsive="true"></table>
                        <input type="hidden" id="user_state" value=1>
                        <input type="hidden" id="user_type" value=0>
                        <div id="footbar">
                            <button class="btn btn-warning btn-sm m-b-10 m-l-5 RoleOfdelete" onclick="add()" ><i class="glyphicon glyphicon-plus" style="color:#fff"></i>&nbsp;添加用户
                            </button>
                            <button class="btn btn-warning btn-sm m-b-10 m-l-5 RoleOfdelete" onclick="role_mange()"><i class="glyphicon glyphicon-user" style="color:#fff"></i>&nbsp;角色管理
                            </button>
                            <div class="btn-group">
	                            <button type="button" class="btn btn-warning dropdown-toggle  btn-sm" data-toggle="dropdown">
									选择用户状态<span class="caret"></span>
								</button>
	                            <ul class="dropdown-menu" role="menu">
	                                  <li><a onclick="javascript:show_lock_user(1)">正常状态</a></li>
	                                  <li><a onclick="javascript:show_lock_user(0)">注销状态</a></li>
	                            </ul>
                            </div>
                            <div class="btn-group">
	                            <button type="button" class="btn btn-warning dropdown-toggle  btn-sm" data-toggle="dropdown">
									选择用户类别<span class="caret"></span>
								</button>
	                            <ul class="dropdown-menu" role="menu">
	                                  <li><a onclick="javascript:show_type_user(0)">内部用户</a></li>
	                                  <li><a onclick="javascript:show_type_user(1)">经销商用户</a></li>
	                                  <li><a onclick="javascript:show_type_user(2)">供应商用户</a></li>
	                                 
	                            </ul>
                            </div>
                             <a href="<?php echo site_url("ceshi/ceshi");?>">&nbsp;测试号</a>
                        </div>
                    </div>
                </div>
                <!-- /# card -->
            </div>
            <!-- /# column -->
        </div>

    </section>
</div>

<form id="add_user_form" class="form-horizontal" role="form">
    <div class="modal fade " id="add_user" tabindex="-1" role="dialog" aria-labelledby="add_user_label"
         style=" top: -40%;left: 0%">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     	<span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="add_user_label">新增用户</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group-sm">
                            <label class="col-sm-2 control-label" for="username">用户账号</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="ti-user"></i></span>
                                    <input type="text"  style="width: 1px; height: 1px; position: absolute; border: 0px; padding: 0px;">
                                    <input type="password"  style="width: 1px; height: 1px; position: absolute; border: 0px; padding: 0px;">
                                    <input name="username" id="username" type="password" onfocus="this.type='text'"   class="form-control" placeholder="用户账号" autocomplete="off">
                                </div>

                            </div>

                        </div>
                        <div class="form-group-sm">
                            <label class="col-sm-2 control-label" for="password">登陆密码</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="ti-user"></i></span>
                                    <input type="password" class="form-control  input-sm" name="password" id="password" placeholder="用户密码">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group-sm">
                            <label for="real_name" class="col-sm-2 control-label">姓名</label>
                            <div class="col-sm-2">
                                <input type="text" name="real_name" class="form-control  input-sm" id="real_name" placeholder="名称">
                            </div>
                        </div>
                        <div class="form-group-sm">
                            <label for="sex" class="col-sm-1 control-label">性别</label>
                            <div class="col-sm-2">
                                <SELECT name="sex" id="sex" class="form-control">
                                    <option value=0>请选择性别</option>
                                    <option value=1>男士</option>
                                    <option value=2>女士</option>
                                </SELECT>
                            </div>
                        </div>
                        <div class="form-group-sm">
                            <label for="number" class="col-sm-1 control-label">证件号</label>
                            <div class="col-sm-4">
                                <input type="text" name="number" class="form-control  input-sm" id="number" placeholder="证件号">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group-sm">
                            <label for="address" class="col-sm-2 control-label">户籍地址</label>
                            <div class="col-sm-4">
                                <input type="text" name="address" class="form-control  input-sm" id="address" placeholder="户籍地址">
                            </div>
                        </div>
                        <div class="form-group-sm">
                            <label for="tell" class="col-sm-2 control-label">联系电话</label>
                            <div class="col-sm-4">
                                <input type="number" name="tell" class="form-control  input-sm" id="tell"  placeholder="联系电话">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group-sm">
                            <label for="entry_date" class="col-sm-2 control-label">入职日期</label>
                            <div class="col-sm-4">
                                <input type="date" name="entry_date" class="form-control  input-sm" id="entry_date" placeholder="入职日期">
                            </div>
                        </div>
                        <div class="form-group-sm">
                            <label for="email" class="col-sm-2 control-label">工作邮箱</label>
                            <div class="col-sm-4">
                                <input type="email" name="email" class="form-control  input-sm" id="email"  placeholder="工作邮箱">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group-sm" id="add_group">
                            <label for="group" class="col-sm-2 control-label">所属组织</label>
                            <div class="col-sm-4">
                                <SELECT name="group" id="group" class="form-control" onchange="">
                                    <?php echo $select; ?>
                                </SELECT>
                            </div>
                        </div>
                        <div class="form-group-sm">
                            <label for="role" class="col-sm-2 control-label">用户身份</label>
                            <div class="col-sm-4">
                                <SELECT name="role" id="role" class="form-control">
									<?php 
									foreach($rolse as $value){
									echo "<option value=".$value['rolecode'].">".$value['rolename']."</option>";

									}
									?>
                                </SELECT>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span
                                class="glyphicon glyphicon-remove" aria-hidden="true"></span>关闭
                    </button>
                    <button type="button" id="btn_add_user_submit" class="btn btn-primary"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>

<form id="edit_user_form" class="form-horizontal" role="form">
    <div class="modal fade " id="edit_user" tabindex="-1" role="dialog" aria-labelledby="edit_user_label"
         style=" top: -40%;left: 0%">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="edit_user_label">用户信息管理</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="form-group-sm">
                            <label class="col-sm-2 control-label" for="edit_username">用户账号</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="index" name="index">
                                    <span class="input-group-addon"><i class="ti-user"></i></span>
                                    <input type="text" class="form-control  input-sm" name="edit_username"
                                           id="edit_username" placeholder="用户账号">
                                </div>
                                <span class="ti-check form-control-feedback"></span>
                                <span class="sr-only">(success)</span>
                            </div>

                        </div>
                        <div class="form-group-sm">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <button class="btn btn-pink btn-rounded m-b-10 m-l-5" onclick="reset_pass()"><span
                                                class="glyphicon glyphicon-repeat"></span>&nbsp;密码重置
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group-sm">
                            <label for="edit_real_name" class="col-sm-2 control-label">姓名</label>
                            <div class="col-sm-2">
                                <input type="text" name="edit_real_name" class="form-control  input-sm"
                                       id="edit_real_name" placeholder="名称">
                            </div>
                        </div>
                        <div class="form-group-sm">
                            <label for="edit_sex" class="col-sm-1 control-label">性别</label>
                            <div class="col-sm-2">
                                <SELECT name="edit_sex" id="edit_sex" class="form-control">
                                    <option value=0>请选择性别</option>
                                    <option value=1>男士</option>
                                    <option value=2>女士</option>
                                </SELECT>
                            </div>
                        </div>
                        <div class="form-group-sm">
                            <label for="edit_number" class="col-sm-1 control-label">证件号</label>
                            <div class="col-sm-4">
                                <input type="text" name="edit_number" class="form-control  input-sm" id="edit_number"
                                       placeholder="证件号">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="form-group-sm">
                            <label for="edit_address" class="col-sm-2 control-label">户籍地址</label>
                            <div class="col-sm-4">
                                <input type="text" name="edit_address" class="form-control  input-sm" id="edit_address"
                                       placeholder="户籍地址">
                            </div>
                        </div>
                        <div class="form-group-sm">
                            <label for="edit_tell" class="col-sm-2 control-label">联系电话</label>
                            <div class="col-sm-4">
                                <input type="number" name="edit_tell" class="form-control  input-sm" id="edit_tell"
                                       placeholder="联系电话">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group-sm">
                            <label for="edit_entry_date" class="col-sm-2 control-label">入职日期</label>
                            <div class="col-sm-4">
                                <input type="date" name="edit_entry_date" class="form-control  input-sm"
                                       id="edit_entry_date" placeholder="联系电话">
                            </div>
                        </div>
                        <div class="form-group-sm">
                            <label for="edit_email" class="col-sm-2 control-label">工作邮箱</label>
                            <div class="col-sm-4">
                                <input type="email" name="edit_email" class="form-control  input-sm" id="edit_email"
                                       placeholder="工作邮箱">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group-sm">
                            <label for="edit_group" class="col-sm-2 control-label">所属组织</label>
                            <div class="col-sm-4">
                                <SELECT name="edit_group" id="edit_group" class="form-control">
                                    <?php echo $select; ?>
                                </SELECT>
                            </div>
                        </div>
                       
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span
                                class="glyphicon glyphicon-remove" aria-hidden="true"></span>关闭
                    </button>
                    <button type="button" id="btn_edit_user_submit" class="btn btn-primary"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="dis_role_form">
    <div class="modal fade " id="dis_roles" tabindex="-1" role="dialog" style=" top: -40%;left: 0%"
         aria-labelledby="dis_role_label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="dis_role_label">分配角色</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group-sm">
                            <label class="col-sm-2 control-label">用户名称</label>
                            <div class="col-sm-4">
                                <div id="dis_username"></div>
                                <input type="hidden" name="dis_uid" id="dis_uid">
                                <input type="hidden" id="up_index">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="form-group-sm">
                            <label for="dis_roles" class="col-sm-2  control-label">角色分配</label>
                            <div class="col-sm-9">
                                <select class="selectpicker" data-style="btn-warning" name="dis_roles_select" id="dis_roles_select" multiple data-live-search="true">
                                </select>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><span
                                class="glyphicon glyphicon-remove" aria-hidden="true"></span>关闭
                    </button>
                    <button type="button" id="btn_dis_role_submit" class="btn btn-primary"><span
                                class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="<?php echo $skin . $js; ?>lib/jquery.min.js"></script>
<!-- bootstrap -->
<script src="<?php echo $skin . $js; ?>lib/bootstrap.min.js"></script>
<script src="<?php echo $skin . $js; ?>lib/treegrid/bootstrap-table.min.js"></script>
<script src="<?php echo $skin . $js; ?>lib/treegrid/bootstrap-table-zh-CN.js"></script>
<!-- 弹出框 -->
<script src="<?php echo $skin . $js; ?>lib/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="<?php echo $skin . $js; ?>lib/bootstrapValidator.js"></script>
<script type="text/javascript" src="<?php echo $skin . $js; ?>time.js"></script>
<script src="<?php echo $skin . $js; ?>lib/select/bootstrap-select.js"></script>
<script type="text/javascript">
    var $table = $('#userinfo');
    var logout = "<?php echo site_url('acl/login/redircet');?>";
    $(function () {
        $table.bootstrapTable({ // 对应table标签的id
            url: "<?php echo site_url('user/users_view'); ?>", // 获取表格数据的url
            method: "post",
            contentType: "application/x-www-form-urlencoded",
            cache: false, // 设置为 false 禁用 AJAX 数据缓存， 默认为true
            striped: true,  //表格显示条纹，默认为false
            pagination: true, // 在表格底部显示分页组件，默认false
            pageList: [10, 20, 30], // 设置页面可以显示的数据条数
            pageSize: 10, // 页面数据条数
            pageNumber: 1, // 首页页码
            showHeader: true,
            sidePagination: 'server', // 设置为服务器端分页
            queryParams: function (params) { // 请求服务器数据时发送的参数，可以在这里添加额外的查询参数，返回false则终止请求
                return {
                    pageSize: params.limit, // 每页要显示的数据条数
                    offset: params.offset, // 每页显示数据的开始行号
                    sort: params.sort, // 要排序的字段
                    sortOrder: params.order, // 排序规则
                    keyword: params.search
                    // dataId: $("#dataId").val() // 额外添加的参数
                };
            },
            sortName: 'id', // 要排序的字段
            sortOrder: 'desc', // 排序规则
            columns: [
                {checkbox: true, align: 'center', width: '3%'},
                {field: 'username', title: '用户名', align: 'center', valign: 'middle', width: '10%'},
                {field: 'gname', title: '所属组织', align: 'center', width: '20%'},
                {field: 'role', title: '角色', align: 'center', width: '10%'},
                {field: 'registered',title: '注册时间',align: 'center',valign: 'middle',width: '10%',formatter: 'formatDate'},
                {field: 'last_login',title: '最后登陆',align: 'center',valign: 'middle',width: '12%',formatter: 'formatTime'},
                {field: 'adduser', title: '创建人', align: 'center', valign: 'middle', width: '10%'},
                {field: 'state', title: '状态', align: 'center', valign: 'middle', width: '5%',
                	formatter: function (value, row, index) {
                		if(row.state == 1){ return '<span class="badge badge-success">正常</span>';}
                        else{return '<span class="badge badge-danger">已注销</span>';}
                    }
                },
                {
                    title: "操作", align: 'right', valign: 'middle', width: '20%',
                    formatter: function (value, row, index) {
                        var button = "";
                        if (row.username != "admin" && row.identifier == 0) {
                        	button += '<button class="btn btn-info btn-sm m-b-10 m-l-5" onclick="dis_role(\'' + row.id + '\',\'' + index + '\',\'' + row.username + '\',\'' + row.role_id + '\')" style="margin:0 5px;"><i class="glyphicon glyphicon-cog" style="color:#fff"></i>&nbsp;角色</button>' +
                                '<button class="btn btn-warning btn-sm m-b-10 m-l-5" onclick="edit(\'' + row.id + '\',\'' + index + '\')" style="margin:0 5px;"><i class="fa fa-pencil-square-o" ></i>&nbsp;编辑</button>';
                        }
						if(row.state  > 0){
							button += '<button class="btn btn-primary btn-sm m-b-10 m-l-5" onclick="lock(\'' + row.id + '\',0)" style="margin:0 5px;"><i class="glyphicon glyphicon-off" style="color:#fff"></i>&nbsp;注销</button>';
                        }else{
                        	button += '<button class="btn btn-success btn-sm m-b-10 m-l-5" onclick="lock(\'' + row.id + '\',1)" style="margin:0 5px;"><i class="glyphicon glyphicon-off" style="color:#fff"></i>&nbsp;开通</button>';
                        }
                        return button;
                    }
                }
            ],
            onLoadSuccess: function () {  //加载成功时执行
                console.info("加载成功");
            },
            onLoadError: function () {  //加载失败时执行
                console.info("加载数据失败");
            },
            onDblClickRow: function (row) {
                var url = "<?php echo base_url();?>index.php/user/userinfo/" + row.id;
                if (row.username == "admin") swal({title: "对不起，您点错了!", type: "error"});
                else window.location.href = url;
            }

        });

        $('#add_user_form').bootstrapValidator({
            //live: 'disabled',
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                username: {
                    message: '用户账号无效',
                    validators: {
                        notEmpty: {
                            message: '用户账号不能为空'
                        },
                        stringLength: {
                            min: 4,
                            max: 30,
                            message: '用户名必须大于4，小于30个字'
                        }
                    }
                },
                password: {
                    message: '密码无效',
                    validators: {
                        notEmpty: {
                            message: '密码不能为空'
                        },
                        stringLength: {
                            min: 6,
                            max: 30,
                            message: '密码必须大于6，小于30位'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: '组织编码只能由字母、数字组成'
                        }
                    }
                },
                real_name: {
                    message: '姓名无效',
                    validators: {
                        notEmpty: {
                            message: '姓名不能位空'
                        }
                    }
                },
                number: {
                    message: '身份证号码无效',
                    validators: {
                        regexp: {
                            regexp: /^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/,
                            message: '身份证格式错误'
                        },
                        stringLength: {
                            min: 18,
                            max: 18,
                            message: '身份证号必须是18位'
                        }
                    }
                },
                tell: {
                    message: '手机号码无效',
                    validators: {
                        notEmpty: {
                            message: '手机号不能位空'
                        },
                        stringLength: { min: 10, max: 13, message: '号码位数错误'},
                        regexp:{regexp:/^1[34578]\d{9}$/,message:'手机号无效'}
                    }
                }
            }
        });
        $('#edit_user_form').bootstrapValidator({
            //live: 'disabled',
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                edit_username: {
                    message: '用户账号无效',
                    validators: {
                        notEmpty: {
                            message: '用户账号不能为空'
                        },
                        stringLength: {
                            min: 4,
                            max: 30,
                            message: '用户名必须大于4，小于30个字'
                        }
                    }
                },
                edit_real_name: {
                    message: '姓名无效',
                    validators: {
                        notEmpty: {
                            message: '姓名不能位空'
                        }
                    }
                },
                edit_number: {
                    message: '身份证号码无效',
                    validators: {
                        regexp: {
                            regexp: /^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$/,
                            message: '身份证格式错误'
                        },
                        stringLength: {
                            min: 18,
                            max: 18,
                            message: '身份证号必须是18位'
                        }
                    }
                },
                edit_tell: {
                    message: '手机号码无效',
                    validators: {
                        notEmpty: {
                            message: '手机号不能位空'
                        },
                        stringLength: {
                            min: 11,
                            max: 11,
                            message: '手机号必须是11位'
                        },
                    }
                }
            }
        });
    });
    function show_lock_user(state){
        $("#user_state").val(state);
        var type = $("#user_type").val();
    	$table.bootstrapTable('refresh', { 
        	url: "<?php echo base_url(); ?>index.php/user/users_view/" + state + "/" +type,
         });
    }
    function show_type_user(type){
    	$("#user_type").val(type);
        var state = $("#user_state").val();
    	$table.bootstrapTable('refresh', { 
    		url: "<?php echo base_url(); ?>index.php/user/users_view/" + state + "/" +type,
         });
    }
    function dis_role(uid, index, username, rids) {
        $.ajax({
            type: "POST",//方法类型
            dataType: "json",//预期服务器返回的数据类型
            url: "<?php echo site_url('role/role_select/1');?>",//url
            data: {uid: uid},
            success: function (result) {
                $("#dis_username").html(username);
                $("#dis_roles_select").html(result.select);
                $("#dis_uid").val(uid);
                $("#up_index").val(index);
                $('#dis_roles_select').selectpicker('refresh');
                $("#dis_roles").modal("show");
            },
            error: function (data) {
                window.location.href = logout;
            }
        });
    }

    $('#btn_dis_role_submit').click(function () {
        var rolenames = "";
        var uid = $("#dis_uid").val();
        var role_codes = $("#dis_roles_select").val();
        $("#dis_roles_select").find("option:selected").each(function () {
            rolenames += $(this).text() + ",";
        })
        if($("#dis_roles_select").find("option:selected").length == 0){
        	swal({title: "请选择角色!", type: "error"});
        }else{
	        rolenames = rolenames.substring(0, rolenames.length - 1);
	        swal({
	            title: "您确定要分配吗？", text: "", type: "warning", showCancelButton: true, confirmButtonColor: "#DD6B55",
	            confirmButtonText: "确定修改", closeOnConfirm: false, showLoaderOnConfirm: true,
	        }, function () {
	            $('#dis_roles').modal("hide");
	            setTimeout(function () {
	                $.ajax({
	                    type: "POST", dataType: "json",
	                    url: "<?php echo site_url('user/dis_role');?>",//url
	                    data: {uid: uid, role_codes: role_codes},
	                    success: function (result) {
	                        if (result.messcode == true) {
	                            swal({title: "修改成功!", type: "success"},
	                                function () {
	                                    $table.bootstrapTable('updateCell', {index: $('#up_index').val(),field: 'role',value: rolenames});
	                                    
	                                });
	                        } else {
	                            swal({title: "修改失败!", type: "error"});
	                        }
	                    },
	                    error: function () {
	                        swal({title: "对不起", text: "您没有该权限！", type: "error"});
	                    }
	                });
	            }, 1000);
	        });
        }
    });


    function role_mange() {
        var url = "<?php echo site_url('role');?>";
        window.location.href = url;
    }

    function edit(id, index) {
        $.ajax({
            type: "POST",//方法类型
            dataType: "json",//预期服务器返回的数据类型
            url: "<?php echo site_url('user/one_user');?>",//url
            data: {id: id},
            success: function (result) {
                $('#edit_username').val(result.username);
                $('#edit_real_name').val(result.name);
                $('#edit_sex').val(result.sex);
                $('#edit_number').val(result.id_number);
                $('#edit_address').val(result.address);
                $('#edit_entry_date').val(result.entry_date);
                $('#edit_email').val(result.email);
                $('#edit_tell').val(result.tell);
                $('#edit_role').val(result.role_id);
                $('#edit_group').val(result.group_code);
                $('#id').val(id);
                $('#index').val(index);
                $('#edit_user').modal();
            },
            error: function (data) {
                window.location.href = logout;
            }
        });

    }

    $('#btn_edit_user_submit').click(function () {
        $('#edit_user_form').bootstrapValidator('validate');
        if ($("#edit_user_form").data('bootstrapValidator').isValid()) {
            swal({
                title: "您确定要修改它吗？",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定修改",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    $('#edit_user').modal("hide");
                    $.ajax({
                        type: "POST",//方法类型
                        dataType: "json",//预期服务器返回的数据类型
                        url: "<?php echo site_url('user/change_userinfo');?>",//url
                        data: $('#edit_user_form').serialize(),
                        success: function (result) {
                            if (parseInt(result.messcode) > 0) {
                                swal({title: "修改成功!", type: "success"},
                                    function () {
                                        $table.bootstrapTable('updateRow', {
                                            index: $('#index').val(),
                                            row: result.data
                                        });
                                    }
                                );
                            } else {
                                swal({title: "修改失败!", type: "error"});
                            }
                        },
                        error: function () {
                            swal({title: "对不起", text: "您没有该权限！", type: "error"});
                        }
                    });
                }, 1000);

            });
        }
    });

    function lock(id,state) {
    	 if(state == 1){
             var active_t = "开通"; var active_text = ""; 
         }else{
             var active_t = "注销";var active_text = "注销后这些用户将不能登陆！"; 
         } 
        swal({
            title: "您确定"+active_t+"吗？",
            text: active_text,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "确定"+active_t,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function () {
            setTimeout(function () {
                $.ajax({
                    type: "POST",//方法类型
                    dataType: "json",//预期服务器返回的数据类型
                    url: "<?php echo site_url('user/lock_user');?>",//url
                    data: {id: id,state:state},
                    success: function (result) {
                        if (parseInt(result) > 0) {
                            var ids = [];
                            ids.push(parseInt(id));
                            $table.bootstrapTable('remove', {field: "id", values: ids});
                            swal({title: "已"+active_t, type: "success"});
                        } else {
                            swal({title: active_t+"失败!", type: "error"});
                        }
                    },
                    error: function (data) {
                        swal({title: "对不起", text: "您没有该权限！", type: "error"});
                    }
                });
            }, 1000);

        });
    }

    function add() {
        //alert("ss");
        $("#add_user").modal();
    }

    $('#btn_add_user_submit').click(function () {
        $('#add_user_form').bootstrapValidator('validate');
        if ($("#add_user_form").data('bootstrapValidator').isValid()) {
            swal({
                title: "您确定要开通它吗？",
                text: "",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "确定添加",
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            }, function () {
                setTimeout(function () {
                    $('#add_user').modal("hide");
                    $.ajax({
                        type: "POST",//方法类型
                        dataType: "json",//预期服务器返回的数据类型
                        url: "<?php echo site_url('user/add_user');?>",//url
                        data: $('#add_user_form').serialize(),
                        success: function (result) {
                            if (parseInt(result.messcode) > 0) {
                                swal({title: "添加成功!", type: "success"},
                                    function () {
                                        var opt = {
                                            url: "<?php echo site_url('user/users_view');?>",
                                        };
                                        $table.bootstrapTable('refresh', opt);
                                        document.getElementById("add_user_form").reset();
                                    });
                            } else {
                                swal({title: "添加失败!", text: "该用户已经存在", type: "error"});
                            }
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            swal({title: "对不起", text: "您没有该权限或者登录超时！", type: "error"});
                        }
                    });
                }, 1000);

            });
        }
    });

    function reset_pass() {
        var id = $("#id").val();
        $.post("<?php echo site_url('user/changpass');?>", {id: id},
            function (data) {
                if (!isNaN(data) && data > 0) {
                    swal({title: "重置成功!", type: "success"});
                }
                else {
                    window.location.href = logout;
                }
            }
        );
    }
   
   
</script>
</body>

</html>