function jsonJQueryHtml(url, post) {
    $.post(url, post,
            function (prfl) {
                for (var attr in prflArray = $.parseJSON(prfl))
                    $('#' + attr).val(prflArray[attr]).change();
            }
    );
}