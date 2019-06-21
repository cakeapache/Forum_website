function test(){
    win=document.documentElement;
    judge=window.event.wheelDelta;
    bar = document.getElementById('navId');
    bar.style.display = 'block';
    if(judge<0){
        bar.classList.add("fadeOutUp");
        win.scrollTop+=15;
    }
    if(judge>0){
        bar.classList.remove("fadeOutUp");
    }else if(win.scrollTop==0){
        bar.classList.remove("fadeOutUp");
    }
}

function pop(){
    item=document.getElementById('login');
    item.style.display = 'block';
        if(item.className=="login animated fast fadeInRight fadeOutRight"){
        item.classList.remove("fadeOutRight");
        item.style.display="block";
        }else{
            item.classList.add("fadeOutRight");
        }
}
function setting(){
    item =document.getElementById('setting');
    item.style.display = 'block';
    if(item.className =="setting-container animated faster fadeInRight fadeOutRight"){
        item.classList.remove('fadeOutRight');
        item.style.display='block';
    }else{
        item.classList.add('fadeOutRight');
    }
}
//jQuery loading function
$loading = $('.loading');
$progress = $('.loading .progress');
$bar = $('.loading .progress .bar');
prg = 0;
timer = 0;
item = document.getElementById('input');
item2 = document.getElementById("setting");
window.onload = ()=>{
    Page("on-load");
    if(item2) item2.style.display = 'none';
    //jQuery loading function
    progress(100,[1,5],[10,50],()=>{
        window.setTimeout(()=>{
        $loading.fadeOut();
        },300);
    });


}
function progress(dist,speed,delay,callback){
    _dist = random(dist);
    _delay = random(delay);
    _speed = random(speed);
    window.clearTimeout(timer);
    timer = window.setTimeout(()=>{
        if( prg + _speed >= dist){
            window.clearTimeout(timer);
            prg = _dist;
            callback && callback();
        } else{
            prg = prg + _speed;
            progress(_dist,speed,delay,callback);
        }
        
        $progress.html("<img src='/static/img/loading.gif' style='width:300px;height:150px;'/><br/><div class='bar' style='width:"+parseInt(prg/4)+"%;'"+
        ">&nbsp</div><br/>"+parseInt(prg)+"%");
    },_delay);
}
function random(n){
    if(typeof n =="object"){
        times = n[1]-n[0];
        offset = n[0];
        return Math.random()* times + offset;
    }else{
        return n;
    }
}

function Page(id){
    page1 = document.getElementById('main-content');
    page2 = document.getElementById('second-content');
    bt1 = document.getElementById('bt1');
    bt2 = document.getElementById('bt2');
if(page1 && page2 && bt1 && bt2){
    switch(id){
        case "main-content":
            page1.style.display='block';
            page2.style.display='none';
            bt1.classList.add('active');
            bt2.classList.remove('active');
            break;
        case "second-content":
            page1.style.display='none';
            page2.style.display='block';
            bt1.classList.remove('active');
            bt2.classList.add('active');
            break;
        case "on-load":
                page1.style.display='block';
                page2.style.display='none';
                bt1.classList.add('active');
                bt2.classList.remove('active');
                break;
        default:
            alert('error');
    }
}
}
//pop(),setting() is open-window function 