/**
 * Code from client
 * 20170801
 */

var m1 = "";
var z2 = "";
var z1 = "";
var m2 = "";
var randomDigits = "";
var max_t = 0;
var min_t = 0;
var flag = 0;

var factorX = 1;

var arry_correctval = [];
var arry_total = [];

var An = 0;
var Ad = 0;
var fraction_count = 0;
var simplify_count = 0;

var step1_error = "";
var step2_error = "";
var step3_error = "";
var step4_error = "";
var step5_whole_numerator_error = "";
var step5_whole_denominator_error = "";
var step5_whole = "";
var step5_numerator_error = "";
var step5_denominator_error = "";

var possibleFlag = false;
var simplifyFlag=false;
var wholeBtnFlag = false;
var specialFlag = false;
var startdisplay = false;
var answered = []; //ADDED

// start ADDED functions
//getter and setter
function setRandomDigits(digit){
	randomDigits = digit;
}

function getRandomNumber1(){
	return z1;
}

function getRandomNumber2(){
	return z2;
}

function getRandomNumber3(){
	return m1;
}

function getRandomNumber4(){
	return m2;
}

function getAnswered(){
	return answered;
}

function setAnswered(answer){
	answered.push(answer);
}

function enabledNextQuestion(){
	$("#dynamic_question_btn").show();
}

function disabledNextQuestion(){
	$("#dynamic_question_btn").hide();
}

function answerDone(){
	$("#questionPane").hide();
	$("#step_div").hide();
	$("#examPane1").hide();
	$("#tipsFlow").show();
	$("#ansFlow").show();
	$("#ansCorrectFlow").show();
	enabledNextQuestion();
}

function answerReset(){
	$("#questionPane").show();
	$("#step_div").show();
	$("#tipsFlow").hide();
	$("#ansFlow").hide();
	$("#ansCorrectFlow").hide();
	answered = [];
	disabledNextQuestion();
}

function alertModal(message){
	$("#message_text_modal").html(message);
	$("#message_modal_dynamic").show();
	$("#yes_simplify_modal").hide();
	$("#no_simplify_modal").hide();
	$("#close_modal").show();
	$("#yes_whole_modal").hide();
	$("#no_whole_modal").hide();
	$("#yes_modal").hide();
	$("#ok_simplify_modal").hide();
	$("#ok_whole_num_modal").hide();
}

function retrySimplifyModal(message){
	$("#message_text_modal").html(message);
	$("#message_modal_dynamic").show();
	$("#ok_simplify_modal").show();
	$("#ok_whole_num_modal").hide();
	$("#yes_simplify_modal").hide();
	$("#no_simplify_modal").hide();
	$("#close_modal").hide();
	$("#yes_whole_modal").hide();
	$("#no_whole_modal").hide();
	$("#yes_modal").hide();
}

function retryWholeNumModal(message){
	$("#message_text_modal").html(message);
	$("#message_modal_dynamic").show();
	$("#ok_simplify_modal").hide();
	$("#ok_whole_num_modal").show();
	$("#yes_simplify_modal").hide();
	$("#no_simplify_modal").hide();
	$("#close_modal").hide();
	$("#yes_whole_modal").hide();
	$("#no_whole_modal").hide();
	$("#yes_modal").hide();
}

function simplifyModal(message){
	$("#message_text_modal").html(message);
	$("#message_modal_dynamic").show();
	$("#ok_simplify_modal").hide();
	$("#ok_whole_num_modal").hide();
	$("#yes_simplify_modal").show();
	$("#no_simplify_modal").show();
	$("#close_modal").hide();
	$("#yes_whole_modal").hide();
	$("#no_whole_modal").hide();
	$("#yes_modal").hide();
}

function wholeNumberModal(message){
	$("#message_text_modal").html(message);
	$("#message_modal_dynamic").show();
	$("#yes_simplify_modal").hide();
	$("#no_simplify_modal").hide();
	$("#close_modal").hide();
	$("#yes_whole_modal").show();
	$("#no_whole_modal").show();
	$("#yes_modal").hide();
	$("#ok_simplify_modal").hide();
	$("#ok_whole_num_modal").hide();
}

function cannotSimplifyModal(message){
	$("#message_text_modal").html(message);
	$("#message_modal_dynamic").show();
	$("#yes_simplify_modal").hide();
	$("#no_simplify_modal").hide();
	$("#close_modal").hide();
	$("#yes_whole_modal").hide();
	$("#no_whole_modal").hide();
	$("#yes_modal").show();
	$("#ok_simplify_modal").hide();
	$("#ok_whole_num_modal").hide();
}

function btnNOOnclose() {
	$("#message_modal_dynamic").hide();
}

function btnOkSimplifyRetry() {
	simplifyModal("Simplify fraction if possible ?");
}

function btnOkWholeNumRetry() {
	wholeNumberModal("Would you make a whole number ?");
}

// end ADDED functions


function digits(digits){
	a = 1;		
	for (var i = 0; i < digits; i++) {
		a *= 10;		
	}
	return a;
}

function randomDigitsOnclick(){
	carry_over1 = false;
	carry_over = false;
	// randomDigits = $("#randomDigits").prop("value");
	randomDigits = parseInt(randomDigits);
	if(isNaN(randomDigits)) randomDigits = 1;
	if(randomDigits > 7) randomDigits = 7;
	$("#randomDigits").prop("value", randomDigits);
	max_t = digits(randomDigits);
	
	m1 = Math.floor(Math.random() * max_t);
	m2 = Math.floor(Math.random() * max_t);
	z1 = Math.floor(Math.random() * max_t);
	z2 = Math.floor(Math.random() * max_t);

	m1 = m1>1 ? m1 : m1 + 2;
	m2 = m2>1 ? m2 : m2 + 2;
	z1 = z1 ? z1 : z1 + 1;
	z2 = z2 ? z2 : z2 + 1;
	if ( m1 == m2 ) {
		m1 ++;
	}
	
	$("#m1").prop("value", m1);
	$("#m2").prop("value", m2);
	$("#z1").prop("value", z1);
	$("#z2").prop("value", z2);

	$("#subject_z1_b").html(z1);
	$("#subject_z2_b").html(z2);
	$("#subject_m1_b").html(m1);
	$("#subject_m2_b").html(m2);

	$("#subject_z1_b1").html(z1);
	$("#subject_z2_b1").html(z2);
	$("#subject_m1_b1").html(m1);
	$("#subject_m2_b1").html(m2);

	$("#examPane").show();
	// displayFraction(true, false, "#examPane");

	// displayFraction(false, false, "#examPane");
	step_count = 0;
}

function btncalculateOnclick(){
	step_count++;
	retry_attempt = 0;
	$("#step_div").show();
	var result_str = "";
	if (step_count == 1) {
		result_str = "<div>";
		result_str += "<p style='margin-top:20px;'>Step " + step_count +": Cross multiple #1 </p>";
		result_str += '<div>';
			result_str += '<table style="margin-left:45px">';
				result_str += '<tr>';
					
					result_str += '<td align="center"><label style = "color:blue">'+ z1 +'</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle"><b> + </b></td>';
					result_str += '<td align="center"><label>'+ z2 +'</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				result_str += '</tr>';
				result_str += '<tr>';
					result_str += '<td bgcolor="#000000" height="2"></td>';
					result_str += '<td bgcolor="#000000" height="2"></td>';
				result_str += '</tr>';
				result_str += '<tr>';
					result_str += '<td align="center"><label>'+ m1 +'</label></td>';
					result_str += '<td align="center"><label style = "color:blue">'+ m2 +'</td>';

				result_str += '</tr>';				
			result_str += '</table>';

		result_str += '</div>';
		result_str += '<div>';
			result_str += '<table>';
				result_str += '<tr>';
					
					result_str += '<td align="center"><label style = "color:blue">'+ z1 +'</label></td>';
					result_str += '<td align="center" valign="middle"><label> '+ "&nbsp;" +'X'+ "&nbsp;" +'</label></td>'; //modify
					result_str += '<td align="center"><label style = "color:blue">'+ m2 +'</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><input class="inputCheck"></td>';
				result_str += '</tr>';				
			result_str += '</table>';
		result_str += '</div>';
		result_str += "</div>";
		$("#crossone").html(result_str);
	}

	$(".inputCheck").keydown(function(event){
		if(event.keyCode == 13){
			if(checkAnswer($(this)) == false && carry_over1 == false){
				// alert("Answer can't be alphabet !");
				alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			
			temp_answer = checkAnswerValidation($(this));
			if(temp_answer == -1){
				// alert("Your answer is larger than what we need.");
				alertModal("Your answer is larger than what we need.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(temp_answer == -2){
				// alert("opps not enough, your answer needs to be larger.");
				alertModal("Oops not enough, your answer needs to be larger.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(temp_answer == -3){
				$(this).prop("value", "").focus();
				return false;
			}
			if(temp_answer == correct_answer) {
				nextsetp();
			}
			
		}
	}).focus();
}

function nextsetp(){
	
	retry_attempt = 0;
	step_count++;
	

	if (simplifyFlag == true) {
		step_count--;
		
	}
	result_str = "";
	if (step_count == 2) {
		result_str = "<div>";
		result_str += "<p style='margin-top:20px;'>Step " + step_count +": Cross Multiple #2</p>";
		result_str += '<div>';
			result_str += '<table style="margin-left:45px;">';
				result_str += '<tr>';
					
					result_str += '<td align="center"><label>'+ z1 +'</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle"><b> + </b></td>';
					result_str += '<td align="center"><label style = "color:blue">'+ z2 +'</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				result_str += '</tr>';
				result_str += '<tr>';
					result_str += '<td bgcolor="#000000" height="2"></td>';
					result_str += '<td bgcolor="#000000" height="2"></td>';
				result_str += '</tr>';
				result_str += '<tr>';
					result_str += '<td align="center"><label style = "color:blue">'+ m1 +'</label></td>';
					result_str += '<td align="center"><label>'+ m2 +'</td>';

				result_str += '</tr>';				
			result_str += '</table>';

		result_str += '</div>';
		result_str += '<div>';
			result_str += '<table>';
				result_str += '<tr>';
					
					result_str += '<td align="center"><label style = "color:blue">'+ z2 +'</label></td>';
					result_str += '<td align="center" valign="middle"><label> '+ "&nbsp;" +'X'+ "&nbsp;" +'</label></td>'; //modify
					result_str += '<td align="center"><label style = "color:blue">'+ m1 +'</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><input class="inputCheck"></td>';
				result_str += '</tr>';				
			result_str += '</table>';
		result_str += '</div>';
		result_str += "</div>";
		$("#crosstwo").html(result_str);
	}

	if (step_count == 3) {
		result_str = "<div>";
		result_str += "<p style='margin-top:20px;'>Step " + step_count +": Add #1 and #2 </p>";
		result_str += '<div>';
			result_str += '<table>';
				result_str += '<tr>';
					
					result_str += '<td align="center"><label style="color:blue;">'+ arry_correctval[10] +'</label></td>';
					result_str += '<td align="center" valign="middle"><label> '+ "&nbsp;" +'+'+ "&nbsp;" +'</label></td>'; //modify
					result_str += '<td align="center"><label style="color:blue;">'+ arry_correctval[9] +'</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><input class="inputCheck"></td>';
				result_str += '</tr>';			
			result_str += '</table>';

		result_str += '</div>';
		result_str += "</div>";
		$("#addoneandtwo").html(result_str);
	}

	if (step_count == 4) {
		result_str = "<div>";
		result_str += "<p style='margin-top:20px;'>Step " + step_count +": Multiply denominators </p>";
		result_str += '<div>';
			result_str += '<table>';
				result_str += '<tr>';
					
					result_str += '<td align="center"><label style="color:blue;">'+ m1 +'</label></td>';
					result_str += '<td align="center" valign="middle"><label> '+ "&nbsp;" +' X '+ "&nbsp;" +'</label></td>'; //modify
					result_str += '<td align="center"><label style="color:blue;">'+ m2 +'</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><input class="inputCheck"></td>';
				result_str += '</tr>';			
			result_str += '</table>';

		result_str += '</div>';
		result_str += "</div>";
		$("#multiply_denominator").html(result_str);
	}

	if (step_count == 5) {
		
		
		flag = possibleFlagfunc();
		if (flag == 1 && wholeBtnFlag == false) {
			
			// $("#myModal").show();
			simplifyModal("Simplify fraction if possible ?"); //added
		}
		if (arry_correctval[6] > arry_correctval[7]) {
			// $("#myModal1").show();
			wholeNumberModal("Would you make a whole number ?"); //added
		}

		if ( arry_correctval[1] > arry_correctval[2] && flag == 0 ) {
			// $("#myModal1").show();
			wholeNumberModal("Would you make a whole number ?"); //added
		}

		if (flag == 1 && simplifyFlag == false) {
			// console.log("simplifyFlag == false");
			arry_correctval[3] = Math.floor(arry_correctval[1] / arry_correctval[2]);
			result_str = "<div>";
			result_str += "<p style='margin-top:20px;'>Step " + step_count +": Simplify fraction if possible</p>";
			
			result_str += '<table id="step_count3">';

				result_str += '<tr>';
					
					result_str += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
					result_str += '<td align="center"><input class="inputCheck4" style="display:none;width:50px"></td>';
					result_str += '<td rowspan="3" align="center" valign="middle"><b class="hidden_tag" style="display:none"> = </b></td>';
					result_str += '<td rowspan="3" align="center" valign="middle"><input class="inputCheck1" style="display:none;width:50px"></td>';
					result_str += '<td align="center"><input class="inputCheck2" style="display:none;width:50px"></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
					
				result_str += '</tr>';
				result_str += '<tr>';
					result_str += '<td bgcolor="#000000" height="2"></td>';
					result_str += '<td bgcolor="#000000" height="2"></td>';
					result_str += '<td bgcolor="#000000" height="2" class="hidden_tag" style="display:none"></td>';
				result_str += '</tr>';
				result_str += '<tr>';
					result_str += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
					result_str += '<td align="center"><input class="inputCheck5" style="display:none;width:50px"></td>';
					result_str += '<td align="center"><input class="inputCheck3" style="display:none;width:50px"></td>';
					
				result_str += '</tr>';				
			result_str += '</table>';
			result_str += "</div>";

			$("#simplify").html(result_str);
		}else if (arry_correctval[1] < arry_correctval[2] && flag == 0 ) {
			specialFlag = true;
			result_str = "<div>";
			result_str += "<p style='margin-top:20px;'>Step " + step_count +": Simplify fraction if possible</p>";
			
			result_str += '<table id="step_count3">';

				result_str += '<tr>';
					
					result_str += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
					result_str += '<td align="center"><label>' + arry_correctval[1] + '</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
					
				result_str += '</tr>';
				result_str += '<tr>';
					result_str += '<td bgcolor="#000000" height="2"></td>';
					result_str += '<td bgcolor="#000000" height="2"></td>';
					
				result_str += '</tr>';
				result_str += '<tr>';
					result_str += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
					result_str += '<td align="center"><label>' + arry_correctval[2] + '</label></td>';
					
				result_str += '</tr>';				
			result_str += '</table>';
			result_str += "</div>";

			$("#simplify").html(result_str);
			nextsetp();
		}else if (wholeBtnFlag == false && flag == 0 && simplifyFlag == false) { 
			result_str = "<div>";
			result_str += "<p style='margin-top:20px;'>Step " + step_count +": Simplify fraction if possible</p>";
			
			result_str += '<table id="step_count3">';

				result_str += '<tr>';
					
					result_str += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
					result_str += '<td rowspan="3" align="center" valign="middle"><input class="inputCheck1" style="width:50px"></td>';
					result_str += '<td align="center"><input class="inputCheck2" style="width:50px"></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
					
				result_str += '</tr>';
				result_str += '<tr>';
					result_str += '<td bgcolor="#000000" height="2"></td>';
					result_str += '<td bgcolor="#000000" height="2"></td>';
					
				result_str += '</tr>';
				result_str += '<tr>';
					result_str += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
					result_str += '<td align="center"><input class="inputCheck3" style="width:50px"></td>';
					
				result_str += '</tr>';				
			result_str += '</table>';
			result_str += "</div>";

			$("#simplify").html(result_str);
			wholeOfValidationFunc();
		}
	}

	if (step_count == 6) {
		if (arry_correctval[1] < arry_correctval[2] && factorX != 1 || specialFlag == true) {
			// $("#myModal2").show();
			cannotSimplifyModal("Can not Simplify."); //added

		}else if (arry_correctval[1] > arry_correctval[2] && factorX == 1) {
			arry_correctval[3] = Math.floor(arry_correctval[1] / arry_correctval[2]);
			arry_correctval[4] = arry_correctval[1] % arry_correctval[2];
			arry_correctval[5] = arry_correctval[2];
			if (arry_correctval[4] == 0) {
				result_str = "<div>";
				result_str += "<p>Step " + step_count +": Answer</p>";
				
				result_str += '<table>';

					result_str += '<tr>';
						result_str += '<td rowspan="3" align="center"><label id="result_z1_b">'+ arry_correctval[3] +'</label></td>';						
					result_str += '</tr>';				
				result_str += '</table>';
				result_str += "</div>";
			}else{
				result_str = "<div>";
				result_str += "<p>Step " + step_count +": Answer</p>";
				
				result_str += '<table>';

					result_str += '<tr>';
						result_str += '<td rowspan="3" align="center"><label id="result_z1_b">'+ arry_correctval[3] +'</label></td>';
						result_str += '<td align="center"><label id="result_z1_b">'+ arry_correctval[4] +'</label></td>';
						
					result_str += '</tr>';
					result_str += '<tr>';
						result_str += '<td bgcolor="#000000" height="2"></td>';
						
					result_str += '</tr>';
					result_str += '<tr>';
						result_str += '<td align="center"><label id="result_m1_b">'+ arry_correctval[5] +'</label></td>';						
					result_str += '</tr>';				
				result_str += '</table>';
				result_str += "</div>";
			}
			
			$("#answer").html(result_str);
			answerDone(); //added   		
			displayTotalFlow();
			displayTotalFlow1();
		}else if (arry_correctval[1] > arry_correctval[2] && factorX != 1 && arry_correctval[4] != 0) {
			if (arry_correctval[6] == 0) {
				result_str = "<div>";
				result_str += "<p>Step " + step_count +": Answer</p>";
				
				result_str += '<table>';

					result_str += '<tr>';
						result_str += '<td rowspan="3" align="center"><label id="result_z1_b">'+ arry_correctval[3] +'</label></td>';						
					result_str += '</tr>';				
				result_str += '</table>';
				result_str += "</div>";
			}else{
				result_str = "<div>";
				result_str += "<p>Step " + step_count +": Answer</p>";
				
				result_str += '<table>';

					result_str += '<tr>';
						result_str += '<td rowspan="3" align="center"><label id="result_z1_b">'+ arry_correctval[3] +'</label></td>';
						result_str += '<td align="center"><label id="result_z1_b">'+ arry_correctval[4] +'</label></td>';
						
					result_str += '</tr>';
					result_str += '<tr>';
						result_str += '<td bgcolor="#000000" height="2"></td>';
						
					result_str += '</tr>';
					result_str += '<tr>';
						result_str += '<td align="center"><label id="result_m1_b">'+ arry_correctval[5] +'</label></td>';						
					result_str += '</tr>';				
				result_str += '</table>';
				result_str += "</div>";
			}
			
			$("#answer").html(result_str);
			answerDone(); //added
			displayTotalFlow();
			displayTotalFlow1();
		}else if (arry_correctval[1] > arry_correctval[2] && factorX != 1 && arry_correctval[4] == 0) {
			if (arry_correctval[4] == 0) {
				result_str = "<div>";
				result_str += "<p>Step " + step_count +": Answer</p>";
				
				result_str += '<table>';

					result_str += '<tr>';
						result_str += '<td rowspan="3" align="center"><label id="result_z1_b">'+ arry_correctval[3] +'</label></td>';						
					result_str += '</tr>';				
				result_str += '</table>';
				result_str += "</div>";
			}else{
				result_str = "<div>";
				result_str += "<p>Step " + step_count +": Answer</p>";
				
				result_str += '<table>';

					result_str += '<tr>';
						result_str += '<td rowspan="3" align="center"><label id="result_z1_b">'+ arry_correctval[3] +'</label></td>';
						result_str += '<td align="center"><label id="result_z1_b">'+ arry_correctval[4] +'</label></td>';
						
					result_str += '</tr>';
					result_str += '<tr>';
						result_str += '<td bgcolor="#000000" height="2"></td>';
						
					result_str += '</tr>';
					result_str += '<tr>';
						result_str += '<td align="center"><label id="result_m1_b">'+ arry_correctval[5] +'</label></td>';						
					result_str += '</tr>';				
				result_str += '</table>';
				result_str += "</div>";
			}
			
			$("#answer").html(result_str);
			answerDone(); //added
			displayTotalFlow();
			displayTotalFlow1();
		}else if (arry_correctval[6] == arry_correctval[7] && factorX != 1) {
			result_str = "<div>";
			result_str += "<p style='margin-top:20px;'>Step " + step_count +": Answer</p>";
			
			result_str += '<table>';

				result_str += '<tr>';
					result_str += '<td rowspan="3" align="center"><label id="result_z1_b">'+ arry_correctval[6] +'</label></td>';						
				result_str += '</tr>';				
			result_str += '</table>';
			result_str += "</div>";
			$("#answer").html(result_str);
			answerDone(); //added
			displayTotalFlow();
			displayTotalFlow1();
		}else if (arry_correctval[1] < arry_correctval[2] && flag == 0 && startdisplay == true) { 
			result_str = "<div>";
			
			result_str += '<table id="step_count3">';

				result_str += '<tr>';
					
					result_str += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
					result_str += '<td align="center"><label>' + arry_correctval[1] + '</label></td>';
					result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
					
				result_str += '</tr>';
				result_str += '<tr>';
					result_str += '<td bgcolor="#000000" height="2"></td>';
					result_str += '<td bgcolor="#000000" height="2"></td>';
					
				result_str += '</tr>';
				result_str += '<tr>';
					result_str += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
					result_str += '<td align="center"><label>' + arry_correctval[2] + '</label></td>';
					
				result_str += '</tr>';				
			result_str += '</table>';
			result_str += "</div>";
			
			$("#simplify").html(result_str);
			nextsetp();
			answerDone(); //added
			displayTotalFlow();
			displayTotalFlow1();
		}
		
	}

	$(".inputCheck").unbind("keydown").keydown(function(event){
		if(event.keyCode == 13){
			if(checkAnswer($(this)) == false && carry_over1 == false){
				// alert("Answer can't be alphabet !");
				alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			
			temp_answer = checkAnswerValidation($(this));
			if(temp_answer == -1){
				// alert("Your answer is larger than what we need.");
				alertModal("Your answer is larger than what we need.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(temp_answer == -2){
				// alert("opps not enough, your answer needs to be larger.");
				alertModal("Oops not enough, your answer needs to be larger.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(temp_answer == -3){
				$(this).prop("value", "").focus();
				return false;
			}
			if(temp_answer == correct_answer && carry_over1 == false){
				 
				 nextsetp();
			}
			else {
				carry_elem = $(this);
				carry_elem.blur();
				// $("#myModal").show();
				simplifyModal("Simplify fraction if possible ?"); //added
			}
		}
		
	}).focus();

	$(".inputCheck4").unbind("keydown").keydown(function(event){
		if(event.keyCode == 13){
			if(checkAnswer($(this)) == false && carry_over1 == false){
				// alert("Answer can't be alphabet !");
				alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			temp_answer = checkAnswerValidation($(this));
			if(temp_answer == -1){
				if (!step5_numerator_error) {
					step5_numerator_error = $(this).prop("value");
				}
				// alert("Your answer is larger than what we need.");
				alertModal("Your answer is larger than what we need.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(temp_answer == -2){
				if (!step5_numerator_error) {
					step5_numerator_error = $(this).prop("value");
				}
				// alert("opps not enough, your answer needs to be larger.");
				alertModal("Oops not enough, your answer needs to be larger.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(temp_answer == -3){
				if (!step5_numerator_error) {
					step5_numerator_error = $(this).prop("value");
				}
				$(this).prop("value", "").focus();
				return false;
			}
			$(".inputCheck4").attr("value", temp_answer);
			$(".inputCheck4").attr("readonly", true);
			$(".inputCheck5").attr("readonly", false);
			$(".inputCheck5").unbind("keydown").keydown(function(event){
				if(event.keyCode == 13){
					if(checkAnswer($(this)) == false && carry_over1 == false){
						// alert("Answer can't be alphabet !");
						alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
						$(this).prop("value", "").focus();
						retry_attempt++;
						return false;
					}
					
					temp_answer = checkAnswerValidation($(this));
					if(temp_answer == -1){
						if (!step5_denominator_error) {
							step5_denominator_error = $(this).prop("value");
						}
						// alert("Your answer is larger than what we need.");
						alertModal("Your answer is larger than what we need.");
						$(this).prop("value", "").focus();
						retry_attempt++;
						return false;
					}
					if(temp_answer == -2){
						if (!step5_denominator_error) {
							step5_denominator_error = $(this).prop("value");
						}
						// alert("opps not enough, your answer needs to be larger.");
						alertModal("Oops not enough, your answer needs to be larger.");
						$(this).prop("value", "").focus();
						retry_attempt++;
						return false;
					}
					if(temp_answer == -3){
						if (!step5_denominator_error) {
							step5_denominator_error = $(this).prop("value");
						}
						$(this).prop("value", "").focus();
						return false;
					}
					$(".inputCheck5").attr("value", temp_answer);
					$(".inputCheck5").attr("readonly", true);
					if (arry_correctval[6] <= arry_correctval[7]) {
						wholeBtnFlag = false;
						simplifyFlag = false;
					}
					wholeBtnFlag = true;
					nextsetp();
				}
			}).focus();
		}	
	}).focus();
}


function wholeOfValidationFunc() {
	$(".inputCheck1").unbind("keydown").keydown(function(event){
		if(event.keyCode == 13){
			if(checkAnswer($(this)) == false && carry_over1 == false){
				// alert("Answer can't be alphabet !");
				alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			
			temp_answer = checkAnswerValidation($(this));
			if(temp_answer == -1){
				if (!step5_whole) {
					step5_whole = $(this).prop("value");
				}
				// alert("Your answer is larger than what we need.");
				alertModal("Your answer is larger than what we need.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(temp_answer == -2){
				if (!step5_whole) {
					step5_whole = $(this).prop("value");
				}
				// alert("opps not enough, your answer needs to be larger.");
				alertModal("Oops not enough, your answer needs to be larger.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(temp_answer == -3){
				if (!step5_whole) {
					step5_whole = $(this).prop("value");
				}
				$(this).prop("value", "").focus();
				return false;
			}
			$(".inputCheck1").attr("value", temp_answer);
			$(".inputCheck1").attr("readonly", true);
			$(".inputCheck2").attr("readonly", false);
			$(".inputCheck2").unbind("keydown").keydown(function(event){
				if(event.keyCode == 13){
					if(checkAnswer($(this)) == false && carry_over1 == false){
						// alert("Answer can't be alphabet !");
						alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
						$(this).prop("value", "").focus();
						retry_attempt++;
						return false;
					}
					
					temp_answer = checkAnswerValidation($(this));
					if(temp_answer == -1){
						if (!step5_whole_numerator_error) {
							step5_whole_numerator_error = $(this).prop("value");
						}
						// alert("Your answer is larger than what we need.");
						alertModal("Your answer is larger than what we need.");
						$(this).prop("value", "").focus();
						retry_attempt++;
						return false;
					}
					if(temp_answer == -2){
						if (!step5_whole_numerator_error) {
							step5_whole_numerator_error = $(this).prop("value");
						}
						// alert("opps not enough, your answer needs to be larger.");
						alertModal("Oops not enough, your answer needs to be larger.");
						$(this).prop("value", "").focus();
						retry_attempt++;
						return false;
					}
					if(temp_answer == -3){
						if (!step5_whole_numerator_error) {
							step5_whole_numerator_error = $(this).prop("value");
						}
						$(this).prop("value", "").focus();
						return false;
					}
					$(".inputCheck2").attr("value", temp_answer);
					$(".inputCheck2").attr("readonly", true);
					$(".inputCheck3").attr("readonly", false);
					$(".inputCheck3").unbind("keydown").keydown(function(event){
						if(event.keyCode == 13){
							if(checkAnswer($(this)) == false && carry_over1 == false){
								// alert("Answer can't be alphabet !");
								alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
								$(this).prop("value", "").focus();
								retry_attempt++;
								return false;
							}
							
							temp_answer = checkAnswerValidation($(this));
							if(temp_answer == -1){
								if (!step5_whole_denominator_error) {
									step5_whole_denominator_error = $(this).prop("value");
								}
								// alert("Your answer is larger than what we need.");
								alertModal("Your answer is larger than what we need.");
								$(this).prop("value", "").focus();
								retry_attempt++;
								return false;
							}
							if(temp_answer == -2){
								if (!step5_whole_denominator_error) {
									step5_whole_denominator_error = $(this).prop("value");
								}
								// alert("opps not enough, your answer needs to be larger.");
								alertModal("Oops not enough, your answer needs to be larger.");
								$(this).prop("value", "").focus();
								retry_attempt++;
								return false;
							}
							if(temp_answer == -3){
								if (!step5_whole_denominator_error) {
									step5_whole_denominator_error = $(this).prop("value");
								}
								$(this).prop("value", "").focus();
								return false;
							}
							$(".inputCheck3").attr("value", temp_answer);
							$(".inputCheck3").attr("readonly", true);
							simplifyFlag = false;
							nextsetp();		    						
						}
					}).focus();
				}
			}).focus();
		}
		
	}).focus();
}

function canbtnYEsOnclick(){
	if (factorX == 1) {
		result_str = "<div>";
		result_str += "<p>Step " + step_count +": Answer</p>";
		
		result_str += '<table>';

			result_str += '<tr><td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td></tr>';
			result_str += '<tr><td bgcolor="#000000" height="2"></td></tr>';
			result_str += '<tr><td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td></tr>';				
		result_str += '</table>';
		result_str += "</div>";
	}else{
		result_str = "<div>";
		result_str += "<p>Step " + step_count +": Answer</p>";
		
		result_str += '<table>';

			result_str += '<tr><td align="center"><label id="result_z1_b">'+ arry_correctval[6] +'</label></td></tr>';
			result_str += '<tr><td bgcolor="#000000" height="2"></td></tr>';
			result_str += '<tr><td align="center"><label id="result_m1_b">'+ arry_correctval[7] +'</label></td></tr>';				
		result_str += '</table>';
		result_str += "</div>";
	}
	startdisplay = true;
	$("#answer").html(result_str);
	// $("#myModal2").hide();
	$("#message_modal_dynamic").hide(); //added
	answerDone(); //added
	displayTotalFlow();
	displayTotalFlow1();
}

function checkAnswerValidation(elem) {
	answer_val = parseInt(elem.prop("value"));

	getz1 = parseInt($("#z1").prop("value"));
	getz2 = parseInt($("#z2").prop("value"));
	getm1 = parseInt($("#m1").prop("value"));
	getm2 = parseInt($("#m2").prop("value"));
	
	if (step_count == 1) {
		correct_answer = getz1 * getm2;
		if (answer_val == correct_answer){
			carry_over = false;
			arry_correctval[10] = correct_answer;
			return correct_answer;	
		} 
		if(retry_attempt > 1){
			if (!step1_error) {
				step1_error = answer_val;
			}
			// alert("Correct Answer is " + correct_answer + ". Retry! ");
			alertModal("Correct Answer is " + correct_answer + ". Retry. ");
			retry_attempt = 0;
			return -3;
		}
		if (answer_val > correct_answer) {
			if (!step1_error) {
				step1_error = answer_val;
			}
			return -1;
		}else{
			if (!step1_error) {
				step1_error = answer_val;
			}
			return -2;	
		}
	}
	if (step_count == 2) {
		correct_answer = getm1 * getz2;
		if (answer_val == correct_answer){
			carry_over = false;
			arry_correctval[9] = correct_answer;
			return correct_answer;
		} 
		if(retry_attempt > 1){
			if (!step2_error) {
				step2_error = answer_val;
			}
			// alert("Correct Answer is " + correct_answer + ". Retry! ");
			alertModal("Correct Answer is " + correct_answer + ". Retry. ");
			retry_attempt = 0;
			return -3;
		}
		if (answer_val > correct_answer) {
			if (!step2_error) {
				step2_error = answer_val;
			}
			return -1;
		}else{
			if (!step2_error) {
				step2_error = answer_val;
			}
			return -2;	
		}
	}

	if (step_count == 3) {
		correct_answer = getz1 * getm2 + getz2 * getm1;
		if (answer_val == correct_answer){
			carry_over = false;
			arry_correctval[1] = correct_answer;
			return correct_answer;	
		} 
		if(retry_attempt > 1){
			if (!step3_error) {
				step3_error = answer_val;
			}
			// alert("Correct Answer is " + correct_answer + ". Retry! ");
			alertModal("Correct Answer is " + correct_answer + ". Retry. ");
			retry_attempt = 0;
			return -3;
		}
		if (answer_val > correct_answer) {
			if (!step3_error) {
				step3_error = answer_val;
			}
			return -1;
		}else{
			if (!step3_error) {
				step3_error = answer_val;
			}
			return -2;	
		}
	}

	if (step_count == 4) {

		correct_answer = getm1 * getm2;
		
		if (answer_val == correct_answer){
			arry_correctval[2] = correct_answer;
		
			carry_over = false;
			return correct_answer;	
		} 

		if(retry_attempt > 1){
			if (!step4_error) {
				step4_error = answer_val;
			}
			// alert("Correct Answer is " + correct_answer + ". Retry! ");
			alertModal("Correct Answer is " + correct_answer + ". Retry. ");
			retry_attempt = 0;
			return -3;
		}
		if (answer_val > correct_answer) {
			if (!step4_error) {
				step4_error = answer_val;
			}
			return -1;
		}else{
			if (!step4_error) {
				step4_error = answer_val;
			}
			return -2;	
		}
	}
	if (step_count == 5) {

		if (simplifyFlag == true) {
			simplify_count++;	
		}
		if (flag == 0 && simplifyFlag == false) {
			fraction_count++;
			if (fraction_count == 1) {

				correct_answer = Math.floor(arry_correctval[1]/arry_correctval[2]);
			
				if (answer_val == correct_answer){
					arry_correctval[3] = correct_answer;
				
					carry_over = false;
					return correct_answer;	
				}				    	
			}
			if (fraction_count == 2) {
				
				correct_answer = arry_correctval[1] % arry_correctval[2];
			 
				if (answer_val == correct_answer){
					arry_correctval[4] = correct_answer;
				
					carry_over = false;
					return correct_answer;	
				} 
			}
			if (fraction_count == 3) {

				correct_answer = arry_correctval[2];
			
				if (answer_val == correct_answer){
					arry_correctval[5] = correct_answer;
				
					carry_over = false;
					return correct_answer;	
				} 
				
			}

			if(retry_attempt > 1){
				fraction_count--;
				// alert("Correct Answer is " + correct_answer + ". Retry! ");
				alertModal("Correct Answer is " + correct_answer + ". Retry. ");
				retry_attempt = 0;
				return -3;
			}
			if (answer_val > correct_answer) {
				fraction_count--;
				return -1;
			}else{
				fraction_count--;
				return -2;
			}
		}
		
		if (wholeBtnFlag == true && arry_correctval[6] > arry_correctval[7]) {
			fraction_count++;
							
			if (fraction_count == 1) {

				correct_answer = Math.floor(arry_correctval[6]/arry_correctval[7]);
			
				if (answer_val == correct_answer){
					arry_correctval[3] = correct_answer;
				
					carry_over = false;
					return correct_answer;	
				}				    	
			}
			if (fraction_count == 2) {
				
				correct_answer = arry_correctval[6] % arry_correctval[7];
			 
				if (answer_val == correct_answer){
					arry_correctval[4] = correct_answer;
				
					carry_over = false;
					return correct_answer;	
				} 
			}
			if (fraction_count == 3) {

				correct_answer = arry_correctval[7];
			
				if (answer_val == correct_answer){
					arry_correctval[5] = correct_answer;
				
					carry_over = false;
					return correct_answer;	
				} 
				
			}

			if(retry_attempt > 1){
				fraction_count--;
				// alert("Correct Answer is " + correct_answer + ". Retry! ");
				alertModal("Correct Answer is " + correct_answer + ". Retry. ");
				retry_attempt = 0;
				return -3;
			}
			if (answer_val > correct_answer) {
				fraction_count--;
				return -1;
			}else{
				fraction_count--;
				return -2;
			}
		}

		if (simplifyFlag == true) {
			correct_answer = 0;
			An = Math.abs( arry_correctval[1] );
			Ad = Math.abs( arry_correctval[2] );

			//Find common factors of Numerator and Denominator
			for ( var x = 2; x <= Math.min( An, Ad ); x ++ ) {
				var check1 = An / x;
				if ( check1 == Math.round( check1 ) ) {
					var check2 = Ad / x;
					if ( check2 == Math.round( check2 ) ) {
						factorX = x;
					}
				}
			}

			An=(An/factorX);  //divide by highest common factor to reduce fraction then multiply by neg to make positive or negative
			Ad=Ad/factorX; 
			
			if (simplify_count == 1) {
				
				correct_answer = An;
			
				if (answer_val == correct_answer){
					arry_correctval[6] = correct_answer;
				
					carry_over = false;
					return correct_answer;	
				} 

				if(retry_attempt > 1){
					simplify_count--;
					// alert("Correct Answer is " + correct_answer + ". Retry! ");
					alertModal("Correct Answer is " + correct_answer + ". Retry. ");
					retry_attempt = 0;
					return -3;
				}
				if (answer_val > correct_answer) {
					simplify_count--;
					return -1;
				}else{
					simplify_count--;
					return -2;
				}
				
			}
			if (simplify_count == 2) {
				
				correct_answer = Ad;
			
				if (answer_val == correct_answer){
					arry_correctval[7] = correct_answer;
				
					carry_over = false;
					return correct_answer;	
				} 

				if(retry_attempt > 1){
					simplify_count--;
					// alert("Correct Answer is " + correct_answer + ". Retry! ");
					alertModal("Correct Answer is " + correct_answer + ". Retry. ");
					retry_attempt = 0;
					return -3;
				}
				if (answer_val > correct_answer) {
					simplify_count--;
					return -1;
				}else{
					simplify_count--;
					return -2;
				}
			}
		}	        	
	}
	
}

function possibleFlagfunc() {
	correct_answer = 0;
	An = Math.abs( arry_correctval[1] );
	Ad = Math.abs( arry_correctval[2] );

	//Find common factors of Numerator and Denominator
	for ( var x = 2; x <= Math.min( An, Ad ); x ++ ) {
		var check1 = An / x;
		if ( check1 == Math.round( check1 ) ) {
			var check2 = Ad / x;
			if ( check2 == Math.round( check2 ) ) {
				factorX = x;
			}
		}
	}

	An=(An/factorX);  //divide by highest common factor to reduce fraction then multiply by neg to make positive or negative
	Ad=Ad/factorX; 
	if ( An != arry_correctval[1] ) {
		return 1;
	}else{
		return 0;
	}
}

function wholebtnYEsOnclick() {
	
	wholeBtnFlag = true;
	$(".inputCheck1").show();
	$(".inputCheck2").show();
	$(".inputCheck3").show();
	$(".hidden_tag").show();
	wholeOfValidationFunc();
	$(".inputCheck2").attr("readonly", true);
	$(".inputCheck3").attr("readonly", true);
	// $("#myModal1").hide();
	$("#message_modal_dynamic").hide(); //added
}
function wholebtnNOOnclick() {
	// alert("Can not! Retry!");
	retryWholeNumModal("Can not. Retry.");
	// wholeBtnFlag = false;
	// nextsetp();
	// $(".inputCheck2").show();
	// $(".inputCheck3").show();
	// $(".inputCheck3").attr("readonly", true);
	// $("#myModal1").hide();
}

function btnYEsOnclick(){
	
	simplifyFlag = true;
	$(".inputCheck4").show();
	$(".inputCheck5").show();
	$(".inputCheck4").attr("readonly", false);
	$(".inputCheck5").attr("readonly", true);
	nextsetp();
	// $("#myModal").hide();
	$("#message_modal_dynamic").hide(); //added

}

function btnNOOnclick(){
	// alert("Can not!Retry!");
	retrySimplifyModal("Can not. Retry.");
}

function checkAnswer(elem) {
	answer_val = parseInt(elem.prop("value"));
	if(isNaN(answer_val)) return false;
	elem.prop("value", answer_val);
	setAnswered(answer_val);
	return true;
}

function displayTotalFlow(){
	
	strhtml = "";
	// strhtml += "<b style='color:blue'>Answered Flow</b>";
	// strhtml += "<br><br>";
	strhtml += '<div id="examPane1" style="">';
		strhtml += '<table>';
		
			strhtml += '<tr>';
			strhtml += '<td colspan="5"><b>Add:</b></td>';
				
			strhtml += '</tr>';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label style = "color:blue">'+ z1 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> + </b></td>';
				strhtml += '<td align="center"><label style = "color:blue">'+ z2 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label>'+ m1 +'</label></td>';
				strhtml += '<td align="center"><label>'+ m2 +'</td>';
				
			strhtml += '</tr>';				
		strhtml += '</table>';

	strhtml += '</div>';

	strhtml += "<p>Step 1: Cross Multiple #1</p>";
	if (step1_error) {
		strhtml += "<p style='color:red;'> Step 1 Error : " +  step1_error + "</p>";
	}
	strhtml += "<div>";
	strhtml += '<div>';
		strhtml += '<table style="margin-left:45px;">';
			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label style = "color:blue">'+ z1 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> + </b></td>';
				strhtml += '<td align="center"><label>'+ z2 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label>'+ m1 +'</label></td>';
				strhtml += '<td align="center"><label style = "color:blue">'+ m2 +'</td>';

			strhtml += '</tr>';				
		strhtml += '</table>';

	strhtml += '</div>';
	strhtml += "<p style='color:blue'>" + z1 + " x "+ m2 +" = "+ arry_correctval[10] +"</p>";

	strhtml += "<p>Step 2: Cross Multiple #2</p>";
	if (step2_error) {
		strhtml += "<p style='color:red;'> Step 2 Error : " +  step2_error + "</p>";
	}
	strhtml += "<div>";
	strhtml += '<div>';
		strhtml += '<table style="margin-left:45px;">';
			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label>'+ z1 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> + </b></td>';
				strhtml += '<td align="center"><label style = "color:blue">'+ z2 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label style = "color:blue">'+ m1 +'</label></td>';
				strhtml += '<td align="center"><label>'+ m2 +'</td>';

			strhtml += '</tr>';				
		strhtml += '</table>';

	strhtml += '</div>';
	strhtml += "<p style='color:blue'>" + z2 + " x "+ m1 +" = "+ arry_correctval[10] +"</p>";

	strhtml += "<div>";
	strhtml += "<p>Step 3: Add #1 and #2 </p>";
	if (step3_error) {
		strhtml += "<p style='color:red;'> Step 3 Error : " +  step3_error + "</p>";
	}
	strhtml += '<div>';
		strhtml += '<table>';
			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label style="color:blue;">'+ arry_correctval[10] +'</label></td>';
				strhtml += '<td align="center" valign="middle"><b> + </b></td>';
				strhtml += '<td align="center"><label style="color:blue;">'+ arry_correctval[9] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><label>' + arry_correctval[1] + '</label></td>';
			strhtml += '</tr>';			
		strhtml += '</table>';

	strhtml += '</div>';
	strhtml += "</div>";

	strhtml += "<div>";
	strhtml += "<p>Step 4: Multiply denominators</p>";
	if (step4_error) {
		strhtml += "<p style='color:red;'> Step 4 Error : " +  step4_error + "</p>";
	}
	strhtml += '<div>';
		strhtml += '<table>';
			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label style="color:blue;">'+ m1 +'</label></td>';
				strhtml += '<td align="center" valign="middle"><b> X </b></td>';
				strhtml += '<td align="center"><label style="color:blue;">'+ m2 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><label>' + arry_correctval[2] + '</label></td>';
			strhtml += '</tr>';			
		strhtml += '</table>';

	strhtml += '</div>';
	strhtml += "</div>";

	strhtml += "<p>Step 5: Simplify fraction if possible</p>";

	if (step5_whole) {
		strhtml += "<p style='color:red;'> Step5 Whole Error : " + step5_whole + "</p>";
	}

	if (step5_whole_numerator_error) {
		strhtml += "<p style='color:red;'> Step5 Whole Numerator Error : " + step5_whole_numerator_error + "</p>";
	}
	if (step5_whole_denominator_error) {
		strhtml += "<p style='color:red;'> Step5 Whole Denominator Error : " + step5_whole_denominator_error + "</p>";
	}
	if (step5_numerator_error) {
		strhtml += "<p style='color:red;'> Step5 Numerator Error : " + step5_numerator_error + "</p>";
	}
	if (step5_denominator_error) {
		strhtml += "<p style='color:red;'> Step5 Denominator Error : " + step5_denominator_error + "</p>";
	}

	if (arry_correctval[1] > arry_correctval[2] && factorX != 1 && arry_correctval[4] == 0) {
		// console.log("4= 0");
		strhtml += "<p style='color:red'> Simplify Number : " + factorX + "</p>";
		
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[4] + '</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[5] + '</label></td>';
				
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[1] > arry_correctval[2] && factorX != 1 && arry_correctval[4] != 0) {
		// console.log("4!= 0");
		strhtml += "<p style='color:red'> Simplify Number : " + factorX + "</p>";
		
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[6] + '</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[4] + '</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[7] + '</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[5] + '</label></td>';
				
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[1] > arry_correctval[2] && factorX == 1) {
		
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[4] + '</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[5] + '</label></td>';
				
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[1] < arry_correctval[2] && factorX != 1) {
		strhtml += "<p style='color:red'> Simplify Number : " + factorX + "</p>";
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[6] + '</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[7] + '</label></td>';
				
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[1] < arry_correctval[2] && factorX == 1) {
		
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[1] + '</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[2] + '</label></td>';						
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[6] == arry_correctval[7]) {
		strhtml += "<p style='color:red'> Simplify Number : " + factorX + "</p>";
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td rowspan="3" align="center"><label style="color:blue;">' + arry_correctval[6] + '</label></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';						
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}
	
	strhtml += "<p>Step 6: Answer: </p>";
	if (arry_correctval[1] > arry_correctval[2] && factorX != 1 && arry_correctval[4] == 0) {
		if (arry_correctval[4] == 0) {
			strhtml += "<div>";
			strhtml += '<table id="step_count3">';

				strhtml += '<tr>';
					
					strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
					
				strhtml += '</tr>';				
			strhtml += '</table>';
			strhtml += "</div>";
		}else{
			strhtml += "<div>";
			strhtml += '<table id="step_count3">';

				strhtml += '<tr>';
					
					strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
					strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[4] + '</label></td>';
					
				strhtml += '</tr>';
				strhtml += '<tr>';
					strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				strhtml += '</tr>';
				strhtml += '<tr>';
					strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[5] + '</label></td>';
					
				strhtml += '</tr>';				
			strhtml += '</table>';
			strhtml += "</div>";
		}
		

	}else if (arry_correctval[1] > arry_correctval[2] && factorX != 1 && arry_correctval[4] != 0) {
		if (arry_correctval[6] == 0) {
			strhtml += "<div>";
			strhtml += '<table id="step_count3">';

				strhtml += '<tr>';
					
					strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
					
				strhtml += '</tr>';				
			strhtml += '</table>';
			strhtml += "</div>";					
		}else{
			strhtml += "<div>";
			strhtml += '<table id="step_count3">';

				strhtml += '<tr>';
					
					strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
					strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[4] + '</label></td>';
					
				strhtml += '</tr>';
				strhtml += '<tr>';
					strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				strhtml += '</tr>';
				strhtml += '<tr>';
					strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[5] + '</label></td>';
					
				strhtml += '</tr>';				
			strhtml += '</table>';
			strhtml += "</div>";
		}				
	}else if (arry_correctval[1] > arry_correctval[2] && factorX == 1) {
		if (arry_correctval[4] == 0) {
			strhtml += "<div>";
			strhtml += '<table id="step_count3">';

				strhtml += '<tr>';
					
					strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
					
				strhtml += '</tr>';				
			strhtml += '</table>';
			strhtml += "</div>";
		}else{
			strhtml += "<div>";
			strhtml += '<table id="step_count3">';

				strhtml += '<tr>';
					
					strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
					strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[4] + '</label></td>';
					
				strhtml += '</tr>';
				strhtml += '<tr>';
					strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				strhtml += '</tr>';
				strhtml += '<tr>';
					strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[5] + '</label></td>';
					
				strhtml += '</tr>';				
			strhtml += '</table>';
			strhtml += "</div>";
		}
		
	}else if (arry_correctval[1] < arry_correctval[2] && factorX != 1) {
						
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[6] + '</label></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b" style="color:blue;">'+ arry_correctval[7] +'</label></td>';
				
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[1] < arry_correctval[2] && factorX == 1) {
		
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[1] + '</label></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b" style="color:blue;">'+ arry_correctval[2] +'</label></td>';						
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[6] == arry_correctval[7]) {
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				strhtml += '<td rowspan="3" align="center"><label style="color:blue;">' + arry_correctval[6] + '</label></td>';					
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}

	$("#correct_flow").html(strhtml);
}

function displayTotalFlow1(){
	
	strhtml = "";
	// strhtml += "<b style='color:blue'>Answered Flow</b>";
	// strhtml += "<br><br>";
	strhtml += '<div id="examPane1" style="">';
		strhtml += '<table>';
		
			strhtml += '<tr>';
			strhtml += '<td colspan="5"><b>Add:</b></td>';
				
			strhtml += '</tr>';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label style = "color:blue">'+ z1 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> + </b></td>';
				strhtml += '<td align="center"><label style = "color:blue">'+ z2 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label>'+ m1 +'</label></td>';
				strhtml += '<td align="center"><label>'+ m2 +'</td>';
				
			strhtml += '</tr>';				
		strhtml += '</table>';

	strhtml += '</div>';

	strhtml += "<p>Step 1: Cross Multiple #1</p>";
	strhtml += "<div>";
	strhtml += '<div>';
		strhtml += '<table style="margin-left:45px;">';
			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label style = "color:blue">'+ z1 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> + </b></td>';
				strhtml += '<td align="center"><label>'+ z2 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label>'+ m1 +'</label></td>';
				strhtml += '<td align="center"><label style = "color:blue">'+ m2 +'</td>';

			strhtml += '</tr>';				
		strhtml += '</table>';

	strhtml += '</div>';
	strhtml += "<p style='color:blue'>" + z1 + " x "+ m2 +" = "+ arry_correctval[10] +"</p>";

	strhtml += "<p>Step 2: Cross Multiple #2</p>";
	strhtml += "<div>";
	strhtml += '<div>';
		strhtml += '<table style="margin-left:45px;">';
			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label>'+ z1 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> + </b></td>';
				strhtml += '<td align="center"><label style = "color:blue">'+ z2 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label style = "color:blue">'+ m1 +'</label></td>';
				strhtml += '<td align="center"><label>'+ m2 +'</td>';

			strhtml += '</tr>';				
		strhtml += '</table>';

	strhtml += '</div>';
	strhtml += "<p style='color:blue'>" + z2 + " x "+ m1 +" = "+ arry_correctval[10] +"</p>";

	strhtml += "<div>";
	strhtml += "<p>Step 3: Add #1 and #2 </p>";
	strhtml += '<div>';
		strhtml += '<table>';
			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label style="color:blue;">'+ arry_correctval[10] +'</label></td>';
				strhtml += '<td align="center" valign="middle"><b> + </b></td>';
				strhtml += '<td align="center"><label style="color:blue;">'+ arry_correctval[9] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><label>' + arry_correctval[1] + '</label></td>';
			strhtml += '</tr>';			
		strhtml += '</table>';

	strhtml += '</div>';
	strhtml += "</div>";

	strhtml += "<div>";
	strhtml += "<p>Step 4: Multiply denominators</p>";
	strhtml += '<div>';
		strhtml += '<table>';
			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label style="color:blue;">'+ m1 +'</label></td>';
				strhtml += '<td align="center" valign="middle"><b> X </b></td>';
				strhtml += '<td align="center"><label style="color:blue;">'+ m2 +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><label>' + arry_correctval[2] + '</label></td>';
			strhtml += '</tr>';			
		strhtml += '</table>';

	strhtml += '</div>';
	strhtml += "</div>";

	strhtml += "<p>Step 5: Simplify fraction if possible</p>";

	if (arry_correctval[1] > arry_correctval[2] && factorX != 1 && arry_correctval[4] == 0) {
		// console.log("4= 0");
		strhtml += "<p style='color:red'> Simplify Number : " + factorX + "</p>";
		
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[4] + '</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[5] + '</label></td>';
				
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[1] > arry_correctval[2] && factorX != 1 && arry_correctval[4] != 0) {
		// console.log("4!= 0");
		strhtml += "<p style='color:red'> Simplify Number : " + factorX + "</p>";
		
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[6] + '</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[4] + '</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[7] + '</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[5] + '</label></td>';
				
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[1] > arry_correctval[2] && factorX == 1) {
		
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[4] + '</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[5] + '</label></td>';
				
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[1] < arry_correctval[2] && factorX != 1) {
		strhtml += "<p style='color:red'> Simplify Number : " + factorX + "</p>";
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[6] + '</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[7] + '</label></td>';
				
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[1] < arry_correctval[2] && factorX == 1) {
		
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[1] + '</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[2] + '</label></td>';						
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[6] == arry_correctval[7]) {
		strhtml += "<p style='color:red'> Simplify Number : " + factorX + "</p>";
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label id="result_z1_b">'+ arry_correctval[1] +'</label></td>';
				strhtml += '<td rowspan="3" align="center" valign="middle"><b> = </b></td>';
				strhtml += '<td rowspan="3" align="center"><label style="color:blue;">' + arry_correctval[6] + '</label></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b">'+ arry_correctval[2] +'</label></td>';						
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}
	
	strhtml += "<p>Step 6: Answer: </p>";
	if (arry_correctval[1] > arry_correctval[2] && factorX != 1 && arry_correctval[4] == 0) {
		if (arry_correctval[4] == 0) {
			strhtml += "<div>";
			strhtml += '<table id="step_count3">';

				strhtml += '<tr>';
					
					strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
					
				strhtml += '</tr>';				
			strhtml += '</table>';
			strhtml += "</div>";
		}else{
			strhtml += "<div>";
			strhtml += '<table id="step_count3">';

				strhtml += '<tr>';
					
					strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
					strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[4] + '</label></td>';
					
				strhtml += '</tr>';
				strhtml += '<tr>';
					strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				strhtml += '</tr>';
				strhtml += '<tr>';
					strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[5] + '</label></td>';
					
				strhtml += '</tr>';				
			strhtml += '</table>';
			strhtml += "</div>";
		}
		

	}else if (arry_correctval[1] > arry_correctval[2] && factorX != 1 && arry_correctval[4] != 0) {
		if (arry_correctval[6] == 0) {
			strhtml += "<div>";
			strhtml += '<table id="step_count3">';

				strhtml += '<tr>';
					
					strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
					
				strhtml += '</tr>';				
			strhtml += '</table>';
			strhtml += "</div>";					
		}else{
			strhtml += "<div>";
			strhtml += '<table id="step_count3">';

				strhtml += '<tr>';
					
					strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
					strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[4] + '</label></td>';
					
				strhtml += '</tr>';
				strhtml += '<tr>';
					strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				strhtml += '</tr>';
				strhtml += '<tr>';
					strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[5] + '</label></td>';
					
				strhtml += '</tr>';				
			strhtml += '</table>';
			strhtml += "</div>";
		}				
	}else if (arry_correctval[1] > arry_correctval[2] && factorX == 1) {
		if (arry_correctval[4] == 0) {
			strhtml += "<div>";
			strhtml += '<table id="step_count3">';

				strhtml += '<tr>';
					
					strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
					
				strhtml += '</tr>';				
			strhtml += '</table>';
			strhtml += "</div>";
		}else{
			strhtml += "<div>";
			strhtml += '<table id="step_count3">';

				strhtml += '<tr>';
					
					strhtml += '<td rowspan="3" align="center" valign="middle"><label style="color:blue;">' + arry_correctval[3] + '</label></td>';
					strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[4] + '</label></td>';
					
				strhtml += '</tr>';
				strhtml += '<tr>';
					strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
				strhtml += '</tr>';
				strhtml += '<tr>';
					strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[5] + '</label></td>';
					
				strhtml += '</tr>';				
			strhtml += '</table>';
			strhtml += "</div>";
		}
		
	}else if (arry_correctval[1] < arry_correctval[2] && factorX != 1) {
						
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[6] + '</label></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b" style="color:blue;">'+ arry_correctval[7] +'</label></td>';
				
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[1] < arry_correctval[2] && factorX == 1) {
		
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				
				strhtml += '<td align="center"><label style="color:blue;">' + arry_correctval[1] + '</label></td>';
				
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td bgcolor="#000000" height="2" style="color:blue;"></td>';
			strhtml += '</tr>';
			strhtml += '<tr>';
				strhtml += '<td align="center"><label id="result_m1_b" style="color:blue;">'+ arry_correctval[2] +'</label></td>';						
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}else if (arry_correctval[6] == arry_correctval[7]) {
		strhtml += "<div>";
		strhtml += '<table id="step_count3">';

			strhtml += '<tr>';
				strhtml += '<td rowspan="3" align="center"><label style="color:blue;">' + arry_correctval[6] + '</label></td>';					
			strhtml += '</tr>';				
		strhtml += '</table>';
		strhtml += "</div>";
	}

	$("#Answer_correct_flow").html(strhtml);
}
function displayFraction(IsShowWholeNumber, IsAfter, elemAfter){
	
	strhtml = "";
	strhtml += '<table style="float:left;">';
	strhtml += '<tr>';
	if( IsShowWholeNumber){
		strhtml += '<td rowspan="3" align="center" valign="middle"><input type="text" style="width:50px" name="w1" class="w1" value=""></td>';
	}
	strhtml += '<td align="center"><input type="text" style="width:50px" name="n1" class="n1" value=""></td>';
	strhtml += '</tr>'
	strhtml += '<tr>';
	strhtml += '<td bgcolor="#000000" height="2"></td>';
	strhtml += '</tr>';
	strhtml += '<tr>';
	strhtml += '<td align="center"><input type="text" style="width:50px" name="d1" class="d1" value=""></td>';
	strhtml += '</tr>';
	strhtml += '</table>';
	strhtml += '<table style="clear:both"></table>'
	if(IsAfter)
		$(strhtml).insertAfter(elemAfter);
	else
		$(strhtml).insertBefore(elemAfter);
}