<?php 
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
						<td style="text-align:right">标志符</td>
						<td><input type="text" id="sign" name="sign" value="<?=$detail->sign?>" placeholder="请输入标志符" size="100" /></td>
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
						<td style="text-align:right">标题</td>
						<td><input type="text" id="title" name="title" value="<?=$detail->title?>" placeholder="请输入标题" size="100" /></td>
					</tr>
					<tr>
						<td style="text-align:right">图片</td>
						<td>
							<input type="hidden" id="cover_image_id" name="cover_image_id" value="" />
							<input type="hidden" id="cover_image" name="cover_image" value="" />
							<div id="ASUploaderPlaceHolder" style="background:url(/assets/ASUploader/plus.gif);width:18px;height:18px;"></div>
                            <div id="cover_image_preview"></div>
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
						<td style="text-align:right" width="120">专辑简介</td>
						<td><textarea id="content" name="content" cols="80" rows="8"><?=$detail->content?></textarea></td>
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
			<br />
			<table class="stdtable overviewtable inherittdtable" cellspacing="0" cellpadding="0" border="0">
				<colgroup align="right">
					<col class="odd"></col>
					<col class="even"></col>
					<col class="odd"></col>
					<col class="even"></col>
					<col class="odd"></col>
					<col class="even"></col>
				</colgroup>
				<thead>
					<tr>
						<th>视频ID</th>
						<th>顺序</th>
						<th>视频标题</th>
						<th>视频浏览量</th>
						<th>创建时间</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($videoList as $row) {?>
					<tr>
						<td><?=$row->id?></td>
						<td><input id="order_<?=$row->order_id?>" value="<?=$row->order_id?>" /></td>
						<td><?=$row->title?></td>
						<td><?=$row->views?></td>
						<td><?=date('Y-m-d H:i:s', $row->create_time)?></td>
						<td>
							<a href="/admin/album/detail/id/<?=$row->id?>">编辑</a>
							<a href="javascript:deleteAlbum('<?=$row->id?>');">删除</a>
						</td>
					</tr>
				<?php } ?>
							
					<?php if (Page::$total > 1) {?>
					<tr>
						<td colspan="5"><?php Page::getPageByView(Yaf_Registry::get("config")->application->viewPath.'/page.html.php');?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>

	</div>
	<!--end centercontent-->
</div>

</div>
<!--end bodywrapper-->

<?php
$vt->preInc('/assets/jqueryui/js/jquery-ui-timepicker.js');
$vt->preInc('/assets/ASUploader/ASUploader.js');
$vt->preload('album', 'js', true);
?>

<?php include dirname(__DIR__).'/footer.html.php'; ?>