<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
		
		<div id="detail-box" class="centerlist">
			<table class="stdtable overviewtable inherittdtable" cellspacing="0" cellpadding="0" border="0">
				<tbody>
					<tr>
						<td class="odd">About Us</td>
						<td class="odd">Links</td>
						<td class="odd">About Us</td>
					</tr>
					<tr>
						<td>
						<form id="aboutusForm1" action="#" method="post" class="form-horizontal">
							<input type="hidden" name="data_type" value="1" />
							<input type="hidden" name="fragment" value="1" />
							<textarea id="aboutus" name="content" style="width: 98%; height: 600px;"><?=$aboutUs?></textarea>
						</form>
						</td>
						<td>
						<form id="linksForm1" action="#" method="post" class="form-horizontal">
							<input type="hidden" name="data_type" value="1" />
							<input type="hidden" name="fragment" value="1" />
							<textarea id="links" name="content" style="width: 98%; height: 600px;"><?=$links?></textarea>
						</form>
						</td>
						<td>
						<form id="aboutForm2" action="#" method="post" class="form-horizontal">
							<input type="hidden" name="data_type" value="1" />
							<input type="hidden" name="fragment" value="1" />
							<textarea id="friendlink" name="content" style="width: 98%; height: 600px;"><?=$aboutUs?></textarea>
						</form>
						</td>
					</tr>
					<tr>
						<td style="text-align:center">
							<input type="button" value="保存" onclick="$('#aboutusForm1').submit()" />
							<input type="button" value="重置" onclick="$('#aboutusForm1')[0].reset()" />
						</td>
						<td style="text-align:center">
							<input type="button" value="保存" onclick="$('#linksForm1').submit()" />
							<input type="button" value="重置" onclick="$('#linksForm1')[0].reset()" />
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
$vt->preload('fragment', 'js', true);
?>

<?php include dirname(__DIR__).'/footer.html.php'; ?>