<?php
$vt = ViewTools::getInstance();
$vt->preload('bbs', 'css');
include dirname(__DIR__).'/header.html.php';
?>

<?php include Yaf_Registry::get('config')->application->viewPath.'/breadcrumb.html.php';?>

<div class="container singlebar margintop5 clr">
    <a href="/bbs/topic/new-<?=$boardOne->id?>" id="newTopicBtn" title="发新帖"></a>
</div>

<div id="tpcl" class="containerborder margintop5 clr">
	<div class="caption">
    	<a href="">最新发帖</a>
    	<a href="">最新回复</a>
    	<a href="">热门</a>
    	<a href="">精华</a>
    </div>
    
    <div class="list-body">
    <?php if (empty($topicList)) {?>
    	<p>本版块或指定的范围内尚无主题</p>
    <?php } else {?>
    	
    <?php }?>
    </div>
</div>


<?php
$vt->preload('bbs', 'js');
include dirname(__DIR__).'/footer.html.php';
?>