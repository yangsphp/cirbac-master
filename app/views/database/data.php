<?php $this->load->view('common/header')?>
<?php //var_dump($buttons); ?>
<div class="container-fluid p-t-15">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
				<ul class="nav nav-tabs page-tabs">
				  <li > <a href="<?php echo site_url('database/index');?>">数据维护</a> </li>
				  <li class="active"> <a href="#!">数据恢复</a> </li>
				  <!--
				  <li> <a href="lyear_pages_config_system.html">系统</a> </li>
				  <li> <a href="lyear_pages_config_upload.html">上传</a> </li>
				  -->
				</ul>
                <div class="tab-content">

                    <div id="toolbar2" class="toolbar-btn-action">
                        <?php if (in_array('删除_back', $buttons)) { ?>
                            <button type="button" class="btn btn-danger btn-sm  m-r-5" onclick="selected_del()">
                                <span class="mdi mdi-window-close" aria-hidden="true"></span>删除
                            </button>
                        <?php } ?>
                        <table id="database_tab" style="text-align:center;word-break:break-all;"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('common/footer')?>
<script type="text/javascript" src="<?php echo $skin; ?>new/js/main.min.js"></script>
    <script type="text/javascript">
        $('#database_tab').bootstrapTable({
            classes: 'table table-bordered table-hover table-striped table-condensed table-responsive',
            url: "<?php echo site_url('database/show_back');?>",
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
            pagination: true,                    // 是否显示分页
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
                    field: 'name', title: 'SQL文件', align: 'left'
                }, {
                    field: 'size', title: '文件大小'
                }, {
                    field: 'date_entered', title: '备份时间'
                },{
                    field: 'operate', title: '操作', width: '150px', align: 'center', formatter: btnGroup, // 自定义方法
                    events: {
                        'click .callback-btn': function (event, value, row, index) {  
                            callback_operate(row.id);
                        },
                        'click .download-btn': function (event, value, row, index) {  
                            download_operate(row.name, row.path);
                        }, 
						'click .del-btn': function (event, value, row, index) {
							del_operate(row.id);
						}
                    }
                }],

            onLoadSuccess: function (data) {
                $("[data-toggle='tooltip']").tooltip();
            }

        });

        // 操作按钮
        function btnGroup(value, row, index) {
            let html = '', back_flag = '<?php echo in_array('还原', $buttons) ? 1 : 0?>', download_flag = '<?php echo in_array('下载', $buttons) ? 1 : 0?>', delete_flag = '<?php echo in_array('删除', $buttons) ? 1 : 0?>';
            if (back_flag == 1) {
                html += '<a href="#!" class="btn btn-xs btn-default m-r-5 callback-btn" title="还原" data-toggle="tooltip"><i class="mdi mdi-wrench"></i></a>';
            }
            if (download_flag == 1) {
                html += '<a href="#!" class="btn btn-xs btn-default m-r-5 download-btn" title="下载" data-toggle="tooltip"><i class="mdi mdi-download"></i></a>';
            }
			if (delete_flag == 1) {
                html += '<a href="#!" class="btn btn-xs btn-default m-r-5 del-btn" title="删除" data-toggle="tooltip"><i class="mdi mdi-close"></i></a>';
            }
            return html;
        }
		
		function callback_operate(id) {
			$.confirm({
                title: '还原提示',
                content: '还原后不可恢复，请谨慎！',
                type: 'red',
                typeAnimated: true,
                buttons: {
				tryAgain: {
					text: '还原',
					btnClass: 'btn-red',
					action: function () {
						lightyear.loading('show');
						setTimeout(function () {
							$.ajax({
								type: "POST",//方法类型
								url: "<?php echo site_url('database/callback_op');?>",//url
								data: {id: id},
								dataType: 'json',
								success: function (result) {
									if (result.code == 0) {
										lightyear.loading('hide');
										lightyear.notify(result.msg, 'success', 3000);
										//window.location.reload();
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
		
		function download_operate(name, path) {
			let tempa = document.createElement('a');
			tempa.download = name;
			tempa.href = path;
			document.body.appendChild(tempa);
			tempa.click();
			tempa.remove()
		}
		
		//删除菜单
        function del_operate(id, index) {
            $.confirm({
                title: '删除提示',
                content: '删除后不可恢复，请谨慎！',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: '删除',
                        btnClass: 'btn-red',
                        action: function () {
                            lightyear.loading('show');
                            setTimeout(function () {
                                $.ajax({
                                    type: "POST",//方法类型
                                    url: "<?php echo site_url('database/delete_op');?>",//url
                                    data: {id: id},
                                    dataType: 'json',
                                    success: function (result) {
                                        if (result.code == 0) {
                                            lightyear.loading('hide');
                                            lightyear.notify(result.msg, 'success', 3000);
                                            $('#database_tab').bootstrapTable('refresh');
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
        function selected_del() {
            var selRows = $('#database_tab').bootstrapTable("getSelections");
            if (selRows.length == 0) {
                lightyear.notify('请选择要备份的行', 'danger', 3000);
                return;
            }
            console.log(selRows);

            var postData = "";
            $.each(selRows, function (i) {
                postData += this.id;
                if (i < selRows.length - 1) {
                    postData += ",";
                }
            });
            $.confirm({
                title: '删除提示',
                content: '删除后不可恢复，请谨慎！',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: '删除',
                        btnClass: 'btn-red',
                        action: function () {
                            lightyear.loading('show');
                            setTimeout(function () {
                                $.ajax({
                                    type: "POST",//方法类型
                                    url: "<?php echo site_url('database/delete_op');?>",//url
                                    data: {id: id},
                                    dataType: 'json',
                                    success: function (result) {
                                        if (result.code == 0) {
                                            lightyear.loading('hide');
                                            lightyear.notify(result.msg, 'success', 3000);
											$('#database_tab').bootstrapTable('refresh');
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
    </script>