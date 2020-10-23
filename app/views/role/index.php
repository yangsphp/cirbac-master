<?php $this->load->view('common/header')?>
<?php //var_dump($buttons); ?>
<div class="container-fluid p-t-15">

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header"><h4>角色管理</h4></div>
                <div class="card-body">

                    <div id="toolbar2" class="toolbar-btn-action">
                        <?php if (in_array('新增', $buttons)) { ?>
                            <button id="btn_add" type="button" class="btn btn-cyan btn-sm m-r-5"
                                    onclick="open_add_Label()">
                                <span class="mdi mdi-plus" aria-hidden="true"></span>新增
                            </button>
                        <?php }
                        if (in_array('删除', $buttons)) { ?>
                            <button type="button" class="btn btn-danger btn-sm  m-r-5" onclick="selected_del()">
                                <span class="mdi mdi-window-close" aria-hidden="true"></span>删除
                            </button>
                        <?php } ?>
                        <table id="role_tab" style="text-align:center;word-break:break-all;"></table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade" id="add_role" tabindex="-1" role="dialog"
         aria-labelledby="add_role_Label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="add_role_Label">新增角色</h4>
                </div>
                <div class="modal-body" id="add-role">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="save_role()">添加</button>
                </div>
            </div>
        </div>
    </div>


<?php $this->load->view('common/footer')?>
<script type="text/javascript" src="<?php echo $skin; ?>new/js/main.min.js"></script>


    <script type="text/javascript">
        $('#role_tab').bootstrapTable({
            classes: 'table table-bordered table-hover table-striped table-condensed table-responsive',
            url: "<?php echo site_url('role/show_role');?>",
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
            search: true,                      // 是否显示表格搜索，此搜索是客户端搜索

            //showExport: true,        // 是否显示导出按钮, 导出功能需要导出插件支持(tableexport.min.js)
            //exportDataType: "basic", // 导出数据类型, 'basic':当前页, 'all':所有数据, 'selected':选中的数据

            columns: [
                {checkbox: true, width: '50px'}, {
                    field: 'index',
                    title: 'ID',
                    width: '100px',
                    //sortable: true,    // 是否排序
                    formatter: function (value, row, index) {
                        var pageSize = $('#role_tab').bootstrapTable('getOptions').pageSize;     //通过table的#id 得到每页多少条
                        var pageNumber = $('#role_tab').bootstrapTable('getOptions').pageNumber; //通过table的#id 得到当前第几页
                        return pageSize * (pageNumber - 1) + index + 1;
                    }
                }, {
                    field: 'name', title: '名称'
                }, {
                    field: 'date_entered', title: '创建时间'
                }, {
                    field: 'operate', title: '操作', width: '150px', align: 'center', formatter: btnGroup, // 自定义方法
                    events: {
                        'click .edit-btn': function (event, value, row, index) {  //编辑角色
                            open_add_Label(row.id);
                        },
                        'click .del-btn': function (event, value, row, index) {  //删除角色
                            del_role(row.id, index);
                        }
                    }
                }],

            onLoadSuccess: function (data) {
                $("[data-toggle='tooltip']").tooltip();
            }

        });

        // 操作按钮
        function btnGroup(value, row, index) {
            let html = '', delete_flag = '<?php echo in_array('删除', $buttons) ? 1 : 0?>',
                edit_flag = '<?php echo in_array('编辑', $buttons) ? 1 : 0?>';
            if (edit_flag == 1) {
                html += '<a href="#!" class="btn btn-xs btn-default m-r-5 edit-btn" title="编辑" data-toggle="tooltip"><i class="mdi mdi-pencil"></i></a>';
            }
            if (delete_flag == 1) {
                html += '<a href="#!" class="btn btn-xs btn-default m-r-5 del-btn" title="删除" data-toggle="tooltip"><i class="mdi mdi-window-close"></i></a>';
            }
            return html;
        }


        //打开添加角色的弹出框
        function open_add_Label(id = 0) {
            $.get('<?php echo site_url("role/add")?>?id=' + id, function (res) {
                $("#add-role").html(res.html);
                $("#add_role_Label").html(res.title)
                $("#add_role").modal();
            }, 'json')
        }


        //保存角色
        function save_role() {
            lightyear.loading('show');
            setTimeout(function () {
                $.ajax({
                    type: "POST",//方法类型
                    url: "<?php echo site_url('role/add_op');?>",
                    data: $('#add_role_form').serialize(),
                    dataType: 'json',
                    success: function (result) {
                        if (result.code == 0) {
                            lightyear.notify(result.msg, 'success', 3000);
                            $('#role_tab').bootstrapTable('refresh');
                            $("#add_role").modal('hide');
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
		
        function del_role(id, index) {
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
                                    url: "<?php echo site_url('role/delete_op');?>",//url
                                    data: {id: id},
                                    dataType: 'json',
                                    success: function (result) {
                                        if (result.code == 0) {
                                            lightyear.loading('hide');
                                            lightyear.notify(result.msg, 'success', 3000);
                                            $('#role_tab').bootstrapTable('refresh');
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

        //批量删除
        function selected_del() {
            var selRows = $('#role_tab').bootstrapTable("getSelections");
            if (selRows.length == 0) {
                lightyear.notify('请选择要删除的行', 'danger', 3000);
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
                        text: '确定',
                        btnClass: 'btn-red',
                        action: function () {
                            lightyear.loading('show');
                            setTimeout(function () {
                                $.ajax({
                                    type: "POST",//方法类型
                                    url: "<?php echo site_url('role/delete_op');?>",//url
                                    data: {id: postData},
                                    dataType: 'json',
                                    success: function (result) {
                                        if (result.code == 0) {
                                            lightyear.loading('hide');
                                            lightyear.notify(result.msg, 'success', 3000);
                                            $('#role_tab').bootstrapTable('refresh');
                                        } else {
                                            lightyear.loading('hide');
                                            lightyear.notify(result.msg, 'danger', 3000);
                                        }
                                    },
                                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                                        lightyear.notify('删除失败', 'danger', 3000);
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