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
// the following functions display things or hide them or change their colour
function go(tOut){
		$("#target").html('<div id="splash" style="display:none"><div style="position:absolute;left:85px;top:25px"><img src="/tplan/images/ajax-loader.gif"></div><span class="appName"><h1></h1></span></div>');
		$("#splash").splashQ({
			splashBox: "splash",
			abortCallback: function(){window.alert("logout!")},
			abortMsg: "Logout",
			errorMsg: 'An error has occurred. <br /><br />Please choose an action',
			maxRetries: 1,
			timeout: tOut,
			scripts:
			[
				{name:"Retrieving Unit", src:"/tplan/js/planUnit_2.js"},
				{name:"Lesson Layouts", src:"/tplan/js/planLessons_2.js"},
				{name:"Lesson Settings", src:"/tplan/js/planContent_2.js"},
				{name:"Objectives", src:"/tplan/js/planObj_2.js"},
				{name:"Activities", src:"/tplan/js/planActivities_2.js"},
				{name:"Cross-Curricular", src:"/tplan/js/planCco_2.js"},
				{name:"Lesson Content", src:"/tplan/js/planUi_2.js"}
			]
		}
	); // end splashscreen
}
function canIEditThis(unit)
{
    var objectName="unit_"+window.unitId;
	    objectName = getHTTPObject();
    		if (moz){
    			objectName.onload = objectName.onerror = objectName.onabort = function(){
				if (objectName.responseText=='no')
                                    {
                                        alert('You are not allowed to edit this Unit');
                                        window.back();
                                    }
                                    else
                                        {
                                            go(20000);
                                        }
                        };
    		} else {
    			objectName.onreadystatechange = function() {
        		if (objectName.readyState==4) {
                            	if (objectName.responseText=='no')
                                    {
                                        alert('You are not allowed to edit this Unit');
                                         window.back();
                                    }
                                    else
                                        {
                                            go(20000);
                                        }
                                }
                            };
			}
    var randomnumber = Math.floor(Math.random()*1000001);
    //urlstring = "code/lessonfunctions_2.php?GetUnit=" + window.unitId + "&_=" + randomnumber;
    urlstring = "code/lessonfunctions_2.php?GetUnit=" + window.unitId + "&user_id="+window.userId+"&user_level="+window.userLevel+"&_=" + randomnumber;
    objectName.open("GET", urlstring, false);
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
//	alert ('Not yet implemented for activity - '+actNum);
	if (actId!='Add Activity')
	{
		if (document.getElementById('activityStore['+lessonNum+']['+actId+']'))
		{document.getElementById('storeRoom['+lessonNum+']').removeChild(document.getElementById('activityStore['+lessonNum+']['+actId+']'));}
                var actTab = $("#acttabs_"+lessonNum).tabs();
		var actTabIndex=actNum-1;
		actTab.tabs('remove',actTabIndex);
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
	$('#'+tab+" li:eq(" + whatTabIndex + ") a").html(whatTabLabel);
	$('#'+tab+" li:eq(" + whatTabIndex + ")").attr('id',function(){
				return contentId
				});
//	alert($('#'+tab+" li:eq(" + whatTabIndex + ")").attr('id'));
	$("#acttabs_"+lessonNum).tabs('url',whatTabIndex,whatTabUrl);$("#acttabs_"+lessonNum).tabs('load',whatTabIndex);
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
	var fieldName=document.getElementById(updateField+'['+lessonNum+']['+elementNum+']');
	if ((!activityArea) && (fieldName)){
		storeArea.removeChild(fieldName);}
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
}*/
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
		window.open(objectName.responseText,'_blank');
                };
    		} else
                {
		objectName.onreadystatechange = function() {
        	if (objectName.readyState==4) {
                    //alert (objectName.responseText);
                $('#title_div').html(titleDiv);
                    window.open(objectName.responseText,'_blank');
                    }
    		};
	}
    //window.goLocation=('code/plan_print.php?lesson_num=' + planNum + '&unit_id=' + unitId);
    urlstring = 'code/plan_print_2.php?lesson_num=' + planNum + '&unit_id=' + unitId;
    objectName.open("GET", urlstring, false);
    objectName.send(null);
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

