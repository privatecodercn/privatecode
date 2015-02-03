<?php
$preLoadCss = array('article');
include dirname(__DIR__).'/header.html.php';
?>


<div class="container fluid">
	<div id="main">
    	<div id="breadcrumb">
            <div class="base">您的位置</div>
            <div class="info"><a href="/">首页</a>&nbsp;&nbsp;→&nbsp;&nbsp;文章页&nbsp;&nbsp;→&nbsp;&nbsp;<h1 class="title" title="<?=$detail->title?>"><?=$detail->title?></h1></div>
        </div>
        
        <div id="fieldinfo">
        	<div class="base">发布时间：<?=date('Y-m-d H:i:s', $detail->post_time)?>&nbsp;&nbsp;作者：佚名&nbsp;&nbsp;来源：本站原创</div>
        </div>
        
        <div id="content">
        	<?=$detail->content?>
        </div>
        
        <div id="content_pagenation">
        <?php 
		if ($pageTotal>1)
		{
			for ($i=1; $i<=$pageTotal; $i++)
			{
				if ($i == $page)
				{
					echo '<a class="cur">'.$i.'</a>&nbsp;';
				} else {
					echo '<a href="/article/'.$id.'/'.$i.'">'.$i.'</a>&nbsp;';
				}
			}
		}
		?>
        </div>
        
        <div id="tags">
            <strong>Tags:</strong>&nbsp;
            <a href="blog_reviews.html" title="View posts in technology">technology</a>
            <a href="blog_reviews.html" title="View posts in web">web</a>
            <a href="blog_reviews.html" title="View posts in design">design</a>
            <a href="blog_reviews.html" title="View posts in inspiration">inspiration</a>
            <a href="blog_reviews.html" title="View posts in kitchen">kitchen</a>
            <a href="blog_reviews.html" title="View posts in panorama">panorama</a>
        </div>
        
        <div class="clear"></div>
        
    </div>
    
    <?php include dirname(__DIR__).'/sidebar.html.php'; ?>
    
    <div class="clear"></div>
</div>





<?php include dirname(__DIR__).'/footer.html.php'; ?>