<?php
$config = Yaf_Registry::get("config");
$vt = new ViewTools();
$vt->viewPath = $this->getScriptPath();
$vt->preload('default', 'css');
if (isset($preLoadCss)) foreach ($preLoadCss as $v)
{
	$vt->preload($v, 'css');
}
if (isset($preIncCss)) foreach ($preIncCss as $v)
{
	$vt->preInc($v);
}
$vt->preload('common', 'js');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-cn" xmlns:wb="http://open.weibo.com/wb">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php if (isset($seoTitle)) {echo $seoTitle.'_'.$config->site->title;} else {echo $config->site->title;}?></title>
<meta name="keywords" content="<?php if (isset($seoKeywords)) {echo $seoKeywords;} else {echo $config->site->keywords;}?>">
<meta name="description" content="<?php if (isset($seoDescription)) {echo $seoDescription;} else {echo $config->site->description;}?>">
<?=$vt->inc('css')?>
<?=$vt->loadCss()?>
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>


<div id="header">
	<div class="container">
        <div class="h1"><a href="<?=$config->site->url?>" title="<?=$config->site->title?>"><?=$config->site->name?></a></div>
        <ul id="hnav">
            <li class="active"><a href="<?=$config->site->url?>" title="首页">首页</a></li>
            <li><a href="/video/list_jijin.html" title="集锦视频">集锦视频</a></li>
            <li><a href="/video/list_match.html" title="比赛视频">比赛视频</a></li>
            <li><a href="/video/list_commentator.html" title="解说视频">解说视频</a></li>
            <li><a href="/ti" title="TI国际邀请赛">TI国际邀请赛</a></li>
            <li><a href="/album" title="专辑">专辑</a></li>
        </ul>
        <form id="site-search" name="site-search" method="post">
       	 <input type="text" name="search" placeholder="请输入搜索关键字...." class="input-icon input-icon-search">
         <a onClick="$('#site-search').submit()"></a>
        </form>
    </div>
</div>