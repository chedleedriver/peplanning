function drawLessonLayout(themeId,lessonNum,themeName)
{
	doUpdateTheme('themeid',lessonNum,themeId);
	window.themeIds[lessonNum]=themeId;
	doUpdateTheme('theme',lessonNum,themeName);
	window.themes[lessonNum]=themeName;
	var themeTab = $('#tabs').tabs();
	var themeTabUrl="code/lessonfunctions.php?DrawPlanPage=" + lessonNum + "&theme_id=" + themeId  + "&topic_id=" + topicId + "&level=" + levelId + "&uow_id=" + window.unitId + "&objectives=" + window.objectiveIds_array[i] + "&plan_type=newPlan";
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
function drawNewLessonLayout(themeId,lessonNum,themeName)
{
	doUpdateTheme('themeid',lessonNum,themeId);
	window.themeIds[lessonNum]=themeId;
	doUpdateTheme('theme',lessonNum,themeName);
	window.themes[lessonNum]=themeName;
	var themeTab = $('#tabs').tabs();
	var themeTabUrl="code/lessonfunctions.php?DrawPlanPage=" + lessonNum + "&theme_id=" + themeId  + "&topic_id=" + topicId + "&level=" + levelId + "&uow_id=" + window.unitId + "&objectives=" + window.objectiveIds_array[i] + "&plan_type=brandNewPlan";
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
	var themeTab = $('#tabs').tabs();
	var themeTabUrl="code/lessonfunctions.php?DrawPlanPage=" + lessonNum + "&theme_id=" + themeId  + "&topic_id=" + topicId + "&level=" + levelId + "&uow_id=" + window.unitId + "&objectives=" + window.objectiveIds_array[i] + "&lesson_id=" + lessonId + "&plan_type=setPlan";
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
        var oldPlan=document.getElementById('planPage_'+lessonNum);
        if (oldPlan)
	{
                oldPlan.parentNode.removeChild(oldPlan);
		window.lessonIds[lessonNum]=new Array();
		window.themeIds[lessonNum]=new Array();
		window.themes[lessonNum]=new Array();
		window.objectiveIds[lessonNum]=new Array();
		window.objectives[lessonNum]=new Array();
		window.objectiveStrand[lessonNum]=new Array;
		window.activityIds[lessonNum]=new Array();
		window.activityLps[lessonNum]=new Array();
                window.activityNum[lessonNum]=new Array();
                window.activityCount[lessonNum]=0;
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
		var themeTab = $('#tabs').tabs();
		if ((window.planType=="newPlan")&&(window.originalType!='s')) {
		var themeTabUrl="code/lessonfunctions.php?GetThemes=" + lessonNum + "&topic_id=" + window.topicId + "&level=" + window.levelId + "&description=" + window.description + "&num_lessons=" + window.numLessons + "&plan_type=brandNewPlan"; }
		else {
		var themeTabUrl="code/lessonfunctions.php?GetSetLessons=" + lessonNum + "&topic_id=" + window.topicId + "&level=" + window.levelId + "&description=" + window.description + "&num_lessons=12"; 
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
                                url: 'code/lessonfunctions.php?SaveLesson=1&plan_type='+window.planType+'&uow_id='+window.unitId+'&lesson_num='+lessonNum,
                                type: 'post'
                              };
                $('#storeRoom_'+lessonNum).ajaxForm(options);
                // save each new lesson on load
                submitAndUpdate('#storeRoom_'+lessonNum);
                window.goLocation='';
        }
        //submitAndUpdate('#storeRoom_'+lessonNum);
}
