$('#tabs li').click(function(){
	$('#tabs li i').removeClass('on');
	$(this).find('i').addClass('on');
	if ($('#tabs').data('islist')=='1')
	{
		var url = '/fc/house/getList/type/'+$('#tabs').data('type');
		$.getJSON(url, function(response){
			if (response.success)
			{
				;
			} else {
				;
			}
		});
	} else {
		$('#form form').hide();
		$('#'+$(this).data('tab')).show();
		$('#'+$(this).data('tab')).prepend($('#pics'));
	}
});