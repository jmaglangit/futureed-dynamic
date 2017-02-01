/**
 * Created by jason on 2/1/17.
 */
$(function() {
    $.each(['#f00', '#ff0', '#0f0', '#0ff', '#00f', '#f0f', '#000', '#fff'], function() {
        $('#colors_sketch .tools').append("<a href='#simple_sketch' data-color='" + this + "' style='width: 10px; background: " + this + ";'></a> ");
    });
    $.each([3, 5, 10, 15], function() {
        $('#colors_sketch .tools').append("<a href='#simple_sketch' data-size='" + this + "' style='background: #ccc'>" + this + "</a> ");
    });
    $('#simple_sketch').sketch();
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
function redraw(){
    $('')
}