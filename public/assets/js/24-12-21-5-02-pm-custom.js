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
            $('.updateSearchableSelect').select2({dropdownParent: $('.updateSearchableSelect').parent()});
        }
    });

}








/*================
Date Code Start
================*/


 // setting current date code Start
 $(document).ready(function() {
    var today = new Date().toISOString().split('T')[0];
    let formatDate = today.split('-');
    $('#val-date').val(formatDate[2]+' / '+formatDate[1]+' / '+formatDate[0]);
})
// setting current date code end


function checkValue(str, max) {
    if (str.charAt(0) !== '0' || str == '00') {
        var num = parseInt(str);
        if (isNaN(num) || num <= 0 || num > max) num = 1;
        str = num > parseInt(max.toString().charAt(0)) && num.toString().length == 1 ? '0' + num : num.toString();
    };
    return str;
};

// reformat by date
function date_reformat_dd(date) {
    date.addEventListener('input', function(e) {
        this.type = 'text';
        var input = this.value;
        if (/\D\/$/.test(input)) input = input.substr(0, input.length - 3);
        var values = input.split('/').map(function(v) {
            return v.replace(/\D/g, '')
        });
        if (values[1]) values[1] = checkValue(values[1], 12);
        if (values[0]) values[0] = checkValue(values[0], 31);

        var output = values.map(function(v, i) {
            return v.length == 2 && i < 2 ? v + ' / ' : v;
        });
        this.value = output.join('').substr(0, 14);
    });

}


/*================
Date Code end
================*/




/*================
searchable Select Code start
================*/

$(document).ready(function() {
    $('.searchableSelect').select2({
        dropdownParent: $('.searchableSelect').parent()
    });
});

function initializeSelect2() {
    $('.searchableSelect').select2({
        dropdownParent: $('.searchableSelect').parent()
    });
};



/*================
searchable Select Code end
================*/




/*================
Input coma seperated Code start
================*/

function updateTextView(e){
    var num = getNumber($(e).val());
    if(num==0){
      $(e).val('');
    }else{
      $(e).val(num.toLocaleString());
    }
}
  function getNumber(_str){
    var arr = _str.split('');
    var out = new Array();
    for(var cnt=0;cnt<arr.length;cnt++){
      if(isNaN(arr[cnt])==false){
        out.push(arr[cnt]);
      }
    }
    return Number(out.join(''));
  }


/*================
Input coma seperated Code end
================*/

