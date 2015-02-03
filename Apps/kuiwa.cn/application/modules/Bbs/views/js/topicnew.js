//实例化编辑器
var um = UM.getEditor('content', {
	initialFrameWidth:'956',
	initialFrameHeight:500,
	allowDivTransToP: false,
	zIndex:0,
	focus: true
});

$(function(){
	$('#newPostTab li').click(function(){
		$('#newPostTab li').removeClass('cur');
		$(this).addClass('cur');
	});
	// 表单提交保存
	$('#newPostForm').submit(function(){
		um.sync();
		var data = $(this).serialize();
		data.content = um.getContent();
		$.post('/bbs/topic/saveNew', data, function(response){
			if (response.success)
			{
				window.location.href="/bbs/topic-"+response.data.id+".html";
			} else {
				alert(response.message);
			}
		}, 'json');
		return false;
	});
});