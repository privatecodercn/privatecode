
<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		
		<div id="detail-box" class="centerlist">
			<table class="stdtable overviewtable inherittdtable" cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td class="odd">首页走马灯</td>
						<td class="odd">About Us(首页）</td>
						<td class="odd">About Us</td>
					</tr>
					<tr>
						<td>
						<form id="carouselForm" action="#" method="post" class="form-horizontal">
							<input type="hidden" name="data_type" value="2" />
							<input type="hidden" name="fragment" value="1" />
							<textarea id="carouselinfo" name="content" style="width: 98%; height: 600px;"><?=$carouselInfo?></textarea>
						</form>
						</td>
						<td>
						<form id="aboutForm1" action="#" method="post" class="form-horizontal">
							<input type="hidden" name="data_type" value="1" />
							<input type="hidden" name="fragment" value="1" />
							<textarea id="friendlink" name="content" style="width: 98%; height: 600px;"><?=$indexAboutInfo?></textarea>
						</form>
						</td>
						<td>
						<form id="aboutForm2" action="#" method="post" class="form-horizontal">
							<input type="hidden" name="data_type" value="1" />
							<input type="hidden" name="fragment" value="1" />
							<textarea id="friendlink" name="content" style="width: 98%; height: 600px;"><?=$aboutInfo?></textarea>
						</form>
						</td>
					</tr>
					<tr>
						<td style="text-align:center">
							<input type="button" value="保存" onclick="$('#carouselForm').submit()" />
							<input type="button" value="重置" onclick="$('#carouselForm')[0].reset()" />
						</td>
						<td style="text-align:center">
							<input type="button" value="保存" onclick="$('#aboutForm1').submit()" />
							<input type="button" value="重置" onclick="$('#aboutForm1')[0].reset()" />
						</td>
						<td style="text-align:center">
							<input type="button" value="保存" onclick="$('#aboutForm2').submit()" />
							<input type="button" value="重置" onclick="$('#aboutForm2')[0].reset()" />
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

<?php 
$__inCode = <<<code
<script	type="text/javascript">
$(function(){
	// 表单提交保存
	$('#carouselForm').submit(function(){
		$.post('/admin/saveInfo/sign/carousel', $(this).serialize(), function(response){
			if (response.success)
			{
				alert('操作成功！');
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
	$('#aboutForm1').submit(function(){
		$.post('/admin/saveInfo/sign/indexaboutus', $(this).serialize(), function(response){
			if (response.success)
			{
				alert('操作成功！');
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
	$('#aboutForm2').submit(function(){
		$.post('/admin/saveInfo/sign/aboutus', $(this).serialize(), function(response){
			if (response.success)
			{
				alert('操作成功！');
			} else {
				alert('操作失败');
			}
		}, 'json');
		return false;
	});
});
</script>
code;
?>