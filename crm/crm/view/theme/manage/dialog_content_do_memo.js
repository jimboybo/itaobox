$(function(){
	$('a[p=dialog_do_memo]').click(function(){
		$('#dialog_do_memo').css({
			'width':'600px',
			'margin-left': function () {
			    return -($(this).width() / 2);
			}
		});
		
		$('#dialog_do_memo').modal('show');
	});
});



