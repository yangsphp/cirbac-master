operate: {
 // post请求传输
            post: function(url, data) {
            	$.operate.submit(url, "post", "json", data);
            },
   // 修改行
            rowedit: function(row) {
                $.modal.loading("正在处理中，请稍后...");
        	    var url =  $.table._option.roweditUrl;
                var config = {
                    url: url,
                    type: "post",
                    dataType: "json",
                    data: row,
                    success: function(result) {
                        $.operate.ajaxSuccess(result);
                    }
                };
                $.ajax(config)
            },
    // 保存结果弹出msg刷新table表格
            ajaxSuccess: function (result) {
            	if (result.code == web_status.SUCCESS) {
                	$.modal.msgSuccess(result.msg);
            		$.table.refresh();
                } else {
                	$.modal.alertError(result.msg);
                }
            	$.modal.closeLoading();
            }
 
}