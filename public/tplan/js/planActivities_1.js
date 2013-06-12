function drawActivityTabs(i)
{
    //debug('My Userlevel='+window.userLevel);
    if(window.topicStatus!='R'||window.userLevel==9){
        $('#acttabs_'+i).tabs({
			panelTemplate:'<div style="height:400px"></div>',
			tabTemplate: '<li id="#{label}" class="ui-widget"><a class="ui-widget" href="#{href}">#{label}</a> <span class="ui-icon ui-icon-close">Remove Tab</span></li>',
			ajaxOptions: { 
				async: false, 
				cache: false,
				timeout: 200
				},
			cache:true
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
//					alert (act_position + "-" + act_section);
					})
		});
    }
    else{
        $('#acttabs_'+i).tabs({
			panelTemplate:'<div style="height:400px"></div>',
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
				var actTabUrl="code/lessonfunctions.php?GetActivity=" + objNum + "&lesson_num=" + i +  "&content_id=" + window.activityIds[i][a] + "&strands=" + window.strand_array[i][a] + "&teaching_points=" + window.teaching_point_array[i][a] + "&time=" + window.time[i][a] + "&plan_type=" + window.planType + "&topic_status=" + window.topicStatus;
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
		var actTabUrl="code/lessonfunctions.php?GetActivities=1&lesson_num=" + i + "&topic_id=" + topicId + "&level=" + levelId + "&theme_id=" + window.themeIds[i] + "&plan_type=" + window.planType;
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
        actTabUrl="code/lessonfunctions.php?GetActivities=" + actNum + "&lesson_num=" + i + "&topic_id=" + topicId + "&level=" + levelId + "&theme_id=" + themeIds[i] + "&plan_type=" + window.planType;
	actTabLabel="Add Activity";
	$("#acttabs_"+i).tabs( 'add' , actTabUrl , actTabLabel );
	$('#acttabs_'+i).bind("tabsselect", function(e, tab) {
		currentActTab=tab.index+1;
		if (currentActTab == $("#acttabs_"+i).tabs('length'))
			{
				var actNum=tab.index + 2;
				$("#acttabs_"+i +" li:eq(" + tab.index + ") a").html('Activity'); 
				actTabUrl="code/lessonfunctions.php?GetActivities=" + actNum + "&lesson_num=" + i + "&topic_id=" + topicId + "&level=" + levelId + "&theme_id=" + themeIds[i] + "&plan_type=" + window.planType;
				$("#acttabs_"+i).tabs( 'add' , actTabUrl , actTabLabel );
				var $tabs = $("#acttabs"+i).tabs({
    				add: function(event, ui) {
        			$tabs.tabs('select', '#' + ui.panel.id);
    				}
				});
			}

	});
        }
        /*$("#acttabs_"+i).tabs()..scrollabletab({
                            'closeable':true,
                            'animationSpeed':200
                            });*/
	var	divToReveal=document.getElementById('acttabs_'+i);
		divToReveal.style.visibility='visible';
	var divToAttachItTo=document.getElementById('activityListDiv['+i+']');
		divToAttachItTo.appendChild(divToReveal);
}
