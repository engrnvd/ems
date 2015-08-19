/**
 * Created by EngrNaveed on 08-Jan-15.
 */
$(function () {
    $(".linkedClassCheckbox").click(lccHandler);

    function lccHandler() {
        var thisCheckbox = $(this),
            parentForm = thisCheckbox.parents(".linkedClassForm");
        // post data to db
        var data = parentForm.serialize();
        // show waiting
        var $waiting = $(btsp.waiting());
        thisCheckbox.replaceWith($waiting);
        $.post('html_components/linkedClassCheckbox.php', data, function (response) {
            $("body").append(response);
            $waiting.replaceWith(thisCheckbox);
        });
        thisCheckbox.click(lccHandler);
    }

















});