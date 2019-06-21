function insertAtCursor(myValue) {
	myField = document.getElementById("textarea");
	if (document.selection) {
	    myField.focus();
	    sel = document.selection.createRange();
	    sel.text = myValue;
	}
	else if (myField.selectionStart || myField.selectionStart == '0') {
	    var startPos = myField.selectionStart;
	    var endPos = myField.selectionEnd;
	    myField.value = myField.value.substring(0, startPos)
	        + myValue
	        + myField.value.substring(endPos, myField.value.length);
	        myField.selectionStart = startPos + myValue.length;
	        myField.selectionEnd = startPos + myValue.length;
	} else {
	    myField.value += myValue;
	}
}
function ltrim(str){ 
	return str.replace(/(^\s*)/g,"");
   }

   var shift,digital0,backetLeft;
document.getElementById('textarea').onkeydown = function(e){

	if (e.keyCode == 9) {
		insertAtCursor('    ');
		return false;
	}else if(e.keyCode==13){
		
		if(document.getElementById('suggestion').style.display==''||document.getElementById('suggestion').style.display=='none'){
			var lastStr=splitToS(this.value.slice(0,this.selectionStart)).pop();
			var length=lastStr.length-ltrim(lastStr).length;

		var str="\n";
		for(var i=0;i<length;i++){
			str+=" ";
		}
		insertAtCursor(str);
		return false;
		}
	}
	if(e.keyCode==16){
	
		shift=true;
	}
	if(e.keyCode==57){	
	
		digital0=true;
	}
	if(e.keyCode==219){
		backetLeft=true;
	}
	if(shift && digital0){
	
		insertAtCursor("()");
		this.selectionStart-=1;
		this.selectionEnd-=1;
		return false;
	}

	if(shift && backetLeft){
		
		insertAtCursor("{}");
		this.selectionStart-=1;
		this.selectionEnd-=1;
		return false;
	}
}

document.getElementById('textarea').onkeyup=function(e){
	shift=false;
	digital0=false;
	backetLeft=false
}


function share(){
	item = document.getElementById('textarea');
	data = document.getElementById('shareData');
	data.value = item.innerHTML;
	alert(data.value);
}