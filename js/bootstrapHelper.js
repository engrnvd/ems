/**
 * Created by EngrNaveed on 29-Dec-14.
 */
var btsp = {
    icon : function(icon){
        return "<span class='glyphicon glyphicon-"+icon+" '></span>";
    },

    showModal : function( options ){
        var markup = "<div id='"+options.id+"' class='modal fade'>";
        markup += "<div class='modal-dialog'>";
        markup += "<div class='modal-content'>";
        markup += "<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>";
        if(options.content){
            markup += options.content;
        }else{
            markup += "<div class='modal-header'>";

            markup += "<h4 class='modal-title'>"+options.title+"</h4>";
            markup += "</div>";
            markup += "<div class='modal-body'>";
            markup += options.body;
            markup += "</div>";
            markup += "<div class='modal-footer'>";
            markup += "<button type='button' class='btn btn-default' data-dismiss='modal'>No</button>";
            markup += "<button id='confirmNewRecord' type='button' class='btn btn-primary'>Yes</button>";
            markup += "</div>";
            markup += "</div>";
        }

        markup += "</div>";
        markup += "</div>";
        $("body").append(markup);
        options.show = true;
        $("#"+options.id).modal(options);
        //return markup;
    },

    waiting: function(){
        return "<div class='progress progress-striped active'><div class='progress-bar'  role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width: 100%'></div></div>";
    }
};