function customMenu(event, menuBorders) {
    obj = $($(event.target).attr('cstm-mn'));

    y = (obj.height() * 1 + 100 * 1 + event.pageY * 1) > ($(window).height() * 1) ? ($(window).height() * 1 - obj.height() * 1 - 100 * 1) : (event.pageY);
    x = (obj.width() * 1 + event.pageX * 1) > ($(window).width() * 1) ? ($(window).width() * 1 - obj.width() * 1) : (event.pageX);

    obj.finish().toggle(100).
            /* in the right position (the mouse) */
            css(
                    {
                        top: y + 'px',
                        left: x + 'px'
                    }
            );
    
    menuBorders ? manageCustomMenuBorders() : '';
}

$(document).ready(
        function () {

            $(this).bind('contextmenu',
                    function () {
                        return false;
                    }
            );

            $(this).bind('click',
                    function (event) {

                        if ($(event.target).hasClass('has-cstm-mn')) {
                            /* avoid the real one */
                            event.preventDefault();

                            /* right click only allowed during select mode */
                            if (event.which === 3 || (($(event.target).hasClass('inst-ctnt-pn-fl-pn') || $(event.target).hasClass('inst-ctnt-pn-dr-pn') || $(event.target).parent().hasClass('nvgtn-fldr-ctnr')) && $('.custom-sub-menu-title') && $('.custom-sub-menu-title').attr('md') && $('.custom-sub-menu-title').attr('md') === 'slctn')) {
                                clickAndContextEventDuringSelect(event);
                                return false;
                            }

                            customMenu(event, $('.nvgtn-fldr-ctnr').length);
                        } else
                        if ($(event.target).has('input'))
                            return true;

                        return false;
                    }
            );


            $(this).click(
                    function (event) {
                        if ($(event.target).hasClass('custom-sub-menu') && !$(event.target).hasClass('custom-menu-wait') && !$(event.target).hasClass('custom-sub-menu-title'))
                            /* hide it AFTER the action was triggered */
                            $('.custom-menu').hide(100);
                    }
            );


            $(this).bind('mousedown',
                    function (e) {
                        /* if the clicked element is not the menu */
                        if (!$(e.target).parents('.custom-menu').length > 0)
                            /* hide it */
                            $('.custom-menu').hide(100);
                    }
            );

            $('.custom-menu-auto-hide').bind('mouseleave',
                    function () {
                        $(this).hide(100);
                    }
            );

        }
);

