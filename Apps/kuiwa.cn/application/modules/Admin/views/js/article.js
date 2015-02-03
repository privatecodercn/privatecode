//实例化编辑器
var ue = UE.getEditor('content',
	{ 
		initialFrameWidth:'100%',
		initialFrameHeight:500,
		allowDivTransToP: false,
		zIndex:0
	});
ue.ready(function() {
	this.focus();
	ue.execCommand('serverparam', {
		//'targetType': '1'
	});
});
function uploadComplete(response)
{
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
		ue.sync();
		var data = $(this).serialize();
		data.content = ue.getContent();
		$.post('/admin/article/save', data, function(response){
			if (response.success)
			{
				window.location.href="/admin/article/index";
			} else {
				alert(response.message);
			}
		}, 'json');
		return false;
	});
	
});