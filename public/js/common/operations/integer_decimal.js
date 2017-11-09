/**
 * Code from client
 * 20170904
 */

var randomNumber = 0;
var randomdigitsNumber = 0;
var step_count = 0;
var countofrandomdigitsNumber = 0;
var real_number = "";
var str_randomNumber = "";
var max_digit = 0;
var checkIndex =0;
var str_interger = "";
var str_decimal = "";
var po1 = 0;
var randomIndex = 0;
var step5Answer = 0;
var step4Answer = 0;

var step3Flag = false;

var arry_correctval = [];
var arry_total = [];
var arry_randomNumber = [];
var arry_temp = [];
var arry_checkIdx = [];
var number_words = ["One", "Ten", "Hundred", "Thousand", "Ten Thousand", "Hundred Thousand", "Million", "Ten Million", "Hundred Million"];
var decimal_words = [ "Tenths", "Hundredths","Thousandths", "Ten Thousandths",  "Hundred Thousandths", "Millionths", "Ten Millionths", "Hundred Millionths"];

var ths_words = ["first", "second", "third", "fourth","fifth", "sixth", "seventh", "eighth", "nineth", "tenth"];
var answered = []; //ADDED

// start ADDED functions
//getter and setter
function setRandomDigits(digit){
	randomDigits1 = digit;
	randomDigits2 = digit;
}

function getRandomNumber1(){
	return str_interger;
}

function getRandomNumber2(){
	return underl;
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
	$("#answerPane").hide();
	$("#step_div").hide();
	$("#tipsFlow").show();
	$("#ansFlow").show();
	$("#ansCorrectFlow").show();
	enabledNextQuestion();
}

function answerReset(){
	$("#questionPane").show();
	$("#answerPane").show();
	$("#step_div").show();
	$("#tipsFlow").hide();
	$("#ansFlow").hide();
	$("#ansCorrectFlow").hide();
	answered = [];
	disabledNextQuestion();
}

function alertModal(message){
	dynamicBlock();
	$("#message_text_modal").html(message);
	$("#message_modal_dynamic").show();
	$("#close_modal").show();
	$("#yes_modal").hide();
	$("#no_modal").hide();
}

function closeModal(){
	$("#message_modal_dynamic").hide();
}

// end ADDED functions


function randomDigitsOnclick(){

	randomNumber = 0;
	randomdigitsNumber = 0;
	step_count = 0;
	countofrandomdigitsNumber = 0;
	real_number = "";
	str_randomNumber = "";
	max_digit = 0;
	checkIndex =0;
	str_interger = "";
	str_decimal = "";
	po1 = 0;
	randomIndex = 0;
	step5Answer = 0;
	step4Answer = 0;

	step3Flag = false;

	arry_correctval = [];
	arry_total = [];
	arry_randomNumber = [];
	arry_temp = [];
	arry_checkIdx = [];
	
	randomDigits1 = parseInt($(".randomDigits1").prop("value"));
	min = 0.05;
	randomDigits2 = parseInt($(".randomDigits2").prop("value"));

	if(isNaN(randomDigits1)) {
		randomDigits1 = 50;
		$(".randomDigits1").prop("value", randomDigits1);
	}
	if(isNaN(randomDigits2)) {
		randomDigits2 = 3;
		$(".randomDigits2").prop("value", randomDigits2);
	}
	if (randomDigits2 > 7) {
		randomDigits2 = 7;
		$(".randomDigits2").prop("value", randomDigits2);
	}

	randomNumber = (Math.random() * (randomDigits1 - min) + min).toFixed(randomDigits2);
	real_number = randomNumber + "";

	po1 = randomNumber.indexOf(".");
	str_interger = randomNumber.substring(0, po1);
	str_decimal = randomNumber.substring(po1+1);
	// console.log(str_interger + "---" + str_decimal);
	randomIndex = Math.floor(Math.random() * str_decimal.length);


		underl = "";
	for (var i = 0; i < str_decimal.length; i++) {
		if (i == randomIndex) {
			underl += "<u style='color:red'>" + str_decimal[i] + "</u>";
		}else{
			underl += str_decimal[i];
		}
	}
	$("#step_div").html('<div id="tableNumber_div"></div><div id="lastDiv"></div>');
	$("#correct_flow").html("");
	$("#correct_flow_answer").html("");

	max_digit = real_number.length + 3;
	$("#str_interger_b").html(str_interger);
	$("#str_decimal_b").html(underl);
	$("#start_div").show();
}

function startBtnOnclick(){
	step_count++;
	retry_attempt = 0;
	$("#step_div").show();
	var result_str = "";
	if (step_count == 1) {
		result_str = "<div>";
		result_str += "<p>Step " + step_count +":  First identify how many decimal points the number has?</p>";
		result_str += "<input class='inputCheck'>";
		result_str += "</div>";
		$("#tableNumber_div").html(result_str);
	}

	$(".inputCheck").keydown(function(event){
		if(event.keyCode == 13){
			if(checkAnswer($(this)) == "y"){
				// alert("Answer can't be alphabet !");
				alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(checkAnswer($(this)) == "z"){
				// alert('Input the valid expression');
				alertModal('That is incorrect. Answer can’t be blank. Please retry.');
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			
			temp_answer = checkAnswerValidation($(this));
			// console.log("temp_answer = " + temp_answer);
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
			$(this).attr("readonly", true);
			nextsetp();
		}
	}).focus();
}

function nextsetp(){
	
	retry_attempt = 0;
	result_str = "";
	step_count++;
	result_str += "<table>";
		result_str += "<tr>";

			for (var i = 0; i < real_number.length; i++) {
				if (i == po1) {
					result_str += "<th id='color_th'>Decimal</th>";
				}else if (i > po1) {
					result_str += "<th id='color_th'>" + decimal_words[i-po1-1] + "</th>";
				}else if (i < po1) {
					result_str += "<th id='color_th'>" + number_words[po1 - i - 1] + "</th>";
				}
				
			}

		result_str += "</tr>";
		result_str += "<tr>";
			for (var i = 0; i < real_number.length; i++) {
				if (i == po1) {
					result_str += "<td>.</td>";
				}else{
					result_str += "<td><input type=text style='width:91px;text-align:center;' placeholder='answer' class='checkIndexs'></td>";
				}


			}
		result_str += "</tr>";
	result_str += "</table>";
	if (step_count == 2) {
		$("<p>Step " + step_count + " : Second identify how many digits the number has? </p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
	}

	if (step_count == 3) {
		$("<p>Step " + step_count + " : Use the place value table and rewrite the number in the table.</p>" + result_str).insertBefore("#lastDiv");
		return middleFunc();
	}

	if (step_count == 4) {
		$("<p>Step " + step_count + " : Where does " + str_decimal[randomIndex] + " fall in the number?  (Example Tenths place) </p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
	}

	if (step_count == 5) {
		$("<p>Step " + step_count + " : What is the value of the number?  (Example if it is a tenths, type in 0.1 x 1)  </p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
	}
	if (step_count == 6) {
		$("<p>Step " + step_count + " : Answer.</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
	}

	$(".inputCheck").unbind("keydown").keydown(function(event){
		if(event.keyCode == 13){
			if(checkAnswer($(this)) == "y"){
				// alert("Answer can't be alphabet !");
				alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(checkAnswer($(this)) == "z"){
				// alert('Input the valid expression');
				alertModal('That is incorrect. Answer can’t be blank. Please retry.');
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			
			temp_answer = checkAnswerValidation($(this));

			if (step_count == 4 || step_count == 5) {
				if(temp_answer == true){
					// console.log("temp_answer = " + temp_answer);
					// alert('Write it out as an equation, example: 456+10');
					alertModal('Write it out as an equation, example: 456+10.');
					$(this).prop("value", "").focus();
					retry_attempt++;
					return false;
				}
				if (temp_answer == false) {
					// alert("Answer can't be alphabet !");
					alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
					$(this).prop("value", "").focus();
					retry_attempt++;
					return false;
				}
				if(temp_answer == "e"){
					// alert("Your answer is not accurate. Retry!");
					alertModal("Your answer is either incorrect or must be in all capital letters. Please retry.");
					$(this).prop("value", "").focus();
					retry_attempt++;
					return false;
				}
				if(temp_answer == -3){
					$(this).prop("value", "").focus();
					return false;
				}
				// console.log("temp_answer = " + temp_answer);
				$(this).attr("readonly", true);
				nextsetp();
				if (step_count > 6) {
					answerDone();	//added
					displayTotalFlow();
					displayTotalFlow1();
				}
			}else{
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
				// console.log("temp_answer = " + temp_answer);
				$(this).attr("readonly", true);
				nextsetp();
				if (step_count > 6) {
					answerDone();	//added
					displayTotalFlow();
					displayTotalFlow1();
				}
			}
			
		}
	}).focus();
}

function middleFunc() {
	$(".checkIndexs").eq(0).focus();
	checkIndex = 0;
	$(".checkIndexs").unbind("keydown").keydown(function(event){
		if(event.keyCode == 13){
			if(checkAnswer($(this)) == "y"){
				// alert("Answer can't be alphabet !");
				alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(checkAnswer($(this)) == "z"){
				// alert('Input the valid expression');
				alertModal('That is incorrect. Answer can’t be blank. Please retry.');
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
			if (checkIndex == real_number.length) {
				nextsetp();
			}
			$(this).attr("readonly", true);
			if (checkIndex > po1) {
				$(".checkIndexs").eq(checkIndex-1).focus();
			}else{
				$(".checkIndexs").eq(checkIndex).focus();
			}
		}	
	});
}

function checkAnswerValidation(elem) {
	
	answer_val = elem.prop("value");

	if (step_count == 1) {
		correct_answer = randomDigits2;

		if (answer_val == correct_answer){
			return correct_answer;
		}
	}
	if (step_count == 2) {
		correct_answer = str_interger.length + randomDigits2;
	
		if (answer_val == correct_answer){
			return correct_answer;	
		}
	}

	if (step_count == 3) {
		if (real_number[checkIndex] == ".") {
			checkIndex++;
			$(".checkIndexs").eq(checkIndex).focus();
		}
		correct_answer = real_number[checkIndex] * 1;
		if (answer_val == correct_answer) {
			checkIndex++;
			retry_attempt = 0;
			return correct_answer;
		}
		if (answer_val > correct_answer) {
			if(retry_attempt > 1){
				// alert("Correct Answer is " + correct_answer + ". Retry! ");
				alertModal("The correct answer is " + correct_answer + ". Please retry. ");
				retry_attempt = 0;
				return -3;
			}else{
		
				if (!arry_checkIdx[checkIndex]) {
					// console.log("checkIndex = " + checkIndex);
					arry_checkIdx[checkIndex] = answer_val;
				}
				return -1;
			}
		}else {
			if(retry_attempt > 1){
				// alert("Correct Answer is " + correct_answer + ". Retry! ");
				alertModal("The correct answer is " + correct_answer + ". Please retry. ");
				retry_attempt = 0;
				return -3;
			}else{

				if (!arry_checkIdx[checkIndex]) {

					arry_checkIdx[checkIndex] = answer_val;
				}
				return -2;
			}
		}
	}

	if (step_count == 4) {
		var strqq = "";
		strqq = decimal_words[randomIndex];
		// console.log("strqq = " + strqq);
		correct_answer = strqq.toLowerCase()
		if (answer_val == correct_answer){
			step4Answer = correct_answer;
			return correct_answer;	
		}else if (answer_val == strqq) {
			step4Answer = strqq;
			return strqq;
		} else{
			if(retry_attempt > 1){
				// alert("Correct Answer is " + correct_answer + " or " + strqq + ". Retry! ");
				alertModal("The correct answer is " + correct_answer + " or " + strqq + ". Please retry. ");
				retry_attempt = 0;
				return -3;
			}else{
				if (!arry_temp[step_count]) {
					arry_temp[step_count] = answer_val;
				}
				return "e";
			}
		}
	}
	if (step_count == 5) {
		correct_answer1 =  1 / digits(randomIndex + 1) + "x" + str_decimal[randomIndex];
		correct_answer2 =  str_decimal[randomIndex] + "x" + 1 / digits(randomIndex + 1);
	
		if (answer_val == correct_answer1){
			step5Answer = correct_answer1;
			return correct_answer1;	
		}else if (answer_val == correct_answer2) {
			step5Answer = correct_answer2;
			return correct_answer2;
		} else{
			arry_temp[5] = answer_val;
			if (isValidExpression(answer_val)) {
				if(retry_attempt > 1){
					// alert("Correct Answer is " + correct_answer1 + " or " + correct_answer2 + ". Retry! ");
					alertModal("The correct answer is " + correct_answer1 + " or " + correct_answer2 + ". Please retry. ");
					retry_attempt = 0;
					return -3;
				}else{
					return true;
				}
			}else {
				if(retry_attempt > 1){
					// alert("Correct Answer is " + correct_answer1 + " or " + correct_answer2 + ". Retry! ");
					alertModal("The correct answer is " + correct_answer1 + " or " + correct_answer2 + ". Please retry. ");
					retry_attempt = 0;
					return -3;
				}else{
					return false;
				}
			}
		}
	}
	if (step_count == 6) {
		correct_answer =  (1 / digits(randomIndex + 1).toFixed(randomIndex))*str_decimal[randomIndex];
		// console.log("correct_answer = " + correct_answer);
		
		if (answer_val == correct_answer){
			// console.log("correct_answer1 = " + correct_answer);
			
			return correct_answer;
		}
	}

	if (answer_val > correct_answer) {
		if(retry_attempt > 1){
			// alert("Correct Answer is " + correct_answer + ". Retry! ");
			alertModal("The correct answer is " + correct_answer + ". Please retry. ");
			retry_attempt = 0;
			return -3;
		}else{
			if (!arry_temp[step_count]) {
				arry_temp[step_count] = answer_val;
			}
			return -1;
		}
	}else {
		if(retry_attempt > 1){
			// alert("Correct Answer is " + correct_answer + ". Retry! ");
			alertModal("The correct answer is " + correct_answer + ". Please retry. ");
			retry_attempt = 0;
			return -3;
		}else{
			if (!arry_temp[step_count]) {
				arry_temp[step_count] = answer_val;
			}
			return -2;
		}
	}
}

function isValidExpression(__str_expr){
	var __temp_expr = __str_expr.match( /[1-9.+-/*=]*/ );
	return (__temp_expr == __str_expr);
}

function checkAnswer(elem) {
	answer_val = elem.prop("value");
	// console.log("step_count = " + step_count);
	setAnswered(answer_val);	//added
	if (step_count == 5 || step_count == 4) {
		// console.log("step_count45 = " + step_count);
		
		if (answer_val == "") {
			return "z";
		}
	}else{
		
		if(isNaN(answer_val)) {
			return "y";
		}
		if (answer_val == "") {
			return "z";
		}
	}

	elem.prop("value", answer_val);
}

function displayTotalFlow(){
	result_str = "";
	// result_str += "<b style='color:blue'>Answered Flow</b>";
	// result_str += "<br><br>";
	result_str += "<div id='start_div'>";
		result_str += '<label>What is the place value of the underlined integer?';
			result_str += '<b id="randomNumber_b">' + str_interger.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +"."+str_decimal + '</b>';
		result_str += '</label>';
	result_str += "</div>";

	result_str += "<div>";

		result_str += "<p>Step 1: First identify how many decimal points the number has? " + randomDigits2 + "</p>";
		result_str += str_interger + "<font color=red>." + str_decimal + "</font>";
		if (arry_temp[1]) {
			result_str += "<p style='color:red;'> Error : " + arry_temp[1] + "</p>";
		}

		result_str += "<p style='color:blue'> - Count the number of integers to the right of the decimal point.  In this case there are " + randomDigits2 + "</p>";
		
	result_str += "</div>";

	result_str += "<div>";

		result_str += "<p>Step 2: Second identify how many digits the number has? " + str_interger.length + "</p>";
		result_str += "<font color=red>" + str_interger + "</font>." + str_decimal;
		if (arry_temp[2]) {
			result_str += "<p style='color:red;'> Error : " + arry_temp[2] + "</p>";
		}
		result_str += "<p style='color:blue'> - Count all digits to the left of the decimal point.  In this case there are " + str_interger.length + "</p>";


	result_str += "</div>";

	stc = "";
	stc += "<table>";
		stc += "<tr>";

			for (var i = 0; i < real_number.length; i++) {
				if (i == po1) {
					stc += "<th id='color_th'>Decimal</th>";
				}else if (i > po1) {
					stc += "<th id='color_th'>" + decimal_words[i-po1-1] + "</th>";
				}else if (i < po1) {
					stc += "<th id='color_th'>" + number_words[po1 - i - 1] + "</th>";
				}

			}
			
		stc += "</tr>";
		stc += "<tr>";
			for (var i = 0; i < real_number.length; i++) {
				if (i > po1) {
					stc += "<td>" + str_decimal[i - po1 - 1] + "</td>";
				}else{
					stc += "<td></td>";
				}
			}
		stc += "</tr>";
	stc += "</table>";
	stc1 = "";
	stc1 += "<table>";
		stc1 += "<tr>";

			for (var i = 0; i < real_number.length; i++) {
				if (i == po1) {
					stc1 += "<th id='color_th'>Decimal</th>";
				}else if (i > po1) {
					stc1 += "<th id='color_th'>" + decimal_words[i-po1-1] + "</th>";
				}else if (i < po1) {
					stc1 += "<th id='color_th'>" + number_words[po1 - i - 1] + "</th>";
				}

			}

		stc1 += "</tr>";
		stc1 += "<tr>";
			for (var i = 0; i < real_number.length; i++) {
				if (i == po1) {
					stc1 += "<td>.</td>"
				}
				if (i > po1) {
					stc1 += "<td></td>";
				}else if (i < po1){
					stc1 += "<td>" + str_interger[i] + "</td>";
				}
			}
		stc1 += "</tr>";
	stc1 += "</table>";
	result_interger = "";
	result_decimal = "";
	for (var i = 0; i < str_interger.length; i++) {
		if (i == str_interger.length - 1) {
			if (i == 0) {
				result_interger += number_words[str_interger.length - i - 1] + ".";
			}else{
				result_interger += "and " + number_words[str_interger.length - i - 1] + ".";
			}
		}else{
			result_interger += number_words[str_interger.length - i - 1] + ",";
		}
	}
	for (var i = 0; i < str_decimal.length; i++) {
		if (i == str_decimal.length - 1) {
			if (i == 0) {
				result_decimal += decimal_words[i] + ".";
			}else{
				result_decimal += "and " + decimal_words[i] + ".";
			}
		}else{
			result_decimal += decimal_words[i] + ",";
		}
	}
	str_error = "";
	for (var k in arry_checkIdx){
		if (arry_checkIdx.hasOwnProperty(k)) {
			str_error += "<p style='color:red;'> Error : " + arry_checkIdx[k] + "</p>";
		}
	}

	result_str += "<div>";

		result_str += "<p>Step 3:  Use the place value table and rewrite the number in the table.<br> "+ str_error +"<br>- Fill in this table.<br><font color=blue> - We know that if there are " + str_interger.length + " digits in the number to the left of the decimal.<br> - This means the number is in the " + number_words[str_interger.length] + ".  <br> - Hence we have a " + result_interger + "</font></p>" + stc1;
		result_str += "<p><font color=blue> - Next we know that there are " + str_decimal.length + " integers after the decimal point.  <br> - This means we have a " + result_decimal + "</font></p>" + stc;

	result_str += "</div>";

	result_str += "<div>";

		result_str += "<p>Step 4: Where does " + str_decimal[randomIndex] + " fall in the number?  (Example Tenths place)</p>";
		result_str += "<p><font color=blue>" + step4Answer + "</font></p>";
		if (arry_temp[4]) {
			result_str += "<p style='color:red;'> Error : " + arry_temp[4] + "</p>";
		}
		result_str += "<p><font color=blue> - In this case the number " + str_decimal[randomIndex] + " falls in "+ decimal_words[randomIndex] +" place.</font></p>";
	
	result_str += "</div>";

	result_str += "<p> Step 5: What is the value of the number?  (Example if it is a ones, type in 1x5)  </p>";
	if (arry_temp[5]) {
		result_str += "<p style='color:red;'> Error : " + arry_temp[5] + "</p>";
	}
	result_str += "<p><font color=blue>" + step5Answer + "</font></p>";
	
	result_str += "<p> Step 6: Answer.</p>";
	if (arry_temp[6]) {
		result_str += "<p style='color:red;'> Error : " + arry_temp[6] + "</p>";
	}
	result_str += "<font color=blue>"+1 / digits(randomIndex + 1)*str_decimal[randomIndex] + "</font>";
	$("#correct_flow").html(result_str);

}

function displayTotalFlow1(){
	result_str = "";
	// result_str += "<b style='color:blue'>Correct Answered Flow</b>";
	// result_str += "<br><br>";
	result_str += "<div id='start_div'>";
		result_str += '<label>What is the place value of the underlined integer?';
			result_str += '<b id="randomNumber_b">' + str_interger.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +"."+str_decimal + '</b>';
		result_str += '</label>';
	result_str += "</div>";

	result_str += "<div>";

		result_str += "<p>Step 1: First identify how many decimal points the number has? " + randomDigits2 + "</p>";
		result_str += str_interger + "<font color=red>." + str_decimal + "</font>";
	
		result_str += "<p style='color:blue'> - Count the number of integers to the right of the decimal point.  In this case there are " + randomDigits2 + "</p>";
		
	result_str += "</div>";

	result_str += "<div>";

		result_str += "<p>Step 2: Second identify how many digits the number has? " + str_interger.length + "</p>";
		result_str += "<font color=red>" + str_interger + "</font>." + str_decimal;
		
		result_str += "<p style='color:blue'> - Count all digits to the left of the decimal point.  In this case there are " + str_interger.length + "</p>";
		
	
	result_str += "</div>";

	stc = "";
	stc += "<table>";
		stc += "<tr>";
		
			for (var i = 0; i < real_number.length; i++) {
				if (i == po1) {
					stc += "<th id='color_th'>Decimal</th>";
				}else if (i > po1) {
					stc += "<th id='color_th'>" + decimal_words[i-po1-1] + "</th>";	
				}else if (i < po1) {
					stc += "<th id='color_th'>" + number_words[po1 - i - 1] + "</th>";
				}
				
			}

		stc += "</tr>";
		stc += "<tr>";
			for (var i = 0; i < real_number.length; i++) {
				stc += "<td>" + real_number[i] + "</td>";

			}
		stc += "</tr>";
	stc += "</table>";
	result_interger = "";
	result_decimal = "";
	for (var i = 0; i < str_interger.length; i++) {
		if (i == str_interger.length - 1) {
			if (i == 0) {
				result_interger += number_words[str_interger.length - i - 1] + ".";
			}else{
				result_interger += "and " + number_words[str_interger.length - i - 1] + ".";
			}
		}else{
			result_interger += number_words[str_interger.length - i - 1] + ",";
		}

	}
	for (var i = 0; i < str_decimal.length; i++) {
		if (i == str_decimal.length - 1) {
			if (i == 0) {
				result_decimal += decimal_words[i] + ".";
			}else{
				result_decimal += "and " + decimal_words[i] + ".";
			}
		}else{
			result_decimal += decimal_words[i] + ",";
		}

	}

	result_str += "<div>";

		result_str += "<p>Step 3:  Use the place value table and rewrite the number in the table.<br> - Fill in this table.<br><font color=blue> - We know that if there are " + str_interger.length + " digits in the number to the left of the decimal.<br> - This means the number is in the " + number_words[str_interger.length] + ".  <br> - Hence we have a " + result_interger + "</font></p>" + stc;
		result_str += "<p><font color=blue> - Next we know that there are " + str_decimal.length + " integers after the decimal point.  <br> - This means we have a " + result_decimal + "</font></p>" + stc;

	result_str += "</div>";

	result_str += "<div>";

		result_str += "<p>Step 4: Where does " + str_decimal[randomIndex] + " fall in the number?  (Example Tenths place)</p>";
		result_str += "<p><font color=blue>" + step4Answer + "</font></p>";

		result_str += "<p><font color=blue> - In this case the number " + str_decimal[randomIndex] + " falls in "+ decimal_words[randomIndex] +" place.</font></p>";

	result_str += "</div>";

	result_str += "<p> Step 5: What is the value of the number?  (Example if it is a ones, type in 1x5)  <br><font color=blue>" + step5Answer + "</font></p>";
	result_str += "<p> Step 6: Answer.</p>";
	result_str += "<font color=blue>"+1 / digits(randomIndex + 1)*str_decimal[randomIndex] + "</font>";
	$("#correct_flow_answer").html(result_str);

}

function displayFraction(IsAfter, elemAfter){
	
	current_str = "";
	for (var i = 0; i < exponentsNumber; i++) {
		if (i == 0) result_str = "<br><label id='valuetoinput_l" + i + "' style='color:blue;'> What is " + baseNumber + " = <input class='inputCheck' style='width:80px;'> --- " + (i+1) + "<sup>" + arr_orderNumber[i] + "</sup></label>"
		if(i > 0) current_str += "x";
		current_str += baseNumber;
		result_str += "<br><label id='valuetoinput_l" + (i+1) + "' style='color:blue;display:none'>What is " + current_str + " x "+ baseNumber +" = <input class='inputCheck' style='width:80px;'> --- " + (i+2) + "<sup>" + arr_orderNumber[i + 1] + "</sup></label>";
	}
	if(IsAfter)
		$(result_str).insertAfter(elemAfter);
	else
		$(result_str).insertBefore(elemAfter);
}