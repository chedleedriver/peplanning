// This file ecapsulates sections which use our runOnload, login and register systems.

/*
 * runOnLoad.js: portable registration for onload event handlers.
 *
 * This module defines a single runOnLoad() function for portably registering
 * functions that can be safely invoked only when the document is fully loaded
 * and the DOM is available.
 *
 * Functions registered with runOnLoad() will not be passed any arguments when
 * invoked. They will not be invoked as a method of any meaningful object, and
 * the this keyword should not be used.  Functions registered with runOnLoad()
 * will be invoked in the order in which they were registered.  There is no
 * way to deregister a function once it has been passed to runOnLoad().
 *
 * In old browsers that do not support addEventListener() or attachEvent(),
 * this function relies on the DOM Level 0 window.onload property and will not
 * work correctly when used in documents that set the onload attribute
 * of their <body> or <frameset> tags.
 */
function runOnLoad(f) {
    if (runOnLoad.loaded) f();    // If already loaded, just invoke f() now.
    else runOnLoad.funcs.push(f); // Otherwise, store it for later
}

runOnLoad.funcs = []; // The array of functions to call when the document loads
runOnLoad.loaded = false; // The functions have not been run yet.

// Run all registered functions in the order in which they were registered.
// It is safe to call runOnLoad.run() more than once: invocations after the
// first do nothing. It is safe for an initialization function to call
// runOnLoad() to register another function.
runOnLoad.run = function() {
    if (runOnLoad.loaded) return;  // If we've already run, do nothing

    for(var i = 0; i < runOnLoad.funcs.length; i++) {
        try { runOnLoad.funcs[i](); }
        catch(e) { /* An exception in one function shouldn't stop the rest */ }
    }

    runOnLoad.loaded = true; // Remember that we've already run once.
    delete runOnLoad.funcs;  // But don't remember the functions themselves.
    delete runOnLoad.run;    // And forget about this function too!
};

// Register runOnLoad.run() as the onload event handler for the window
if (window.addEventListener)
    window.addEventListener("load", runOnLoad.run, false);
else if (window.attachEvent) window.attachEvent("onload", runOnLoad.run);
else window.onload = runOnLoad.run;

// end of the runOnload


// LOGIN ---------------------------------------------------------------------------------------------

$(function() {
    $.ajax({
        type: "GET",
        url: "checklogin.php",
        dataType: 'text',
        beforesend:function(){$('#accordion2').html("<img src='imagefiles/my_plans_loader.gif'>")},
        success: function(data) {
            if(data=='imin'){
                var user = document.getElementById('myUser');
                $('#login').html("<a href='#' onclick='javascript:editAccount()'>my account&nbsp;|&nbsp</a><a href='process.php'>&nbsp;sign out</a>").fadeIn(1500, 
                function() {$('#login').show()});
                $.get("tab2.php", function(data){
                    $('#accordion2').html(data);
                });
                $.get("assessment_tab.php", function(data){
                    $('#page-feature-assessment').html(data);
                });
            }
            else if(data=='imout'){
                $(function() {
                    $('.errorlog').hide();
                    $('#login_form').show();
                    $('.buttonlog').click(function() {
                        $('.errorlog').hide();
                        var user = $("input#userlog").val();
                        if (user == "") {
                            $("label#userlog_error").show();
                            $("input#userlog").focus();
                            return false;
                        }
                        var pass = $("input#passlog").val();
                        if (pass == "") {
                            $("label#passlog_error").show();
                            $("input#passlog").focus();
                            return false;
                        }
                        var sublogin=1;
                        var dataString = 'user='+ user + '&pass=' + pass + '&sublogin=' + sublogin;
                        $.ajax({
                            type: "POST",
                            url: "process.php",
                            data: dataString,
                            dataType: 'text',
                            success: function(data) {
                                if (data=='fail'){
                                    $("label#passlog_error2").show();
                                    $("label#userlog_error2").show();
                                    $("input#userlog").focus();
                                    $.get("process.php", function(data){});
                                    $('#accordion2').html("You must login to see your plans");
                                }
                                else{
                                    $('#login').html("<a href='#' onclick='javascript:editAccount()'>my account&nbsp;|&nbsp</a><a href='process.php'>&nbsp;sign out</a>")
                                    .fadeIn(1500, function() {
                                        $('#login').show()
                                    });
                                    $.get("tab2.php", function(data){
                                        $('#accordion2').html(data);
                                    });
                                    $.get("assessment_tab.php", function(data){
                                        $('#page-feature-assessment').html(data);
                                    });
                                }
                            }
                        });
                        return false
                    });
                });
            }
            else{
                alert('you should not be here');
            }
                        
                    }
                });
});
// REGISTER ---------------------------------------------------------------------------------------------

$(function() {
  $('.error').hide();
  $('input.text-input').css({backgroundColor:"#FFFFFF"});
  $('input.text-input').focus(function(){
    $(this).css({backgroundColor:"##eefacf"});
  });
  $('input.text-input').blur(function(){
    $(this).css({backgroundColor:"#FFFFFF"});
  });

  $(".buttonr").click(function() {
		// validate and process form
		// first hide any error messages
    $('.error').hide();

    var user = $("input#user").val();
  if ((user == "")||(user=="username")) {
      $("label#user_error").show();
      $("input#user").focus();
      return false;
  }
  var email = $("input#email").val();
  if ((email == "")||(email=="email")) {
      $("label#email_error").show();
      $("input#email").focus();
      return false;
    }
  var pass = $("input#pass").val();
  if ((pass == "")||(pass=="password")) {
      $("label#pass_error").show();
      $("input#pass").focus();
      return false;
    }

  var subjoin=1;

		var dataString= 'user=' + user + '&email=' + email + '&pass=' + pass + '&subjoin=' + subjoin;
		//alert (dataString);return false;

		$.ajax({
      type: "POST",
      url: "process.php",
      data: dataString,
      dataType: 'text',

      success: function(data) {

          if (data==0){
              //alert('none');
              $('#registerDialog').html("<div id='message' style='font-family:arial;font-size:12px;color:#829f5e'></div>");
              $('#message').html("<h2>Welcome to PE Planning</h2>")
              .append("We have sent your login details to your email.")
              .hide()
              .fadeIn(1500, function() {
              $('#message').append("");
              });
          }
          if (data =='user'){
            $("label#user_error").hide();
            $("label#user_error2").show();
            $("input#user").focus();
            return false;

            }
            else if (data == 'email'){
            $("label#email_error").hide();
            $("label#email_error2").show();
            $("input#email").focus();
            }
            else if (data==2){
              //alert('two');

                $('#registerDialog').html("<div id='message'></div>");
                $('#message').html("<h2>Oops, there seems to be a problem</h2>")
                .append("<p>Please try again later.</p>")
                .hide()
                .fadeIn(1500, function() {
                $('#message').append("<img id='checkmark' src='images/check.png' />");

                });
              }
            }
     });
    return false;
	});
});
runOnLoad(function(){
  $("input#pass").select().focus();
  $("input#email").select().focus();
  $("input#user").select().focus();
});

// end of register --------------------------------------------------------------------------------