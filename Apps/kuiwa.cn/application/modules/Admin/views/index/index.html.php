<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper  clearfix">
		<!-- notification announcement -->
		<div class="noticebar announcement">
			<a class="close"></a>
			<h3>Hello World</h3>
			<p>欢迎使用后台管理系统.</p>
		</div>

		<!--cols two left content-->
		<div class="two-third">
			<div class="contenttitle2 no-mgt">
				<h4>服务器概览</h4>
			</div>
			<div class="mgb20">
				<table class="stdtable overviewtable" cellspacing="0"
					cellpadding="0" border="0">
					<colgroup>
						<col class="odd" width="25%" align="right"></col>
						<col class="even" width="25%"></col>
						<col class="odd" width="25%" align="right"></col>
						<col class="even" width="25%"></col>
					</colgroup>

					<tbody>
						<tr>
							<td align="right">服务器域名/IP地址</td>
							<td colspan="3"><?=$_SERVER['HTTP_HOST']?>/<?=$_SERVER['SERVER_ADDR']?>
							</td>
						</tr>
						<tr>
							<td align="right">服务器标识</td>
							<td colspan="3"><?=php_uname()?></td>
						</tr>
						<tr>
							<td align="right">服务器解译引擎</td>
							<td><?=$_SERVER['SERVER_SOFTWARE'];?></td>
							<td align="right">PHP版本</td>
							<td><?=PHP_VERSION?></td>
						</tr>
						<tr>
							<td align="right">程序根路径</td>
							<td><?=BASE_PATH?></td>
							<td align="right"></td>
							<td></td>
						</tr>
					</tbody>

				</table>
                
			</div>
			<div class="contenttitle2 no-mgt">
				<h4>缓存管理</h4>
			</div>
			<div class="mgb20">
				
				<table class="stdtable overviewtable" cellspacing="0" cellpadding="0" border="0">
					<colgroup>
						<col class="odd" width="25%" align="center"></col>
						<col class="even" width="25%" align="center"></col>
						<col class="odd" width="25%" align="center"></col>
						<col class="even" width="25%" align="center"></col>
					</colgroup>

					<tbody>
						<tr>
							<td onclick="clearCache('js')" class="pointer">清空JS缓存</td>
							<td onclick="clearCache('css')" class="pointer">清空CSS缓存</td>
							<td onclick="clearCache('')" class="pointer">清空</td>
							<td></td>
						</tr>
					</tbody>

				</table>
                
			</div>
            
			<div id="chartplace" style="height: 500px;"></div>
		</div>

		<!--cols one right content-->
		<div class="one-third no-mgr">
			<!--widget box-->
			<div class="widgetbox">
				<div class="title no-mgt">
					<h4>数据概览</h4>
				</div>
				<dl>
					<dt class="clearfix">
						<div class="fl">
							<a href="javascript:;" class="button"><span>会员总数</span> </a>
						</div>
						<div class="fr">
							<a href="/admin/user/index" class="button"><span>查看全部</span> </a>
						</div>
						<span class="number">20</span>
					</dt>
					<dd class="clearfix">
						<div class="one-half">
							<div class="left">
								<a class="avatar" href="#"><img src="/assets/admin/images/default/1.jpg" /> </a>
								<p class="name">
									<a href="#">324</a>
								</p>
								<p class="describe">今日登录用户数</p>
							</div>
						</div>

						<div class="one-half no-mgr">
							<div class="left">
								<a class="avatar" href="#"><img src="/assets/admin/images/default/1.jpg" /> </a>
								<p class="num">
									<span>5</span>
								</p>
								<p class="describe">今日新注册用户数</p>
							</div>
						</div>

					</dd>
					<dd class="clearfix last">
						<div class="one-half">
							<div class="left">
								<a class="avatar" href="#"><img src="/assets/admin/images/default/1.jpg" /> </a>
								<p class="name">
									<a href="#">23423</a>
								</p>
								<p class="describe">主题总数</p>
							</div>
						</div>

						<div class="one-half no-mgr">
							<div class="left">
								<a class="avatar" href="#"><img src="/assets/admin/images/default/1.jpg" /> </a>
								<p class="name">
									<a href="#">23423</a>
								</p>
								<p class="describe">帖子总数</p>
							</div>
						</div>

					</dd>
				</dl>
			</div>
			<!--widget box-->
		</div>


	</div>

</div>
<!--end centercontent-->

</div>
<!--end bodywrapper-->

<script type="text/javascript">
function clearCache(type)
{
	var url = '/admin/index/clearCache/type/'+type;
	$.getJSON(url, function(response){
		if (response.success)
		{
			alert('清空完成！');
		} else {
			alert('清空失败！');
		}
	});
}
</script>

<?php include dirname(__DIR__).'/footer.html.php'; ?>