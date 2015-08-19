/**
 * Created by EngrNaveed on 04-Jan-15.
 */
$(function () {
    var $editable = $(".editable");

    // adjust the sizes of editables
    $editable.each(function (index, entry) {
        var element = $(entry),
            $parent = element.parent(),
            innerHeight = $parent.innerHeight() - $parent.getCss('padding-bottom') - $parent.getCss('padding-top'),
            innerWidth = $parent.width() - $parent.getCss('padding-left') - $parent.getCss('padding-right');
        //$parent.highlight();
        //log("innerH: "+innerHeight);
        //log("innerW: "+innerWidth);
        //element.height(innerHeight+'px');
        //element.width(innerWidth+'px');
    });

    // bind click event
    $editable.click(editableClickHandler);

    function getValue(jqObj){
        return jqObj.data('value');
    }

    function setInputValue(inputElement,value){
        var type = inputElement.data('type');
        switch(type) {
            case 'textarea':
                inputElement.text(value);
                break;
            case 'select':
                inputElement.find("option").each(function (index,element) {
                    if($(element).text()==value){
                        $(element).attr('selected','true');
                    }
                });
                break;
            default:
                inputElement.val(value);
                break;
        }
    }

    function editableClickHandler(){
        // find the matching input
        // put the matching input inside $this
        // set the value of the matching input
        // in case of enter-key pressed:
        // set the new value
        // store the new value to the db
        // in case of some other key:
        // restore previous value
        // remove the new input

        var $thisEditable = $(this),
            inputContainerId = $thisEditable.attr('id')+"-input",
            $inputContainer = $("#"+inputContainerId).clone(),
            $newInput = $inputContainer.find('.form-control'),
            value = getValue($thisEditable);
        // adjust position
        $inputContainer.css('position','absolute');
        $inputContainer.css('z-index','1');
        $thisEditable.css('position','relative');
        // change id, so that no two elements have same id
        $newInput.attr('id',inputContainerId+'-edit');
        // replacement
        $thisEditable.replaceWith($inputContainer);
        setInputValue($newInput,value);
        // adjust width
        $inputContainer.width($newInput.parent().width());
        $newInput.focus();
        // bind fkey hints
        $(".fkeyInput").keyup(showfKeyHints);
        // the following line of code is a fix for a problem:
        // the <select> inputs don't save on Enter, instead they popup their option tags
        $newInput.keypress(function (e) {
            if (e.keyCode == 13) {return false;}
        });
        // bind event
        $newInput.bind('keyup',function (e){
            if (e.keyCode == 13) { // Enter key
                var newValue = $newInput.val();
                // show waiting
                var $waiting = $(btsp.waiting());
                $inputContainer.replaceWith($waiting);
                // post data to db
                var data = {
                    recordInfo:$thisEditable.data('cell-id'),
                    valueToSave : newValue
                };
                $.post('html_components/records_post_handler.php', data, function (response){
                    if($(response).hasClass('alert-success')){
                        $thisEditable.text(newValue);
                    }
                    $waiting.replaceWith($thisEditable);
                    $("body").append(response);
                    //log(response);
                });
            }else if(e.keyCode == 27){ // Escape key
                $inputContainer.replaceWith($thisEditable);
            }
        });
        // on loosing focus
        $inputContainer.bind('blur',function(){
            $inputContainer.replaceWith($thisEditable);
        });
        // bind again
        // Reason: the handler was bound earlier,
        // we removed the element later and then recreated it
        // There is no binding after recreation
        $editable.click(editableClickHandler);
    }
});