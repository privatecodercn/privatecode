<?php
$preLoadCss = array('index');
include dirname(__DIR__).'/header.html.php';
?>

<div class="container fluid">
	<div id="main">
    	<div id="breadcrumb">
            <div class="base">您的位置</div>
            <div class="info"><a href="/">首页</a>&nbsp;&nbsp;→&nbsp;&nbsp;<h1 class="title" title="TI国际邀请赛">TI国际邀请赛</h1></div>
        </div>
        
		<div class="brief">
        	<p>DOTA2国际邀请赛，The International DOTA2 Championships。简称Ti，创立于2011年，是一个全球性的电子竞技赛事，由ValveCorporation（V社）主办。</p>
			<p>每年一次在美国西雅图（除Ti1在德国科隆）举行DOTA2最大规模和最高奖金额度的国际性高水准比赛。</p>
			<p>截止TI4，DOTA2奖金额度已高达千万美元。</p>
        </div>
		
		<?php 
		$definition = Local_Cfg::getDefinition();
		for ($i=$maxSession; $i>0; $i--)
		{
		?>
    	<div class="block1<?php if ($i%2 == 0){?> no-margin-left<?php }?>">
        	<div class="figure">
            	<a href="/ti<?=$i?>.html"><img alt="" src="/img/TI.jpg" /></a>
            	<div class="catlabel">
				    <span class="base">TI<?=$i?></span>
				    <span class="arrow"></span>
			    </div>
            </div>
            <div class="text">
            	<h2>TI<?=$i?></h2>
                <p class="videoinfo">举办年份：<?=$startYear+$i-1?>&nbsp;&nbsp;</p>
            </div>
        </div>
		<?php } ?>
        
        <div id="tags">
            <strong>Tags:</strong>&nbsp;
            <a href="/tags/<?=urlencode('V社')?>.html" title="<?=urlencode('V社')?>">V社</a>
            <a href="/tags/DOTA2.html" title="DOTA2">DOTA2</a>
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