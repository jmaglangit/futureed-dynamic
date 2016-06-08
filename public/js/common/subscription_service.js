/**
 * Created by jason on 5/2/16.
 */
$(document).ready(function () {
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();

    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);

        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    //Wizard Subject
    $(".wizard-box").click(function (e) {
        navigateTab();
    });

    //Wizard Panel
    $(".wizard-panel").click(function (e) {
        navigateTab();
    });

    $(".next-step").click(function (e) {
        navigateTab();
    });

    $(".prev-step").click(function (e) {
        navigatePrevTab();
    });


});

function navigateTab(){
    var $active = $('.wizard .nav-tabs li.active');
    $active.next().removeClass('disabled');
    nextTab($active);
}

function navigatePrevTab(){
    var $active = $('.wizard .nav-tabs li.active');
    prevTab($active);
}

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

function lastTab() {
    var $active = $('.wizard .nav-tabs li.active');
    var $last = $('.wizard .nav-tabs li:last');
    $active.removeClass('active');
    $active.addClass('disabled');
    $last.removeClass('disabled');
    $last.find('a[data-toggle="tab"]').click();
}
