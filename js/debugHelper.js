/**
 * Created by EngrNaveed on 28-Dec-14.
 */

    var print = function(message) {
            var $output = $('<div class="nvd-print-result"><div>');
            $output.append("<p>"+message+"</p>");
            $output.css({
                position: 'fixed',
                bottom: '1em',
                left: '1em',
                padding: '1em',
                border: '1px solid #333',
                backgroundColor: 'rgba(50,50,50,0.5)',
                borderRadius: '0.5em'
            });
            $output.appendTo("body");
    };

    function log(message){
        console.log(message);
    }

function appendTobody(markup) {
    $("body").append("<pre>"+markup+"</pre>");
}

(function($) {
    $.fn.highlight = function() {
        this.css("border","2px solid red");
        this.css("background-color","#fdd");
    };





})(jQuery);