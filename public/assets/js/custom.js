function commonFunction(confirmation=false,targetUrl,returnUrl,method,msg='',formID=''){
    if(confirmation){
        swal({
            text: msg,
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: "OK"
            },
        }).then((willDelete) => {
            if (willDelete)
            {
                $.ajax({
                    type: method,
                    url: targetUrl,
                    data: {_token: $('#laravelToken').val()},
                    success: function(data) {
                        if(data.success==true){
                            swal("success", data.message, "success").then((value) => {
                                window.location = returnUrl;
                            });
                        }else if(data.success==false ){
                            swal("warning", data.message, "warning").then((value) => {
                                // window.location = returnUrl;
                            });
                        }

                    }
                });
            }
        });
    }else{
        var myform = document.getElementById(formID);
        var fd = new FormData(myform);
        fd.append("_token", $('#laravelToken').val());
        $.ajax({
            url: targetUrl,
            type: method,
            processData: false,
            contentType: false,
            data: fd,
            success: function (data) {

                if (data.success == true) {
                    swal("success", data.message, "success").then((value) => {
                        window.location=returnUrl;
                    });
                } else {
                    if (data.hasOwnProperty("message")) {
                        var wrapper = document.createElement("div");
                        var err = "";
                        $.each(data.message, function (i, e) {
                            err += "<p>" + e + "</p>";
                        });

                        wrapper.innerHTML = err;
                        console.log(wrapper);
                        swal({
                            icon: "error",
                            // text: "Please fix following error!",
                            content: wrapper,
                            type: "error",
                        });
                    }
                }
            },
        });
    }
}

function commonFunctionForAllRequest(html=false,confirmation=false,targetElement='',targetUrl,returnUrl='',method,msg='',formID=''){
    if(confirmation){
        swal({
            text: msg,
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: "OK"
            },
        }).then((willDelete) => {
            if (willDelete)
            {
                $.ajax({
                    type: method,
                    url: targetUrl,
                    data: {_token: $('#laravelToken').val()},
                    success: function(data) {
                        if(data.success==true){
                            swal("success", data.message, "success").then((value) => {
                                window.location = returnUrl;
                            });
                        }else if(data.success==false ){
                            swal("warning", data.message, "warning").then((value) => {
                                // window.location = returnUrl;
                            });
                        }

                    }
                });
            }
        });
    }else if(html){
        ajaxCommonCodeForFormData(html,targetElement,targetUrl,returnUrl,method,formID);
    } else{
        // var myform = document.getElementById(formID);
        // var fd = new FormData(myform);
        // fd.append("_token", $('#laravelToken').val());
        // $.ajax({
        //     url: targetUrl,
        //     type: method,
        //     processData: false,
        //     contentType: false,
        //     data: fd,
        //     success: function (data) {

        //         if (data.success == true) {
        //             swal("success", data.message, "success").then((value) => {
        //                 window.location=returnUrl;
        //             });
        //         } else {
        //             if (data.hasOwnProperty("message")) {
        //                 var wrapper = document.createElement("div");
        //                 var err = "";
        //                 $.each(data.message, function (i, e) {
        //                     err += "<p>" + e + "</p>";
        //                 });

        //                 wrapper.innerHTML = err;
        //                 console.log(wrapper);
        //                 swal({
        //                     icon: "error",
        //                     // text: "Please fix following error!",
        //                     content: wrapper,
        //                     type: "error",
        //                 });
        //             }
        //         }
        //     },
        // });
        ajaxCommonCodeForFormData(html,targetElement,targetUrl,returnUrl,method,formID);
    }

}

// common code for ajax request for form Data
function ajaxCommonCodeForFormData(html,targetElement,targetUrl,returnUrl,method,formID){
    var fd = new FormData(document.getElementById(formID));
    fd.append("_token", $('#laravelToken').val());
    $.ajax({
        url: targetUrl,
        type: method,
        processData: false,
        contentType: false,
        data: fd,
        success: function (data) {

            if (data.success == true && html) {
               $(targetElement).html(data.html)
            } else if (data.success == true && !html) {
                swal("success", data.message, "success").then((value) => {
                    window.location=returnUrl;
                });
            } else {
                if (data.hasOwnProperty("message")) {
                    var wrapper = document.createElement("div");
                    var err = "";
                    $.each(data.message, function (i, e) {
                        err += "<p>" + e + "</p>";
                    });

                    wrapper.innerHTML = err;
                    console.log(wrapper);
                    swal({
                        icon: "error",
                        // text: "Please fix following error!",
                        content: wrapper,
                        type: "error",
                    });
                }
            }
        },
    });
}

// function for edit data using modal
function editResource(targetUrl,targetTag) {
    $.ajax({
        type: 'get',
        url: targetUrl,
        success: function(data) {
            $(targetTag).html(data);
        }
    });
}




// const commaSeperated = (val) =>{
//     var num = getNumber(val.toLocaleString());
//     if(num!=0){
//         return num.toLocaleString();
//     }

// }

function commaSeparateNumber(val){
    while (/(\d+)(\d{3})/.test(val.toString())){
      val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
    }
    return val;
  }




