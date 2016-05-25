;;;(function($){
	$(function(){
		$("[dellink]").click(function(){
			var url_arr = $(this).attr("href").split("/");
			var id = url_arr.pop();
			var url = url_arr.join("/");
			if(window.confirm("确认删除?数据删除将不可恢复!")) {
				$.post(url,{'id':id},function(data){
					var d = $.parseJSON(data);	
					if(d.res == true) {
						window.location.href = window.location.href;	
					} else {
						alert("删除失败!");	
					}
				});	
			}
			return false;	
		});
	});
})($);
