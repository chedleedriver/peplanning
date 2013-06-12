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