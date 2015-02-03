
    	<div class="widget">
        	<div class="header">
        		<h4>热门视频</h4>
            </div>
            <ul class="content">
            	<?php 
				if (!isset($hotVideoList))
				{
					$hotVideoList = Local_Fragment::getVideoList('hotVideo');
				}
            	foreach ($hotVideoList as $video)
            	{
            	?>
            	<li class="item">
                    <div class="figure"><img src="<?=$video['cover_image']?>" width="120" height="90" /></div>
                    <h4><a href="/video/x_<?=String::idCrypt($video['id'])?>.html" title="<?=$video['title']?>"><?=$video['title']?></a></h4>
                    <div class="meta">生命值：<?=$video['score']?>&nbsp;&nbsp;|&nbsp;&nbsp;发布时间：<?=date('Y-m-d', $video['create_time'])?></div>
                    <div class="clear"></div>
                </li>
                <?php } ?>
            </ul>
        </div>