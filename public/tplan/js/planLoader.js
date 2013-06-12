// planScripts.js
// version 1
// created 10/11/09
//The first section is for jquery intilization of the objects required
//	document.getElementById('content').appendChild(objTabDiv);
// this is the Ajax function to create the Ajax object
function getHTTPObject()
{
	if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
	else if (window.XMLHttpRequest) return new XMLHttpRequest();
	else {
		alert("Your browser does not support AJAX.");
		return null;
		}
}
function canIEditThis(unit)
{
    var objectName="unit_"+window.unitId;
	    objectName = getHTTPObject();
    		
    			objectName.onreadystatechange = function() {
        		if (objectName.readyState==4) {
                            	if (objectName.responseText=='no')
                                    {
                                        alert('You are not allowed to edit this Unit');
                                         window.back();
                                    }
                                    else
                                        {
                                            var dataArray=objectName.responseText.split('^');
                                            createVariables(dataArray); 
                                            setUpContent();
                                            createUi();
                                        }
                                }
                            };
			
    var randomnumber = Math.floor(Math.random()*1000001);
    //urlstring = "code/lessonfunctions_2.php?GetUnit=" + window.unitId + "&_=" + randomnumber;
    urlstring = "code/lessonfunctions_2.php?GetUnit=" + window.unitId + "&user_id="+window.userId+"&user_level="+window.userLevel+"&_=" + randomnumber;
    objectName.open("GET", urlstring, false);
    objectName.send(null);
}
function createUi()
{
       var $tabs=$('#tabs').tabs({
                        spinner:'Loading Lesson Plan...',
			panelTemplate:'<div style="height:650px"></div>',
                        tabTemplate: '<li id="#{label}" class="ui-widget"><a href="#{href}" title="Lesson"><span class="tab-label">#{label}</span></a> <span id="tabspan" class="ui-icon ui-icon-close">Remove Tab</span></li>',
			ajaxOptions: {
                            async: true,
                            cache:false,
                            error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html("cannot load lesson plan");},
                            beforeSend:function(){
                                //showSpinner($('li',$tabs).index($(this).parent()));
                                $('#content').fadeTo('slow',0.2);
                                $('#header').fadeTo('slow',0.2);
                                jLoading('Loading...','Loading Lesson...');
                            },
                            success:function()
                            {
                                $('#content').fadeTo('slow',1);
                                $('#header').fadeTo('slow',1);
                                $.alerts._hide();
                            }
                        },
                        show: function(event, ui) {
                            $('#tabs .ui-icon-close').hide();
                            $(ui.tab).parent().find('.ui-icon-close').show();
                        },
			cache:true
                    }).find(".ui-tabs-nav").sortable({
//				containment: 'parent'
			});
        if(window.topicStatus!='R'){            
	$('#tabspan').live('click', function() {
			var index = $('li',$tabs).index($(this).parent());
			unDrawLessonLayout(index+1);
		});
        }
    
	var lessonTabsDiv=document.getElementById('tabs'); // finished asking the questions, time to create some 
            lessonTabsDiv.style.visibility = 'visible'; // tabs to put the plans in
//alert (window.userLevel);
if (window.userLevel==1) window.numLessons=1;
for (j = 1 ; j <= window.numLessons ; j++) {
    makeTab(j);
    }
for (i = 1 ; i <= window.numLessons ; i++) { 
    if(window.themeIds[i]) //test to see whether it is an unplanned lesson
        {    
            var lessonTabUrl="code/lessonfunctions_2.php?DrawPlanPage=" + i + "&theme_id=" + document.getElementById('themeid['+i+']').value + "&topic_id=" + window.topicId + "&level=" + window.levelId + "&uow_id=" + window.unitId + "&objectives=" + window.objectiveIds_array[i] + "&plan_type=" + window.planType;
            
        }
    else 
        {
            if ((window.planType=="newPlan")&&(window.originalType!='s')) //test for whether it is restricted and has to have a set plan
                {
                    var lessonTabUrl="code/lessonfunctions_2.php?GetThemes=" + i + "&topic_id=" + window.topicId + "&level=" + window.levelId + "&description=" + window.description + "&num_lessons=" + window.numLessons + "&plan_type=" + window.planType;
                }
            else
                {
                    var lessonTabUrl="code/lessonfunctions_2.php?GetSetLessons=" + i + "&topic_id=" + window.topicId + "&level=" + window.levelId + "&description=" + window.description + "&num_lessons=" + window.numLessons + "&plan_type=" + window.planType;
                }
                   
        }
        $('#tabs').tabs("url",i-1,lessonTabUrl); //add the url to the tab
    }
var headingDiv=document.getElementById('header'); // this is in effect the title of the page
	headingDiv.className='ui-widget';
var addS=""; // make sure we are grammatically correct
var displayLevel=getDisplayLevel(window.levelId); // don't want decimals in the display so convert to fractions
if (window.numLessons > 1) addS="s";
headingDiv.innerHTML="<table><tr><td rowspan=2 align='left' width=30%><img src='images/bnb_logo_narrow.jpg' border=0 style=\"cursor:pointer;\" onclick='goHome();' alt='Go Home'></td><td align='left' width=60% valign=\"bottom\" ><label class='ui-widget' style='font-size:18px;font-family: \"Lucida Grande\",Verdana,Sans-serif; font-weight: normal;'>You are planning to teach " + window.numLessons + " lesson" + addS + " in " + window.topic + " at level " + displayLevel + ".  </label><td align='center' rowspan=2 width=10%><img src='index_files/printer_iconsmall.jpg' border=none width=\"30\" height=\"30\" style=\"cursor:pointer\" valign='bottom' onclick='printPlan(0,"+window.unitId+");' alt='Print Plan'><img src='index_files/home_iconsmall.jpg' border=none width=\"30\" height=\"30\" style=\"cursor:pointer\" valign='bottom' onclick='goHome();' alt='Go Home'></td></tr><tr><td align='left' valign='top'><div id='last_save' style='font-size: 10px; font-family: \"Lucida Grande\",Verdana,Sans-serif; font-weight: normal;'></div></td></tr></table>";
$("#tabs").tabs('select',window.lessonNumber);
$("#tabs").tabs('load',window.lessonNumber);
for (l=1 ; l <= window.numLessons ; l++)
	{
	if (window.lessonIds[l])
		{
			lessonField=document.createElement('input');
			lessonField.id='lesson_id['+l+']';
			lessonField.name='lesson_id['+l+']';
			lessonField.value=window.lessonIds[l];
			document.getElementById('storeRoom['+l+']').appendChild(lessonField);
                        lessonField=document.createElement('input');
			lessonField.type='submit';
			lessonField.value=window.lessonIds[l];
			document.getElementById('storeRoom['+l+']').appendChild(lessonField);
		}

	}
var numLessonsField=document.createElement('input');
	numLessonsField.id='num_lessons';
	numLessonsField.name='num_lessons';
	numLessonsField.value=window.numLessons
var uowField=document.createElement('input');
	uowField.id='uow_id';
	uowField.name='uow_id';
	uowField.value=window.unitId;
document.getElementById('storeArea').appendChild(numLessonsField);	
document.getElementById('storeArea').appendChild(uowField);
$("#assessment_options").hide();
	$("#assessment_cell").click(function() {
		$("#assessment_options").animate({height: "toggle"}, 1000);
	});
//sets up the ajax save as you go functionality
//var buttons = $('.ui-dialog-buttonpane').children('button');
//buttons.removeClass('ui-state-default ui-state-hover ui-state-focus ui-corner-all').addClass('btn btn-m');
for (i = 1 ; i <= window.numLessons ; i++) {
 var options = {
        target:        '#last_save',   // target element(s) to be updated with server response
        //beforeSubmit:  showRequest,  // pre-submit callback
        success:    doAction,
        url: 'code/lessonfunctions_2.php?SaveLesson=1&plan_type='+window.planType+'&uow_id='+window.unitId+'&lesson_num='+i,
        type: 'post'
        };

    // bind form using 'ajaxForm'
    $('#storeRoom_'+i).ajaxForm(options);
    // save each new lesson on load
    }
    var saveNum=window.lessonNumber+1;
    //submitAndUpdate('#storeRoom_'+saveNum);
    window.goLocation='';
    $('#saveDiv['+saveNum+']').css('height','200px');
    $('#tabs .ui-icon-close').hide();
    $('#tabs .ui-tabs-selected').find('.ui-icon-close').show();

}
function createVariables(dataArray)
{
    window.topicId=dataArray[0];window.levelId=dataArray[1];window.numLessons=dataArray[2];window.topic=dataArray[3];window.topicStatus=dataArray[4];window.originalType=dataArray[5];window.userLevel=dataArray[6];window.activityCount=new Array();window.lessonIds=new Array();window.themeIds=new Array();window.themes=new Array();window.objectiveIds=new Array();window.objectiveIds_array=new Array();window.objectives=new Array();window.objectiveStrand=new Array();window.activityIds=new Array();window.activityLps=new Array();window.time=new Array();window.activityNum=new Array();window.keywords=new Array();window.keywords_array=new Array();window.ict=new Array();window.ict_array=new Array();window.numeracy=new Array();window.numeracy_array=new Array();window.risk_assessment=new Array();window.risk_assessment_array=new Array();window.citizenship=new Array();window.citizenship_array=new Array();window.teaching_assistant=new Array();window.sen=new Array();window.ta=new Array();window.strand=new Array();window.strand_array=new Array();window.teaching_point=new Array();window.teaching_point_array=new Array();window.differentiation=new Array();window.differentiation_array=new Array();window.progression=new Array();window.progression_array=new Array();window.progression_points=new Array();window.progression_points_array=new Array();window.analyses=new Array();window.analyses_array=new Array();window.analyses_points=new Array();window.analyses_points_array=new Array();
}
function setUpContent()
{
   
		var objectName="lessons";
	    	objectName = getHTTPObject();
    		
				objectName.onreadystatechange = function() { 
        		if (objectName.readyState==4) {
					var globals = objectName.responseText;
                                        var setUpLessons = new Function(globals);
                                        setUpLessons();

        			}
    		};
			
		var randomnumber = Math.floor(Math.random()*1000001);	
    	urlstring = "code/lessonfunctions_2.php?SetUpLessons=" + window.unitId + "&num_lessons=" + window.numLessons + "&lesson_type=" + window.planType + "&topic_id=" + window.topicId + "&level_id=" + window.levelId + "&original_type=" + window.originalType + "&lesson_num=" + window.lessonNumber + "&_=" + randomnumber;
		objectName.open("GET", urlstring, false);
    	objectName.send(null);

}
function drawObjectiveTabs(i) // i = lessonNum
{
	for (var objectiveId in window.objectiveIds[i])
	{
		doUpdateField('objectiveid',i,window.objectiveIds[i][objectiveId],window.objectiveIds[i][objectiveId]);
		doUpdateField('objective',i,window.objectiveIds[i][objectiveId],window.objectives[i][objectiveId]);
		doUpdateField('objectivestrand',i,window.objectiveIds[i][objectiveId],window.objectiveStrand[i][objectiveId]);
		updateObjList(window.objectiveStrand[i][objectiveId],window.objectiveIds[i][objectiveId],i);
	}
}
function drawActivityTabs(i)
{
    //debug('My Userlevel='+window.userLevel);
    if(window.topicStatus!='R'||window.userLevel==9){
        $('#acttabs_'+i).tabs({
			panelTemplate:'<div name="#{label}" style="height:400px"></div>',
			tabTemplate: '<li id="#{label}" class="ui-widget"><a class="ui-widget" href="#{href}">#{label}</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>',
			ajaxOptions: { 
				async: false, 
				cache: false,
				timeout: 200
				},
			cache:true,
                        selected:0,
                        show: function(event, ui) {
                            $('#acttabs_'+i+' .ui-icon-close').hide();
                            $(ui.tab).parent().find('.ui-icon-close').show();
                        }
			}).find(".ui-tabs-nav").sortable({
//				containment: 'parent'
			}).disableSelection();
	$('#acttabs_'+i+' span.ui-icon-close').live('click', function(e) {
  			$('#act_ul_'+i+' li').each(function(){
				var act_position = $('#act_ul_'+i+' li').index(this)+1;
				var act_section = $(this).attr("id");
				doRemoveField('activitynum',i,$(this).parent().attr("id"),act_section);
                                });
                                
                        var index = $('li','#acttabs_'+i).index($(this).parent());
			var actId = $(this).parent().attr("id");
                        $('#acttabs_'+i).tabs('remove',$('#acttabs_'+i).tabs('option','selected'));
			unDrawActivity(i,index+1,actId);
                        //re sort the tabs following removal
                        $('#act_ul_'+i+' li').each(function(){
					var act_position = $('#act_ul_'+i+' li').index(this)+1;
					var act_section = $(this).attr("id");
					doUpdateField('activitynum',i,act_position,act_section);});
			e.stopImmediatePropagation();
			return false;
		});
	$('#acttabs_'+i).bind('sortupdate', function(event, ui) {
                                        $('#act_ul_'+i+' li').each(function(){
					var act_position = $('#act_ul_'+i+' li').index(this)+1;
					var act_section = $(this).attr("id");
					doUpdateField('activitynum',i,act_position,act_section);
					//alert (act_position + "-" + act_section);
					})
		});
    }
    else{
        $('#acttabs_'+i).tabs({
			panelTemplate:'<div name="#{label}" style="height:400px"></div>',
			tabTemplate: '<li id="#{label}" class="ui-widget"><a class="ui-widget" href="#{href}">#{label}</a></li>',
			ajaxOptions: {
				async: false,
				cache: false,
				timeout: 200
				},
			cache:true
			});
    }
	if (window.activityCount[i]!=0)
	{
                for (c = 1 ; c <= window.activityCount[i] ; c++)
			{
				var	actNum=c+1;
                                if (window.activityNum[i][c]) var a=window.activityNum[i][c];
				if (!document.getElementById('activitynum['+i+']['+c+']') && (window.activityNum[i][c])){
				doUpdateField('activitynum',i,c,window.activityIds[i][a]); }
                                var b=document.getElementById('activitynum['+i+']['+c+']').value;
				if (!document.getElementById('activityid['+i+']['+b+']') && (window.activityIds[i][a])){
				doUpdateActivity('activityid',i,b,window.activityIds[i][a]); }
				if (!document.getElementById('activitylps['+i+']['+b+']') && (window.activityLps[i][a])){
				doUpdateActivity('activitylps',i,b,window.activityLps[i][a]);	}
				if (!document.getElementById('time['+i+']['+a+']') && (window.time[i][a])){
				doUpdateActivity('timeout',i,b,window.time[i][a]); }
				if ((window.strand[i][a]) && (window.strand[i][a].length!=0)) 
				{ 
					window.strand_array[i][a]='0';
					for (var subStrands in window.strand[i][a]) 
						{ 
							doUpdateField3Dim('strand',i,b,window.strand[i][a][subStrands],window.strand[i][a][subStrands]);
							window.strand_array[i][a]=window.strand_array[i][a] + ',' + window.strand[i][a][subStrands];
						}
				}
				if ((window.teaching_point[i][a]) && (window.teaching_point[i][a].length!=0)) 
				{
					window.teaching_point_array[i][a]='0';
					for (var subPoints in window.teaching_point[i][a])
						{ 
							doUpdateField3Dim('teaching_point',i,b,window.teaching_point[i][a][subPoints],window.teaching_point[i][a][subPoints]);
							window.teaching_point_array[i][a]=window.teaching_point_array[i][a] + ',' + window.teaching_point[i][a][subPoints];
						}
				}
				if ((window.differentiation[i][a]) && (window.differentiation[i][a].length!=0))
				{
					for (var subDiff in window.differentiation[i][a]) 
						{ 
							doUpdateField3Dim('differentiation',i,b,window.differentiation[i][a][subDiff],window.differentiation[i][a][subDiff]);
						}
				}
				if ((window.analyses[i][a]) && (window.analyses[i][a].length!=0))
				{
					for (var subAnal in window.analyses[i][a]) 
						{ 
							doUpdateField3Dim('analyses',i,b,window.analyses[i][a][subAnal],window.analyses[i][a][subAnal]);
									if ((window.analyses_points[i][a][subAnal]) && (window.analyses_points[i][a][subAnal]!=0))
										{
											for (var subAnalPoint in window.analyses_points[i][a][subAnal]) 
												{ 
													doUpdateField4Dim('analyses_points',i,b,window.analyses_points[i][a][subAnal][subAnalPoint],window.analyses_points[i][a][subAnal][subAnalPoint],subAnal);
												}
										}
						}
				}
				if ((window.progression[i][a]) && (window.progression[i][a].length!=0))
				{
					for (var subProg in window.progression[i][a]) 
						{ 
							doUpdateField3Dim('progression',i,b,window.progression[i][a][subProg],window.progression[i][a][subProg]);
									if ((window.progression_points[i][a][subProg]) && (window.analyses_points[i][a][subProg]!=0))
										{
												for (var subProgPoint in window.progression_points[i][a][subProg]) 
													{ 
														doUpdateField4Dim('progression_points',i,b,window.progression_points[i][a][subProg][subProgPoint],window.progression_points[i][a][subProg][subProgPoint],subProg);
													}
										}
						}
				}
				var objNum=a;
                                var themeId=document.getElementById("themeid["+i+"]").value;
				var actTabUrl="code/lessonfunctions_2.php?GetActivity=" + objNum + "&lesson_num=" + i +  "&content_id=" + window.activityIds[i][a] + "&strands=" + window.strand_array[i][a] + "&teaching_points=" + window.teaching_point_array[i][a] + "&time=" + window.time[i][a] + "&plan_type=" + window.planType + "&topic_status=" + window.topicStatus + "&topic_id=" + topicId + "&theme_id=" + themeId + "&level=" + window.levelId;
				var actTabLabel=window.activityLps[i][a];
				$("#acttabs_"+i).tabs( 'add' , actTabUrl , actTabLabel );
				//var $tabs = $("#acttabs"+i).tabs({
    				//add: function(event, ui) {
        			//$tabs.tabs('select', '#' + ui.panel.id);
    				//}
				//});
                                //$("#acttabs_"+i).tabs( 'load' , a-1 );
				$('#act_ul_'+i+' li:last').attr('id',function(){
//				alert (window.activityIds[i][a]);
				return window.activityIds[i][a]
				});
			}
	}
	else
	{
		var actTabUrl="code/lessonfunctions_2.php?GetActivities=1&lesson_num=" + i + "&topic_id=" + topicId + "&level=" + levelId + "&theme_id=" + window.themeIds[i] + "&plan_type=" + window.planType;
		var actTabLabel="Activity";
			$("#acttabs_"+i).tabs( 'add' , actTabUrl , actTabLabel );
				var $tabs = $("#acttabs"+i).tabs({
    				add: function(event, ui) {
        			$tabs.tabs('select', '#' + ui.panel.id);
    				}
				});		
		var	actNum=2;
	}
	if(window.topicStatus!='R'||window.userLevel==9){
        actTabUrl="code/lessonfunctions_2.php?GetActivities=" + actNum + "&lesson_num=" + i + "&topic_id=" + topicId + "&level=" + levelId + "&theme_id=" + themeIds[i] + "&plan_type=" + window.planType;
	actTabLabel="Add Activity";
	$("#acttabs_"+i).tabs( 'add' , actTabUrl , actTabLabel );
	$('#acttabs_'+i).bind("tabsselect", function(event, ui) {
		//currentActTab=tab.index;
                //alert('tab label ' + $(ui.tab).text()); 
		if ($(ui.tab).text() == "Add Activity")
			{
				var actNum=ui.index + 2;
				//$("#acttabs_"+i +" li:eq(" + ui.index + ") a").html('Activity'); 
				$(ui.tab).text('Select Activity')
                                actTabUrl="code/lessonfunctions_2.php?GetActivities=" + actNum + "&lesson_num=" + i + "&topic_id=" + topicId + "&level=" + levelId + "&theme_id=" + themeIds[i] + "&plan_type=" + window.planType;
				$("#acttabs_"+i).tabs( 'add' , actTabUrl , actTabLabel );
				var $tabs = $("#acttabs"+i).tabs({
    				add: function(event, ui) {
        			$tabs.tabs('select', '#' + ui.panel.id);
    				}
				});
			}

	});
        }
        $('#acttabs_'+i+' .ui-icon-close').hide();
        $('#acttabs_'+i+' .ui-tabs-selected').find('.ui-icon-close').show();
        /*$("#acttabs_"+i).tabs()..scrollabletab({
                            'closeable':true,
                            'animationSpeed':200
                            });*/
	var	divToReveal=document.getElementById('acttabs_'+i);
		divToReveal.style.visibility='visible';
	var divToAttachItTo=document.getElementById('activityListDiv['+i+']');
		divToAttachItTo.appendChild(divToReveal);
}
function drawCcoTabs(i) // i = lessonNum
{
    $('#ccotabs_'+i).tabs({
			panelTemplate:'<div style="height:400px"></div>',
			tabTemplate: '<li  class="ui-widget"><a class="ui-widget" href="#{href}">#{label}</a> </li>',
			ajaxOptions: {
				async: false,
				cache: true,
				timeout: 200
				},
			cache:true
			});
	if ((window.keywords[i]) && (window.keywords[i].length!=0)) 
		{
		window.keywords_array[i]="0";
		for (var keyword in window.keywords[i])
			{
				doUpdateField('keywords',i,window.keywords[i][keyword],window.keywords[i][keyword]);
				window.keywords_array[i]=window.keywords_array[i] + ',' + window.keywords[i][keyword];
			}
		}
		var objTabUrl="code/lessonfunctions_2.php?GetData=keywords&lesson_num=" + i + "&topic_id=" + window.topicId + "&data=" + window.keywords_array[i] + "&plan_type=" + window.planType;
		var objTabLabel="Keywords";
		$("#ccotabs_"+i).tabs( 'add' , objTabUrl , objTabLabel );
		var $tabs = $("#ccotabs_"+i).tabs({
    		add: function(event, ui) {
        		$tabs.tabs('select', '#' + ui.panel.id);
    			}
		});		
//	$("#ccotabs_"+i).tabs( 'load' , 0 );
	if ((window.citizenship[i]) && (window.citizenship[i].length!=0)) 
		{
			window.citizenship_array[i]='0';
			for (var citizenship in window.citizenship[i])
				{
					doUpdateField('citizenship',i,window.citizenship[i][citizenship],window.citizenship[i][citizenship]);
					window.citizenship_array[i]=window.citizenship_array[i] + ',' + window.citizenship[i][citizenship];
				}
			}
		var objTabUrl="code/lessonfunctions_2.php?GetData=citizenship&lesson_num=" + i + "&topic_id=" + window.topicId + "&data=" + window.citizenship_array[i] + "&plan_type=" + window.planType;
		var objTabLabel="Citizenship";
		$("#ccotabs_"+i).tabs( 'add' , objTabUrl , objTabLabel );
		var $tabs = $("#ccotabs_"+i).tabs({
    		add: function(event, ui) {
        		$tabs.tabs('select', '#' + ui.panel.id);
    			}
		});		
//	$("#ccotabs_"+i).tabs( 'load' , 1 );
	if ((window.ict[i]) && (window.ict[i].length!=0)) 
		{
			window.ict_array[i]='0';
			for (var ict in window.ict[i])
				{
					doUpdateField('ict',i,window.ict[i][ict],window.ict[i][ict]);
					window.ict_array[i]=window.ict_array[i] + ',' + window.ict[i][ict];
				}
			}
		var objTabUrl="code/lessonfunctions_2.php?GetData=ict&lesson_num=" + i + "&topic_id=" + window.topicId + "&data=" + window.ict_array[i] + "&plan_type=" + window.planType;
		var objTabLabel="ICT";
		$("#ccotabs_"+i).tabs( 'add' , objTabUrl , objTabLabel );
		var $tabs = $("#ccotabs_"+i).tabs({
    		add: function(event, ui) {
        		$tabs.tabs('select', '#' + ui.panel.id);
    			}
		});		
//	$("#ccotabs_"+i).tabs( 'load' , 2 );
	if ((window.numeracy[i]) && (window.numeracy[i].length!=0)) 
		{
			window.numeracy_array[i]='0';
			for (var numeracy in window.numeracy[i])
				{
					doUpdateField('numeracy',i,window.numeracy[i][numeracy],window.numeracy[i][numeracy]);
					window.numeracy_array[i]=window.numeracy_array[i] + ',' + window.numeracy[i][numeracy];
				}
			}
		var objTabUrl="code/lessonfunctions_2.php?GetData=numeracy&lesson_num=" + i + "&topic_id=" + window.topicId + "&data=" + window.numeracy_array[i] + "&plan_type=" + window.planType;
		var objTabLabel="Numeracy";
		$("#ccotabs_"+i).tabs( 'add' , objTabUrl , objTabLabel );
		var $tabs = $("#ccotabs_"+i).tabs({
    		add: function(event, ui) {
        		$tabs.tabs('select', '#' + ui.panel.id);
    			}
		});		
//	$("#ccotabs_"+i).tabs( 'load' , 3 );
	if ((window.risk_assessment[i]) && (window.risk_assessment[i].length)) 
		{
			window.risk_assessment_array[i]='0';
			for (var risk_assessment in window.risk_assessment[i])
				{
					doUpdateField('risk_assessment',i,window.risk_assessment[i][risk_assessment],window.risk_assessment[i][risk_assessment]);
					window.risk_assessment_array[i]=window.risk_assessment_array[i] + ',' + window.risk_assessment[i][risk_assessment];
				}
			}
		var objTabUrl="code/lessonfunctions_2.php?GetData=risk_assessment&lesson_num=" + i + "&topic_id=" + window.topicId + "&data=" + window.risk_assessment_array[i] + "&plan_type=" + window.planType;
		var objTabLabel="Risk Assessment";
		$("#ccotabs_"+i).tabs( 'add' , objTabUrl , objTabLabel );
		var $tabs = $("#ccotabs_"+i).tabs({
    		add: function(event, ui) {
        		$tabs.tabs('select', '#' + ui.panel.id);
    			}
		});		
//	$("#ccotabs_"+i).tabs( 'load' , 4 );
	var	divToReveal=document.getElementById('ccotabs_'+i);
		divToReveal.style.visibility='visible';
	var divToAttachItTo=document.getElementById('ccoDiv['+i+']');
		divToAttachItTo.appendChild(divToReveal);
	$("#ccotabs_"+i).tabs( 'select' , 0 );
}
function makeTab(i)
{
    	if (!window.differentiation_array[i]) window.differentiation_array[i]=new Array();
	if (!window.progression_array[i]) window.progression_array[i]=new Array();
	if (!window.progression_points_array[i]) window.progression_points_array[i]=new Array();
	if (!window.analyses_array[i]) window.analyses_array[i]=new Array();
	if (!window.analyses_points_array[i]) window.analyses_points_array[i]=new Array();
/*	$('#strandList_'+i).accordion({
			autoHeight: false,
			collapsible: true,
			header: 'h6',
			active: false
			 }); //create an accordian to display the objectives */
	$('#levelList_'+i).accordion({
			autoHeight: false,
			collapsible: true,
			header: 'h3',
			active: false
			 }); //create an accordian to display the objectives
	$('#lessonPartList_'+i).accordion({
			autoHeight: false,
			collapsible: true,
			header: 'h3',
			active: false
			 }); //create an accordian to display the activities
	var lessonForm=document.createElement('form');
        lessonForm.id='storeRoom_'+i;
        lessonForm.name='storeRoom_'+i;
        
        //lessonForm.action='code/lessonfunctions.php?SaveLesson=1&plan_type='+window.planType+'&uow_id='+window.unitId+'&lesson_num='+i;
	lessonForm.method='POST';
        document.getElementById('storeArea').appendChild(lessonForm);
        var lessonDiv=document.createElement('div');
	lessonDiv.id='storeRoom['+i+']';
        lessonDiv.name='storeRoom['+i+']';
        document.getElementById('storeRoom_'+i).appendChild(lessonDiv);
        if ((!document.getElementById('themeid['+i+']')) && (window.themeIds[i])){ 
		doUpdateTheme('themeid',i,window.themeIds[i]);}
	if ((!document.getElementById('theme['+i+']')) && (window.themes[i])){
		doUpdateTheme('theme',i,window.themes[i]);}
        if (window.ta[i]) doUpdateSEN('taout',i,window.ta[i]);
        if (window.sen[i]) doUpdateSEN('senout',i,window.sen[i]);
        //if (window.lessonNumber==0) $("#tabs").tabs( "option", "ajaxOptions", { async: false } );
	if (document.getElementById('themeid['+i+']'))
	{
		var lessonTabUrl="#tab"+i;
		var lessonTabLabel='Lesson '+i+'. '+document.getElementById('theme['+i+']').value;
			$("#tabs").tabs('add',lessonTabUrl,lessonTabLabel,i-1);
	}
	else
	{
            
                var lessonTabUrl="#tab"+i;
		var lessonTabLabel="lesson " + i;
			$("#tabs").tabs('add',lessonTabUrl,lessonTabLabel,i-1); 
                        
                
        }
}
function drawLessonLayout(themeId,lessonNum,themeName)
{
        doUpdateTheme('themeid',lessonNum,themeId);
	window.themeIds[lessonNum]=themeId;
	doUpdateTheme('theme',lessonNum,themeName);
	window.themes[lessonNum]=themeName;
        var themeTab = $('#tabs').tabs();
	var themeTabUrl="code/lessonfunctions_2.php?DrawPlanPage=" + lessonNum + "&theme_id=" + themeId  + "&topic_id=" + topicId + "&level=" + levelId + "&uow_id=" + window.unitId + "&objectives=" + window.objectiveIds_array[i] + "&plan_type=newPlan";
	var themeTabLabel='Lesson '+lessonNum+'. '+themeName;
	if ($('#tabs').tabs('length')==1) {
		var themeTabIndex=0; }
	else if (themeIds[lessonNum]) {
		var themeTabIndex=lessonNum-1; }
	else {
		var themeTabIndex=themeTab.tabs('option', 'selected');}
	$("#tabs li:eq(" + themeTabIndex + ") a").html(themeTabLabel);
	themeTab.tabs('url',themeTabIndex,themeTabUrl);themeTab.tabs('load',themeTabIndex);
}
function drawSetLessonLayout(lessonId,themeId,lessonNum,themeName)
{
	doUpdateTheme('themeid',lessonNum,themeId);
	window.themeIds[lessonNum]=themeId;
	doUpdateTheme('theme',lessonNum,themeName);
	window.themes[lessonNum]=themeName;
	setUpContent();
	var themeTab = $('#tabs').tabs();
	var themeTabUrl="code/lessonfunctions_2.php?DrawPlanPage=" + lessonNum + "&theme_id=" + themeId  + "&topic_id=" + topicId + "&level=" + levelId + "&uow_id=" + window.unitId + "&objectives=" + window.objectiveIds_array[i] + "&lesson_id=" + lessonId + "&plan_type=setPlan";
	var themeTabLabel='Lesson '+lessonNum+'. '+themeName;
	if ($('#tabs').tabs('length')==1) {
		var themeTabIndex=0; }
	else if (themeIds[lessonNum]) {
		var themeTabIndex=lessonNum-1; }
	else {
		var themeTabIndex=themeTab.tabs('option', 'selected');}
	$("#tabs li:eq(" + themeTabIndex + ") a").html(themeTabLabel);
	themeTab.tabs('url',themeTabIndex,themeTabUrl);themeTab.tabs('load',themeTabIndex);
        submitAndUpdate('#storeRoom_'+lessonNum);
}
function unDrawLessonLayout(lessonNum)
{
	deleteLesson(lessonNum);
        var oldPlan=document.getElementById('planPage_'+lessonNum);
        if (oldPlan)
	{
		oldPlan.parentNode.removeChild(oldPlan);
		window.lessonIds[lessonNum]=new Array();
		window.themeIds[lessonNum]=new Array();
		window.themes[lessonNum]=new Array();
		window.objectiveIds[lessonNum]=new Array();
		window.objectives[lessonNum]=new Array();
		window.objectiveStrand[lessonNum]=new Array();
                window.activityNum[lessonNum]=new Array();
		window.activityIds[lessonNum]=new Array();
		window.activityLps[lessonNum]=new Array();
		window.time[lessonNum]=new Array();
		window.keywords[lessonNum]=new Array();
		window.keywords_array[lessonNum]=new Array();
		window.ict[lessonNum]=new Array();
		window.ict_array[lessonNum]=new Array();
		window.numeracy[lessonNum]=new Array();
		window.numeracy_array[lessonNum]=new Array();
		window.risk_assessment[lessonNum]=new Array();
		window.risk_assessment_array[lessonNum]=new Array();
		window.citizenship[lessonNum]=new Array();
		window.citizenship_array[lessonNum]=new Array();
		window.teaching_assistant[lessonNum]=new Array();
		window.sen[lessonNum]=new Array();
		window.ta[lessonNum]=new Array();
		window.strand[lessonNum]=new Array();
		window.strand_array[lessonNum]=new Array();
		window.teaching_point[lessonNum]=new Array();
		window.teaching_point_array[lessonNum]=new Array();
		window.differentiation[lessonNum]=new Array();
		window.differentiation_array[lessonNum]=new Array();
		window.progression[lessonNum]=new Array();
		window.progression_array[lessonNum]=new Array();
		window.progression_points[lessonNum]=new Array();
		window.progression_points_array[lessonNum]=new Array();
		window.analyses[lessonNum]=new Array();
		window.analyses_array[lessonNum]=new Array();
		window.analyses_points[lessonNum]=new Array();
		window.analyses_points_array[lessonNum]=new Array();
                for(a=1;a<=window.activityCount[lessonNum];a++)
                    {
                                window.activityNum[lessonNum][a]=new Array();
                                window.activityIds[lessonNum][a]=new Array();
                                window.activityLps[lessonNum][a]=new Array();
                                window.time[lessonNum][a]=new Array();
                                window.keywords[lessonNum][a]=new Array();
                                window.keywords_array[lessonNum][a]=new Array();
                                window.ict[lessonNum][a]=new Array();
                                window.ict_array[lessonNum][a]=new Array();
                                window.numeracy[lessonNum][a]=new Array();
                                window.numeracy_array[lessonNum][a]=new Array();
                                window.risk_assessment[lessonNum][a]=new Array();
                                window.risk_assessment_array[lessonNum][a]=new Array();
                                window.citizenship[lessonNum][a]=new Array();
                                window.citizenship_array[lessonNum][a]=new Array();
                                window.teaching_assistant[lessonNum][a]=new Array();
                                window.sen[lessonNum][a]=new Array();
                                window.ta[lessonNum][a]=new Array();
                                window.strand[lessonNum][a]=new Array();
                                window.strand_array[lessonNum][a]=new Array();
                                window.teaching_point[lessonNum][a]=new Array();
                                window.teaching_point_array[lessonNum][a]=new Array();
                                window.differentiation[lessonNum][a]=new Array();
                                window.differentiation_array[lessonNum][a]=new Array();
                                window.progression[lessonNum][a]=new Array();
                                window.progression_array[lessonNum][a]=new Array();
                                window.progression_points[lessonNum][a]=new Array();
                                window.progression_points_array[lessonNum][a]=new Array();
                                window.analyses[lessonNum][a]=new Array();
                                window.analyses_array[lessonNum][a]=new Array();
                                window.analyses_points[lessonNum][a]=new Array();
                                window.analyses_points_array[lessonNum][a]=new Array();
                    }
                window.activityCount[lessonNum]=0;
                $('#acttabs_'+lessonNum).tabs('destroy');
		var themeTab = $('#tabs').tabs();
		if (window.levelId>0) {
		var themeTabUrl="code/lessonfunctions_2.php?GetThemes=" + lessonNum + "&topic_id=" + window.topicId + "&level=" + window.levelId + "&description=" + window.description + "&num_lessons=" + window.numLessons; }
		else {
		var themeTabUrl="code/lessonfunctions_2.php?GetSetLessons=" + lessonNum + "&topic_id=" + window.topicId + "&level=" + window.levelId + "&description=" + window.description + "&num_lessons=12"; 
		}
		var themeTabLabel="lesson " + lessonNum;
		var themeTabIndex=lessonNum-1;
                document.getElementById('storeArea').removeChild(document.getElementById('storeRoom_'+lessonNum));
                var lessonForm=document.createElement('form');
                lessonForm.id='storeRoom_'+lessonNum;
                lessonForm.name='storeRoom_'+lessonNum;
                //lessonForm.action='code/lessonfunctions.php?SaveLesson=1&plan_type='+window.planType+'&uow_id='+window.unitId+'&lesson_num='+lessonNum;
                lessonForm.method='POST';
                document.getElementById('storeArea').appendChild(lessonForm);
                var lessonDiv=document.createElement('div');
                lessonDiv.id='storeRoom['+lessonNum+']';
                lessonDiv.name='storeRoom['+lessonNum+']';
                document.getElementById('storeRoom_'+lessonNum).appendChild(lessonDiv);
		//newStoreRoom=document.createElement('div');
		//newStoreRoom.id='storeRoom['+lessonNum+']';
		//document.getElementById('storeArea').appendChild(newStoreRoom);
		$("#tabs li:eq(" + themeTabIndex + ") a").html(themeTabLabel);
		themeTab.tabs('url',themeTabIndex,themeTabUrl);
		themeTab.tabs('load',themeTabIndex);
                var options = {
                                target:'#last_save',   // target element(s) to be updated with server response
                                success:       doAction,  // post-submit callback
                                url: 'code/lessonfunctions_2.php?SaveLesson=1&plan_type='+window.planType+'&uow_id='+window.unitId+'&lesson_num='+lessonNum,
                                type: 'post'
                              };
                $('#storeRoom_'+lessonNum).ajaxForm(options);
                // save each new lesson on load
                //submitAndUpdate('#storeRoom_'+lessonNum);
                window.goLocation='';
        }
        //submitAndUpdate('#storeRoom_'+lessonNum);
}
function deleteLesson(lessonNum)
{
    jLoading('Unloading...','Unloading Lesson...','Removing Lesson Details');
    var objectName="unit_"+window.unitId;
	    objectName = getHTTPObject();
    		
    			objectName.onreadystatechange = function() {
        		if (objectName.readyState==4) {
                            	$.alerts._hide();
                                }
                            };
			
    var randomnumber = Math.floor(Math.random()*1000001);
    urlstring = 'code/lessonfunctions_2.php?DeleteLesson=1&uow_id='+window.unitId+'&lesson_num='+lessonNum+'&_=' + randomnumber;
    objectName.open("GET", urlstring, true);
    objectName.send(null);
}
function displayThemeDescription(theme,lessonNum) 
{
	themeId=theme + "[" + lessonNum + "]"; 
	themeLi="li_" + theme + "[" + lessonNum + "]";
	document.getElementById(themeLi).style.cursor = 'pointer';	
	document.getElementById(themeId).style.visibility = 'visible';
	document.getElementById(themeId).style.zIndex = 101;
}
function hideThemeDescription(theme,lessonNum)
{
	themeId=theme + "[" + lessonNum + "]"; 
	themeLi="li_" + theme + "[" + lessonNum + "]";
	if (document.getElementById(themeId)) // added this because it throws an error when we change the tab to be the lesson name
	{
		document.getElementById(themeId).style.visibility = 'hidden';
		document.getElementById(themeId).style.zIndex = 100;
	}
}
function highlightListSelected(li)
{
	li.style.background = '#CCCCCC';
	li.style.cursor = 'pointer';
}
function lowlightListSelected(li)
{
	li.style.background = '#FFFFFF';
}
function showButton(divNum)
{
		$("#questionDialogue").dialog('option', 'buttons', {"next": function() {okButtonPressed('questionDialogue',"questionDialogue",divNum + 1);}});
}
function getDisplayLevel(level)
{
	if (level==0){return "foundation";}
	if (level==1){return "1";}
	if (level==1.5){return "1/2";}
	if (level==2){return "2";}
	if (level==2.5){return "2/3";}
	if (level==3){return "3";}
	if (level==3.5){return "3/4";}
	if (level==4){return "4";}
}
// these functions save the data back to the database via ajav calls to the main php function script

// The following functions are going to be grouped together by what they control - objectives, acvtivities etc.
// starting with objectives
function unDrawActivity(lessonNum,actNum,actId)
{
	if (actId!='Add Activity')
	{
		if (document.getElementById('activityStore['+lessonNum+']['+actId+']'))
		{document.getElementById('storeRoom['+lessonNum+']').removeChild(document.getElementById('activityStore['+lessonNum+']['+actId+']'));}
                var actTab = $("#acttabs_"+lessonNum).tabs();
		var actTabIndex=actNum-1;
                //alert($("#acttabs_"+lessonNum).tabs('length'));
                //actTab.tabs('remove',actTabIndex);
                
                        
	}
        submitAndUpdate('#storeRoom_'+lessonNum);
}
function changeObjTabAndMoveOn(changeto,tab,whatTabLabel,updateField,lessonNum,objNum)
{
	changeto.style.background='#CCCCCC';
	$('#strandList_'+lessonNum+'_'+objNum).accordion( 'activate' , -1 );
	var whatTab = "$('#"+tab+"').tabs()";
	var whatTabIndex=$('#'+tab).tabs('option','selected');
	$('#'+tab+" li:eq(" + whatTabIndex + ") a").html(whatTabLabel);
	var nextTab=whatTabIndex+1;
	if (nextTab == $('#'+tab).tabs('length')) nextTab=0;
//	$('#'+tab).tabs('select',nextTab);
	doUpdateField(updateField,lessonNum,objNum,changeto.id);
	doUpdateField('objective',lessonNum,objNum,whatTabLabel);
}
function showProgressPoints(progression,lessonNum,objNum,progInputId)
{
       $('.prog_points').attr('visibility','hidden');
        if (window.currentProgressionPoint)
	{
		if (document.getElementById(currentProgressionPoint))
		{
			document.getElementById(currentProgressionPoint).style.visibility = 'hidden';
			//document.getElementById(currentProgressionPoint).style.zIndex = 100;
		}
	}
	progressionId=progression + "_" + objNum + "[" + lessonNum + "]";
        if($('#'+progInputId).attr('checked')){
	document.getElementById(progressionId).style.visibility = 'visible';
//	document.getElementById(progressionId).style.zIndex = 100;
    }
	window.currentProgressionPoint=progressionId;
}
function hideProgressPoints(progression,lessonNum,objNum)
{
        progressionId=progression + "_" + objNum + "[" + lessonNum + "]";
	document.getElementById(progressionId).style.visibility = 'hidden';
	document.getElementById(progressionId).style.zIndex = 100;
}
function showAnalysisPoints(analysis,lessonNum,objNum)
{
//	hideActivityDescription(analysis,lessonNum,objNum);
	if (window.currentAnalysisPoints)
	{
		if (document.getElementById(currentAnalysisPoints))
		{
			document.getElementById(currentAnalysisPoints).style.visibility = 'hidden';
			document.getElementById(currentAnalysisPoints).style.zIndex = 100;
		}
	}
	analysisId="point_" + analysis + "_" + objNum + "[" + lessonNum + "]"; 
	document.getElementById(analysisId).style.visibility = 'visible';
	document.getElementById(analysisId).style.zIndex = 101;
	window.currentAnalysisPoints=analysisId;
}
function hideAnalysisPoints(analysis,lessonNum,objNum)
{
	analysisId="point_" + analysis + "_" + objNum + "[" + lessonNum + "]"; 
	document.getElementById(analysisId).style.visibility = 'hidden';
	document.getElementById(analysisId).style.zIndex = 100;
}
function displayActivityDescription(activity,lessonNum,objNum) 
{
	if (window.currentActivity)
	{
		if (document.getElementById(currentActivity))
		{
			document.getElementById(currentActivity).style.visibility = 'hidden';
			document.getElementById(currentActivity).style.zIndex = 100;
		}
	}

	activityId=activity + "_" + objNum + "[" + lessonNum + "]"; 
	activityLi="li_" + activity + "_" + objNum + "[" + lessonNum + "]";
//	document.getElementById(activityLi).style.cursor = 'pointer';
	document.getElementById(activityId).style.visibility = 'visible';
	document.getElementById(activityId).style.zIndex = 101;
	window.currentActivity=activityId;
//	document.getElementById(activityId).style.background = '#F0F0F0';
//	document.getElementById(activityLi).style.background = '#F0F0F0';
}
function displayAnalysisActivityDescription(activity,lessonNum,objNum) 
{
	if (window.currentAnalysisActivity)
	{
		if (document.getElementById(currentAnalysisActivity))
		{
			document.getElementById(currentAnalysisActivity).style.visibility = 'hidden';
			document.getElementById(currentAnalysisActivity).style.zIndex = 100;
		}
	}

	activityId=activity + "_" + objNum + "[" + lessonNum + "]"; 
	activityLi="li_" + activity + "_" + objNum + "[" + lessonNum + "]";
//	document.getElementById(activityLi).style.cursor = 'pointer';
	document.getElementById(activityId).style.visibility = 'visible';
	document.getElementById(activityId).style.zIndex = 101;
	window.currentAnalysisActivity=activityId;
//	document.getElementById(activityId).style.background = '#F0F0F0';
//	document.getElementById(activityLi).style.background = '#F0F0F0';
}
function hideActivityDescription(activity,lessonNum,objNum)
{
	activityId=activity + "_" + objNum + "[" + lessonNum + "]"; 
	activityLi="li_" + activity + "_" + objNum + "[" + lessonNum + "]";
	if (document.getElementById(activityId)) // added this because it throws an error when we change the tab to be the lesson name
	{
		document.getElementById(activityId).style.visibility = 'hidden';
		document.getElementById(activityId).style.zIndex = 100;
//		document.getElementById(activityId).style.background = '#FFFFFF';
//		document.getElementById(activityLi).style.background = '#FFFFFF';
	}
}
function changeActivityTabAndMoveOn(changeto,tab,whatTabLabel,updateField,lessonNum,actNum,planType)
{
	changeto.style.fontWeight='bold';
	var whatTab = "$('#"+tab+"').tabs()";
	var whatTabIndex=$('#'+tab).tabs('option','selected');
	doUpdateActivity(updateField,lessonNum,changeto.value,changeto.value);
	doUpdateActivity('activity',lessonNum,changeto.value,whatTabLabel);
	doUpdateField('activitynum',lessonNum,actNum,changeto.value);
	var contentId=document.getElementById(updateField + "[" + lessonNum + "][" + changeto.value + "]").value;
	var objNum=whatTabIndex+1;
        var themeId=document.getElementById("themeid["+lessonNum+"]").value;
	var whatTabUrl="code/lessonfunctions_2.php?GetActivity=" + objNum + "&lesson_num=" + lessonNum +  "&content_id=" + contentId + "&strands=''&teaching_points=''&time=0&plan_type=" + planType + "&topic_status=''&topic_id=" + topicId + "&theme_id=" + themeId + "&level=" + levelId;
	var curTabA = $('#'+tab+' .ui-tabs-selected a');
        var curTab = $('#'+tab+' .ui-tabs-selected');
        var curTabIdx = $('#'+tab).tabs('option','selected');
        curTabA.html(whatTabLabel);
        curTab.attr('id',function(){
				return contentId
				});
        //$('#'+tab+" li:eq(" + whatTabIndex + ") a").html(whatTabLabel);
	//$('#'+tab+" li:eq(" + whatTabIndex + ")").attr('id',function(){
	//			return contentId
	//			});
//	alert($('#'+tab+" li:eq(" + whatTabIndex + ")").attr('id'));

	$('#'+tab).tabs('url',curTabIdx,whatTabUrl).tabs('load',curTabIdx);
        //$('#'+tab).tabs('load',curTab.index);
	//var nextTab=whatTabIndex+1;
	//if (nextTab == $('#'+tab).tabs('length')) nextTab=0;
	//$('#'+tab).tabs('select',nextTab);
	window.progression_array[lessonNum][actNum]=new Array;
	window.progression_points_array[lessonNum][actNum]=new Array;
	window.differentiation_array[lessonNum][actNum]=new Array;
	window.analyses_array[lessonNum][actNum]=new Array;
	window.analyses_points_array[lessonNum][actNum]=new Array;
        submitAndUpdate('#storeRoom_'+lessonNum);
}
function doUpdateTheme(updateField,lessonNum,updateValue)
{
        if (!document.getElementById('storeRoom['+lessonNum+']'))
	{
		storeArea=document.createElement('div');
		storeArea.id='storeRoom['+lessonNum+']';
	}
	else {
		var storeArea=document.getElementById('storeRoom['+lessonNum+']');
	}
	var fieldName=updateField+'['+lessonNum+']';
	if (!document.getElementById(fieldName)) {
		var createField=document.createElement('input');
			createField.id=fieldName;
			createField.name=fieldName;
			storeArea.appendChild(createField);}
	var updateField=document.getElementById(fieldName);
		updateField.value=updateValue;
}
function doRemoveField(updateField,lessonNum,elementNum,updateValue)
{
	var storeArea=document.getElementById('storeRoom['+lessonNum+']');
	var activityArea=document.getElementById('activityStore['+lessonNum+']['+elementNum+']');
        var actFieldName=document.getElementById(updateField+'['+lessonNum+']['+elementNum+']');
	if ((!activityArea) && (actFieldName)){
            storeArea.removeChild(actFieldName);
            }
}
function doUpdateField(updateField,lessonNum,elementNum,updateValue)
{
        var storeArea=document.getElementById('storeRoom['+lessonNum+']');
	var fieldName=updateField+'['+lessonNum+']['+elementNum+']';
	if (!document.getElementById(fieldName)) {
		var createField=document.createElement('input');
			createField.id=fieldName;
			createField.name=fieldName;
			storeArea.appendChild(createField);}
	var updateField=document.getElementById(fieldName);
		updateField.value=updateValue;
}
function doUpdateSEN(updateField,lessonNum,updateValue)
{
	var storeArea=document.getElementById('storeRoom['+lessonNum+']');
	var fieldName=updateField+'['+lessonNum+']';
	if (!document.getElementById(fieldName)) {
		var createField=document.createElement('input');
			createField.id=fieldName;
			createField.name=fieldName;
			storeArea.appendChild(createField);}
	var updateField=document.getElementById(fieldName);
		updateField.value=updateValue;
}
function doUpdateActivity(updateField,lessonNum,elementNum,updateValue)
{
	if (!document.getElementById('activityStore['+lessonNum+']['+elementNum+']')) {
		var storeArea=document.createElement('div');
			storeArea.id='activityStore['+lessonNum+']['+elementNum+']';
			document.getElementById('storeRoom['+lessonNum+']').appendChild(storeArea);
	}
	else {
		var storeArea=document.getElementById('activityStore['+lessonNum+']['+elementNum+']');
	}
	var fieldName=updateField+'['+lessonNum+']['+elementNum+']';
	if (!document.getElementById(fieldName)) {
		var createField=document.createElement('input');
			createField.id=fieldName;
			createField.name=fieldName;
			storeArea.appendChild(createField);}
	var updateField=document.getElementById(fieldName);
		updateField.value=updateValue;
}
function doUpdateField3Dim(updateField,lessonNum,elementNum,updateValue,elem)
{
	var storeArea=document.getElementById('activityStore['+lessonNum+']['+elementNum+']');
		var fieldName=updateField+'['+lessonNum+']['+elementNum+']['+elem+']';
	if (!document.getElementById(fieldName)) {
		var createField=document.createElement('input');
			createField.id=fieldName;
			createField.name=fieldName;
			storeArea.appendChild(createField);
		var updateField=document.getElementById(fieldName);
			updateField.value=updateValue;}
}
function doUpdateField4Dim(updateField,lessonNum,elementNum,updateValue,elem,elemOwner)
{
	var storeArea=document.getElementById('activityStore['+lessonNum+']['+elementNum+']');
		var fieldName=updateField+'['+lessonNum+']['+elementNum+']['+elemOwner+']['+elem+']';
	if (!document.getElementById(fieldName)) {
		var createField=document.createElement('input');
			createField.id=fieldName;
			createField.name=fieldName;
			storeArea.appendChild(createField);
		var updateField=document.getElementById(fieldName);
			updateField.value=updateValue;}
}
function toggleUpdateField(updateField,lessonNum,elementNum,elem,strandId,objective)
{
    var style2 = elem.style;
//    style2.fontWeight = style2.fontWeight? "":"bold";
	var storeArea=document.getElementById('storeRoom['+lessonNum+']');
		var idFieldName='objectiveid['+lessonNum+']['+elem+']';
		var strandFieldName='objectivestrand['+lessonNum+']['+elem+']';
		var objFieldName='objective['+lessonNum+']['+elem+']';
	if (!document.getElementById(idFieldName)) {
		var idCreateField=document.createElement('input');
			idCreateField.id=idFieldName;
			idCreateField.name=idFieldName;
			storeArea.appendChild(idCreateField);
		var idUpdateField=document.getElementById(idFieldName);
			idUpdateField.value=elem;
		var strandCreateField=document.createElement('input');
			strandCreateField.id=strandFieldName;
			strandCreateField.name=strandFieldName;
			storeArea.appendChild(strandCreateField);
		var strandUpdateField=document.getElementById(strandFieldName);
			strandUpdateField.value=strandId;
		var objCreateField=document.createElement('input');
			objCreateField.id=objFieldName;
			objCreateField.name=objFieldName;
			storeArea.appendChild(objCreateField);
		var objUpdateField=document.getElementById(objFieldName);
			objUpdateField.value=elem;
/*			window.objectiveIds[lessonNum].splice(window.objectiveIds[lessonNum].length,0,elem);
			window.objectives[lessonNum].splice(window.objectives[lessonNum].length,0,objective);
			window.objectiveStrand[lessonNum].splice(window.objectiveStrand[lessonNum].length,0,strandId);*/
			window.objectiveIds[lessonNum].splice(objId,0,elem);
			window.objectives[lessonNum].splice(objId,0,objective);
			window.objectiveStrand[lessonNum].splice(objId,0,strandId);
			}
	else {
			storeArea.removeChild(document.getElementById(idFieldName));
			storeArea.removeChild(document.getElementById(strandFieldName));
			storeArea.removeChild(document.getElementById(objFieldName));
			for (var objId in window.objectiveIds[lessonNum]) {
				if (window.objectiveIds[lessonNum][objId]==elem) {
							window.objectiveIds[lessonNum].splice(objId,1); 
							window.objectives[lessonNum].splice(objId,1); 
							window.objectiveStrand[lessonNum].splice(objId,1); 
							}
			}
		}
	updateObjList(strandId,elem,lessonNum);
}
function updateObjList(strandId,objectiveNum,lessonNum)
{
	strandDiv=document.getElementById('strandList_'+lessonNum+'_'+strandId);
        if(strandDiv)
        {
	strandDiv.innerHTML='<ul style=\'margin-left: -20px;#display:inline;#margin-left: 0px\'>';
	for (var objectiveId in window.objectiveIds[lessonNum])
	{
		if (window.objectiveStrand[lessonNum][objectiveId]==strandId)
			{
/*				alert (dump(window.objectiveIds[lessonNum]));
				alert (dump(window.objectives[lessonNum]));
				alert (dump(window.objectiveStrand[lessonNum]));*/
				//objectiveNum=parseInt(objectiveId)+1;
                                if (ie)
                                    {
                                        strandDiv.innerHTML=strandDiv.innerHTML+'<li>'+window.objectives[lessonNum][objectiveId]+"</li>";  
                                    }
                                else
                                    {
                                      strandDiv.innerHTML=strandDiv.innerHTML+'<li><a class=\'ui-widget\' href=\"#\">'+window.objectives[lessonNum][objectiveId]+"</a></li>";
                                    }

                        }
        }
        strandDiv.innerHTML=strandDiv.innerHTML+'</ul>';
        strandDiv.style.visibility='visible';
    }
}
function toggleUpdateField2Dim(updateField,lessonNum,elementNum,elem)
{
    var style2 = elem.style;
    var elemValue=elem.value;
//    style2.fontWeight = style2.fontWeight? "":"bold";
	var storeArea=document.getElementById('storeRoom['+lessonNum+']');
        var fieldName=updateField+'['+lessonNum+']['+elemValue+']';
	if (!document.getElementById(fieldName)) {
		var createField=document.createElement('input');
			createField.id=fieldName;
			createField.name=fieldName;
			storeArea.appendChild(createField);
		var updateField=document.getElementById(fieldName);
			updateField.value=elem.value;}
	else {storeArea.removeChild(document.getElementById(fieldName));}

}
function toggleUpdateField3Dim(updateField,lessonNum,elementNum,elem)
{
var alreadyThere=0;    
var style2 = elem.style;
//    style2.fontWeight = style2.fontWeight? "":"bold";
	var storeArea=document.getElementById('activityStore['+lessonNum+']['+elementNum+']');
	var fieldName=updateField+'['+lessonNum+']['+elementNum+']['+elem.value+']';
        var progPointDiv=elem.value+'_'+elementNum+'['+lessonNum+']';
        var progPointClass=elem.value+'_'+elementNum+'['+lessonNum+']';
	if (updateField=='teaching_point')
		{
			if (!window.teaching_point[lessonNum][elementNum]) window.teaching_point[lessonNum][elementNum]=new Array();
			if (window.teaching_point[lessonNum][elementNum][elem.value])
					{ 
/*					if (ie) window.differentiation[lessonNum][elementNum].splice(window.differentiation[lessonNum][elementNum][elem.value],1);
					else */
					window.teaching_point[lessonNum][elementNum].splice(elem.value,1);
//					else window.differentiation[lessonNum][elementNum].splice(window.differentiation[lessonNum][elementNum].indexOf(window.differentiation[lessonNum][elementNum][elem.value]),1);
					}
			else 
				{
					window.teaching_point[lessonNum][elementNum][elem.value]=elem.value;
				}
		}
	if (updateField=='differentiation')
		{
			if (!window.differentiation[lessonNum][elementNum]) window.differentiation[lessonNum][elementNum]=new Array();
			if (window.differentiation[lessonNum][elementNum][elem.value])
					{ 
/*					if (ie) window.differentiation[lessonNum][elementNum].splice(window.differentiation[lessonNum][elementNum][elem.value],1);
					else */
					window.differentiation[lessonNum][elementNum].splice(elem.value,1);
//					else window.differentiation[lessonNum][elementNum].splice(window.differentiation[lessonNum][elementNum].indexOf(window.differentiation[lessonNum][elementNum][elem.value]),1);
					}
			else 
				{
					window.differentiation[lessonNum][elementNum][elem.value]=elem.value;
				}
		}
	if (updateField=='progression')
		{
			if (!window.progression[lessonNum][elementNum]) window.progression[lessonNum][elementNum]=new Array();
			if (window.progression[lessonNum][elementNum][elem.value])
					{ 
					window.progression[lessonNum][elementNum].splice(elem.value,1);
//					else window.progression[lessonNum][elementNum].splice(window.progression[lessonNum][elementNum].indexOf(window.progression[lessonNum][elementNum][elem.value]),1);
					}
			else 
				{
					window.progression[lessonNum][elementNum][elem.value]=elem.value;
				}
		}
	if (updateField=='analyses')
		{
			if (!window.analyses[lessonNum][elementNum]) window.analyses[lessonNum][elementNum]=new Array();
			if (window.analyses[lessonNum][elementNum][elem.value])
					{ 
					window.analyses[lessonNum][elementNum].splice(elem.value,1);
//					else window.analyses[lessonNum][elementNum].splice(window.analyses[lessonNum][elementNum].indexOf(window.analyses[lessonNum][elementNum][elem.value]),1);
					}
			else 
				{
					window.analyses[lessonNum][elementNum][elem.value]=elem.value;
				}
		}
		if (!document.getElementById(fieldName)) {
		var createField=document.createElement('input');
			createField.id=fieldName;
			createField.name=fieldName;
			storeArea.appendChild(createField);
		var fieldToUpdate=document.getElementById(fieldName);
			fieldToUpdate.value=elem.value;
			if (updateField=='progression')
				{
					showProgressPoints(elem.value,lessonNum,elementNum,elem.id);
					window.currentProgressionPoint=elem.value;

				}
			else if (updateField=='analyses')
				{
//					showAnalysisPoints(elem.value,lessonNum,elementNum);
//					displayAnalysisActivityDescription(elem.value,lessonNum,elementNum);
					window.currentAnalysesPoint=elem.value;
				}
			}
	else {
			if (updateField=='progression')
				{
				if (window.progression_points_array[lessonNum][elementNum][elem.value]){
                                    for (progPoint in window.progression_points[lessonNum][elementNum][elem.value])
                                        {
                                            if(document.getElementById('progression_points['+lessonNum+']['+elementNum+']['+elem.value+']['+progPoint+']').value!=elem.value) storeArea.removeChild(document.getElementById('progression_points['+lessonNum+']['+elementNum+']['+elem.value+']['+progPoint+']'));
                                        }
                                    window.progression_points_array[lessonNum][elementNum][elem.value]='';
                                    }
                                if (window.currentProgressionPoint) window.currentProgressionPoint='';
                                $('.'+progPointClass).attr('checked', false);
                                hideProgressPoints(elem.value,lessonNum,elementNum);
//                                debug('progpoint class='+progPointClass);
				}
			else if (updateField=='analyses')
				{
//					hideAnalysisPoints(elem.value,lessonNum,elementNum);
//					hideActivityDescription(elem.value,lessonNum,elementNum);
					if (window.analyses_points_array[lessonNum][elementNum][elem.value]) window.analyses_points_array[lessonNum][elementNum][elem.value]='';
					if (window.currentAnalysesPoint) window.currentAnalysesPoint='';
				}
             storeArea.removeChild(document.getElementById(fieldName));
             
        }
}
function toggleUpdateField4Dim(updateField,lessonNum,elementNum,elem,elemOwner)
{
var alreadyThere=0;    
var style2 = elem.style;
//    style2.fontWeight = style2.fontWeight? "":"bold";

	var storeArea=document.getElementById('activityStore['+lessonNum+']['+elementNum+']');
	var fieldName=updateField+'['+lessonNum+']['+elementNum+']['+elemOwner+']['+elem.value+']';
	if (updateField=='progression_points')
		{
			if (!window.progression_points[lessonNum][elementNum]) window.progression_points[lessonNum][elementNum]=new Array();
			if (!window.progression_points[lessonNum][elementNum][elemOwner]) window.progression_points[lessonNum][elementNum][elemOwner]=new Array();
			if (window.progression_points[lessonNum][elementNum][elemOwner][elem.value])
			{ 
				var targetArr=new Array();
                                for (progPoint in window.progression_points[lessonNum][elementNum][elemOwner])
                                    {
                                        if (progPoint!=elem.value) targetArr[progPoint]=progPoint;
                                    }
                                window.progression_points[lessonNum][elementNum][elemOwner].length=0;
                                for (target in targetArr)
                                    {
                                        window.progression_points[lessonNum][elementNum][elemOwner][target]=target;
                                    }
			}
			else 
			{
                                window.progression_points[lessonNum][elementNum][elemOwner][elem.value]=elem.value;
                        }
		}
	
	if (updateField=='analyses_points')
		{
			if (!window.analyses_points[lessonNum][elementNum]) window.analyses_points[lessonNum][elementNum]=new Array();
			if (!window.analyses_points[lessonNum][elementNum][elemOwner]) window.analyses_points[lessonNum][elementNum][elemOwner]=new Array();
			if (window.analyses_points[lessonNum][elementNum][elemOwner][elem.value])
			{
				var targetArr=new Array();
                                for (analysesPoint in window.analyses_points[lessonNum][elementNum][elemOwner])
                                    {
                                        if (analysesPoint!=elem.value) targetArr[analysesPoint]=analysesPoint;
                                    }
                                window.analyses_points[lessonNum][elementNum][elemOwner].length=0;
                                for (target in targetArr)
                                    {
                                        window.analyses_points[lessonNum][elementNum][elemOwner][target]=target;
                                    }
			}
			else 
			{
				window.analyses_points[lessonNum][elementNum][elemOwner][elem.value]=elem.value;
			}
		}
	if (!document.getElementById(fieldName)) {
		var createField=document.createElement('input');
			createField.id=fieldName;
			createField.name=fieldName;
			storeArea.appendChild(createField);
		var updateField=document.getElementById(fieldName);
			updateField.value=elem.value;}
	else {storeArea.removeChild(document.getElementById(fieldName));}
}
function showHelpDialog(helpTopic)
{
        var helpTopicArray=helpTopic.split("-");
        if (helpTopicArray[0]=="cco") helpSubtitle="Cross Curricular Opportunities";
        else if (helpTopicArray[0]=="exit") helpSubtitle="Save, Print & Exit";
        else helpSubtitle=helpTopicArray[0];
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
    urlstring = "code/lessonfunctions_2.php?GetHelp=" + helpTopic;
    objectName.open("GET", urlstring, true);
    objectName.send(null);
        $('#helpDialog').dialog('option', 'title', helpTitle);
	$('#helpDialog').dialog('open');
}
function showDifferentiationDialog(lessonNum,objNum,contentId)
{
	var differentiations='';
//	if (window.differentiation_array[lessonNum]) var differentiations=window.differentiation_array[lessonNum][objNum];
	if ((window.differentiation[lessonNum][objNum]) && (window.differentiation[lessonNum][objNum].length!=0))
		{
			window.differentiation_array[lessonNum][objNum]='0';
			for (var subDiff in window.differentiation[lessonNum][objNum]) 
				{ 
					window.differentiation_array[lessonNum][objNum]=window.differentiation_array[lessonNum][objNum] + ',' + window.differentiation[lessonNum][objNum][subDiff]; 
				}
		}
	var divToFillId=document.getElementById('differentiationDialog');
	var objectName="differentiationObject";
	    objectName = getHTTPObject();
    	objectName.onreadystatechange = function() {
        	if (objectName.readyState==4) {
				divToFillId.innerHTML=objectName.responseText;
				divToFillId.style.visibility='visible';
        		}
    	};
    urlstring = "code/lessonfunctions_2.php?GetDifferentiation=" + lessonNum + "&content_id=" + objNum + "&obj_num=" + contentId + "&differentiations=" + window.differentiation_array[lessonNum][objNum];
    objectName.open("GET", urlstring, true);
    objectName.send(null);
	$('#differentiationDialog').dialog('open');
}
function showProgressionDialog(lessonNum,objNum,contentId)
{
	var progression_arr=new Array();
	var progression_points='';
	var progression_num=1;
	if ((window.progression[lessonNum][objNum]) && (window.progression[lessonNum][objNum].length!=0))
		{
			window.progression_array[lessonNum][objNum]='0';
			for (var subProg in window.progression[lessonNum][objNum]) 
				{ 
					window.progression_array[lessonNum][objNum]=window.progression_array[lessonNum][objNum] + ',' + window.progression[lessonNum][objNum][subProg]; 
						if ((window.progression_points[lessonNum][objNum][subProg]) && (window.progression_points[lessonNum][objNum][subProg]!=0))
							{
								window.progression_points_array[lessonNum][objNum][subProg]=subProg;
								for (var subProgPoint in window.progression_points[lessonNum][objNum][subProg]) 
									{ 
										window.progression_points_array[lessonNum][objNum][subProg]=window.progression_points_array[lessonNum][objNum][subProg] + ',' + window.progression_points[lessonNum][objNum][subProg][subProgPoint]; 
									}
								if (progression_num==1) progression_points=window.progression_points_array[lessonNum][objNum][subProg];
								else progression_points=progression_points + ';' + window.progression_points_array[lessonNum][objNum][subProg];
							}
				progression_num++;
				}
		}
	var divToFillId=document.getElementById('progressionDialog');
	var objectName="progressionObject";
	    objectName = getHTTPObject();
    	objectName.onreadystatechange = function() {
        	if (objectName.readyState==4) {
				divToFillId.innerHTML=objectName.responseText;
				divToFillId.style.visibility='visible';
        		}
    	};
    urlstring = "code/lessonfunctions_2.php?GetProgression=" + lessonNum + "&content_id=" + objNum + "&obj_num=" + contentId + "&progressions=" + window.progression_array[lessonNum][objNum] + "&progression_points=" + progression_points;
    objectName.open("GET", urlstring, true);
    objectName.send(null);
	$('#progressionDialog').dialog('open');
}
function showAnalysisDialog(lessonNum,objNum,contentNum)
{
	var analyses_points;
	var analyses_arr=new Array();
	var analyses_num=1;
	if ((window.analyses[lessonNum][objNum]) && (window.analyses[lessonNum][objNum].length!=0))
		{
			window.analyses_array[lessonNum][objNum]='0';
			for (var subAnal in window.analyses[lessonNum][objNum]) 
				{ 
					window.analyses_array[lessonNum][objNum]=window.analyses_array[lessonNum][objNum] + ',' + window.analyses[lessonNum][objNum][subAnal];
						/*if ((window.analyses_points[lessonNum][objNum][subAnal]) && (window.analyses_points[lessonNum][objNum][subAnal]!=0))
							{
								window.analyses_points_array[lessonNum][objNum][subAnal]=subAnal;
								for (var subAnalPoint in window.analyses_points[lessonNum][objNum][subAnal]) 
									{ 
										window.analyses_points_array[lessonNum][objNum][subAnal]=window.analyses_points_array[lessonNum][objNum][subAnal] + ',' + window.analyses_points[lessonNum][objNum][subAnal][subAnalPoint]; 
									}
								if (analyses_num==1) analyses_points=window.analyses_points_array[lessonNum][objNum][subAnal];
								else analyses_points=analyses_points + ';' + window.analyses_points_array[lessonNum][objNum][subAnal];
							}*/
				analyses_num++;
				}
		}
	var divToFillId=document.getElementById('analysisDialog');
	var objectName="analysisObject";
	    objectName = getHTTPObject();
    	objectName.onreadystatechange = function() {
        	if (objectName.readyState==4) {
				divToFillId.innerHTML=objectName.responseText;
				divToFillId.style.visibility='visible';
        		}
    	};
    urlstring = "code/lessonfunctions_2.php?GetAnalysis=" + lessonNum + "&content_id=" + objNum + "&obj_num=" + contentNum + "&topic_id=" + topicId + "&level=" + levelId + "&theme_id=" + window.themeIds[lessonNum] + "&analyses=" + window.analyses_array[lessonNum][objNum] + "&analyses_points=" + analyses_points;
    objectName.open("GET", urlstring, true);
    objectName.send(null);
	$('#analysisDialog').dialog('open');
}
function dialogButtonPressed(whichDialog)
{
	$("#"+whichDialog).dialog('close')
}
function showInstruction(lessonNum,instruction)
{
        if (instruction)
//	document.getElementById(instruction + '_full').style.visibility='visible';
       if ($('#'+instruction + '_full').is(":visible")==true){
           $('.top_help').hide();
       }
       else {
           $('.top_help').show()
       }
        submitAndUpdate('#storeRoom_'+lessonNum);
}
function hideInstruction(lessonNum,instruction)
{
//	if (instruction)
//	document.getElementById(instruction + '_full').style.visibility='hidden';
}
function updateMyUnits()
{
		var objectName="lessons";
    	objectName = getHTTPObject();
   		objectName.onreadystatechange = function() {
       		if (objectName.readyState==4) {
				$("#accordion2").accordion('destroy').accordion();
				$("#accordion2").accordion({
					autoHeight: false,
					collapsible: true,
					active: false,
					header: 'h4',
					navigation: true,
					clearStyle: true,
					alwaysOpen: false
					});
alert (objectName.responseText);
				window.opener.document.getElementById('accordion2').innerHTML=objectName.responseText
       			}
   		};
    	urlstring = "code/basefunctions.php?GetMyUnits=1";
    	objectName.open("GET", urlstring, true);
    	objectName.send(null);
}
function loadScript(scriptURL) {var scriptElem = document.createElement('SCRIPT');scriptElem.setAttribute('language', 'JavaScript');scriptElem.setAttribute('src', scriptURL);document.body.appendChild(scriptElem);}
// tha function above is used to debug ajax calls from ie
// to use it paste this into the start of the scripts
/*function printPlan(planId) {
	var mine=window.open('','','width=1,height=1,left=0,top=0,scrollbars=no');
	if (mine)
	{
	mine.close();
	objectName = getHTTPObject();
        if (moz){
    		objectName.onload = objectName.onerror = objectName.onabort = function(){
			var print_options = 'scrollbars,0,location=yes,resizable,width=900,height=700';
			window.open(objectName.responseText,'Plan_Print',print_options);};
    		}
        else {
                objectName.onreadystatechange = function() {
                if (objectName.readyState==4) {
			var print_options = 'scrollbars,0,location=yes,resizable,width=900,height=700';
			window.open(objectName.responseText,'Plan_Print',print_options);
       		}
            };
        }
	urlstring = "code/lessonfunctions.php?PrintPlan=" + planId + "&ajax=y";
    objectName.open("GET", urlstring, false);
    objectName.send(null);
	}
	else
	{
		alert('We have detected that you are blocking popups. In order to print you need to enable popups from this site.');
	}
}
function printPlan(planNum,unitId)
{
    if (planNum==0)
        {
            var $tabs=$('#tabs').tabs();
            planNum=$tabs.tabs('option', 'selected')+1;
         }
    submitAndUpdate('#storeRoom_'+planNum);
    sleep(3000);
    if (window.numLessons==1) planNum=1;
     var titleDiv= $('#title_div').html();
    $('#title_div').html("<div class='loading'>preparing plan for printing...</div>");
   var objectName="plan_print";
	objectName = getHTTPObject();
    	if (moz){
    		objectName.onload = objectName.onerror = objectName.onabort = function(){
		//alert (objectName.responseText);
                $('#title_div').html(titleDiv);
		eval(objectName.responseText)
                };
    		} else
                {
		objectName.onreadystatechange = function() {
        	if (objectName.readyState==4) {
                    //alert (objectName.responseText);
                $('#title_div').html(titleDiv);
                    eval(objectName.responseText);
                    }
    		};
	}
    //window.goLocation=('code/plan_print.php?lesson_num=' + planNum + '&unit_id=' + unitId);
    urlstring = 'code/plan_print_2.php?lesson_num=' + planNum + '&unit_id=' + unitId;
    objectName.open("GET", urlstring, false);
    objectName.send(null);
}*/
function printPlan(lessonNum,unitId)
{
    if(lessonNum==0){
        var curTabIdx = $('#tabs').tabs('option','selected');
        lessonNum=curTabIdx+1; 
        }
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
                    stat=clearInterval(stat);
                    });
                }
                // failure
                else if (response.result==0){
                showOverlay(response.detail,response.more);
                }   
        });
}
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}
function mainPrintAssessment(VarAssess,VarTopic,VarLevel,VarUnit) {
    //alert('Assess: ' + VarAssess + '&Topic: ' + VarTopic + '&VarLevel: '+ VarLevel );
    document.location=('/tplan/code/assessment_print_2.php?assess_id='+ VarAssess + '&topic_id='+ VarTopic + '&level_id=' + VarLevel + '&unit_id=' + VarUnit);
}

function goHome()
{
    window.doneLessons=0;
    if (window.userLevel==1||window.numLessons==1) i=1;
    else i=$('#tabs').tabs('option','selected')+1;
    //for (i = 1 ; i <= window.numLessons ; i++) {
    //    if (i==window.numLessons)
    //        {
               var lessonForm=document.getElementById('storeRoom_'+i);
               var whereNext=document.createElement('input');
               window.goLocation=('/staffroom');
               whereNext.name='where_next';
               whereNext.id='where_next';
               whereNext.style.visibility='hidden';
               whereNext.value='/staffroom';
               if (lessonForm){
               lessonForm.appendChild(whereNext);}
     //       }
     submitAndUpdate('#storeRoom_'+i);
    //}
}
function trialNotification(){
    alert('As a free trial user your access is restricted to \'Core Task - Introductory Lesson\'.\n\nPlease select the link below to subscribe in full');
}function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
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
$(function() {
	$("#progressionDialog").dialog({
				buttons: {"return": function() {dialogButtonPressed('progressionDialog');}},
				modal:true,
				position:'top',
				width:1000,
				minHeight:600,
				title:"Activity Progression Details",
				dialogClass:'information',
				autoOpen:false
	 });
});
$(function() {
	$("#differentiationDialog").dialog({
				buttons: {"return": function() {dialogButtonPressed('differentiationDialog');}},
				modal:true,
				position:'top',
				width:800,
				minHeight:400,
				title:"Activity Differentiation Details",
				dialogClass:'information',
				autoOpen:false
	 });
});
$(function() {
	$("#analysisDialog").dialog({
				buttons: {"return": function() {dialogButtonPressed('analysisDialog');}},
				modal:true,
				position:'top',
				width:1200,
				minHeight:400,
				title:"Activity Analysis Details",
				dialogClass:'information',
				autoOpen:false
	 });

});
$(function() {
	$("#helpDialog").dialog({
				buttons: {  },
				modal:false,
				position:'top',
				width:600,
				minHeight:400,
				title:"Help",
				dialogClass:'information',
				autoOpen:false
	 });

});
function showRequest(formData, jqForm, options) {
    var queryString = $.param(formData);
    alert('About to submit: \n\n' + window.numLessons);
    return true;
}
function doAction(responseText, statusText, xhr, $form)  {
    window.doneLessons=window.doneLessons + 1;
    if (window.doneLessons==window.numLessons) document.location='myplans.php';
    if (window.goLocation) document.location=window.goLocation;
}
function submitAndUpdate(lesson) {
   $(lesson).submit();
}
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



