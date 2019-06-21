BTM = document.getElementById('ToBTM');
inp = document.getElementById('main-content1');
elements = document.getElementsByName('board');
stage = document.getElementById('stage');
BTM.onclick= ()=>{
    if(stage.value<=elements.length){
        for(i = 0;i<elements.length;i++){
            if(stage.value-1==i){
                window.scrollTo(0,elements[i].getBoundingClientRect().top+ window.scrollY-72);
            }
        }
    }else{
        alert('沒有這層樓!!ˊ。w。ˋ');
    }
}

function change(){
    $hidden=$("#post_content").val().trim();
    space = document.getElementById('reply');
$("#post_content").attr('value',space.innerHTML);
if($hidden.length>225){
    alert("超過225個字了><!!");
}
}
function check(form,cat,top){
    b = document.getElementById('post_content');
    if(b.value==''){
        alert("請輸入內容!!");
    } else{
        form.submit();
    }
}


parameter = location.href;
if(parameter.indexOf('?')==-1){
    value = 1;
}else{
value = parameter.split('?')[1];
}
elements = document.getElementsByName('board');
page_content = document.getElementById('page');
per = 8;
page = Math.ceil(elements.length/per);
for(i=0 ; i< elements.length;i++){
    elements[i].style.display='none';
}
if(page>1){
    str='<a style="font-size:16px;">第 </a>';
    for( i =1; i<=page;i++){
        str=str+"<a href='?"+i+"' name='label' style='border:1px solid white; border-radius:4px; color:black; font-size:18px; background:rgba(115, 195, 210,0.6); margin:5px; padding:5px;' >"+i+"</a>";
    }
    str=str+'<a style="font-size:16px;">'+"頁"+'</a>';
    page_content.innerHTML=str;
    labels = document.getElementsByName('label');
    for(i = 0 ;i<labels.length;i++){
        if(i+1==value){
            labels[i].style.color='white';
        }
    }
}
for(i=(value-1)*per ; i< per+((value-1)*per);i++){
        elements[i].style.display='inline-block';
}

function imgCont(){
    a = document.getElementById('imgContainer');
    if(a.className=="imageContainer animated fast fadeInUp fadeOutDown"){
        alert("上傳圖片單次上傳總大小限制為30MB，且圖片限定檔名為pmg，jpeg，gif。");
        a.style.display = 'block';
        a.classList.remove('fadeOutDown');
    }else {
        a.classList.add('fadeOutDown');
    }
}