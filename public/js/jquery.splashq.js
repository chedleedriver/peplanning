(function($) {
$.fn.splashQ = function(settings){
	return new SplashQ(this, settings);
}; 
function SplashQ(ref, settings){
	var _self = this;
	this.splash = ref;//$("#" + setting.splashBox);
	/*Progressbar creation*/
	this.progressContainer = $("<div class='splashscreen_progress_container'></div>");
	var splashWidth = this.splash.width(); 
	this.progressContainer.css({
		width: splashWidth
	});
	this.progressBar = $("<div class='splashscreen_progress_bar' style='position:absolute;left:0;top:0;width:0'></div>");
	this.progressContainer.append(this.progressBar);
	this.console = $("<div class='splashscreen_console'><span style='display:none'></span></div>");
	this.scriptName = $("<div class='splashscreen_package_name'></div>");
	this.toggleConsole = $("<a class='splashscreen_toggle_console' href='#'></a>");
	this.overlay = $("<div class='splashscreen_overlay'></div>");
	this.errorBox = $("<div class='splashscreen_error_box'></div>");

	var paramList = ["successCallback", "abortCallback", "errorMsg", "timeout", "retryMsg", "abortMsg", "maxRetries", "scripts"];
	var settings = $.extend(this._defaults, settings);
	for(var i = 0; i < paramList.length; i++){
		this[paramList[i]] = settings[paramList[i]];
	}
	this.toggleConsole.click(function(){ _self.console.toggle(); });	
	$("body").append(this.overlay);
	this.splash
		.append(this.progressContainer)
		.append(this.console)
		.append(this.scriptName)
		.append(this.toggleConsole)
		.append(this.errorBox)
		.css({
			top: ($(document).height()-this.splash.height())/2,
			left: ($(document).width()-splashWidth)/2
		})
	.show();
	this.load({
		scripts:this.scripts
	});
} 
$.extend(SplashQ.prototype, {
	/* public members */
	retry: function(){
		this._resetErrorCounter();
		this.load({
			scripts: this.scripts, 
			startIndex: this.loadedScripts
		});
	},
	ajaxError: function(evt, request, parameters){
		var _self = this;
		this.console.find("div:last").append("<span style='float:right'>[<span class='splashscreen_failed'>failed</span>]</span><br style='clear:both'/>")
		if(this._counter){
			this._counter--;
			this.load.call(this, "");
		}else{
			this._resetErrorCounter();
			this.scriptName.html("<span class='splashscreen_script_name'>Load Error</span><a class='splashscreen_retry' href='#'>" + _self.retryMsg + "</a><a class='splashscreen_abort' href='#'>" + _self.abortMsg + "</a>");
			if(this.abortCallback){
				$(".splashscreen_abort", this.splash[0]).click(function(){ _self.abortCallback.call(_self); });
			}
			$(".splashscreen_retry", this.splash[0]).click(function(){ _self.errorBox.hide(); _self.retry.call(_self) });
			this.console.show();
			this.errorBox.show();
			this.errorBox.html(this.errorMsg);
			this._scrollConsoleToBottom();
		}
	},
	load: function(toLoad, data, loadStatus){
		var _self = this;
		this._startIndex = toLoad.startIndex || this.loadedScripts;
		this.loadedScripts = this._startIndex;
		this.scripts = toLoad.scripts || this.scripts;
		
		if(toLoad){
			// executed once
			var len = this.scripts.length;
			if(!len){ return; }
			this._increment = parseInt(this.progressContainer.width()) / len;
		}else{
			if(loadStatus && loadStatus == "success"){
				this.console.find("div:last").append("<span style='float:right'>[<span class='splashscreen_ok'>  ok  </span>]</span><br style='clear:both'/>");
				this.progressBar.css({width:parseInt((this.loadedScripts + 1)*this._increment) + "px"});
				this.loadedScripts++;
				this._resetErrorCounter();
			}
		}
		if(this.scripts[this.loadedScripts]){
			this.scriptName.html("<span style='color:black'>loading... " + _self.scripts[_self.loadedScripts].name + "</span>");
			this.console.append("<div class='splashscreen_console_line'><span style='float:left'>" + _self.scripts[_self.loadedScripts].src + "...</span></div>")
			this._scrollConsoleToBottom();
			$.ajax({
				type: "GET",
				url: _self.scripts[_self.loadedScripts].src, 
				success: function(data, loadStatus){ _self.load.call(_self, "", data, loadStatus) },
				error: function(){ _self.ajaxError.call(_self) },
				timeout: _self.timeout,
				dataType: "script"
			});
		}else{
			this.destroy();
		}		
	},
	destroy: function(){
		this.splash.remove();
		this.overlay.remove();
		if(this.successCallback){
			this.successCallback();
		}
	},
	loadedScripts: 0,
	scripts: [],
	/* private members */
	_scrollConsoleToBottom: function(){
		var cDom = this.console[0];
		cDom.scrollTop = cDom.scrollHeight;
	},
	_resetErrorCounter: function(){
		this._counter = this.maxRetries - 1;
	},
	_defaults: {
		retryMsg: "Retry",
		abortMsg: "Abort",
		errorMsg: "An error has occurred",
		maxRetries: 3,
		timeout: 10000
	},
	_increment: 10,
	_counter: 2,
	_startIndex: 0
});
})(jQuery);
 