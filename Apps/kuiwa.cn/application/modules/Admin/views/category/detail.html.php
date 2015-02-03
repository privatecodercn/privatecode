<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		
		<div id="detail-box" class="centerlist">
			<form enctype="multipart/form-data" id="detailform" method="post" action="">
			<input type="hidden" id="isNew" name="isNew" value="<?=($detail->id>0)?1:0?>" />
			<table class="stdtable overviewtable inherittdtable" cellspacing="0" cellpadding="0" border="0">
				<colgroup align="right">
					<col class="odd" width="120"></col>
					<col class="even"></col>
				</colgroup>
				<tbody>
					<tr>
						<td style="text-align:right">类型</td>
						<td>
							<select id="type" name="type">
								<?php foreach ($type as $k=>$v) { ?>
								<option value="<?=$k?>"<?php if ($k==$detail->type) {echo ' selected="selected"';}?>><?=$v?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">分类ID</td>
						<td><input type="text" id="id" name="id" value="<?=$detail->id?>" placeholder="请输入分类ID,新添加分类可不填写" size="10" /></td>
					</tr>
					<tr>
						<td style="text-align:right">名称</td>
						<td><input type="text" id="name" name="name" value="<?=$detail->name?>" placeholder="请输入分类名称" size="100" /></td>
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
$vt->preInc('http://libs.baidu.com/jqueryui/1.10.4/jquery-ui.min.js');
$vt->preload('category', 'js', true);
?>

<?php include dirname(__DIR__).'/footer.html.php'; ?>