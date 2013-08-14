//log
function log(args) {
	$.get('http://crm.itaobox.com/index.php?route=api/tool/ilog',{msg:args},function(data){
		if (data.hasOwnProperty('error_response')) {
			alert( 'system error, Please try it later!');
		}else{
			alert( 'system error, Please try it later!');	
		}
	},'json');
}