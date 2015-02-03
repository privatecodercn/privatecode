<?php
$preLoadCss = array('index');
include dirname(__DIR__).'/header.html.php';
?>

<div id="headline" class="container">
	<div id="headlinebase">
    	<div>新闻</div>
        <p>公告</p>
    </div>
    <div id="headlinetext">
    	<?php foreach ($newsList as $item) {?>
    	<a href="<?=$item->url?>" title="<?=$item->title?>"><?=$item->title?></a>
        <?php }?>
    </div>
        <div class="clear"></div>
</div>

<div id="focus" class="container">
	<ul>
        <li class="masked masked-big">
        	<a href="<?=$focusBig->url?>" title=""></a>
        	<div class="figure"><img src="<?=$focusBig->cover_image?>" /></div>
        	<div class="text">
		      <h2><?=$focusBig->title?></h2>
		      <span class="meta">发布时间：<?=date('Y-m-d', $focusBig->create_time)?></span>
		      <p><?=$focusBig->brief?></p>
		    </div>
        </li>
        <?php
		foreach ($focusSmall as $k=>$item)
		{
			$class = '';
			if ($k%2==1)
			{
				$class .= ' margin-left';
			}
			if ($k>1)
			{
				$class .= '  no-margin-bottom';
			}
		?>
        <li class="masked masked-small <?=$class?>">
        	<a href="<?=$item->url?>" title=""></a>
        	<div class="figure"><img src="<?=$item->cover_image?>" /></div>
        	<div class="text">
		      <h2><?=$item->title?></h2>
		      <span class="meta">发布时间：<?=date('Y-m-d', $item->create_time)?></span>
		    </div>
        </li>
		<?php }?>
        <div class="clear"></div>
    </ul>
</div>

<div class="container fluid">
	<div id="main">
    	<?php 
		$definition = Local_Cfg::getDefinition();
		foreach ($newestVideoList as $k=>$video) 
		{
		?>
    	<div class="block1<?php if ($k%2 == 0){?> no-margin-left<?php }?>">
        	<div class="figure">
            	<a href="/video/x_<?=String::idCrypt($video->id)?>.html"><img alt="" src="<?=$video->cover_image?>" /></a>
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
        
    </div>
    
    <div id="sidebar">
		<!--#include file="/inc/hotVideo.shtml"-->
		<!--#include file="/inc/viewsRankVideo.shtml"-->
    </div>
    
    
    <div class="clear"></div>
</div>

<?php include dirname(__DIR__).'/footer.html.php'; ?>