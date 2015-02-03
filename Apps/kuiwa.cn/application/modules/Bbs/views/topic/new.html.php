<?php
$vt = ViewTools::getInstance();
$vt->preload('bbs', 'css');
include dirname(__DIR__).'/header.html.php';
?>

<?php include Yaf_Registry::get('config')->application->viewPath.'/breadcrumb.html.php';?>

<ul id="newPostTab" class="container margintop5 clr">
	<li class="cur">发表帖子</li>
    <li>发起投票</li>
</ul>

<div class="container">
  <form id="newPostForm" name="newPostForm" method="post" action="">
      <input type="hidden" name="board_id" id="board_id" value="<?=$board_id?>" />
      <div class="li">
          <input type="radio" name="is_copy" value="0" id="is_copy_0" class="radio" />
          <label>原创</label>
          &nbsp;&nbsp;&nbsp;
          <input type="radio" name="is_copy" value="1" id="is_copy_1" class="radio" checked="checked" />
          <label>转载</label>
      </div>
      <div class="li">
      	  <?php $arr=Local_Cfg::getBbsCategory();var_export($arr)?>
          <select name="select" id="select">
              <?php foreach ($arr as $cid=>$cname) {?>
              <option value="<?=$cid?>"><?=$cname?></option>
              <?php }?>
          </select>
        <input type="text" name="title" id="title" /> <span>还可输入80个字符</span>
  </div>
      <div class="li"><textarea id="content" name="content"></textarea></div>
  </form>
</div>

<?php
$vt->preInc('/assets/umeditor/umeditor.config.js');
$vt->preInc('http://ueditor.baidu.com/umeditor/umeditor.min.js');
$vt->preInc('http://ueditor.baidu.com/umeditor/themes/default/css/umeditor.min.css');
$vt->preload('bbs', 'js');
$vt->preload('topicnew', 'js');
include dirname(__DIR__).'/footer.html.php';
?>