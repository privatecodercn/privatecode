<?php 
$preIncCss = array('http://code.jquery.com/ui/1.10.4/themes/cupertino/jquery-ui.css');
$preLoadCss = array('//timepicker');
include dirname(__DIR__).'/header.html.php';
?>
<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		
		<div id="detail-box" class="centerlist">
			<form method="POST" >
			<input type="hidden" name="focusIndex" value="0" />
			<fieldset>
			<legend>首页焦点大图</legend>
				<div class="line">
					<label>标题</label> <div class="field"><input type="text" id="title" name="title" value="<?=$focusBig->title?>" size="50" /></div>
				</div>
				<div class="line">
					<label>链接</label> <div class="field"><input type="text" id="url" name="url" value="<?=$focusBig->url?>" size="50" /></div>
				</div>
				<div class="line">
					<label>图片</label> 
					<div class="field">
						<input type="hidden" id="cover_image_id" name="cover_image_id" value="<?=$focusBig->cover_image_id?>" />
						<input type="hidden" id="cover_image" name="cover_image" value="<?=$focusBig->cover_image?>" />
						<div id="ASUploaderPlaceHolder" style="background:url(/assets/ASUploader/plus.gif);width:18px;height:18px;"></div>
						<div id="cover_image_preview"><?php if ($focusBig->cover_image){?><img src="<?=$focusBig->cover_image?>" /><?php }?></div>
					</div>
				</div>
				<div class="line">
					<label>发布日期</label> <div class="field"><input type="text" id="create_time" name="create_time" class="create_time" value="<?=date('Y-m-d', $focusBig->create_time)?>" size="50" /></div>
				</div>
				<div class="line">
					<label>简介</label> 
					<div class="field"><textarea id="brief" name="brief" rows="10" cols="80"><?=$focusBig->brief?></textarea></div>
				</div>
				<div class="line">
					<label></label> 
					<div class="field"><input type="submit" value="保存" /></div>
				</div>
			</fieldset>
			</form>
		</div>
		
		<?php
		for ($i=1; $i<=4; $i++) {
			
		?>
		<div id="detail-box" class="centerlist">
			<form method="POST" >
			<input type="hidden" name="focusIndex" value="<?=$i?>" />
			<fieldset>
			<legend>首页焦点小图<?=$i?></legend>
				<div class="line">
					<label>标题</label> <div class="field"><input type="text" id="title" name="title" value="<?=$focusSmall[$i]->title?>" size="50" /></div>
				</div>
				<div class="line">
					<label>链接</label> <div class="field"><input type="text" id="url" name="url" value="<?=$focusSmall[$i]->url?>" size="50" /></div>
				</div>
				<div class="line">
					<label>图片</label> 
					<div class="field">
						<input type="hidden" id="cover_image_id<?=$i?>" name="cover_image_id" value="<?=$focusSmall[$i]->cover_image_id?>" />
						<input type="hidden" id="cover_image<?=$i?>" name="cover_image" value="<?=$focusSmall[$i]->cover_image?>" />
						<div id="ASUploaderPlaceHolder<?=$i?>" style="background:url(/assets/ASUploader/plus.gif);width:18px;height:18px;"></div>
						<div id="cover_image_preview<?=$i?>"><?php if ($focusSmall[$i]->cover_image){?><img src="<?=$focusSmall[$i]->cover_image?>" /><?php }?></div>
					</div>
				</div>
				<div class="line">
					<label>发布日期</label> <div class="field"><input type="text" id="create_time<?=$i?>" name="create_time" class="create_time" value="<?=date('Y-m-d', $focusBig->create_time)?>" size="50" /></div>
				<div class="line">
					<label></label> 
					<div class="field"><input type="submit" value="保存" /></div>
				</div>
				</div>
			</fieldset>
			</form>
		</div>
		<?php }?>

	</div>
	<!--end centercontent-->
</div>

</div>
<!--end bodywrapper-->


<?php
$vt->preInc('http://libs.baidu.com/jqueryui/1.10.4/jquery-ui.min.js');
$vt->preInc('/assets/jqueryui/js/jquery-ui-timepicker.js');
$vt->preInc('/assets/ASUploader/ASUploader.js');
$vt->preload('indexfocus', 'js', true);
?>

<?php include dirname(__DIR__).'/footer.html.php'; ?>
