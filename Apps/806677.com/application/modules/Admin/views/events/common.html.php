<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">

		<!--cols two left content-->
		<div class="centerlist">
			<div class="contenttitle2 no-mgt">
				<h4>总赛事列表</h4>
			</div>
			<table class="stdtable overviewtable" cellspacing="0" cellpadding="0" border="0">
				<thead>
					<tr>
						<th class="odd" style="text-align:left;">
						<a href="javascript:void();">新建总赛事</a>
						</th>
					</tr>
				</thead>
			</table>
			<table class="stdtable overviewtable" cellspacing="0" cellpadding="0" border="0">
				<colgroup>
					<col class="even"></col>
					<col class="even"></col>
					<col class="even"></col>
					<col class="even"></col>
					<col class="even"></col>
				</colgroup>
				<thead>
					<tr>
						<th class="odd">ID</th>
						<th class="odd">名称</th>
						<th class="odd">简称</th>
						<th class="odd">开始日期</th>
						<th class="odd">结束日期</th>
						<th class="odd">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($list as $k=>$row) { ?>
					<tr<?php if (($k%2)==1) {echo ' bgcolor="#EFEFEF"';}?>>
						<td><?=$row->id?></td>
						<td class="odd"><?=$row->name?></td>
						<td><?=$row->short_name?></td>
						<td class="odd"><?=date('Y-m-d H:i:s', $row->start_time)?></td>
						<td><?=date('Y-m-d H:i:s', $row->end_time)?></td>
						<td>
							<a href="javascript:edit(<?=$row->id?>)">编辑</a>
							<a href="javascript:del(<?=$row->id?>)">删除</a>
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
function del(id)
{
	var url = '/admin/events/deleteCommon/id/'+id;
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