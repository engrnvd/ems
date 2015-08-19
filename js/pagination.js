/**
 * Created by EngrNaveed on 31-Dec-14.
 */

$(function(){

    var form = $("#paginationForm"),
        input = $("#res_per_page"),
        disableActiveLinks = $(".pagination .active,.pagination .disabled");

    // auto submit the form when the input is changed
    input.change(function () { form.submit(); });

    // do nothing if a disables or an active link is clicked
    disableActiveLinks.click(function () { return false; });



});
