function uploadCompleteHandler(request) {
	request = $.parseJSON(request);
	//alert(request.data);
	$('#title_image').val(request.data);
};
$(function(){
	ASUploader = new ASUploader({
		movieName				: "ASUploaderFlash",
		flashUrl				: "/j?ASUploader/ASUploader.swf",
		uploadUrl				: "/article/uploadImg",
		lableText				: "选择本地图片",
		textTopPadding			: 0,
		textLeftPadding			: 0,
		width					: 110,
		height					: 30,
		fileTypesDesc			: "Image",
		fileTypes				: "*.png;*.jpg;*.gif",
		postParams				: {"multi_merge":1, "more_params":"much more"},
		fileQueueLimit			: 5,
		multiFiles				: false,
		autoUpload				: true,
		uploadCompleteHandler	: "uploadCompleteHandler"
	}).create();
	// 表单提交保存
	$('#detailform').submit(function(){
		$.post('/admin/article/save', $(this).serialize(), function(response){
			if (response.success)
			{
				$("#detail-box").dialog('close');
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
});


// 编辑设置表单信息
function setFormInfo(id)
{
	$.getJSON('/admin/article/read?id='+id, function(json){
		if (json.success)
		{
			$.each(json.data, function(i,n){
				$('#'+i).val(n);
			});
			$('#post_time').val(formatDate(json.data.post_time*1000));
			keditor.html(json.data.content);
			//alert(json.data.content);
		} else {
			alert('获取文章内容失败！');
		}
	});
}
var keditor = null;

// 打开表单对话框
function openForm(id)
{
	if (id)
	{
		var op = '修改';
	} else {
		var op = '添加';
	}
	$("#detail-box").dialog({
		height: 900,
		width: 900,
		modal: true,
		autoOpen: true,
		title: op + '博客信息',
		buttons: {
			'保存': function() {
				keditor.sync('#editor');
				$('#detailform').submit();
			},
			'取消': function() {
				$(this).dialog('close');
			}
		},
		close: function() {
			$("#detailform")[0].reset();
		},
		open : function(event, ui) {
			// 打开Dialog后创建编辑器
			keditor = KindEditor.create('#editor', {
				themeType : 'simple',
				cssPath : ['/stc/kindeditor/plugins/code/prettify.css']
			});
		},
		beforeClose : function(event, ui) {
			// 关闭Dialog前移除编辑器
			keditor.remove();
		}
	});
	if (id)
	{
		setFormInfo(id);
	}
}