var isIE = !!window.ActiveXObject;
var isIE6 = isIE && navigator.appVersion.match(/6./i)=="6." ? true : false;
var isIE7 = navigator.userAgent.indexOf("MSIE 7.0")>0 ? true : false;
var isIE8 = navigator.userAgent.indexOf("MSIE 8.0")>0 ? true : false;
var isLowIE = isIE6 || isIE7;
function setClassName(obj, classValue)
{
	if (isLowIE)
	{
		obj.className = classValue;
	} else {
		obj.setAttribute('class', classValue);
	}
}
(function(){
	var Carousel = function(id, opts, data){
		var ele = document.getElementById(id);
		if (ele == null)
		{
			return false;
		}
		Carousel.data = data;
		Carousel.currentIndex = 0;
		Carousel.interval = opts.interval;
		Carousel.picNodes = [];
		Carousel.dotNodes = [];
		// carousel main
		var oMain = document.createElement('div');
		setClassName(oMain, 'carousel-main');
		// control bar
		var oCtrl = document.createElement('div');
		setClassName(oCtrl, 'carousel-ctrl');
		for (var i in data)
		{
			var oItem = document.createElement('div');
			if (i==0)
			{
				setClassName(oItem, 'carousel-item');
			} else {
				setClassName(oItem, 'carousel-item hide');
			}
			var itemLink = document.createElement('a');
			itemLink.setAttribute('href', data[i]['url']);
			if (data[i]['target'])
			{
				itemLink.setAttribute('target', data[i]['target']);
			} else {
				itemLink.setAttribute('target', '_blank');
			}
			var itemPic = document.createElement('img');
			itemPic.setAttribute('border', '0');
			itemPic.setAttribute('src', data[i]['pic']);
			if (typeof(opts.showTitle)=='undefined' || opts.showTitle)
			{
				var showTitle = true;
				var itemTitle = document.createElement('h3');
				var oText = document.createTextNode(data[i]['title']);
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
			
			Carousel.picNodes[i] = oItem;
			Carousel.dotNodes[i] = itemDot;
		}
		for (var j in Carousel.dotNodes)
		{
			if (Carousel.dotNodes[j].addEventListener)
			{
				Carousel.dotNodes[j].addEventListener('click', function(){Carousel.switchPic(this.getAttribute('idx'));}, false);
			} else if (window.dotNodes[j].attachEvent){
				Carousel.dotNodes[j].attachEvent('onclick', function(){Carousel.switchPic(this.getAttribute('idx'));});
			} else {
				Carousel.dotNodes[j]['onclick'] = function(){Carousel.switchPic(this.getAttribute('idx'));};
			}
		}
		ele.appendChild(oMain);
		ele.appendChild(oCtrl);
		window.carouselInt = setInterval('Carousel.switchPic()', opts.interval);
	};
	Carousel.switchPic = function(i)
	{
		// 原来图片切换隐藏
		setClassName(Carousel.picNodes[Carousel.currentIndex], 'carousel-item hide');
		setClassName(Carousel.dotNodes[Carousel.currentIndex], '');
		if (i)
		{
			Carousel.currentIndex = i;
			var force = true;
		} else {
			Carousel.currentIndex++;
			var force = false;
		}
		if (Carousel.currentIndex == Carousel.data.length)
		{
			Carousel.currentIndex = 0;
		}
		// 新图切换显示
		setClassName(Carousel.picNodes[Carousel.currentIndex], 'carousel-item');
		setClassName(Carousel.dotNodes[Carousel.currentIndex], 'current');
		if (force && !isIE)
		{
			window.clearInterval(window.carouselInt);
			window.carouselInt = setInterval('Carousel.switchPic()', Carousel.interval);
		}
	};
	
	window.Carousel = Carousel;
})();