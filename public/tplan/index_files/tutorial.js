function ajaxRequest(){
 var activexmodes=["Msxml2.XMLHTTP", "Microsoft.XMLHTTP"] //activeX versions to check for in IE
 if (window.ActiveXObject){ //Test for support for ActiveXObject in IE first (as XMLHttpRequest in IE7 is broken)
  for (var i=0; i<activexmodes.length; i++){
   try{
    return new ActiveXObject(activexmodes[i])
   }
   catch(e){
    //suppress error
   }
  }
 }
 else if (window.XMLHttpRequest) // if Mozilla, Safari etc
  return new XMLHttpRequest()
 else
  return false
}

var mygetrequest=new ajaxRequest()
mygetrequest.onreadystatechange=function(){
 if (mygetrequest.readyState==4){
  if (mygetrequest.status==200 || window.location.href.indexOf("http")==-1){
   document.getElementById("result").innerHTML=mygetrequest.responseText
  }
  else{
   alert("An error has occured making the request")
  }
 }
}
var namevalue=encodeURIComponent(document.getElementById("name").value)
var agevalue=encodeURIComponent(document.getElementById("age").value)
mygetrequest.open("GET", "tutorial.php?name="+namevalue+"&age="+agevalue, true)
mygetrequest.send(null)