$(function () {
    // popover demo
    $("a[data-toggle=popover]").popover({
		html:true,
		trigger:'click',
		placement:'right',
		offset:5
	}).click(function(e) {
        e.preventDefault()
    });
	
	//删除客户
	$('table#table_customer_list tbody tr a[p_action="delete"]').on('click',function(event){
		var id=$(this).attr('p_id');
		var self = $(this);
		$.get(base_url+'?route=api/customer/del',{data:id},function(data){
			if (data.hasOwnProperty('error_response')) {
				log('[页面：manage/customers - 接口：api/customer/del - 参数：id:'+id+'] [错误：'+data.error_response.code+' - '+data.error_response.msg+']');
			}
			else{
				//删除节点
				self.parent().parent().animate({
					opacity: 0,
					height:'toggle'
				}, 200, function() {
					
				});
			}
		},'json');
	});
	
});