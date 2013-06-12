<? include ("basefunctions.php"); // some functions to save the unit and get lists of plans etc.
//include ("session.php"); //this is to check they are logged in, you will need this to get the login working
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html dir="ltr" xml:lang="en-GB" xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=7" />
        <title>PE Planning | peplanning.org.uk</title>

        <link rel="stylesheet" type="text/css" href="/tplan/css/peplanning/jquery-ui-1.7.3.custom.css"/>
        <link rel="stylesheet" type="text/css" href="index_files/maincss.css" media="screen"/>
        
        <script type="text/javascript">
        /* google analytics */
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-16957975-1']);
        _gaq.push(['_trackPageview']);

        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        </script>
    </head>

    <body id="central" class="portal-page locale-en-GB portal-page js platform-windows">
    <script type="text/javascript" src="/tplan/js/jquery-1.3.2.min.js"></script>
    <script type="text/javascript" src="/tplan/js/jquery-ui-1.7.2.custom.min.js"></script>
    <script type="text/javascript" src="index_files/login/js/logreg_1.js"></script>
    <script type="text/javascript" src="/tplan/js/mainScripts.js"></script>
    <script type="text/javascript" src="index_files/utilities.js"></script>
    <script type="text/javascript" src="index_files/sean-pager.htm"></script>
<script type="text/javascript">
$(function() {
	$("#registerDialog").dialog({
				modal:true,
				width:300,
                                height:250,
				dialogClass:'pager-tabs',
                                bgiframe: true,
				autoOpen:false
	 });
});
$(function() {
	$("#passwordDialog").dialog({
				modal:true,
				width:300,
                                height:250,
				dialogClass:'pager-tabs',
                                bgiframe: true,
				autoOpen:false
	 });
});
$(function() {
	$("#accountDialog").dialog({
				modal:true,
				width:300,
                                height:250,
				dialogClass:'pager-tabs',
                                bgiframe: true,
				autoOpen:false
	 });
});
$(function() {
	$('#genreList').accordion({
			autoHeight: false,
			collapsible: true,
			header: 'h3',
			active: false
			 });
});

function clearinputText() {
      document.sform.user.value= "";
}
</script>
   <div id="wrapper">
      <div id="doc">
         <div id="main-feature" style="position:absolute;top:0px;left:25px">
             <img src="index_files/bnb_logo.jpg" alt="logo" />
         </div>
        <div id="login" style="position:absolute;top:90px;right:50px;z-index:1">
            <form id="login_form" method="post" action="">
                             <table width="400">
                                <tr>
                                    <td >
                                        <input type="text" name="userlog" id="userlog" size="12" value="username" onfocus="this.value='';this.style.color='#829f5e'" style="font-family:arial;font-size:12px;color:#b7cc99"/>
                                   </td>
                                   <td >
                                        <input type="text" name="passlog" id="passlog" size="12" value="password"  onfocus="this.value='';this.type='password';this.style.color='#829f5e'" style="font-family:arial;font-size:12px;color:#b7cc99" />
                                    </td>
                                    <td>
                                        <a href="#" onclick="javascript:document.login_form.submit()" style="font-family:arial;font-size:12px" class="buttonlog">sign in&nbsp;|</a><a href="#" onclick="javascript:register()" style="font-family:arial;font-size:12px">&nbsp;register</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="errorlog" for="userlog" id="userlog_error">This field is required.</label>
                                        <label class="errorlog" for="userlog" id="userlog_error2">username incorrect or</label>
                                    </td>
                                    <td colspan="2">
                                        <label class="errorlog" for="passlog" id="passlog_error">This field is required.</label>
                                        <label class="errorlog" for="passlog" id="passlog_error2">password incorrect.</label>
                                    </td>
                                </tr>
                              </table>
                             </form>
        </div>
        <div style="position:absolute;top:110px;right:15px;z-index:1">
            <!--<img src="index_files/underline.jpg" alt="logo" />-->
        </div>
        <!-- pagination -->
        <div id="gettingstarted-feature" class="pager pager-with-tabs" style="position:absolute;top:150px;left:25px">

    	<ul id="gettingstarted-nav" class="pager-tabs">
            <li id="plan-link" class="first"><a href="#feature-plan">Let's get going</a></li>
            <li id="plans-link" class="selected"><a href="#feature-plans">Plans</a></li>
            <li id="assessment-link" class="last"><a href="#feature-assessment">Assessment </a></li>
        </ul>

        <!-- Tabbed Pages content - dynamically add or subtract pages -->

	<div class="pager-content">

	<!-- tab 1 - select lessons -->

        <div style="display: none;" class="gettingstarted-feature-contents" id="feature-plan">

		<div class="col2">

                <form id="myform" method="post" action="">
                    <table>
                        <tr>
                            <td>
                                <h3>Step1.&nbsp;&nbsp;</h3>
                            </td>
                            <td>
                                <h4> Enter the number of lessons to be delivered in this unit of work:&nbsp;&nbsp;</h4>
                            </td>
                            <td>
                                <h4><select name="numLessons" id="numLessons">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option></select><br />
                                </h4></td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td>
                                <h3>Step2.&nbsp;&nbsp;</h3>
                            </td>
                            <td>
                                <h4>At what National Curriculum level are you going to teach this unit of work?&nbsp;&nbsp;</h4>
                            </td>
                            <td>
                                <h4>
                                    <select name="level" id="level">
                                        <option value="1.0">Level 1</option>
                                        <option value="1.5">Level 1/2</option>
                                        <option value="2.0">Level 2</option>
                                        <option value="2.5">Level 2/3</option>
                                        <option value="3.0">Level 3</option>
                                        <option value="3.5">Level 3/4</option>
                                        <option value="4.0">Level 4</option>
                                    </select><br />
                                </h4>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr valign="middle">
                            <td>
                                <h3>Step3.&nbsp;&nbsp;</h3>
                            </td>
                            <td>
                                <h4>Give your unit of work a title: eg. Class 3A Hockey:&nbsp;&nbsp;</h4>
                            </td>
                            <td>
                                <h4>
                                    <input type="text" size="12" maxlength="50" name="description" id="description"/><br />
                                </h4>
                            </td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td>
                                <h3>Step4.&nbsp;&nbsp;</h3>
                            </td>
                            <td>
                                <h4> Select an activity:&nbsp;&nbsp;</h4>
                            </td>
                            <td>
                                <h4>
                                    <select name="genre" id="genre" size="1" onchange="getSomeTopics()">
                                    <option value="0">Select an Activity Type</option>
                                    <? GetGenres()?>
                                    </select><br/>
                                </h4>
                            </td>
                            <td>
                                <h4>
                                    <select name="topic" id ="topic" size="1">
                                        <option value=" " selected="selected">Please select an Activity Type first</option>
                                    </select>
                                </h4>
                            </td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td><br><br><br><a href="javascript:takeAndShake('setPlan');"><img src="index_files/preset_btn.gif"></a>
                            </td>
                            <td><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:takeAndShake('newPlan');"><img src="index_files/custom_btn.gif"></a>
                            </td>
                        </tr>
                    </table>
                </form>
                </div>
                <div id="registerDialog" style="display:none">
                <!--<div id="contact_form">-->
                    <form id="signup" action="" method="post">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="left" valign="top">
                                 <input type="text" name="user" id="user" size="30" value="username" class="text-inputlog" onfocus="this.value='';this.style.color='#829f5e'" style="font-family:arial;font-size:12px;color:#b7cc99"/>
                                  <label class="error" for="user" id="user_error">This field is required.</label>
                                  <label class="error" for="user" id="user_error2">This username is in use.</label>
                            </td>
                        </tr>
                        <tr>
                            <td align ="left" valign="top">
                                <input type="text" name="email" id="email" size="30" value="email" class="text-inputlog" onfocus="this.value='';this.style.color='#829f5e'" style="font-family:arial;font-size:12px;color:#b7cc99"/>
                                <label class="error" for="email" id="email_error">This field is required.</label>
                                <label class="error" for="email" id="email_error2">Please enter a valid email.</label>
                            </td>
                        </tr>
                        <tr align="center">
                            <td align ="left" valign="top">
                                <input type="text" name="pass" id="pass" size="30" value="password" class="text-inputlog" onfocus="this.value='';this.type='password';this.style.color='#829f5e'" style="font-family:arial;font-size:12px;color:#b7cc99"/>
                                <label class="error" for="pass" id="pass_error">This field is required</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <input type="hidden" name="subjoin" value="1" />
                                <a href="#" onclick="javascript:document.signup.submit()" style="font-family:arial;font-size:14px" class="buttonr">sign up</a
                                <!--<input type="image" src="index_files/signup.jpg" value="sign up" class="buttonr" name="submit" id="submit_btn"/>-->
                            </td>
                        </tr>
                    </table>
                    </form>
</div>
<div id="accountDialog" style="display:none">
                <!--<div id="contact_form">-->
                    <form id="signup" action="" method="post">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="left" valign="top">
                                 <input type="text" name="user" id="user" size="30" value="username" class="text-inputlog" onfocus="this.value='';this.style.color='#829f5e'" style="font-family:arial;font-size:12px;color:#b7cc99"/>
                                  <label class="error" for="user" id="user_error">This field is required.</label>
                                  <label class="error" for="user" id="user_error2">This username is in use.</label>
                            </td>
                        </tr>
                        <tr>
                            <td align ="left" valign="top">
                                <input type="text" name="email" id="email" size="30" value="email" class="text-inputlog" onfocus="this.value='';this.style.color='#829f5e'" style="font-family:arial;font-size:12px;color:#b7cc99"/>
                                <label class="error" for="email" id="email_error">This field is required.</label>
                                <label class="error" for="email" id="email_error2">Please enter a valid email.</label>
                            </td>
                        </tr>
                        <tr align="center">
                            <td align ="left" valign="top">
                                <input type="text" name="pass" id="pass" size="30" value="password" class="text-inputlog" onfocus="this.value='';this.type='password';this.style.color='#829f5e'" style="font-family:arial;font-size:12px;color:#b7cc99"/>
                                <label class="error" for="pass" id="pass_error">This field is required</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <input type="hidden" name="subjoin" value="1" />
                                <a href="#" onclick="javascript:document.signup.submit()" style="font-family:arial;font-size:14px" class="buttonr">sign up</a
                                <!--<input type="image" src="index_files/signup.jpg" value="sign up" class="buttonr" name="submit" id="submit_btn"/>-->
                            </td>
                        </tr>
                    </table>
                    </form>
</div>
<div id="passwordDialog" style="display:none">
                <!--<div id="contact_form">-->
                    <form id="signup" action="" method="post">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="left" valign="top">
                                 <input type="text" name="user" id="user" size="30" value="username" class="text-inputlog" onfocus="this.value='';this.style.color='#829f5e'" style="font-family:arial;font-size:12px;color:#b7cc99"/>
                                  <label class="error" for="user" id="user_error">This field is required.</label>
                                  <label class="error" for="user" id="user_error2">This username is in use.</label>
                            </td>
                        </tr>
                        <tr>
                            <td align ="left" valign="top">
                                <input type="text" name="email" id="email" size="30" value="email" class="text-inputlog" onfocus="this.value='';this.style.color='#829f5e'" style="font-family:arial;font-size:12px;color:#b7cc99"/>
                                <label class="error" for="email" id="email_error">This field is required.</label>
                                <label class="error" for="email" id="email_error2">Please enter a valid email.</label>
                            </td>
                        </tr>
                        <tr align="center">
                            <td align ="left" valign="top">
                                <input type="text" name="pass" id="pass" size="30" value="password" class="text-inputlog" onfocus="this.value='';this.type='password';this.style.color='#829f5e'" style="font-family:arial;font-size:12px;color:#b7cc99"/>
                                <label class="error" for="pass" id="pass_error">This field is required</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <input type="hidden" name="subjoin" value="1" />
                                <a href="#" onclick="javascript:document.signup.submit()" style="font-family:arial;font-size:14px" class="buttonr">sign up</a
                                <!--<input type="image" src="index_files/signup.jpg" value="sign up" class="buttonr" name="submit" id="submit_btn"/>-->
                            </td>
                        </tr>
                    </table>
                    </form>
</div>
        </div> <!-- end pager content -->

        <!-- tab 2 - plans -->
        <div style="display:none;" class="gettingstarted-feature-contents" id="feature-plans">
            <div class="col2">
                <div id="accordion2" class="basic">
                    <label class="error">You must be logged in to see your plans</label>
                </div>
            </div>
    	</div>

	<!-- tab 3 - assessment -->
        <div style="display:none;" class="gettingstarted-feature-contents2" id="feature-assessment">
             <div class="col3">
                 <div id="assessment" class="basic">
                 <? //if($session->logged_in)
                    echo("<table>
                        <tr><td><a href=\"myAssessments.php?assessType=1\"><input type=\"image\" src=\"index_files/class.jpg\"  class=\"ui-button\" onclick=\"document.location='/myAssessments.php?assessType=1';\"/></a></td><td><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Class Assessment</h3></td></tr>
                        <tr><td><a href=\"myAssessments.php?assessType=2\"><input type=\"image\" src=\"index_files/individual.jpg\"  class=\"ui-button\" onclick=\"document.location='/myAssessments.php?assessType=2';\"/></a></td><td><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Individual Assessment</h3></td></tr>
                        <tr><td><a href=\"\"><input type=\"image\" src=\"index_files/teacher.jpg\" class=\"ui-button\" onclick=\"\"/></a></td><td><h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teacher Assessment (Coming Soon)</h3></td></tr>
                        </table>");
                 ?>
                 </div>
             </div>
    	</div><!-- end tab3-->
</div> <!-- end #pagination -->
        </div>
        <div style="position:absolute;top:750px;left:25px">
        <table  background="index_files/footer.png" width="100%" align="center">
            <tr>
                <td>
                    <br></br>
                        <table width=1000 height=266  align="center" border=0 >
                            <tr align="left">
                                <td valign="top">
                                    <img src="index_files/contact_link.gif"></img><br></br>
                                        <h5>T. 01274 777 800
                                        </h5>
                                            <a href="mailto:sales@peplanning.org.uk">
                                        <h5>E. sales@peplanning.org.uk</a>
                                        </h5>
                                </td>
                </td>
                <td valign="top">
                    <img src="index_files/latest_link.gif"></img>
                    <br>
                        <a href=""><h5> </a></h5>
                        <a href=""><h5> </a></h5>
                        <a href=""><h5> </a></h5>
                        <a href=""><h5> </a></h5>
                        <a href=""><h5> </a></h5>
                        <a href=""><h5> </a></h5>
                </td>
                <td valign="top">
                    <img src="index_files/nc_link.gif"></img>
                    <br>
                    <a href="http://curriculum.qcda.gov.uk/key-stages-1-and-2/subjects/physical-education/keystage1/index.aspx" TARGET="_blank"><h5>Current NCPE Key stage 1</a></h5>
                    <a href="http://curriculum.qcda.gov.uk/key-stages-1-and-2/subjects/physical-education/keystage2/index.aspx" TARGET="_blank"><h5>Current NCPE Key stage 2</a></h5>
                </td>

                <td valign="top">
                    <img src="index_files/links_link.gif"></img><br></br>
                    <a href="http://www.sportsuk.org.uk" TARGET="_blank"><h5>Sports UK Ltd</a></h5>
                    <a href="http://www.education.gov.uk" TARGET="_blank"><h5>Department for Education (DfE)</a></h5>
                    <a href="http://www.qcda.gov.uk" TARGET="_blank"><h5>QCDA</a></h5>
                    <a href="http://www.itfacilitas.co.uk" TARGET="_blank"><h5>IT Facilitas</a></h5>
                </td>
          </tr>
          <table width=1000 height=10 align="center" border=0>
              <tr align="left">
                <td valign="bottom">
                  <a href="http://www.itfacilitas.co.uk" TARGET="_blank">Powered by IT Facilitas</a>
                </td>
                <td align="right" valign="bottom">
                    Copyright PEPLANNING 2010. All rights reserved.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
              </tr>
          </table>
    </table>
    </div>
    </div>
    </div>

    <!--<script type="text/javascript" src="index_files/utilities.js"></script>
    <script type="text/javascript" src="index_files/sean-pager.htm"></script>-->
</div>
</body>
</html>