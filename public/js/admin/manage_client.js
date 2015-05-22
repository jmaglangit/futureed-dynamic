$(document).on('click', '#client_nav_head' , function() {
	var data_target = $(this).data("target");

	$('#' + data_target).toggle('collapse');
});