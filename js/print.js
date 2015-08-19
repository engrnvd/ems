/**
 * Created by Engr. Naveed on 09-Feb-15.
 */
$(function () {
    if (window.matchMedia) {
        var mediaQueryList = window.matchMedia('print');
        mediaQueryList.addListener(function(mql) {
            if (mql.matches) { beforePrint(); }
            else { afterPrint(); }
        });
    }

    function beforePrint(){

    }


    function afterPrint(){

    }






});

