var isIE = !!window.ActiveXObject;
var isIE6 = isIE && navigator.appVersion.match(/6./i)=="6." ? true : false;
var isIE7 = navigator.userAgent.indexOf("MSIE 7.0")>0 ? true : false;
var isIE8 = navigator.userAgent.indexOf("MSIE 8.0")>0 ? true : false;
var isLowIE = isIE6 || isIE7;
function setClassName(obj, classValue)
{
//	if (isLowIE)
//	{
		obj.className = classValue;
//	} else {
//		obj.setAttribute('class', classValue);
//	}
}