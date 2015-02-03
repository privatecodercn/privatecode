<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">

		<!--cols two left content-->
		<div class="centerlist">
			<div class="contenttitle2 no-mgt">
				<h4>文章列表</h4>
			</div>
			<table class="stdtable overviewtable" cellspacing="0" cellpadding="0" border="0">
				<colgroup>
					<col class="even" width="5%"></col>
					<col class="even" width="30%"></col>
					<col class="even" width="22%"></col>
					<col class="even" width="8%"></col>
					<col class="even" width="5%"></col>
					<col class="even" width="10%"></col>
					<col class="even" width="20%"></col>
				</colgroup>
				<thead>
					<tr>
						<th class="odd">ID</th>
						<th class="odd">标题</th>
						<th class="odd">标签</th>
						<th class="odd">编辑</th>
						<th class="odd">状态</th>
						<th class="odd">创建时间</th>
						<th class="odd">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($list as $k=>$row) { ?>
					<tr<?php if (($k%2)==1) {echo ' bgcolor="#EFEFEF"';}?>>
						<td><?=$row->id?></td>
						<td><?=$row->title?></td>
						<td><?=$row->tags?></td>
						<td><?=$row->editor?></td>
						<td><?=$status[$row->status]?></td>
						<td><?=date('Y-m-d H:i:s', $row->create_time)?></td>
						<td>
							<a href="/admin/article/detail/id/<?=$row->id?>">编辑</a>
							<a href="javascript:delArticle(<?=$row->id?>)">删除</a>
						</td>
					</tr>
					<?php } ?>
					<?php if (Page::$total > 1) {?>
					<tr><td colspan="7"><?php Page::getPageByView(Yaf_Registry::get("config")->application->viewPath.'page.html.php');?></td></tr>
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
function delArticle(id)
{
	var url = '/admin/article/delete/id/'+id;
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