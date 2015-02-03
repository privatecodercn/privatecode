<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">

		<!--cols two left content-->
		<div class="centerlist">
			<div class="contenttitle2 no-mgt">
				<h4>作者列表</h4>
			</div>
			<table class="stdtable overviewtable" cellspacing="0" cellpadding="0" border="0">
				<colgroup>
					<col class="even"></col>
					<col class="even"></col>
					<col class="even"></col>
					<col class="even"></col>
					<col class="even"></col>
					<col class="even"></col>
				</colgroup>
				<thead>
					<tr>
						<th class="odd">ID</th>
						<th class="odd">昵称</th>
						<th class="odd">真实姓名</th>
						<th class="odd">创建日期</th>
						<th class="odd">状态</th>
						<th class="odd">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($list as $k=>$row) { ?>
					<tr<?php if (($k%2)==1) {echo ' bgcolor="#EFEFEF"';}?>>
						<td><?=$row->uid?></td>
						<td class="odd"><?=$row->nickname?></td>
						<td><?=$row->realname?></td>
						<td class="odd"><?=date('Y-m-d H:i:s', $row->regtime)?></td>
						<td class="odd"><?=$status[$row->status]?></td>
						<td>
							<a href="/admin/author/detail/uid/<?=$row->uid?>">编辑</a>
							<a href="javascript:delAuthor(<?=$row->uid?>)">删除</a>
						</td>
					</tr>
					<?php } ?>
					<?php if (Page::$total > 1) {?>
					<tr><td colspan="6"><?php Page::getPageByView(Yaf_Registry::get("config")->application->viewPath.'page.html.php');?></td></tr>
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
function delAuthor(uid)
{
	var url = '/admin/author/delete/uid/'+uid;
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