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
		var objTabUrl="code/lessonfunctions.php?GetData=keywords&lesson_num=" + i + "&topic_id=" + window.topicId + "&data=" + window.keywords_array[i] + "&plan_type=" + window.planType;
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
		var objTabUrl="code/lessonfunctions.php?GetData=citizenship&lesson_num=" + i + "&topic_id=" + window.topicId + "&data=" + window.citizenship_array[i] + "&plan_type=" + window.planType;
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
		var objTabUrl="code/lessonfunctions.php?GetData=ict&lesson_num=" + i + "&topic_id=" + window.topicId + "&data=" + window.ict_array[i] + "&plan_type=" + window.planType;
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
		var objTabUrl="code/lessonfunctions.php?GetData=numeracy&lesson_num=" + i + "&topic_id=" + window.topicId + "&data=" + window.numeracy_array[i] + "&plan_type=" + window.planType;
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
		var objTabUrl="code/lessonfunctions.php?GetData=risk_assessment&lesson_num=" + i + "&topic_id=" + window.topicId + "&data=" + window.risk_assessment_array[i] + "&plan_type=" + window.planType;
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
