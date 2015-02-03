<?php
$preLoadCss = array('index');
$preLoadCss = array('list');
include dirname(__DIR__).'/header.html.php';
?>

<div class="container fluid">
	<div id="main">
    	<div id="breadcrumb">
            <div class="base">您的位置</div>
            <div class="info"><a href="/">首页</a>&nbsp;&nbsp;→&nbsp;&nbsp;<h1 class="title" title="<?=$typeName?>"><?=$typeName?></h1></div>
        </div>
        
		<div class="brief">
        	
        </div>
		
		<ul class="list">
		<?php 
		$definition = Local_Cfg::getDefinition();
		foreach ($videoList as $k=>$video)
		{
		?>
    	<li><a href="/video/x_<?=String::idCrypt($video->id)?>.html"><?=$video->title?></a><span><?=date('Y-m-d H:i', $video->create_time)?></span></li>
		<?php } ?>
		</ul>
        
		
        
        <div class="clear"></div>
        
    </div>
    
    <div id="sidebar">
		<!--#include file="/inc/hotVideo.shtml"-->
		<!--#include file="/inc/viewsRankVideo.shtml"-->
    </div>
    
    <div class="clear"></div>
</div>


<?php include dirname(__DIR__).'/footer.html.php'; ?>