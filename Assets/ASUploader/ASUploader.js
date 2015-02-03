/**
 * ASUploader: http://ASUploader.googlecode.com
 * 
 * @copyright (c) 2011 
 * @author Joseph Chen
 * @release MIT License:
 * @link http://www.opensource.org/licenses/mit-license.php
 *
 *
 */
function ASUploader(setting) {
	this.setting = setting;
	this.movieId = 0;
	this.movie = null;
	// flash settings
	this.holder = 'ASUploaderPlaceHolder';
	this.movieName = 'ASUploader_' + this.movieId;
	this.flashUrl = 'ASUploader.swf';
	this.width = 150;
	this.height = 30;
	this.windowMode = 'transparent';
	
	// upload server settings
	this.uploadUrl = '/upload.php';
	this.filePostName = 'Filedata';
	this.queryString = false;
	this.postParams = '';
	this.returnDataType = 'JSON';
	this.completeCallback = 'completeCallback';
	this.autoUpload = false;
	
	// file settings
	this.fileTypesDesc = 'All Files';
	this.fileTypes = '*.*';
	this.file_size_limit = 0;// zero means 'unlimited'
	this.file_upload_limit = 0;
	this.file_size_limit = 0;
	this.file_queue_limit = 0;
	this.multiFiles = true;
	
	/* start define functions */
	//init setting
	this.init = function() {
		for (var i in this.setting)
		{
			this.setDefaultVal(i, this.setting[i]);
		}
		
		this.postParams = this.buildParams(setting.postParams);
	};
	
	// create ASUploader instance
	this.create = function (movieName) {
		if (!movieName) {
			movieName = this.movieName;
		}
		if (document.getElementById(this.movieName) !== null) {
			throw "ID " + this.movieName + " is already in use. The Flash Object could not be added";
		}
		var objectHTML = '<object id="' + this.movieName + '" type="application/x-shockwave-flash" data="'
				+ this.flashUrl + '" width="' + this.width + '" height="' + this.height + '" class="swfupload">'
				+ '<param name="wmode" value="' + this.windowMode + '" />'
				+ '<param name="movie" value="' + this.flashUrl + '" />'
				+ '<param name="quality" value="high" />'
				+ '<param name="menu" value="false" />'
				+ '<param name="allowScriptAccess" value="always" />'
				+ '<param name="flashvars" value="' + this.getFlashVars() + '" />'
				+ '</object>';
		document.getElementById(this.holder).innerHTML = objectHTML;
		this.movie = document.getElementById(this.movieName);
		return this;
	};
	// set default value
	this.setDefaultVal = function (name, value) {
		if (this.setting[name] != undefined) {
			this[name] = this.setting[name];
		} else if (this[name] == undefined) {
			this[name] = value;
		}
	};
	// build params
	this.buildParams = function (params) {
		var paramPairs = ["post_from_ASUploader=1"];
		
		if (typeof(params) === 'object') {
			for (var key in params) {
				paramPairs.push(encodeURIComponent(key.toString()) + '=' + encodeURIComponent(params[key].toString()));
			}
		}
		paramPairs.push('returnDataType=' + encodeURIComponent(this.returnDataType));
		
		return paramPairs.join('&');
	};
	
	this.getFlashVars = function() {
		var flashVars = [];
		for (var i in this)
		{
			var tof = typeof(this[i]);
			if (tof == 'function' || tof == 'object')
			{
				continue;
			}
			flashVars.push(i+'='+ encodeURIComponent(this[i]));
		}
		return flashVars.join('&');
	};
	
	this.upload = function() {
		this.movie.upload();
	};
	
	
	// execute code
	this.init();
	
};