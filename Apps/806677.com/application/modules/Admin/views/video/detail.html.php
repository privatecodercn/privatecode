<?php 
$preIncCss = array('http://code.jquery.com/ui/1.10.4/themes/cupertino/jquery-ui.css');
$preLoadCss = array('//timepicker');
include dirname(__DIR__).'/header.html.php';
?>

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
						<td style="text-align:right">标题</td>
						<td><input type="text" id="title" name="title" value="<?=$detail->title?>" placeholder="请输入标题" size="100" /></td>
					</tr>
					<tr>
						<td style="text-align:right">视频类型</td>
						<td>
							<select id="type" name="type">
								<?php $type = Local_Cfg::getVideoType();
								foreach ($type as $k=>$v) { ?>
								<option value="<?=$k?>"<?php if ($k==$detail->type) {echo ' selected="selected"';}?>><?=$v?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">播放方式</td>
						<td>
							<select id="play_style" name="play_style">
								<option value="1"<?php if ($detail->play_style==1) {?>selected="selected"<?php }?>>嵌入</option>
								<option value="2"<?php if ($detail->play_style==2) {?>selected="selected"<?php }?>>跳转播放页</option>
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">清晰度</td>
						<td>
							<select id="definition" name="definition">
								<?php $definition = Local_Cfg::getDefinition();
								foreach ($definition as $k=>$v) { ?>
								<option value="<?=$k?>"<?php if ($k==$detail->definition) {echo ' selected="selected"';}?>><?=$v?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
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
						<td style="text-align:right">视频来源</td>
						<td>
							<select id="from" name="from">
								<?php foreach ($from as $k=>$v) { ?>
								<option value="<?=$k?>"<?php if ($k==$detail->from) {echo ' selected="selected"';}?>><?=$v?></option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">专辑</td>
						<td>
                        	<input type="hidden" id="album_id" name="album_id" value="" placeholder="" />
                        	<input type="text" id="album" name="album" value="" placeholder="" size="40" />
                        </td>
					</tr>
					<tr>
						<td style="text-align:right">标签</td>
						<td><input type="text" id="tags" name="tags" value="<?=$detail->tags?>" placeholder="请输入标签" size="100" /></td>
					</tr>
					<tr>
						<td style="text-align:right">作者</td>
						<td>
                        	<input type="hidden" id="author_uid" name="author_uid" value="<?=$detail->author_uid?>" placeholder="" />
                        	<input type="text" id="author_nickname" name="author" value="<?=$detail->author?>" placeholder="输入昵称查找" size="40" />
						</td>
					</tr>
					<tr>
						<td style="text-align:right">图片</td>
						<td>
							<input type="text" id="cover_image_id" name="cover_image_id" value="<?=$detail->cover_image_id?>" />
							<input type="text" id="cover_image" name="cover_image" value="<?=$detail->cover_image?>" size="120" />
							<div id="ASUploaderPlaceHolder" style="background:url(/assets/ASUploader/plus.gif);width:18px;height:18px;"></div>
                            <div id="cover_image_preview"><?php if ($detail->cover_image){?><img src="<?=$detail->cover_image?>" /><?php }?></div>
						</td>
					</tr>
					<tr>
						<td style="text-align:right">评分</td>
						<td><input type="text" id="score" name="score" value="<?=$detail->score?>" size="15" /></td>
					</tr>
					<tr>
						<td style="text-align:right">查看数</td>
						<td><input type="text" id="views" name="views" value="<?=$detail->views?>" size="25" /></td>
					</tr>
					<tr>
						<td style="text-align:right">发布时间</td>
						<td><input type="text" id="create_time" name="create_time" value="<?=$detail->create_time?>" size="25" /></td>
					</tr>
					<tr>
						<td style="text-align:right">播放页地址</td>
						<td><input type="text" id="url" name="url" value="<?=$detail->url?>" size="100" /></td>
					</tr>
			  <tr>
						<td style="text-align:right">播放器代码</td>
						<td>
						<textarea id="code" name="code" cols="80" rows="8"><?=$detail->code?></textarea>
						<br />
						<div id="previewCode"></div>
						
						</td>
					</tr>
					<tr>
						<td style="text-align:right" width="120">视频简介</td>
						<td><textarea id="summary" name="summary" cols="80" rows="8"><?=$detail->summary?></textarea></td>
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
$vt->preInc('/assets/ASUploader/ASUploader.js');
$vt->preload('video', 'js', true);
?>

<?php include dirname(__DIR__).'/footer.html.php'; ?>