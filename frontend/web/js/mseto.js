function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function numberOnly(event) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(event.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1
            // Allow: Ctrl+A, Command+A
            || (event.keyCode === 65 && (event.ctrlKey === true || event.metaKey === true))
            // Allow: home, end, left, right, down, up
            || (event.keyCode >= 35 && event.keyCode <= 40)) {
        // let it happen, don't do anything
        return;
    }
    // Ensure that it is a number and stop the keypress
    if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event.keyCode < 96 || event.keyCode > 105))
        event.preventDefault();
}

function maxLengthContentEditable(event) {
    target = $(event.target);
    
    splt = $.trim(target.text()).split(' ');

    if ($.inArray(event.keyCode, [13, 222]) && (target.text().length < target.attr('max') * 1 || $.inArray(event.keyCode, [46, 40, 39, 38, 37, 36, 35, 8]) > -1
            || (event.keyCode === 65 && (event.ctrlKey === true || event.metaKey === true))))
        if (target.text().length < 15 || target.text().slice(-1) === ' ' || splt[splt.length - 1].length < 15 || (splt[splt.length - 1].length === 15 && event.keyCode === 32) || ($.inArray(event.keyCode, [46, 40, 39, 38, 37, 36, 35, 8]) > -1 || (event.keyCode === 65 && (event.ctrlKey === true || event.metaKey === true))))
            return;

    event.preventDefault();
}

function notExceedMaxLengthContentEditable(event) {
    target = $(event.target);
    
    if (target.text().length > target.attr('max') * 1)
        target.text(target.text().substr(0, target.attr('max') * 1));
}