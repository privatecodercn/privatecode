<?php 
$preIncCss = array('http://code.jquery.com/ui/1.10.4/themes/cupertino/jquery-ui.css');
$preLoadCss = array('//timepicker');
include dirname(__DIR__).'/header.html.php';
?>
<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		<form method="POST" >
    	<div class="head-buttons">
            <div class="button"><input type="button" id="createNew" value="新增" /></div>
            <div class="button"><input type="submit" value="保存" /></div>
        </div>
		<?php foreach ($list as $i=>$item) {?>
		<div id="newsbox<?=$i?>" class="centerlist">
			<fieldset>
			<legend>首页新闻公告</legend>
				<div class="line">
					<label>标题</label> <div class="field"><input type="text" id="title<?=$i?>" name="titles[<?=$i?>]" value="<?=$list[$i]->title?>" size="50" /></div>
				</div>
				<div class="line">
					<label>链接</label> <div class="field"><input type="text" id="url<?=$i?>" name="urls[<?=$i?>]" value="<?=$list[$i]->url?>" size="50" /></div>
				</div>
			</fieldset>
		</div>
		<?php } ?>
		</form>

	</div>
	<!--end centercontent-->
</div>

</div>
<!--end bodywrapper-->
<script type="text/javascript">
var maxI = <?=count($list)-1?>;
</script>

<?php
$vt->preInc('http://libs.baidu.com/jqueryui/1.10.4/jquery-ui.min.js');
$vt->preInc('/assets/jqueryui/js/jquery-ui-timepicker.js');
$vt->preInc('/assets/ASUploader/ASUploader.js');
$vt->preload('indexnews', 'js', true);
?>

<?php include dirname(__DIR__).'/footer.html.php'; ?>
