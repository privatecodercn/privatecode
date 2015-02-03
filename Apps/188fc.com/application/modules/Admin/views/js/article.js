//实例化编辑器
var ue = UE.getEditor('content',{PHPSESSID:'<?php echo session_id(); ?>', initialFrameWidth:'100%'});
ue.addListener('ready',function(){
  this.focus()
});

$(function(){
	// 表单提交保存
	$('#detailform').submit(function(){
		ue.sync();
		var data = $(this).serialize();
		data.content = ue.getContent();
		$.post('/admin/article/save', data, function(response){
			if (response.success)
			{
				window.location.href="/admin/article";
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
});