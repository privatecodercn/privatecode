<?php
$preLoadCss = array('index');
include dirname(__DIR__).'/header.html.php';
?>

<div class="container fluid">
	<div id="main">
    	<div id="breadcrumb">
            <div class="base">您的位置</div>
            <div class="info"><a href="/">首页</a>&nbsp;&nbsp;→&nbsp;&nbsp;文章页&nbsp;&nbsp;→&nbsp;&nbsp;<h1 class="title" title="<?=$detail->title?>"><?=$detail->title?></h1></div>
        </div>
		
		<script type="text/javascript" src="http://www.qq.com/404/search_children.js" charset="utf-8"></script>
        <!--<script type="text/javascript" src="http://www.qq.com/404/search_children.js?edition=small" charset="utf-8"></script>-->
		
        <div class="clear"></div>
        
    </div>
    
    <div id="sidebar">
    	<!--#include file="/inc/hotVideo.shtml"-->
		<!--#include file="/inc/viewsRankVideo.shtml"-->
    </div>
	<div class="clear"></div>
</div>

<?php include dirname(__DIR__).'/footer.html.php'; ?>