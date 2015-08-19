/**
 * Created by Engr. Naveed on 14-Mar-15.
 *
 * Working:
 * - any element with class "selectAll" will act as a select_all / select_none button
 * - the target checkboxes must have a class name as defined in the 'data-target-class' attribute of the select_all / select_none button
 */
($(function () {
    var selectAllButtons = $(".selectAll");
    selectAllButtons.css("cursor","pointer");
    selectAllButtons.click(function () {
        var targetClass = $(this).data("target-class"),
            targetElements = $("."+targetClass);
        if(targetElements.prop("checked")){
            //log("condition true, attr exists: "+targetElements.prop("checked"));
            targetElements.prop('checked', false);
            //log("condition true, attr changed to: "+targetElements.prop("checked"));
        }else{
            //log("condition false: "+targetElements.attr("checked"));
            targetElements.prop('checked', true);
            //log("condition false, Trying to change attr: "+targetElements.attr("checked"));
        }
    });
}));