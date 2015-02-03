
function uploadComplete(response) {
	response = $.parseJSON(response);
	$('#cover_image').val(response.data.path);
	$('#cover_image_id').val(response.data.id);
	var html = '<img src="'+response.data.path+'" />';
	$('#cover_image_preview').html(html);
};
$(function(){
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
		"postParams"		: {"multi_merge":1, "type":"album"}
	}).create();
	$("#create_time").datetimepicker({
		buttonImageOnly: true,
		dateFormat: "yy-mm-dd",
		timeFormat: "HH:mm:ss",
		changeMonth: true,
		changeYear: true,
		showOtherMonths: true,
		selectOtherMonths: true
	});
	$("#author_nickname").autocomplete({
		source: '/AutoComplete/author',
		select: function( event, ui ) {
			$('#author_uid').val(ui.item.value);
			$('#author_nickname').val(ui.item.name);
			return false;
		}
	});
	// 表单提交保存
	$('#detailform').submit(function(){
		var coverImg = $('#cover_image').val();
		if (coverImg=='')
		{
			alert('请上传封面图片!');
			return false;
		}
		var data = $(this).serialize();
		$.post('/admin/album/save', data, function(response){
			if (response.success)
			{
				window.location.href="/admin/album/index";
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
	
});