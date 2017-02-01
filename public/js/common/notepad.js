/**
 * Created by jason on 2/1/17.
 */
$(function() {
    $('#notepad_sketch').sketch();
});

//notepad opener
$('#opener').on('click', function() {
    var panel = $('#slide-panel');
    if (panel.hasClass("visible")) {
        panel.removeClass('visible').animate({'margin-right':'-830px'});
    } else {
        panel.addClass('visible').animate({'margin-right':'0px'});
    }
    return false;
});

//clear
