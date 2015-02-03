/******************************
* Additional function for this site
* Written by JimmyBryant
*******************************/

$(function(){			 //dom ready
	
	//show hide userinfodrop
	var timerId=null;
	$('.topheader .right').hover(function(){
		clearTimeout(timerId);
	   	timerId=setTimeout(function(){$('.userinfodrop').show();},300);
	},function(){
		clearTimeout(timerId);
		timerId=setTimeout(function(){$('.userinfodrop').hide();},500);
	}); 

	//show hide vertical nav
	$('.vernav .menu').click(function(){
		var $this=$(this);
		var url=$this.attr('href');
		var submenu=$(url);
		if(submenu.length>0){
			if(submenu.is(':visible')){
				submenu.slideUp();
			}else{
				submenu.slideDown();
			}
		}
		return  false;
 
	});

	//close notice
	$('.noticebar .close').click(function(){
		$(this).parent().fadeOut();
	});

	//switch menu
	$('#headermenu li a').click(function(){
		$('#headermenu li').removeClass('current');
		$(this).parent().addClass('current');
		$('.mainwrapper .vernav').addClass('hide');
		$('.iconmenu').hide();
		$('#headersubmenu_'+$(this).attr('indexId')).show();
		return false;
	});

//	$("#dialog").dialog();

});

function handler(name)
{
	var ifrHtml = '<iframe border="0" src=""></iframe>';
	switch (name)
	{
		case '':
			alert('?');
		break;

		case 'profile':
			$.get('/profile', function(data){
				$("body").append(data);
				$("#dialog-profile").dialog({
					resizable: true,
					height: 360,
					modal: true,
					buttons: {
						"OK": function() {
							$(this).dialog("close");
						},
						Cancel: function() {
							$(this).dialog("close");
						}
					}
				});
				$("input,select").uniform();
			});
		break;

		case 'modifypwd':
			
		break;

		case 'help':
			
		break;

		case 'logout':
			$.getJSON('/admin/doLogout', function(json){
				if (json.success)
				{
					window.location='/admin/login';
				} else {
					alert('请求失败！');
				}
			});
		break;

		case '':
			
		break;

		default:
			alert('未知操作！');
		break;
	}
	return true;
}
function formatDate(fdate)
{
	var fTime =null; 
	var fStr = 'ymdhis';
	var formatStr= "y-m-d h:i:s";
	if (fdate) {
		fTime = new Date(fdate);
	} else {
		fTime = new Date();
	}
	var formatArr = [
		fTime.getFullYear().toString(),
		(fTime.getMonth()+1).toString(),
		fTime.getDate().toString(),
		fTime.getHours().toString(),
		fTime.getMinutes().toString(),
		fTime.getSeconds().toString() 
	];
	for (var i=0; i<formatArr.length; i++)
	{
		formatStr = formatStr.replace(fStr.charAt(i), formatArr[i]);
	}
	return formatStr;
}