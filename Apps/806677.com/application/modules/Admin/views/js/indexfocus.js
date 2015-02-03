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
	new ASUploader(uploaderOptions).create();
	
	uploaderOptions.holder = "ASUploaderPlaceHolder1";
	uploaderOptions.movieName = "ASUploaderFlash1";
	uploaderOptions.postParams.index = "1";
	new ASUploader(uploaderOptions).create();
	
	uploaderOptions.holder = "ASUploaderPlaceHolder2";
	uploaderOptions.movieName = "ASUploaderFlash2";
	uploaderOptions.postParams.index = "2";
	new ASUploader(uploaderOptions).create();
	
	uploaderOptions.holder = "ASUploaderPlaceHolder3";
	uploaderOptions.movieName = "ASUploaderFlash3";
	uploaderOptions.postParams.index = "3";
	new ASUploader(uploaderOptions).create();
	
	uploaderOptions.holder = "ASUploaderPlaceHolder4";
	uploaderOptions.movieName = "ASUploaderFlash4";
	uploaderOptions.postParams.index = "4";
	new ASUploader(uploaderOptions).create();
	
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