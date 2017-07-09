function mailTrigger(trgr) {
    $(location).attr('href',
            'mailto:' + encodeURIComponent((trgr.attr('to') ?  trgr.attr('to') : '') + ' ')
            + '?cc=' + encodeURIComponent((trgr.attr('cc') ?  trgr.attr('cc') : '') + ' ')
            + '&bcc=' + encodeURIComponent((trgr.attr('bcc') ?  trgr.attr('bcc') : '') + ' ')
            + '&subject=' + encodeURIComponent((trgr.attr('subject') ?  trgr.attr('subject') : '') + ' ')
            + '&body=' + encodeURIComponent((trgr.attr('body') ?  trgr.attr('body') : ''))
            );
}

function callTrigger(tel) {
    $(location).attr('href', 'tel:' + encodeURIComponent(tel));
}