/**
 * Created by EngrNaveed on 13-01-15.
 */
$(function (){

    var classInput = $("#class_id,#class");
    // set value as the page loads
    performFunctions();
    // set value as class id is changed
    classInput.change(function () {
        performFunctions();
    });

    function setValues(){
        var classInputVal = classInput.val();
        var inputName = classInput.attr('id');
        var data = (inputName == "class_id") ? { classId : classInputVal } : { class:classInputVal };
        $.post("ajaxHandlers/classIdChangeHandler.php",data, function (res){
            var data = JSON.parse(res);
            for( var key in data ){
                $("#"+key).val(data[key]);
            }
            // subject combinations
            if(data.subjCombs && data.subjCombs.toString() != ""){
                var markup = "<select id='subj_combination' name='subj_combination' class='form-control'>";
                for( var subcomb in data.subjCombs){
                    subcomb = data.subjCombs[subcomb];
                    markup = markup + "<option value='"+subcomb['id']['val']+"'>"+subcomb['title']['val']+"</option>";
                    //log(subcomb);
                }
                markup = markup + "</select>";
            }else{
                markup = "<input id='subj_combination' name='subj_combination' class='form-control'>";
            }
            $("#subj_combination").replaceWith(markup);
        });
    }

    function performFunctions(){ setValues(); }

});