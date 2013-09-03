// jQuery Alert Dialogs Plugin
//
// Version 1.1
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 14 May 2009
//
// Visit http://abeautifulsite.net/notebook/87 for more information
//
// Usage:
//		jAlert( message, [title, callback] )
//		jConfirm( message, [title, callback] )
//		jPrompt( message, [value, title, callback] )
// 
// History:
//
//		1.00 - Released (29 December 2008)
//
//		1.01 - Fixed bug where unbinding would destroy all resize events
//
// License:
// 
// This plugin is dual-licensed under the GNU General Public License and the MIT License and
// is copyright 2008 A Beautiful Site, LLC. 
//
(function($) {
	
	$.alerts = {
		
		// These properties can be read/written by accessing $.alerts.propertyName from your scripts at any time
		
		verticalOffset: -200,                // vertical offset of the dialog from center screen, in pixels
		horizontalOffset: 0,                // horizontal offset of the dialog from center screen, in pixels/
		repositionOnResize: true,           // re-centers the dialog on window resize
		overlayOpacity: .6,                // transparency level of overlay
		overlayColor: '#FFF',               // base color of overlay
		draggable: true,                    // make the dialogs draggable (requires UI Draggables plugin)
		okButton: '&nbsp;OK&nbsp;',         // text for the OK button
		cancelButton: '&nbsp;Cancel&nbsp;', // text for the Cancel button
		dialogClass: null,                  // if specified, this class will be applied to all dialogs
		
		// Public methods
		
		alert: function(message, title, callback) {
			if( title == null ) title = 'Notice';
			$.alerts._show(title, message, null, 'alert', function(result) {
				if( callback ) callback(result);
			});
		},
                
                inform: function(message, title, callback) {
			if( title == null ) title = 'Information';
			$.alerts._show(title, message, null, 'inform', function(result) {
				if( callback ) callback(result);
			});
		},
		
		lesson: function(message, title, callback) {
			if( title == null ) title = 'Information';
			$.alerts._show(title, message, null, 'lesson', function(result) {
				if( callback ) callback(result);
			});
		},
                
                confirm: function(message, title, callback) {
			if( title == null ) title = 'Confirm';
			$.alerts._show(title, message, null, 'confirm', function(result) {
				if( callback ) callback(result);
			});
		},
			
		prompt: function(message, value, title, callback) {
			if( title == null ) title = 'Prompt';
			$.alerts._show(title, message, value, 'prompt', function(result) {
				if( callback ) callback(result);
			});
		},
                
                form: function(message, value, title, callback) {
			if( title == null ) title = 'Form';
			$.alerts._show(title, message, value, 'form', function(result) {
				if( callback ) callback(result);
			});
		},
		
                userform: function(message, value, title, callback) {
			if( title == null ) title = 'Edit User';
			$.alerts._show(title, message, value, 'userform', function(result) {
				if( callback ) callback(result);
			});
		},
                
		passwordform: function(message, value, title, callback) {
			if( title == null ) title = 'Change Password';
			$.alerts._show(title, message, value, 'passwordform', function(result) {
				if( callback ) callback(result);
			});
		},
                
		selectform: function(message, value, title, callback) {
			if( title == null ) title = 'Select';
			$.alerts._show(title, message, value, 'selectform', function(result) {
				if( callback ) callback(result);
			});
		},
                status: function(message, value, title, callback) {
			if( title == null ) title = 'Loading...';
			$.alerts._show(title, message, value, 'status', function(result) {
				if( callback ) callback(result);
			});
		},
                loading: function(message, value, title, callback) {
			if( title == null ) title = 'Loading Lesson Details';
			$.alerts._show(title, message, value, 'loading', function(result) {
				if( callback ) callback(result);
			});
		},
		// Private methods
		
		_show: function(title, msg, value, type, callback) {
			
			$.alerts._hide();
			$.alerts._overlay('show');
			if(type=='alert') var popMess="popup_message_alert";
			else if(type=='inform') var popMess="popup_message_inform";
                        else if(type=='lesson') var popMess="popup_message_lesson";
                        else var popMess="popup_message";
			$("BODY").append(
			  '<div id="popup_container">' +
			    '<h1 id="popup_title"></h1>' +
			    '<div id="popup_content">' +
			      '<div id="'+popMess+'"></div>' +
				'</div>' +
			  '</div>');
			
			if( $.alerts.dialogClass ) $("#popup_container").addClass($.alerts.dialogClass);
			
			// IE6 Fix
			var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed'; 
			
			$("#popup_container").css({
				position: pos,
				zIndex: 99999,
				padding: 0,
				margin: 0
			});
			
			$("#popup_title").text(title);
			$("#popup_content").addClass(type);
			$("#popup_message").text(msg);
			$("#popup_message").html( $("#popup_message").text());
		
			$("#popup_container").css({
				minWidth: $("#popup_container").outerWidth(),
				maxWidth: $("#popup_container").outerWidth()
			});
			
			$.alerts._reposition();
			$.alerts._maintainPosition(true);
			
			switch( type ) {
				case 'alert':
					$("#popup_message_alert").text(msg);
                                        $("#popup_message_alert").html( $("#popup_message_alert").text());
                                        $("#popup_message_alert").after('<div id="popup_panel_alert"><a value="' + $.alerts.okButton + '" id="popup_ok" ><span>OK</span></a></div>');
					$("#popup_ok").click( function() {
						$.alerts._hide();
						callback(true);
					});
					$("#popup_ok").focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#popup_ok").trigger('click');
					});
				break;
                                case 'inform':
					$("#popup_message_inform").text(msg);
                                        $("#popup_message_inform").html( $("#popup_message_inform").text());
                                        $("#popup_message_inform").after('<div id="popup_panel_inform"><a value="' + $.alerts.okButton + '" id="inform_ok" ><span>OK</span></a></div>');
                                        $("#inform_ok").click( function() {
						$.alerts._hide();
						callback(true);
					});
					$("#inform_ok").focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#inform_ok").trigger('click');
					});
				break;
                                case 'lesson':
					$("#popup_message_lesson").text(msg);
                                        $("#popup_message_lesson").html( $("#popup_message_lesson").text());
                                        $("#popup_message_inform").after('<div id="popup_panel_lesson"><a value="' + $.alerts.okButton + '" id="inform_ok" ><span>OK</span></a></div>');
                                        $("#lesson_ok").click( function() {
						$.alerts._hide();
						callback(true);
					});
					$("#popup_title").focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#lesson_ok").trigger('click');
					});
				break;
				case 'confirm':
					$("#popup_message").after('<div id="popup_panel"><div class="btn_left"><a value="' + $.alerts.okButton + '" id="popup_ok"><span>OK</span></a></div><div class="btn_right"><a value="' + $.alerts.cancelButton + '" id="popup_cancel"><span>cancel</span></a></div></div>');
					$("#popup_ok").click( function() {
						$.alerts._hide();
						if( callback ) callback(true);
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback(false);
					});
					$("#popup_ok").focus();
					$("#popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
				break;
				case 'prompt':
					var inputDetails="<br /><input type=\"text\" size=\"30\" id=\"popup_prompt\" class=\"popup_input\" value='"+value+"' onfocus='if(this.value==\""+value+"\"){this.value=\"\";}' onblur='if(this.value == \"\"){this.value=\""+value+"\"}'/><br><span>Enter the email address you registered with PE Planning</span>";
					$("#popup_message").append(inputDetails).after('<div id="popup_panel"><div class="btn_left"><a value="' + $.alerts.okButton + '" id="popup_ok"><span>OK</span></a></div><div class="btn_right"><a value="' + $.alerts.cancelButton + '" id="popup_cancel"><span>cancel</span></a></div></div>');
					$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						var val = $("#popup_prompt").val();
						$.alerts._hide();
						if( callback ) callback( val );
                                               // if(title=='Forgotten Password') location.replace("http://" + location.host + "/");
                
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback( null );
                                                if(title=='Forgotten Password') location.replace("http://" + location.host + "/");
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value ) $("#popup_prompt").val(value);
					//$("#popup_prompt").focus().select();
				break;
                                case 'form':
                                        var inputDetails="<br /><input type=\"text\" size=\"30\" id=\"popup_prompt\" class=\"popup_input\" value='"+value+"' onfocus='if(this.value==\""+value+"\"){this.value=\"\";}' onblur='if(this.value == \"\"){this.value=\""+value+"\"}'/>";
					$("#popup_message").append(inputDetails).after('<div id="popup_panel"><div class="btn_left"><a value="' + $.alerts.okButton + '" id="popup_ok"><span>OK</span></a></div><div class="btn_right"><a value="' + $.alerts.cancelButton + '" id="popup_cancel"><span>cancel</span></a></div></div>');
					$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						//var val = $("#sel_level").val()+","+$("#popup_prompt").val();
                                                var val = $("#createunit").serialize()+"&own_title="+$("#popup_prompt").val();
						//$.alerts._hide();
						if( callback ) callback( val );
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback( null );
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value ) $("#popup_prompt").val(value);
					//$("#popup_prompt").focus().select();
				break;
                                case 'userform':
                                        var inputDetails="<br /><a href='javascript:void(0)' onclick='changePassword(0);'>change password?</a>";
					$("#popup_message").append(inputDetails).after('<div id="popup_panel"><div class="btn_left"><a value="' + $.alerts.okButton + '" id="popup_ok"><span>OK</span></a></div><div class="btn_right"><a value="' + $.alerts.cancelButton + '" id="popup_cancel"><span>cancel</span></a></div></div>');
					//$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						//var val = $("#sel_level").val()+","+$("#popup_prompt").val();
                                                var val = $("#edituserform").serialize();
						//$.alerts._hide();
						if( callback ) callback( val );
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback( null );
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value ) $("#popup_prompt").val(value);
					//$("#popup_prompt").focus().select();
				break;
                                case 'passwordform':
                                        var inputDetails="<br />";
					$("#popup_message").append(inputDetails).after('<div id="popup_panel"><div class="btn_left"><a value="' + $.alerts.okButton + '" id="popup_ok"><span>OK</span></a></div><div class="btn_right"><a value="' + $.alerts.cancelButton + '" id="popup_cancel"><span>cancel</span></a></div></div>');
					$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						//var val = $("#sel_level").val()+","+$("#popup_prompt").val();
                                                var val = $("#passwordform").serialize();
						//$.alerts._hide();
						if( callback ) callback( val );
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback( null );
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value ) $("#popup_prompt").val(value);
					//$("#popup_prompt").focus().select();
				break;
                                case 'selectform':
                                        var inputDetails="";
					$("#popup_message").append(inputDetails).after('<div id="popup_panel"><div class="btn_left"><a value="' + $.alerts.okButton + '" id="popup_ok"><span>OK</span></a></div><div class="btn_right"><a value="' + $.alerts.cancelButton + '" id="popup_cancel"><span>cancel</span></a></div></div>');
					$("#popup_prompt").width( $("#popup_message").width() );
					$("#popup_ok").click( function() {
						//var val = $("#sel_level").val()+","+$("#popup_prompt").val();
                                                var val = $("#assess_sel").val();
						//$.alerts._hide();
						if( callback ) callback( val );
					});
					$("#popup_cancel").click( function() {
						$.alerts._hide();
						if( callback ) callback( null );
					});
					$("#popup_prompt, #popup_ok, #popup_cancel").keypress( function(e) {
						if( e.keyCode == 13 ) $("#popup_ok").trigger('click');
						if( e.keyCode == 27 ) $("#popup_cancel").trigger('click');
					});
					if( value ) $("#popup_prompt").val(value);
					//$("#popup_prompt").focus().select();
				break;
                                case 'status':
                                        $("#popup_message").after('<div id="status_bar"></div>')
                                        $("#status_bar").progressbar({value:0});
                                        //$("#status_bar").show();
    					//$("#popup_message").append($("#status_bar"));
                                        //.after('<div id="popup_panel"><a value="Close" id="inform_ok" ><span>Close</span></a></div>');
                                        $("#popup_title").click( function() {
						$.alerts._hide();
						callback(true);
					});
					$("#status_ok").focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#status_ok").trigger('click');
					});
				break;
                                case 'loading':
                                        $("#popup_message").after('<div id="status_bar"></div>')
                                        //$("#status_bar").show();
    					//$("#popup_message").append($("#status_bar"));
                                        //.after('<div id="popup_panel"><a value="Close" id="inform_ok" ><span>Close</span></a></div>');
                                        $("#popup_title").click( function() {
						$.alerts._hide();
						callback(true);
					});
					$("#status_ok").focus().keypress( function(e) {
						if( e.keyCode == 13 || e.keyCode == 27 ) $("#status_ok").trigger('click');
					});
				break;
				
			}
			
			// Make draggable
			if( $.alerts.draggable ) {
				try {
					$("#popup_container").draggable({handle: $("#popup_title")});
					$("#popup_title").css({cursor: 'move'});
				} catch(e) { /* requires jQuery UI draggables */ }
			}
		},
		
		_hide: function() {
			$("#popup_container").remove();
			$.alerts._overlay('hide');
			$.alerts._maintainPosition(false);
		},
		
		_overlay: function(status) {
			switch( status ) {
				case 'show':
					$.alerts._overlay('hide');
					$("BODY").append('<div id="popup_overlay"></div>');
					$("#popup_overlay").css({
						position: 'absolute',
						zIndex: 99998,
						top: '0px',
						left: '0px',
						width: '100%',
						height: $(document).height(),
						background: $.alerts.overlayColor,
						opacity: $.alerts.overlayOpacity
					});
				break;
				case 'hide':
					$("#popup_overlay").remove();
				break;
			}
		},
		
		_reposition: function() {
			var top = (($(window).height() / 2) - ($("#popup_container").outerHeight() / 2)) + $.alerts.verticalOffset;
			var left = (($(window).width() / 2) - ($("#popup_container").outerWidth() / 2)) + $.alerts.horizontalOffset;
			if( top < 0 ) top = 0;
			if( left < 0 ) left = 0;
			
			// IE6 fix
			if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();
			
			$("#popup_container").css({
				top: top + 'px',
				left: left + 'px'
			});
			$("#popup_overlay").height( $(document).height() );
		},
		
		_maintainPosition: function(status) {
			if( $.alerts.repositionOnResize ) {
				switch(status) {
					case true:
						$(window).bind('resize', $.alerts._reposition);
					break;
					case false:
						$(window).unbind('resize', $.alerts._reposition);
					break;
				}
			}
		}
		
	}
	
	// Shortuct functions
	jAlert = function(message, title, callback) {
		$.alerts.alert(message, title, callback);
	};
	
        jInform = function(message, title, callback) {
		$.alerts.inform(message, title, callback);
	};
        
	jLesson = function(message, title, callback) {
		$.alerts.lesson(message, title, callback);
	};
        
        jConfirm = function(message, title, callback) {
		$.alerts.confirm(message, title, callback);
	};
		
	jPrompt = function(message, value, title, callback) {
		$.alerts.prompt(message, value, title, callback);
	};
        jForm = function(message, value, title, callback) {
		$.alerts.form(message, value, title, callback);
	};
        jUserform = function(message, value, title, callback) {
		$.alerts.userform(message, value, title, callback);
	};
        jPasswordform = function(message, value, title, callback) {
		$.alerts.passwordform(message, value, title, callback);
	};
        jSelectform = function(message, value, title, callback) {
		$.alerts.selectform(message, value, title, callback);
	};
        jStatus = function(message, title, callback) {
		$.alerts.status(message, title, callback);
	};
	jLoading = function(message, title, callback) {
		$.alerts.loading(message, title, callback);
	};
	
})(jQuery);