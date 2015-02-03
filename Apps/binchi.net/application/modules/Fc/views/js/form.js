$(document).bind("mobileinit", function(){   
    $.mobile.page.prototype.options.keepNative = "select";   
});
var winWidth = $(document.body).width();
var iWidth = 90;
	
wx.config({
	debug: false,
	appId: 'wx79199e80a9511190',
	timestamp: '<?=$timestamp?>',
	nonceStr:  '<?=$nonceStr?>',
	signature: '<?=$signature?>',
	jsApiList: ['chooseImage', 'uploadImage', 'downloadImage', 'previewImage']
});
$(function(){
	$('#chooseImage').click(function(){
		wx.chooseImage({
			success: function (res) {
				var localIds = res.localIds;
				var num = 0;
				for (var i in localIds)
				{
					num++;
					if (num>9) 
					{
						alert('最多只能上传9张图片，已自动忽略第9张后的图片！');
						break;
					}
					var ele = $('<li><img src="'+localIds[i]+'" border="0" /></li>');
					ele.css({'width':iWidth,'height':iWidth});
					ele.find('img').css({'width':iWidth, 'height':iWidth});
					$('#pics').append(ele);
				}
				if ($('#pics li').length>1)
				{
					$('#pics').css({'text-align':'left','width':96*$('#pics li').length});
				}
			}
		});
	});
	/*goSlide({
		'holder': 'pics',
	});*/
});