<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		
		<div id="detail-box" class="centerlist">
			<table class="stdtable overviewtable inherittdtable" cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td class="odd">宾驰网络</td>
						<td class="odd">房产服务号</td>
						<td class="odd">房产订阅号</td>
					</tr>
					<tr>
						<td>
						<form id="Form1" action="#" method="post" class="form-horizontal">
							<input type="hidden" name="app_name" value="binchi" />
							<textarea id="binchi" name="content" style="width: 98%; height: 600px;"><?=$binchiMenu?></textarea>
						</form>
						</td>
						<td>
						<form id="Form2" action="#" method="post" class="form-horizontal">
							<input type="hidden" name="app_name" value="fc" />
							<textarea id="fc188_com" name="content" style="width: 98%; height: 600px;"><?=$fc188Menu?></textarea>
						</form>
						</td>
						<td>
						<form id="Form3" action="#" method="post" class="form-horizontal">
							<input type="hidden" name="app_name" value="fcinfo" />
							<textarea id="fc188-com" name="content" style="width: 98%; height: 600px;"></textarea>
						</form>
						</td>
					</tr>
					<tr>
						<td style="text-align:center">
							<input type="button" value="保存" onclick="$('#Form1').submit()" />
							<input type="button" value="重置" onclick="$('#Form1')[0].reset()" />
						</td>
						<td style="text-align:center">
							<input type="button" value="保存" onclick="$('#Form2').submit()" />
							<input type="button" value="重置" onclick="$('#Form2')[0].reset()" />
						</td>
						<td style="text-align:center">
							<input type="button" value="保存" onclick="$('#Form3').submit()" />
							<input type="button" value="重置" onclick="$('#Form3')[0].reset()" />
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

<?php include dirname(__DIR__).'/footer.html.php'; ?>
<script type="text/javascript">
$(function(){
	$('form').submit(function(){
		var data = $(this).serialize();
		$.post('/admin/weixinMenu/release', data, function(response) {
			if (response.success)
			{
				alert('发布成功！');
			} else{
				alert(response.message);
			}
		}, 'json');
		return false;
	});
		
});
</script>