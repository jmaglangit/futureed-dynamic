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

$('.help-sketch').on('click', function(){
    var alert = $('#notepad-info');

    if(alert.hasClass("visible")){
        alert.removeClass("visible").animate({'margin-right':'-830px'});
        $('#notepad_sketch').animate({'width':'820px'});

    } else {
        alert.addClass('visible').animate({
            'margin-right':'0px','height': '442px','margin-left': '0px','margin-top': '0px','width': '330px'});
        $('#notepad_sketch').animate({'width':'475px','height':'450px'});
    }
    return false;
});

//clear
