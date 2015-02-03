$(function(){
	// 表单提交保存
	$('#detailform').submit(function(){
		var data = $(this).serialize();
		$.post('/admin/category/save', data, function(response){
			if (response.success)
			{
				window.location.href="/admin/category/index";
			} else {
				alert(response.message);
			}
		}, 'json');
		return false;
	});
	
});