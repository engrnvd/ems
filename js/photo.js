/**
 * Created by EngrNaveed on 31-Dec-14.
 */

$(function(){
// update student picture
    var $photo = $("#photoInput");
    $photo.change(updateStudentPhoto);

// photo selector
    $photo.css("display" , "none");
    $(".photoThumb").click( function(evt) {
        $photo.get(0).click();
        evt.preventDefault();
    } );

    function updateStudentPhoto(){
        // We are going to:
        // 1. display the thumbnail before uploading
        // 2. upload the image before submitting the form

        // start of step 1:-------------------------------------------
        var $photo = $("#photoInput");
        var file = $photo.get(0).files[0];
        var imageType = /image.*/;

        if (!file.type.match(imageType)) { $("#response").html("Not a valid image file."); return }

        var img = document.createElement("img");
        img.classList.add("obj");
        img.file = file;
        $(".photoThumb img").remove();
        $(".photoThumb").get(0).appendChild(img);

        var reader = new FileReader();
        reader.onload = (function(aImg) {
            return function(e) { aImg.src = e.target.result; };
        })(img);
        reader.readAsDataURL(file);

        // start of step 2---------------------------------------------
        // if FormData is not supported, no need to try to upload
        if (window.FormData) {
            var input = $photo.get(0);
            var formdata = new FormData();

            $("#response").html("Uploading . . .");

            formdata.append("photoInput", file);
            formdata.append( "person_id" , $("#person_id").val() );
            $.ajax({
                url: "ajaxHandlers/photoUploader.php",
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (res) {
                    $("#response").html(res);
                    $("#photo .error").remove();
                }
            });
        }
    }
    //function downloadStPhoto(stId){
    //    var formdata = new FormData();
    //    formdata.append("stId" , stId );
    //    $.ajax({
    //        url: "../ajaxHandlers/downloadStPhoto.php",
    //        type: "POST",
    //        data: formdata,
    //        dataType : "html",
    //        processData: false,
    //        contentType: false,
    //        success: function (data) {
    //            $(".photoThumb").html(data);
    //        }
    //    });
    //}

});
