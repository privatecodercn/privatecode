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
		"postParams"		: {"multi_merge":1, "type":"video"}
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
	$("#album").autocomplete({
		source: '/AutoComplete/album',
		select: function( event, ui ) {
			$('#album_id').val(ui.item.value);
			$('#album').val(ui.item.name);
			return false;
		}
	});
	$("#author_nickname").autocomplete({
		source: '/AutoComplete/author',
		select: function( event, ui ) {
			$('#author_uid').val(ui.item.value);
			$('#author_nickname').val(ui.item.name);
			return false;
		}
	});
	$('#cover_image').change(function (){
		var html = '<img src="'+$(this).val()+'" />';
		$('#cover_image_preview').html(html);
	});
	$('#url').change(function (){
		$.getJSON('/admin/video/autoVideoDetail/url/'+encodeURIComponent($(this).val()), function(response){
			if (response.success) {
				$('#title').val(response.data.title);
				$('#code').val(response.data.code);
				var html = '<embed src="'+response.data.code+'" quality="high" width="700" height="437" align="middle" autostart="false" allowScriptAccess="always" allowFullScreen="true" mode="transparent" type="application/x-shockwave-flash"></embed>';
				$('#previewCode').html(html);
			} else {
				aler
			}
		});
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
		$.post('/admin/video/save', data, function(response){
			if (response.success)
			{
				window.location.href="/admin/video/index";
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
	
});