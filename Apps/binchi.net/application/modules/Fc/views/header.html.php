<?php
$config = Yaf_Registry::get("config");
$vt = ViewTools::getInstance();
$vt->viewPath = $this->getScriptPath();
$vt->preload('default', 'css', true);
if (isset($preLoadCss) && $preLoadCss)
{
	foreach ($preLoadCss as $css)
	{
		$vt->preload($css, 'css');
	}
}
$vt->preload('common', 'js', true);
$navCurrent = isset($navCurrent) ? $navCurrent : 'nav_home';
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="x-dns-prefetch-control" content="on">
<title><?php if (isset($seoTitle)) {echo $seoTitle;} elseif (isset($title)) {echo $title;} else {echo '财富房产';}?></title>
<meta name="keywords" content="<?php if (isset($seoKeywords)) {echo $seoKeywords;} else {echo $config->site->keywords;}?>">
<meta name="description" content="<?php if (isset($seoDescription)) {echo $seoDescription;} else {echo $config->site->description;}?>">
<?=$vt->load('css')?>
</head>

<body>