$(function(){
	$('#boardform').submit(function(){
		var data = $(this).serialize();
		$.post('/admin/board/doBatchSave', data, function(response){
			if (response.success)
			{
				window.location = window.location;
			} else {
				alert(response.message ? response.message : '操作失败！');
			}
		}, 'json');
		return false;
	});
});
var newBoardId = 0;
function addSubBoard(id)
{
	var pObj = $('#boardrow'+id);
	var subVal = parseInt(pObj.attr('sub')) + 1;
	var subPreStr = '├' + new Array(subVal+1).join('一一一');
	var html = '<tr id="newboard'+newBoardId+'" sub="'+subVal+'" class="subboard'+id+'">'
				+'<td><input type="hidden" name="newpid[]" value="'+id+'" /></td>'
				+'<td><input name="neworder[]" type="text" value="0" size="2"></td>'
				+'<td>'+subPreStr+'<input name="newname[]" type="text" value="" size="30">&nbsp;<a href="javascript:deleteNewBoard('+newBoardId+');">删除</a></td>'
				+'<td></td><td></td></tr>'
				;
	pObj.after(html);
	newBoardId++;
}
function addTopBoard()
{
	var html = '<tr id="newboard'+newBoardId+'">'
				+'<td><input type="hidden" name="newpid[]" value="0" /></td>'
				+'<td><input name="neworder[]" type="text" value="0" size="2"></td>'
				+'<td><input name="newname[]" type="text" value="" size="30">&nbsp;<a href="javascript:deleteNewBoard('+newBoardId+');">删除</a></td>'
				+'<td></td><td></td></tr>'
				;
	$('#addTopBoardRow').before(html);
	newBoardId++;
}

function deleteNewBoard(id)
{
	$('#newboard'+id).remove();
}

function deleteBoard(id)
{
	$.getJSON('/admin/board/delete/id/'+id, function(response){
		if (response.success)
		{
			window.location = window.location;
		} else {
			alert(response.message ? response.message : '操作失败！');
		}
	});
}