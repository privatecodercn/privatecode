<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		
		<div id="detail-box" class="centerlist">
			<table class="stdtable overviewtable" cellspacing="0" cellpadding="0" border="0">
				<colgroup align="right">
					<col class="odd"></col>
					<col class="even"></col>
					<col class="odd"></col>
					<col class="even"></col>
					<col class="odd"></col>
				</colgroup>
				<thead>
					<tr>
						<th>ID</th>
						<th>标题</th>
						<th>视频浏览量</th>
						<th>创建时间</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($list as $row) {?>
					<tr>
						<td><?=$row->id?></td>
						<td><?=$row->title?></td>
						<td><?=$row->views?></td>
						<td><?=date('Y-m-d H:i:s', $row->create_time)?></td>
						<td>
							<a href="/video/x_<?php echo String::idCrypt($row->id);?>.html" target="_blank">查看</a>
							<a href="/admin/video/detail/id/<?=$row->id?>">编辑</a>
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

<script type="text/javascript">
function delVideo(id)
{
	var url = '/admin/video/delete/id/'+id;
	$.getJSON(url, function(response){
		if (response.success)
		{
			window.location = window.location;
		} else {
			alert('删除失败!');
		}
	});
}
</script>

<?php include dirname(__DIR__).'/footer.html.php'; ?>
