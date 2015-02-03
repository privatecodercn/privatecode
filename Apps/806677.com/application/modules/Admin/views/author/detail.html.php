<?php 
$preIncCss = array('http://code.jquery.com/ui/1.10.4/themes/cupertino/jquery-ui.css');
$preLoadCss = array('//timepicker');
include dirname(__DIR__).'/header.html.php';
?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		
		<div id="detail-box" class="centerlist">
			<form id="detailform" method="post">
			<input type="hidden" id="uid" name="uid" value="<?=$detail->uid?>" />
			<input type="hidden" id="editType" name="editType" value="<?=$detailType?>" />
			<table class="stdtable overviewtable inherittdtable" cellspacing="0" cellpadding="0" border="0">
				<colgroup align="right">
					<col class="odd" width="120"></col>
					<col class="even"></col>
				</colgroup>
				<tbody>
					<tr>
						<td style="text-align:right">状态</td>
						<td>
							<select id="status" name="status">
								<?php foreach ($status as $k=>$v) { ?>
								<option value="<?=$k?>"<?php if ($k==$detail->status) {echo ' selected="selected"';}?>><?=$v?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">昵称</td>
						<td><input type="text" id="nickname" name="nickname" value="<?=$detail->nickname?>" placeholder="请输入昵称" size="45" /></td>
					</tr>
					<tr>
						<td style="text-align:right">真实姓名</td>
						<td><input type="text" id="realname" name="realname" value="<?=$detail->realname?>" size="45" /></td>
					</tr>
					<tr>
						<td style="text-align:right">加入时间</td>
						<td><input type="text" id="regtime" name="regtime" value="<?=$detail->regtime?>" size="45" /></td>
					</tr>
					<tr>
						<td width="120" style="text-align:right;vertical-align:top">简介</td>
						<td><textarea id="content" name="content" rows="10" cols="80"><?=$detail->brief?></textarea></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="submit" value="保存" />
							<input type="reset" value="重置" />
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
$vt->preInc('/assets/jqueryui/js/jquery-ui-timepicker.js');
$vt->preload('author', 'js', true);
?>

<?php include dirname(__DIR__).'/footer.html.php'; ?>