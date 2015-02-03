<?php include dirname(__DIR__).'/header.html.php'; ?>

<!--begin centercontent-->
<div class="centercontent">

	<div id="default_main" class="contentwrapper clearfix">
    
    	<div>
        
        </div>
    
    </div>

</div>
<!--end bodywrapper-->
<?php
//$vt->preload('weixinmenuindex', 'js', true);
?>

<?php include dirname(__DIR__).'/footer.html.php'; ?>
<script type="text/javascript">
$(function(){
	$('form').submit(function(){
		var data = $(this).serialize();
		$.post('/admin/weixinMenu/release', data, function(response) {
			if (response.success)
			{
				alert('发布成功！');
			} else{
				alert(response.message);
			}
		}, 'json');
		return false;
	});
		
});
</script>