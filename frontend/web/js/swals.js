function errorSwal() {
    swal(
            {
                title: 'An Error Occured',
                text: 'Please Try Again<br/>If this error persists, please seek assistance from your system administrator',
                timer: 1200,
                type: 'error',
                html: true,
                showConfirmButton: false,
                closeOnConfirm: true,
                allowEscapeKey: true,
                allowOutsideClick: true,
                showCloseButton: true
            }
    );
}

function customErrorSwal(title, message, timer, type) {
    swal(
            {
                title: title,
                text: message,
                timer: timer,
                type: type,
                html: true,
                showConfirmButton: true,
                closeOnConfirm: true,
                allowEscapeKey: true,
                allowOutsideClick: true,
                showCloseButton: true
            }
    );
}

function customAjaxLoader (title, message) {
    swal(
            {
                title: title,
                text: "<img src='../../../common/assets/icons/loading.gif' width='30%'/><br/><br/><br/>" + message,
                html: true,
                showConfirmButton: false,
                closeOnConfirm: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
                showCloseButton: false
            }
    );
}

