var objectName="unit_"+window.unitId;
	    objectName = getHTTPObject();
    		if (moz){
    			objectName.onload = objectName.onerror = objectName.onabort = function(){
				var dataArray=objectName.responseText.split('^');
                                createVariables(dataArray); 
                               };
    		} else {
    			objectName.onreadystatechange = function() {
        		if (objectName.readyState==4) {
                            	var dataArray=objectName.responseText.split('^');
                                createVariables(dataArray);
                                }
                            };
			}
	var randomnumber = Math.floor(Math.random()*1000001);	
    urlstring = "code/lessonfunctions.php?GetUnit=" + window.unitId + "&_=" + randomnumber;
	objectName.open("GET", urlstring, false);
    objectName.send(null);
function createVariables(dataArray)
{
window.topicId=dataArray[0];window.levelId=dataArray[1];window.numLessons=dataArray[2];window.topic=dataArray[3];window.topicStatus=dataArray[4];window.originalType=dataArray[5];window.userLevel=dataArray[6];window.activityCount=new Array();window.lessonIds=new Array();window.themeIds=new Array();window.themes=new Array();window.objectiveIds=new Array();window.objectiveIds_array=new Array();window.objectives=new Array();window.objectiveStrand=new Array();window.activityIds=new Array();window.activityLps=new Array();window.time=new Array();window.activityNum=new Array();window.keywords=new Array();window.keywords_array=new Array();window.ict=new Array();window.ict_array=new Array();window.numeracy=new Array();window.numeracy_array=new Array();window.risk_assessment=new Array();window.risk_assessment_array=new Array();window.citizenship=new Array();window.citizenship_array=new Array();window.teaching_assistant=new Array();window.sen=new Array();window.ta=new Array();window.strand=new Array();window.strand_array=new Array();window.teaching_point=new Array();window.teaching_point_array=new Array();window.differentiation=new Array();window.differentiation_array=new Array();window.progression=new Array();window.progression_array=new Array();window.progression_points=new Array();window.progression_points_array=new Array();window.analyses=new Array();window.analyses_array=new Array();window.analyses_points=new Array();window.analyses_points_array=new Array();
}
