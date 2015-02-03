<?php
$vt = ViewTools::getInstance();
$vt->preload('bbs', 'css');
include dirname(__DIR__).'/header.html.php';
?>

<?php include Yaf_Registry::get('config')->application->viewPath.'/breadcrumb.html.php';?>

<?php foreach ($boardList as $board) {?>
<div class="container margintop5 clr">
    <div class="tbgtopborder"></div>
    <div class="tbg"><a href="/bbs/board-<?=$board['id']?>.html" class="tbgtext"><?=$board['name']?></a></div>
    <div class="block">
    <?php
		$first = true; 
		foreach ($board['sub'] as $sub) {
			if (isset($boardTodayData[$sub['id']]) && $boardTodayData[$sub['id']]['post_num']>0) {
				$img = 'http://ww3.sinaimg.cn/large/005VaPhhgw1enbnh0w327g300v00tdfl.gif';
			} else {
				$img = 'http://ww2.sinaimg.cn/large/005VaPhhgw1enbngiae16g300v00t0gn.gif';
			}
	?>
        <dl class="sub-board<?=$first ? ' board-no-tline' : ''?>">
            <dt>
                <img src="<?=$img?>" border="0" align="absmiddle" />
                <a href="/bbs/board-<?=$sub['id']?>.html"><?=$sub['name']?></a>
                &nbsp;[<?=isset($boardTodayData[$sub['id']]) ? $boardTodayData[$sub['id']]['post_num'] : '0'?>]
            </dt>
            <dd class="desc">
			<?php if ($sub['post_num']>0) {?>
            	<a>宠物大冒险中的魔法颜色都代表什 ...</a>
                <em>半小时前 admin</em>
			<?php } else { echo '<div>从未</div>';}?>
            </dd>
            <dd><?=$sub['post_num']?>/<?=$sub['topic_num']?></dd>
        </dl>
    <?php 
		$first = false;
	}
	?>
    </div>
</div>
<?php }?>

<?php
$vt->preload('index', 'js');
include dirname(__DIR__).'/footer.html.php';
?>