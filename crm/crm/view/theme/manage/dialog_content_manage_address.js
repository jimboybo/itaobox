$(function(){
	$('a[p=dialog_manage_address]').click(function(){
		$('#dialog_manage_address').css({
			'width':'750px',
			'margin-left': function () {
			    return -($(this).width() / 2);
			}
		});
		
		$('#dialog_manage_address').modal('show')
	});
});



