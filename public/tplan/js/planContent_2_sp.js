$(document).ready(function() { 
		var objectName="lessons";
	    	objectName = getHTTPObject();
    		if (moz){
    			objectName.onload = objectName.onerror = objectName.onabort = function(){
					//alert (objectName.responseText);
					eval(objectName.responseText);};
    		} else {
				objectName.onreadystatechange = function() {
        		if (objectName.readyState==4) {
					//alert (objectName.responseText);
					eval(objectName.responseText);
        			}
    		};
			}
		var randomnumber = Math.floor(Math.random()*1000001);	
    	urlstring = "code/lessonfunctions_2.php?SetUpLessons=" + window.unitId + "&num_lessons=" + window.numLessons + "&lesson_type=" + window.planType + "&topic_id=" + window.topicId + "&level_id=" + window.levelId + "&original_type=" + window.originalType + "&lesson_num=" + window.lessonNumber + "&_=" + randomnumber;
		objectName.open("GET", urlstring, false);
    	objectName.send(null);
});
