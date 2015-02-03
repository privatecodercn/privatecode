<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">

		<!--cols two left content-->
		<div class="centerlist">
			<div class="contenttitle2 no-mgt">
				<h4>分类列表</h4>
			</div>
			<table class="stdtable overviewtable" cellspacing="0" cellpadding="0" border="0">
				<colgroup>
					<col class="even"></col>
					<col class="even"></col>
					<col class="even"></col>
					<col class="even"></col>
				</colgroup>
				<thead>
					<tr>
						<th class="odd">ID</th>
						<th class="odd">类型</th>
						<th class="odd">名称</th>
						<th class="odd">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($list as $k=>$row) { ?>
					<tr<?php if (($k%2)==1) {echo ' bgcolor="#EFEFEF"';}?>>
						<td><?=$row->id?></td>
						<td><?=$type[$row->type]?></td>
						<td><?=$row->name?></td>
						<td>
							<a href="/admin/category/detail/id/<?=$row->id?>">编辑</a>
							<a href="javascript:delRow('/admin/category/delete/id/<?=$row->id?>');">删除</a>
						</td>
					</tr>
					<?php } ?>
					<?php if (Page::$total > 1) {?>
					<tr><td colspan="4"><?php Page::getPageByView(Yaf_Registry::get("config")->application->viewPath.'page.html.php');?></td></tr>
					<?php }?>
				</tbody>
			</table>
		</div>

	</div>
	<!--end centercontent-->
</div>

</div>
<!--end bodywrapper-->

<?php include dirname(__DIR__).'/footer.html.php'; ?>