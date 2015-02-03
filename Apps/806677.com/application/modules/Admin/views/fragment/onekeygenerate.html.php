<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		
		<div id="detail-box" class="centerlist">
			<table class="stdtable overviewtable inherittdtable" cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td style="text-align:center">
							<input type="button" value="生成热门视频碎片" onclick="generateHotVides()" />
						</td>
						<td style="text-align:center">
							<input type="button" value="生成视频排行碎片" onclick="generateViewsRankVides()" />
						</td>
						<td style="text-align:center">
							
						</td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>
	<!--end centercontent-->
</div>

</div>
<!--end bodywrapper-->

<script type="text/javascript">
function generateHotVides()
{
	$.getJSON('/admin/fragment/save/sign/hotVideo/saveDb/0', function(response){
		if (response.success)
		{
			alert('操作成功！');
		} else {
			alert('操作失败！');
		}
	});
}

function generateViewsRankVides()
{
	$.getJSON('/admin/fragment/save/sign/viewsRankVideo/saveDb/0', function(response){
		if (response.success)
		{
			alert('操作成功！');
		} else {
			alert('操作失败！');
		}
	});
}
</script>

<?php
$vt->preload('fragment', 'js', true);
?>

<?php include dirname(__DIR__).'/footer.html.php'; ?>