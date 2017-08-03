/**
 * Code from client
 * 20170727
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
    $("#message_text_modal").html(message);
    $("#message_modal_dynamic").show();
    $("#close_modal").show();
    $("#yes_modal").hide();
    $("#no_modal").hide();
}

function carryOneModal(message){
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
	// randomNumber1 = 27;
	// randomNumber2 = 56;

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
		// alert("Correct Answer is " + correct_answer + ". Retry! "); //removed
		alertModal("Correct Answer is " + correct_answer + ". Retry! "); //added
		retry_attempt = 0;
		if (!arry_tempanswer[total_step]) {
			arry_tempanswer[total_step] = answer_val;
			// console.log("arry_tempanswer[total_step] = " + arry_tempanswer[total_step]);
		}
		return -3;
	}
	if (answer_val > correct_answer) {
		if (!arry_tempanswer[total_step]) {
			arry_tempanswer[total_step] = answer_val;
			// console.log("arry_tempanswer[total_step] = " + arry_tempanswer[total_step]);
		}
		return -1;
	}else {
		if (!arry_tempanswer[total_step]) {
			arry_tempanswer[total_step] = answer_val;
			// console.log("arry_tempanswer[total_step] = " + arry_tempanswer[total_step]);
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
////////////////////////
function displayFunction(IsShowCarry, nRow1, nRow2, elemBefore){
	//Display mul_num1
	result = "";
	if( nRow1 <= 0 || nRow1 > getDigitsCouunt(randomNumber1)){
		result = "<p class='functionVal mul_num1' align=right style='width:150px;'>";
	}
	else
		result = "<p class='functionVal' align=right style='width:150px;'>";
	nRow1 = nRow1 * 1; nRow2 = nRow2 * 1;
	for(k=getDigitsCouunt(randomNumber1); k >= 1; k--){
		if( IsShowCarry){
			if( k == nRow1){
				if(carry_over_All_Values_Correct[nRow2][k]){
					result += "<span class='carry_num'>" + carry_over_All_Values_Correct[nRow2][k] + "</span>";
				}
				result += "<span class='mul_num2'>" + getDigitNum(randomNumber1, k) + "</span>";
			} else{
				result += " " + getDigitNum(randomNumber1, k);
			}
		} else{
			result += " " + getDigitNum(randomNumber1, k);
		}
	}
	result += "</p>";
	$(result).insertBefore(elemBefore);
	//Display mul_num2
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
	//display prev results 
	nBuff = nRow2 < getDigitsCouunt(randomNumber2) ? nRow2: getDigitsCouunt(randomNumber2);
	for( k = 1; k <= getDigitsCouunt(randomNumber2)-1; k ++){
		if(IsShowCarry)break;
		var subPrevResult = sub_result_Value[k];//randomNumber1 * getDigitNum(randomNumber2, k - 1) * digits(k-2);
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
	//Display curr results
	if( nRow2 >= 1 && nRow1 >= 1 && !IsShowCarry){
		var cur_Disp_val = randomNumber1 % digits(nRow1-1);
		cur_Disp_val *= getDigitNum(randomNumber2, nRow2-1);
		if( nRow2 > 2)
			cur_Disp_val *= digits(nRow2-2);
		if (nRow2 == getDigitsCouunt(randomNumber2)+1 && nRow2 > 1) {
			result = "<p class='functionVal under_line' align=right style='width:150px;'>+ ";
		}
		else
			result = "<p class='functionVal' align=right style='width:150px;'>";
		for(k=getDigitsCouunt(cur_Disp_val); k >= 1; k--){
			// if( k==getDigitsCouunt(cur_Disp_val)-1){
			// 	console.log("getDigitsCouunt(cur_Disp_val) = " +getDigitsCouunt(cur_Disp_val));
			// 	if(carry_over_All_Values_Correct[nRow2-1][k]){
			// 		continue;
			// 	}
			// }
			result += getDigitNum(cur_Disp_val, k) + " ";
		}
		result += "</p>";
		$(result).insertBefore(elemBefore);
	}
	if( IsShowCarry){
		var cur_Disp_val = randomNumber1 % digits(nRow1);
		cur_Disp_val *= getDigitNum(randomNumber2, nRow2);
		cur_Disp_Buff = cur_Disp_val;
		if( nRow2 > 1)
			cur_Disp_val *= digits(nRow2-1);
		if (nRow2 == getDigitsCouunt(randomNumber2)+1 && nRow2 > 1) {
			result = "<p class='functionVal under_line' align=right style='width:150px;'>+  ";
		}
		else
			result = "<p class='functionVal' align=right style='width:150px;'>";
		for(k=getDigitsCouunt(cur_Disp_val); k >= 1; k--){
			if( k==getDigitsCouunt(cur_Disp_val)){
				if(carry_over_All_Values_Correct[nRow2][getDigitsCouunt(cur_Disp_Buff) - 1]){
					continue;
				}
			}
			result += getDigitNum(cur_Disp_val, k) + " ";
		}
		result += "</p>";
		$(result).insertBefore(elemBefore);
	}
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
	displayFunction( false, 0, step_count_row2-1, "#lastDiv");
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
		displayFunction( false, -step_count_row2+1, step_count_row2, "#lastDiv");
			//<input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
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
			$("<p style='margin-top: 20px;'>Step " + (total_step) + ": Result#"+ (step_count_row2) +": What is the result?</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
		else{
			// if (true) {}
			// console.log("total_step = " + total_step);
			// console.log("step_count_row2 = " + step_count_row2);
			if (total_step > 1) {
				$("<p style='margin-top: 20px;'>Step " + (total_step) + ": Multiply Row2 " + step_words[step_count_row2 - 1] + " x The Row 1 " + step_words[step_count_row1]+ " + " + carry_over_value + " carried over.</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
			}else{
				$("<p style='margin-top: 20px;'>Step " + (total_step) + ": Multiply Row2 " + step_words[step_count_row2 - 1] + " x The Row 1 " + step_words[step_count_row1]+ "</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
			}
			
		}
	}
	$(".inputCheck").keydown(function(event){
		if(event.keyCode == 13){
			if(checkAnswer($(this)) == false){
				// alert("Answer can't be alphabet !"); //removed
                alertModal("Answer can't be alphabet !"); //added
				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			temp_answer = checkAnswerValidation($(this));
			if(temp_answer == -1){
				// alert("Your answer is larger than what we need."); //removed
				alertModal("Your answer is larger than what we need."); //added

				$(this).prop("value", "").focus();
				retry_attempt++;
				return false;
			}
			if(temp_answer == -2){
				// alert("opps not enough, your answer needs to be larger."); //removed
				alertModal("opps not enough, your answer needs to be larger."); //added
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
				// console.log("carry_over_value = "+ carry_over_value);
			
				sub_step_Value[step_count_row1] = temp_answer % 10;
				sub_step_Value[step_count_row1 + 1] = carry_over_value;
				carry_over_Step_Values_Correct[step_count_row1] = carry_over_value;
				carry_over_Step_Values_Real[step_count_row1] = carry_over_value;
				if(step_count_row1 > 1 && carry_over_Step_Values_Correct[step_count_row1 - 1] != carry_over_Step_Values_Real[step_count_row1 - 1]){
					carry_over_Step_Values_Correct[step_count_row1] = parseInt((temp_answer + carry_over_Step_Values_Correct[step_count_row1 - 1]) / 10);
				}

				carry_elem = $(this);
				carry_elem.blur();
				// $("#myModal").show(); //removed
                carryOneModal("Do you need to carry the " + carry_words[carry_over_value - 1] + " over?"); //added

				// $("#number_count").html(carry_words[carry_over_value - 1]); //removed
				// $("#question_b2").show(); //removed
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
//	var large_num = randomNumber1;// > randomNumber2 ? randomNumber1 : randomNumber2;
//	getDigitsCouunt(randomNumber1) = getDigitsCouunt(large_num);
	for (var i = 0; i < getDigitsCouunt(randomNumber1); i++) {

		first_ones = randomNumber1 % 10;
        sec_ones = randomNumber2 % 10;

		randomNumber1 = parseInt((randomNumber1 - randomNumber1 % 10) / 10);
		randomNumber2 = parseInt((randomNumber2 - randomNumber2 % 10) / 10);
	}

	document.getElementById('message_modal_dynamic').style.display = "block";
}

function btnYEsOnclick(){
//	carr_over_var[step_count_row1 - 1] = true;
//	carr_over_var2[step_count_row1 - 1] = true;
	carry_over = true;
	$("#message_modal_dynamic").hide();
	$("<p style='margin-top: 10px;'>Carry " + carry_over_Step_Values_Real[step_count_row1] + "</p>").insertBefore("#lastDiv");
	gotoNextLevel();
}

function btnNOOnclick(){
//	carry_over_Step_Values_Correct[step_count_row1] = 0;
	carry_over_Step_Values_Real[step_count_row1] = 0;
	sub_step_Value[step_count_row1] = 0;
//	carr_over_var2[step_count_row1 - 1] = true;
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
			displayFunction( false, -j+1, step_count_row2, "#lastDiv2");
		}
	   	for(i = 1; i <= getDigitsCouunt(randomNumber1); i++){
    		steps++;
    		result = "<p align=left style='text-indent:10px;'>";
    		if (steps > 1) {
    			result += "Step " + steps + " : Multiply Row2 " + step_words[j - 1] + " x The Row 1 " + step_words[i - 1] + " + " + carry_over_All_Values_Correct[j][i] + " carried over"+"</p>";	
    			if (arry_tempanswer[steps]) {
    				result += "<label style='color:red;'> error : " + arry_tempanswer[steps] + "</label>";
    			}
    		}else{
    			result += "Step " + steps + " : Multiply Row2 " + step_words[j - 1] + " x The Row 1 " + step_words[i - 1] + "</p>";	
    			if (arry_tempanswer[steps]) {
    				result += "<label style='color:red;'> error : " + arry_tempanswer[steps] + "</label>";
    			}
    		}
    		
    		$(result).insertBefore("#lastDiv2");

	 	 	diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
	 	 	displayFunction( true, i, j, "#lastDiv2");
    	}
    	steps++;
    	result = "<p align=left style='text-indent:10px;'>";
    	result += "Step " + steps + " : Result # " + j + "<br>";
    	result += randomNumber1 * getDigitNum(randomNumber2, j) * digits(j-1) +"</p>";
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
	displayFunction(false, getDigitsCouunt(randomNumber1)+1, getDigitsCouunt(randomNumber2)+1, "#lastDiv2");
	result = "<p align=left style='text-indent:10px;'>Answer:</p>";
	result += "<p align=left style='text-indent:20px;'>" + randomNumber1 * randomNumber2 + "</p>";

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
			displayFunction( false, -j+1, step_count_row2, "#lastDiv3");
		}
	   	for(i = 1; i <= getDigitsCouunt(randomNumber1); i++){
    		steps++;
    		result = "<p align=left style='text-indent:10px;'>";
    		if (steps > 1) {
    			result += "Step " + steps + " : Multiply Row2 " + step_words[j - 1] + " x The Row 1 " + step_words[i - 1] + " + " + carry_over_All_Values_Correct[j][i] + " carried over"+"</p>";	
    		}else{
    			result += "Step " + steps + " : Multiply Row2 " + step_words[j - 1] + " x The Row 1 " + step_words[i - 1] + "</p>";	
    		}
    		$(result).insertBefore("#lastDiv3");

	 	 	diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
	 	 	displayFunction( true, i, j, "#lastDiv3");
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
	displayFunction(false, getDigitsCouunt(randomNumber1)+1, getDigitsCouunt(randomNumber2)+1, "#lastDiv3");
	result = "<p align=left style='text-indent:10px;'>Answer:</p>";
	result += "<p align=left style='text-indent:20px;'>" + randomNumber1 * randomNumber2 + "</p>";

	$("#lastDiv3").html(result);	
}