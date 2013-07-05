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


// LOGIN ----------------------------------------------------------------------------------------------



$(function() { // LOGIN
  $('.error').hide();
  $('input.text-input').css({backgroundColor:"#FFFFFF"});
  $('input.text-input').focus(function(){
    $(this).css({backgroundColor:"#FFDDAA"}); // yellow bg
  });
  $('input.text-input').blur(function(){
    $(this).css({backgroundColor:"#FFFFFF"});
  });

 
  $(".buttonr").click(function() {
		// validate and process form
		
    $('.error').hide(); // first hide any error messages
		
	  var user = $("input#user").val();
		if (user == "username" || user == "") {
      $("label#user_error").show();
      $("input#user").focus();
      return false;
    }
		var pass = $("input#pass").val();
		if (pass == "") {
      $("label#pass_error").show();
      $("input#pass").focus();
      return false;
    }

    var sublogin = $("input#sublogin").val();
		if (sublogin == "") {
      $("label#sublogin_error").show();
      $("input#sublogin").focus();
      return false;
    }
			
		var dataString = 'user='+ user + '&pass=' + pass + '&sublogin=' + sublogin;
		//alert (dataString);return false;

      $.ajax({
      type: "POST",
      url: "process.php", // needs to be changed to ajax_login.php to check for database
      data: dataString,
      success: function() {
                   
        $('#contact_form').html("<div id='message'></div>");
        $('#message').html("Welcome " + user + " you are logged in.<br> <a href = 'process.php'> Sign Out</a>")
        .append("<p></p>")
        .hide()
        .fadeIn(700, function() {
        $('#message').append("<img id='checkmark' src='index_files/login/images/check.pn' />");
        });
      }
     });
    return false;
	});


        // REGISTER

        $(".buttonr").click(function() {
		// validate and process form
                
        $('.errorr').hide(); // first hide any error messages

	  var userr = $("input#userr").val();
          if (userr == "username" || userr == "") {
      $("label#userr_error").show();
      $("input#userr").focus();
      return false;
    }
		var pass = $("input#pass").val();
		if (pass == "") {
      $("label#pass_error").show();
      $("input#pass").focus();
      return false;
    }

    var sublogin = $("input#sublogin").val();
		if (sublogin == "") {
      $("label#sublogin_error").show();
      $("input#sublogin").focus();
      return false;
    }

		var dataString = 'user='+ userr + '&pass=' + pass + '&sublogin=' + sublogin;
		//alert (dataString);return false;

      $.ajax({
      type: "POST",
      url: "process.php", // needs to be changed to ajax_login.php to check for database
      data: dataString,
      success: function() {

        $('#contact_form').html("<div id='message'></div>");
        $('#message').html("Welcome " + userr + " you are logged in.<br> <a href = 'process.php'> Sign Out</a>")
        .append("<p></p>")
        .hide()
        .fadeIn(700, function() {
        $('#message').append("<img id='checkmark' src='index_files/login/images/check.pn' />");
        });
      }
     });
    return false;
	});



});

runOnLoad(function(){
  $("input#user").select().focus();
});

// REGISTRATION -------------------------------------------------------------------------------------------------

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
  if (user == "") {
      $("label#user_error").show();
      $("input#user").focus();
      return false;
  }
  var email = $("input#email").val();
  if (email == "") {
      $("label#email_error").show();
      $("input#email").focus();
      return false;
    }
  var pass = $("input#pass").val();
  if (pass == "") {
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
              $('#registerDialog').html("<div id='message'></div>");
              $('#message').html("<h2>Welcome to PE Planning</h2>")
              .append("<p>We have sent your login details to your email.</p>")
              .hide()
              .fadeIn(1500, function() {
              $('#message').append("");
              });
          }
          if (data =='user'){
              /*$('#registerDialog').html("<div id='message'></div>");
            $('#message').html("<h2>There was a problem</h2>")
            .append("<p>Your username or email are already in use.</p>")
            .hide()
            .fadeIn(1500, function() {
            $('#message').append("<img id='checkmark' src='images/check.png' />");

        });*///alert('works');

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
