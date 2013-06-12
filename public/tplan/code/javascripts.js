 /******************************************************************/
/****** Helens new functions ***************************************/
/*******************************************************************/



//The "Drawing" Functions. These functions are for fetching content from the database, and
//drawing it in the app

//function addLessonSlots() {

//    lessonslotanswerareadiv = document.getElementById("lesson_slots_answers_div");
//    lessonslotanswerareadiv.innerHTML="";

//    lessonslotquestionareadiv = document.getElementById("lesson_slots");
//    lessonslotquestionareadiv.innerHTML="";

//    numberoflessonstoplan = document.getElementById('numlessons').value;
//    for (i=1; i<=numberoflessonstoplan; i++) {
//        lessonslotanswerdiv = document.createElement("div");
//        lessonslotanswerdiv.id = "lessonslot_" + i + "answer_cell";
//        lessonslotanswerdiv.className = "lessonslotanswerdiv";
//        lessonslotanswerdiv.innerHTML = "Lesson " + i;
//        lessonslotanswerareadiv.appendChild(lessonslotanswerdiv);

//        lessonslottbdiv = document.createElement("div");
//        lessonslottbdiv.id = "lessonslot_" + i;
//        lessonslottbdiv.className = "lessonslotanswerdiv";
//        lessonslottbdiv.innerHTML = "Lesson " + i;
//        lessonslotquestionareadiv.appendChild(lessonslottbdiv);



//    }
// function to create the unit of work (this is actually the overarching plan including the lesson plans themselves
var isWorking = false;
var httpObject = getHTTPObject();
var WriteMultiCell=new Array();
var httpObjects=new Array();

function saveUnitOfWork()
{
	if (!isWorking && httpObject)
	{
		if (httpObject != null)
			{
				var topicId=document.getElementById('topic_id').value;
//				var description=document.getElementById('description').value; This is a temporary assignment...
				var description="testing";
				var numLessons=document.getElementById('numlessons_id').value;
				var level=document.getElementById('level_id').value;
				httpObject.open("GET", "code/functions.php?SaveUnitofWork=yes&topic_id="+topicId+"&level_id="+level+"&num_lessons="+numLessons+"&description="+description,true);
				httpObject.onreadystatechange = function() {processNewUnitOfWorkId();};
				isWorking = true;
				httpObject.send(null);
			}
	}
}
function processNewUnitOfWorkId()
{
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
			writeIt=document.getElementById('submit_plan_div');
			newField=document.createElement('input');
			newField.setAttribute('type','hidden');
			newField.setAttribute('value',httpObject.responseText);
			newField.setAttribute('id','uow_id');
			newField.setAttribute('name','uow_id');
			writeIt.appendChild(newField);
			isWorking = false;
		}
	}

}
/* probably need to add everything above to multi */

// The original function dynamically changes the thickbox depending on your browser window size

function resizeThickbox(box,boxheight,boxwidth) 
{
   
    $('a.thickbox').each(function(){  
        var text = $(this).attr("href");  
   		var searchstr = box;
		var matchstr = text.indexOf(searchstr);

		if(matchstr != -1) {
             // adjust the height  
             text = text.replace(/height=[0-9]*/,'height=' + boxheight);  
             // adjust the width  
             text = text.replace(/width=[0-9]*/,'width=' + boxwidth);  
         $(this).attr("href", text);}
     });  
}  

function addLessonSlots() {

	numberoflessonstoplan = document.getElementById('numlessons').value;

	lessonslotanswerareadiv = document.getElementById("unitofwork_fieldset_div");
    lessonslotanswerareadiv.innerHTML="";

	lessonslotanswerdiv = document.createElement("div");
    lessonslotanswerdiv.id = "puw";
	document.getElementById("unitofwork_fieldset_div").appendChild(lessonslotanswerdiv);
    lessonslotanswerul = document.createElement("ul");
	lessonslotanswerul.id = "lessonsul";
	document.getElementById("puw").appendChild(lessonslotanswerul);
	for (i=1; i<=numberoflessonstoplan; i++) {
        lessonslotanswerli = document.createElement("li");
        lessonslotanswerli.id = "lessonslot_answer_cell[" + i + "]";
        lessonslotanswerli.innerHTML = "<a href=# class='puwgrey'>Lesson " + i + "</a>";
		document.getElementById("lessonsul").appendChild(lessonslotanswerli);
    }
// create a table in here to display this nicely
	lessonslottbareadiv = document.getElementById("lesson_slots_tb_div");
	lessonslottbareadiv.innerHTML="";
	lessonslottbdiv = document.createElement("div");
    //lessonslottbdiv.id = "puw_tb";
	lessontable = document.createElement("table");
	lessontable.className = "plan";
	document.getElementById("lesson_slots_tb_div").appendChild(lessontable);
		for (i=1; i<=numberoflessonstoplan; i++) {
			lessonrow = document.createElement("tr");
			lessontable.appendChild(lessonrow);
			lessoncell = document.createElement("td");
			lessonrow.appendChild(lessoncell);
			lessonslottbsel = document.createElement("select");
			lessonslottbsel.setAttribute('class','select-100');
        	lessonslottbsel.id = "lessonslot_tb_sel[" + i + "]";
			lessoncell.appendChild(lessonslottbsel);
//	document.getElementById("puw_tb").appendChild(lessonslottbsel);

    }


}

function changeLessonSlots() {

	numberoflessonstoplan = document.getElementById('numlessons').value;
	removeURL=document.getElementById("uow_wrapper");
	removeURL.innerHTML="<fieldset id='unitofwork_fieldset'><legend>Plan Unit of work</legend><centre><div id='unitofwork_fieldset_div'></div></centre></fieldset>";
	lessonslotanswerareadiv = document.getElementById("unitofwork_fieldset_div");
    lessonslotanswerareadiv.innerHTML="";

	lessonslotanswerdiv = document.createElement("div");
    lessonslotanswerdiv.id = "puw";
	document.getElementById("unitofwork_fieldset_div").appendChild(lessonslotanswerdiv);
    lessonslotanswerul = document.createElement("ul");
	lessonslotanswerul.id = "lessonsul";
	document.getElementById("puw").appendChild(lessonslotanswerul);
	for (i=1; i<=numberoflessonstoplan; i++) {
        lessonslotanswerli = document.createElement("li");
        lessonslotanswerli.id = "lessonslot_answer_cell[" + i + "]";
		lessonslotanswerli.title = document.getElementById("lessonslot_tb_sel[" + i + "]").value;
		themes = themesxml.getElementsByTagName("theme");
		numthemes = themes.length;
		   for (j = 0 ; j < numthemes ; j++) {
	       themedata = unpackXMLnode(themes[j]);
				if (themedata["theme_id"]==lessonslotanswerli.title)
				{ lessonname=themedata["theme_name"];
				  lessonid=themedata["theme_id"];}
		   }
        //lessonslotanswerli.innerHTML = "<a href=# class='puwgrey' onclick='planLesson(" + lessonslotanswerli.title + ",\""+ lessonname + "\"," + i + "," + numberoflessonstoplan +");return false;'>" + lessonname + "</a>";
		lessonslotanswerli.innerHTML = "<a href=# class='puwgrey' onclick='themeButtonPressed(i,lessonslotanswerli.title);return false;'>" + lessonname + "</a>";
		document.getElementById("lessonsul").appendChild(lessonslotanswerli);
		lessonIdFieldName="lesson_id[" + i + "]";
		lessonIdField=document.createElement('input');
		lessonIdField.setAttribute('id',lessonIdFieldName);
		lessonIdField.setAttribute('name',lessonIdFieldName);
		lessonIdField.setAttribute('type','hidden');
		lessonIdField.setAttribute('value',lessonid);
		lessonslotanswerli.appendChild(lessonIdField);
		lessonNameFieldName="lesson_name[" + i + "]";
 		lessonNameField=document.createElement('input');
		lessonNameField.setAttribute('id',lessonNameFieldName);
		lessonNameField.setAttribute('name',lessonNameFieldName);
		lessonNameField.setAttribute('type','hidden');
		lessonNameField.setAttribute('value',lessonname);
		lessonslotanswerli.appendChild(lessonNameField);
   }
}

function planLesson(theme_id,theme,lessonnumber,numberoflessonstoplan)
{
	fetchAndProcessXML('contents',theme_id);
	currentplan = document.getElementById("lessonslot_answer_cell[" + lessonnumber + "]");
}

function processXML(xmlresponse, whatkind) {
    switch (whatkind) {
        case 'contents':

            for (contentcounter=1; contentcounter<=7 ; contentcounter++) {
                 drawContents(xmlresponse, 'content_'+contentcounter);
            }
            break;
    }
}

function drawContents(contentsxml, selectbox_id) {
    selectboxelt = document.getElementById(selectbox_id);
    selectboxelt.innerHTML="";

    dummyoption = document.createElement("option");
    dummyoption.id = selectbox_id + "_dummyoption";
    dummyoption.value = "0";
    dummyoption.title="";
    dummyoption.text="Select Activity";
    selectboxelt.add(dummyoption, null);

    contents = contentsxml.getElementsByTagName('content');
    numcontents = contents.length;

    for (i = 0; i < numcontents; i++) {
        content = contents[i];
        contentdata = unpackXMLnode(content);

        optiongroupid = selectbox_id + "_" + contentdata["lesson_part_id"];//strandid;
        //check if that optiongroup already exists - if not, make it and add it
        optiongroupelt = document.getElementById(optiongroupid);
        if (optiongroupelt == null ) {
            optiongroupelt = document.createElement('optgroup');
            optiongroupelt.id=optiongroupid;
            optiongroupelt.label=contentdata["lesson_part_name"];
            optiongroupelt.className = 'optiongroup_lessonpart';
            optiongroupelt.title = '';
            selectboxelt.appendChild(optiongroupelt);
//			selectboxelt.add(optiongroupelt,null);
        }

        optionelementid = selectbox_id + '_lessonpart_' + contentdata["lesson_part_id"] + "_content_" + contentdata["content_id"];
        //check if that option already exists - if not, make it and add it
		optionelt = document.getElementById(optionelementid);
        if (optionelt == null ) {
            optionelt = document.createElement('option');
            optionelt.id = optionelementid;
            optionelt.value = contentdata["content_id"];
            optionelt.text = contentdata["content_name"];

            html_content_descript = unpackContentDesc(contentdata["content_description"], "<br />\n");
            content_descript = unpackContentDesc(contentdata["content_description"], "\r\n");
            //content_descript = contentdata["content_description"];


            optionelt.setAttribute("html_content_description", html_content_descript);
            optionelt.setAttribute("content_description", content_descript);
            optionelt.setAttribute("content_time", contentdata["content_time"])
            optionelt.title=content_descript;
//			selectboxelt.addEventListener('mouseover',showSelectedOption(optionelt.id,selectbox_id),false);
            //optionelt.onfocus = displaycontent(window.event.target);
            //
            optiongroupelt.appendChild(optionelt);
            //appends the tooltip
//            $("#"+ optionelementid).bt();
        }
    }
    selectboxelt.onchange = function(){ //run some code when "onchange" event fires
                    var chosenoption=this.options[this.selectedIndex] //this refers to "selectmenu"
                    if (chosenoption==null || chosenoption.value == 0||chosenoption.vale=="0"){
                        //do nothing
                    } else {

                        whattodisplay = "<b>" + chosenoption.innerHTML + "</b>" +
                                         "<br />" + chosenoption.getAttribute("html_content_description") +
                                        "<br /><br /><b>Time:" + chosenoption.getAttribute("content_time");


                            displayselectedcontent(whattodisplay);
                    }
    }

}
function showSelectedOption(opt,sel) {
				optselected=document.getElementById(opt);

					if (!document.getElementById("hiddencontent"))
				 	{
					 	hiddencontent = document.createElement("div");
					 	hiddencontent.id = ("hiddencontent");
//				 	hiddenhelp.visibility="visible";
				 	}
				 	fieldsetholder = document.getElementById("contentdisplayarea");
				 	fieldsetholder.appendChild(hiddencontent);
				 	hiddencontent.style.top = fieldsetholder.style.height;
				 	hiddencontent.style.width = fieldsetholder.style.width;
				 	hiddencontent.innerHTML = "<h1>" + optselected.value + "</h1><p>" + optselected.content_description + "</p>";
}
function displayselectedcontent(whattodisplay) {

    //alert("Well at least we got here");
    content_areaelt = document.getElementById("contentdisplayarea");
    content_areaelt.innerHTML = whattodisplay;

}




function fetchAndProcessXML(whatkind,theme_id) {

    //send ajax request to get the possible contents,
    
    xmlhttpObject = getHTTPObject();
    xmlhttpObject.onreadystatechange = function() {

        if (xmlhttpObject.readyState==4) {
            xmlresponse = xmlhttpObject.responseXML;
            //alert(xmlhttpObject.responseText);

            processXML(xmlresponse, whatkind);
        }
    };

    urlstring;
    switch (whatkind) {
        case 'contents':
            level_id = document.getElementById('level_id').value;
            topic_id = document.getElementById('topic_id').value;
           // theme_id = document.getElementById('theme').value;
           //alert("sending theme_id... "+ theme_id);
            urlstring = "code/functions.php?GetXMLData=contents&level_id="+level_id+"&topic_id="+topic_id+"&theme_id="+theme_id;
            //alert("urlstring is \n" + urlstring);
            break;
    }

    //alert('urlstring is' + urlstring);
    xmlhttpObject.open("GET", urlstring, true);
    xmlhttpObject.send(null);
}

function addTopics() {

    //send ajax request to get the possible objectives, based on topic and level
    topicshttpObject = getHTTPObject();
    topicshttpObject.onreadystatechange = function() {

        if (topicshttpObject.readyState==4) {
            topicsxml = topicshttpObject.responseXML;

            //alert("topics xml is: " + topicsxml);
            //use it to fill the topics selectbox
            drawTopics(topicsxml);
        }
    };

    urlstring = "code/functions.php?GetXMLData=topics";
    //alert('urlstring is' + urlstring);
    topicshttpObject.open("GET", urlstring, true);
    topicshttpObject.send(null);
}

function drawTopics(topicsxml) {

    selectbox_id = 'topic';
    //get the select box for putting options in
    topicselectbox = document.getElementById(selectbox_id);

    topicselectbox.innerHTML="";

    dummyoption = document.createElement('option');
    dummyoption.id = 'topic_dummy_option';
    dummyoption.text="Select Topic";
    dummyoption.title="";
    dummyoption.value = "0";
    //dummyoption.disabled = true;

    topicselectbox.add(dummyoption, null);

      topics = topicsxml.getElementsByTagName('topic');
     numtopics = topics.length;

  for (i = 0; i < numtopics; i++) {
      topic = topics[i];
   topicdata = unpackXMLnode(topic);

   optiongroupid = selectbox_id + "_genre_" + topicdata["genre_id"];
          //check if that optiongroup already exists - if not, make it and add it
  optiongroupelt = document.getElementById(optiongroupid);
  if (optiongroupelt == null ) {
              optiongroupelt = document.createElement('optgroup');
              optiongroupelt.id=optiongroupid;
              optiongroupelt.label=topicdata["genre_name"];
              optiongroupelt.className = 'optiongroup_genre';
              optiongroupelt.title = "";
//              topicselectbox.add(optiongroupelt, null);
				topicselectbox.appendChild(optiongroupelt);
          }


          optionelementid = selectbox_id + '_' + topicdata["topic_id"];
          //check if that option already exists - if not, make it and add it
          optionelt = document.getElementById(optionelementid);
          if (optionelt == null ) {
              optionelt = document.createElement('option');
              optionelt.id = optionelementid;
              optionelt.value = topicdata["topic_id"];
              optionelt.text =topicdata["topic_name"];
              optionelt.title = topicdata["topic_description"];
              optiongroupelt.appendChild(optionelt);
          }
      }
}

function addPossibleObjectives() {
    //get the values of the level_id and topic_id
    level_id = document.getElementById('level').value;
    topic_id = document.getElementById('topic').value;

    // quit if they are not set.
    if ( !level_id || !topic_id ) {
        alert("topic/level not set");
        return;
    }

    //send ajax request to get the possible objectives, based on topic and level
    objectiveshttpObject = getHTTPObject();
    objectiveshttpObject.onreadystatechange = function() {

        if (objectiveshttpObject.readyState==4) {
/*
                if (objectiveshttpObject) {
                alert("well, at least its not null");
                alert("and its ready state is..." + objectiveshttpObject.readyState);
                alert("and its headers are:  " + objectiveshttpObject.getAllResponseHeaders())
                alert("and its status is: " + objectiveshttpObject.status);
                alert("and its status text is " + objectiveshttpObject.statusText);
                alert("and its response text is " + objectiveshttpObject.responseText);
                alert("and its response xml is " + objectiveshttpObject.responseXML);
            }
*/


            //get the xml
            objectivesxml = objectiveshttpObject.responseXML;
            //use it to fill the 3 selectboxes
            drawObjectives(objectivesxml, 'objectives_1', 'clear');
            drawObjectives(objectivesxml, 'objectives_2', 'clear');
            drawObjectives(objectivesxml, 'objectives_3', 'clear');
        }
    };

    urlstring = "code/functions.php?GetXMLData=objectives&topic_id=" + topic_id + "&level_id=" + level_id;
    //alert('urlstring is' + urlstring);
    objectiveshttpObject.open("GET", urlstring, true);
    objectiveshttpObject.send(null);
}


function drawObjectives(objectivesxml, selectbox_id, clear_add) {
   //possible values for clear_add_smart are...
   // 'clear' - removes all options first, then adds the new ones - the only one implemented so far :-),
   // 'add' - adds each option (if its not already there)
   // 'smartreplace' - is the same as 'clear' - except that nodes are added if not already there, or removed if not needed. (smart)
   //'clear' is implemented, so we'd better have it as the default
   if (typeof clear_add == 'undefined') clear_add_smartreplace = 'clear';
  selectboxelt = document.getElementById(selectbox_id);

 if (clear_add=='clear') {
        selectboxelt.innerHTML="";
        dummyoption = document.createElement("option");
        dummyoption.id = selectbox_id + "_dummyoption";
        dummyoption.value = "unselected";
        dummyoption.title="";
        dummyoption.text="Select Objective";
        selectboxelt.add(dummyoption, null);
 }


  objectives = objectivesxml.getElementsByTagName('objective');
  numobjectives = objectives.length;

  for (i = 0; i < numobjectives; i++) {
      objective = objectives[i];

   objectivedata = unpackXMLnode(objective);

   optiongroupid = selectbox_id + "_" + objectivedata["level_id"] + "_" + objectivedata["strand_id"];//strandid;
          //check if that optiongroup already exists - if not, make it and add it
  optiongroupelt = document.getElementById(optiongroupid);
  if (optiongroupelt == null ) {
              optiongroupelt = document.createElement('optgroup');
              optiongroupelt.id=optiongroupid;
              optiongroupelt.label=objectivedata["level_name"] + " - " + objectivedata["strand_description"] + " - " + objectivedata["strand_name"];
              optiongroupelt.className = 'optiongroup_level_' + objectivedata["level_id"];
              optiongroupelt.title = objectivedata["strand_description"];
              selectboxelt.appendChild(optiongroupelt);
          }


          optionelementid = selectbox_id + '_' + objectivedata["level_id"] + "_" + objectivedata["strand_id"] + "_" + objectivedata["objective_id"];
          //check if that option already exists - if not, make it and add it
          optionelt = document.getElementById(optionelementid);
          if (optionelt == null ) {
              optionelt = document.createElement('option');
              optionelt.id = optionelementid;
              optionelt.value = objectivedata["objective_id"];
              optionelt.text =objectivedata["objective_name"];
              optionelt.title="";
              optiongroupelt.appendChild(optionelt);
          }

      }

}

/* Utility function for unpacking the "content" description field (as obtained it from the database) of a   */
function unpackContentDesc(contentdescription, sep) {
    regexp1 = new RegExp("i:\d+;s:\d+:");
    regexp1 = new RegExp("i:");
    regexp2 = new RegExp('\";}$');
    regexp3 = new RegExp('\";$');
    regexp4 = new RegExp('^\"');
    regexp5 = new RegExp("\\\""); //quote inside a line
    regexp6 = new RegExp("\"");   //quote delimiting a line
    quotestring = "QUOTESTRINGPLACEHOLDER";

    // Temporarily take out any "real" quotes (from within the descriptions)
    cd_alt = contentdescription.replace(regexp5, quotestring);

    //Split on seperating quotes
    lines = cd_alt.split(regexp6);


    //Throw away stuff betwixt, keep stuff between
    rubbish = new Array();
    whatwewant = new Array();

    if (lines.length>0) {
            rubbish.push(lines.shift());
        }

    while (lines.length > 0 ) {
        rubbish.push(lines.shift());
        if (lines.length>0) {
            whatwewant.push(lines.shift());
        }
    }
    
    reconstituted = whatwewant.join(sep);
    //put any real quotes back in
    return reconstituted.replace(quotestring, regexp5);

 //   lines = contentdescription.split(regexp1);
 //   lines.shift(); // kill the first element, which is the starting bunch of junk
   // numlines = lines.length;
 //   for (ik=0;ik<numlines;ik++) {
  //      lines[ik]=lines[ik].replace(regexp2, ""); //kill the end mess (last one only)
  //      lines[ik]=lines[ik].replace(regexp3, ""); //kill the end mess (all the others)
  //      lines[ik]=lines[ik].replace(regexp4, ""); //kill the starting quote
 //   }

    //return lines.join(sep);
}
function unpackThemeDesc(themedescription, sep) {
    regexp1 = new RegExp("i:\d+;s:\d+:");
    regexp1 = new RegExp("i:");
    regexp2 = new RegExp('\";}$');
    regexp3 = new RegExp('\";$');
    regexp4 = new RegExp('^\"');
    regexp5 = new RegExp("\\\""); //quote inside a line
    regexp6 = new RegExp("\"");   //quote delimiting a line
    quotestring = "QUOTESTRINGPLACEHOLDER";

    // Temporarily take out any "real" quotes (from within the descriptions)
    cd_alt = themedescription.replace(regexp5, quotestring);

    //Split on seperating quotes
    lines = cd_alt.split(regexp6);


    //Throw away stuff betwixt, keep stuff between
    rubbish = new Array();
    whatwewant = new Array();

    if (lines.length>0) {
            rubbish.push(lines.shift());
        }

    while (lines.length > 0 ) {
        rubbish.push(lines.shift());
        if (lines.length>0) {
            whatwewant.push(lines.shift());
        }
    }
    
    reconstituted = whatwewant.join(sep);
    //put any real quotes back in
    return reconstituted.replace(quotestring, regexp5);

 //   lines = contentdescription.split(regexp1);
 //   lines.shift(); // kill the first element, which is the starting bunch of junk
   // numlines = lines.length;
 //   for (ik=0;ik<numlines;ik++) {
  //      lines[ik]=lines[ik].replace(regexp2, ""); //kill the end mess (last one only)
  //      lines[ik]=lines[ik].replace(regexp3, ""); //kill the end mess (all the others)
  //      lines[ik]=lines[ik].replace(regexp4, ""); //kill the starting quote
 //   }

    //return lines.join(sep);
}


/* Utility function for unpacking an xml node - see php function mysql2xmlarray where nodes are packed */

function unpackXMLnode(nodetounpack) {
    sub_nodes = nodetounpack.childNodes;
    numchildren = sub_nodes.length;
    unpacked_result = new Array();

    for (ij = 0;ij < numchildren;ij++) {

        node_name = sub_nodes[ij].nodeName;
        node_contents = "";
        if (sub_nodes[ij].hasChildNodes()) {
            node_contents = sub_nodes[ij].childNodes[0].nodeValue;
        }
        unpacked_result[node_name] = node_contents;
    }

    return unpacked_result;
}


function addPossibleThemes() {

    level_id = document.getElementById('level').value;
    topic_id = document.getElementById('topic').value;

    //alert('level_id: ' + level_id + 'topic_id' + topic_id);

    if ( !level_id || !topic_id ) {
        alert("topic/level not set");
        return;
    }


    //ennumerate the possible themes
    themePosshttpObject = getHTTPObject();
    themePosshttpObject.onreadystatechange = function() {

        if (themePosshttpObject.readyState==4) {
            //do stuff

            //was testing if null
/*
            if (themePosshttpObject) {
                alert("well, at least its not null");
                alert("and its ready state is..." + themePosshttpObject.readyState);
                alert("and its headers are:  " + themePosshttpObject.getAllResponseHeaders())
                alert("and its status is: " + themePosshttpObject.status);
                alert("and its status text is " + themePosshttpObject.statusText);
                alert("and its response text is " + themePosshttpObject.responseText);
            }
*/

//check - to remove later
            //responsetext = themePosshttpObject.responseText;

           // alert("themes xml is \n" + responsetext);

            themesxml = themePosshttpObject.responseXML;
          // alert(themesxml);
            drawThemePossibilities(themesxml);
        }
    };

    urlstring = "code/functions.php?GetXMLData=themes&topic_id=" + topic_id + "&level_id=" + level_id;
    //alert("themesxml url is " + urlstring);
    themePosshttpObject.open("GET", urlstring, true);
    themePosshttpObject.send(null);
}
function drawThemepossibilitiesUl(themesxml) {
   numberoflessonstoplan = document.getElementById('numlessons').value;
}
function drawThemePossibilities(themesxml) {

    //find div ready to write to
    //possiblethemes_div_elt = document.getElementById("possiblethemes_div")

    /// first clear the div
    //possiblethemes_div_elt.innerHTML="";
    //For each possible theme, create a theme icon with:
    //  name of the theme as Name
    //  description of theme on hoverover
    //  class as themepossibilities
    // hidden property recording the database id of this theme


   //also find the theme select box to write to
   
   numberoflessonstoplan = document.getElementById('numlessons').value;
   for (j = 1 ; j <= numberoflessonstoplan ; j++) {
   selectbox_id = "lessonslot_tb_sel[" + j + "]";
   selectboxelt = document.getElementById(selectbox_id);
		option = document.createElement("option");
        option.value = "lesson "+j;
        option.text =  "lesson "+j;
        selectboxelt.add(option,null);

    themes = themesxml.getElementsByTagName("theme");

    numthemes = themes.length;

    //alert("gonna add " + numthemes + "buttons" );


   for (i = 0 ; i < numthemes ; i++) {

        themedata = unpackXMLnode(themes[i]);

        // create elements for the unit of work area

//        themeposselement = document.createElement("button");
//        themeposselement.className = "theme_poss";
//        themeposselement.disabled=true;
//        themeposselement.id="themeposs_"+ themedata['theme_id'];//themes[i].getAttribute('themeid');
//        themeposselement.title = themedata["theme_description"];
 //       themeposselement.value=themedata["theme_name"];
//        themeposselement.innerHTML=themedata["theme_name"];
//        possiblethemes_div_elt.appendChild(themeposselement);

        // Create options for the theme select box
       	option = document.createElement("option");
//        option.id = selectbox_id + "_option_" + themedata["theme_id"];
// using the name for now...       option.value = themedata["theme_id"];
		option.value = themedata["theme_id"];
        option.text = themedata["theme_name"];
		option.setAttribute("theme_importance", themedata["theme_importance"]);
		option.setAttribute("theme_notes", themedata["theme_notes"]);
        selectboxelt.add(option,null);

  }
   }


    // add and remove possible themes

    //cycle through the theme icons already there, and remove from the div if they
    //are not needed - while removing any from the todo list if they are already there

    //then cycle through any remaining todo theme possibilities and add them.

}

function okButtonPressed(whichbutton) {
    switch (whichbutton) {
        case "start":
            //populate next set of fields
            addTopics();
            //navigate out of this fieldset and into the next one
            moveIntoFieldset("topiclevel_fieldset");
            //close the thickbox
            tb_remove();
            //populate the answer fields
            break;
        case "topiclevel":
            //validate topic
            topic_id = document.getElementById("topic").value;
            if (topic_id == null || topic_id ==0 || topic_id == "0") {
                alert("Please select topic");
                return;
            }
            //validate level
            level_id = document.getElementById("level").value;
            if (level_id == null || level_id ==0 || level_id == "0") {
                alert("Please select level");
                return;
            }
            //validate numberoflessons
            numlessons_id = document.getElementById("numlessons").value;
            if (numlessons_id == null || numlessons_id ==0 || numlessons_id == "0") {
                alert("Please select Number of Lessons");
                return;
            }
            //populate next sets of fields
			var boxheight;
			switch (numlessons_id){
				case "1": boxheight = 125; break;
				case "2": boxheight = 145; break;
				case "3": boxheight = 165; break;
				case "4": boxheight = 185; break;
				case "5": boxheight = 205; break;
				case "6": boxheight = 225; break;
				case "7": boxheight = 248; break;
				case "8": boxheight = 268; break;
				case "9": boxheight = 288; break;
				case "10": boxheight = 308; break;
				case "11": boxheight = 328; break;
				case "12": boxheight = 348; break;}
			resizeThickbox('unitofwork_thickbox',boxheight,800); //resize the dimensions of the a tag for the TB
            addLessonSlots(); // in the thickbox and in the answers area
            addPossibleThemes();
            addPossibleObjectives();
            //navigate out of this fieldset and into the next one
            moveOutOfFieldset("topiclevel_fieldset");
            moveIntoFieldset("unitofwork_fieldset");
			//addLessonSlots(); 
            //close the thickbox
            tb_remove();
            //populate the answer fields
            processField("topic");
            processField("level");
            processField("numlessons");
// add to multi
			saveUnitOfWork();
            break;
 //           validateAndMoveOn('topiclevel');
 //           break;
        case "unitofwork":
			changeLessonSlots();
//            validateAndMoveOn('unitofwork');
			moveOutOfFieldset("unitofwork_fieldset");
            moveIntoFieldset("unitofwork_fieldset");
			tb_remove();
            break;
        case "theme":
            fetchAndProcessXML('contents');
            validateAndMoveOn('theme');
            break;
        case "objectives":
            validateAndMoveOn('objectives');
            break;
        case "lessoncontents":
            //validate contents
             //do we want them to fill in all contents fields....??
             //
             //Add stuff to equipment field
             GetData("equipment", null);
             GetData("keywords", null);
             GetData("citizenship", null);
             GetData("ict", null);
             GetData("numeracy", null);
             GetData("risk_assessment", null);
                        //navigate out of this fieldset and into the next one
            moveOutOfFieldset("lessoncontents_fieldset");
            moveIntoFieldset("equip_fieldset");
            //close the thickbox
            tb_remove();
            //populate the answer fields
            processContentField("content_1");
            processContentField("content_2");
            processContentField("content_3");
            processContentField("content_4");
            processContentField("content_5");
            processContentField("content_6");
            processContentField("content_7");
            break;
        case "equip":
            moveOutOfFieldset("equip_fieldset");
            moveIntoFieldset("ta_fieldset");
            tb_remove();
            processList("equipment_list");
            break;
        case "ta":
            moveOutOfFieldset("ta_fieldset");
            moveIntoFieldset("cross_curricular_fieldset");
            moveOutOfFieldset("cross_curricular_fieldset");
            tb_remove();
			processField("ta");
			processField("sen");
            moveIntoFieldset("submit_plan");
			moveOutOfFieldset("submit_plan");
            break;
		case "keywords":
			processList("keywords_list");
			tb_remove();
            moveIntoFieldset("submit_plan");
			moveOutOfFieldset("submit_plan");
			break;
		case "citizenship":
			processList("citizenship_list");
			tb_remove();
            moveIntoFieldset("submit_plan");
			moveOutOfFieldset("submit_plan");
			break;
		case "ict":
			processList("ict_list");
			tb_remove();
            moveIntoFieldset("submit_plan");
			moveOutOfFieldset("submit_plan");
			break;
		case "numeracy":
			processList("numeracy_list");
			tb_remove();
            moveIntoFieldset("submit_plan");
			moveOutOfFieldset("submit_plan");
			break;
		case "risk_assessment":
			processList("risk_assessment_list");
			tb_remove();
            moveIntoFieldset("submit_plan");
			moveOutOfFieldset("submit_plan");
			break;
    }
}
function themeButtonPressed(themeNumber, theme_id)
{
            fetchAndProcessXML('contents',theme_id);
    		document.getElementById("objectives_fieldset").className="fieldsetHighlight";
}

function validateAndMoveOn(wherefrom) {
    from_fieldset_name = wherefrom + "_fieldset";
    whereto = getNextSubunitName(wherefrom);
    to_fieldset = whereto + "_fieldset";
    write_errors_to = wherefrom + "_errorreport";
    clearErrorContents(write_errors_to);
    if (validateSubunit(wherefrom, write_errors_to)) {

        moveOutOfFieldset(from_fieldset_name);
        //if there is a next fieldset to go to
        if ((whereto !=null) && (whereto.length > 0) && (wherefrom!='unitofwork')) {
          moveIntoFieldset(to_fieldset);
        }
        tb_remove();

        populateSubunitAnswers(wherefrom);
    }
}

var subUnitNames=new Array("schoolclass","topiclevel","unitofwork","objectives", "lessoncontents","equip", "ta","crosscurricular");

var subFields= new Array();
subFields["schoolclass"]= new Array("school","class","year");
subFields["topiclevel"] =  new Array("topic", "level","numlessons");
subFields["unitofwork"] = new Array();
subFields["objectives"]=new Array("objectives_1", "objectives_2", "objectives_3");
//to do - complete next one
subFields["lessoncontents"] = new Array("lesson_part_1", "content_1","point_1");//, "strand_1", "image_1", "time_1");
subFields["equip"] = new Array("equipment");
subFields["crosscurricular"] = new Array("keywords", "citizenship", "numeracy", "ict", "sen", "risk_assessment");

function getNextSubunitName(subunitname) {

    //To Do - change this to query the nodes

   indexOfInput = subUnitNames.indexOf(subunitname, 0);
   if (indexOfInput == -1) {return "";}
   indexOfOutput = indexOfInput + 1;
   if (indexOfOutput >= subUnitNames.length) {return "";}
   return subUnitNames[indexOfOutput];
}

function populateSubunitAnswers(subunitToPopulate) {



    answersToProcess = subFields[subunitToPopulate];

    //alert("subunitToPopulate is " + subunitToPopulate);
    len = answersToProcess.length;
    for (i = 0; i < len ; i++) {
        field_to_process = answersToProcess[i];
        //alert("field_to_process is " + field_to_process);
        processField(field_to_process);
    }
}

function processContentField(field_to_process) {
    questionelement = document.getElementById(field_to_process);
        if (questionelement == null) {
            alert("failed to find element " + field_to_process );
            alert("body contains:\n" + document.getElementById("bodyelt").innerHTML)
        }
        answercell = document.getElementById(field_to_process + "_answer_cell");
        if (questionelement.type == "select-one") {
            selectedindex = questionelement.selectedIndex;
            if (selectedindex ==0 ) {
            answercell.innerHTML = "";//childNodes[questionelement.selectedIndex].innerHTML;
            } else {
//                chosenoption = questionelement.options[selectedindex];
//                answertext = chosenoption.innerHTML + " " +
//                                         "\r" + chosenoption.getAttribute("content_description") +
//                                        "\r\rTime:" + chosenoption.getAttribute("content_time")+
//                                        "\r";
//				answerrows = answertext.length - answertext.replace(/\n/gi,'').length + 2;
//				answercell.innerHTML = "<textarea class='main_form' rows='" + answerrows + "' name='" + field_to_process + "'>" + answertext + "</textarea>";
                chosenoption = questionelement.options[selectedindex];
                answertitle = chosenoption.innerHTML;
				answerid = questionelement.options[selectedindex].value;
				answersize = answertitle.length;
                answerdesc = chosenoption.getAttribute("content_description");
                answertime = "Time:" + chosenoption.getAttribute("content_time");
				//answerrows = answerdesc.length - answertext.replace(/\n/gi,'').length + 2;
				answerrows = answerdesc.length / 25;
				answercell.innerHTML = "<input type='hidden' name='" + field_to_process + "_id' id='" + field_to_process + "_id' value='" + answerid + "'><input width=" + answersize + "class='main_form' type='text' name='" + field_to_process + "' id='" + field_to_process + "' value='" + answertitle + "'>" + "<br><textarea class='main_form' rows='" + answerrows + "' name='" + field_to_process + "_desc' id='" + field_to_process + "_desc'>" + answerdesc + "</textarea>" + "<textarea class='main_form' rows='1' name='" + field_to_process + "_time' name='" + field_to_process + "_time'>" + answertime + "</textarea>";

            }
        }
        if (questionelement.type == "select-multiple") {
            answertext = "";

            for (i = 0; i < questionelement.length ; i++) {
                //alert('looking at option ' + i);

                if (questionelement.options[i].selected){
                    //alert('found something selected');
                  answertext = answertext + questionelement.options[i].innerHTML + ", ";
                }

            }
            if (answertext.length>=2) {
                answertext = answertext.toString().substring(0, answertext.length-2);
            }
            answercell.innerHTML = answertext;

        }
        if (questionelement.type == "text") {
            answercell.innerHTML = questionelement.value;
        }

}

function processField(field_to_process) {
    questionelement = document.getElementById(field_to_process);
        if (questionelement == null) {
            alert("failed to find element " + field_to_process );
            alert("body contains:\n" + document.getElementById("bodyelt").innerHTML)
        }
        answercell = document.getElementById(field_to_process + "_answer_cell");
        if (questionelement.type == "select-one") {
            selectedindex = questionelement.selectedIndex;
			answertext = questionelement.options[selectedindex].innerHTML.toString();
			answerid = questionelement.options[selectedindex].value;
			inputsize = answertext.length;
            answercell.innerHTML = "<input size=" + inputsize + " class='main_form' type='text' name='" + field_to_process + "' id='" + field_to_process + "' value='" + answertext + "'><input type='hidden' id='" + field_to_process + "_id' name='" + field_to_process + "_id' value='" + answerid + "'>";//childNodes[questionelement.selectedIndex].innerHTML;
        }
        if (questionelement.type == "select-multiple") {
            answertext = "";

            for (i = 0; i < questionelement.length ; i++) {
                //alert('looking at option ' + i);

                if (questionelement.options[i].selected){
                    //alert('found something selected');
                  answertext = answertext + questionelement.options[i].innerHTML + ", ";
				  answerid = answerid + questionelement.options[i].value + ", ";
                }

            }
            if (answertext.length>=2) {
                answertext = answertext.toString().substring(0, answertext.length-2);
                answerid = answerid.toString().substring(0, answerid.length-2);
 //				answerid = questionelement.options[selectedindex].value;
           }
            inputsize = answertext.length;
answercell.innerHTML = "<input size=" + inputsize + " class='main_form' type='text' id='" + field_to_process + "' name='" + field_to_process + "' value='" + answertext + "'><input type='hidden' name='" + field_to_process + "_id' id='" + field_to_process + "_id' value='" + answerid + "'>";

        }
        if (questionelement.type == "text") {
			answertext = questionelement.value;
            inputsize = answertext.length;
            answercell.innerHTML = "<input size=" + inputsize + " class='main_form' type='text' name='" + field_to_process + "' id='" + field_to_process + "' value='" + answertext + "'>";
        }

}
function processList(listToProcess)
{
        	answercell = document.getElementById(listToProcess + "_answer_cell");
            answertext = "";
			answerid = "";
			questionelement=document.getElementById(listToProcess)
			for (i = 0; i < questionelement.length ; i++) {
                  answertext = answertext + questionelement.options[i].innerHTML + ", ";
				  answerid = answerid + questionelement.options[i].value + ", ";
            }
            if (answertext.length>=2) {
                answertext = answertext.toString().substring(0, answertext.length-2);
                answerid = answerid.toString().substring(0, answerid.length-2);
 //				answerid = questionelement.options[selectedindex].value;
           }
            inputsize = answertext.length;
answercell.innerHTML = "<input size=" + inputsize + " class='main_form' type='text' name='" + listToProcess + "' value='" + answertext + "'><input type='hidden' name='" + listToProcess + "_id' value='" + answerid + "'>";
}
function validateSubunit(subunitname, write_errors_to) {
    return true;
}

function clearErrorContents(elementId) {

}

function moveOutOfFieldset(from_fieldset) {

    //alert("attempting to move out of " + from_fieldset);
    fieldset_to_leave=document.getElementById(from_fieldset);
	div_to_show_name=from_fieldset + '_div';
	document.getElementById(div_to_show_name).style.visibility = 'visible';

//    fieldset_to_leave.className="";
}

function moveIntoFieldset(to_fieldset) {
    document.getElementById(to_fieldset).className="fieldsetHighlight";
}

//Fetches the help from the database - only needs to be done once
//adds the help as the title attribute of the target
//calls "Beauty Tips" to make the title display in a bubble.
function addHelpOnce(event, helpkey, fieldset) {
    event = event || window.event;
    target = event.target;
    title = target.getAttribute("title");
    if (title==null || title=="") {
        helphttpObject = getHTTPObject();
        helphttpObject.onreadystatechange = function() {

            if (helphttpObject.readyState==4) {
                //responsexml = helphttpObject.responseXML;
                responsetext = helphttpObject.responseText;
                newtitle = "";
                if (responsetext && (responsetext != null) && (responsetext != "") && (responsetext.indexOf("help_name")>-1)) {

                    //hack - can't currently parse xml as invalid html breaks the xml
                    //so unpicking the responsetext like this
                    
                    //discard the front and end rubbish
                    responsetext = responsetext.split("<help_name>")[1];
                    responsetext = responsetext.split("</help_text>")[0];
                    //extract the two pieces
                    splitarray = responsetext.split("</help_name>\n<help_text>");
                    help_name = splitarray[0];
                    help_text = splitarray[1];
                    newtitle = "Help for " + help_name + ": " + help_text;
/*
                    helptopics = responsexml.getElementsByTagName("helptopic");
                    if (helptopics !=null && helptopics.length > 0) {
                        
                        helptopicdata = unpackXMLnode(helptopics[0]);
                        newtitle = "Help for " + helptopicdata["help_name"] + ": " + helptopicdata["help_text"];
                    }
*/
                }

                if (newtitle=="") {

                    newtitle = "No help topic found for " + helpkey;
                }
                //target.setAttribute("title", newtitle);
                //$("#" + target.id).bt();
                //$("#" + target.id).btOn();
				if (!document.getElementById("hiddenhelp"))
				 {
					 hiddenhelp = document.createElement("div");
					 hiddenhelp.id = ("hiddenhelp");
//				 hiddenhelp.visibility="visible";
				 }
				 fieldsetholder = document.getElementById(fieldset);
				 fieldsetholder.appendChild(hiddenhelp);
				 hiddenhelp.style.top = fieldsetholder.style.height;
				 hiddenhelp.style.width = fieldsetholder.style.width;
				 hiddenhelp.innerHTML = "<h1>Help</h1><p>" + newtitle + "</p>";
            }
        };
        urlstring="code/functions.php?GetXMLData=help&help_key="+helpkey;
        helphttpObject.open("GET", urlstring, true);
        helphttpObject.send(null);

    }
}
function removeHelp()
{
//		fieldsetholder = document.getElementById("hiddenhelp").parentNode.nodeName;
//		fieldsetholder.removeChild(document.getElementById("hiddenhelp"));
		MM_showHideLayers('hiddenhelp','','hide');
}
function removeContent()
{
//		fieldsetholder = document.getElementById("hiddenhelp").parentNode.nodeName;
//		fieldsetholder.removeChild(document.getElementById("hiddenhelp"));
		MM_showHideLayers('hiddencontent','','hide');
}
function MM_showHideLayers() 
{ 
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
function MM_effectAppearFade(targetElement, duration, from, to, toggle)
{
	Spry.Effect.DoFade(targetElement, {duration: duration, from: from, to: to, toggle: toggle});
}
function MM_effectSquish(targetElement)
{
	Spry.Effect.DoSquish(targetElement);
}


/*
 *Graveyard of functions tried for displaying help / popups - now using BeautyTips instead.
 */
/*
function getObjectPosition(obj) {

    //curleft = obj.offsetLeft;
    //curtop = obj.offsetTop;
    var curleft = 0;
      var curtop = 0;
      if (obj.offsetParent) {
            do  {
                alert ("obj is " + obj.id + " adding " + obj.offsetLeft);
                if (obj.id=="TB_window") {
                      break;
                  }
                 curleft += obj.offsetLeft;
                  curtop += obj.offsetTop;
                  
            } while (obj = obj.offsetParent);
      }
      return [curleft,curtop];

}
*/
/*
function displayPopup(event, hoveritem, popupdivID, contentToDisplay ) {
    hp = document.getElementById(popupdivID);

    alert("hp is " + hp.id);

    hp.innerHTML = contentToDisplay;
    // Set position of hover-over popup
    hp.className = "visiblepopupdiv";
    hp.style.position = 'absolute';
    //newLeft = mouseX(window.event) + 20;//hoveritem.offsetLeft + 20;
    //newTop = mouseY(window.event) + 18;//hoveritem.offsetTop + 18;

    //coords = getObjectPosition(hoveritem);

    hp.style.top =  mouseY(event) + "pt";
    hp.style.left = mouseX(event) + "pt";
   
   alert("after display, hp.className is " + hp.className );
   alert("after display, hp.style.top is " + hp.style.top );
   alert("after display, hp.style.left is " + hp.style.left );
   //alert("after display, hoveritem.offsetTop is " + hoveritem.offsetTop );
   //alert("after display, hoveritem.offsetLeft is " + hoveritem.offsetLeft );
}
*/
/*
function hidePopup(popupdivID) {
    hp = document.getElementById(popupdivID);
    hp.className = "hiddenpopupdiv";
}
*/
/*
function displayHelp_withinTB(event) {
    event = event || window.event;
    hoveritem = event.target;
    alert("hoveritem is " + hoveritem);



    helpname = hoveritem.getAttribute("alt");
    alert("helpname is " + helpname);
    
    ycoord = mouseY(event)-getTBtop();
    xcoord = mouseX(event)-getTBleft();


    hoveritem.setAttribute("hoveringHere", true);

    displayPopup(event, hoveritem, "helppopupdiv", helpname);
}

*/
/*
function displayHelp(event) {
    event = event || window.event;
    hoveritem = event.target;
    //alert("hoveritem is " + hoveritem);
    helpname = hoveritem.getAttribute("alt");
    
    xcoord = mouseX(event);
    ycoord = mouseY(event);

    hoveritem.setAttribute("hoveringHere", true);
  
    displayPopup(event, hoveritem, "helppopupdiv", helpname);

}

function hideHelp(hoveritem) {
    hoveritem.setAttribute("hoveringHere", false);
    hidePopup("helppopupdiv");
}
*/

/*Utility functions for giving the coords of mouse*/
/*
function mouseX(evt) {
if (evt.pageX) return evt.pageX;
else if (evt.clientX)
   return evt.clientX + (document.documentElement.scrollLeft ?
   document.documentElement.scrollLeft :
   document.body.scrollLeft);
else return null;
}
*/
/*
function mouseY(evt) {
if (evt.pageY) return evt.pageY;
else if (evt.clientY)
   return evt.clientY + (document.documentElement.scrollTop ?
   document.documentElement.scrollTop :
   document.body.scrollTop);
else return null;
}
*/
/*
function getTBtop() {
     return $("#TB_window").margin_top;
}
*/
/*
function getTBleft() {
    return $("#TB_window").margin_left;
}
*/


/**
*
*  Javascript trim, ltrim, rtrim
*  http://www.webtoolkit.info/
*
**/

function trim(str, chars) {
	return ltrim(rtrim(str, chars), chars);
}

function ltrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
}

function rtrim(str, chars) {
	chars = chars || "\\s";
	return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
}


/************************************************************/
/********* End of Helen's new functions ********************/
/******************************************************/
function getHTTPObject()
{
	if (window.ActiveXObject) return new ActiveXObject("Microsoft.XMLHTTP");
	else if (window.XMLHttpRequest) return new XMLHttpRequest();
	else {
		alert("Your browser does not support AJAX.");
		return null;
		}
}
function SendData(WhatToSend)
{
	if(httpObject.readyState == 4)
	{
		document.getElementById(WhatToSend).value = httpObject.responseText;
		alert("made it here");
	}
}
function changeContent(WriteCell)
{
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
//			alert (httpObject.responseText);
			var cell=document.getElementById(WriteCell);
			cell.innerHTML=httpObject.responseText;
			isWorking = false;
		}
	}
}
function changeMultiContent()
{
for (var index = 1; index < httpObjects.length; index++) 
	{
      if (httpObjects[index] && httpObjects[index].readyState == 4) 
			{
			if (httpObjects[index].responseText.indexOf('invalid') == -1) 
				{
					var cell=document.getElementById(WriteMultiCell[index]);
					cell.innerHTML=httpObjects[index].responseText;
					isWorking = false;
					httpObjects[index]=null;
				}
			}
	}
}
/*function GetData(WhatToGet,from)
{
	if (!isWorking && httpObject) 
	{
	WriteCell=WhatToGet+'_cell';
	if (httpObject != null) 
	var CellCount=1;
	{
		if (WhatToGet=="content"){
			var lesson_part_bit="lesson_part_"+from;
			httpObject.open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic').value+"&theme_id="+document.getElementById('theme').value+"&level_id="+document.getElementById('level').value+"&lesson_part_id="+document.getElementById(lesson_part_bit).value+"&element_num="+from,true);
			WriteCell=WriteCell+"_"+from;
			httpObject.onreadystatechange = function() {changeContent(WriteCell);};
			isWorking = true;
			httpObject.send(null);
}
		else if (WhatToGet=="point"){
			var content_part_bit="content_"+from;
			httpObject.open("GET", "code/functions.php?GetData="+WhatToGet+"&content_id="+document.getElementById(content_part_bit).value+"&element_num="+from,true);
			WriteCell=WriteCell+"_"+from;
			httpObject.onreadystatechange = function() {changeContent(WriteCell);};
			isWorking = true;
			httpObject.send(null);
		}
		else if (WhatToGet=="strand"){
			var content_part_bit="content_"+from;
			httpObject.open("GET", "code/functions.php?GetData="+WhatToGet+"&content_id="+document.getElementById(content_part_bit).value+"&element_num="+from,true);
			WriteCell=WriteCell+"_"+from;
			httpObject.onreadystatechange = function() {changeContent(WriteCell);};
			isWorking = true;
			httpObject.send(null);
		}
		else if (WhatToGet=="theme"){
			httpObject.open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic').value,true);
			httpObject.onreadystatechange = function() {changeContent(WriteCell);};
			isWorking = true;
			httpObject.send(null);
		}
		else if (WhatToGet=="keywords"){
			var CellCount=1;
			for (var i = 1; i <= CellCount; i++) 
				{
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++; 				
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null) 
					{
						WriteMultiCell[index]=WriteCell;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic').value,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
				}
		}
		else if (WhatToGet=="objectives")
		{
			var CellCount=3;
			for (var i = 1; i <= CellCount; i++) 
				{
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++; 				
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null) 
					{
						WriteMultiCell[index]=WriteCell+"_"+i;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic').value+"&element_num="+i,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
				}
		}
		else if (WhatToGet=="equipment"){
			var CellCount=3;
			for (var i = 1; i <= CellCount; i++) 
				{
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++; 				
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null) 
					{
						WriteMultiCell[index]=WriteCell+"_"+i;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic').value+"&element_num="+i,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
				}
		}
		else if (WhatToGet=="lesson_part"){
			var CellCount=7;
			for (var i = 1; i <= CellCount; i++) 
				{
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++; 				
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null) 
					{
						WriteMultiCell[index]=WriteCell+"_"+i;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic').value+"&element_num="+i,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
				}
		}
		else {
			var CellCount=1;
			for (var i = 1; i <= CellCount; i++) 
				{
				var index = 1;
   				while (httpObjects[index] && index < 20)
      			index++; 				
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null) 
					{
						WriteMultiCell[index]=WriteCell;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
				}
		}
	}
	}
}*/
/* Get Data is quite a crucial function. This just sends a single request off to get the data, like strand or point.
some of the requests are now habdled by the getXMLdata done by Helen so that we can manipulate the data locally before 
presenting it.
Anothe thing is thew multi-data requests. If we want to get more than one thing at once we set up an array 
of http objects to retrieve the information for us */
function GetData(WhatToGet,from)
{
	if (!isWorking && httpObject)
	{
	WriteCell=WhatToGet+'_cell';
	if (httpObject != null)
	var CellCount=1;
	{
		if (WhatToGet=="content"){
			var lesson_part_bit="lesson_part_"+from;
			httpObject.open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic').value+"&theme_id="+document.getElementById('theme').value+"&level_id="+document.getElementById('level_id').value+"&lesson_part_id="+document.getElementById(lesson_part_bit).value+"&element_num="+from,true);
			WriteCell=WriteCell+"_"+from;
			httpObject.onreadystatechange = function() {changeContent(WriteCell);};
			isWorking = true;
			httpObject.send(null);
}
		else if (WhatToGet=="point"){
			var content_part_bit="content_"+from;
			httpObject.open("GET", "code/functions.php?GetData="+WhatToGet+"&content_id="+document.getElementById(content_part_bit).value+"&element_num="+from,true);
			WriteCell=WriteCell+"_"+from;
			httpObject.onreadystatechange = function() {changeContent(WriteCell);};
			isWorking = true;
			httpObject.send(null);
		}
		else if (WhatToGet=="strand"){
			var content_part_bit="content_"+from;
			httpObject.open("GET", "code/functions.php?GetData="+WhatToGet+"&content_id="+document.getElementById(content_part_bit).value+"&element_num="+from,true);
			WriteCell=WriteCell+"_"+from;
			httpObject.onreadystatechange = function() {changeContent(WriteCell);};
			isWorking = true;
			httpObject.send(null);
		}
		else if (WhatToGet=="theme"){
			httpObject.open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic_id').value,true);
			httpObject.onreadystatechange = function() {changeContent(WriteCell);};
			isWorking = true;
			httpObject.send(null);
		}
		else if (WhatToGet=="equipment"){
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++;
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null)
					{
						WriteMultiCell[index]=WriteCell;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic_id').value,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
		}
		else if (WhatToGet=="keywords"){
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++;
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null)
					{
						WriteMultiCell[index]=WriteCell;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic_id').value,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
		}
		else if (WhatToGet=="citizenship"){
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++;
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null)
					{
						WriteMultiCell[index]=WriteCell;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic_id').value,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
		}
		else if (WhatToGet=="ict"){
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++;
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null)
					{
						WriteMultiCell[index]=WriteCell;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic_id').value,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
		}
		else if (WhatToGet=="numeracy"){
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++;
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null)
					{
						WriteMultiCell[index]=WriteCell;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic_id').value,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
		}
		else if (WhatToGet=="SEN"){
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++;
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null)
					{
						WriteMultiCell[index]=WriteCell;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic_id').value,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
		}
		else if (WhatToGet=="risk_assessment"){
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++;
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null)
					{
						WriteMultiCell[index]=WriteCell;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic_id').value,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
		}
		else if (WhatToGet=="objectives")
		{
			var CellCount=3;
			for (var i = 1; i <= CellCount; i++)
				{
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++;
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null)
					{
						WriteMultiCell[index]=WriteCell+"_"+i;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic_id').value+"&element_num="+i,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
				}
		}
		else if (WhatToGet=="lesson_part"){
			var CellCount=7;
			for (var i = 1; i <= CellCount; i++)
				{
				var index = 1;
   				while (httpObjects[index] && index < 40)
      			index++;
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null)
					{
						WriteMultiCell[index]=WriteCell+"_"+i;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet+"&topic_id="+document.getElementById('topic_id').value+"&element_num="+i,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
				}
		}
		else {
			var CellCount=1;
			for (var i = 1; i <= CellCount; i++)
				{
				var index = 1;
   				while (httpObjects[index] && index < 20)
      			index++;
				httpObjects[index] = getHTTPObject();
				if (httpObjects[index] != null)
					{
						WriteMultiCell[index]=WriteCell;
						httpObjects[index].open("GET", "code/functions.php?GetData="+WhatToGet,true);
						httpObjects[index].onreadystatechange = function() {changeMultiContent();};
						httpObjects[index].send(null);
					}
				else alert("httpobject is null");
				}
		}
	}
	}
}
/* These are the functions to maintain the lists when doing database maintenance.
The list changing functions for the plan are below */
function amendList(ListToAmend)
{
	CellToAmend=ListToAmend+"_cell";
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
			var cell=document.getElementById(CellToAmend);
			//alert (httpObject.responseText);
			cell.innerHTML=httpObject.responseText;
			isWorking = false;
		}
	}
}
function ChangeList(WhatToChange,TopicId)
{
	document.location=('topic.php?topic_id='+TopicId+'&mode='+WhatToChange);	
}
function ChangeContentList(WhatToChange,ContentId,topic)
{
	document.location=('content.php?content_id='+ContentId+'&mode='+WhatToChange+'&topic='+topic);	
}
function ChangeContentProgressionList(WhatToChange,ProgressionId,ContentId,progressionNum,topic)
{
	document.location=('content.php?progression_id='+ProgressionId+'&mode='+WhatToChange+'&content_id='+ContentId+'&progression_num='+progressionNum+'&topic='+topic);	
}
function maintainSetPlan()
{
	topicId=document.getElementById('topic').value;
        level=document.getElementById('level').value;
        document.location=('set_plan_maintenance.php?topic_id='+topicId+'&level_id='+level+'&mode=look');
}
function AddToList(Id,WhatToAdd,WhatList,progNum)
{
	var WhatToAddId=WhatToAdd+"_out";
	var WhatToUpdate=WhatToAdd+"_in";
	var AddToTable=document.getElementById(WhatToAddId).value;
			httpObject.open("GET", "../code/functions.php?PutData="+WhatList+"&"+WhatList+"_id="+Id+"&what_to_add="+WhatToAdd+"&what_to_add_id="+AddToTable+"&progression_num="+progNum); 
			httpObject.onreadystatechange = function() {amendList(WhatToUpdate);};
			isWorking = true;
			httpObject.send(null);
}
function AddManyToList(Id,WhatToAdd,WhatList,progNum)
{
	var WhatToAddId=WhatToAdd+"_out";
	var WhatToUpdate=WhatToAdd+"_in";
        var arSelected=new Array();
        var ob=document.getElementById(WhatToAddId);
        for (var i = 0; i < ob.options.length; i++) {
            if (ob.options[ i ].selected)
                arSelected.push(ob.options[ i ].value); }
	       var AddToTable=implode(',',arSelected);
			httpObject.open("GET", "../code/functions.php?PutManyData="+WhatList+"&"+WhatList+"_id="+Id+"&what_to_add="+WhatToAdd+"&what_to_add_id="+AddToTable+"&progression_num="+progNum);
			httpObject.onreadystatechange = function() {amendList(WhatToUpdate);};
			isWorking = true;
			httpObject.send(null);
}
function AddEvaluation(Id,WhatToAdd,WhatList,progNum,level)
{
	var WhatToAddId=WhatToAdd+"_out";
	var WhatToUpdate=WhatToAdd+"_in";
	var AddToTable=document.getElementById(WhatToAddId).value;
		httpObject.open("GET", "../code/functions.php?PutData="+WhatToAdd+"&"+WhatToAdd+"_id="+AddToTable+"&what_to_add="+WhatToAdd+"&what_to_add_id="+Id+"&progression_num="+progNum+"&level="+level);
		httpObject.onreadystatechange = function() {amendList(WhatToUpdate);};
		isWorking = true;
		httpObject.send(null);
}
function RemoveFromList(Id,WhatToRemove,WhatList,progNum)
{
	var WhatToRemoveId=WhatToRemove+"_in";
	var WhatToUpdate=WhatToRemove+"_in";
	var RemoveFromTable=document.getElementById(WhatToRemoveId).value;
	//alert ("../code/functions.php?RemoveData="+WhatList+"&"+WhatList+"_id="+Id+"&what_to_remove="+WhatToRemove+"&what_to_remove_id="+RemoveFromTable);
			httpObject.open("GET", "../code/functions.php?RemoveData="+WhatList+"&"+WhatList+"_id="+Id+"&what_to_remove="+WhatToRemove+"&what_to_remove_id="+RemoveFromTable+"&progression_num="+progNum);
			httpObject.onreadystatechange = function() {amendList(WhatToUpdate);};
			isWorking = true;
			httpObject.send(null);
}
function RemoveManyFromList(Id,WhatToRemove,WhatList,progNum)
{
	var WhatToRemoveId=WhatToRemove+"_in";
	var WhatToUpdate=WhatToRemove+"_in";
	var arSelected=new Array();
        var ob=document.getElementById(WhatToRemoveId);
	 for (var i = 0; i < ob.options.length; i++) {
            if (ob.options[ i ].selected)
                arSelected.push(ob.options[ i ].value); }
	       var RemoveFromTable=implode(',',arSelected);
                        httpObject.open("GET", "../code/functions.php?RemoveManyData="+WhatList+"&"+WhatList+"_id="+Id+"&what_to_remove="+WhatToRemove+"&what_to_remove_id="+RemoveFromTable+"&progression_num="+progNum);
			httpObject.onreadystatechange = function() {amendList(WhatToUpdate);};
			isWorking = true;
			httpObject.send(null);
}
function RemoveFromLevel(Id,themeId)
{
	var levelId=document.getElementById('level').value;
        var WhatToRemoveId="theme_in";
	var WhatToUpdate="theme_in";
	var RemoveFromTable=document.getElementById(WhatToRemoveId).value;
	//alert ("../code/functions.php?RemoveData="+WhatList+"&"+WhatList+"_id="+Id+"&what_to_remove="+WhatToRemove+"&what_to_remove_id="+RemoveFromTable);
			httpObject.open("GET", "../code/functions.php?RemoveThemeLevel="+Id+"&theme="+themeId+"&level="+levelId);
			httpObject.onreadystatechange = function() {ReloadPage('topic.php?topic_id='+Id+'&mode=theme');};
			isWorking = true;
			httpObject.send(null);
}function RemoveEvaluation(Id,topicId,themeId,level)
{
	var RemoveFromTable=document.getElementById('evaluation_in').value;
	//alert ("../code/functions.php?RemoveData="+WhatList+"&"+WhatList+"_id="+Id+"&what_to_remove="+WhatToRemove+"&what_to_remove_id="+RemoveFromTable);
		httpObject.open("GET", "../code/functions.php?RemoveEvaluation=evaluation&evaluation_id="+Id+"&topic_id="+topicId+"&theme_id="+themeId+"&level="+level);
		httpObject.onreadystatechange = function() {amendList('evaluation_in');};
		isWorking = true;
		httpObject.send(null);
}
function AddToProgList(Id,WhatToAdd,WhatList,progNum)
{
	var WhatToAddId=WhatToAdd+"_out["+progNum+"]";
	var WhatToUpdate=WhatToAdd+"_in["+progNum+"]";
	var AddToTable=document.getElementById(WhatToAddId).value;
			httpObject.open("GET", "../code/functions.php?PutData="+WhatList+"&"+WhatList+"_id="+Id+"&what_to_add="+WhatToAdd+"&what_to_add_id="+AddToTable+"&progression_num="+progNum);
			httpObject.onreadystatechange = function() {amendList(WhatToAdd+"_in");};
			isWorking = true;
			httpObject.send(null);
}
function RemoveFromProgList(Id,WhatToRemove,WhatList,progNum)
{
	var WhatToRemoveId=WhatToRemove+"_in["+progNum+"]";
	var WhatToUpdate=WhatToRemove+"_in["+progNum+"]";
	var RemoveFromTable=document.getElementById(WhatToRemoveId).value;
	//alert ("../code/functions.php?RemoveData="+WhatList+"&"+WhatList+"_id="+Id+"&what_to_remove="+WhatToRemove+"&what_to_remove_id="+RemoveFromTable);
			httpObject.open("GET", "../code/functions.php?RemoveData="+WhatList+"&"+WhatList+"_id="+Id+"&what_to_remove="+WhatToRemove+"&what_to_remove_id="+RemoveFromTable+"&progression_num="+progNum);
			httpObject.onreadystatechange = function() {amendList(WhatToRemove+"_in");};
			isWorking = true;
			httpObject.send(null);
}
function DeleteTableItem(table,id,page)
{
		httpObject.open("GET", "../code/functions.php?DeleteTableItem="+table+"&id="+id+"&page="+page);
		httpObject.onreadystatechange = function() {ReloadPage(page);};
			isWorking = true;
			httpObject.send(null);
}
function ReloadPage(page)
{
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
			document.location=(page);
		}
	}
}
function GetStrandLevel(objectiveId,topicId)
{
			httpObject.open("GET", "../code/functions.php?GetStrandLevel=StrandLevel&objective_id="+objectiveId+"&topic_id="+topicId);
			httpObject.onreadystatechange = function() {ShowStrandLevel();};
			isWorking = true;
			httpObject.send(null);
}
function GetLevel(themeId,topicId)
{
			httpObject.open("GET", "../code/functions.php?GetLevel=Level&theme_id="+themeId+"&topic_id="+topicId);
			httpObject.onreadystatechange = function() {ShowLevel();};
			isWorking = true;
			httpObject.send(null);
}
function GetThemeImportance(level,themeId,topicId)
{
			httpObject.open("GET", "../code/functions.php?GetThemeImportance=Importance&theme_id="+themeId+"&topic_id="+topicId+"&level="+level);
			httpObject.onreadystatechange = function() {ShowImportance();};
			isWorking = true;
			httpObject.send(null);
}
function GetThemeNotes(level,themeId,topicId)
{
			importance=document.getElementById('importance').value;
			httpObject.open("GET", "../code/functions.php?GetThemeNotes=notes&theme_id="+themeId+"&topic_id="+topicId+"&level="+level+"&importance="+importance);
			httpObject.onreadystatechange = function() {ShowNotes();};
			isWorking = true;
			httpObject.send(null);
}
function GetThemeEvaluation(level,themeId,topicId)
{
			importance=document.getElementById('importance').value;
			httpObject.open("GET", "../code/functions.php?GetThemeEvaluation=Evaluation&theme_id="+themeId+"&topic_id="+topicId+"&level="+level+"&importance="+importance);
			httpObject.onreadystatechange = function() {ShowEvaluation();};
			isWorking = true;
			httpObject.send(null);
}
function ShowStrandLevel()
{
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
			var cell=document.getElementById('strandlevelcell');
			cell.innerHTML=httpObject.responseText;
			isWorking = false;
		}
	}
}
function ShowImportance()
{
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
			var cell=document.getElementById('importancecell');
			cell.innerHTML=httpObject.responseText;
			isWorking = false;
		}
	}
}
function ShowNotes()
{
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
			var cell=document.getElementById('notescell');
			cell.innerHTML=httpObject.responseText;
			isWorking = false;
		}
	}
}
function ShowEvaluation()
{
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
			var cell=document.getElementById('evaluationcell');
			cell.innerHTML=httpObject.responseText;
			isWorking = false;
		}
	}
}
function UpdateThemeLevelImportanceNotes(level,themeId,topicId,importance)
{
//			evaluation=document.getElementById('evaluation').value;
//			note=document.getElementById('notes[]');
//                        alert(note);
//			httpObject.open("GET", "../code/functions.php?UpdateThemeLevelImportanceNotes=update&theme_id="+themeId+"&topic_id="+topicId+"&level="+level+"&importance="+importance+"&notes='"+note+"'&evaluation=''");
//			httpObject.onreadystatechange = function() {ResetPage();};
//			httpObject.onreadystatechange = function() {alert(httpObject.responseText);};
//			isWorking = true;
//			httpObject.send(null);
document.forms[0].submit();
}
function ResetPage()
{
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
			//alert (httpObject.responseText);
			window.location.reload();
			isWorking = false;
		}
	}
}

function oldShowLevel()
{
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
			var temp = document.getElementById('temp');
  			temp.innerHTML = '<td>'+httpObject.responseText;
			var cell=document.getElementById('levelcell');
  			cell.parentNode.replaceChild(temp.firstChild.firstChild, cell);
			cell.innerHTML=httpObject.responseText;
			isWorking = false;
		}
	}
}
function ShowLevel()
{
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
			var cell=document.getElementById('levelcell');
			cell.innerHTML=httpObject.responseText;
			isWorking = false;
		}
	}
}
function UpdateStrand(strandId,objectiveId,topicId)
{
			httpObject.open("GET", "../code/functions.php?UpdateStrandLevel=strand&id="+strandId+"&objective_id="+objectiveId+"&topic_id="+topicId);
			httpObject.onreadystatechange = function() {ClearStrand();};
			isWorking = true;
			httpObject.send(null);
}
function UpdateObjectiveLevel(levelId,objectiveId,topicId)
{
			httpObject.open("GET", "../code/functions.php?UpdateStrandLevel=level&id="+levelId+"&objective_id="+objectiveId+"&topic_id="+topicId);
			httpObject.onreadystatechange = function() {ClearLevel();};
			isWorking = true;
			httpObject.send(null);
}
function UpdateThemeLevel(levelId,themeId,topicId)
{
			httpObject.open("GET", "../code/functions.php?UpdateThemeLevel=level&id="+levelId+"&theme_id="+themeId+"&topic_id="+topicId);
			httpObject.onreadystatechange = function() {ClearLevel();};
			isWorking = true;
			httpObject.send(null);
}
function ClearStrand()
{
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
			var cell=document.getElementById('strandlevelcell');
			isWorking = false;
		}
	}
}

function ClearLevel()
{
	if(httpObject.readyState == 4)
	{
		if (httpObject.responseText.indexOf('invalid') == -1) 
		{
			var cell=document.getElementById('strandlevelcell');
			//alert(httpObject.responseText);
			isWorking = false;
		}
	}
}
function NewInputWindow(WindowFrom,WindowFile,WindowTitle,WindowWidth,WindowHeight,WindowX,WindowY)
{
	var WindowY = (screen.width  - WindowWidth)/2;
 	var WindowX = (screen.height - WindowHeight)/2;
	WindowVars='width='+WindowWidth+',height='+WindowHeight+',left='+WindowY+',top='+WindowX+',toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no';
	WindowFrom=window.open(WindowFile,WindowTitle,WindowVars);
}
function ReloadForm(obj)
{
	document.location=('content_insert.php?topic=' + obj.value);
}
function chooseContent(obj,mode)
{
	document.location=('choose_content.php?mode=' + mode + '&topic=' + obj.value);
}
function chooseObjective(obj)
{
	document.location=('choose_objective.php?mode=objective&topic=' + obj.value);
}
function editContent(topic,id)
{
	document.location=('content.php?mode=look&content_id='+id + '&topic=' + topic);
}
function editContentResources(topic,id)
{
	document.location=('content_resources.php?mode=look&content_id='+id + '&topic=' + topic);
}
function editContentResource(topic,id,cr_id)
{
	document.location=('content_resources.php?mode=resource_edit&content_id='+id + '&topic=' + topic + '&cr_id=' + cr_id);
}
function editObjective(topic,id)
{
	document.location=('assessment.php?mode=look&objective_id='+id + '&topic=' + topic);
}
function ReturnTo(obj,id)
{
	document.location=(obj+'.php?mode=look&'+obj+'_id='+id);
}
function getCategory(what) {
    if (what.value != '') {
        var category_selected = what.value;
        document.location=('view_service_provider_details.php?cat=' + category_selected);
    }
}

function getCompany(what) {
    if (what.value != '') {
        var category_selected = document.service_select.cat_sel.value;
        var company = what.value;
        document.location=('view_service_provider_details.php?cat=' + category_selected + '&comp=' + company);
    }
}

function ShowUser(who) {
    if (who.value != '') {
        var user_selected = who.value;
        document.location=('view_user_details.php?user=' + user_selected);
    }
}

function JavaPreviewMessage(mess_id,page_num) {
	if (mess_id != '') {
        var mess_selected = mess_id;
		document.location=('display_message.php?mode=preview&mess_id=' + mess_selected + '&page=' + page_num);
    }
}
function JavaShowMessage(mess_id) {
    if (mess_id != '') {
        var mess_selected = mess_id;
        document.location=('display_message.php?mode=show&mess_id=' + mess_selected);
    }
}

function CheckUserInput()
{
		if (document.signin.username.value=="")
  	{
		alert("Please Enter a Username");
		document.signin.username.focus();
		return false;
  	}
		if (document.signin.password.value=="")
  	{
	  	alert("Please Enter a Password");
	  	document.signin.password.focus();
		return false;
  	}
		document.forms[0].submit();
}
function CheckPasswordInput(operation)
{
	if (operation=='request')
	{
		if (document.forms['pwrequest'].username.value=="")
		{
		alert("Please Enter a valid username");
		document.forms['pwrequest'].username.focus();
		return false;
		}
		if (document.forms['pwrequest'].email.value=="")
		{
		alert("Please Enter a valid email address");
		document.forms['pwrequest'].email.focus();
		return false;
		}
		if (document.forms['pwrequest'].email_confirm.value=="")
		{
		alert("Please confirm your email address");
		document.forms['pwrequest'].email_confirm.focus();
		return false;
		}
		if (document.forms['pwrequest'].email.value!=document.forms['pwrequest'].email_confirm.value)
		{
		alert("email addresses do not match");
		document.forms['pwrequest'].email.focus();
		return false;
		}
		return true
	}
	if (operation=='reset')
	{
		if (document.forms['pwreset'].old_password.value=="")
		{
		alert("Please Enter your current password");
		document.forms['pwreset'].old_password.focus();
		return false;
		}
		else if (document.forms['pwreset'].new_password.value=="")
		{
		alert("Please enter a new password");
		document.forms['pwreset'].new_password.focus();
		return false;
		}
		else if (document.forms['pwreset'].confirm_password.value=="")
		{
		alert("Please confirm your new password");
		document.forms['pwreset'].confirm_password.focus();
		return false;
		}
		else if (document.forms['pwreset'].new_password.value!=document.forms['pwreset'].confirm_password.value)
		{
		alert("new and confirm passwords do not match");
		document.forms['pwreset'].confirm_password.value="";
		document.forms['pwreset'].new_password.value="";
		document.forms['pwreset'].new_password.focus();
		return false;
		}
		else if (document.forms['pwreset'].old_password.value==document.forms['pwreset'].new_password.value)
		{
		alert("old and new passwords must not match");
		document.forms['pwreset'].old_password.value="";
		document.forms['pwreset'].confirm_password.value="";
		document.forms['pwreset'].new_password.value="";
		document.forms['pwreset'].old_password.focus();
		return false;
		}
		return true;
	}
}
function MM_findObj(n, d) 
{
var p,i,x; if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
if(!x && document.getElementById) x=document.getElementById(n); return x;
}
/* The following functions are used for building the equipment and the cross curricular opportunity lists
Basically they will check to see if an output select list has been created and create one adn populate it with the selection.
Still need to add an event monitor to remove from this list */
// Marks all the items as selected for the submit button.  
function selectList(sourceList) 
{
	sourceList = window.document.forms[0].parentList;
	for(var i = 0; i < sourceList.options.length; i++) 
		{
			if (sourceList.options[i] != null)
			sourceList.options[i].selected = true;
		}
	return true;
}

// Deletes the selected items of supplied list.
function deleteSelectedItemsFromList(sourceList) 
{
	var maxCnt = sourceList.options.length;
	for(var i = maxCnt - 1; i >= 0; i--) 
	{
		if ((sourceList.options[i] != null) && (sourceList.options[i].selected == true)) 
		{
			sourceList.options[i] = null;
      	}
   	}
}
<!--
// Add the selected items in the parent by calling method of parent
function addSelectedItemsToParent(properties) 
{
	self.opener.addToParentList(window.document.forms[0].destList,properties);
	window.close();
}
// Fill the selcted item list with the items already present in parent.
function fillInitialDestList() 
{
	var destList = window.document.forms[0].destList; 
	var srcList = self.opener.window.document.forms[0].parentList;
	for (var count = destList.options.length - 1; count >= 0; count--) 
	{
		destList.options[count] = null;
	}
	for(var i = 0; i < srcList.options.length; i++) 
	{ 
		if (srcList.options[i] != null)
		destList.options[i] = new Option(srcList.options[i].text);
   	}
}
// Add the selected items from the source to destination list
function addSrcToDestList(list) 
{
	destName = list + "_list";
	srcList = document.getElementById(list); 
	destList = document.getElementById(destName);
	destList.style.visibility="visible";
	var len = destList.length;
	for(var i = 0; i < srcList.length; i++) 
	{
		if ((srcList.options[i] != null) && (srcList.options[i].selected)) 
		{
//Check if this value already exist in the destList or not
//if not then add it otherwise do not add it.
			var found = false;
			for(var count = 0; count < len; count++) 
			{
				if (destList.options[count] != null) 
				{
					if (srcList.options[i].text == destList.options[count].text) 
					{
						found = true;
						break;
      				}
   				}
			}
			if (found != true) 
			{
				destList.options[len] = new Option(srcList.options[i].text); 
				destList.options[len].value = srcList.options[i].value; 
				len++;
         	}
      	}
   	}
}
// Deletes from the destination list.
function deleteFromDestList(list) 
{
	var destName = list + "_list";
	destList = document.getElementById(destName); 
	var len = destList.options.length;
	for(var i = (len-1); i >= 0; i--) 
	{
		if ((destList.options[i] != null) && (destList.options[i].selected == true)) 
		{
			destList.options[i] = null;
      	}
   	}
}
// End -->
function SetFieldFocus(focusfield)
{
	document.forms['enquiry'].focusfield.focus();
}
function implode (glue, pieces) {
    var i = '',
        retVal = '',
        tGlue = '';
    if (arguments.length === 1) {
        pieces = glue;
        glue = '';
    }
    if (typeof(pieces) === 'object') {
        if (pieces instanceof Array) {
            return pieces.join(glue);
        } else {
            for (i in pieces) {
                retVal += tGlue + pieces[i];
                tGlue = glue;
            }
            return retVal;
        }
    } else {
        return pieces;
    }
}
function orderPoints(contentId,mode,topicId)
{
    document.location=('points_order.php?content_id=' +contentId+"&mode='"+mode+"'&topic="+topicId);
}