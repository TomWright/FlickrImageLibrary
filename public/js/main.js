var $headerElement = null;
var $window = null;

$(document).ready(function() {
    $window = $(window);
    $headerElement = $('heading.main');
    $window.scroll($.throttle(250, checkStickyHeaderHandler));
});

function checkStickyHeaderHandler()
{
    var scrollTop = $window.scrollTop();
    var headerTop = $headerElement.offset().top;
    if (scrollTop > headerTop && !$headerElement.hasClass('sticky')) {
        $headerElement.addClass('sticky');
    } else if (scrollTop == 0) {
        $headerElement.removeClass('sticky');
    }
}