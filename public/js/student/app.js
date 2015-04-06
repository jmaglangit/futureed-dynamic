//common

$('a').smoothScroll();  

$("#user_principal").click(function() {
	$("#principal, #form_schoolname, #form_address, #form_address2, #form_postcode").show( "slow");
	$("#parent").hide("slow");
	$("#user_teacher, #user_parent").fadeTo("slow", 0.3);
	$(this).fadeTo("slow", 1);
});
$("#user_teacher").click(function() {
	$("#form_address, #form_address2, #form_postcode" ).hide( "slow");
	$("#parent").hide("slow");
	$("#principal, form_schoolname").show("slow");
	$("#user_principal, #user_parent").fadeTo("slow", 0.3);
	$(this).fadeTo("slow", 1);
});
$("#user_parent").click(function() {
	$("#principal").hide("slow");
	$("#parent").show("slow");
	$("#user_principal, #user_teacher").fadeTo("slow", 0.3);
	$(this).fadeTo("slow", 1);
});