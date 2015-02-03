//实例化编辑器
var ue = UE.getEditor('content',
	{
		PHPSESSID:'<?php echo session_id(); ?>', 
		initialFrameWidth:'100%',
		initialFrameHeight:500,
		zIndex:0
	});
ue.addListener('ready',function(){
  this.focus()
});
function uploadComplete(response) {
	response = $.parseJSON(response);
	$('#cover_image').val(response.data.path);
	$('#cover_image_id').val(response.data.id);
	var html = '<img src="'+response.data.path+'" />';
	$('#cover_image_preview').html(html);
};
$(function(){
	$("#post_time").datetimepicker({
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd",
		timeFormat: "HH:mm:ss",
		changeMonth: true,
		changeYear: true,
		showOtherMonths: true,
		selectOtherMonths: true
	});
	
	ASUploader = new ASUploader({
		"holder"			: "ASUploaderPlaceHolder",
		"movieName"			: "ASUploaderFlash",
		"flashUrl"			: "/assets/ASUploader/ASUploader.swf",
		"uploadUrl"			: "/admin/index/uploadImg",
		"width"				: 18,
		"height"			: 18,
		"fileTypesDesc"		: "Image",
		"fileTypes"			: "*.png;*.jpg;*.gif",
		"multiFiles"		: true,
		"autoUpload"		: true,
		"completeCallback"	: "uploadComplete",
		"postParams"		: {"multi_merge":1, "type":"article"}
	}).create();
	// 表单提交保存
	$('#detailform').submit(function(){
		var coverImg = $('#cover_image').val();
		if (coverImg=='')
		{
			alert('请上传封面图片!');
			return false;
		}
		ue.sync();
		var data = $(this).serialize();
		data.content = ue.getContent();
		$.post('/admin/article/save', data, function(response){
			if (response.success)
			{
				window.location.href="/admin/article/index";
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
	
});