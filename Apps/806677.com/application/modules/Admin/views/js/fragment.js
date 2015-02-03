$(function(){
	// 表单提交保存
	$('#aboutusForm1').submit(function(){
		$.post('/admin/fragment/save/sign/aboutus', $(this).serialize(), function(response){
			if (response.success)
			{
				alert('操作成功！');
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
	$('#linksForm1').submit(function(){
		$.post('/admin/fragment/save/sign/links', $(this).serialize(), function(response){
			if (response.success)
			{
				alert('操作成功！');
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
	$('#aboutForm2').submit(function(){
		$.post('/admin/fragment/save/sign/aboutus', $(this).serialize(), function(response){
			if (response.success)
			{
				alert('操作成功！');
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
});