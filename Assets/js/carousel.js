(function(){
	var Carousel = function(id, opts, config){
		var ele = document.getElementById(id);
		if (ele == null)
		{
			return false;
		}
		Carousel.config = config;
		this.l = config.length;
		window.picNodes = [];
		window.dotNodes = [];
		// carousel main
		var oMain = document.createElement('div');
		setClassName(oMain, 'carousel-main');
		// control bar
		var oCtrl = document.createElement('div');
		setClassName(oCtrl, 'carousel-ctrl');
		for (var i in config)
		{
			var oItem = document.createElement('div');
			if (i==0)
			{
				setClassName(oItem, 'carousel-item');
			} else {
				setClassName(oItem, 'carousel-item hide');
			}
			var itemLink = document.createElement('a');
			itemLink.setAttribute('href', config[i]['url']);
			if (config[i]['target'])
			{
				itemLink.setAttribute('target', config[i]['target']);
			} else {
				itemLink.setAttribute('target', '_blank');
			}
			var itemPic = document.createElement('img');
			itemPic.setAttribute('border', '0');
			itemPic.setAttribute('src', config[i]['pic']);
			if (typeof(opts.showTitle)=='undefined' || opts.showTitle)
			{
				var showTitle = true;
				var itemTitle = document.createElement('h3');
				var oText = document.createTextNode(config[i]['title']);
				itemTitle.appendChild(oText);
				itemLink.appendChild(itemTitle);
			} else {
				var showTitle = false;
			}
			itemLink.appendChild(itemPic);
			oItem.appendChild(itemLink);
			oMain.appendChild(oItem);
			var itemDot = document.createElement('span');
			if (i==0)
			{
				setClassName(itemDot, 'current');
			} else {
				setClassName(itemDot, '');
			}
			itemDot.setAttribute('idx', i);
			oCtrl.appendChild(itemDot);
			
			
			window.picNodes[i] = oItem;
			window.dotNodes[i] = itemDot;
		}
		Carousel.currentIndex = 0;
		Carousel.interval = opts.interval;
		for (var j in window.dotNodes)
		{
			if (window.dotNodes[j].addEventListener)
			{
				window.dotNodes[j].addEventListener('click', function(){Carousel.switchPic(this.getAttribute('idx'));}, false);
//			} else if (window.dotNodes[j].attachEvent){
//				window.dotNodes[j].attachEvent('onclick', function(){Carousel.switchPic(this.getAttribute('idx'));});
			} else {
				window.dotNodes[j]['onclick'] = function(){Carousel.switchPic(this.getAttribute('idx'));};
			}
		}
		ele.appendChild(oMain);
		ele.appendChild(oCtrl);
		window.carouselInt = setInterval('Carousel.switchPic()', opts.interval);
	};
	Carousel.switchPic = function(i)
	{
		// 原来图片切换隐藏
		setClassName(window.picNodes[Carousel.currentIndex], 'carousel-item hide');
		setClassName(window.dotNodes[Carousel.currentIndex], '');
		if (i)
		{
			Carousel.currentIndex = i;
			var force = true;
		} else {
			Carousel.currentIndex++;
			var force = false;
		}
		if (Carousel.currentIndex == Carousel.config.length)
		{
			Carousel.currentIndex = 0;
		}
		// 新图切换显示
		setClassName(window.picNodes[Carousel.currentIndex], 'carousel-item');
		setClassName(window.dotNodes[Carousel.currentIndex], 'current');
		if (force && !isIE)
		{
			Window.clearInterval(window.carouselInt);
			window.carouselInt = setInterval('Carousel.switchPic()', Carousel.interval);
		}
	};
	
	window.Carousel = Carousel;
})();