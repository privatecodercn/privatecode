function showScbarTypeMenu(obj){var typeObj = $(obj);var h = typeObj.height();var pos = typeObj.position();$('#scbar_type_menu').css({"left":pos.left+'px', "top":(pos.top+h)+'px'}).show();}$(function(){$('#'+navCurrent+' a').addClass('nav_current');$('#ulogin').submit(function(){var data = $(this).serialize();$.post('/member/dologin', data, function(response){if (response.success){window.location.href=indow.location.href;} else {alert(response.message);}}, 'json');return false;});$('#scbar_type_menu a').click(function(){$('#scbar_type').text($(this).text());$('#scbar_type_menu').hide();$('#scbar_type_value').val($(this).attr('rel'));});$('#head_nav ul li').mousemove(function(){var child = $(this).attr('child');if (child){$('.quicknav').hide();$('#'+child).show();}}).mouseout(function(){var child = $(this).attr('child');if (child){$('.quicknav').hide();$('#'+child).hide();}});$('.quicknav').mousemove(function(){$(this).show();}).mouseout(function(){$(this).hide();});var navH = $('#head_nav').offset().top;$(window).scroll(function(){if ($(this).scrollTop() >= navH) {$('#head_nav').css({'position':'fixed', 'left':0, 'top':0, 'right':0});} else {$('#head_nav').removeAttr('style');}});});$(function(){});var um = UM.getEditor('content', {initialFrameWidth:'956',initialFrameHeight:500,allowDivTransToP: false,zIndex:0,focus: true});$(function(){$('#newPostTab li').click(function(){$('#newPostTab li').removeClass('cur');$(this).addClass('cur');});$('#newPostForm').submit(function(){um.sync();var data = $(this).serialize();data.content = um.getContent();$.post('/bbs/topic/saveNew', data, function(response){if (response.success){window.location.href="/bbs/topic-"+response.data.id+".html";} else {alert(response.message);}}, 'json');return false;});});