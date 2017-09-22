/**
 *  Code from client
 * 7/26/17.
 */

var randomNumber1 = "";
var randomNumber2 = "";

var step_count = 0;
var max_digit = 0;

var borrow_var = [];
var x_var = [];
var x_var2 = [];
var y_var = [];
var arr_randomNumber1 = [];
var arr_randomNumber2 = [];
var arry_error_temp = [];

_end_num = 9;
var answered = []; //ADDED

//START ADDED FUNCTIONS

function setRandomDigits(digit){
    randomDigits = digit;
}

function getRandomNumber1(){
    return randomNumber1;
}

function getRandomNumber2(){
    return randomNumber2
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
    $("#ok_modal").hide();
}

function borrowOneModal(message){
    dynamicBlock();
    $("#message_text_modal").html(message);
    $("#message_modal_dynamic").show();
    $("#close_modal").hide();
    $("#yes_modal").show();
    $("#no_modal").show();
    $("#ok_modal").hide();
}

function btnNOBorrowModal(message){
    dynamicBlock();
    $("#message_text_modal").html(message);
    $("#message_modal_dynamic").show();
    $("#close_modal").hide();
    $("#yes_modal").hide();
    $("#no_modal").hide();
    $("#ok_modal").show();
}

function btnNOOnclose() {
    $("#message_modal_dynamic").hide();
    dynamicUnBlock();
}

function btnOkBorrowModal() {
    borrowOneModal("Do you need to BORROW 1 from next column?");
}

//END ADDED FUNCTION

function randomDigitsOnclick(){
    randomNumber1 = "";
    randomNumber2 = "";

    step_count = 0;
    max_digit = 0;

    borrow_var = [];
    x_var = [];
    x_var2 = [];
    y_var = [];
    arr_randomNumber1 = [];
    arr_randomNumber2 = [];
    // randomDigits = _validateNum($("#randomDigits").prop("value"), 4);
    // if(randomDigits > 9) randomDigits = 8;
    // $("#randomDigits").prop("value", randomDigits);

    randomNumber1 = Math.floor(Math.random() * digits(randomDigits));
    randomNumber2 = Math.floor(Math.random() * randomNumber1);
    // if (randomNumber2 == 0 ) randomNumber2++;
    // if (randomNumber1 == 0 ) randomNumber1++;

//        randomNumber1 = 1002;
//        randomNumber2 = 3;

    $("#randomNumber1").prop("value", randomNumber1);
    $("#randomNumber2").prop("value", randomNumber2);

    $("#subject_number1_p").html(randomNumber1);
    $("#subject_number2_p").html(randomNumber2);

    $("#answerPane").html('<div id="lastDiv"></div>');
    $("#examPane").show();
    $("#lastDiv2").html("");
    $("#lastDiv3").html("");

    max_digit = getDigitsCouunt((randomNumber1 > randomNumber2 ? randomNumber1 : randomNumber2));
    step_count = 0;

    x_var = [];
    y_var = [];
    borrow_var = [];
    for(i=0; i<getDigitsCouunt(randomNumber1); i++){
        x_var[i] = getDigitNum(randomNumber1, i + 1);
        borrow_var[i] = false;
    }

    for(i=0; i<getDigitsCouunt(randomNumber2); i++)
        y_var[i] = getDigitNum(randomNumber2, i + 1);
}

function startAnswer() {
    if($(".answer_value").length == 0) generateAnswerStep();
}

function generateAnswerStep() {
    retry_attempt = 0;
    if(step_count >= max_digit) {
        checkTotal();
        // ADDED call function view hide
        answerDone();
        return;
    }
    var str1 = randomNumber1.toString();

    diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
    result = "<p>Subtract</p>";
    result += "<p align=right style='width:100px;'>";
    if (getDigitsCouunt(randomNumber1) == 0) result += "<label style='color:blue'>" + "0" + "&nbsp;" + "</label>";

    for(i=getDigitsCouunt(randomNumber1); i >= 1; i--){

        if ((step_count+1) == i) {
            result += "<label style='color:blue'>" + getDigitNum(randomNumber1, i) + "&nbsp;" + "</label>";
        }else{
            result += getDigitNum(randomNumber1, i) + " ";
        }
    }
    result += "</p>";
    result += "<p align=right style='width:100px;'> - ";
    if(diff_space > 0) result += "&nbsp&nbsp&nbsp&nbsp";
    if (getDigitsCouunt(randomNumber2) == 0) result += "<label style='color:blue'>" + "0" + "&nbsp;" + "</label>";

    for(i=getDigitsCouunt(randomNumber2); i >= 1; i--){
        if ((step_count+1) == i) {
            result += "<label style='color:blue'>" + getDigitNum(randomNumber2, i) + "&nbsp;" + "</label>";
        }else{
            result += getDigitNum(randomNumber2, i) + " ";
        }
    }

    result += "</p>";

    borrow_var[step_count] = false;
    // console.log("step_count = " + step_count);
    $(".answer_value").unbind("keydown").removeClass("inputCheck").attr("readonly", true);
    $("<p class='margin-10-top'>Step " + (step_count + 1) + ": Subtract the " + step_words[step_count] + "</p>" + result + "<input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            correct_answer = getCorrectAnswer();
            setAnswered($(this).prop("value")); //ADDED
            temp_answer = validateAnswer4Substraction($(this), correct_answer);
            if(temp_answer == 0) generateAnswerStep();
        }
    });

    if((step_count < y_var.length) && (x_var[step_count] < y_var[step_count])){
        borrowNumber(step_count + 1);
        borrow_var[step_count] = true;
        // $("#myModal").show();
        borrowOneModal("Do you need to BORROW 1 from next column?");
    } else $(".inputCheck").focus();
    step_count++;
}

function getCorrectAnswer() {
    correct_answer = 10 + x_var[step_count - 1];
    if(y_var.length > step_count - 1) correct_answer -= y_var[step_count - 1];
    return correct_answer % 10;
}

function validateAnswer4Substraction(_elem, _correct_answer) {
    _correct_answer = _validateNum(_correct_answer, 0);

    if( retry_attempt > retry_attempt_limit ) {
        retry_attempt = 0;                                      return _errorHandler(_elem, -5, "The correct answer is " + _correct_answer + ". Please retry. ");
    }       

    _answer = _elem.prop("value");

    // console.log("Correct Answer: " + _correct_answer + ", Answered Answer: " + _elem.prop("value"));

    
    if(isNaN(_answer))                                          return _errorHandler(_elem, -1, "That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
    if (_answer == "")                                          return _errorHandler(_elem, -5, "Please enter a valid input.");

    _elem.prop("value", _answer);
    if((_answer * 1 < _start_num) || (_answer * 1 > _end_num)) {
        if (!arry_error_temp[step_count]) arry_error_temp[step_count] = _answer;
        return _errorHandler(_elem, -2, "That is incorrect. Answer can't less than " + _start_num + " or more than " + _end_num + ". Please retry.");
    }
    if(step_count > 1)
        if(borrow_var[step_count - 2]){
            if((_answer == _correct_answer + 1)||(_answer == _correct_answer - 9))
                                                                return _errorHandler(_elem, -6, "Remember you borrowed 1 in the previous step.");
        }

    if(_answer < _correct_answer) {      
        if (!arry_error_temp[step_count]) arry_error_temp[step_count] = _answer;
        return _errorHandler(_elem, -3, "Oops not enough, your answer needs to be larger.");
    }
    if(_answer > _correct_answer)  {
        if (!arry_error_temp[step_count]) arry_error_temp[step_count] = _answer;
         return _errorHandler(_elem, -4, "Your answer is larger than what we need.");
     }

    return 0;
}

function _errorHandler(_elem, _err_num, _err_description) {
    alertModal( _err_description );
    if(_err_num != -6) retry_attempt++;
    _elem.prop("value", "").focus();
    return _err_num;
}

function borrowNumber(_digits) {
    x_var[_digits] = (x_var[_digits] + 9) % 10;
    if(x_var[_digits] == 9) borrowNumber(_digits + 1);
}

function dismissZero(_number) {
    _number = parseInt(_number);
    return _number;
}

function checkTotal() {
    $(".answer_value").unbind("keydown").removeClass("inputCheck").attr("readonly", true);
    $("<p>Total</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
    str_answer = "";

    for(i=0; i<$(".answer_value").length; i++)
        str_answer = $(".answer_value").eq(i).prop("value") + "" + str_answer;

    str_answer = dismissZero(str_answer);
    $(".inputCheck").prop("value", str_answer);
    displayTotalFlow();
    displayTotalFlow2();
}

function displayTotalFlow(){

    for(i=0; i<getDigitsCouunt(randomNumber1); i++){
        x_var2[i] = getDigitNum(randomNumber1, i + 1);
    }

    for(i=0; i<max_digit; i++){

    }

    diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
    result = '<p>Subtract ' + randomNumber2 + ' from ' + randomNumber1 + '</label></p>';

    for(i=1; i<=max_digit; i++){
        result += "<p align=left style='text-indent:10px;' class='margin-10-top'>";
        result += "Step " + i + " : Subtract the " + step_words[i - 1];
        if (arry_error_temp[i]) {
            result += "<br>"+ "&nbsp; &nbsp; " + "<font style = 'color: red;'>" + "step"+ i + ":&nbsp;" + "error : "+ arry_error_temp[i] + "</font>";
        }
        result += "</p>";

        result += "<p align=left style='text-indent:20px;'>";
        result += x_var2[i-1];
        if(y_var.length > i - 1) result += " - " + y_var[i-1];
        if(i>1){
            if(borrow_var[i - 2]){
                result += ", but remember we borrowed 1 so it is " + x_var[i - 1];
                if(y_var.length > i - 1) result += " - " + y_var[i-1];
            }
        }

        result += "</p><p align=left style='text-indent:20px;'>";
        if(y_var.length > i - 1){
            if(x_var[i - 1] < y_var[i - 1]) result += "Since " + x_var[i - 1] + " < " + y_var[i - 1] + " you need to borrow 1 from the next column hence";
        }

        result += "</p><p align=left style='text-indent:20px;'>";
        if(y_var.length > i - 1){
            if(x_var[i - 1] < y_var[i - 1]) result += (x_var[i - 1] + 10) + " - " + y_var[i - 1] + " = " + (x_var[i - 1] + 10 - y_var[i - 1]);
            else result += x_var[i - 1] + " - " + y_var[i - 1] + " = " + (x_var[i - 1] - y_var[i - 1]);
        } else {
            // console.log("i = " + i + "---" + y_var[i - 1]);
            result += x_var[i - 1];
        }

        result += "</p>";

    }

    result += "<p align=left style='text-indent:10px;'>Answer:</p>";
    result += "<p align=left style='text-indent:20px;'>" + $(".inputCheck").prop("value") + "</p>";

    $("#lastDiv2").html(result);
}

function displayTotalFlow2(){

    for(i=0; i<getDigitsCouunt(randomNumber1); i++){
        x_var2[i] = getDigitNum(randomNumber1, i + 1);
    }

    for(i=0; i<max_digit; i++){

    }

    diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
    result = '<p>Subtract ' + randomNumber2 + ' from ' + randomNumber1 + '</label></p>';

    for(i=1; i<=max_digit; i++){
        result += "<p align=left style='text-indent:10px;' class='margin-10-top'>";
        result += "Step " + i + " : Subtract the " + step_words[i - 1];
        result += "</p>";

        result += "<p align=left style='text-indent:20px;'>";
        result += x_var2[i-1];
        if(y_var.length > i - 1) result += " - " + y_var[i-1];
        if(i>1){
            if(borrow_var[i - 2]){
                result += ", but remember we borrowed 1 so it is " + x_var[i - 1];
                if(y_var.length > i - 1) result += " - " + y_var[i-1];
            }
        }

        result += "</p><p align=left style='text-indent:20px;'>";
        if(y_var.length > i - 1){
            if(x_var[i - 1] < y_var[i - 1]) result += "Since " + x_var[i - 1] + " < " + y_var[i - 1] + " you need to borrow 1 from the next column hence";
        }

        result += "</p><p align=left style='text-indent:20px;'>";
        if(y_var.length > i - 1){
            if(x_var[i - 1] < y_var[i - 1]) result += (x_var[i - 1] + 10) + " - " + y_var[i - 1] + " = " + (x_var[i - 1] + 10 - y_var[i - 1]);
            else result += x_var[i - 1] + " - " + y_var[i - 1] + " = " + (x_var[i - 1] - y_var[i - 1]);
        } else {
            result += y_var[i - 1];
        }

        result += "</p>";

    }

    result += "<p align=left style='text-indent:10px;'>Answer:</p>";
    result += "<p align=left style='text-indent:20px;'>" + $(".inputCheck").prop("value") + "</p>";

    $("#lastDiv3").html(result);        
}


function btnYEsOnclick(){
    // $("#myModal").hide();
    $("#message_modal_dynamic").hide();
    if(borrow_var[step_count - 2]) alertModal("Remember you borrowed 1 in the previous step.");
    // console.log("yes = " + step_count);
    $(".inputCheck").focus();
}

function btnNOOnclick(){
    // $("#myModal").hide();
    $("#message_modal_dynamic").hide();
    btnNOBorrowModal(x_var[step_count - 1] + " is less than " + y_var[step_count - 1] + ", So you must borrow 1.");
    $(".inputCheck").focus();
}