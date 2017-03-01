$(document).ready(function () {

    /* Фиксирует меню*/
    var StickyElement = function (node) {
        var doc = $(document),
                fixed = false,
                anchor = node.find('.sticky-anchor'),
                content = node.find('.sticky-content');

        var onScroll = function (e) {
            var docTop = doc.scrollTop(),
                    anchorTop = anchor.offset().top;

            console.log('scroll', docTop, anchorTop);
            if (docTop > anchorTop) {
                if (!fixed) {
                    anchor.height(content.outerHeight());
                    content.addClass('fixed');
                    fixed = true;
                }
            } else {
                if (fixed) {
                    anchor.height(0);
                    content.removeClass('fixed');
                    fixed = false;
                }
            }
        };

        $(window).on('scroll', onScroll);
    };

    var demo = new StickyElement($('#sticky'));

    /* END Фиксирует меню*/


    /* Открываение подпунктов фильтра*/
    initMenuFilter();
});

function initMenuFilter() {
    $('.filter_options').hide();

    $('.filtr_ul_button').click(
            function () {
                $(this).next().slideToggle('normal');
            }
    );
}

