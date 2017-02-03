$(document).ready(function () {

}
);

setTimeout(function () {
    var colHeight = jQuery('.col-sm-2.sidenav').outerHeight();
    var colHeight1 = jQuery('.col-sm-10.text-left').outerHeight();

    if (colHeight > colHeight1) {
        jQuery('.col-sm-10.text-left').css('min-height', colHeight);
    } else {
        jQuery('.col-sm-2.sidenav').css('min-height', colHeight1);
    }

}, 1000);