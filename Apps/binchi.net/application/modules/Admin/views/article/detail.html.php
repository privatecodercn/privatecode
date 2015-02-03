<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		
		<div id="detail-box" class="centerlist">
			<form enctype="multipart/form-data" id="detailform" method="post" action="/admin/article/save">
			<input type="hidden" id="id" name="id" value="<?=$detail->id?>" />
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
						<td style="text-align:right">是否转载</td>
						<td>
							<select id="is_copy" name="is_copy">
								<?php foreach ($isCopy as $k=>$v) { ?>
								<option value="<?=$k?>"><?=$v?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">标签</td>
						<td><input type="text" id="tags" name="tags" value="<?=$detail->tags?>" placeholder="请输入标签" size="100" /></td>
					</tr>
					<tr>
						<td style="text-align:right">标题</td>
						<td><input type="text" id="title" name="title" value="<?=$detail->title?>" placeholder="请输入标题" size="100" /></td>
					</tr>
					<tr>
						<td style="text-align:right">图片</td>
						<td>
							<input type="hidden" id="cover_image_id" name="cover_image_id" value="<?=$detail->cover_image_id?>" />
							<input type="hidden" id="cover_image" name="cover_image" value="<?=$detail->cover_image?>" />
							<div id="ASUploaderPlaceHolder" style="background:url(/assets/ASUploader/plus.gif);width:18px;height:18px;"></div>
                            <div id="cover_image_preview"><?php if ($detail->cover_image){?><img src="<?=$detail->cover_image?>" /><?php }?></div>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">编辑</td>
						<td><input type="text" id="editor" name="editor" value="<?=$detail->editor?>" size="45" /></td>
					</tr>
					<tr>
						<td style="text-align:right">作者</td>
						<td><input type="text" id="author" name="author" value="<?=$detail->author?>" size="45" /></td>
					</tr>
					<tr>
						<td style="text-align:right">查看数</td>
						<td><input type="text" id="views" name="views" value="<?=$detail->views?>" size="45" /></td>
					</tr>
					<tr>
						<td style="text-align:right">发布时间</td>
						<td><input type="text" id="post_time" name="post_time" value="<?=date('Y-m-d H:i:s')?>" size="45" /></td>
					</tr>
					<tr>
						<td style="text-align:right" width="120">文章内容</td>
						<td><textarea id="content" name="content"><?=$detail->content?></textarea></td>
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
$vt->preInc('/assets/jqueryui/js/jquery-ui-timepicker.js');
$vt->preInc('/assets/ueditor/ueditor.config.js');
$vt->preInc('/assets/ueditor/ueditor.all.min.js');
$vt->preInc('/assets/ASUploader/ASUploader.js');
$vt->preload('article', 'js', true);
include dirname(__DIR__).'/footer.html.php';
?>