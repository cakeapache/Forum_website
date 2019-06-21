
var listColor='skyblue';
function creatLi(data,className,id){

    var ul =document.createElement('ul');
    ul.className=className;
    ul.id=id;
    var li=[]

        
        data.forEach(value => {
            var node=document.createElement('li');
            
            var textnode=document.createTextNode(value);
 
            node.appendChild(textnode);
       
            li.push(node);
        });
       
        li.forEach(value => {
            ul.appendChild(value);
        });

        document.body.appendChild(ul);
}

function show(obj,list){
    
   var p=kingwolfofsky.getInputPositon(obj);
    var temp=document.getElementById(list);

    temp.style.top=p.bottom-obj.scrollTop+'px';
   temp.style.left = p.left-obj.scrollLeft+ 'px';
    temp.style.display="inline-block";
  
    
}
function closeLi(list){
    var temp=document.getElementById(list);
    var li=temp.getElementsByTagName('li');
    for(let i=0;i<li.length;i++){
            
      li[i].style.background="white";
      li[i].style.zIndex=10;
    
        
    }
    temp.style.display="";
}

function selectList(list){

    var recentSelet=-1;
    var li=[]
        if((document.getElementById(list).style.display!="none"&&document.getElementById(list).style.display!='') && event.keyCode=='40'){

            var oldLi=document.getElementById(list).getElementsByTagName('li');
        for(let i=0;i<oldLi.length;i++){
            
            if(oldLi[i].style.display!="none"){
                li.push(oldLi[i]);
           
            }
        }
      

          for(let i=0;i<li.length;i++){
            
              if(li[i].style.background==listColor){
                  recentSelet=i;
              }
          }
        
          switch(recentSelet){
            case -1:li[0].style.background=listColor;break;
            case (li.length-1):
                li[li.length-1].style.background="white";
                li[0].style.background=listColor;
                break;
            default:
                 li[recentSelet].style.background="white";
                 li[recentSelet+1].style.background=listColor;


          }}else if((document.getElementById(list).style.display!="none"&&document.getElementById(list).style.display!='') && event.keyCode=='38'){

            var oldLi=document.getElementById(list).getElementsByTagName('li');
            for(let i=0;i<oldLi.length;i++){
            
                if(oldLi[i].style.display!="none"){
                    li.push(oldLi[i]);
               
                }
            }
            for(let i=0;i<li.length;i++){
              
                if(li[i].style.background==listColor){
                    recentSelet=i;
                }
            }
          
            switch(recentSelet){
              case -1:li[li.length-1].style.background=listColor;break;
              case (0):
                  li[0].style.background="white";
                  li[li.length-1].style.background=listColor;
                  break;
              default:
                   li[recentSelet].style.background="white";
                   li[recentSelet-1].style.background=listColor;
  

            }
           
         
        }       
    
}

/*var ignoreKey = false;
/*var handler = function(e)
{
    if (ignoreKey&& document.getElementById('suggestion').style.display!="none")
    {   
        e.preventDefault();
        return;
    }
    if ((e.keyCode == 38 || e.keyCode == 40 )&& document.getElementById('suggestion').style.display!="none") 
    {
        var pos = this.selectionStart;
        //this.value = (e.keyCode == 38?1:-1)+parseInt(this.value,10);        
        this.selectionStart = pos; this.selectionEnd = pos;

        ignoreKey = true; setTimeout(function(){ignoreKey=false},1);
        e.preventDefault();
    }
};*/
function splitToS(val){
  return  val.split(/\n/);
}
function extractLastS( term ) {
  return splitToS( term ).pop();
}

function split( val ) {
  return val.split( /\s/ );
}

function extractLast( term ) {
  return split( term ).pop();
}

function insertWord(obj,e,list){
    if(e.keyCode==13){
        var li=document.getElementById(list);
        if(li.style.display!=''&&li.style.display!='none'){
            var innerLi=li.getElementsByTagName('li');
            for(let i=0;i<innerLi.length;i++){
               

                if(innerLi[i].style.backgroundColor==listColor){
                  var str=innerLi[i].innerHTML;
                  
              
                  var lineData=splitToS(obj.value.slice(0,obj.selectionStart));
                  var wordData=split(lineData.pop());
                  var point=wordData.pop();
                  if(point.indexOf('.')>=0){

                    wordData.push(point.substring(0,point.indexOf('.')+1)+str);
                  }else{
                  wordData.push(str);
                  }
                  var lastLine=wordData.join(' ');
                  lineData.push(lastLine);
                  obj.value=lineData.join('\n')+obj.value.slice(obj.selectionStart,obj.length);
                  obj.selectionStart=lineData.join('\n').length;
                  obj.selectionEnd=lineData.join('\n').length;
                 
                  closeLi(list);
                  e.preventDefault();
                }
            }
        }

    }

}
function handler(obj,e,list){
  
    if(document.getElementById(list).style.display!=""&&document.getElementById(list).style.display!="none"){
   
        if((e.keyCode == 38 || e.keyCode == 40 )){
        
       // var pos = obj.selectionStart;
       // obj.selectionStart = pos; obj.selectionEnd = pos;
        e.preventDefault();
        }
    }

}
function filter(str,list){
    var strArray=str.split(/\s/);
 
    var critcalWord=strArray.pop();
    let data=[]
    if(critcalWord!=""&&critcalWord!=" "){
        
    var li =document.getElementById(list).getElementsByTagName('li');
  
    for(let i=0;i<li.length;i++){
        if(critcalWord.search(/[()]/)==-1 &&(critcalWord[critcalWord.length-1]=='.' || ((li[i].innerHTML).toLowerCase()).search(critcalWord.substring(critcalWord.indexOf('.')+1))>=0)||(critcalWord.search(/[()]/)==-1 && ((li[i].innerHTML).toLowerCase()).search(critcalWord.toLowerCase())>=0)){
            li[i].style.display="block";
        data.push(li[i].innerHTML);
        }else{
            
            li[i].style.display="none";
        }
    }
}

 return data;
  
  
  
}


function test1(textId,listId){

document.getElementById(textId).addEventListener('blur',function(){closeLi(listId);});
document.getElementById(textId).addEventListener('keydown',function(e){handler(this,e,listId);

                                                                                                                                                                                                                                                                                                    
                                                                                  if(e.keyCode==27){
                                                                                    closeLi(listId);
                                                                                  } 
                                                                                  insertWord(this,e,listId);
                                                                                 
                                                                                    selectList(listId);
                                                                            
                                                                                
                                                                                
                                                                                
                                                                                });


document.getElementById(textId).addEventListener('keyup',function(e){
                                                                    if(filter(this.value.slice(0,this.selectionStart),listId).length>0){
                                                                      
                                                                       
                                                                     if(e.keyCode!=39&&e.keyCode!=37&&e.keyCode!=27&&e.keyCode!=13){
                                                                       if((e.keyCode==38 ||e.keyCode==40)){
                                                                           return ;
                                                                       }
                                                                        show(this,listId); 
                                                                        //selectList('suggestion');
                                                                     }else {closeLi(listId);}
                                                                     
                                                                    }else {closeLi(listId);}
                                                                        
                                                                        
                                                                });



                                                            }                                   
var kingwolfofsky = {
    
    getInputPositon: function (elem) {
        if (document.selection) {   
            elem.focus();
            var Sel = document.selection.createRange();
            return {
                left: Sel.boundingLeft,
                top: Sel.boundingTop,
                bottom: Sel.boundingTop + Sel.boundingHeight
            };
        } else {
            var that = this;
            var cloneDiv = '{$clone_div}', cloneLeft = '{$cloneLeft}', cloneFocus = '{$cloneFocus}', cloneRight = '{$cloneRight}';
            var none = '<span style="white-space:pre-wrap;"> </span>';
            var div = elem[cloneDiv] || document.createElement('div'), focus = elem[cloneFocus] || document.createElement('span');
            var text = elem[cloneLeft] || document.createElement('span');
            var offset = that._offset(elem), index = this._getFocus(elem), focusOffset = { left: 0, top: 0 };
 
            if (!elem[cloneDiv]) {
                elem[cloneDiv] = div, elem[cloneFocus] = focus;
                elem[cloneLeft] = text;
                div.appendChild(text);
                div.appendChild(focus);
                document.body.appendChild(div);
                focus.innerHTML = '|';
                focus.style.cssText = 'display:inline-block;width:0px;overflow:hidden;z-index:-100;word-wrap:break-word;word-break:break-all;';
                div.className = this._cloneStyle(elem);
                div.style.cssText = 'visibility:hidden;display:inline-block;position:absolute;z-index:-100;word-wrap:break-word;word-break:break-all;overflow:hidden;';
            };
            div.style.left = this._offset(elem).left + "px";
            div.style.top = this._offset(elem).top + "px";
            var strTmp = elem.value.substring(0, index).replace(/</g, '<').replace(/>/g, '>').replace(/\n/g, '<br/>').replace(/\s/g, none);
            text.innerHTML = strTmp;
 
            focus.style.display = 'inline-block';
            try { focusOffset = this._offset(focus); } catch (e) { };
            focus.style.display = 'none';
            return {
                left: focusOffset.left,
                top: focusOffset.top,
                bottom: focusOffset.bottom
            };
        }
    },
 
   
    _cloneStyle: function (elem, cache) {
        if (!cache && elem['${cloneName}']) return elem['${cloneName}'];
        var className, name, rstyle = /^(number|string)$/;
        var rname = /^(content|outline|outlineWidth)$/; 
        var cssText = [], sStyle = elem.style;
 
        for (name in sStyle) {
            if (!rname.test(name)) {
                val = this._getStyle(elem, name);
                if (val !== '' && rstyle.test(typeof val)) { 
                    name = name.replace(/([A-Z])/g, "-$1").toLowerCase();
                    cssText.push(name);
                    cssText.push(':');
                    cssText.push(val);
                    cssText.push(';');
                };
            };
        };
        cssText = cssText.join('');
        elem['${cloneName}'] = className = 'clone' + (new Date).getTime();
        this._addHeadStyle('.' + className + '{' + cssText + '}');
        return className;
    },
 
   
    _addHeadStyle: function (content) {
        var style = this._style[document];
        if (!style) {
            style = this._style[document] = document.createElement('style');
            document.getElementsByTagName('head')[0].appendChild(style);
        };
        style.styleSheet && (style.styleSheet.cssText += content) || style.appendChild(document.createTextNode(content));
    },
    _style: {},

    _getStyle: 'getComputedStyle' in window ? function (elem, name) {
        return getComputedStyle(elem, null)[name];
    } : function (elem, name) {
        return elem.currentStyle[name];
    },
 
   
    _getFocus: function (elem) {
        var index = 0;
        if (document.selection) {
            elem.focus();
            var Sel = document.selection.createRange();
            if (elem.nodeName === 'TEXTAREA') {
                var Sel2 = Sel.duplicate();
                Sel2.moveToElementText(elem);
                var index = -1;
                while (Sel2.inRange(Sel)) {
                    Sel2.moveStart('character');
                    index++;
                };
            }
            else if (elem.nodeName === 'INPUT') {
                Sel.moveStart('character', -elem.value.length);
                index = Sel.text.length;
            }
        }
        else if (elem.selectionStart || elem.selectionStart == '0') { 
            index = elem.selectionStart;
        }
        return (index);
    },
 
    
    _offset: function (elem) {
        var box = elem.getBoundingClientRect(), doc = elem.ownerDocument, body = doc.body, docElem = doc.documentElement;
        var clientTop = docElem.clientTop || body.clientTop || 0, clientLeft = docElem.clientLeft || body.clientLeft || 0;
        var top = box.top + (self.pageYOffset || docElem.scrollTop) - clientTop, left = box.left + (self.pageXOffset || docElem.scrollLeft) - clientLeft;
        return {
            left: left,
            top: top,
            right: left + box.width,
            bottom: top + box.height
        };
    }
};
 
function getPosition(ctrl) {
    var p = kingwolfofsky.getInputPositon(ctrl);
    document.getElementById('show').style.left = p.left + "px";
    document.getElementById('show').style.top = p.bottom + "px";
}
