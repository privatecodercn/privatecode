$(function(){
	$('form').submit(function(){
		var data = $(this).sereialize();
		aelrt(data.content);
		$.post('/admin/weixinMenu/release', data, function(response) {
			if (response.success)
			{
				alert('发布成功！');
			} else{
				alert(response.message);
			}
		}, 'json');
		return false;
	});
		
});