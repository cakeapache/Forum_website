
function addCode(eleId){
  var htmlCode = document.getElementById(eleId).value;
  var ifrmae = document.getElementById('iframe');
  if(ifrmae.contentDocument.getElementById(eleId)!=null)
     ifrmae.contentDocument.getElementById(eleId).innerHTML= htmlCode;
}


function addJs(){
  var jsCode = document.getElementById("jsCode").value;
  var ifrmae = document.getElementById('iframe');
 

 
     ifrmae.contentDocument.getElementById("jsCode").innerHTML= jsCode;
}
function reloadIframe(){
  document.getElementById('iframe').contentDocument.location.reload();


 
};

