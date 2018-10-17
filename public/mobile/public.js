var myApp = new Framework7({
    name:website,
    lazy: {
        threshold: 50,
        sequential: false,
    },
});

var $$ = Dom7;

var swiper = myApp.swiper.create('.swiper-container', {
    init:true,
    speed: 300,
    spaceBetween: 100,
    pagination: {
        el: '.swiper-pagination',
    },
    autoplay: {
        delay: 2000,
    },
});
myApp.lazy.create('.lazy');

myApp.request.setup({
    headers: {
        'X-CSRF-TOKEN': $$('meta[name="csrf-token"]').attr('content')
    }
});

function videoListMart(data,imgServer = '') {
    var _html = '';
    for ( i=0; i< data.length; i++ ){
        _html += videoListHtml(data[i],imgServer);
    }
    return _html;
}

function videoListHtml(data,imgServer)
{
    if(imgServer != ''){
        data.thumb = imgServer + data.thumb;
    }
    return '<div class="card demo-facebook-card"><div class="card-header"><div class="demo-facebook-name">'+data.title+'</div><div class="demo-facebook-date">'+data.time+'</div></div><div class="card-content"><a href="/mobile/v/'+data.token+'" class="external"> <img src="'+data.thumb+'" width="100%"/></a></div><div class="card-footer"><a class="link"><i class="f7-icons diy-size-20">timer_fill</i>'+data.limit+'</a><a class="link"><i class="f7-icons diy-size-20">videocam_round_fill</i>'+data.pixel+'</a><a class="link"><i class="f7-icons diy-size-20">eye_fill</i>'+data.view+'</a></div></div>';
}
function checkEmail(emailStr){
    let start = 0;
    let end = emailStr.length;
    while(start<end){
        let charcode=emailStr.charCodeAt(start);
        if(!(charcode==45||charcode==46||
            (charcode>=48&charcode<=59)||
            (charcode>=64&charcode<=90)||  (charcode>=97&charcode<=122))){
            return false;
        }
        start++;
    }

    let emailStrArr=emailStr.split("@");
    if(emailStrArr.length!=2){
        return false;
    }else if(emailStrArr[0]==''||emailStrArr[1]==''){
        return false;
    }else{
        if(emailStrArr[0].split(".").length>1){
            return false;
        }
        let emailStr2Arr=emailStrArr[1].split(".");
        if(emailStr2Arr.length<2){
            return false;
        }else if(emailStr2Arr[0]==''||emailStr2Arr[emailStr2Arr.length]==''){
            return false;
        }else if(!(emailStr2Arr[emailStr2Arr.length-1]=='com'||
            emailStr2Arr[emailStr2Arr.length-1]=='cn'||
            emailStr2Arr[emailStr2Arr.length-1]=='gov'||
            emailStr2Arr[emailStr2Arr.length-1]=='edu'||
            emailStr2Arr[emailStr2Arr.length-1]=='net'||
            emailStr2Arr[emailStr2Arr.length-1]=='org'||
            emailStr2Arr[emailStr2Arr.length-1]=='int'||
            emailStr2Arr[emailStr2Arr.length-1]=='mil')){
            return false;
        }
    }
    return true;
}

function errorJsonToText(data)
{
    let errorMsg = '';
    if(data.message){
        errorMsg = data.message;
    }else{
        for (var i in data.errors){
            errorMsg += '<p>' + data.errors[i][0] + '</p>';
        }
    }
    return errorMsg;
}

function toastConter($text) {
    return myApp.toast.create({
        text: $text,
        position: 'center',
        closeTimeout: 2000,
    });
}

function notifications(title,content,endtime = 3000) {
    return  myApp.notification.create({
        icon: '<i class="f7-icons text-color-red">bell_fill</i>',
        title: website,
        titleRightText: 'now',
        subtitle: title,
        text: content,
        closeTimeout: endtime,
    });
}
