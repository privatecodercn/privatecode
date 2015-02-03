<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		
		<div id="detail-box" class="centerlist">
			<form enctype="multipart/form-data" id="boardform" method="post" action="">
			<table class="stdtable overviewtable inherittdtable" cellspacing="0" cellpadding="0" border="0">
				<colgroup align="right">
					<col class="odd" width="50"></col>
					<col class="even" width="100"></col>
					<col class="odd"></col>
					<col class="even" width="200"></col>
					<col class="odd" width="150"></col>
				</colgroup>
				<thead>
					<tr>
						<th></th>
						<th>显示顺序</th>
						<th>版块名称</th>
						<th>版主</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<tr id="addTopBoardRow">
						<td colspan="5"><a href="javascript:addTopBoard();">添加新分区</a></td>
					</tr>
					<tr>
						<td colspan="5">&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="submit" value="提交" />
						</td>
					</tr>
				</tbody>
			</table>
			</form>
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
$vt->preInc('http://libs.baidu.com/jqueryui/1.10.4/jquery-ui.min.js');
$vt->preload('topic', 'js');
?>

<?php include dirname(__DIR__).'/footer.html.php'; ?>
