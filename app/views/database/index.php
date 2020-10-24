<?php $this->load->view('common/header')?>
<?php //var_dump($buttons); ?>
<div class="container-fluid p-t-15">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
				<ul class="nav nav-tabs page-tabs">
				  <li class="active"> <a href="#!">数据维护</a> </li>
				  <li> <a href="<?php echo site_url('database/data');?>">数据恢复</a> </li>
				  <!--
				  <li> <a href="lyear_pages_config_system.html">系统</a> </li>
				  <li> <a href="lyear_pages_config_upload.html">上传</a> </li>
				  -->
				</ul>
                <div class="tab-content">

                    <div id="toolbar2" class="toolbar-btn-action">
                        <?php if (in_array('备份', $buttons)) { ?>
                            <button type="button" class="btn btn-danger btn-sm  m-r-5" onclick="selected_back()">
                                <span class="mdi mdi-plus" aria-hidden="true"></span>备份
                            </button>
                        <?php } ?>
                        <table id="database_tab" style="text-align:center;word-break:break-all;"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="add_database" tabindex="-1" auth="dialog"
         aria-labelledby="add_auth_Label">
        <div class="modal-dialog" auth="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="add_database_Label"></h4>
                </div>
                <div class="modal-body" id="add-database">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="save_dict()">修改</button>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('common/footer')?>
<script type="text/javascript" src="<?php echo $skin; ?>new/js/main.min.js"></script>
    <script type="text/javascript">
        $('#database_tab').bootstrapTable({
            classes: 'table table-bordered table-hover table-striped table-condensed table-responsive',
            url: "<?php echo site_url('database/show_database');?>",
            method: 'post',
            dataType: 'json',        // 因为本示例中是跨域的调用,所以涉及到ajax都采用jsonp,
            uniqueId: 'id',
            idField: 'index',        // 每行的唯一标识字段
            contentType: "application/x-www-form-urlencoded",
            toolbar: '#toolbar',       // 工具按钮容器
            //clickToSelect: true,     // 是否启用点击选中行
            showColumns: true,         // 是否显示所有的列
            showRefresh: true,         // 是否显示刷新按钮
            //showToggle: true,        // 是否显示详细视图和列表视图的切换按钮(clickToSelect同时设置为true时点击会报错)
            pagination: false,                    // 是否显示分页
            sortName: 'id', 			// 要排序的字段
            sortOrder: "asc",                    // 排序方式
            queryParams: function (params) {
                console.log(params)
                var temp = {
                    limit: params.limit,         // 每页数据量
                    offset: params.offset,       // sql语句起始索引
                    //page: (params.offset / params.limit) + 1,
                    sort: params.sort,           // 排序的列名
                    search: params.search,       // 搜索
                    sortOrder: params.order      // 排序方式'asc' 'desc'
                };
                return temp;
            },                                   // 传递参数
            sidePagination: "server",            // 分页方式：client客户端分页，server服务端分页
            pageNumber: 1,                       // 初始化加载第一页，默认第一页
            pageSize: 10,                        // 每页的记录行数
            pageList: [10, 25, 50, 100],         // 可供选择的每页的行数
            search: false,                      // 是否显示表格搜索，此搜索是客户端搜索

            //showExport: true,        // 是否显示导出按钮, 导出功能需要导出插件支持(tableexport.min.js)
            //exportDataType: "basic", // 导出数据类型, 'basic':当前页, 'all':所有数据, 'selected':选中的数据

            columns: [
                {checkbox: true, width: '50px'}, {
                    field: 'index',
                    title: 'ID',
                    width: '100px',
                    //sortable: true,    // 是否排序
                    formatter: function (value, row, index) {
                        var pageSize = $('#database_tab').bootstrapTable('getOptions').pageSize;     //通过table的#id 得到每页多少条
                        var pageNumber = $('#database_tab').bootstrapTable('getOptions').pageNumber; //通过table的#id 得到当前第几页
                        return pageSize * (pageNumber - 1) + index + 1;
                    }
                }, {
                    field: 'name', title: '表名', align: 'left'
                }, {
                    field: 'note', title: '表注释'
                }, {
                    field: 'tsize', title: '表大小（M）', width: '150px', formatter: function(value, row, index){
						let per = Math.round(100 * row.tsize / row.total_size);
						return '<div class="progress" style="margin-bottom:0;background-color:#e4e7ea;"><div class="progress-bar progress-bar-striped active" role="progressbar" style="width: '+per+'%;" aria-valuenow="'+row.tsize+'" aria-valuemin="0" aria-valuemax="'+row.total_size+'">'+row.tsize+'</div></div>';
					}
                },{
                    field: 'index', title: '索引'
                }, {
                    field: 'chip', title: '碎片'
                }, {
                    field: 'rows', title: '记录数'
                },{
                    field: 'operate', title: '操作', width: '150px', align: 'center', formatter: btnGroup, // 自定义方法
                    events: {
                        'click .repair-btn': function (event, value, row, index) {  
                            repair_operate(row.name);
                        },
                        'click .optimize-btn': function (event, value, row, index) {  
                            optimize_operate(row.name);
                        }, 
						'click .dict-btn': function (event, value, row, index) {
							open_add_Label(row.name);
						}
                    }
                }],

            onLoadSuccess: function (data) {
                $("[data-toggle='tooltip']").tooltip();
            }

        });

        // 操作按钮
        function btnGroup(value, row, index) {
            let html = '', repair_flag = '<?php echo in_array('修复', $buttons) ? 1 : 0?>', optimize_flag = '<?php echo in_array('优化', $buttons) ? 1 : 0?>', dict_flag = '<?php echo in_array('字典', $buttons) ? 1 : 0?>';
            if (repair_flag == 1) {
                html += '<a href="#!" class="btn btn-xs btn-default m-r-5 repair-btn" title="修复" data-toggle="tooltip"><i class="mdi mdi-wrench"></i></a>';
            }
            if (optimize_flag == 1) {
                html += '<a href="#!" class="btn btn-xs btn-default m-r-5 optimize-btn" title="优化" data-toggle="tooltip"><i class="mdi mdi-rotate-3d"></i></a>';
            }
			if (dict_flag == 1) {
                html += '<a href="#!" class="btn btn-xs btn-default m-r-5 dict-btn" title="字典" data-toggle="tooltip"><i class="mdi mdi-book-open-variant"></i></a>';
            }
            return html;
        }
		
		function repair_operate(table) {
			$.confirm({
                title: '修复提示',
                content: '修复后不可恢复，请谨慎！',
                type: 'red',
                typeAnimated: true,
                buttons: {
				tryAgain: {
					text: '修复',
					btnClass: 'btn-red',
					action: function () {
						lightyear.loading('show');
						setTimeout(function () {
							$.ajax({
								type: "POST",//方法类型
								url: "<?php echo site_url('database/repair_op');?>",//url
								data: {table: table},
								dataType: 'json',
								success: function (result) {
									if (result.code == 0) {
										lightyear.loading('hide');
										lightyear.notify(result.msg, 'success', 3000);
										window.location.reload();
									} else {
										lightyear.loading('hide');
										lightyear.notify(result.msg, 'danger', 3000);
									}
								},
								error: function (XMLHttpRequest, textStatus, errorThrown) {
									lightyear.notify('对不起' + XMLHttpRequest.statusText, 'danger', 3000);
								}
							});
						}, 1e3);
					}
				},
				close: {
					text: '关闭'
				}
                }
            });
		}
		
		function optimize_operate(table) {
			$.confirm({
                title: '优化提示',
                content: '优化后不可恢复，请谨慎！',
                type: 'red',
                typeAnimated: true,
                buttons: {
				tryAgain: {
					text: '优化',
					btnClass: 'btn-red',
					action: function () {
						lightyear.loading('show');
						setTimeout(function () {
							$.ajax({
								type: "POST",//方法类型
								url: "<?php echo site_url('database/optimize_op');?>",//url
								data: {table: table},
								dataType: 'json',
								success: function (result) {
									if (result.code == 0) {
										lightyear.loading('hide');
										lightyear.notify(result.msg, 'success', 3000);
										window.location.reload();
									} else {
										lightyear.loading('hide');
										lightyear.notify(result.msg, 'danger', 3000);
									}
								},
								error: function (XMLHttpRequest, textStatus, errorThrown) {
									lightyear.notify('对不起' + XMLHttpRequest.statusText, 'danger', 3000);
								}
							});
						}, 1e3);
					}
				},
				close: {
					text: '关闭'
				}
                }
            });
		}
		
		//批量备份
        function selected_back() {
            var selRows = $('#database_tab').bootstrapTable("getSelections");
            if (selRows.length == 0) {
                lightyear.notify('请选择要备份的行', 'danger', 3000);
                return;
            }
            console.log(selRows);

            var postData = "";
            $.each(selRows, function (i) {
                postData += this.name;
                if (i < selRows.length - 1) {
                    postData += ",";
                }
            });
            $.confirm({
                title: '备份提示',
                content: '备份后不可恢复，请谨慎！',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: '备份',
                        btnClass: 'btn-red',
                        action: function () {
                            lightyear.loading('show');
                            setTimeout(function () {
                                $.ajax({
                                    type: "POST",//方法类型
                                    url: "<?php echo site_url('database/back_op');?>",//url
                                    data: {table: postData},
                                    dataType: 'json',
                                    success: function (result) {
                                        if (result.code == 0) {
                                            lightyear.loading('hide');
                                            lightyear.notify(result.msg, 'success', 3000);
                                        } else {
                                            lightyear.loading('hide');
                                            lightyear.notify(result.msg, 'danger', 3000);
                                        }
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        lightyear.notify('备份失败', 'danger', 3000);
                                    }
                                });
                            }, 1e3);
                        }
                    },
                    close: {
                        text: '关闭'
                    }
                }
            });
        }

        //打开添加菜单的弹出框
        function open_add_Label(table) {
            $.get('<?php echo site_url("database/dict")?>?table=' + table, function (res) {
                $("#add-database").html(res.html);
                $("#add_database_Label").html(res.title)
                $("#add_database").modal();
            }, 'json')
        }
		
		function save_dict() {
			lightyear.loading('show');
            setTimeout(function () {
                $.ajax({
                    type: "POST",//方法类型
                    url: "<?php echo site_url('database/dict_op');?>",
                    data: $('#add_database_form').serialize(),
                    dataType: 'json',
                    success: function (result) {
                        if (result.code == 0) {
                            lightyear.notify(result.msg, 'success', 3000);
                            $("#add_database").modal('hide');
                        } else {
                            lightyear.notify(result.msg, 'danger', 3000);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        lightyear.notify('对不起，失败', 'danger', 3000);
                    },
                    complete: function () {
                        lightyear.loading('hide');
                    }
                });
            }, 1e3);
		}
    </script>