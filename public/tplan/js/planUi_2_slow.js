    $(document).ready(function() {
        
	var $tabs=$('#tabs').tabs({
			panelTemplate:'<div style="height:650px"></div>',
                        spinner: 'Loading...',
			tabTemplate: '<li id="#{label}" class="ui-widget"><a style="white-space:nowrap;" href="#{href}"><span>#{label}</span></a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>',
			ajaxOptions: {
                            async: false,
                            cache:false,
                            error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html("Couldn't load this tab. We'll try to fix this as soon as possible");}
                        },
			cache:true
			})
	$('#tabs span.ui-icon-close').live('click', function() {
			var index = $('li',$tabs).index($(this).parent());
			unDrawLessonLayout(index+1);
		});
	var lessonTabsDiv=document.getElementById('tabs'); // finished asking the questions, time to create some 
		lessonTabsDiv.style.visibility = 'visible'; // tabs to put the plans in
//alert (window.userLevel);
if (window.userLevel==1) numLessons=1;
for (i = 1 ; i <= numLessons ; i++) {
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
	if (document.getElementById('themeid['+i+']'))
	{
		var lessonTabUrl="code/lessonfunctions.php?DrawPlanPage=" + i + "&theme_id=" + document.getElementById('themeid['+i+']').value + "&topic_id=" + window.topicId + "&level=" + window.levelId + "&uow_id=" + window.unitId + "&objectives=" + window.objectiveIds_array[i] + "&plan_type=" + window.planType;
		var lessonTabLabel='Lesson '+i+'. '+document.getElementById('theme['+i+']').value;
			$("#tabs").tabs('add',lessonTabUrl,lessonTabLabel);
	}
	else
	{
            if ((window.planType=="newPlan")&&(window.originalType!='s'))
                {
                    var lessonTabUrl="code/lessonfunctions.php?GetThemes=" + i + "&topic_id=" + window.topicId + "&level=" + window.levelId + "&description=" + window.description + "&num_lessons=" + window.numLessons + "&plan_type=" + window.planType;
                    var lessonTabLabel="lesson " + i;
			$("#tabs").tabs('add',lessonTabUrl,lessonTabLabel); 
                }
            else
                {
                    var lessonTabUrl="code/lessonfunctions.php?GetSetLessons=" + i + "&topic_id=" + window.topicId + "&level=" + window.levelId + "&description=" + window.description + "&num_lessons=" + window.numLessons + "&plan_type=" + window.planType;
                    var lessonTabLabel="lesson " + i;
			$("#tabs").tabs('add',lessonTabUrl,lessonTabLabel);
                }
        }
}
var headingDiv=document.getElementById('header'); // this is in effect the title of the page
	headingDiv.className='ui-widget';
var addS=""; // make sure we are grammatically correct
var displayLevel=getDisplayLevel(window.levelId); // don't want decimals in the display so convert to fractions
if (numLessons > 1) addS="s";
headingDiv.innerHTML="<table><tr><td rowspan=2 align='left' width=30%><img src='images/bnb_logo_narrow.jpg' border=0 style=\"cursor:pointer;\" onclick='goHome();' alt='Go Home'></td><td align='left' width=60% valign=\"bottom\" ><label class='ui-widget' style='font-size:18px;font-family: \"Lucida Grande\",Verdana,Sans-serif; font-weight: normal;'>You are planning to teach " + window.numLessons + " lesson" + addS + " in " + window.topic + " at level " + displayLevel + ".  </label><td align='center' rowspan=2 width=10%><img src='index_files/printer_iconsmall.jpg' border=none width=\"30\" height=\"30\" style=\"cursor:pointer\" valign='bottom' onclick='printPlan(0,"+window.unitId+");' alt='Print Plan'><img src='index_files/home_iconsmall.jpg' border=none width=\"30\" height=\"30\" style=\"cursor:pointer\" valign='bottom' onclick='goHome();' alt='Go Home'></td></tr><tr><td align='left' valign='top'><div id='last_save' style='font-size: 10px; font-family: \"Lucida Grande\",Verdana,Sans-serif; font-weight: normal;'></div></td></tr></table>";
/*$("#tabs").tabs().scrollabletab({
                            'closeable':true,
                            'animationSpeed':200
                            });
debug('selected tab = '+$("#tabs").tabs('option','selected'));*/
$("#tabs").tabs('load',window.lessonNumber);
//debug('lesson number = '+window.lessonNumber);
/*for (i=0 ; i < window.numLessons ; i++) // this is making firefox slow
	{$("#tabs").tabs('load',i);
	}*/
$("#tabs").tabs('select',window.lessonNumber);
//debug('selected tab = '+$("#tabs").tabs('option','selected'));
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

for (i = 1 ; i <= numLessons ; i++) {
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
    submitAndUpdate('#storeRoom_'+saveNum);
    window.goLocation='';
    $('#saveDiv['+saveNum+']').css('height','200px');
});
