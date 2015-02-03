$(function(){
	$("#createNew").click(function(){
		maxI += 1;
		var box = $('#newsbox0').clone();
		box.attr('id', 'newsbox'+maxI);
		box.find('#title0').val('').attr('id', 'title'+maxI).attr('name', 'titles['+maxI+']');
		box.find('#url0').val('').attr('id', 'url'+maxI).attr('name', 'urls['+maxI+']');
		$('#newsbox'+(maxI-1)).after(box);
	});
	// 表单提交保存
	$('form').submit(function(){
		var data = $(this).serialize();
		$.post('/admin/fragment/saveIndexNews', data, function(response){
			if (response.success)
			{
				alert('保存成功');
			} else {
				alert(response.message);
			}
		}, 'json');
		return false;
	});
	
});