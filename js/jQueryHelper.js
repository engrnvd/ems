/**
 * Created by EngrNaveed on 05-Jan-15.
 */
(function($) {
    $.fn.getCss = function(cssProp) {
        var value = this.css(cssProp);
        value = value.replace(/px/,'');
        return value;
    };




})(jQuery);