<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		
		<div id="detail-box" class="centerlist">
			<table class="stdtable overviewtable inherittdtable" cellspacing="0" cellpadding="0" border="0">
				<colgroup align="right">
					<col class="odd"></col>
					<col class="even"></col>
					<col class="odd"></col>
					<col class="even"></col>
					<col class="odd"></col>
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th>封面图片</th>
						<th>专辑标题</th>
						<th>视频浏览量</th>
						<th>创建时间</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($list as $row) {?>
					<tr>
						<td><?=$row->id?></td>
						<td><img src="<?=$row->cover_image?>" width="100" /></td>
						<td><?=$row->title?></td>
						<td><?=$row->views?></td>
						<td><?=date('Y-m-d H:i:s', $row->create_time)?></td>
						<td>
							<a href="javascript:delVideo(<?=$row->id?>)">删除</a>
						</td>
					</tr>
				<?php } ?>
							
					<?php if (Page::$total > 1) {?>
					<tr>
						<td colspan="5"><?php Page::getPageByView(Yaf_Registry::get("config")->application->viewPath.'/page.html.php');?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>

	</div>
	<!--end centercontent-->
</div>

</div>
<!--end bodywrapper-->

<style>
.ui-autocomplete {
	max-height: 300px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: hidden;
}
* html .ui-autocomplete {
	height: 300px;
}
</style>

<?php
$vt->preInc('http://code.jquery.com/ui/1.10.4/themes/flick/jquery-ui.css');
?>
<script type="text/javascript">
function deleteAlbum(id)
{
	$.getJSON('/admin/album/delete/id/'+id, function(response){
		if (response.success)
		{
			window.location.href="/admin/album/index";
		} else {
			alert('操作失败');
		}
	});
}
</script>

<?php include dirname(__DIR__).'/footer.html.php'; ?>
