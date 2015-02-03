<?php include dirname(__DIR__).'/header.html.php'; ?>





<?php
$vt->preInc('/assets/ueditor/third-party/codemirror/codemirror.js');
$vt->preInc('/assets/ueditor/third-party/codemirror/codemirror.css');
$vt->preload('article', 'js', true);
include dirname(__DIR__).'/footer.html.php';
?>
