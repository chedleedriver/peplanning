function closeIt(what)
{
    $('#'+what).overlay().close();
    var loc=location.pathname;
    var pathArr = loc.split('?');
    if (pathArr[0]) loc = pathArr[0];
    if((loc=='/createaplan')||(loc=='/auth/login')) location.replace("http://" + location.host + "/");
    if((loc=='/auth/edituser')||(loc=='/auth/password')) location.replace("http://" + location.host + "/staffroom");
    if(what=='usercheck_div') location.replace("http://" + location.host + "/auth/unify?link=no");
}
function passwordFocus(from)
{
    if(from=='register') {var clearField='#password_reg_clear'; var passField='#password_reg';}
    if(from=='subscribe') {var clearField='#password_subscribe_clear'; var passField='#password_subscribe';}
    if(from=='login') {var clearField='#password_clear'; var passField='#password';}
    if(from=='change') {var clearField='#password_clear_change'; var passField='#password_change';}
    if(from=='change_new') {var clearField='#new_password_clear_change'; var passField='#new_password_change';}
    if(from=='change_confirm') {var clearField='#confirm_password_clear_change'; var passField='#confirm_password_change';}
    $(clearField).hide();
    $(passField).show();
    $(passField).focus();
}
function passwordBlur(from)
{
    if(from=='register') {var clearField='#password_reg_clear'; var passField='#password_reg';}
    if(from=='subscribe') {var clearField='#password_subscribe_clear'; var passField='#password_subscribe';}
    if(from=='login') {var clearField='#password_clear'; var passField='#password';}
    if(from=='change') {var clearField='#password_clear_change'; var passField='#password_change';}
    if(from=='change_new') {var clearField='#new_password_clear_change'; var passField='#new_password_change';}
    if(from=='change_confirm') {var clearField='#confirm_password_clear_change'; var passField='#confirm_password_change';}
     if($(passField).val() == '') {
        $(clearField).show();
        $(passField).hide();
    }

}

function disableCtrlKeyCombination(e)
{
        //list all CTRL + key combinations you want to disable
        var forbiddenKeys = new Array('a', 'n', 'c', 'x', 'v', 'j');
        var key;
        var isCtrl;
        if(window.event)
        {
                key = window.event.keyCode;     //IE
                if(window.event.ctrlKey)
                        isCtrl = true;
                else
                        isCtrl = false;
        }
        else
        {
                key = e.which;     //firefox
                if(e.ctrlKey)
                        isCtrl = true;
                else
                        isCtrl = false;
        }
        //if ctrl is pressed check if other key is in forbidenKeys array
        if(isCtrl)
        {
                for(i=0; i<forbiddenKeys.length; i++)
                {
                        //case-insensitive comparation
                        if(forbiddenKeys[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
                        {
                                return false;
                        }
                }
        }
        return true;
}
function pauseComp(ms) 
{
    ms += new Date().getTime();
    while (new Date() < ms){}
} 
/*----- STAFFROOM ------------------------------------------------------------*/


function getJQLessons(getWhat,getDesc,getLevel,getTopic,getNumLessons,getScrollNum)
{
    $.ajax({
        url:"/staffroom/show-Lessons",
        data:{unit_id:getWhat,unit_description:getDesc,unit_level:getLevel,unit_topic:getTopic,unit_numlessons:getNumLessons},
        dataType:"html",
        context:"#mylessons_content"}) //context:"#MyLessons"})
        .done(function(msg){
            processLessons(msg);
        });
    $(".item").css("color", "#808386");
    $("#myplans_item_"+getWhat).css("color", "#77AF0C");
    var i = $("#lesson-list").scrollable();
    var s = i.data("scrollable");
    s.seekTo(getScrollNum);
}
function processLessons(data)
{
    $("#middle_section").empty();
    $("#middle_section").append(data);
}
function showLessonDetails(topicId,levelId,themeId,title,lessonNum,unitId,lessonId)
{
    $.ajax({
        url:"/staffroom/show-lesson-details",
        data:{topic_id:topicId,level_id:levelId,theme_id:themeId,lesson_num:lessonNum,unit_id:unitId,lesson_id:lessonId},
        dataType:"html",
        success:(function(msg){
           jLesson(msg,title);
          
        })
    });
}
//--------------------- Plan Print from version 1 --------------------------

function printLesson(lessonNum,unitId) 
{
//this is based on the original print function  
if (lessonNum==0){
   showOptions("#options_items");
   jConfirm('You have requested a printout of your whole unit of work<br><br><b>Warning: This will print out all the lesson plans in this unit and may cover several sheets of paper</b><br><br>Do you want to print the whole unit?', 'Confirm Print Request', function(r) {
       if(r) {doPrint(lessonNum,unitId)}
       else{jAlert('Print Request Canceled');}
   });
   }
   else{
      doPrint(lessonNum,unitId);
   }
}
function doPrint(lessonNum,unitId)
{
    
    $.ajax({
        url:'/staffroom/print-Lesson',
        data:{lesson_num:lessonNum,unit_id:unitId},
        dataType:"json"}).done(function(msg){
            $.alerts._hide();
            var response=eval(msg);
                // success
                if(response.result==1){
                showStatus('Plan');
                if(lessonNum==0) var printTime = 80;
                else var printTime = 10;
                window.value = 0;
                var stat=setInterval("updateStatus("+printTime+")",500);    
                $.ajax({
                    url:response.detail,
                    cache:false
                }).done(function(msg){
                    $.alerts._hide();
                    var popUp = window.open(msg,'_blank');
                    if (popUp == null || typeof(popUp)=='undefined') {   
                        jInform('<p>You are not allowing popup windows from our site.</p><p>In order to print you must enable popups</p><p>You can go to our <a href="/learn/faqs">FAQ area</a> to learn how to do this or you can download a copy of the plan <a href="'+msg+'">here</a></p>'); 
                        }
                    else {   
                        setTimeout( function() {
                            if (popUp.outerHeight === 0) {
                                    jInform('<p>You are not allowing popup windows from our site.</p><p>In order to print you must enable popups</p><p>You can go to our <a href="/learn/faqs">FAQ area</a> to learn how to do this or you can download a copy of the plan <a href="'+msg+'">here</a></p>'); 
                                } 
                            }, 
                            1000);
                    }
                    //window.open(msg,'_blank');
                    stat=clearInterval(stat);
                    });
                }
                // failure
                else if (response.result==0){
                location.href='/staffroom?reason=' + response.more + '&level=' + response.detail;
                }   
        });
}
function assessUnit(varTopic,varLevel,varUnit)
{
    showOptions("#options_items");
    if(varLevel!=0) {
    jSelectform('<form id="assess_form"><h1>You can assess your unit in 3 ways:</h1><select class="popup_select" id="assess_sel"><option value=1>Class Assessment</option><option value=2>Individual Assessment</option><option value=3>Teacher Assessment</option><p><a href="/learn/assessment"><span class=info>Not sure which to choose?</span></a></form>', '', 'Choose Assessment Type', function(r) {
       if((r=='1')||(r=='2')||(r=='3')){
           $.alerts._hide();
           if (r!='3')
               {
               var url = "/tplan/code/assessment_print_2.php?assess_id="+ r + "&topic_id=" + varTopic + "&level_id=" + varLevel + "&unit_id=" + varUnit;
           $.ajax({
            url:url,
            dataType:"html",
            success:(function(msg){
                assWindow=window.open('','_blank');
                assWindow.document.write(msg);
                return false;
        
                })
            });
        }
        else {
            location.href="/tplan/code/teacher_assessment_2.php?unit_id=" + varUnit;
        }
       }
        else{
            if(r!=null){ 
            $("#options").toggle();
            assessUnit(varTopic,varLevel,varUnit);}
        }
            
    });
    }
    else {
       location.href="/tplan/code/teacher_assessment_2.php?unit_id=" + varUnit;
    }
}
function editLesson(unitId,lessonNum,planType,myId,myLevel)
{
    if (lessonNum==0) showOptions("#options_items");
    $.ajax({
        url:'/staffroom/edit-Lesson',
        data:{unit_id:unitId,lesson_num:lessonNum,plan_type:planType,my_id:myId,my_level:myLevel},
        dataType:'json'})
            .done(function(msg){
                var response=eval(msg);
                // success
                if(response.result==1){
                //location.replace(response.detail);
                eval(response.detail);
                //alert (response.detail)
                }
                // failure
                else if (response.result==0){
                    location.href='/staffroom?reason=' + response.more + '&level=' + response.detail;
                }   
            });
}
function renameUnit(unitId)
{
    showOptions("#options_items");
    var currentTitle = document.getElementById("mylessons_name");
    var currentName=currentTitle.innerHTML;
    jPrompt('', currentName, 'Rename Unit', function(r) {
        if (r) {
        $.ajax({
        url:'/staffroom/rename-Unit',
        data:{unit_id:unitId,name:r},
        dataType:'json'})
            .done(function(msg){
                $.alerts._hide();
                var response=eval(msg);
                // success
                if(response.result==1){
                //location.replace(response.detail);
                currentTitle.innerHTML = r;
                location.href='/staffroom';
                }
                // failure
                else if (response.result==0){
                    if ((response.detail=='Register')||(response.detail=='Subscribe'))
                    {showOverlay(response.detail,response.more);}
                    else {
                        jInform(response.more,response.detail);
                    }
                }   
            });
        }
        else {
            jAlert('Rename Request Cancelled');
        }
    });
    
}
function deleteUnit(unitId)
{
    showOptions("#options_items");
    jConfirm('Are you sure you want to delete this unit?', 'Confirmation Dialog', function(r) {
    if (r) {
        $.ajax({
        url:'/staffroom/delete-Unit',
        data:{unit_id:unitId},
        dataType:'json'})
            .done(function(msg){
                $.alerts._hide();
                var response=eval(msg);
                // success
                if(response.result==1){
                location.replace('/staffroom');
                //alert (response.detail)
                }
                // failure
                else if (response.result==0){
                    if ((response.detail=='Register')||(response.detail=='Subscribe'))
                    {
                        showOverlay(response.detail,response.more);}
                    else {
                        jAlert(response.more,response.detail);
                    } 
                }
            });
    }
    else {
        jAlert('Delete Canceled');
    }
    });
}
function createUnit()
{
    showOptions("#options_items");
   
   $.ajax({
        url:"/createaplan/unsetplan"
    }).done(function(msg){
        jForm(msg,'Give your Unit a Title','Create Your Own',function(r){
            if(r!=null) { 
            showStatus('Plan');
            var createTime = 5;
            var stat=setInterval("updateStatus("+createTime+")",50);
            $.post("/createaplan/create-Plan",r,function(data){
                stat=clearInterval(stat);
                $.alerts._hide();
                var response=eval(data);
                // success
                if(response.result==1){
                    if(response.detail=='setplan') location.replace('/staffroom');
                    else editLesson(response.detail,1,"newPlan",0,3);
                }
                // failure
                else if (response.result==0){
                     
                     location.href='/staffroom?reason=' + response.more + '&level=' + response.detail;
                    
                }
            })
            }
        });
        
    });
}
function myToggle(section)
{
    $(section).toggle();
}
function showOptions(section)
{
    if(section=="#options_items") 
        {
            if((($("#options_items").css('opacity')==1)||($("#options_items").css('filter')=='alpha(opacity=100)')))
                {
                    if(!$.browser.msie)
                        {
                            $("#options_items").fadeTo("fast",0);
                            $('#mylessons_content').fadeTo("slow",1);
                        }
                    else
                        {
                        if(parseInt($.browser.version)==7)
                          {
                              //$('#middle_section').css('filter','alpha(opacity=100)')
                              $("#options_items").css('filter','alpha(opacity=0)');
                          }
                        else if(parseInt($.browser.version)==8)
                          {
                              $('#mylessons_content').css('filter','alpha(opacity=100)')
                              $("#options_items").css('filter','alpha(opacity=0)');
                          }
                        else
                            {
                                $("#options_items").fadeTo("fast",0);
                                $('#mylessons_content').fadeTo("slow",1); 
                            }
                              
                        }     
                $("#options_items").css('visibility','hidden');
                }
                else
                    {
                        if(!$.browser.msie)
                            {   
                                $('#mylessons_content').fadeTo("fast",0.4);
                                $("#options_items").fadeTo("slow",1);
                            }
                        else
                            { 
                                if(parseInt($.browser.version)==7)
                                    {
                                        //$('#middle_section').css('filter','alpha(opacity=40)')
                                        $("#options_items").css('filter','alpha(opacity=100)');
                                    }
                                else if(parseInt($.browser.version)==8)
                                    {
                                        $('#mylessons_content').css('filter','alpha(opacity=40)')
                                        $("#options_items").css('filter','alpha(opacity=100)');
                                    } 
                                else {
                                        $('#mylessons_content').fadeTo("fast",0.4);
                                        $("#options_items").fadeTo("slow",1);
                                    }
                            }
                    $("#options_items").css('visibility','visible');
                    }
            

        }
}
//----------------------------------------------------create a plan functions
function getTopics(planType)
{
    if(planType=='unsetplan') var level=document.getElementById('own_sel_level').value;
    else var level=document.getElementById('sel_level').value;
    $.ajax({
        url:"/createaplan/get-Topics",
        data:{level_id:level,plan_type:planType},
        dataType:"json"}) 
        .done(function(msg){
            processTopics(msg,planType);
        });
}
function processTopics(data,planType)
{
    var i=0;
    var lastGenre=0;
    if(planType=='unsetplan') var topicSelect='#own_sel_topic';
    else var topicSelect='#sel_topic';
    $(topicSelect).empty();
    $(topicSelect).append("<option value=99>Select Activity</option>");
    $.each(data,function(i,topic){
        if(topic.id!=lastGenre) { 
            if (i!=0) $(topicSelect).append("<optgroup label='"+topic.description+"'>");
            else $(topicSelect).append("</optgroup><optgroup label='"+topic.description+"'>");
        }
        $(topicSelect).append("<option value="+topic.topic_id+">"+topic.topic_description+"</option>"); 
        lastGenre=topic.id;
       i++;
    })
    $(topicSelect).append("</optgroup>");
    //activateContinue(1);
}
function getLessonNumbers()
{
    var topic=document.getElementById('sel_topic').value;
    $("#sel_num_lessons").empty();
    $("#sel_num_lessons").append("<option value=99>Select number</option>");
    if((topic==53)||(topic==54)||(topic==55)||(topic==56)) $("#sel_num_lessons").append("<option value=7>7</option>");
    else {
        for(var i=5;i<=12;i++){
            $("#sel_num_lessons").append("<option value="+i+">"+i+"</option>");
        }
    }
}
function checkSetPlan(topicId,level,numLessons)
{
    $.ajax({
        url:"/createaplan/check-set-plan",
        type:"GET",
        data:{sel_level:level,sel_topic:topicId,sel_num_lessons:numLessons},
        dataType:"json"}).done(function(msg){
                $.alerts._hide();
                var response=eval(msg);
                // success
                
            }); 
}

function createPlan(planType,userLevel)
{
    var sel_level=$("#sel_level").val();
    var sel_topic=$("#sel_topic").val();
    var sel_num_lessons=$("#sel_num_lessons").val(); 
    var title=$("#unit_title").val();
    showStatus('Plan');
    if(userLevel==0) var createTime = 8;
    else var createTime = sel_num_lessons * 8;
    window.value = 0;
    var stat=setInterval("updateStatus("+createTime+")",500);
    $.ajax({
        url:"/createaplan/create-Plan",
        type:"POST",
        data:{sel_level:sel_level,sel_topic:sel_topic,sel_num_lessons:sel_num_lessons,title:title,plan_type:planType},
        dataType:"json"}).done(function(msg){
                stat=clearInterval(stat);
                $.alerts._hide();
                var response=eval(msg);
                // success
                if(response.result==1){
                location.replace('/staffroom');
                }
                // failure
                else if (response.result==0){
                     
                     location.href='/staffroom?reason=' + response.more + '&level=' + response.detail;
                    
                }
            }); 
}
function showStatus(whatStatus)
{
    $('#status_bar').progressbar("destroy");
    jStatus('',whatStatus);
}
function updateStatus(createTime)
{
    var interval = 100 / createTime;
    window.value = interval + window.value;
    $('#status_bar').progressbar({value:window.value});
}
function processPlan(data)
{
    alert ('processing Plan');
}
function activateContinue(step)
{
    var divStep = '#step'+step+'_cont';
    $(divStep).html('<a class="next right"><span>continue</span></a>');
}
//-------------------------------- Authorisation functions
//-------------------------------- Combined Functions
function showOverlay(ovl,more)
{
    // This function gets the requested overlay and form and displays
    if(ovl=='Register') boxAction('freetrial');
    $.alerts._hide();
    if(more){
        var ovlMessage=more;
    } else ovlMessage='none';
    //if(ovl=='Login') clearSession();
    //setupEncryption();
    var url = "/auth/" + ovl;
    var contentId = "#" + ovl + "-content";
    var divId = "#" + ovl + "_div";
    $.ajax({
        url:url,
        data:{reason:ovlMessage},
        dataType:"html"})
        .done(function(msg){
           $(contentId).replaceWith(msg);
           
           $(divId).maxZIndex();
           document.forms[0].reset();
           $(divId).overlay().load(); 
           passwordBlur(ovl);
        });
}
function doProcess(proc)
{
    // This function sends the form data to the controller and reports response
    var url = "/auth/" + proc;
    var formName = "#" + proc + 'form';
    var divId = "#" + proc + "_div";
    var sendData=$(formName).serialize();
    $(".error").val('');
    $.post(url, {data:sendData},
        function(data) {
                var response=eval(data);
                // success
        if(response.result==1){ 
            if(proc=='Login'){
                location.href = "http://" + location.host + "/staffroom?reason=" + response.detail;
                }
            else successFunction(proc,response);
            }
                
        // failure
        else if (response.result==0){
            if ((proc!='Logout')&&(proc!='payment')&&(proc!='Subscribe')&&(proc!='usercheck')) $(divId).overlay().close();
            if(response.detail=="Invalid username or password try again") location.href = "https://" + location.host + "/auth/login?fail=1";
            else if(response.detail=="Please complete all the fields on the login form") location.href = "https://" + location.host + "/auth/login?fail=2";
            else if(response.detail=="registered") location.href = "http://" + location.host + "/staffroom?reason=" + response.detail;
            else if(response.detail=="no change") location.href = "http://" + location.host + "/staffroom?reason=nochange";
            else if(proc=='usercheck') location.href = "http://" + location.host + "/auth/usercheck?reason=" + response.detail + "&userid=" + response.more;
            else jAlert (response.detail)
            
        } 
        // neither. something else went wrong
        else if (response.result==2){
        location.href = "https://" + location.host + "/auth/payment";
        }
        else if (response.result==3){
        location.href = "http://" + location.host + "/staffroom?reason=" + response.detail;
        }
        else if (response.result==4){
        for(var key in response){ 
            var fieldName = '#' + key + '_msg';
            var errorMessage = response[key];
            if(errorMessage!="") {
            $(fieldName).val(errorMessage);
            $(fieldName).show();}
            }
        }
        else {
        for(var key in response){ 
            var fieldName = '#' + key + '_msg';
            var errorMessage = response[key];
            for (var subKey in errorMessage){
            $(fieldName).val(errorMessage[subKey]);
            $(fieldName).show();}
            }
        }
   });
}
function successFunction(proc,response)
{
    var divId = "#" + proc + "_div"; 
    if ((proc!='Logout')&&(proc!='payment')&&(proc!='Subscribe')) $(divId).overlay().close(); 
    switch(proc) {
        case 'Login':
            //location.href=("/staffroom");
            location.href = "http://" + location.host + "/staffroom";
            break;
        case 'edituser':
            location.href = "http://" + location.host + "/staffroom?reason=useredited";
            break;
        case 'Subscribe':
            location.href = "http://" + location.host + "/staffroom?reason=subscribed";
            break;
        case 'password':
            location.href = "http://" + location.host + "/staffroom?reason=passwordchanged";
            break;
        case 'feedback':
            location.href = "http://" + location.host + "/staffroom?reason=feedback";
            break;
        case 'payment':
            location.href = "http://" + location.host + "/staffroom?reason=payment";
            break;
        case 'usercheck':
            location.href = "http://" + location.host + "/auth/unify";
            break;
        case 'Logout':
            if(response.unify) location.href='https://sts.platform.rmunify.com/WsFederation/Logout';
            else location.href=  "http://" + location.host + "/";
            break;
        
    }
}
function boxAction(action)
{
    /**$.ajax({
        url:"/auth/get-User-Level"
        }) 
        .done(function(msg){
            var userLevel=msg;
            });*/
        switch(action) {
        case 'register':
            location.href=('/auth/subscribe');
            break;
        case 'subscribe':
            location.href=('/auth/payment');
            break;
        case 'trial':
            location.href=('/auth/subscribe');
            break;
        case 'planalesson':
            location.href=('/createaplan');
            break;
        case 'createyourown':
            createUnit();
            break;
        case 'endorsements':
            location.href=('/learn/endorsements');
            break;
        case 'faqs':
            location.href=('/learn/faqs');
            break;
        case 'freetrial':
            location.href=('/auth/subscribe');
            break;
        case 'social':
            //location.href=('http://www.facebook.com/PEplanning');
            window.open('http://www.facebook.com/PEplanning','_blank');
            break;
        case 'staffroom':
            location.href=('/learn/staffroom');
            break;
        case 'peschool':
            location.href=('/learn/peschool');
            break;
        case 'peteacher':
            location.href=('/learn/peteacher');
            break;
        case 'pecoach':
            location.href=('/learn/pecoach');
            break;
        case 'additionalresources':
            location.href=('/resources/');
            break;
        case 'userguide':
            location.href=('/resource-downloads/Guide%20to%20using%20PEplanning%20v1.1.pdf');
            break;
        case 'video':
            location.href=('/learn/video');
            break;
        
    }
}
function editUser(userId)
{
    $.alerts._hide();
    //setupEncryption();
    $.ajax({
        url:"/auth/edituser"
        }).done(function(msg){
            jUserform(msg,'','Edit User', function(r) {
                if(r) {
                    var sendData=r;
                    $.post("/auth/edituser",{data:sendData},function(data){
                        $.alerts._hide();
                        var response=eval(data);
                        var changedInfo='Details Updated';
                        for(var key in response){
                           if(response[key].result==1) {
                               jInform(changedInfo);
                               exit;
                           }
                           
                        }
                        jInform('No Changes Made')
                        })
                }
                    })
                })
           
           
}
function changePassword(previousResult)
{
    $.alerts._hide();
    $.ajax({
        url:"/auth/password",
        data:{prev:previousResult}
        }).done(function(msg){
            jPasswordform(msg,previousResult,'Change Password', function(r) {
                if(r) {
                    var sendData=r;
                    $.post("/auth/password",{data:sendData},function(data){
                        $.alerts._hide();
                        var response=eval(data);
                        jAlert(response.detail);
                        if(response.result==0) {
                             previousResult='';
                             changePassword(response.detail);
                           
                    }
                        })
                }
                    })
                })
           
           
}
function forgotPassword()
{
    $('#Login_div').overlay().close();
    jPrompt('','email address','Forgotten Password',function(r){
        if (r) {
        var get_par = "&email="+r;
        //$.get("/auth/forgot-password",get_par,function(data){
        //        $.alerts._hide();
        //        var response=eval(data);
        //        jAlert(response.more,response.detail);
        //     })
        location.href=("/auth/forgot-password?email="+r);
        }
    });
}
function reactivateAccount()
{
    $.alerts._hide();
    jPrompt('','email address','Re-send Activation Email',function(r){
        if (r) {
        var get_par = "&email="+r;
        $.get("/auth/reactivate-account",get_par,function(data){
                $.alerts._hide();
                var response=eval(data);
                jAlert(response.more,response.detail);
            })
        }
    });
}
function showRestriction(reason)
{
    location.href=('/learn/restrictions?#'+reason);
}
function clearSession()
{
    $.ajax({
        url:"/auth/clear-Session",
        dataType:"json",
        success:(function(msg){
            var response=eval(msg);
            //jAlert(response.detail)
        })
    })
}
function shutMeAndTakeMeHere(whereGoWe)
{
    $.alerts._hide();
    location.href=(whereGoWe);
}
/*----------------------Encryption Process----------------------------
function randomString() 
{
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var string_length = 128;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            randomstring += chars.substring(rnum,rnum+1);
	}
	//randomstring += cursor.x;
	//randomstring += cursor.y;
	return randomstring;
}
function setupEncryption()
{
	// Initialize the password variable
	var password;
	// If a connection hasn't been made
	if(!window.isConnected){
		// Create a random AES key
		var hashObj = new jsSHA(randomString(), "ASCII");
		password = hashObj.getHash("SHA-512", "HEX");
		// Authenticate with the server
		$.jCryption.authenticate(password, "/auth/set-Encryption?generateKeypair=true", "/auth/set-Encryption?handshake=true", function(AESKey) {
			window.isConnected=1;
			window.password = password;
                	})
		
         return password;
        }
}
*/
//--------------------- Contact Process------------------------------------
function showContact()
{
    $.ajax({
        url:"/auth/Contact",
        dataType:"html",
        success:(function(msg){
           $("#contact_form").replaceWith(msg);
           //$("#contact_div").maxZIndex();
           //$("#contact_div").overlay().load(); 
        })
    });
}
function doContact()
{
    var name_contact=$("#name_contact").val();
    var email_contact=$("#email_contact").val();
    var email_confirm_contact=$("#email_confirm_contact").val();
    var details_contact=$("#details_contact").val();
    var nature_contact=$("#nature_contact").val();
    $("#name_contact_msg").val('');
    $("#email_contact_msg").val('');
    $("#email_confirm_contact_msg").val('');
    $("#details_contact_msg").val('');
    $("#nature_contact_msg").val('');
    if(name_contact=='name') name_contact='';
    $.ajax({
        type:"POST",
        url:"/auth/contact",
        data:{name_contact:name_contact,email_contact:email_contact,email_confirm_contact:email_confirm_contact,details_contact:details_contact,nature_contact:nature_contact},
        dataType:"json"})
        .done(function(msg){
            processContact(msg);
        });
}
function processContact(data)
{
    var response=eval(data);
    if(response.result==1){
        $("#name_contact").val('name');
        $("#email_contact").val('email address');
        $("#details_contact").val('How can we help you?');
        $("#nature_contact").val('How can we help you?');
        jAlert(response.detail);
        }
    else {
        for(var key in response){ 
            var fieldName = '#' + key + '_msg';
            var errorMessage = response[key];
            for (var subKey in errorMessage){
            //alert('key name: ' + subKey + ' value: ' + errorMessage[subKey]); 
            $(fieldName).val(errorMessage[subKey])}
        }
        
    }

}
function downloadFile(file,level)
{
    if(level>=4) document.location = '/resource-downloads/' + file;
    else location.href = "http://" + location.host + "/staffroom?reason=download";
}
/*----- PLAN A LESSON - Summary ----------------------------------------------*/

function updateSummary(){

    var mylevel = document.getElementById("sel_level");
    $level = (mylevel.options[mylevel.selectedIndex].text);

    var mytopic = document.getElementById("sel_topic");
    $topic = ($("#sel_topic option:selected").text());    

    $lessons = document.getElementById('sel_num_lessons').value;
    $title = document.getElementById('unit_title').value;

    document.getElementById('sum_1').innerHTML = $level;
    document.getElementById('sum_2').innerHTML = $topic;
    document.getElementById('sum_3').innerHTML = $lessons;
    document.getElementById('sum_4').innerHTML = $title;
}

/*----- Browser Hack for select boxes ----------------------------------------*/
function updateSelect(get,post){
    $select_overlay = ($("#"+get+" option:selected").text());
    document.getElementById(post).value = $select_overlay;

    //alert(get+ ', ' + post);
    if(get == 'sel_level'){getTopics('setplan');}
    if(get == 'own_sel_level'){getTopics('unsetplan');}
    if((get == 'sel_topic') || (get == 'own_sel_topic')){getLessonNumbers();}
}
