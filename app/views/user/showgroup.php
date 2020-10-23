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
    <link rel="stylesheet" href="<?php echo $skin.$css;?>lib/treegrid/jquery.treegrid.min.css">
</head>
<body>
<div class="main">
     <div class="page-header">
        <div class="page-title">
            <ol class="breadcrumb text-left">
				<li><a href="#">首页</a></li>
				<li>基础数据</li>
				<li class="active">内部组织架构</li>
			</ol>
		</div>
     </div>
                <!-- /# row -->
      <section id="main-content">
          <div class="row">
               <div class="col-lg-12">
                   <div class="card alert">
                       <div class="jsgrid-table-panel">
    						<table id="group_tree"></table>
                        </div>
                   </div>
                </div>
           </div>
      </section>
</div>
   <form id="add_group_form" >
    <div class="modal fade " id="add_group" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style=" top: -40%;left: 0%">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">新增组织</h4>
                </div>
                <div class="modal-body" >
	                	<div class="form-group">
							 <div class="row">
								 <label for="newbmname" class="col-sm-3 control-label">组织名称</label>
								 <div class="col-sm-8">
										<input type="text" name="newbmname" class="form-control" id="newbmname" placeholder="组织名称">
								</div>
						     </div>
						</div>
						<div class="form-group">
							 <div class="row">
							     <label for="newbmid" class="col-sm-3 control-label">组织编码</label>
							     <div class="col-sm-8">
								   <input type="text" name="newbmid" class="form-control" id="newbmid" placeholder="组织编码">
								 </div>
							</div>
						</div>
						<div class="form-group">
							 <div class="row">
							     <label for="newbm_easy" class="col-sm-3  control-label">描述</label>
							     <div class="col-sm-8">
							        <input type="text" name="newbm_easy" class="form-control" id="newbm_easy" placeholder="描述">
							        <input type="hidden" name="flevel" class="form-control" id="flevel">
							        <input type="hidden" name="fbid" class="form-control" id="fbid">
							     </div>
							  </div>
						</div>
	                	<DIV id="addgroup-html"></DIV>
                </div>
                 <div class="modal-footer">
                	<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>关闭</button>
                    <button type="submit" id="btn_add_group_submit" class="btn btn-primary" data-dismiss="modal" ><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    <form id="edit_group_form" >
    <div class="modal fade " id="edit_group" tabindex="-1" role="dialog" aria-labelledby="edit_group_label" style=" top: -50%;left: 0%">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="edit_group_label">修改组织</h4>
                </div>
                <div class="modal-body" >
	                	<div class="form-group">
							 <div class="row">
								 <label for="edit_newbmname" class="col-sm-3 control-label">组织名称</label>
								 <div class="col-sm-9">
								     <input type="hidden" name="edit_gid"  id="edit_gid" >	
								      <input type="hidden" name="index" class="form-control" id="index">
									 <input type="text" name="edit_newbmname" class="form-control" id="edit_newbmname" placeholder="组织名称">
								</div>
						     </div>
						</div>
						<div class="form-group">
							 <div class="row">
							     <label for="edit_newbmid" class="col-sm-3 control-label">组织编码</label>
							     <div class="col-sm-9">
								   <input type="text" name="edit_newbmid" class="form-control" id="edit_newbmid" placeholder="组织编码">
								 </div>
							</div>
						</div>
						<div class="form-group">
							 <div class="row">
							     <label for="edit_newbm_easy" class="col-sm-3  control-label">描述</label>
							     <div class="col-sm-9">
							        <input type="text" name="edit_newbm_easy" class="form-control" id="edit_newbm_easy" placeholder="描述">
							     </div>
							  </div>
						</div>
                </div>
                <div class="modal-footer">
                	<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>关闭</button>
                    <button type="button" id="btn_edit_group_submit" class="btn btn-primary" data-dismiss="modal" ><span class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></span>保存</button>
                </div>
            </div>
        </div>
    </div>
    </form>
    <script src="<?php echo $skin.$js;?>lib/jquery.min.js"></script> 
    <!-- bootstrap -->
    <script src="<?php echo $skin.$js;?>lib/bootstrap.min.js"></script>
    <script src="<?php echo $skin.$js;?>lib/treegrid/bootstrap-table.min.js"></script>
    <script src="<?php echo $skin . $js; ?>lib/treegrid/bootstrap-table-zh-CN.js"></script>
    <script src="<?php echo $skin.$js;?>lib/treegrid/bootstrap-table-treegrid.js"></script>
    <script src="<?php echo $skin.$js;?>lib/treegrid/jquery.treegrid.min.js"></script>
    <!-- 弹出框 -->
    <script src="<?php echo $skin.$js;?>lib/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="<?php echo $skin.$js;?>lib/bootstrapValidator.js"></script>
    <script type="text/javascript" src="<?php echo $skin.$js;?>time.js"></script>
    <script type="text/javascript">
    var $table = $('#group_tree');
    var opt = '<?php echo site_url('user/show_groups');?>';
    var logout = "<?php echo site_url('login/redircet');?>"; 
    $(function() {
         $table.bootstrapTable({
        	 url:'<?php echo site_url('user/show_groups');?>',
             idField: 'gcode',
             columns: [
                { field: 'check',  checkbox: true, formatter: function (value, row, index) {
                        if (row.check == true) {
                            return {  checked: true };
                        }
                    }
                },
                { field: 'gname',  title: '组织名称' },
                { field: 'gcode', title: '组织编码',align: 'left'},
                { field: 'gaddtime', title: '创建时间', formatter: 'formatTime'},
                { field: 'operate', title: '操作', align: 'center', events : operateEvents, formatter: 'operateFormatter' },
            ],
            treeShowField: 'gname',
            //指定父id列
            parentIdField: 'fgid',
            onResetView: function(data) {
                //console.log('load');
                $table.treegrid({
                    //initialState: 'collapsed',// 所有节点都折叠
                     initialState: 'expanded',// 所有节点都展开，默认展开
                    treeColumn: 1,
                     expanderExpandedClass: 'glyphicon glyphicon-minus',  //图标样式
                     expanderCollapsedClass: 'glyphicon glyphicon-plus',
                    onChange: function() {
                        $table.bootstrapTable('resetWidth');
                    }
                });
                //只展开树形的第一级节点
                $table.treegrid('getRootNodes').treegrid('expand');
            },
            onCheck:function(row){
                var datas = $table.bootstrapTable('getData');// 勾选子类
                selectChilds(datas,row,"gid","fgid",true);// 勾选父类
                selectParentChecked(datas,row,"gid","fgid")// 刷新数据
                $table.bootstrapTable('load', datas);
            },

            onUncheck:function(row){
                var datas = $table.bootstrapTable('getData');
                selectChilds(datas,row,"gid","fgid",false);
                $table.bootstrapTable('load', datas);
            },
            // bootstrap-table-treetreegrid.js 插件配置 -- end
        });

         $('#add_group_form').bootstrapValidator({
             //live: 'disabled',
             message: 'This value is not valid',
             feedbackIcons: {
                 valid: 'glyphicon glyphicon-ok',
                 invalid: 'glyphicon glyphicon-remove',
                 validating: 'glyphicon glyphicon-refresh'
             },
             fields: {
            	 newbmname: {
                     message: '新添加组织名称无效',
                     validators: {
                         notEmpty: {
                             message: '组织名不能位空'
                         }
                     }
                 },
                 newbm_easy: {
                     message: '组织简称无效',
                     validators: {
                         notEmpty: {
                             message: '组织简称不能为空'
                         }
                     }
                 },
                 newbmid: {
                	 message: '组织编码无效',
                     validators: {
                         notEmpty: {
                             message: '组织编码不能位空'
                         },
                         regexp: {
                             regexp: /^[a-zA-Z0-9]+$/,
                             message: '组织编码只能由字母、数字组成'
                         }
                     }
                 }
             }
         });
         $('#edit_group_form').bootstrapValidator({
             //live: 'disabled',
             message: 'This value is not valid',
             feedbackIcons: {
                 valid: 'glyphicon glyphicon-ok',
                 invalid: 'glyphicon glyphicon-remove',
                 validating: 'glyphicon glyphicon-refresh'
             },
             fields: {
            	 edit_newbmname: {
                     message: '新添加组织名称无效',
                     validators: {
                         notEmpty: {
                             message: '组织名不能为空'
                         }
                     }
                 },
                 edit_newbm_easy: {
                     message: '组织简称无效',
                     validators: {
                         notEmpty: {
                             message: '组织简称不能为空'
                         }
                     }
                 },
                 edit_newbmid: {
                	 message: '组织编码无效',
                     validators: {
                         notEmpty: {
                             message: '组织编码不能为空'
                         },
                         regexp: {
                             regexp: /^[a-zA-Z0-9]+$/,
                             message: '组织编码只能由字母、数字组成'
                         }
                     }
                 }
             }
         });
        
    });
   
    // 格式化按钮
    function operateFormatter(value, row, index) {
        return [
            '<button type="button" class="btn btn-info btn-sm m-b-10 m-l-5 RoleOfadd" style="margin-right:15px;"><i class="fa fa-plus" ></i>&nbsp;新增</button>',
            '<button type="button" class="btn btn-success btn-sm m-b-10 m-l-5 RoleOfedit" style="margin-right:15px;"><i class="fa fa-trash-o" ></i>&nbsp;修改</button>',
            '<button type="button" class="btn btn-primary btn-sm m-b-10 m-l-5 RoleOfdelete" style="margin-right:15px;"><i class="fa fa-pencil-square-o" ></i>&nbsp;删除</button>'
            
        ].join('');

    }
  
    //初始化操作按钮的方法
    window.operateEvents = {
        'click .RoleOfadd': function (e, value, row, index) {
            add(row.gid);
        },
        'click .RoleOfdelete': function (e, value, row, index) {
        	del(row.gid);
        },
        'click .RoleOfedit': function (e, value, row, index) {
            update(row,index);
        }
    };
    function update(row,index) {
        $("#edit_newbmname").val(row.gname);
        $("#edit_newbm_easy").val(row.abbreviation);
        $("#edit_newbmid").val(row.gcode);
        $("#edit_gid").val(row.gid);
        $("#index").val(index);
    	$('#edit_group').modal();
    }
    $('#btn_edit_group_submit').click(function(){
    	$('#edit_group_form').bootstrapValidator('validate');
        if($("#edit_group_form").data('bootstrapValidator').isValid()){
        	var newname  	=  $("#edit_newbmname").val();
        	var new_easy    =  $("#edit_newbm_easy").val();
        	var newid    	=  $("#edit_newbmid").val();
        	var gid         =  $("#edit_gid").val();
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
                    $('#edit_supplier').modal("hide");
                    $.ajax({
                        type: "POST",//方法类型
                        dataType: "json",//预期服务器返回的数据类型
                        url: "<?php echo site_url('user/editgroup');?>",//url
                        data: {gid:gid,newname:newname,new_easy:new_easy,newid:newid},
                        success: function (result) {
                            if (parseInt(result) > 0) {
                            	
                                swal({title: "修改成功!", type: "success"},
                                    function () {
                                	   $('#edit_group').modal('hide');	
                                	   var rows = {'gname':newname,'gcode':newid};
	          				           $table.bootstrapTable('refresh',{url:opt});
                                    }
                                );
                            } else {
                                swal({title: "修改失败!", type: "error"});
                            }
                        },
                        error: function () {
                            swal({title: "对不起", text: "您没有该权限或者登录超时！", type: "error"});
                        }
                    });
                }, 1000);

            });
        }
    });

    function add(id) {
    	 $.ajax({
             type: "POST",//方法类型
             dataType: "json",//预期服务器返回的数据类型
             url: "<?php echo site_url('user/fbid');?>" ,//url
             data: {id:id},
             success: function (result) {
            	 $("#flevel").val(result.glevel);
 				 $("#fbid").val(result.gcode);
             },
             error : function(XMLHttpRequest, textStatus, errorThrown) {
                 swal({ title:"对不起", text: "您没有该权限或者登录超时！",type: "error"});
             }
         });
    	$('#add_group').modal();
    }
    $('#btn_add_group_submit').click(function(){
    	$('#add_group_form').bootstrapValidator('validate');
        if($("#add_group_form").data('bootstrapValidator').isValid()){
        	var newbmname  	=  $("#newbmname").val();
        	var newbm_easy  =  $("#newbm_easy").val();
        	var flevel  	=  $("#flevel").val();
        	var fbid     	=  $("#fbid").val();
        	var newbmid    	=  $("#newbmid").val();
        	swal({title: "您确定要添加它吗？",type: "warning",showCancelButton: true,
                confirmButtonColor: "#DD6B55",confirmButtonText: "确定添加",closeOnConfirm: false,showLoaderOnConfirm: true,
            },function(){
	           	setTimeout(function(){
	           		$.post("<?php echo site_url('user/addgroup');?>",{newbmname:newbmname,newbm_easy:newbm_easy,flevel:flevel,fbid:fbid,newbmid:newbmid},
	        				function(data){
	        					if(data > 0){
	        						$('#add_group').modal('hide');							
	        						swal({ title: "添加成功!",type: "success"},
	    								 function(){
	             				        	$table.bootstrapTable('refresh', opt);
	             				        	document.getElementById("add_group_form").reset();
	        						});
	        					}else if(data == -1){
	        						swal("添加失败!","该组织编码已经存在","error" );
	            				}else{
	            					 window.location.href=logout; 
	        					}
	        				}
	        	    );
	           	 },900);
            });
        }
    });
   
    function del(id) {
    	 swal({
             title: "您确定要删除它吗？",
             text: "如果该组织名称有关联其他内容，您将无法删除！",
             type: "warning",
             showCancelButton: true,
             confirmButtonColor: "#DD6B55",
             confirmButtonText: "确定，删除",
             closeOnConfirm: false,
             showLoaderOnConfirm: true,
         },
         function(){
        	 setTimeout(function(){
        		 $.post("<?php echo site_url('user/deletegroup');?>",{id:id},
          				function(data){
          					if(!isNaN(data) && data > 0 ){
          						swal({title: "删除成功!",type: "success" },
     								 function(){
              				        	 $table.bootstrapTable('remove',{field:"gid",values:[id]});
         						     });
          					}else if(!isNaN(data) && data == 0 ){
          						swal("删除失败!","该组织有关联数据，无法删除！","error" );
          					}else{
          						 //window.location.href=logout; 
         						 alert(data);
          					}
          				}
          			);
             }, 1000);
         });
    }

    /**
     * 选中父项时，同时选中子项
     * @param datas 所有的数据
     * @param row 当前数据
     * @param id id 字段名
     * @param pid 父id字段名
     */
    function selectChilds(datas,row,id,pid,checked) {
        for(var i in datas){
            if(datas[i][pid] == row[id]){
                datas[i].check=checked;
                selectChilds(datas,datas[i],id,pid,checked);
            };
        }
    }

    function selectParentChecked(datas,row,id,pid){
        for(var i in datas){
            if(datas[i][id] == row[pid]){
                datas[i].check=true;
                selectParentChecked(datas,datas[i],id,pid);
            };
        }
    }

  
</script>
</body>

</html>