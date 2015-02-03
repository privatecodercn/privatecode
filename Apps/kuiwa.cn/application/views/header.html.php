<?php
$config = Yaf_Registry::get("config");
$vt = ViewTools::getInstance();
$vt->viewPath = $this->getScriptPath();
$vt->preload('//default', 'css', true);
$vt->preload('//common', 'js', true);
$navCurrent = isset($navCurrent) ? $navCurrent : 'nav_home';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-cn">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php if (isset($seoTitle)) {echo $seoTitle;} elseif (isset($title)) {echo $title;} else {echo $config->site->title;}?></title>
<meta name="keywords" content="<?php if (isset($seoKeywords)) {echo $seoKeywords;} else {echo $config->site->keywords;}?>">
<meta name="description" content="<?php if (isset($seoDescription)) {echo $seoDescription;} else {echo $config->site->description;}?>">
<?=$vt->load('css')?>
</head>

<body>


<div id="head">
	<div id="hd_content" class="container">
		<div id="hd_logo"><a href="/" title="<?=$config->site->name?>"><img src="/img/wxd/logo.png" alt="<?=$config->site->name?>" border="0"></a></div>
		<div id="hd_right">
		<?php if (User::isLogined()) { ?>
			<ul>
				<li>用户</li>
			</ul>
		<?php } else { ?>
			<form id="ulogin" name="ulogin" method="post" action="">
			<div>
				<span class="loginFrmTitle">用户名</span>
				<span class="loginFrmInput"><input name="username" id="username" type="text" autocomplete="off" /></span>
				<span class="loginFrmButton"><input type="checkbox" name="cookietime" value="2592000" class="cookietime" /> 自动登录</span>
				<span class="loginFrmText"><a href="/getpwd">找回密码</a></span>
			</div>
			<div>
				<span class="loginFrmTitle">密码</span>
				<span class="loginFrmInput"><input name="password" id="password" type="password" autocomplete="off" /></span>
				<span class="loginFrmButton"><button type="submit">登录</button></span>
				<span class="loginFrmText"><a href="/register">立即注册</a></span>
			</div>
			</form>
		<?php } ?>
		</div>
		<div class="clear"></div>
	</div>
</div>

<div id="head_nav" class="container">
	<script type="text/javascript">var navCurrent = '<?=$navCurrent?>';</script>
	<ul>
		<li id="nav_home"><a href="/">首页</a></li>
		<li id="nav_bbs"><a href="/bbs">葵娃社区</a></li>
		<li id="nav_by" child="quickby"><a href="/article/by">备孕</a></li>
		<li id="nav_hy" child="quickhy"><a href="/article/hy">怀孕</a></li>
		<li id="nav_newborn"><a href="/article/newborn">产后/新生儿</a></li>
		<li id="nav_baby"><a href="/article/baby">育婴</a></li>
		<li id="nav_favorite"><a href="/favorite">收藏</a></li>
		<li id="nav_rank"><a href="/rank">排行榜</a></li>
	</ul>
	<!--<a id="qmenu">快捷导航</a>-->
</div>

<ul id="quickby" class="container quicknav">
	<li><a href="">男女性备孕注意事项</a></li>
	<li><a href="">怎么提高怀孕几率的呢？</a></li>
	<li><a href="">备孕成功经验</a></li>
	<li><a href="">孕前检查项目及时间</a></li>
</ul>

<div id="scbar" class="container">
	<form id="scbar_form" method="post" autocomplete="off" onsubmit="searchFocus($('scbar_txt'))" action="" target="_blank">
		<input type="hidden" name="type" id="scbar_type_value" value="topic" />
		<div id="scbar_left"></div>
		<div id="scbar_text">
		<input type="text" name="srchtxt" id="scbar_txt" value="请输入搜索内容" autocomplete="off" x-webkit-speech="" speech="" class=" xg1" placeholder="请输入搜索内容" />
		</div>
		<div>
			<a href="javascript:;" id="scbar_type" onclick="showScbarTypeMenu(this)" hidefocus="true" initialized="true">帖子</a>
		</div>
		<div id="scbar_btn">
		<input type="submit" value="" />
		</div>
		<span id="scbar_hot">
			<strong class="xw1">热搜:&nbsp; </strong>
			<?php $kwArr = $config->site->hotKw->toArray();?>
			<?php foreach ($kwArr as $kw) {?>
			<a href="/search?kw=<?=urlencode($kw)?>&amp;source=hotsearch" target="_blank" class="xi2" sc="1"><?=$kw?></a>&nbsp;
		<?php } ?>
		</span>
	</form>
	<ul id="scbar_type_menu">
		<li><a href="javascript:;" rel="topic" class="curtype">帖子</a></li>
		<li><a href="javascript:;" rel="user">用户</a></li>
	</ul>
</div>
