$(function(){
	$("#join_time").datetimepicker({
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd",
		timeFormat: "HH:mm:ss",
		changeMonth: true,
		changeYear: true,
		showOtherMonths: true,
		selectOtherMonths: true
	});
	
	// 表单提交保存
	$('#detailform').submit(function(){
		var data = $(this).serialize();
		$.post('/admin/author/save', data, function(response){
			if (response.success)
			{
				window.location.href="/admin/author/index";
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
	
});