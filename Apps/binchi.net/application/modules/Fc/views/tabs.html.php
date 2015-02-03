<?php 
$vt->preload('tabs', 'js', true);
?>
<div id="tabs" data-type="<?=$type?>" data-islist="<?=(int)$publishTab?>">
    <ul>
        <li data-tab="house"><i class="house on"></i><span>套房</span></li>
        <li data-tab="building"><i class="building"></i><span>写字楼</span></li>
        <li data-tab="shop"><i class="shop"></i><span>商铺</span></li>
<?php if ($publishTab) { ?>
        <li><a href="<?=$publishUrl?>"><i class="newAdd"></i><span>我要发布</span></a></li>
<?php }?>
    </ul>
</div>