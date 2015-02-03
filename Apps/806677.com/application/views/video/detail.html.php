<?php
include dirname(__DIR__).'/header.html.php';
?>


<div class="container fluid">
	<div id="main">
    	<div id="breadcrumb">
            <div class="base">您的位置</div>
            <div class="info"><a href="/">首页</a>&nbsp;&nbsp;→&nbsp;&nbsp;文章页&nbsp;&nbsp;→&nbsp;&nbsp;<h1 class="title" title="<?=$detail->title?>"><?=$detail->title?></h1></div>
        </div>
        
        <div id="fieldinfo">
        	<div class="base">发布时间：<?=date('Y-m-d H:i:s', $detail->create_time)?>&nbsp;&nbsp;作者：佚名&nbsp;&nbsp;来源：本站原创</div>
        </div>
        
        <div id="content">
			<p>
				<center>
				<?php if (0 === strpos($detail->code, 'http://')) {?>
        		<embed src="<?=$detail->code?>" quality="high" width="700" height="437" align="middle" autostart="true" allowScriptAccess="always" allowFullScreen="true" mode="transparent" type="application/x-shockwave-flash"></embed>
				<?php } else if (0 === strpos($detail->code, '<embed')) {
					echo $detail->code;
				}
				?>
				</center>
			</p>
			<p>
				<?=$detail->brief?>
			</p>
        </div>
        
        
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