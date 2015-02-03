<div class="containerborder breadcrumb margintop5 clr">
	<div class="breadcrumb-content">
    	<a href="./" class="breadcrumbnv-home" title="首页">首页</a>
    	<?php foreach ($GLOBALS['breadcrumbs'] as $item) {?>
        <em>»</em>
        <a href="<?=$item['url']?>"><?=$item['title']?></a>
        <?php }?>
    </div>
</div>