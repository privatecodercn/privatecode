function uploadComplete(response) {response = $.parseJSON(response);$('#cover_image'+response.data.index).val(response.data.path);$('#cover_image_id'+response.data.index).val(response.data.id);var html = '<img src="'+response.data.path+'" />';$('#cover_image_preview'+response.data.index).html(html);};function test(){}$(function(){var uploaderOptions = {"holder": "ASUploaderPlaceHolder","movieName": "ASUploaderFlash","flashUrl": "/assets/ASUploader/ASUploader.swf","uploadUrl": "/admin/index/uploadImg","width": 18,"height": 18,"fileTypesDesc": "Image","fileTypes": "*.png;*.jpg;*.gif","multiFiles": true,"autoUpload": true,"completeCallback": "uploadComplete","postParams": {"index":"", "type":"fragment"}};new ASUploader(uploaderOptions).create();uploaderOptions.holder = "ASUploaderPlaceHolder1";uploaderOptions.movieName = "ASUploaderFlash1";uploaderOptions.postParams.index = "1";new ASUploader(uploaderOptions).create();uploaderOptions.holder = "ASUploaderPlaceHolder2";uploaderOptions.movieName = "ASUploaderFlash2";uploaderOptions.postParams.index = "2";new ASUploader(uploaderOptions).create();uploaderOptions.holder = "ASUploaderPlaceHolder3";uploaderOptions.movieName = "ASUploaderFlash3";uploaderOptions.postParams.index = "3";new ASUploader(uploaderOptions).create();uploaderOptions.holder = "ASUploaderPlaceHolder4";uploaderOptions.movieName = "ASUploaderFlash4";uploaderOptions.postParams.index = "4";new ASUploader(uploaderOptions).create();$(".create_time").datetimepicker({buttonImageOnly: true,dateFormat: "yy-mm-dd",timeFormat: "HH:mm:ss",changeMonth: true,changeYear: true,showOtherMonths: true,selectOtherMonths: true});$('form').submit(function(){var coverImg = $('#cover_image').val();if (coverImg==''){alert('请上传封面图片!');return false;}var data = $(this).serialize();$.post('/admin/fragment/saveFocus', data, function(response){if (response.success){alert('保存成功');} else {alert('操作失败');}}, 'json');return false;});});$(function(){ var timerId=null;$('.topheader .right').hover(function(){clearTimeout(timerId);   timerId=setTimeout(function(){$('.userinfodrop').show();},300);},function(){clearTimeout(timerId);timerId=setTimeout(function(){$('.userinfodrop').hide();},500);}); $('.vernav .menu').click(function(){var $this=$(this);var url=$this.attr('href');var submenu=$(url);if(submenu.length>0){if(submenu.is(':visible')){submenu.slideUp();}else{submenu.slideDown();}}return  false; });$('.noticebar .close').click(function(){$(this).parent().fadeOut();});$('#headermenu li a').click(function(){$('#headermenu li').removeClass('current');$(this).parent().addClass('current');$('.mainwrapper .vernav').addClass('hide');$('.iconmenu').hide();$('#headersubmenu_'+$(this).attr('indexId')).show();return false;});$('#modifyPwdBox').dialog({autoOpen:false,modal:true,title:'修改密码',width:600,height:300,buttons: {"确定": function() {$('#commonModifyPwd').submit();},"取消": function() { $(this).dialog('close');}}});$('#commonModifyPwd').submit(function(){var data = $(this).serialize();$.post('/admin/index/doModifyPwd', data, function(response){if (response.success){alert('保存成功');$('#modifyPwdBox').dialog('close');} else {alert(response.message);}}, 'json');return false;});});function handler(name){var ifrHtml = '<iframe border="0" src=""></iframe>';switch (name){case '':alert('?');break;case 'profile':$.get('/admin/user/profile', function(data){$("body").append(data);$("#dialog-profile").dialog({resizable: true,height: 360,modal: true,buttons: {"OK": function() {$(this).dialog("close");},Cancel: function() {$(this).dialog("close");}}});$("input,select").uniform();});break;case 'modifypwd':$("#modifyPwdBox").dialog('open');break;case 'help':break;case 'logout':$.getJSON('/admin/doLogout', function(json){if (json.success){window.location='/admin/login';} else {alert('请求失败！');}});break;case '':break;default:alert('未知操作！');break;}return true;}function formatDate(fdate){var fTime =null; var fStr = 'ymdhis';var formatStr= "y-m-d h:i:s";if (fdate) {fTime = new Date(fdate);} else {fTime = new Date();}var formatArr = [fTime.getFullYear().toString(),(fTime.getMonth()+1).toString(),fTime.getDate().toString(),fTime.getHours().toString(),fTime.getMinutes().toString(),fTime.getSeconds().toString() ];for (var i=0; i<formatArr.length; i++){formatStr = formatStr.replace(fStr.charAt(i), formatArr[i]);}return formatStr;}