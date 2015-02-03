<?php
$vt = ViewTools::getInstance();
$vt->preload('index', 'css');
include dirname(__DIR__).'/header.html.php';
?>

<div id="focus-container" class="container">
<script type="text/javascript">
var focusData = <?php include APP_PATH.'data/fragment/index-focus.json'; ?>;
</script>
	<div id="focus" class="container-two-third">
		<div id="carousel" class="carousel container-two-third">
			
		</div>
	</div>
	<div id="mainNews" class="container-one-third">
		<div class="blkttl"><h2>最新资讯</h2></div>
		<div class="content">
			<ul>
				<li><a href="" title="">该出手时就出手该出手时就出手该</a><span>2014-07-05</span></li>
				<li><a href="" title="">该出手时就出手该出手时就出手该</a><span>2014-07-05</span></li>
				<li><a href="" title="">该出手时就出手该出手时就出手该</a><span>2014-07-05</span></li>
				<li><a href="" title="">该出手时就出手该出手时就出手该</a><span>2014-07-05</span></li>
				<li><a href="" title="">该出手时就出手该出手时就出手该</a><span>2014-07-05</span></li>
				<li><a href="" title="">该出手时就出手该出手时就出手该</a><span>2014-07-05</span></li>
				<li><a href="" title="">该出手时就出手该出手时就出手该</a><span>2014-07-05</span></li>
				<li><a href="" title="">该出手时就出手该出手时就出手该</a><span>2014-07-05</span></li>
				<li><a href="" title="">该出手时就出手该出手时就出手该</a><span>2014-07-05</span></li>
				<li><a href="" title="">该出手时就出手该出手时就出手该</a><span>2014-07-05</span></li>
				<li><a href="" title="">该出手时就出手该出手时就出手该</a><span>2014-07-05</span></li>
				<li><a href="" title="">该出手时就出手该出手时就出手该</a><span>2014-07-05</span></li>
			</ul>
		</div>
	</div>
	<div class="clear"></div>
</div>

<div class="container margintop5" style="padding:0;">
<img src="/img/containerimg1.jpg" width="960" height="70" />
</div>

<div class="container">
	<div class="container-two-third left">
        <div class="tbgtopborder"></div>
        <div class="tbg"></div>
        <div class="block"></div>
    </div>
	<div class="container-one-third right">
        <div class="tbgtopborder"></div>
        <div class="tbg"></div>
        <div class="block"></div>
    </div>
    <div class="clear"></div>
</div>

<div class="container margintop5">
	<div class="container-two-third left">
        <div class="tbgtopborder"></div>
        <div class="tbg"></div>
        <div class="block">333333333</div>
    </div>
	<div class="container-one-third right">
        <div class="tbgtopborder"></div>
        <div class="tbg"></div>
        <div class="block"></div>
    </div>
    <div class="clear"></div>
</div>

<div class="container margintop5">
<img src="/img/containerimg1.jpg" width="960" height="70" />
</div>

<div class="container margintop5">
	<div class="container-two-third left">
        <div class="tbgtopborder"></div>
        <div class="tbg"></div>
        <div class="block"></div>
    </div>
	<div class="container-one-third right">
        <div class="tbgtopborder"></div>
        <div class="tbg"></div>
        <div class="block"></div>
    </div>
    <div class="clear"></div>
</div>

<div class="container margintop5">
	<div class="container-two-third left">
        <div class="tbgtopborder"></div>
        <div class="tbg"></div>
        <div class="block"></div>
    </div>
	<div class="container-one-third right">
        <div class="tbgtopborder"></div>
        <div class="tbg"></div>
        <div class="block"></div>
    </div>
    <div class="clear"></div>
</div>

<div class="container margintop5">
    <div class="tbgtopborder"></div>
    <div class="tbg">
         <span class="tgbtext">友情链接</span>
    </div>
    <div class="block"></div>
</div>


<?php
$vt->preInc('/assets/carousel/carousel.js');
$vt->preload('index', 'js');
include dirname(__DIR__).'/footer.html.php';
?>