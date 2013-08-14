$(function(){
	//个人
	$('#person_customer').jqBootstrapValidation();
	var options = { 
        target:        '#aa',   // target element(s) to be updated with server response 
        beforeSubmit:  function(arr, $form, options){// pre-submit callback 
			
		},
        success: function(responseText, statusText, xhr, $form){ // post-submit callback
			alert('添加成功！');
			$('.modal').modal('hide');
		},
		url:'http://crm.itaobox.com/index.php?route=api/customer/add',
		type:'get',
		resetForm:true
    };
    $('#person_customer').ajaxForm(options);
	
	//企业
	$('#business_customer').jqBootstrapValidation();
	var options = {
		target:        '#aa',
        beforeSubmit:  function(arr, $form, options){},
        success: function(responseText, statusText, xhr, $form){
			alert('添加成功！');
			$('.modal').modal('hide');
		},
		url:'http://crm.itaobox.com/index.php?route=api/customer/add',
		type:'get',
		resetForm:true
    };
    $('#business_customer').ajaxForm(options);
});

function SyncTaobao() {
	
}

