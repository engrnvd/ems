/**
 * Created by EngrNaveed on 12/27/2014.
 */

function showfKeyHints(){
    log("trying to show fkey hints");
    // the fkey input element
    var thisElement = $(this);

    // build form data to send
    var formData = {
        classname: thisElement.data('classname'),
        fieldname: thisElement.data('fieldname'),
        currentValue: thisElement.val()
    };

    // post data
    $.post("ajaxHandlers/foreignKeyHandler.php", formData, function (response) {
        // remove existing hints and append received hints:
        var parentDiv = thisElement.parent();
        parentDiv.find(".fkeyHints").remove();
        parentDiv.css('position','relative').append(response);

        // click functionality of the hint:
        var fkeyHints = thisElement.siblings(".fkeyHints");
        fkeyHints.find(".list-group-item").click(function () {
            var hint = $(this);

            //check if the input is an inputForEditable
            if(thisElement.parent().hasClass('inputForEditable')){
                thisElement.val(hint.data("value"));
                thisElement.attr('autofocus','true');
                fkeyHints.hide();
                return false;
            }

            // insert a hidden input for the frgn. key
            var hiddenIpId = thisElement.attr("id")+"Ip";
            thisElement.after("<input id='"+hiddenIpId+"' type='hidden' name='"+thisElement.attr("name")+"' value='"+hint.data("value")+"'/>");

            // remove the hints
            fkeyHints.hide();

            // replace the input with a link to the external record and a reset button
            var href = hint.attr('href'),
                exLink = "<a href='"+href+"' target='_blank'>"+hint.data("value")+" ("+hint.find(".list-group-item-heading").html()+")</a>",
                resetBtn = "<a href='#' class='danger_link pull-right resetBtn'>"+btsp.icon("remove")+"</a>",
                exlinkWraper = $("<p class='exlink form-control'>"+exLink+" "+resetBtn+"</p>");
            thisElement.after(exlinkWraper);
            thisElement.hide();

            // reset button functionality
            exlinkWraper.find(".resetBtn").click(function () {
                exlinkWraper.remove();
                thisElement.show();
                fkeyHints.show();
                $("#"+hiddenIpId).remove();
                thisElement.keyup(showfKeyHints);
                return false;
            });

            // prevent default and event bubbling
            return false;
        });
    });
}
$(function(){
    // foreign key add record link
    //$(".newFkeyModalLauncher").click(showNewRecModal);
    //var modalCounter = 1;
    $(".fkeyInput").keyup(showfKeyHints);


});
