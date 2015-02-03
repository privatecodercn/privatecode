<?php
$vt = new ViewTools();
$vt->viewPath = $this->getScriptPath();
if (isset($preIncCss)) foreach ($preIncCss as $v)
{
	$vt->preInc($v);
}
$vt->preload('default', 'css');
$vt->preload('//page', 'css');
if (isset($preLoadCss)) foreach ($preLoadCss as $v)
{
	$vt->preload($v, 'css');
}
$vt->preload('common', 'js');
$vt->preInc('http://libs.baidu.com/jqueryui/1.10.4/jquery-ui.min.js');
$vt->preInc('http://code.jquery.com/ui/1.10.4/themes/cupertino/jquery-ui.css');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理后台</title>
<meta name="description" content="">
<meta name="viewport" content="width=device-width">
<?=$vt->inc('css')?>
<?=$vt->loadCss()?>

</head>
<body>
	<div id="modifyPwdBox" style="display:none;">
		<form id="commonModifyPwd" method="POST" >
		<fieldset>
			<div class="line">
				<label>旧密码</label> <div class="field"><input type="password" id="common_oldpassword" name="oldpassword" value="" size="50" /></div>
			</div>
			<div class="line">
				<label>新密码</label> <div class="field"><input type="password" id="common_newpassword" name="newpassword" value="" size="50" /></div>
			</div>
			<div class="line">
				<label>确认新密码</label> <div class="field"><input type="password" id="common_newpassword2" name="newpassword2" value="" size="50" /></div>
			</div>
		</fieldset>
		</form>
	</div>
	<div class="bodywrapper">

		<!--begin topheader-->
		<div class="topheader  clearfix">
			<div class="left">
				<h1 class="logo">
					DOTA<span>视频</span>
				</h1>
				<span class="slogan">Version 1.0</span>
			</div>

			<div class="right">
				<a class="userinfo"> <img alt="" src="/assets/admin/images/thumbs/avatar.png"> <span><?=$admin_user->nickname?>
				</span> <em></em>
				</a>
				<div class="userinfodrop">
					<em></em>
					<div class="avatar"></div>
					<div class="userdata">
						<h4>
							<?=$admin_user->nickname?>
						</h4>
						<div class="email"><?=$admin_user->email?></div>
						<dl>
							<dd>
								<a href="javascript:handler('profile');">帐号设置</a>
							</dd>
							<dd>
								<a href="javascript:handler('modifypwd');">修改密码</a>
							</dd>
							<dd>
								<a href="javascript:handler('help');">帮助</a>
							</dd>
							<dd>
								<a href="javascript:handler('logout');">退出</a>
							</dd>
						</dl>
					</div>
				</div>
			</div>
		</div>
		<!--end topheader-->

		<!--begin header-->
		<div class="header clearfix">
			<ul id="headermenu" class="headermenu">
				<?php foreach ($cfg['admin_menus'] as $key => $value) { ?>
				<li <?php if ($key==$_menu_block) { echo ' class="current"'; }?>><a
					href="javascript:;" indexId="<?=$key?>"> <span
						class="icon <?=$value['class']?>"></span> <span><?=$value['name']?>
					</span>
				</a>
				</li>
				<?php } ?>
			</ul>
			<div class="headerwidget">
				<div class="costs">

					<div class="todaycost">
						<h4>今日PV</h4>
						<h2>23</h2>
					</div>

					<div class="remainsum">
						<h4>距离目标流量</h4>
						<h2>PV:-534</h2>
					</div>

				</div>
			</div>
		</div>
		<!--end header-->


		<div class="mainwrapper">

			<?php foreach ($cfg['admin_menus'] as $sign => $v) { 
				$block=$v['block'];?>
			<!--begin vertical navigate-->
			<div id="headersubmenu_<?=$sign?>" class="vernav iconmenu<?php if ($sign!=$_menu_block) { echo ' hide'; }?>">
				<dl>
					<?php if ($sign=='main'){ ?>
					<dd ><a class="menu2" href="<?=$site->url?>" target="_blank">网站首页</a></dd>
					<?php } ?>
					<?php foreach ($block as $item) {?>

					<dd <?php if ($item['href']==$admin_now_menu) { ?> class="current"
					<?php } ?>>
						<?php if (empty($item['default'])) { ?>
						<a class="menu overview" href="<?php if (empty($item['sub_id'])) {echo '/admin';}?><?=$item['href']?>"><?=$item['name']?>
						</a>
						<?php } else { ?>
						<a class="menu" href="<?php if (empty($item['sub_id'])) {echo '/admin';}?><?=$item['href']?>"><?=$item['name']?></a>
						<?php } ?>
						<?php if (!empty($item['sub'])) { ?>
						<span class="arrow-down"></span>
						<dl id="<?=$item['sub_id']?>"<?php if (!$item['expand']){ ?>style="display:none;"<?php }?>>
							<?php foreach ($item['sub'] as $v) {
							if (0 === strpos($v['href'], 'http://'))
							{
								$href = $v['href'];
							} else {
								$href = '/admin'.$v['href'];
							}
							?>
							<dd>
								<a href="<?=$href?>"><?=$v['name']?></a>
							</dd>
							<?php } ?>
						</dl>
						<?php } ?>
					</dd>

					<?php } ?>
				</dl>
			</div>
			<!--end vertical navigate-->
			<?php }?>
			
</div>