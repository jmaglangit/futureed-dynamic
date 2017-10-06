/**
 * Code from client
 * 20170825
 */


var test_case = true;
var _TEST_NUM1 = 5127;
var _TEST_NUM2 = 242;

var randomNumber1 = "";
var randomNumber2 = "";

var randomNumber1_2 = "";
var randomNumber2_2 = "";

var moving_decimal_count = 1;

var step_count = 0;
var real_step_count = 0;

var dropdown_var = [];
var temp_val = 0;
var remainder_val = 0;
var _remainder_val = 0;

var arry_step_count_temp = [];
var arry_sub_temp = [];
var arry_left_temp = [];
var arry_correctAnswer_temp = [];
var arry_errorTemp1 = [];
var arry_errorTemp2 = [];
var arry_errorTemp3 = [];
var arry_errorTemp4 = [];

_end_num = 9;
_UPPER_LIMIT = 10000;
var answered = []; //ADDED

// start ADDED functions
//getter and setter
function setRandomDigits(digit){
    randomDigits1 = digit;
    randomDigits2 = digit;
}

function getRandomNumber1(){
    return randomNumber1_2;
}

function getRandomNumber2(){
    return randomNumber2_2;
}

function setRandomNumber1(number){
    randomNumber1 = number;
}

function setRandomNumber2(number){
    randomNumber2 = number;
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

function remainderModal(message){
    dynamicBlock();
    $("#message_text_modal").html(message);
    $("#message_modal_dynamic").show();
    $("#close_modal").hide();
    $("#yes_modal").show();
    $("#no_modal").show();
    $("#ok_modal").hide();
}

function closeModal() {
    $("#message_modal_dynamic").hide();
}

function btnNORemainderModal(message){
    dynamicBlock();
    $("#message_text_modal").html(message);
    $("#message_modal_dynamic").show();
    $("#close_modal").hide();
    $("#yes_modal").hide();
    $("#no_modal").hide();
    $("#ok_modal").show();
}

function btnOkRemainderModal() {
    remainderModal("Do you need to bring down the next digit?");
}

// end ADDED functions

function generateDivisionExpr(_num1, _num2, _num3)
{
    strHTML = '<div class="divide_container"><div class="div_num1">' + _num1 + '</div><div class="div_num2">' + _num2 + '<span class="after_char">' + _num3 + '</span></div><div class="clr"></div></div>';
    return strHTML;
}

function randomDigitsOnclick(){
    test_case = true;
    _TEST_NUM1 = 5127;
    _TEST_NUM2 = 242;

    randomNumber1 = "";
    randomNumber2 = "";

    randomNumber1_2 = "";
    randomNumber2_2 = "";

    step_count = 0;
    real_step_count = 4;

    dropdown_var = [];
    temp_val = 0;
    remainder_val = 0;
    _remainder_val = 0;
    moving_decimal_count = 1;

    arry_step_count_temp = [];
    arry_sub_temp = [];
    arry_left_temp = [];
    arry_correctAnswer_temp = [];
    arry_errorTemp1 = [];
    arry_errorTemp2 = [];
    arry_errorTemp3 = [];
    arry_errorTemp4 = [];

    randomDigits = _validateNum($("#randomDigits").prop("value"), 4);
    if(randomDigits > 5) randomDigits = 4;
    $("#randomDigits").prop("value", randomDigits);
    
    randomDigits2 = _validateNum($("#randomDigits2").prop("value"), 3);
    if(randomDigits2 > 4) randomDigits2 = 3;
    $("#randomDigits2").prop("value", randomDigits2);

    randomNumber1 = Math.floor(Math.random() * digits(randomDigits));
    randomNumber2 = Math.floor(Math.random() * digits(randomDigits2));

    if(randomNumber1 < 7) randomNumber1 = 7 + Math.floor(Math.random() * 7);
    if(randomNumber2 < 3) randomNumber2 = 3 + Math.floor(Math.random() * 7);

    if(randomNumber1 < randomNumber2) randomNumber1 = randomNumber2 + Math.floor(Math.random() * 7);
    if(randomNumber2 % 10 == 0) randomNumber2++;

    randomNumber1 = randomNumber1 + randomNumber2 - randomNumber1 % randomNumber2;

    randomNumber2_2 = randomNumber2 / digits(moving_decimal_count);
    randomNumber1_2 = randomNumber1;
    randomNumber1 = randomNumber1 * digits(moving_decimal_count);

    $("#randomNumber1").prop("value", randomNumber1_2);
    $("#randomNumber2").prop("value", randomNumber2_2);
    initStart();
}

function initStart() {
    $("#subject_number1_p").html(randomNumber1_2);
    $("#subject_number2_p").html(randomNumber2_2);

    $("#answerPane").html('<div id="lastDiv"></div>');
    $("#examPane").show();
    $("#lastDiv2").html("");
    $("#lastDiv3").html("");

    step_count = 0;
    real_step_count = 0;

    max_digit = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2) + 1;
    if(max_digit < 1) max_digit = 1;

    temp_val = 0;
    remainder_val = 0;
}

function checkAnswer(elem) {
    answer_val = parseInt(elem.prop("value"));
    if(isNaN(answer_val)) return false;
    elem.prop("value", answer_val);
    setAnswered(answer_val);    //added
    return true;
}

function startAnswer() {
    if($(".answer_value").length == 0) generateAnswerStep();
}

var retry_first_answer = 0;
var retry_second_answer = 0;
var retry_third_answer = 0;

function validateAnswer4Divide(_elem, _correct_answer) {
    _correct_answer = _validateNum(_correct_answer, 0);
    _answer = parseInt(_elem.prop("value"));

    if(isNaN(_answer))                                          return _errorHandler(_elem, -1, "That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");

    _elem.prop("value", _answer);

    if(_answer < _correct_answer) {
        if( retry_attempt > retry_attempt_limit ) {
            retry_attempt = 0;                                      return _errorHandler(_elem, -5, "The correct answer is " + _correct_answer + ". Please retry. ");
        }else{
            return _errorHandler(_elem, -3, "Oops not enough, your answer needs to be larger.");
        }
    }                               

    if(_answer > _correct_answer) {
        if( retry_attempt > retry_attempt_limit ) {
            retry_attempt = 0;                                      return _errorHandler(_elem, -5, "The correct answer is " + _correct_answer + ". Please retry. ");
        }else{
            return _errorHandler(_elem, -4, "Your answer is larger than what we need.");
        }
    }

    return 0;
}

function generateAnswerStep() {
    retry_attempt = 0;
    $(".pre_answer").removeClass("inputCheck").attr("readonly", true);
    if(real_step_count == 0){
        $("<p>Step 1: First let's simplify by moving the decimal point in the divisor to make it a whole fraction.  How many decimal points does this number have?</p><input type=text placeholder='answer' class='pre_answer inputCheck'>").insertBefore("#lastDiv");
        $(".inputCheck").unbind("keydown").keydown(function(event){
            if(event.keyCode == 13) {
                __temp_answer__ = $(this).prop("value");
                correct_answer = moving_decimal_count;
                temp_answer = validateAnswer($(this), correct_answer);
                
                if(temp_answer == 0){
                    real_step_count++;
                    generateAnswerStep();
                }else{
                    if (!arry_errorTemp1[0]) {
                        arry_errorTemp1[0] = __temp_answer__;
                    }
                }
            }
        }).focus();
        return;
    }
    if(real_step_count == 1){
        $("<p>Step 2: Transform "+randomNumber2_2+".  Move the decimal point to the right by the number in Step 1.  What is the new number?</p><input type=text placeholder='answer' class='pre_answer inputCheck'>").insertBefore("#lastDiv");
        $(".inputCheck").unbind("keydown").keydown(function(event){
            if(event.keyCode == 13) {
                __temp_answer__ = $(this).prop("value");
                correct_answer = randomNumber2;
                temp_answer = validateAnswer4Divide($(this), correct_answer);
                
                if(temp_answer == 0){
                    real_step_count++;
                    generateAnswerStep();
                }else{
                    if (!arry_errorTemp1[1]) {
                        arry_errorTemp1[1] = __temp_answer__;
                    }
                }
            }
        }).focus();
        return;
    }
    if(real_step_count == 2){
        $("<p>Step 3: Now transform the dividend in the same way.  What is the new number?</p><input type=text placeholder='answer' class='pre_answer inputCheck'>").insertBefore("#lastDiv");
        $(".inputCheck").unbind("keydown").keydown(function(event){
            if(event.keyCode == 13) {
                __temp_answer__ = $(this).prop("value");
                correct_answer = randomNumber1;
                temp_answer = validateAnswer4Divide($(this), correct_answer);
                
                if(temp_answer == 0){
                    real_step_count++;
                    generateAnswerStep();
                }else{
                    if (!arry_errorTemp1[2]) {
                        arry_errorTemp1[2] = __temp_answer__;
                    }
                }
            }
        }).focus();
        return;
    }
    if(real_step_count == 3){
        $("<p>Step 4:  What is the new equation?</p><input type=text placeholder='answer' class='pre_answer inputCheck'> into <input type=text placeholder='answer' class='pre_answer inputCheck'>").insertBefore("#lastDiv");
        $(".inputCheck").unbind("keydown").keydown(function(event){
            __index__ = $(".inputCheck").index($(this));
            if(event.keyCode == 13) {
                __temp_answer__ = $(this).prop("value");
                if(__index__ == 0)
                    correct_answer = randomNumber2;
                else
                    correct_answer = randomNumber1;
                temp_answer = validateAnswer4Divide($(this), correct_answer);
                
                if(temp_answer == 0){
                    if(__index__ == 0){
                        $(".inputCheck").eq(1).focus();
                    } else {
                        real_step_count++;
                        generateAnswerStep();
                    }
                }else{
                    if(__index__ == 0){
                        if (!arry_errorTemp1[3]) {
                            arry_errorTemp1[3] = __temp_answer__;
                        }   
                    } else {
                        if (!arry_errorTemp2[3]) {
                            arry_errorTemp2[3] = __temp_answer__;
                        }   
                    }
                }
            }
        });
        $(".inputCheck").eq(0).focus();
        return;
    }

    if(step_count >= max_digit) { 
        generateAnswerEquation(real_step_count).insertBefore("#lastDiv");
        checkTotal();
        // ADDED call function view hide
        answerDone();
        return;
    }

    if(step_count == 0) temp_val = (randomNumber1 + "").substring(0, getDigitsCouunt(randomNumber2));
    else temp_val = (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + step_count - 1, getDigitsCouunt(randomNumber2) + step_count);

    if(step_count > 0) 
        generateAnswerEquation(real_step_count).insertBefore("#lastDiv");

    temp_val = temp_val * 1 + remainder_val * 10;

    dropdown_var[step_count] = false;
    $(".answer_value").unbind("keydown").removeClass("inputCheck").attr("readonly", true);

    strHTML = "";
    // strHTML = generateDivisionExpr(randomNumber2, temp_val, (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + step_count));

    if(remainder_val > 0){
        $("<p>Step " + (real_step_count + 1) + ": " + "Drop down the " + step_words[max_digit - step_count - 1] + " digit</p>").insertBefore("#lastDiv");
        real_step_count++;
        generateAnswerEquation(real_step_count).insertBefore("#lastDiv");
    }

    remainder_val = 0;
    retry_first_answer = 0;
    retry_second_answer = 0;
    retry_third_answer = 0;

    $("<p>Step " + (real_step_count + 1) + ": " + ((step_count == 0)?" Begin on far left. ":"") + "Divide the " + step_words[max_digit - step_count - 1] + " digit</p>" + strHTML + "<p>What is the corresponding multiplication?  (Write it out, example "+randomNumber2+"x1)</p><input type=text placeholder='answer' class='first_answer inputCheck'>").insertBefore("#lastDiv");
    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if($(this).hasClass("first_answer")){

                correct_answer = getCorrectAnswer();

                if(($(this).prop("value") != correct_answer + "x" + randomNumber2 + "") && ($(this).prop("value") != "" + randomNumber2 + "x" + correct_answer)) {

                    if(retry_first_answer > 1){
                        retry_first_answer = 0;
                        alertModal("The correct answer is " + randomNumber2 + "x" + correct_answer + ". Please retry. ");
                        retry_attempt = 0;
                                    
                        $(this).prop("value", "");
                        return;
                    } else {
                    
                        retry_first_answer++;
                        alertModal("That is not the correct answer. Remember to use this format " + randomNumber2 + "x4, please retry.");
                        if (!arry_errorTemp1[real_step_count]) {
                            arry_errorTemp1[real_step_count] = $(this).prop("value");
                        }
                        $(this).prop("value", "").focus();

                        return false;
                    }
                }


                $(this).unbind("keydown").removeClass("inputCheck").attr("readonly", true);
                $("<p>What is the subtraction?  (Write it out, example "+temp_val+"-"+randomNumber2+")</p><input type=text placeholder='answer' class='second_answer inputCheck'>").insertBefore("#lastDiv");

                $(".inputCheck").unbind("keydown").keydown(function(event){

                    if(event.keyCode == 13){

                        if($(this).hasClass("second_answer")){

                            if($(this).prop("value") != "" + temp_val + "-" + (randomNumber2 * correct_answer)) {
                                if(retry_second_answer > 1){
                                    retry_second_answer = 0;
                                    alertModal("The correct answer is " + temp_val + "-" + (randomNumber2 * correct_answer) + ". Please retry. ");
                                    retry_attempt = 0;
                                    
                                    $(this).prop("value", "");
                                    return;
                                }else{
                                    retry_second_answer++;
                                    alertModal("That is not the correct answer. Remember to use this format " + temp_val + "-" + randomNumber2 + ", please retry.");
                                    if (!arry_errorTemp2[real_step_count]) {
                                        arry_errorTemp2[real_step_count] = $(this).prop("value");
                                    }
                                    $(this).prop("value", "").focus();
                                    return false;
                                }
                            }

                            $(this).unbind("keydown").removeClass("inputCheck").attr("readonly", true);
                            $("<p>How much is left?</p><input type=text placeholder='answer' class='third_answer inputCheck'>").insertBefore("#lastDiv");

                            $(".inputCheck").unbind("keydown").keydown(function(event){

                                if(event.keyCode == 13) {
                                    if(checkAnswer($(this)) == false){
                                        alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                                        $(this).prop("value", "").focus();
                                        retry_attempt++;
                                        return false;
                                    }
                                    if(checkAnswerLenght($(this)) == false){
                                        alertModal(" The answer is not this large. Please retry.");
                                        $(this).prop("value", "").focus();
                                        retry_attempt++;
                                        return false;
                                    }
                                    
                                    if($(this).prop("value") * 1 > (temp_val - randomNumber2 * correct_answer) * 1) {
                                        if(retry_third_answer > 1){
                                            retry_third_answer = 0;
                                            retry_attempt = 0;
                                            alertModal("The correct answer is " + (temp_val - randomNumber2 * correct_answer) + ". Please retry. ");

                                            $(this).prop("value", "");
                                            return;
                                        }else{
                                            retry_third_answer++;
                                            alertModal("Your answer is larger than what we need.");
                                            if (!arry_errorTemp3[real_step_count]) {
                                                // console.log("how1");
                                                arry_errorTemp3[real_step_count] = $(this).prop("value");
                                            }
                                            $(this).prop("value", "").focus();
                                            return false;
                                        }
                                    } else if($(this).prop("value") * 1 < (temp_val - randomNumber2 * correct_answer) * 1) {
                                        if(retry_third_answer > 1){
                                            retry_third_answer = 0;
                                            retry_attempt = 0;
                                            alertModal("The correct answer is " + (temp_val - randomNumber2 * correct_answer) + ". Please retry. ");

                                            $(this).prop("value", "");
                                            return;
                                        }else{
                                            retry_third_answer++;
                                            alertModal("Oops not enough, your answer needs to be larger.");
                                            if (!arry_errorTemp3[real_step_count]) {
                                                // console.log("how12");
                                                arry_errorTemp3[real_step_count] = $(this).prop("value");
                                            }
                                            $(this).prop("value", "").focus();
                                            return false;
                                        }
                                    }

                                    if($(this).hasClass("third_answer")){
                                        $(this).unbind("keydown").removeClass("inputCheck").attr("readonly", true);
                                        $("<p>What is answer?</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");

                                        $(".inputCheck").unbind("keydown").keydown(function(event){

                                            if(event.keyCode == 13) {

                                                if($(this).hasClass("answer_value")){
                                                    correct_answer = getCorrectAnswer();
                                                    temp_answer = validateAnswer($(this), correct_answer);
                                                    
                                                    if(temp_answer == 0){
                                                        $(this).blur();
                                                        if(remainder_val * 1 > 0) remainderModal('Do you need to bring down the next digit?');
                                                        else generateAnswerStep();
                                                    }else{
                                                        if (!arry_errorTemp4[real_step_count]) {
                                                            // console.log("what");
                                                            arry_errorTemp4[real_step_count] = $(this).prop("value");
                                                        }
                                                    }
                                                }
                                            }
                                        }).focus();
                                    }
                                }
                            }).focus();
                        }
                    }
                }).focus();
            }
        }
    }).focus();
    step_count++;
    real_step_count++;
}

function getCorrectAnswer() {
    correct_answer = parseInt((temp_val - (temp_val % randomNumber2)) / randomNumber2);
    remainder_val = temp_val % randomNumber2;
    return correct_answer;
}

function _getCorrectAnswer() {
    correct_answer = parseInt((_temp_val - (_temp_val % randomNumber2)) / randomNumber2);
    _remainder_val = _temp_val % randomNumber2;
    return correct_answer;
}

function dismissZero(_number) {
    _number = parseInt(_number);
    return _number;
}

function checkTotal() {
    $(".answer_value").unbind("keydown").removeClass("inputCheck").attr("readonly", true);
    $("<input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
    str_answer = "";

    for(i=0; i<$(".answer_value").length; i++)
        str_answer += "" + $(".answer_value").eq(i).prop("value");

    str_answer = dismissZero(str_answer);

    _after_answer = str_answer;
    _after_remainer = "";
    if(remainder_val > 0) _after_remainer = remainder_val;

    if(remainder_val > 0) str_answer += " and remainder " + remainder_val;
    $(".inputCheck").prop("value", str_answer).attr("readonly", true).hide();

    $("<p>Answer : <input type=text class='under_line' placeholder='answer' value='" + _after_answer + "'>").insertBefore("#lastDiv");
//        $("<p>Remainder : <input type=text class='under_line' placeholder='answer' value='" + _after_remainer + "'>").insertBefore("#lastDiv");

    displayTotalFlow();
    displayTotalFlow1();
}

function displayTotalFlow(){
    remainder_val = 0;
    real_step_count = 0;
    result = generateDivisionExpr(randomNumber2_2, randomNumber1_2, "");
    result += "<p>Step 1: First let's simplify by moving the decimal point in the divisor to make it a whole fraction.  How many decimal points does this number have?</p><span class='under_line'>"+moving_decimal_count+"</span>";
    if (arry_errorTemp1[0]) result += "<p style='color:red;'> Error : "+ arry_errorTemp1[0] +"</p>";
    result += "<p>Step 2: Transform "+randomNumber2_2+".  Move the decimal point to the right by the number in Step 1.  What is the new number?</p><span class='under_line'>"+randomNumber2+"</span>";
    if (arry_errorTemp1[1]) result += "<p style='color:red;'> Error : "+ arry_errorTemp1[1] +"</p>";
    result += "<p>Step 3: Now transform the dividend in the same way.  What is the new number?</p><span class='under_line'>"+randomNumber1+"</span>";
    if (arry_errorTemp1[2]) result += "<p style='color:red;'> Error : "+ arry_errorTemp1[2] +"</p>";
    result += "<p>Step 4:  What is the new equation?</p><span class='under_line'>"+randomNumber2+"</span> into <span class='under_line'>"+randomNumber1+"</span>";
    if ((arry_errorTemp1[3]) || (arry_errorTemp2[3])) result += "<p style='color:red;'> Error : "+ ((arry_errorTemp1[3])?arry_errorTemp1[3]:randomNumber2) +" into "+ ((arry_errorTemp2[3])?arry_errorTemp2[3]:randomNumber1) +"</p>";
    real_step_count = 4;
    for(step_count=0; step_count<max_digit; step_count++){
        
        if(remainder_val > 0){
            result += "<p>Step " + (real_step_count + 1) + ": " + "Drop down the " + step_words[max_digit - step_count - 1] + " digit</p>";
            real_step_count++;
            result += generateAnswerEquationColor(real_step_count);
        }

        result += "<p>Step " + (real_step_count + 1) + ": " + ((step_count == 0)?" Begin on far left. ":"") + "Divide the " + step_words[max_digit - step_count - 1] + " digit</p>";
       
        if(remainder_val > 0){
            result += "<p class='detail_step div_notice'>Bring down remainder, add " + step_words[max_digit - step_count - 1] + " digit</p>";
        }

        if(step_count == 0) temp_val = (randomNumber1 + "").substring(0, getDigitsCouunt(randomNumber2));
        else temp_val = (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + step_count - 1, getDigitsCouunt(randomNumber2) + step_count);

        temp_val = temp_val * 1 + remainder_val * 10;

        remainder_val = 0;
        // strHTML = generateDivisionExpr(randomNumber2, temp_val, (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + step_count));
        // result += strHTML;
        result += "<p class='detail_step'>Divide " + temp_val + " by " + randomNumber2 + "</p>";

        result += generateAnswerEquationColor(real_step_count + 1);

        correct_answer = getCorrectAnswer();
        result += "<p class='detail_step'>Multiple " + correct_answer + " x " + randomNumber2 + " = " + (correct_answer * randomNumber2) + "</p>";
         if (arry_errorTemp1[real_step_count+1]) {
            result += "<p style='color:red;'> Error : "+ arry_errorTemp1[real_step_count + 1] +"</p>";
        }
        result += "<p class='detail_step'>Subtract " + temp_val + " - " + (correct_answer * randomNumber2) + " = " + (temp_val - correct_answer * randomNumber2) + "</p>";
        if (arry_errorTemp2[real_step_count + 1]) {
            result += "<p style='color:red;'> Error : "+ arry_errorTemp2[real_step_count + 1] +"</p>";
        }
        if (arry_errorTemp3[real_step_count + 1]) {
            result += "<p style='color:red;'> Error : "+ arry_errorTemp3[real_step_count + 1] +"</p>";
        }
        if (arry_errorTemp4[real_step_count + 1]) {
            result += "<p style='color:red;'> Error : "+ arry_errorTemp4[real_step_count + 1] +"</p>";
        }
        if(remainder_val > 0) 
            result += "<p class='detail_step'>There is a remainder " + remainder_val + "</p>";

        real_step_count++;
    }

    result += "<p align=left style='text-indent:10px;'>Answer:</p>";
    result += "<p align=left style='text-indent:20px;'>" + $(".inputCheck").prop("value") + "</p>";

    $("#lastDiv2").html(result);        
}
function displayTotalFlow1(){
    remainder_val = 0;
    real_step_count = 0;
    result = generateDivisionExpr(randomNumber2_2, randomNumber1_2, "");
    result += "<p>Step 1: First let's simplify by moving the decimal point in the divisor to make it a whole fraction.  How many decimal points does this number have?</p><span class='under_line'>"+moving_decimal_count+"</span>";
    result += "<p>Step 2: Transform "+randomNumber2_2+".  Move the decimal point to the right by the number in Step 1.  What is the new number?</p><span class='under_line'>"+randomNumber2+"</span>";
    result += "<p>Step 3: Now transform the dividend in the same way.  What is the new number?</p><span class='under_line'>"+randomNumber1+"</span>";
    result += "<p>Step 4:  What is the new equation?</p><span class='under_line'>"+randomNumber1+"</span> into <span class='under_line'>"+randomNumber2+"</span>";
    real_step_count = 4;

    for(step_count=0; step_count<max_digit; step_count++){
        
        if(remainder_val > 0){
            result += "<p>Step " + (real_step_count + 1) + ": " + "Drop down the " + step_words[max_digit - step_count - 1] + " digit</p>";
            real_step_count++;
            result += generateAnswerEquationColor(real_step_count);
        }

        result += "<p>Step " + (real_step_count + 1) + ": " + ((step_count == 0)?" Begin on far left. ":"") + "Divide the " + step_words[max_digit - step_count - 1] + " digit</p>";

        if(remainder_val > 0){
            result += "<p class='detail_step div_notice'>Bring down remainder, add " + step_words[max_digit - step_count - 1] + " digit</p>";
        }

        if(step_count == 0) temp_val = (randomNumber1 + "").substring(0, getDigitsCouunt(randomNumber2));
        else temp_val = (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + step_count - 1, getDigitsCouunt(randomNumber2) + step_count);

        temp_val = temp_val * 1 + remainder_val * 10;

        remainder_val = 0;
        // strHTML = generateDivisionExpr(randomNumber2, temp_val, (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + step_count));
        // result += strHTML;
        result += "<p class='detail_step'>Divide " + temp_val + " by " + randomNumber2 + "</p>";

        result += generateAnswerEquationColor(real_step_count + 1);

        correct_answer = getCorrectAnswer();
        result += "<p class='detail_step'>Multiple " + correct_answer + " x " + randomNumber2 + " = " + (correct_answer * randomNumber2) + "</p>";
        result += "<p class='detail_step'>Subtract " + temp_val + " - " + (correct_answer * randomNumber2) + " = " + (temp_val - correct_answer * randomNumber2) + "</p>";

        if(remainder_val > 0) 
            result += "<p class='detail_step'>There is a remainder " + remainder_val + "</p>";

        real_step_count++;
    }

    result += "<p align=left style='text-indent:10px;'>Answer:</p>";
    result += "<p align=left style='text-indent:20px;'>" + $(".inputCheck").prop("value") + "</p>";

    $("#lastDiv3").html(result);        
}

function _equation_remainder_(_min_digit, _min_value) {
    _min_digit = _min_digit + getDigitsCouunt(randomNumber2) - getDigitsCouunt(_min_value);
    _minus_html = '<div><div class="disp_pre"></div><div class="disp_post upper_line blue_text">';
    _minus_html += '<span class="space">-</span>';
    for(_min_t = 0; _min_t < _min_digit; _min_t++)
        _minus_html += '<span class="space">0</span>';
    _minus_html += _min_value + '</div></div>';
    return _minus_html;
}

function _equation_remainder(_min_digit, _min_value) {
    _min_digit = _min_digit + getDigitsCouunt(randomNumber2) - getDigitsCouunt(_min_value);
    _minus_html = '<div><div class="disp_pre"></div><div class="disp_post upper_line">';
    _minus_html += '<span class="space">-</span>';
    for(_min_t = 0; _min_t < _min_digit; _min_t++)
        _minus_html += '<span class="space">0</span>';
    _minus_html += _min_value + '</div></div>';
    return _minus_html;
}

function _equation_minus_(_min_digit, _min_value) {
    _min_digit = _min_digit + getDigitsCouunt(randomNumber2) - getDigitsCouunt(_min_value);
    _minus_html = '<div><div class="disp_pre"></div><div class="disp_post no_line blue_text">';
    for(_min_t = 0; _min_t < _min_digit; _min_t++)
        _minus_html += '<span class="space">0</span>';
    _minus_html += '-' + _min_value + '</div></div>';
    return _minus_html;
}

function _equation_minus(_min_digit, _min_value) {
    _min_digit = _min_digit + getDigitsCouunt(randomNumber2) - getDigitsCouunt(_min_value);
    _minus_html = '<div><div class="disp_pre"></div><div class="disp_post no_line">';
    for(_min_t = 0; _min_t < _min_digit; _min_t++)
        _minus_html += '<span class="space">0</span>';
    _minus_html += '-' + _min_value + '</div></div>';
    return _minus_html;
}

function _equation_question(_quest_1, _quest_2) {
    return '<div><div class="disp_pre">' + _quest_1 + '</div><div class="disp_post both_line"><span class="space">-</span>' + _quest_2 + '</div></div>';
}

function _equation_answer(_answer_val) {
    _minus_html = "";
    _min_digit = getDigitsCouunt(randomNumber2) - 1;
    for(_min_t = 0; _min_t < _min_digit; _min_t++)
        _minus_html += '<span class="space">0</span>';
    return '<div><div class="disp_pre"></div><div class="disp_post no_line"><span class="space">-</span>' + _minus_html + _answer_val + '</div></div>';
}

function generateAnswerEquation(_step_number) {
    // console.log("Step Number" + _step_number);

    _strHTML = "";
    _answer_val = "";
    _real_step_count = 4;
    _remainder_val = 0;

    for(_step_count=0; _step_count < max_digit; _step_count++){
        if(_step_count == 0) _temp_val = (randomNumber1 + "").substring(0, getDigitsCouunt(randomNumber2));
        else _temp_val = (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + _step_count - 1, getDigitsCouunt(randomNumber2) + _step_count);

        if(_remainder_val > 0){                
            _real_step_count++;
            _strHTML += _equation_remainder(_step_count, _remainder_val + "" + _temp_val);
            if(_step_number <= _real_step_count) break;
        }

        _temp_val = _temp_val * 1 + _remainder_val * 10;
        _remainder_val = 0;
        
        correct_answer = _getCorrectAnswer();
        _strHTML += _equation_minus(_step_count, correct_answer * randomNumber2);

        _answer_val += correct_answer;

        _real_step_count++;
        if(_step_number <= _real_step_count){ 
            _strHTML += _equation_remainder(_step_count, _remainder_val);
            break;
        }
    }

    return $(_equation_answer(_answer_val) + _equation_question(randomNumber2, randomNumber1) + _strHTML);
}

function generateAnswerEquationColor(_step_number) {
    // console.log("Step Number" + _step_number);

    _strHTML = "";
    _answer_val = "";
    _real_step_count = 4;
    _remainder_val = 0;

    for(_step_count=0; _step_count < max_digit; _step_count++){
        if(_step_count == 0) _temp_val = (randomNumber1 + "").substring(0, getDigitsCouunt(randomNumber2));
        else _temp_val = (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + _step_count - 1, getDigitsCouunt(randomNumber2) + _step_count);

        if(_remainder_val > 0){                
            _real_step_count++;

            if(_step_number <= _real_step_count){
                _strHTML += _equation_remainder_(_step_count, _remainder_val + "" + _temp_val);
                break;
            }

            // console.log("Step :" + _step_number + ", " + _real_step_count);
            if(_step_number <= _real_step_count + 1)
                _strHTML += _equation_remainder_(_step_count, _remainder_val + "" + _temp_val);
            else
                _strHTML += _equation_remainder(_step_count, _remainder_val + "" + _temp_val);
        }

        _temp_val = _temp_val * 1 + _remainder_val * 10;
        _remainder_val = 0;
        
        correct_answer = _getCorrectAnswer();
        if(_step_number == _real_step_count + 1)
            _strHTML += _equation_minus_(_step_count, correct_answer * randomNumber2);
        else
            _strHTML += _equation_minus(_step_count, correct_answer * randomNumber2);

        _answer_val += correct_answer;

        _real_step_count++;
        if(_step_number <= _real_step_count){ 
            _strHTML += _equation_remainder_(_step_count, _remainder_val);
            break;
        }
    }

    if(_step_number == 1) return _equation_answer('<span style="color:red;">'+_answer_val+'</span>') + _equation_question('<span class="blue_text">'+randomNumber2+'</span>', '<span class="blue_text">'+_temp_val+'</span>' + (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2))) + _strHTML;
    return _equation_answer('<span style="color:red;">'+_answer_val+'</span>') + _equation_question('<span class="blue_text">'+randomNumber2+'</span>', randomNumber1) + _strHTML;
}

function btnYEsOnclick(){
    $("#message_modal_dynamic").hide();
    if(dropdown_var[step_count - 2]) alertModal("Remember you drop down remainder in the previous step.");
    generateAnswerStep();
}

function btnNOOnclick(){
    $("#message_modal_dynamic").hide();
    btnNORemainderModal("Division is not yet complete. Please continue and bring down the nextdigit.");
    generateAnswerStep();
}

