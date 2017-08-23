/**
 * Code from client
 * 20170818
 */

var randomNumber1 = "";
var randomNumber2 = "";
var randomDigits1 = "";
var randomDigits2 = "";

var total_step = 0;
var step_count_row1 = 0;
var step_count_row2 = 0;
var step_words = ["ones", "tens", "hundreds", "thousands", "ten thousands", "hundred thousands", "millions"];
var carry_over_All_Values_Real = [];
var carry_over_All_Values_Correct = [];
var carry_over_Step_Values_Real = [];
var carry_over_Step_Values_Correct = [];
var step_values = [];
var sub_step_Value = [];
var sub_result_Value = [];
var carry_over = false;
var carry_over_value = 0;
var subResult;
var IsFinish = false;
var arry_tempanswer = [];
var carry_words = ["one", "two", "three", "four", "five", "six", "seven", "eight", "nine"];
var answered = []; //ADDED


// start ADDED functions
//getter and setter
function setRandomDigits(digit){
    randomDigits1 = digit;
    randomDigits2 = digit;
}

function getRandomNumber1(){
    return randomNumber1;
}

function getRandomNumber2(){
    return randomNumber2
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
    $("#tipsFlow").show();
    $("#ansFlow").show();
    $("#ansCorrectFlow").show();
    enabledNextQuestion();
}

function answerReset(){
    $("#questionPane").show();
    $("#answerPane").show();
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

function carryOneModal(message){
    dynamicBlock();
    $("#message_text_modal").html(message);
    $("#message_modal_dynamic").show();
    $("#close_modal").hide();
    $("#yes_modal").show();
    $("#no_modal").show();
}

// end ADDED functions

function randomDigitsOnclick(){
	// randomDigits1 = $("#randomDigits1").prop("value"); //removed
	randomDigits1 = parseInt(randomDigits1);
	if(isNaN(randomDigits1)) randomDigits1 = 1;

	// randomDigits2 = $("#randomDigits2").prop("value"); //removed
	randomDigits2 = parseInt(randomDigits2);
	if(isNaN(randomDigits2)) randomDigits2 = 1;

	if(randomDigits1 > 8) randomDigits1 = 8;
	if(randomDigits2 > 4) randomDigits2 = 4;
	$("#randomDigits1").prop("value", randomDigits1);
	$("#randomDigits2").prop("value", randomDigits2);
	randomNumber1 = Math.floor(Math.random() * digits(randomDigits1));
	randomNumber2 = Math.floor(Math.random() * digits(randomDigits2));

	$("#randomNumber1").prop("value", randomNumber1);
	$("#randomNumber2").prop("value", randomNumber2);
	$("#subject_number1_p").html(randomNumber1);
	$("#subject_number2_p").html(randomNumber2);
	$("#answerPane").html('<div id="lastDiv"></div>');
	$("#examPane").show();
	$("#answertipPane").html("<b style='color: #005588;'>Answer Flow</b><div id='lastDiv2'></div><br>");
	$("#correctanswertipPane").html("<b style='color: #005588;'>Correct Answer Flow</b><div id='lastDiv3'></div><br>");

	total_step = 0;
	step_count_row1 = 0;
	step_count_row2 = 1;
	carry_over_All_Values_Real = [];
	carry_over_All_Values_Correct = [];
	sub_step_Value = [];
	sub_result_Value = [];
	carry_over = false;
	carry_over_value = 0;
	IsFinish = false;
}

function checkAnswer(elem) {
	answer_val = parseInt(elem.prop("value"));
	if(isNaN(answer_val)) return false;
	elem.prop("value", answer_val);
	setAnswered(answer_val);
	return true;
}
function checkAnswerLenght(elem) {
	answer_val = elem.prop("value");
	if(answer_val.length >= 8) return false;
	elem.prop("value", answer_val);
	return true;
}

function checkAnswerValidation(elem) {
	answer_val = parseInt(elem.prop("value"));
	correct_answer = 0;
	if( step_count_row1 == getDigitsCouunt(randomNumber1) + 1){
		for( i = 0; i < sub_step_Value.length - 1; i++){
			// console.log("sub_step_Value.length = "+ sub_step_Value.length);

			correct_answer += sub_step_Value[i+1] * digits(i);
		}
		correct_answer *= digits(step_count_row2-1);

		// console.log("correct_answer = "+ correct_answer);

		sub_result_Value[ step_count_row2] = correct_answer;
	}
	else{
		var val1 = getDigitNum(randomNumber1, step_count_row1) * 1;
		var val2 = getDigitNum(randomNumber2, step_count_row2) * 1;
		correct_answer = val1 * val2;
		if(carry_over) correct_answer += carry_over_value;

	}
	if( IsFinish){
		correct_answer = 0;
		for( i = 0; i < sub_result_Value.length - 1; i++){
			correct_answer += sub_result_Value[i+1];
		}
	}
	if (answer_val == correct_answer){
		carry_over = false;
		return correct_answer;	
	} 
	if(retry_attempt > 1){
		// alert("Correct Answer is " + correct_answer + ". Retry! ");
		alertModal("Correct Answer is " + correct_answer + ". Retry. "); //added
		retry_attempt = 0;
		return -3;
	}
	if (answer_val > correct_answer) {
		if (!arry_tempanswer[total_step]) {
			arry_tempanswer[total_step] = answer_val;
		}
		return -1;
	}else{
		if (!arry_tempanswer[total_step]) {
			arry_tempanswer[total_step] = answer_val;
		}
		return -2;
	}
}

/////////////////????????????????????????/////////////////////////
function gotoNextLevel() {
	carry_elem_value = parseInt(carry_elem.prop("value")) % 10;
	carry_elem.prop("value", carry_elem_value);
	generateAnswerStep();
}

function displayQuestions( isAnswer, nRow1, nRow2, elemBefore){
	result = "";
	if( nRow1 <= 0 || nRow1 > getDigitsCouunt(randomNumber1)){
		result = "<p class='functionVal mul_num1' align=right style='width:150px;'>";
	}
	else
		result = "<p class='functionVal' align=right style='width:150px;'>";
	nRow1 = nRow1 * 1; nRow2 = nRow2 * 1;
	for(k=getDigitsCouunt(randomNumber1); k >= 1; k--){
		if( k == nRow1){
			buf = isAnswer ? carry_over_All_Values_Correct[nRow2][k] : carry_over_All_Values_Real[nRow2][k];
			// console.log(isAnswer + ":" + buf);
			if( buf)
				result += "<span class='carry_num'>" + buf + "</span>";
			result += "<span class='mul_num2'>" + getDigitNum(randomNumber1, k) + "</span>";
		} else{
			result += " " + getDigitNum(randomNumber1, k);
		}
	}
	result += "</p>";
	$(result).insertBefore(elemBefore);
	if( nRow2 == 0 || nRow2 > getDigitsCouunt(randomNumber2))
		result = "<p class='under_line functionVal mul_num2' align=right style='width:150px;'> x  ";
	else
		result = "<p class='under_line functionVal' align=right style='width:150px;'> x  ";

	for(k=getDigitsCouunt(randomNumber2); k >= 1; k--){
		if( k == nRow2){
			result += "<span class='mul_num2'> " + getDigitNum(randomNumber2, k) + " </span>";
		}
		else{
			result += getDigitNum(randomNumber2, k) + " ";	
		}
	}
	result += "</p>";
	$(result).insertBefore(elemBefore);
}
//display prev results 
function displayPrevValue( isAnswer, nRow1, nRow2, elemBefore){
	nBuff = nRow2 < getDigitsCouunt(randomNumber2) ? nRow2: getDigitsCouunt(randomNumber2);
	for( k = 1; k <= nBuff-1; k ++){
		var subPrevResult = sub_result_Value[k];
		if(isAnswer)
			subPrevResult = randomNumber1 * getDigitNum(randomNumber2, k) * digits(k-1);
		if( subPrevResult != sub_result_Value[k])
			result = "<p class='functionVal' align=right style='width:150px; color:red;'>";
		else
			result = "<p class='functionVal' align=right style='width:150px;'>";
		if( subPrevResult == 0)
			result += "0 ";
		for(l=getDigitsCouunt(subPrevResult); l >= 1; l--){
			result += getDigitNum(subPrevResult, l) + " ";	
		}
		result += "</p>";
		$(result).insertBefore(elemBefore);
	}

	if( nRow1 < 0){
		result = "<p class='functionVal' align=right style='width:150px;'>"
		for( k = -1; k >= nRow1; k--)
			result += " 0";
		result += "</p>";
		$(result).insertBefore(elemBefore);
		return;
	}
}
function displayCurrValue( isAnswer, nRow1, nRow2, elemBefore){
	var cur_Disp_val;
	if( !isAnswer){
		cur_Disp_val = sub_result_Value[nRow2 - 1];
	}
	else
		cur_Disp_val = randomNumber1 * getDigitNum(randomNumber2, nRow2 - 1) * digits(nRow2 - 2);
	var result;
	if ( isAnswer) {
		var bFinal = false;
		if (nRow2 == getDigitsCouunt(randomNumber2)+1 && nRow2 > 1) {
			bFinal = true;
			result = "<p class='functionVal under_line' align=right style='width:150px;'>+  ";
		}
		else
			result = "<p class='functionVal' align=right style='width:150px;'>";
		for(k=getDigitsCouunt(cur_Disp_val); k >= 1; k--){
			if( bFinal == false)
				if( k > nRow1 - 1)continue;
			result += getDigitNum(cur_Disp_val, k) + " ";	
		}
		result += "</p>";
	}
	else{
		if (nRow2 == getDigitsCouunt(randomNumber2)+1 && nRow2 > 1) {
			result = "<p class='functionVal under_line' align=right style='width:150px;'>+  ";
		}
		else
			result = "<p class='functionVal' align=right style='width:150px;'>";
		for(k=getDigitsCouunt(cur_Disp_val); k >= 1; k--){
			result += getDigitNum(cur_Disp_val, k) + " ";
		}
		result += "</p>";
	}
	$(result).insertBefore(elemBefore);
}
function displayFunction(IsShowCarry, nRow1, nRow2, elemBefore){
	isAnswer = IsShowCarry;
	displayQuestions( isAnswer, nRow1, nRow2, elemBefore);
	displayPrevValue( isAnswer, nRow1, nRow2, elemBefore);
	if( nRow1 != 0)
		displayCurrValue( isAnswer, nRow1, nRow2, elemBefore);
}
function displayCurrValue1( isAnswer, nRow1, nRow2, elemBefore){
	var cur_Disp_val;
	if( !isAnswer){
		if( nRow2 == getDigitsCouunt(randomNumber2) + 1)
			cur_Disp_val = sub_result_Value[nRow2 - 1];
		else
			cur_Disp_val = sub_result_Value[nRow2];
	}
	else{
		if( nRow2 == getDigitsCouunt(randomNumber2) + 1)
			cur_Disp_val = randomNumber1 * getDigitNum(randomNumber2, nRow2 - 1) * digits(nRow2 - 2);
		else
			cur_Disp_val = randomNumber1 * getDigitNum(randomNumber2, nRow2) * digits(nRow2 - 1);
	}
	result = "";

	if ( isAnswer) {
		var bFinal = false;
		if (nRow2 == getDigitsCouunt(randomNumber2)+1 && nRow2 > 1) {
			bFinal = true;
			result = "<p class='functionVal under_line' align=right style='width:150px;'>+  ";
		}
		else
			result = "<p class='functionVal' align=right style='width:150px;'>";
		for(k = nRow1 + nRow2 - 1; k >= 1; k--){
			if( getDigitsCouunt(cur_Disp_val) < k)continue;
			result += getDigitNum(cur_Disp_val, k) + " ";	
		}
		result += "</p>";
	}
	else{
		if (nRow2 == getDigitsCouunt(randomNumber2)+1 && nRow2 > 1) {
			result = "<p class='functionVal under_line' align=right style='width:150px;'>+  ";
		}
		else
			result = "<p class='functionVal' align=right style='width:150px;'>";
		for(k = nRow1 + nRow2 - 1; k >= 1; k--){
			if( getDigitsCouunt(cur_Disp_val) < k)continue;
			result += getDigitNum(cur_Disp_val, k) + " ";
		}
		result += "</p>";
	}
	$(result).insertBefore(elemBefore);
}
function displayFunction1(IsShowCarry, nRow1, nRow2, elemBefore){
	isAnswer = IsShowCarry;
	displayQuestions( isAnswer, nRow1, nRow2, elemBefore);
	displayPrevValue( isAnswer, nRow1, nRow2, elemBefore);
	if( nRow1 != -1)
		displayCurrValue1( isAnswer, nRow1, nRow2, elemBefore);
}
function checkTotal() {
	carry_over_All_Values_Correct[step_count_row2] = carry_over_Step_Values_Correct;
	carry_over_All_Values_Real[step_count_row2] = carry_over_Step_Values_Real;
	step_count_row1 = 0;
	step_count_row2 ++;
	carry_over_Step_Values_Correct = [];
	carry_over_Step_Values_Real = [];
	carry_over_value = 0;
	sub_step_Value = [];
	if( step_count_row2 == getDigitsCouunt(randomNumber2)+1){
		IsFinish = true;
		displayFunction(false, getDigitsCouunt(randomNumber1)+1, step_count_row2, "#lastDiv");
		generateAnswerStep();
		return true;
	}
	// console.log("checkTotal");
	displayFunction( false, step_count_row1, step_count_row2, "#lastDiv");
	return false;
}

function generateAnswerStep() {
	retry_attempt = 0;

	$(".answer_value").unbind("keydown").removeClass("inputCheck").attr("readonly", true);
	total_step ++;
	if( step_count_row2 >= 2 && step_count_row1 == 0 && step_count_row2 <= getDigitsCouunt(randomNumber2)){
		var strHtml = "<p>Step " + (total_step) + ": Add ";
		for( i = 0; i < step_count_row2 - 1; i ++){
			strHtml += "0";
		}
		strHtml += " in Row 2 in the " + step_words[step_count_row2 - 1] + " place</p>";
		$(strHtml).insertBefore("#lastDiv");
		displayFunction( false, step_count_row1, step_count_row2, "#lastDiv");
		strHtml = "<p align=right style='width:150px'>";
		for( i = 0; i < step_count_row2 - 1; i++)
		strHtml += "0 ";
		strHtml += "</p>";
		$(strHtml).insertBefore("#lastDiv");
  		total_step++;
	}
	if( step_count_row2 > getDigitsCouunt(randomNumber2)){
		var strHtml = "<p>Step " + total_step + ": Add ";
		for( i = 1; i < step_count_row2; i++){
			if( i == 1)
				strHtml += "Result #" + i;
			else
				strHtml += " and Result #" + i;
		}
		strHtml += "</p>";
		$(strHtml).insertBefore("#lastDiv");
	}
	if( IsFinish){
		$("<p>Answer</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
	}
	else{
		if(step_count_row1 >= getDigitsCouunt(randomNumber1))
			$("<p>Step " + (total_step) + ": Result#"+ (step_count_row2) +": What is the result?</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
		else {

			if (carry_over == true) {
				$("<p>Step " + (total_step) + ": Multiple Row2 " + step_words[step_count_row2 - 1] + " x The Row 1 " + step_words[step_count_row1]+ " + " + carry_over_value + " carried over.</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");	
			}else{
				$("<p>Step " + (total_step) + ": Multiple Row2 " + step_words[step_count_row2 - 1] + " x The Row 1 " + step_words[step_count_row1]+ ".</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
			}			
		}
	}
	$(".inputCheck").keydown(function(event){
		if(event.keyCode == 13){
			if(checkAnswer($(this)) == false){
				// alert("Answer can't be alphabet !");
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry."); //added
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}

			if(checkAnswerLenght($(this)) == false){
				// alert(" The answer is not this large. Retry !");
				alertModal("The answer is not this large. Please retry."); //added
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			temp_answer = checkAnswerValidation($(this));
			if(temp_answer == -1){
				// alert("Your answer is larger than what we need.");
				alertModal("Your answer is larger than what we need."); //added
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(temp_answer == -2){
				// alert("opps not enough, your answer needs to be larger.");
				alertModal("Oops not enough, your answer needs to be larger."); //added
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(temp_answer == -3){
				$(this).prop("value", "").focus();
				return false;
			}
			if(step_count_row1 > getDigitsCouunt(randomNumber1)){
				if(checkTotal())
					return;
				temp_answer = 0;
				generateAnswerStep();
				return;
			}
			if( IsFinish){
				answerDone(); //ADDED
				displayTotalFlow();
				displayTotalFlow1();
				$(this).blur();
				return;
			}
			if(temp_answer < 10) {
				sub_step_Value[step_count_row1] = temp_answer;
				carry_over_value = 0;
                carry_over_Step_Values_Correct[step_count_row1] = 0;
                carry_over_Step_Values_Real[step_count_row1] = 0;
				if(step_count_row1 > 1){
					if( temp_answer + carry_over_Step_Values_Correct[step_count_row1 - 1] >= 10 && carry_over_Step_Values_Correct[step_count_row1 - 1] != carry_over_Step_Values_Real[step_count_row1 - 1])
						carry_over_Step_Values_Correct[step_count_row1] = 1;
				}
				generateAnswerStep();
			}
			else {
				carry_over_value = parseInt(temp_answer / 10);
				sub_step_Value[step_count_row1] = temp_answer % 10;
				sub_step_Value[step_count_row1 + 1] = carry_over_value;
				carry_over_Step_Values_Correct[step_count_row1] = carry_over_value;
				carry_over_Step_Values_Real[step_count_row1] = carry_over_value;
				if(step_count_row1 > 1 && carry_over_Step_Values_Correct[step_count_row1 - 1] != carry_over_Step_Values_Real[step_count_row1 - 1]){
					carry_over_Step_Values_Correct[step_count_row1] = parseInt((temp_answer + carry_over_Step_Values_Correct[step_count_row1 - 1]) / 10);
				}
				carry_elem = $(this);
				carry_elem.blur();
				// $("#myModal").show();
                carryOneModal("Do you need to carry " + carry_words[carry_over_value - 1] + " over?"); //added

				// $("#number_count").html(carry_words[carry_over_value - 1]);
				// $("#question_b2").show();
			}
		}
	}).focus();
	step_count_row1++;
}

function startAnswer() {
	if($(".answer_value").length == 0) {
 	 	displayFunction(false, 0, 1, "#lastDiv");
 	 	generateAnswerStep();
	}
}


function startOnclick(){
	for (var i = 0; i < getDigitsCouunt(randomNumber1); i++) {

		first_ones = randomNumber1 % 10;
        sec_ones = randomNumber2 % 10;

		randomNumber1 = parseInt((randomNumber1 - randomNumber1 % 10) / 10);
		randomNumber2 = parseInt((randomNumber2 - randomNumber2 % 10) / 10);
	}

	document.getElementById('message_modal_dynamic').style.display = "block";
}

function btnYEsOnclick(){
	carry_over = true;
	$("#message_modal_dynamic").hide();
	$("<p>Carry " + carry_over_Step_Values_Real[step_count_row1] + "</p>").insertBefore("#lastDiv");
	gotoNextLevel();
}

function btnNOOnclick(){
	// console.log("btn no clicked");
	carry_over_Step_Values_Real[step_count_row1] = 0;
	sub_step_Value[step_count_row1+1] = 0;
	carry_over = false;
	$("#message_modal_dynamic").hide();
	gotoNextLevel();
}

function btnNOOnclose() {
	$("#message_modal_dynamic").hide();
}


function displayTotalFlow(){
 	diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
	result = "<p class='mul_num1' align=right style='width:150px;'>";

	for(k=getDigitsCouunt(randomNumber1); k >= 1; k--){
		result += getDigitNum(randomNumber1, k) + " ";
	}
	result += "</p>";
	$(result).insertBefore("#lastDiv2");

	result = "<p class='under_line mul_num1' align=right style='width:150px;'> x ";
	if(diff_space > 0) result += "  ";

	for(k=getDigitsCouunt(randomNumber2); k >= 1; k--){
		result += getDigitNum(randomNumber2, k) + " ";
	}
	result += "</p>";
	$(result).insertBefore("#lastDiv2");
	var steps = 0;
	var step_values = [];
	for(j = 1; j <= getDigitsCouunt(randomNumber2); j++){
		if( j > 1){
			steps++;
			result = "<p align=left style='text-indent:10px;'>";
			result += "Step " + steps + " : Add ";
			for( k = 1; k < j; k++)
				result += "0";
			result += " in Row" + j + "</p>";
			$(result).insertBefore("#lastDiv2");
			displayFunction1( false, 0, j, "#lastDiv2");
		}
	   	for(i = 1; i <= getDigitsCouunt(randomNumber1); i++){
    		steps++;
    		result = "<p align=left style='text-indent:10px;'>";
    		// console.log("carry_over_Step_Values_Real["+j+"]["+(i+1)+"] = "+ carry_over_All_Values_Real[j][i-1]);
    		if (carry_over_All_Values_Real[j][i-1]*1 !== 0 && i > 1) {
				result += "Step " + steps + " : Multiple Row2 " + step_words[j - 1] + " x The Row 1 " + step_words[i - 1] + " + " + carry_over_All_Values_Real[j][i-1] + " carried over"+"</p>";		
			}else{
				result += "Step " + steps + " : Multiple Row2 " + step_words[j - 1] + " x The Row 1 " + step_words[i - 1] + ".</p>";	
			}
			if (arry_tempanswer[steps]) {
				result += "<label style='color:red;'> error : " + arry_tempanswer[steps] + "</label>";
			}
    		$(result).insertBefore("#lastDiv2");

	 	 	diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
	 	 	displayFunction1( false, i, j, "#lastDiv2");
    	}
    	steps++;
    	result = "<p align=left style='text-indent:10px;'>";
    	result += "Step " + steps + " : Result # " + j + "<br>";
    	result += sub_result_Value[j] +"</p>";
    	$(result).insertBefore("#lastDiv2");
	}
	steps++;
	var strHtml = "<p>Step " + steps + ":  Add ";
	for( i = 0; i < step_count_row2 - 1; i++){
		if( i > 0) strHtml += " and "
		strHtml += "Result #" + (i+1);
	}
	strHtml += "</p>";
	$(strHtml).insertBefore("#lastDiv2");
	displayFunction1(false, getDigitsCouunt(randomNumber1)+1, getDigitsCouunt(randomNumber2)+1, "#lastDiv2");
	result = "<p align=left style='text-indent:10px;'>Answer:</p>";
	var resultVal = 0;
	for( i = 0; i < step_count_row2 - 1; i++){
		resultVal += sub_result_Value[i + 1];
	}
	result += "<p align=left style='text-indent:20px;'>" + resultVal + "</p>";

	$("#lastDiv2").html(result);	
}

function displayTotalFlow1(){
 	diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
	result = "<p class='mul_num1' align=right style='width:150px;'>";

	for(k=getDigitsCouunt(randomNumber1); k >= 1; k--){
		result += getDigitNum(randomNumber1, k) + " ";
	}
	result += "</p>";
	$(result).insertBefore("#lastDiv3");

	result = "<p class='under_line mul_num1' align=right style='width:150px;'> x ";
	if(diff_space > 0) result += "  ";

	for(k=getDigitsCouunt(randomNumber2); k >= 1; k--){
		result += getDigitNum(randomNumber2, k) + " ";
	}
	result += "</p>";
	$(result).insertBefore("#lastDiv3");
	var steps = 0;
	var step_values = [];
	for(j = 1; j <= getDigitsCouunt(randomNumber2); j++){
		if( j > 1){
			steps++;
			result = "<p align=left style='text-indent:10px;'>";
			result += "Step " + steps + " : Add ";
			for( k = 1; k < j; k++)
				result += "0";
			result += " in Row" + j + "</p>";
			$(result).insertBefore("#lastDiv3");
			displayFunction1( true, -j+1, step_count_row2, "#lastDiv3");
		}
	   	for(i = 1; i <= getDigitsCouunt(randomNumber1); i++){
    		steps++;
    		result = "<p align=left style='text-indent:10px;'>";
    		if (carry_over_All_Values_Real[j][i-1]*1 !== 0 && i > 1) {
				result += "Step " + steps + " : Multiple Row2 " + step_words[j - 1] + " x The Row 1 " + step_words[i - 1] + " + " + carry_over_All_Values_Real[j][i-1] + " carried over"+"</p>";		
			}else{
				result += "Step " + steps + " : Multiple Row2 " + step_words[j - 1] + " x The Row 1 " + step_words[i - 1] + ".</p>";	
			}
			$(result).insertBefore("#lastDiv3");

	 	 	diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
	 	 	displayFunction1( true, i, j, "#lastDiv3");
    	}
    	steps++;
    	result = "<p align=left style='text-indent:10px;'>";
    	result += "Step " + steps + " : Result # " + j + "<br>";
    	result += randomNumber1 * getDigitNum(randomNumber2, j) * digits(j-1) +"</p>";
    	$(result).insertBefore("#lastDiv3");
	}
	steps++;
	var strHtml = "<p>Step " + steps + ":  Add ";
	for( i = 0; i < step_count_row2 - 1; i++){
		if( i > 0) strHtml += " and "
		strHtml += "Result #" + (i+1);
	}
	strHtml += "</p>";
	$(strHtml).insertBefore("#lastDiv3");
	displayFunction1(true, getDigitsCouunt(randomNumber1)+1, getDigitsCouunt(randomNumber2)+1, "#lastDiv3");
	result = "<p align=left style='text-indent:10px;'>Answer:</p>";
	result += "<p align=left style='text-indent:20px;'>" + randomNumber1 * randomNumber2 + "</p>";

	$("#lastDiv3").html(result);	
}