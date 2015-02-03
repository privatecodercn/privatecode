<?php include dirname(__DIR__).'/header.html.php'; ?>
<?php include dirname(__DIR__).'/tabs.html.php'; ?>

<div id="form">
    <form id="house" name="form1" method="post" action="">
        <ul id="pics">
        	<li id="chooseImage" onclick="chooseImage()"><img src="http://ww3.sinaimg.cn/large/005VaPhhgw1eomxyacjb7j302i02i0sk.jpg" border="0" width="90" /></li>
        </ul>
        <div class="ui-field-contain">
        	<label for="loupan">小区</label>
        	<input type="text" name="loupan" id="loupan" />
            <input type="hidden" name="loupan_id" id="loupan_id" />
        </div>
        <div class="ui-field-contain">
        	<label for="region">区域</label>
        	<input type="text" name="region" id="region" />
            <input type="hidden" name="region_id" id="region_id" />
        </div>
        <div class="ui-field-contain">
        	<label for="room">户型</label>
        	<input type="text" name="room" id="room" data-mini="true" /> 室
        	<input type="text" name="hall" id="hall" data-mini="true" /> 厅
        	<input type="text" name="washroom" id="washroom" data-mini="true" /> 卫
        	<input type="text" name="balcony" id="balcony" data-mini="true" /> 阳台
        </div>
        <div class="ui-field-contain">
        	<label for="floor">楼层</label>
        	<input type="text" name="floor" id="floor" />
        </div>
        <div class="ui-field-contain">
        	<label for="total_floor">总楼层</label>
        	<input type="text" name="total_floor" id="total_floor" />
        </div>
    </form>

    <form id="building" name="form1" method="post" action="" class="hide">
        building
    </form>

    <form id="shop" name="form1" method="post" action="" class="hide">
        shop
    </form>
</div>

<?php
$vt->preInc('http://res.wx.qq.com/open/js/jweixin-1.0.0.js');
//$vt->preload('form', 'js');
?>
<?php include dirname(__DIR__).'/footer.html.php';?>
<script type="text/javascript">
$(document).bind("mobileinit", function(){   
    $.mobile.page.prototype.options.keepNative = "select";   
});
var winWidth = $(document.body).width();
var iWidth = 90;
	
wx.config({
	debug: true,
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
					alert(3+$('#pics').html());
				}
				
			}
		});
	});
	/*goSlide({
		'holder': 'pics',
	});*/
});

</script>
