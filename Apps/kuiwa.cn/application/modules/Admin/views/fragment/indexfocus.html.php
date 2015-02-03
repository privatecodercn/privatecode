<?php 
$preIncCss = array('http://code.jquery.com/ui/1.10.4/themes/cupertino/jquery-ui.css');
$preLoadCss = array('//timepicker');
include dirname(__DIR__).'/header.html.php';
?>
<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		<form method="POST" >
		<?php
		foreach ($focus as $i => $item) {
			
		?>
		<div id="detail-box" class="centerlist">
			<fieldset>
			<legend>首页焦点图</legend>
				<div class="line">
					<label>标题</label> <div class="field"><input type="text" name="title[]" value="<?=$item->title?>" size="50" /></div>
				</div>
				<div class="line">
					<label>链接</label> <div class="field"><input type="text" name="url[]" value="<?=$item->url?>" size="50" /></div>
				</div>
				<div class="line">
					<label>图片</label> 
					<div class="field">
						<input type="hidden" name="cover_image_id[]" value="<?=$item->cover_image_id?>" />
						<input type="hidden" name="cover_image[]" value="<?=$item->cover_image?>" />
						<div id="ASUploaderPlaceHolder<?=$i?>" style="background:url(/assets/ASUploader/plus.gif);width:18px;height:18px;"></div>
						<div id="cover_image_preview<?=$i?>"><?php if ($item->cover_image){?><img src="<?=$item->cover_image?>" /><?php }?></div>
					</div>
				</div>
				<div class="line">
					<label>发布日期</label> <div class="field"><input type="text" name="create_time[]" class="create_time" value="<?=date('Y-m-d', $item->create_time)?>" size="50" /></div>
				<div class="line">
					<label></label> 
					<div class="field"><input type="submit" value="保存" /></div>
				</div>
				</div>
			</fieldset>
		</div>
		<?php }?>
		</form>

	</div>
	<!--end centercontent-->
</div>

</div>
<!--end bodywrapper-->

<script type="text/javascript">
var maxUploader = <?=count($focus)?>;
</script>


<?php
$vt->preInc('http://libs.baidu.com/jqueryui/1.10.4/jquery-ui.min.js');
$vt->preInc('/assets/jqueryui/js/jquery-ui-timepicker.js');
$vt->preInc('/assets/ASUploader/ASUploader.js');
$vt->preload('indexfocus', 'js', true);
?>

<?php include dirname(__DIR__).'/footer.html.php'; ?>
