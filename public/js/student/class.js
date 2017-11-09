$(document).ready(function() {
    $(window).scroll(function() {
        var catcher = $('header');
        var sticky = $('#sticky-side-bar');

        var offset = sticky.offset();
        
        if($(window).scrollTop() > catcher.height()) {
            sticky.css('position','fixed');
            sticky.css('top','0px');
        } else {
            sticky.css('position','absolute');
            sticky.css('top', catcher.height() + "px");
        }
    });
});