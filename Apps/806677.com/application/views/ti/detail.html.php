<?php
$preLoadCss = array('index');
include dirname(__DIR__).'/header.html.php';
?>


<div class="container fluid">
	<div id="main">
    	<div id="breadcrumb">
            <div class="base">您的位置</div>
            <div class="info"><a href="/">首页</a>&nbsp;&nbsp;→&nbsp;&nbsp;<a href="/ti">DOTA2国际邀请赛（TI）</a>&nbsp;&nbsp;→&nbsp;&nbsp;<h1 class="title" title="<?=$detail->title?>"><?=$detail->title?></h1></div>
        </div>
        
        <div id="fieldinfo">
        	<div class="base"><?=$detail->title?></div>
        </div>
        
        <div class="brief">
			<?=$detail->content?>
        </div>
		
		<?php 
		$definition = Local_Cfg::getDefinition();
		foreach ($videoList as $k=>$video) 
		{
		?>
    	<div class="block1<?php if ($k%2 == 0){?> no-margin-left<?php }?>">
        	<div class="figure">
            	<a href="/video/x_<?php echo String::idCrypt($video->id);?>.html"><img alt="" src="<?=$video->cover_image?>" /></a>
            	<div class="catlabel">
				    <span class="base"><?=$definition[$video->definition]?></span>
				    <span class="arrow"></span>
			    </div>
            </div>
            <div class="text">
            	<h2><?=$video->title?></h2>
                <p class="videoinfo">发布时间：<?=date('Y-m-d H:i', $video->create_time)?>&nbsp;&nbsp;|&nbsp;&nbsp;播放数：<?=$video->views?>&nbsp;&nbsp;</p>
            </div>
        </div>
		<?php } ?>
		
		<div class="clear"></div>
        
        <div id="tags">
            <strong>Tags:</strong>&nbsp;
			<?php foreach ($detail->tags as $k=>$tag) {?>
            <a href="/tags/<?=urlencode($tag)?>.html" title="<?=$tag?>"><?=$tag?></a>
			<?php } ?>
        </div>
        
        <div class="clear"></div>
        
    </div>
    
    <div id="sidebar">
		<!--#include file="/inc/hotVideo.shtml"-->
		<!--#include file="/inc/viewsRankVideo.shtml"-->
    </div>
    
    <div class="clear"></div>
</div>





<?php include dirname(__DIR__).'/footer.html.php'; ?>