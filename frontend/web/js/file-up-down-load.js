function fileUpload(formID, url) {
    $.ajax(
            {
                url: url,
                type: 'post',
                data: new FormData($('#' + formID)[0]),
                cache: false,
                contentType: false,
                processData: false,
                success: function (success) {
                    success ?
                            customErrorSwal('Completed!!', 'File Uploaded Successfully', '1200', 'success') :
                            customErrorSwal('Failed', 'File Did Not Upload', '1200', 'error');
                },
                error: function () {
                    errorSwal();
                }
            }
    );

    return false;
}

function fileNotFound(filename) {
    swal(
            {
                title: "File Not Found",
                text: "<i>'" + filename + "'</i>" + " seems to have been earlier moved or removed",
                type: 'error',
                html: true,
                showConfirmButton: true,
                confirmButtonText: 'ok',
                closeOnConfirm: true,
                allowEscapeKey: true,
                allowOutsideClick: true,
                showCloseButton: true
            }
    );
}

function downloadDoc(file, fn) {
    $.ajax(
            {
                url: '../site/FileExists?file=' + file,
                type: 'post',
                success: function (url) {
                    url === '' || url === null ? fileNotFound(fn) : popWindow(url, fn);
                },
                error: function () {
                    errorSwal();
                }
            }
    );
}

function readURL(input, elmtRef) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $(elmtRef).attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}


