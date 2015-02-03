var goSlide = function(o){
	o = o || {};
	var opts = {
		'holder' : o.holder
	};
	
	var width = document.body.clientWidth;
	var startX = 0;
	var startY = 0;
	//手指滑动距离
	var lastDistX = 0;
	var lastDistY = 0;
	var distX = 0;
	var distY = 0;
	var scrollY = undefined;
	var target = document.getElementById(opts.holder);
	var isTouchPad = (/hp-tablet/gi).test(navigator.appVersion);
	var hasTouch = 'ontouchstart' in window && !isTouchPad;
	var touchStart = hasTouch ? 'touchstart' : 'mousedown';
	var touchMove = hasTouch ? 'touchmove' : 'mousemove';
	var touchEnd = hasTouch ? 'touchend' : 'mouseup';
	
	var translate = function( dist, speed, style ) {
		if( !!style ){ style=ele.style; }else{ style=target.style; }
		style.webkitTransitionDuration =  style.MozTransitionDuration = style.msTransitionDuration = style.OTransitionDuration = style.transitionDuration =  speed + 'ms';
		style.webkitTransform = 'translateX(' + dist + 'px)';
		style.msTransform = style.MozTransform = style.OTransform = 'translateX(' + dist + 'px)';		
	}
	
	//触摸开始函数
	var tStart = function(e){
		console.log(distX);
		var point = hasTouch ? e.touches[0] : e;
		startX =  point.pageX;
		startY =  point.pageY;

		//添加"触摸移动"事件监听
		target.addEventListener(touchMove, tMove,false);
		//添加"触摸结束"事件监听
		target.addEventListener(touchEnd, tEnd ,false);
	}

	//触摸移动函数
	var tMove = function(e){
		if( hasTouch ){ if ( e.touches.length > 1 || e.scale && e.scale !== 1) return }; //多点或缩放

		var point = hasTouch ? e.touches[0] : e;
		distX = point.pageX-startX;
		distY = point.pageY-startY;

		if ( typeof scrollY == 'undefined' && (distX>0 || distY>0))
		{
			scrollY = !!( scrollY || Math.abs(distX) < Math.abs(distY) );
		}
		e.preventDefault();
	}

	//触摸结束函数
	var tEnd = function(e){
		if(distX==0 && distY==0) return;
		e.preventDefault();
		lastDistX += distX;
		lastDistY += distY;

		target.removeEventListener(touchMove, tMove, false);
		target.removeEventListener(touchEnd, tEnd, false);
		
		if (lastDistX > 0)
		{
			lastDistX = 0;
			console.log(lastDistX+' - '+ width+' - '+target.clientWidth);
		} else if ((Math.abs(lastDistX)+width)>target.clientWidth) {
			console.log(lastDistX+' | '+ width+' | '+target.clientWidth);
			lastDistX = -(target.clientWidth - width);
		}
		
		console.log(lastDistX+','+ width+','+target.clientWidth);
		
		translate(lastDistX, 500);
		
	}
	
	target.addEventListener(touchStart, tStart ,false);
};