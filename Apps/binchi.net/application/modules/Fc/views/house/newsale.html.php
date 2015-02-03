<?php 
$preLoadCss = ['form'];
include dirname(__DIR__).'/header.html.php';
?>
<?php include dirname(__DIR__).'/tabs.html.php'; ?>

<div id="form">
    <form id="house" name="form1" method="post" action="">
        <ul id="pics">
        	<li id="chooseImage" onclick="chooseImage()" style="display:none;"><img src="http://ww3.sinaimg.cn/large/005VaPhhgw1eomxyacjb7j302i02i0sk.jpg" border="0" width="90" /></li>
        </ul>
        <hgroup>
            <div>
                <label for="loupan">小区</label>|&nbsp;&nbsp;
                <input type="text" name="loupan" id="loupan" placeholder="1~30字" />
                <input type="hidden" name="loupan_id" id="loupan_id" />
            </div>
            <div>
                <label for="region">区域</label>|&nbsp;&nbsp;
                <input type="text" name="region" id="region" />
                <input type="hidden" name="region_id" id="region_id" />
            </div>
        </hgroup>
        <hgroup>
            <div class="hx">
                <label for="room">户型</label>|&nbsp;&nbsp;
                <input name="room" type="text" id="room" size="2" /> 室
                <input name="hall" type="text" id="hall" size="2" /> 厅
                <input name="washroom" type="text" id="washroom" size="2" /> 卫
                <input name="balcony" type="text" id="balcony" size="2" /> 阳台
            </div>
            <div>
                <label for="floor">楼层</label>|&nbsp;&nbsp;
                <input type="text" name="floor" id="floor" placeholder="第几层" />
            </div>
            <div>
                <label for="total_floor" class="minispacing">总楼层</label>|&nbsp;&nbsp;
                <input type="text" name="total_floor" id="total_floor" placeholder="共几层" />
            </div>
            <div>
                <label for="floor">面积</label>|&nbsp;&nbsp;
                <input type="text" name="floor" id="floor" />
            </div>
            <div>
                <label for="total_floor">售价</label>|&nbsp;&nbsp;
                <input type="text" name="total_floor" id="total_floor" />
            </div>
        </hgroup>
        <hgroup>
            <div>
                <label for="fitment">装修</label>|&nbsp;&nbsp;
                <select name="fitment" id="fitment">
                <option value="0">毛坯</option>
                <option value="1">简单装修</option>
                <option value="2">中等装修</option>
                <option value="3">精装修</option>
                <option value="4">豪华装修</option>
                </select>
            </div>
            <div>
                <label for="property_year">产权</label>|&nbsp;&nbsp;
                <select name="property_year" id="property_year">
                    <option value="70">70年产权</option>
                    <option value="50">50年产权</option>
                    <option value="40">40年产权</option>
                    <option value="30">30年产权</option>
                </select>
            </div>
            <div>
                <label for="type">类型</label>|&nbsp;&nbsp;
                <select name="type" id="type">
                    <option value="1">商品房</option>
                    <option value="2">商住两用</option>
                    <option value="3">经济适用房</option>
                    <option value="4">公房</option>
                    <option value="5">使用权</option>
                </select>
            </div>
        </hgroup>
        <hgroup>
            <div>
                <label for="title">标题</label>|&nbsp;&nbsp;
                <input type="text" name="title" id="title" placeholder="8~30字" />
            </div>
            <div>
              <label for="description" style="vertical-align:top">描述</label><span style="vertical-align:top">|</span>&nbsp;&nbsp;
                <textarea id="description" name="description" cols="30" rows="6" style="margin-top:10px;"></textarea>
                <input type="hidden" name="region_id" id="region_id" />
            </div>
        </hgroup>
        <div align="center">
        	<button type="submit">发布</button>
        </div>
    </form>

    <form id="building" name="form1" method="post" action="" class="hide">
        building
    </form>

    <form id="shop" name="form1" method="post" action="" class="hide">
        shop
    </form>
</div>

<div id="loading">
正在加载......
</div>
<?php
$vt->preInc('http://res.wx.qq.com/open/js/jweixin-1.0.0.js');
$vt->preInc('/assets/js/goSlide.js');
//$vt->preload('form', 'js');
?>
<?php include dirname(__DIR__).'/footer.html.php';?>
<script type="text/javascript">
var winWidth = $(document.body).width();
var iWidth = 90;
var wxReady = false;
var picNums = 1;

$('hgroup').width(winWidth-22);

wx.config({
	debug: false,
	appId: 'wx79199e80a9511190',
	timestamp: '<?=$timestamp?>',
	nonceStr:  '<?=$nonceStr?>',
	signature: '<?=$signature?>',
	jsApiList: ['chooseImage', 'uploadImage', 'downloadImage', 'previewImage']
});

wx.ready(function(){
	wxReady = true;
	$('#chooseImage').show();
	$('#loading').hide();
});
$(function(){
	$('#chooseImage').click(function(){
		alert(33);
		if (!wxReady)
		{
			alert('请稍等微信初始化后操作！');
		}
		wx.chooseImage({
			success: function (res) {
				var localIds = res.localIds;
				if (localIds.length>9) 
				{
					alert('最多只能上传9张图片，已自动忽略第9张后的图片！');
					return false;
				}
				picNums += localIds.length;
				for (var i in localIds)
				{
					var ele = $('<li><img src="'+localIds[i]+'" border="0" /></li>');
					ele.css({'width':iWidth,'height':iWidth, 'margin':'0 3px'});
					if ((picNums*96)>winWidth)
					{
						ele.css('float', 'left');
					} else {
						ele.css('display', 'inline-block');
					}
					ele.find('img').css({'width':iWidth, 'height':iWidth});
					//$('#pics').append(ele);
					ele.appendTo($('#pics'));
				}
				if ((picNums*96)>winWidth)
				{
					$('#pics').css({'text-align':'left','width':picNums*96});
					$('#chooseImage').css({'margin':'0 3px', 'float':'left'});
				} else {
					$('#chooseImage').css({'display':'inline-block'});
				}
				
			}
		});
	});
	$('form').submit(function(){
		var tabType = $(this).attr('id');
		alert(tabType);
		return false;
	});
	goSlide({
		'holder': 'pics',
	});
});

</script>
