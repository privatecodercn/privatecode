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
					<?php outputBoardList($this, $boardList);?>
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

<?php
function outputBoardList($view, $boardList, $sub=0)
{
	foreach ($boardList as $id=>$row)
	{
		if ($sub)
		{
			$subPreStr = '├'.str_repeat('一一一', $sub);
		} else {
			$subPreStr = '';
		}
		$row['managers'] = formatManager($row['managers'], $row['id']);
		echo <<<html
	<tr id="boardrow{$id}" sub="{$sub}" class="subboard{$row['pid']}">
		<td><input type="hidden" name="id[{$id}]" value="{$id}" /><input type="hidden" id="pid{$id}" name="pid[{$row['pid']}]" value="{$row['pid']}" /></td>
		<td><input name="order[{$id}]" type="text" value="{$row['orderid']}" size="2"></td>
		<td>{$subPreStr}<input name="name[{$id}]" type="text" value="{$row['name']}" size="30"> <a href="javascript:addSubBoard({$id});">添加子版块</a></td>
		<td>{$row['managers']}</td>
		<td>
			<a href="/admin/bbs/board/detail?id={$id}">编辑</a>
			<a href="javascript:deleteBoard({$id});">删除</a>
		</td>
	</tr>
html;
		if ($row['sub'])
		{
			outputBoardList($view, $row['sub'], $sub+1);
		}
	}
}
function formatManager($managers, $board_id)
{
	$str = '';
	if ($managers)
	{
		foreach ($managers as $id=>$nickname)
		{
			$str .= $nickname.'&nbsp;';
		}
	}
	if (!$str)
	{
		$str = '<a href="/admin/bbs/board/managerList?board_id='.$board_id.'">添加</a>';
	}
	return $str;
}

$vt->preload('board', 'js');
?>

<?php include dirname(__DIR__).'/footer.html.php'; ?>
