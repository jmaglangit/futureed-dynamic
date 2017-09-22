var arrQuestion = [
	'What do we need to construct?',
	'How many place values are there?',
	'Which digit would you place in the far left?',
	'Which digit would you place in the far right?',
	'Which digit would you place to the right of digit in Step 3?',
	'Which digit would you place to the right of digit in Step ',
	'What is the number?'
];

var arrAnswer = ['smallest number'];
var arrYourAnswer = [];
var arrYourCorrectAnswer = [];

pos_repeat = 5;
pos_last = 5;

var answered = []; //ADDED

// nerubia code
// start ADDED functions
//getter and setter
function setRandomDigits(digit){
    randomDigits = digit;
}

function getRandomNumber1(){
    return randomNumber;
}

function setRandomNumber1(data){
    randomNumber = data;
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
    $("#lastDiv2").show();
    $("#lastDiv3").show();
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
    $("input").attr("readonly", true);
}

function btnNOOnclose() {
    $("#message_modal_dynamic").hide();
    $("input").attr("readonly", false);
}
// end ADDED functions


function randomDigitsOnclick(){
	$("#answerPane").html('<div id="lastDiv"></div>');
	$("#examPane").show();
	$("#lastDiv2").html("");
	$("#lastDiv3").html("");
    // randomDigits = _validateNum($("#randomDigits").prop("value"), 4);
    if(randomDigits < 3) randomDigits = 3;
    if(randomDigits > 9) randomDigits = 9;
    $("#randomDigits").prop("value", randomDigits);
    
    randomNumber = generateRandomNumber(randomDigits);
    
    $("#randomNumber").prop("value", randomNumber);

    if(arrNum.length > 3){
    	arrQuestion = [
			'What do we need to construct?',
			'How many place values are there?',
			'Which digit would you place in the far left?',
			'Which digit would you place in the far right?',
			'Which digit would you place to the right of digit in Step 3?',
			'Which digit would you place to the right of digit in Step ',
			'What is the number?'
		];
    } else {
    	arrQuestion = [
			'What do we need to construct?',
			'How many place values are there?',
			'Which digit would you place in the far left?',
			'Which digit would you place in the far right?',
			'Which digit would you place to the right of digit in Step 3?',
			'What is the number?'
		];    	
    }
}

function generateCorrectAnswer(){
	arrAnswer = ['smallest number'];
	arrYourAnswer = [];

	_arrNum = [];
	arrAnswer[1] = arrNum.length;
	arrAnswer[2] = arrNum.reduce(function(a, b) { return Math.min(a, b);});
	arrAnswer[3] = arrNum.reduce(function(a, b) { return Math.max(a, b);});
	_arrNum = arrNum.slice();
	_arrNum.sort(function(a, b){return a-b});
	for(i=1; i<arrNum.length-1; i++)
		arrAnswer[i + 3] = _arrNum[i];
	arrAnswer[arrNum.length + 2] = _arrNum.join("");
}

function generateRandomNumber(randomDigits){
	arrNum = [];
	arrAnswer = ['smallest number'];

	while(arrNum.length < randomDigits){
		if(arrNum.length == 0) randomnumber = Math.floor(Math.random()*9) + 1;
	    else randomnumber = Math.floor(Math.random()*10);
	    if(arrNum.indexOf(randomnumber) > -1) continue;
	    arrNum[arrNum.length] = randomnumber;
	}

	generateCorrectAnswer();

	return arrNum.join("");
}

function startAnswer(){
	if(randomNumber == "") return false;

    $("#subject_number").html(randomNumber);

    $("#answerPane").html(
    	// 'Use these integers and construct the smallest number possible<br><span class="boldStr">'+randomNumber+'</span>' +
		'<div id="lastDiv1"></div>');
    $("#examPane").show();
    $("#lastDiv2").html("");
    $("#lastDiv3").html("");

    step_count = 0;
    real_step_count = 0;
    pos_last = arrNum.length + 1;

    playAnswer();
}

function appendExamPane(strAppend)
{
	$("<br><br><span>Step "+(real_step_count + 1)+": "+strAppend+((real_step_count < pos_repeat)||(real_step_count > pos_last)?"":real_step_count+"?")+"</span><br>").insertBefore("#lastDiv1");
	$("<input type=text class='answerTxt' size=20>").insertBefore("#lastDiv1");
	if(real_step_count == 0) $("<span>(largest number or smallest number)</span>").insertBefore("#lastDiv1");
}

function generateAnswerFlow(){
	$("#lastDiv2").html('Use these integers and construct the smallest number possible<br><span class="boldStr">'+randomNumber+'</span>');
    $("#lastDiv3").html('Use these integers and construct the smallest number possible<br><span class="boldStr">'+randomNumber+'</span>');
	step_count = 0;
	for(real_step_count = 0; real_step_count < pos_last + 2; real_step_count++){
		strHTML = "<br><br><span>Step "+(real_step_count + 1)+": "+arrQuestion[step_count]+((real_step_count < pos_repeat)||(real_step_count > pos_last)?"":real_step_count+"?")+"</span><br>"
		if(real_step_count == pos_last + 1)  strHTML += "<span>The number is </span>";
		strHTML += "<span class='answerSpan'>" + arrYourCorrectAnswer[real_step_count] + "</span>";
		if(real_step_count == 0) strHTML += "<span>(largest number or smallest number)</span>";
		if(arrYourAnswer[real_step_count].toLowerCase() != arrAnswer[real_step_count]){
			if (real_step_count == 0) {
				strHTML += "<p style='color:red;'> Smallest number Error : " + arrYourAnswer[real_step_count] + "</p>";
			}else{
				strHTML += "<p style='color:red;'> Error : " + arrYourAnswer[real_step_count] + "</p>";
			}
		}

		if(real_step_count == 0) strHTML += "<br><span>In this case we need to figure out the smallest number.</span>";
		else if(real_step_count == pos_last + 1) strHTML += "";
		else if(real_step_count == pos_last) strHTML += "<br><span>Final digit is "+arrAnswer[real_step_count]+"</span>";
		else if(real_step_count == 1) strHTML += "<br><span>There are "+arrAnswer[real_step_count]+" digits, hence "+arrNum[0]+" place values into the "+step_words[arrAnswer[real_step_count] - 1]+"</span>";
		else if(real_step_count == 2) {
			strHTML += "<br><span class='toolTopSpan'>First rank your numbers from smallest to largest.</span>";
			strHTML += "<br><span>We know that "+_arrNum.join("<")+"</span>";
			strHTML += "<br><span class='toolTopSpan'>Your strategy when creating the smallest number is to put the smallest number on the far left.</span>";
  			strHTML += "<br><span>In this case the smallest number is "+arrAnswer[real_step_count]+" since "+_arrNum.join("<")+"</span>";
		}
		else if(real_step_count == 3) strHTML += "<br><span class='toolTopSpan'>The largest number goes on the far right, that is "+arrAnswer[real_step_count]+"</span>";
		else if(real_step_count == 4) strHTML += "<br><span>The next digit is "+arrAnswer[real_step_count]+"</span>";

		$("#lastDiv2").html($("#lastDiv2").html() + strHTML);
		if((real_step_count < pos_repeat)||(real_step_count > pos_last - 1)) step_count++;
	}
	generateCorrectAnswerFlow();
}

function generateCorrectAnswerFlow(){
	step_count = 0;
	for(real_step_count = 0; real_step_count < pos_last + 2; real_step_count++){
		strHTML = "<br><br><span>Step "+(real_step_count + 1)+": "+arrQuestion[step_count]+((real_step_count < pos_repeat)||(real_step_count > pos_last)?"":real_step_count+"?")+"</span><br>"
		if(real_step_count == pos_last + 1)  strHTML += "<span>The number is </span>";
		strHTML += "<span class='answerSpan'>" + arrYourCorrectAnswer[real_step_count] + "</span>";
		if(real_step_count == 0) strHTML += "<span>(largest number or smallest number)</span>";
		if(real_step_count == 0) strHTML += "<br><span>In this case we need to figure out the smallest number.</span>";
		else if(real_step_count == pos_last + 1) strHTML += "";
		else if(real_step_count == pos_last) strHTML += "<br><span>Final digit is "+arrAnswer[real_step_count]+"</span>";
		else if(real_step_count == 1) strHTML += "<br><span>There are "+arrAnswer[real_step_count]+" digits, hence "+arrNum[0]+" place values into the "+step_words[arrAnswer[real_step_count] - 1]+"</span>";
		else if(real_step_count == 2) {
			strHTML += "<br><span class='toolTopSpan'>First rank your numbers from smallest to largest.</span>";
			strHTML += "<br><span>We know that "+_arrNum.join("<")+"</span>";
			strHTML += "<br><span class='toolTopSpan'>Your strategy when creating the smallest number is to put the smallest number on the far left.</span>";
  			strHTML += "<br><span>In this case the smallest number is "+arrAnswer[real_step_count]+" since "+_arrNum.join("<")+"</span>";
		}
		else if(real_step_count == 3) strHTML += "<br><span class='toolTopSpan'>The largest number goes on the far right, that is "+arrAnswer[real_step_count]+"</span>";
		else if(real_step_count == 4) strHTML += "<br><span>The next digit is "+arrAnswer[real_step_count]+"</span>";

		$("#lastDiv3").html($("#lastDiv3").html() + strHTML);
		if((real_step_count < pos_repeat)||(real_step_count > pos_last - 1)) step_count++;
	}
}

function playAnswer()
{
	retry_attempt = 0;
	appendExamPane(arrQuestion[step_count]);
	$(".answerTxt").keydown(function(e){
		if(e.keyCode == 13){

			if ($(".answerTxt").prop("value") == "") {
				alertModal("That is incorrect. Answer cannot be blank. Please retry.");
				return;
			}
			arrYourCorrectAnswer[real_step_count] = $(".answerTxt:last").prop("value");
			if(arrYourAnswer.length == real_step_count) arrYourAnswer[real_step_count] = $(".answerTxt:last").prop("value");
			else if(arrYourAnswer[real_step_count] == "") arrYourAnswer[real_step_count] = $(".answerTxt:last").prop("value");
			if(real_step_count == 0){
				if(arrAnswer[real_step_count] != $(".answerTxt:last").prop("value").toLowerCase()){
			    	if( retry_attempt > retry_attempt_limit ) {
			    		retry_attempt = -1;
                        alertModal("The correct answer is " + arrAnswer[real_step_count] + ". Please retry.");
			    	} else {
                        alertModal('That is incorrect. The answer is either largest number or smallest number. Please retry.');
			    	}
			    	retry_attempt++;
			    	$(".answerTxt:last").prop("value", "").focus();
			    	return false;
				}
			} else if(real_step_count == pos_last + 1){
				if(arrAnswer[real_step_count] != $(".answerTxt:last").prop("value")){
			    	if( retry_attempt > retry_attempt_limit ) {
			    		retry_attempt = -1;
                        alertModal("The correct answer is " + arrAnswer[real_step_count] + ". Please retry.");
			    	} else {
                        alertModal("Your answer is incorrect. Please retry.");
			    	}
			    	retry_attempt++;
			    	$(".answerTxt:last").prop("value", "").focus();
			    	return false;
				}
				$(".answerTxt").attr("readonly", true);
				generateAnswerFlow();
                answerDone(); // added
				return false;
			} else {
				chk_answer = validateAnswer4Sort($(".answerTxt:last"), arrAnswer[real_step_count], 0, 9);
				if(chk_answer != 0) return false;
			}
			$(".answerTxt").attr("readonly", true);
			if((real_step_count < pos_repeat)||(real_step_count > pos_last - 1)) step_count++;
			real_step_count++;
			playAnswer();
		}
	}).focus();
}

// Check Validate Answer for alphabet, number range, 0: correct, -1: alphabet, -2: not in number range, -3: less than correct_answer, -4: more than correct_answer
function validateAnswer4Sort(_elem, _correct_answer, __start_num, __end_num) {
	_correct_answer = _validateNum(_correct_answer, 0);

	    	
	_answer = _elem.prop("value");
	if (_answer == "" ) 										return _errorHandler(_elem, -5, "That is incorrect. Answer cannot be blank. Please retry.");
	_answer = parseInt(_elem.prop("value"));

	
	    	
	if(isNaN(_answer))											return _errorHandler(_elem, -1, "That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");

	_elem.prop("value", _answer);
	if((_answer * 1 < __start_num) || (_answer * 1 > __end_num))	{
		if( retry_attempt > retry_attempt_limit ) {
			retry_attempt = 0;										return _errorHandler(_elem, -6, "The correct answer is " + _correct_answer + ". Please retry.");
		}else{
	        return _errorHandler(_elem, -2, "That is incorrect. Answer cannot be less than " + __start_num + " or more than " + __end_num + ". Please retry.");
	    }
    }
    if(_answer < _correct_answer) {
    	if( retry_attempt > retry_attempt_limit ) {
			retry_attempt = 0;									return _errorHandler(_elem, -6,  "The correct answer is " + _correct_answer + ". Please retry.");
		}else{
			return _errorHandler(_elem, -3, "Oops not enough, your answer needs to be larger.");
		}
        
    }                               

    if(_answer > _correct_answer) {
    	if( retry_attempt > retry_attempt_limit ) {
			retry_attempt = 0;									return _errorHandler(_elem, -6, "The correct answer is " + _correct_answer + ". Please retry.");
		}else{
	        return _errorHandler(_elem, -4, "Your answer is larger than what we need.");
	    }
    }

	return 0;
}

function _errorHandler(_elem, _err_num, _err_description) {

	alertModal( _err_description );

	if(_err_num != -6) retry_attempt++;

	_elem.prop("value", "").focus();

	return _err_num;

}