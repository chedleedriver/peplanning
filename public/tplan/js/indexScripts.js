// mainScript.js
// version 1
// created 10/11/09
//The first section is for jquery intilization of the objects required
// this is the Ajax function to create the Ajax object
$(function() {
	$("#helpDialog").dialog({
				buttons: {  },
				modal:false,
				position:'top',
				width:600,
				minHeight:400,
				title:"Help",
				autoOpen:false
	 });

});
function getHTTPObject()
{
	if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
	else if (window.XMLHttpRequest) return new XMLHttpRequest();
	else {
		alert("Your browser does not support AJAX.");
		return null;
		}
}
function getSomeTopics(genreId)
{
//	if (document.getElementById('sel_genre').value) var genreId=document.getElementById('sel_genre').value; else var genreId=0;
        var levelId=document.getElementById('level').value;
    var objectName = getHTTPObject();
    	objectName.onreadystatechange = function() {
        	if (objectName.readyState==4) {
				document.getElementById('topic').innerHTML=objectName.responseText;
                                if (levelId==0){
                                    var levelCell="<h4><select name='numLessons' id='numLessons'>";
                                    for(i=1;i<=7;i++){
                                        levelCell=levelCell+"<option value='"+i+"'>"+i+"</option>";
                                    }
                                    levelCell=levelCell+"</select><br /></h4>";
                                }
                                else{
                                    var levelCell="<h4><select name='numLessons' id='numLessons'>";
                                    for(i=1;i<=12;i++){
                                        levelCell=levelCell+"<option value='"+i+"'>"+i+"</option>";
                                    }
                                    levelCell=levelCell+"</select><br /></h4>";
                                }
                                    document.getElementById('num_lessons_cell').innerHTML=levelCell;
                                
				}
    	};
    urlstring = "code/basefunctions.php?GetSomeTopics="+genreId+"&level="+levelId;
    objectName.open("GET", urlstring, true);
    objectName.send(null);
}
function getSomeGenres()
{
    var levelId=document.getElementById('level').value;
        var objectName = getHTTPObject();
    	objectName.onreadystatechange = function() {
        	if (objectName.readyState==4) {
				//document.getElementById('genre').innerHTML=objectName.responseText;
				}
    	};
    urlstring = "code/basefunctions.php?GetSomeGenres="+levelId;
    objectName.open("GET", urlstring, true);
    objectName.send(null);
}
function showButton(divNum)
{
		$("#questionDialogue").dialog('option', 'buttons', {"next": function() {okButtonPressed('questionDialogue',"questionDialogue",divNum + 1);}});
}
function getDisplayLevel(level)
{
	if (level==1){return "1";}
	if (level==1.5){return "1/2";}
	if (level==2){return "2";}
	if (level==2.5){return "2/3";}
	if (level==3){return "3";}
	if (level==3.5){return "3/4";}
	if (level==4){return "4";}
}
// these functions save the data back to the database via ajav calls to the main php function script

function takeAndShake(planType)
{
    if (planType=='demoPlan') samplePrintPlan();
    else {
    var saveTopicId=document.getElementById('sel_topic').value; // get the saved stuff
    var i=document.getElementById('sel_topic').selectedIndex;
    var saveTopic=document.getElementById('sel_topic').options[i].text;
    var saveDescription=document.getElementById('description').value;
    var saveNumLessons=document.getElementById('numLessons').value;
    var saveLevel=document.getElementById('level').value;
    var objectName="takeAndShake";
    if (saveLevel==99)
        {
            alert('You must select a level for your unit');
        }
   else if (saveTopic=='Select an Activity')
        {
            alert('You must select an activity for your unit');
        }
    else
        {
        objectName=getHTTPObject();
       objectName.onreadystatechange=function(){    
         if (objectName.readyState==4) {
             var dataArray=objectName.responseText.split('~');
            window.userLevel=dataArray[0];
            window.topicStatus=dataArray[2];
            if (planType=='newPlan'&&dataArray[2]=='R'&&dataArray[0]!=9){
                alert('You may only choose \'Print or Edit Pre-Designed Plans\' with this activity');
            }
            else {
            if (dataArray[1]=="good_to_go"){
                if(planType=='setPlan'&&saveNumLessons>=5){
                    if (saveTopicId==55) {saveNumLessons=7}
                    createDefaultUnit(saveTopicId,saveTopic,saveNumLessons,saveLevel,saveDescription);
                } else {
                    var unitId=saveUnitOfWork(saveTopicId,saveTopic,saveLevel,saveNumLessons,saveDescription,planType);
                }
            }
            else if (dataArray[1]=="not_logged_in"){
                alert('You must be registered and logged in to do this');
            }
            else if (dataArray[1]=="level_5_not_allowed"){
                alert('You do not have sufficient rights to do this, please contact your system administrator')
            }
            else if (dataArray[1]=="level_1_not_allowed"){
                if (saveLevel<=2){
                    alert('Please Select a Level for your Unit')
                }
                else {
                    alert('Please Select a Level for your Unit')
                }
            }
            }
            }
        };
        urlstring = "code/basefunctions.php?CanIDoThis="+saveTopicId; 
        objectName.open("GET", urlstring, true);
        objectName.send(null);
        }
    }
}
function trialNotification(){
    alert('As a free trial user your access is restricted to Lesson 1 only.\n\nPlease return to the home page to subscribe in full\n\nAre you the PE Coordinator?\n\nIf so contact matt@peplanning to get your full access PE Coordinator trial account today');
}
function createDefaultUnit(saveTopicId,saveTopic,saveNumLessons,saveLevel,saveDescription){
  //document.location=('myplans.php?createdefault=1&topic_id='+saveTopicId+'&topic='+saveTopic+'&num_lessons='+saveNumLessons+'&level='+saveLevel+'&description='+saveDescription);
    $('form')[0].reset();
    $('#doc').html("<div class='loading'>creating plan...</div>");
    var objectName="createDefaultUnit";
        objectName=getHTTPObject();
        objectName.onreadystatechange=function(){
           if (objectName.readyState==4) {
                document.location=("myplans.php");
        }
        };
    urlstring = 'code/basefunctions.php?CreateDefaultUnit2=1&topic_id='+saveTopicId+'&topic='+saveTopic+'&num_lessons='+saveNumLessons+'&level='+saveLevel+'&description='+saveDescription;
    objectName.open("GET", urlstring, true);
    objectName.send(null);
}
function sleep(ms)
	{
		var dt = new Date();
		dt.setTime(dt.getTime() + ms);
		while (new Date().getTime() < dt.getTime());
	}
function refreshMyPlansPage(responseData){
                        $('#accordion2').html(responseData);
                        $('#accordion2').accordion('destroy').accordion({
                                autoHeight: false,
                                collapsible: true,
                                active: 0,
                                header: 'h4',
                                icons: {'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s'},
                                animated: 'bounceslide',
                                navigation: true,
                                clearStyle: true,
                               alwaysOpen: false
                                });
}
function saveUnitOfWork(saveTopicId,saveTopic,saveLevel,saveNumLessons,saveDescription,planType)
{
        if (planType=='setPlan') originalPlanType='s'; else originalPlanType='c';
        var objectName="saveUnit";
	    objectName = getHTTPObject();
    	objectName.onreadystatechange = function() {
        	if (objectName.readyState==4) {
                        if (objectName.responseText!="not_logged_in"){
				unitId=objectName.responseText;
				document.location=('http://'+top.location.host+'/tplan/Lessons.php?unit_id='+unitId+'&plan_type='+planType);
                        }
                        else {
                            document.location=('/tplan/signin.php');
                        }
        		}
    	};
    urlstring = "code/basefunctions.php?SaveUnitofWork=save&topic_id=" + saveTopicId + "&topic=" + saveTopic + "&level_id=" + saveLevel + "&num_lessons=" + saveNumLessons + "&description=" + saveDescription + "&plan_type=" + originalPlanType;
    objectName.open("GET", urlstring, true);
    objectName.send(null);
}
function printPlan(planId,unitId) {
    document.location=('code/plan_print.php?lesson_id=' + planId + '&unit_id=' + unitId);
}
function mainPrintPlan(planNum,unitId) {
   if (planNum==0)
        {
            var $tabs=$('#tabs').tabs();
            planNum=$tabs.tabs('option', 'selected')+1;
         }
    if (window.numLessons==1) planNum=1;
    var lessonDiv= $('#lesson_title_'+unitId+'_'+planNum).html();
    $('#lesson_title_'+unitId+'_'+planNum).html("<div class='loading'>preparing plan for printing...</div>");
    var objectName="plan_print";
	objectName = getHTTPObject();
    	if (moz){
    		objectName.onload = objectName.onerror = objectName.onabort = function(){
		//alert (objectName.responseText);
                $('#lesson_title_'+unitId+'_'+planNum).html(lessonDiv);
		eval(objectName.responseText)
                };
    		} else
                {
		objectName.onreadystatechange = function() {
        	if (objectName.readyState==4) {
                    //alert (objectName.responseText);
                   $('#lesson_title_'+unitId+'_'+planNum).html(lessonDiv);
                    eval(objectName.responseText);
                     }
    		};
	}
    //window.goLocation=('code/plan_print.php?lesson_num=' + planNum + '&unit_id=' + unitId);
    urlstring = 'code/main_plan_print.php?lesson_num=' + planNum + '&unit_id=' + unitId;
    objectName.open("GET", urlstring, false);
    objectName.send(null);
}  
function samplePrintPlan() {
    $('#print-it').html("<div class='loading'>preparing plan for printing...</div>");
    var objectName="plan_print";
	objectName = getHTTPObject();
    	if (moz){
    		objectName.onload = objectName.onerror = objectName.onabort = function(){
		//alert (objectName.responseText);
                $('#print-it').html("<div>The plan generated was a sample lesson plan not based on the information you entered.</div>");
		eval(objectName.responseText)
                };
    		} else
                {
		objectName.onreadystatechange = function() {
        	if (objectName.readyState==4) {
                $('#print-it').html("<div>The plan generated was a sample lesson plan not based on the information you entered.</div>");
                    eval(objectName.responseText);
                     }
    		};
	}
    urlstring = "lesson_sample.php?topic=demo";
    objectName.open("GET", urlstring, false);
    objectName.send(null);
}
function mainPrintAssessment(VarAssess,VarTopic,VarLevel,VarUnit) {
    //alert('Assess: ' + VarAssess + '&Topic: ' + VarTopic + '&VarLevel: '+ VarLevel );
    if ((VarLevel==0)&&(VarAssess!=3)) alert("This area is not available for foundation units of work. You can still complete the teacher assessment for your class by clicking on the link");
    else document.location=('/tplan/code/assessment_print.php?assess_id='+ VarAssess + '&topic_id='+ VarTopic + '&level_id=' + VarLevel + '&unit_id=' + VarUnit);
}
function AssessType(assessType) {
    var myAssessType = assessType;
    alert(myAssessType);
    //document.location=('/code/basefunctions.php?myAssessType='+ myAssessType);
}

// main scripts
function editPlan(planId,planType)
{
	window.open('Lessons.php?unit_id='+planId+'&plan_type='+planType);
}
// These functions had to be defined for Firefox
function login() {
	$('#loginDialog').dialog('open');
}
function editAccount(user) {
	var objectName="editAccount";
	    objectName = getHTTPObject();
    	objectName.onreadystatechange = function() {
        	if (objectName.readyState==4) {
                    myAccountSettings=objectName.responseText.split(",");
                    document.getElementById('first_name').value=myAccountSettings[0];
                    document.getElementById('last_name').value=myAccountSettings[1];
                    document.getElementById('school').value=myAccountSettings[2];
                    document.getElementById('postcode').value=myAccountSettings[3];
                    document.getElementById('my_email').value=myAccountSettings[4];
                    $('#accountDialog').dialog('open');
                }
    	};
    urlstring = "code/basefunctions.php?EditUser="+user;
    objectName.open("GET", urlstring, true);
    objectName.send(null);
}
function register() {
	$('#registerDialog').dialog('open');
}
function forgotPassword() {
	$('#passwordDialog').dialog('open')
}
function contactUs() {
	$('#contactDialog').dialog('open');
}
function helpMe(withWhat) {
	$('#informationDialog').dialog('option','title',withWhat);
	document.getElementById('informationDialog').innerHTML="";
	$('#informationDialog').dialog('open');
}
function systemChanges(changeId) {
	$('#changelogDialog').dialog('open');
}
function browserInformation(browserShort,browserFull) {
	$('#informationDialog').dialog('option','title',browserFull);
	document.getElementById('informationDialog').innerHTML="";
	document.getElementById('informationDialog').appendChild(document.getElementById(browserShort));
	$('#informationDialog').dialog('open');
}
function deletePlan(planId) {
	if (confirm('Are you sure you want to delete this Unit - This cannot be undone!')){
	var objectName = getHTTPObject();
	objectName.onreadystatechange = function() {
       	if (objectName.readyState==4) {
                         $('#accordion2').html(objectName.responseText);
                         $('#accordion2').accordion('destroy').accordion({
                                autoHeight: false,
                                collapsible: true,
                                active: 0,
                                header: 'h4',
                                icons: {'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s'},
                                animated: 'bounceslide',
                                navigation: true,
                                clearStyle: true,
                                alwaysOpen: false
                                });
			}
    	};
    urlstring = "code/basefunctions.php?DeletePlan=" + planId;
    objectName.open("GET", urlstring, true);
    objectName.send(null);
    }
}
function deletePlanFromAll(planId) {
	if (confirm('Are you sure you want to delete this Unit - This cannot be undone!')){
	var objectName = getHTTPObject();
	objectName.onreadystatechange = function() {
       	if (objectName.readyState==4) {
			 var dataArray=objectName.responseText.split('~');
                         $('#accordion2').html(dataArray[0]);
                         $('#accordion2').accordion('destroy').accordion({
                                autoHeight: false,
                                collapsible: true,
                                active: false,
                                header: 'h4',
                                icons: {'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s'},
                                animated: 'bounceslide',
                                navigation: true,
                                clearStyle: true,
                                alwaysOpen: false
                                });
                         $('#accordion3').html(dataArray[1]);
                         $('#accordion3').accordion('destroy').accordion({
                                   autoHeight: false,
                                   collapsible: true,
                                   active: false,
                                   header: 'h4',
                                   icons: {'header': 'ui-icon-circle-arrow-e', 'headerSelected': 'ui-icon-circle-arrow-s'},
                                   animated: 'bounceslide',
                                   navigation: true,
                                   clearStyle: true,
                                   alwaysOpen: false
                    });
			}
    	};
    urlstring = "code/basefunctions.php?DeletePlanFromAll=" + planId;
    objectName.open("GET", urlstring, true);
    objectName.send(null);
    }
}
function getCookie(c_name)
{
if (document.cookie.length>0)
  {
  c_start=document.cookie.indexOf(c_name + "=");
  if (c_start!=-1)
    {
    c_start=c_start + c_name.length+1;
    c_end=document.cookie.indexOf(";",c_start);
    if (c_end==-1) c_end=document.cookie.length;
    return unescape(document.cookie.substring(c_start,c_end));
    }
  }
return "";
}
function logOut()
{
    if (confirm('Are you sure you want to Exit?')){
	objectName = getHTTPObject();
	objectName.onreadystatechange = function() {
       	if (objectName.readyState==4) {
            document.location('main.php');
                        /*document.getElementById('login').innerHTML=objectName.responseText;
                        $('#accordion2').html('<td width=350 align="left"><br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<h6>In order to edit, delete and print your plans you first need to sign in to PE PLANNING.</h6><br/><img src="index_files/prinscreen.jpg"/></td>'); //this is the section where GetMyUnits is to be displayed
                        $('#page-feature-assessment').html("<table><tr><td><input type='image' src='index_files/class.jpg' class='ui-button'/></td><td><h3><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Class Assessment</h3></td></tr><tr><td><input type='image' src='index_files/individual.jpg' class='ui-button'/></td><td><h3><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Individual Assessment</h3></td></tr><tr><td><input type='image' src='index_files/teacher.jpg' class='ui-button'/></td><td><h3><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Teacher Assessment</h3></td></tr></table>");
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
                                htmlString="<a style='font-family:arial;font-size:12px' href='#'>"+user+"&nbsp;|&nbsp</a><a style='font-family:arial;font-size:12px' href='#' onclick='javascript:editAccount(\""+user+"\")'>my account&nbsp;|&nbsp</a><a style='font-family:arial;font-size:12px' href='javascript:logOut()'>&nbsp;sign out</a>"
                                if (userlevel=="9") htmlString="<a style='font-family:arial;font-size:12px' href='admin/admin.php'>admin&nbsp;|&nbsp</a>"+htmlString;
                                $('#login').html(htmlString).fadeIn(1500,
                                function() {
                                $('#login').show()
                                });

                                // load signedin content for tab2
                                $.get("tab2.php", function(data){
                                    $('#accordion2').html(data); //GetMyUnits are to be displayed
                                }); // end get function

                                // load signedin content for tab3
                                $.get("assessment_tab.php", function(data){
                                    $('#page-feature-assessment').html(data); // assessment icons are to be displayed
                                });
                                }}
                        }); //ends ajax function
                        return false;
                     }); //ends .button click function
                  }); // ends the 'main'imout' initial function
                    */
            }
    	};
	urlstring = "process.php";
    objectName.open("GET", urlstring, true);
    objectName.send(null);
	}
}
function showHelpDialog(helpTopic)
{
        if (helpTopic=="steps") helpSubtitle="Creating a Unit of Work";
        else if (helpTopic=="exit") helpSubtitle="Save, Print & Exit";
        else if (helpTopic=="allassessments") helpSubtitle="All Assessments";
        else if (helpTopic=="allplans") helpSubtitle="All Plans";
        else helpSubtitle=helpTopic;
        var helpTitle=capitalizeMe("This is what you do with "+helpSubtitle);
        var divToFillId=document.getElementById('helpDialog');
	var objectName="helpObject";
	    objectName = getHTTPObject();
    	objectName.onreadystatechange = function() {
        	if (objectName.readyState==4) {
				divToFillId.innerHTML=objectName.responseText;
				divToFillId.style.visibility='visible';
        		}
    	};
    urlstring = "code/basefunctions.php?GetHelp=" + helpTopic;
    objectName.open("GET", urlstring, true);
    objectName.send(null);
        $('#helpDialog').dialog('option', 'title', helpTitle);
	$('#helpDialog').dialog('open');
}
function capitalizeMe(obj) {
        val = obj;
        newVal = '';
        val = val.split(' ');
        for(var c=0; c < val.length; c++) {
                newVal += val[c].substring(0,1).toUpperCase() +
val[c].substring(1,val[c].length) + ' ';
        }
        return(newVal);
}
function debug(obj)
{console.log(obj)}

//initialization, browser, os detection
var d, dom, nu='', brow='', ie, ie4, ie5, ie5x, ie6, ie7;
var ns4, moz, moz_rv_sub, release_date='', moz_brow, moz_brow_nu='', moz_brow_nu_sub='', rv_full='';
var mac, win, old, lin, ie5mac, ie5xwin, konq, saf, op, op4, op5, op6, op7;

d=document;
n=navigator;
nav=n.appVersion;
nan=n.appName;
nua=n.userAgent;
old=(nav.substring(0,1)<4);
mac=(nav.indexOf('Mac')!=-1);
win=( ( (nav.indexOf('Win')!=-1) || (nav.indexOf('NT')!=-1) ) && !mac)?true:false;
lin=(nua.indexOf('Linux')!=-1);
// begin primary dom/ns4 test
// this is the most important test on the page
if ( !document.layers )
{
	dom = ( d.getElementById ) ? d.getElementById : false;
}
else {
	dom = false;
	ns4 = true;// only netscape 4 supports document layers
}
// end main dom/ns4 test

op=(nua.indexOf('Opera')!=-1);
saf=(nua.indexOf('Safari')!=-1);
konq=(!saf && (nua.indexOf('Konqueror')!=-1) ) ? true : false;
moz=( (!saf && !konq ) && ( nua.indexOf('Gecko')!=-1 ) ) ? true : false;
ie=((nua.indexOf('MSIE')!=-1)&&!op);
if (op)
{
	str_pos=nua.indexOf('Opera');
	nu=nua.substr((str_pos+6),4);
	brow = 'Opera';
}
else if (saf)
{
	str_pos=nua.indexOf('Safari');
	nu=nua.substr((str_pos+7),5);
	brow = 'Safari';
}
else if (konq)
{
	str_pos=nua.indexOf('Konqueror');
	nu=nua.substr((str_pos+10),3);
	brow = 'Konqueror';
}
// this part is complicated a bit, don't mess with it unless you understand regular expressions
// note, for most comparisons that are practical, compare the 3 digit rv nubmer, that is the output
// placed into 'nu'.
else if (moz)
{
	// regular expression pattern that will be used to extract main version/rv numbers
	pattern = /[(); \n]/;
	// moz type array, add to this if you need to
	moz_types = new Array( 'Firebird', 'Phoenix', 'Firefox', 'Iceweasel', 'Galeon', 'K-Meleon', 'Camino', 'Epiphany', 'Netscape6', 'Netscape', 'MultiZilla', 'Gecko Debian', 'rv' );
	rv_pos = nua.indexOf( 'rv' );// find 'rv' position in nua string
	rv_full = nua.substr( rv_pos + 3, 6 );// cut out maximum size it can be, eg: 1.8a2, 1.0.0 etc
	// search for occurance of any of characters in pattern, if found get position of that character
	rv_slice = ( rv_full.search( pattern ) != -1 ) ? rv_full.search( pattern ) : '';
	//check to make sure there was a result, if not do  nothing
	// otherwise slice out the part that you want if there is a slice position
	( rv_slice ) ? rv_full = rv_full.substr( 0, rv_slice ) : '';
	// this is the working id number, 3 digits, you'd use this for
	// number comparison, like if nu >= 1.3 do something
	nu = rv_full.substr( 0, 3 );
	for (i=0; i < moz_types.length; i++)
	{
		if ( nua.indexOf( moz_types[i]) !=-1 )
		{
			moz_brow = moz_types[i];
			break;
		}
	}
	if ( moz_brow )// if it was found in the array
	{
		str_pos=nua.indexOf(moz_brow);// extract string position
		moz_brow_nu = nua.substr( (str_pos + moz_brow.length + 1 ) ,3);// slice out working number, 3 digit
		// if you got it, use it, else use nu
		moz_brow_nu = ( isNaN( moz_brow_nu ) ) ? moz_brow_nu = nu: moz_brow_nu;
		moz_brow_nu_sub = nua.substr( (str_pos + moz_brow.length + 1 ), 8);
		// this makes sure that it's only the id number
		sub_nu_slice = ( moz_brow_nu_sub.search( pattern ) != -1 ) ? moz_brow_nu_sub.search( pattern ) : '';
		//check to make sure there was a result, if not do  nothing
		( sub_nu_slice ) ? moz_brow_nu_sub = moz_brow_nu_sub.substr( 0, sub_nu_slice ) : '';
	}
	if ( moz_brow == 'Netscape6' )
	{
		moz_brow = 'Netscape';
	}
	else if ( moz_brow == 'rv' || moz_brow == '' )// default value if no other gecko name fit
	{
		moz_brow = 'Mozilla';
	}
	if ( !moz_brow_nu )// use rv number if nothing else is available
	{
		moz_brow_nu = nu;
		moz_brow_nu_sub = nu;
	}
	if (n.productSub)
	{
		release_date = n.productSub;
	}
}
else if (ie)
{
	str_pos=nua.indexOf('MSIE');
	nu=nua.substr((str_pos+5),3);
	brow = 'Microsoft Internet Explorer';
}
// default to navigator app name
else
{
	brow = nan;
}
op5=(op&&(nu.substring(0,1)==5));
op6=(op&&(nu.substring(0,1)==6));
op7=(op&&(nu.substring(0,1)==7));
op8=(op&&(nu.substring(0,1)==8));
op9=(op&&(nu.substring(0,1)==9));
ie4=(ie&&!dom);
ie5=(ie&&(nu.substring(0,1)==5));
ie6=(ie&&(nu.substring(0,1)==6));
ie7=(ie&&(nu.substring(0,1)==7));
// default to get number from navigator app version.
if(!nu)
{
	nu = nav.substring(0,1);
}
/*ie5x tests only for functionavlity. dom or ie5x would be default settings.
Opera will register true in this test if set to identify as IE 5*/
ie5x=(d.all&&dom);
ie5mac=(mac&&ie5);
ie5xwin=(win&&ie5x);
//if (ie)	loadScript('http://blog.monstuff.com/archives/images/XHR-Debugging-IE.js');

