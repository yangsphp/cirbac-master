<?php $this->load->view('common/header')?>
<?php //var_dump($buttons); ?>
<div class="container-fluid p-t-15">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
				<div class="card-header"><h4>登录日志</h4></div>
				<div class="card-toolbar clearfix">
					<form class="pull-right search-bar" method="get" action="#!" role="form">
					  <div class="input-group">
						<div class="input-group-btn">
						  <input type="hidden" name="search_field" id="search-field" value="title">
						  <button class="btn btn-default dropdown-toggle" id="search-btn" data-toggle="dropdown" type="button" aria-haspopup="true" aria-expanded="false">
						  标题 <span class="caret"></span>
						  </button>
						  <ul class="dropdown-menu">
							<li> <a tabindex="-1" href="javascript:void(0)" data-field="title">标题</a> </li>
							<li> <a tabindex="-1" href="javascript:void(0)" data-field="cat_name">栏目</a> </li>
						  </ul>
						</div>
						<input type="text" class="form-control" value="" name="keyword" placeholder="请输入名称">
					  </div>
					</form>
					<div class="toolbar-btn-action">
						<!--操作按钮-->
					</div>
				</div>
                <div class="card-body">
                    <div id="toolbar2" class="toolbar-btn-action">
                        <table id="logs_tab" style="text-align:center;word-break:break-all;"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('common/footer')?>
<script type="text/javascript" src="<?php echo $skin; ?>new/js/main.min.js"></script>
    <script type="text/javascript">
        $('#logs_tab').bootstrapTable({
            classes: 'table table-bordered table-hover table-striped table-condensed table-responsive',
            url: "<?php echo site_url('logs/show_logs');?>",
            method: 'post',
            dataType: 'json',        // 因为本示例中是跨域的调用,所以涉及到ajax都采用jsonp,
            uniqueId: 'id',
            idField: 'index',        // 每行的唯一标识字段
            contentType: "application/x-www-form-urlencoded",
            //toolbar: '#toolbar',       // 工具按钮容器
            //clickToSelect: true,     // 是否启用点击选中行
            showColumns: false,         // 是否显示所有的列
            showRefresh: false,         // 是否显示刷新按钮
            //showToggle: true,        // 是否显示详细视图和列表视图的切换按钮(clickToSelect同时设置为true时点击会报错)
            pagination: true,                    // 是否显示分页
            sortName: 'id', 			// 要排序的字段
            sortOrder: "desc",                    // 排序方式
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

            columns: [{
                    field: 'id', title: '日志ID'
                },{
                    field: 'username', title: '用户', align: 'left'
                }, {
                    field: 'logindate', title: '时间'
                },{
                    field: 'loginip', title: 'IP'
                },{
                    field: 'useragent', title: '客户端'
                }],

            onLoadSuccess: function (data) {
                $("[data-toggle='tooltip']").tooltip();
            }

        });
    </script>