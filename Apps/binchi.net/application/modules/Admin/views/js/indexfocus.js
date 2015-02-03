function uploadComplete(response) {
	response = $.parseJSON(response);
	$('#cover_image'+response.data.index).val(response.data.path);
	$('#cover_image_id'+response.data.index).val(response.data.id);
	var html = '<img src="'+response.data.path+'" />';
	$('#cover_image_preview'+response.data.index).html(html);
};
function test()
{
	
}
$(function(){
	var uploaderOptions = {
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
		"postParams"		: {"index":"", "type":"fragment"}
	};
	
	for (var ii=0; ii<=maxUploader; ii++) {
		uploaderOptions.holder = "ASUploaderPlaceHolder" + ii.toString();
		uploaderOptions.movieName = "ASUploaderFlash" + ii.toString();
		uploaderOptions.postParams.index = ii.toString();
		new ASUploader(uploaderOptions).create();
	}
	
	$(".create_time").datetimepicker({
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd",
		timeFormat: "HH:mm:ss",
		changeMonth: true,
		changeYear: true,
		showOtherMonths: true,
		selectOtherMonths: true
	});
	// 表单提交保存
	$('form').submit(function(){
		var coverImg = $('#cover_image').val();
		if (coverImg=='')
		{
			alert('请上传封面图片!');
			return false;
		}
		var data = $(this).serialize();
		$.post('/admin/fragment/saveFocus', data, function(response){
			if (response.success)
			{
				alert('保存成功');
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
	
});