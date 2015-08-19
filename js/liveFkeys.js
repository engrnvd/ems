/**
 * Created by EngrNaveed on 10-01-15.
 */
$(function () {

    var fKeyParentElements = $(".liveFKeyParent");
    fKeyParentElements.change(liveFKeyHandler);
    fKeyParentElements.each(liveFKeyHandler);

    function liveFKeyHandler(){
        var thisElement = $(this),
            targetInputsList = thisElement.data('dependantfields').split(','),
            waiting = $(btsp.waiting());
        for(var i= 0,len=targetInputsList.length; i<len; i++){
            var thisTarget = $("#"+targetInputsList[i]),
                data = {
                    parentField : thisElement.attr('id'),
                    targetField : targetInputsList[i],
                    parentFieldValue: thisElement.val(),
                    classname : thisTarget.data('classname')
                };
            thisTarget.replaceWith(waiting);
            thisTarget.load("ajaxHandlers/liveFKeyHandler.php",data);
            waiting.replaceWith(thisTarget);
        }
        //log(thisElement.parents("form").serialize());
    }



});