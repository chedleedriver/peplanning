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

   //$('.errorlog').hide(); //hides login errors
   //$('#login_form').hide();
   //$('#logged_form').hide();
    $.ajax({
      type: "GET",
      url: "checklogin.php",
      dataType: 'text',
      beforesend:function(){$('#accordion2').html("<img src='imagefiles/my_plans_loader.gif'>")},
      success: function(data) {
                //alert(data)
            //$('#login_form').hide();
            if(data=='imin'){
                //alert(data);

                var user = getCookie('cookname');
                var userlevel = getCookie('cooklevel');
                //alert(user);
                htmlString="<a style='font-family:arial;font-size:12px' href='#'>"+user+"&nbsp;|&nbsp</a><a style='font-family:arial;font-size:12px' href='#' onclick='javascript:editAccount(\""+user+"\")'>my account&nbsp;|&nbsp</a><a style='font-family:arial;font-size:12px' href='process.php'>&nbsp;sign out</a>"
                if (userlevel=="9") htmlString="<a style='font-family:arial;font-size:12px' href='DB_Maintenance/index.php'>admin&nbsp;|&nbsp</a>"+htmlString;
                $('#login').html(htmlString).fadeIn(1500,
                function() {$('#login').show()});

                /*$('#login_form').html("<div id='messagelog'></div>");
                //$('#messagelog').html("<img src='signedin.gif'/>")
                //.append("<p>Hello <b>" + user.value + "</b> <br><p><a href='process.php'><img src='index_files/signout.gif'/></a>")
                //.fadeIn(1500, function() {
                //$('#messagelog').append("");
                //$('#login_form').show()
                });*/

                //update content for tabs (pagination element -main.php)
                // get content for tab 2
                
                $.get("tab2.php", function(data){
                $('#accordion2').html(data); //this is the section where GetMyUnits is to be displayed
                }); // ends the get function

                // get content for tab 3
                $.get("tab3.php", function(data){
                $('#accordion3').html(data);
                //this is the section where GetMyUnits is to be displayed
                }); // ends the get function

            }
            else if(data=='imout'){
                    //alert(data);
                    // main function takes variables and signs in

                    //loads in initial tab content (pagination #main.php)
                    //tab 2 content- GetMyUnits to be displayed
                    $('#accordion2').html('<td width=350 align="left"><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h6>In order to edit, delete and print your plans you first need to sign in to PE PLANNING.</h6><br/></td>'); //this is the section where GetMyUnits is to be displayed
                    //tab 3 - assessment tab - displays 3 assessment icons--> link to #myAssessments.php
                    $('#accordion3').html("<table><tr><td><input type='image' src='index_files/class.jpg' class='ui-button'/></td><td><h3><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Class Assessment</h3></td></tr><tr><td><input type='image' src='index_files/individual.jpg' class='ui-button'/></td><td><h3><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Individual Assessment</h3></td></tr><tr><td><input type='image' src='index_files/teacher.jpg' class='ui-button'/></td><td><h3><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teacher Assessment</h3></td></tr></table>");
                    //$('#page-feature-assessment').click(function(){
                    //$('#page-feature-assessment').html("<h6>You must first sign in to PE Planning before you can assess your plans.</h6>")
                    //});//end load

                    $(function() {
                        $('.errorlog').hide();
                        $('#login_form').show();
                        $('#wrapper').keypress(function(event) {
                            if (event.keyCode == '13') {
                              $('.buttonlog').click();
                            }
                        });

                        $('.buttonlog').click(function() {
 
                        $('.errorlog').hide();
                        var user = $("input#userlog").val();

                        if (user == "") {
                            $("label#userlog_error").show();
                            $("input#userlog").focus();
                            return false;
                        }//end if

                        var pass = $("input#passlog").val();
                        if (pass == "") {
                            $("label#passlog_error").show();
                            $("input#passlog").focus();
                            return false;
                        }//end if

                        //collect signIn form vars from a non-signed in state
                        var sublogin=1;
                        var dataString = 'user='+ user + '&pass=' + pass + '&sublogin=' + sublogin;
                        //alert (dataString);return false;

                        /* ajax post - sends dataString to process.php and on returning the information
                         * which differentiates a pass or fail.
                         * PASS --> loads in tab2 & tab3 content for signin
                         * FAIL --> thows up signin errors for user to correct
                         * */
                        $.ajax({
                        type: "POST",
                        url: "process.php",
                        data: dataString,
                        dataType: 'text',
                        success: function(data) {

                            if (data=='fail'){ //user has failed
                                $("label#passlog_error2").show();
                                $("label#userlog_error2").show();
                                $("input#userlog").focus();

                                //this refreshes the session - prevents continuous fail
                                $.get("process.php", function(data){
                                //alert(data);
                                });//end get function
                            }
                            else{
                                // user has passed (success)
                                // show user details / my account link
                                var userlevel = getCookie('cooklevel');
                                htmlString="<a style='font-family:arial;font-size:12px' href='#'>"+user+"&nbsp;|&nbsp</a><a style='font-family:arial;font-size:12px' href='#' onclick='javascript:editAccount(\""+user+"\")'>my account&nbsp;|&nbsp</a><a style='font-family:arial;font-size:12px' href='process.php'>&nbsp;sign out</a>"
                                if (userlevel=="9") htmlString="<a style='font-family:arial;font-size:12px' href='DB_Maintenance/index.php'>admin&nbsp;|&nbsp</a>"+htmlString;
                                $('#login').html(htmlString).fadeIn(1500,
                                function() {
                                $('#login').show()
                                });

                                // load signedin content for tab2
                                $.get("tab2.php", function(data){
                                    $('#accordion2').html(data); //GetMyUnits are to be displayed
                                }); // end get function

                                // load signedin content for tab3
                                $.get("tab3.php", function(data){
                                    $('#accordion3').html(data); // assessment icons are to be displayed
                                }); // ends the get function

                                        /*$('#login_form').html("<div id='messagelog' style='display:block'></div>");
                                          $('#messagelog').html("<img src='signedin.gif'/>")
                                            .append("<p>Hello <b>" + user + "</b><br> <p> <a href='process.php'><img src='index_files/signout.gif'/></a>")
                                            .hide()
                                            .fadeIn(1500, function() {
                                          $('#messagelog').append("");
                                        });*/
                                
                                }} // ends else function
                        }); //ends ajax function
                        return false;
                     }); //ends .button click function
                  }); // ends the 'main'imout' initial function
                  runOnLoad(function(){
                    //$("input#passlog").select().focus();
                    //$("input#userlog").select().focus();
                    });
                  }
                  else{alert('you should not be here');} // if process.php returns neither 'pass'or 'fail' - doomsday scenario
        }// ends the success
    }); // ends the top function
});

// end of login
//
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
    var school = $("input#reg_school").val();
    var postcode = $("input#reg_postcode").val();
    var subjoin=1;
    var dataString= 'user=' + user + '&email=' + email + '&pass=' + pass + '&school=' + school + '&postcode=' + postcode + '&subjoin=' + subjoin;
    //alert (dataString);return false;

    $.ajax({
        type: "POST",
        url: "process.php",
        data: dataString,
        dataType: 'text',

        success: function(data) {
          if (data==0){
              //alert('none');
              $('#registerDialog').html("<div id='notify' style='font-family:arial;font-size:12px;color:#829f5e'></div>");
              $('#notify').html("<h2>Welcome to PE Planning</h2>")
              .append("We have sent your login details to your email.")
              .hide()
              .fadeIn(1500, function(){
                $('#notify').append("");
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
            $('#registerDialog').html("<div id='notify'></div>");
            $('#notify').html("<h2>Oops, there seems to be a problem</h2>")
            .append("<p>Please try again later.</p>")
            .hide()
            .fadeIn(1500, function() {
                $('#notify').append("<img id='checkmark' src='images/check.png' />");
            });
          }
       }// end of success
   }); // end of ajax
   return false;
});
});
runOnLoad(function(){
  //$("input#pass").select().focus();
  //$("input#email").select().focus();
  //$("input#user").select().focus();
});

// end of register --------------------------------------------------------------------------------
// EDITACCOUNT ---------------------------------------------------------------------------------------------

$(function() {
  $('.error').hide();
  $('input.text-input').css({backgroundColor:"#FFFFFF"});
  $('input.text-input').focus(function(){
    $(this).css({backgroundColor:"##eefacf"});
  });
  $('input.text-input').blur(function(){
    $(this).css({backgroundColor:"#FFFFFF"});
  });
  
  $(".buttona").click(function() {
		// validate and process form
		// first hide any error messages
    $('.error').hide();
    
    var dataString={
        curpass:$("input#curpass").val(),
        newpass:$("input#newpass").val(),
        first_name:$("input#first_name").val(),
        last_name:$("input#last_name").val(),
        school:$("input#school").val(),
        postcode:$("input#postcode").val(),
        email:$("input#my_email").val(),
        subedit:"1"
    }
    $.ajax({
        type: "POST",
        url: "process.php",
        data: dataString,
        dataType: 'text',

        success: function(data) {
            //alert(data);
          if (data == "success"){
              //alert('none');
              /*$('#accountDialog').html("<div id='message' style='font-family:arial;font-size:12px;color:#829f5e'></div>");
              $('#message').html("<h2>Changes Successfully Made</h2>")
              .append("Your account has been successfully updated")
              .hide()
              .fadeIn(1500, function(){
                $('#message').append("");
              });*/
              $('#message').css({'font-family':'arial','font-size':'12px','color':'#829f5e'});
              $('#message')
              .html("<br>Your account has been successfully updated<br>")
              .hide()
              .fadeIn(1500, function(){
                $('#message').append("");
              });
          }
          else{
            //alert('two');
            $('#accountDialog').html("<div id='message'></div>");
            $('#message').html("<h2>Oops, there seems to be a problem</h2>")
            .append("<p>Please try again later.</p>")
            .hide()
            .fadeIn(1500, function() {
                $('#message').append("<img id='checkmark' src='images/check.png' />");
            });
          }
       }// end of success
   }); // end of ajax
   return false;
});
});
runOnLoad(function(){
  //$("input#pass").select().focus();
  //$("input#email").select().focus();
  //$("input#user").select().focus();
});

// end of editaccount --------------------------------------------------------------------------------