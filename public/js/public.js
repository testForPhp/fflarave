
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function checkEmail(emailStr){
    let start=0;
    let end=emailStr.length;
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

function jsonsMsg(xhr) {
    let errors = '';
    if(xhr.responseJSON.errors){
        $.each(xhr.responseJSON.errors,function (index,val) {
            errors += "<p>" + val[0] + "</p>";
        });
    }else{
        errors = xhr.responseJSON.message;
    }
    return errors;
}

function successMsg(text) {
    swal(
        text,
        '',
        'success'
    )
}
function errorMsg(text) {
    sweetAlert(
        text,
        '',
        'error'
    )
}

function errorHtmlMsg(html){
    swal({
        title: '',
        type: 'error',
        html:html,
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonText:
            '關閉',
        confirmButtonAriaLabel: '',
        cancelButtonText:
            '',
        cancelButtonAriaLabel: 'Thumbs down',
    })
}