/**
 * Code from client
 * 20170825
 */

var randomNumber1 = "";
var randomNumber2 = "";
var decimal_low_words = [ "tenths", "hundredths","thousandths", "ten thousandths",  "hundred thousandths", "millionths", "ten millionths", "hundred millionths"];

var step_count = 0;
var max_digit = 0;
var numMax = 0;

var borrow_var = [];
var x_var = [];
var x_var2 = [];
var y_var = [];
var arr_randomNumber1 = [];
var arr_randomNumber2 = [];
var arry_errorTemp = [];

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

function genRandomNumber( numMin, numMax, decimalDigits) {

    randomNumber = (Math.random() * (numMax - numMin) + numMin).toFixed(randomDigits);

    return randomNumber;
}

function randomDigitsOnclick(){
    randomNumber1 = "";
    randomNumber2 = "";
    step_count = 0;
    max_digit = 0;
    numMax = 0;

    borrow_var = [];
    x_var = [];
    x_var2 = [];
    y_var = [];
    arr_randomNumber1 = [];
    arr_randomNumber2 = [];
    arry_errorTemp = [];
    numMax = parseInt($(".input_num_max").prop("value")); 
    if(isNaN(numMax)) {
        numMax = 1;
        $(".input_num_max").prop("value", numMax);
    }
    if(numMax > 10) {
        numMax = 9;
        $(".input_num_max").prop("value", numMax);
    }
    if(randomDigits > 7) randomDigits = 7;

    randomDigits = _validateNum($("#randomDigits").prop("value"), 4);
    if(randomDigits > 9) randomDigits = 8;
    $("#randomDigits").prop("value", randomDigits);
    
    randomNumber1 = genRandomNumber(0.05, numMax, randomDigits);
    randomNumber2 = genRandomNumber(0.05, numMax, randomDigits);
    if (randomNumber1 < randomNumber2) {
        var temp = 0;
        temp = randomNumber1;
        randomNumber1 = randomNumber2;
        randomNumber2 = temp;
    }

    posDot = randomNumber1.indexOf(".");

   // randomNumber1 = "1.6292";
   // randomNumber2 = "0.7878";

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
        x_var[i] = getDigitNum(randomNumber1, i + 2);
        borrow_var[i] = false;
    }

    for(i=0; i<getDigitsCouunt(randomNumber2); i++) {
        y_var[i] = getDigitNum(randomNumber2, i + 2);
    }

}

function startAnswer() {
    if($(".answer_value").length == 0) generateAnswerStep();
}

function generateAnswerStep() {
    retry_attempt = 0;
    if(step_count >= (max_digit-2)) { 
        checkTotal();
        // ADDED call function view hide
        answerDone();
        return;
    }
    var str1 = randomNumber1.toString();

    diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
    result = "<p>Substract</p>";
    result += "<p align=right style='width:100px;'>";

    pos_i = step_count + 2;
    if(pos_i == getDigitsCouunt(randomNumber1) - 1) pos_i++;

    for(i=getDigitsCouunt(randomNumber1); i > 1; i--){

        if (pos_i == i) {
            result += "<label style='color:blue'>" + getDigitNum(randomNumber1, i) + "&nbsp;" + "</label>";
        }else{
            result += getDigitNum(randomNumber1, i) + " ";
        }
    }
    result += "</p>";
    result += "<p align=right style='width:100px;margin-top:10px;' class='answer_underline'> - ";
    if(diff_space > 0) result += "&nbsp&nbsp";

    for(i=getDigitsCouunt(randomNumber2); i > 1; i--){
        if (pos_i == i) {
            result += "<label style='color:blue'>" + getDigitNum(randomNumber2, i) + "&nbsp;" + "</label>";    
        }else{
            result += getDigitNum(randomNumber2, i) + " ";
        }
    }


    result += "</p>";

    borrow_var[step_count] = false;
    $(".answer_value").unbind("keydown").removeClass("inputCheck").attr("readonly", true);
    
    if (step_count >= (randomNumber1.length- posDot - 3) ) {
        $("<p class='margin-10-top'>Step " + (step_count + 1) + ": Substract the " + step_words[(posDot + step_count+3) - randomNumber1.length] + "</p>" + result + "<input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");    
    }else{
        $("<p class='margin-10-top'>Step " + (step_count + 1) + ": Substract the " + decimal_low_words[randomNumber1.length -posDot*1 - step_count-4] + "</p>" + result + "<input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");    
    }
    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if (step_count > (randomNumber1.length-2) ) {
                if (borrow_var[step_count - 2] == true) {
                    correct_answer = (randomNumber1[0] - 1) - randomNumber2[0];    
                }else{
                    correct_answer = randomNumber1[0] - randomNumber2[0];
                }
                
            }else{
                correct_answer = getCorrectAnswer();
            }
            setAnswered($(this).prop("value")); //ADDED
            // console.log("this = " + $(this));
            temp_answer = validateAnswer4Substractiondemo($(this), correct_answer);
            // console.log("temp_answer = " + temp_answer);
            if(temp_answer == 0) {
                generateAnswerStep();
            }
        }
    });
    var z = "";
            
    if (step_count == (randomNumber2.length-2)) {
        z = step_count+1;
        if((z < y_var.length) && (x_var[z] < y_var[z])){
            borrowNumber(z + 2);
            borrow_var[z+1] = true;
            // $("#myModal").show();
            borrowOneModal("Do you need to BORROW 1 from next column?");
        } else $(".inputCheck").focus();
    }
    
    if((step_count < y_var.length) && (x_var[step_count] < y_var[step_count])){

        borrowNumber(step_count + 1);
        if (step_count == (randomNumber2.length-3)) {
            borrowNumber(step_count + 2);
        }
        borrow_var[step_count] = true;
        // $("#myModal").show();
        borrowOneModal("Do you need to BORROW 1 from next column?");
    } else $(".inputCheck").focus();
    step_count++;
}

function validateAnswer4Substractiondemo(_elem, _correct_answer) {

    _correct_answer = _validateNum(_correct_answer, 1);
    _answer = parseInt(_elem.prop("value"));

    if(isNaN(_answer))                                          return _errorHandler(_elem, -1, "That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");



    _elem.prop("value", _answer);

    if((_answer * 1 < _start_num) || (_answer * 1 > _end_num))  {
        if( retry_attempt > retry_attempt_limit ) {

            retry_attempt = 0;                                      return _errorHandler(_elem, -5, "The correct answer is " + _correct_answer + ". Please retry. ");

        }  else{
            if (!arry_errorTemp[step_count]) {
                arry_errorTemp[step_count] = _elem.prop("value");
            }
            return _errorHandler(_elem, -2, "That is incorrect. Answer can't less than " + _start_num + " or more than " + _end_num + ". Please retry.");
        }
    }

    if(step_count > 1)

        if(borrow_var[step_count - 2]){

            if((_answer == _correct_answer + 1)||(_answer == _correct_answer - 9))

                                                                return _errorHandler(_elem, -5, "Remember you borrowed 1 in the previous step.");
        }

    if(_answer < _correct_answer) {
        if( retry_attempt > retry_attempt_limit ) {

            retry_attempt = 0;                                      return _errorHandler(_elem, -5, "The correct answer is " + _correct_answer + ". Please retry. ");

        }  else{
            if (!arry_errorTemp[step_count]) {
                arry_errorTemp[step_count] = _elem.prop("value");
            }
            return _errorHandler(_elem, -3, "Oops not enough, your answer needs to be larger.");        
        }
    }

    if(_answer > _correct_answer){
        if( retry_attempt > retry_attempt_limit ) {

            retry_attempt = 0;                                      return _errorHandler(_elem, -5, "The correct answer is " + _correct_answer + ". Please retry. ");

        }  else{
            if (!arry_errorTemp[step_count]) {
                arry_errorTemp[step_count] = _elem.prop("value");
            }
            return _errorHandler(_elem, -4, "Your answer is larger than what we need.");
        }
    }



    return 0;
}

function borrowNumber(_digits) {

    x_var[_digits] = (x_var[_digits] * 1 + 9) % 10;
    if(x_var[_digits] == 9) borrowNumber(_digits + 1);
}

function getCorrectAnswer() {
    correct_answer = 10 + x_var[step_count - 1]*1;
    if(y_var.length > step_count - 1) correct_answer -= y_var[step_count - 1]*1;
    return correct_answer % 10;
}

function dismissZero(_number) {
    _number = _number * 1;
    return _number;
}

function checkTotal() {
    $(".answer_value").unbind("keydown").removeClass("inputCheck").attr("readonly", true);
    $("<p>Total</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
    str_answer = "";

    for(i=0; i<$(".answer_value").length; i++)
        str_answer = $(".answer_value").eq(i).prop("value") + "" + str_answer;
    var str = "";
    for (var i = 0; i < str_answer.length; i++) {
        str += str_answer.substring(i, i+1);
        if (i == 0) str += ".";
    }

    str_answer = dismissZero(str);
    console.log(str);
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

    pos_i = step_count + 2;
    if(pos_i == getDigitsCouunt(randomNumber1) - 1) pos_i++;

    var z = 0;
    for(i=1; i<=max_digit-2; i++){
        
        z++;
        if (i < randomNumber2.length-1) {
            result += "<p align=left style='text-indent:10px;'>";
            result += "Step " + i + " : Substract the " + decimal_low_words[max_digit-3- i];
            result += "</p>";

            if (arry_errorTemp[i]) {
                result += "<p style='color:red'> Error : " + arry_errorTemp[i] + ".</p>";
            }
            result += "<p align=left style='text-indent:20px;'>";
            result += x_var2[i];
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
                if(x_var[i - 1] < y_var[i - 1]) result += (x_var[i - 1]*1 + 10) + " - " + y_var[i - 1] + " = " + (x_var[i - 1]*1 + 10 - y_var[i - 1]);
                else result += x_var[i - 1] + " - " + y_var[i - 1] + " = " + (x_var[i - 1] - y_var[i - 1]);
            } else {
                result += x_var[i - 1];
            }

            result += "</p>";
        }else{
            z++;
            result += "<p align=left style='text-indent:10px;'>";
            result += "Step " + i + " : Substract the " + step_words[0];
            result += "</p>";

            if (arry_errorTemp[i]) {
                result += "<p style='color:red'> Error : " + arry_errorTemp[i] + ".</p>";
            }

            result += "<p align=left style='text-indent:20px;'>";
            result += x_var2[z];
            if(y_var.length > z - 1) result += " - " + y_var[z-1];
            if(z>1){
                if(borrow_var[z - 3]){
                    result += ", but remember we borrowed 1 so it is " + x_var[z - 1];
                    if(y_var.length > z - 1) result += " - " + y_var[z-1];
                }
            }

            result += "</p><p align=left style='text-indent:20px;'>";
            if(y_var.length > z - 1){
                if(x_var[z - 1] < y_var[z - 1]) result += "Since " + x_var[z - 1] + " < " + y_var[z - 1] + " you need to borrow 1 from the next column hence";
            }

            result += "</p><p align=left style='text-indent:20px;'>";
            if(y_var.length > z - 1){
                if(x_var[z - 1] < y_var[z - 1]) result += (x_var[z - 1]*1 + 10) + " - " + y_var[z - 1] + " = " + (x_var[z - 1]*1 + 10 - y_var[z - 1]);
                else result += x_var[z - 1] + " - " + y_var[z - 1] + " = " + (x_var[z - 1] - y_var[z - 1]);
            } else {
                result += x_var[z - 1];
            }

            result += "</p>";
        }

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

    pos_i = step_count + 2;
    if(pos_i == getDigitsCouunt(randomNumber1) - 1) pos_i++;

    var z = 0;
    for(i=1; i<=max_digit-2; i++){
        
        z++;
        if (i < randomNumber2.length-1) {
            result += "<p align=left style='text-indent:10px;'>";
            result += "Step " + i + " : Substract the " + decimal_low_words[max_digit-3- i];
            result += "</p>";

            result += "<p align=left style='text-indent:20px;'>";
            result += x_var2[i];
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
                if(x_var[i - 1] < y_var[i - 1]) result += (x_var[i - 1]*1 + 10) + " - " + y_var[i - 1] + " = " + (x_var[i - 1]*1 + 10 - y_var[i - 1]);
                else result += x_var[i - 1] + " - " + y_var[i - 1] + " = " + (x_var[i - 1] - y_var[i - 1]);
            } else {
                result += x_var[i - 1];
            }

            result += "</p>";
        }else{
            z++;
            result += "<p align=left style='text-indent:10px;'>";
            result += "Step " + i + " : Substract the " + step_words[0];
            result += "</p>";

            result += "<p align=left style='text-indent:20px;'>";
            result += x_var2[z];
            if(y_var.length > z - 1) result += " - " + y_var[z-1];
            if(z>1){
                if(borrow_var[z - 3]){
                    result += ", but remember we borrowed 1 so it is " + x_var[z - 1];
                    if(y_var.length > z - 1) result += " - " + y_var[z-1];
                }
            }

            result += "</p><p align=left style='text-indent:20px;'>";
            if(y_var.length > z - 1){
                if(x_var[z - 1] < y_var[z - 1]) result += "Since " + x_var[z - 1] + " < " + y_var[z - 1] + " you need to borrow 1 from the next column hence";
            }

            result += "</p><p align=left style='text-indent:20px;'>";
            if(y_var.length > z - 1){
                if(x_var[z - 1] < y_var[z - 1]) result += (x_var[z - 1]*1 + 10) + " - " + y_var[z - 1] + " = " + (x_var[z - 1]*1 + 10 - y_var[z - 1]);
                else result += x_var[z - 1] + " - " + y_var[z - 1] + " = " + (x_var[z - 1] - y_var[z - 1]);
            } else {
                result += x_var[z - 1];
            }

            result += "</p>";
        }

    }

    result += "<p align=left style='text-indent:10px;'>Answer:</p>";
    result += "<p align=left style='text-indent:20px;'>" + $(".inputCheck").prop("value") + "</p>";

    $("#lastDiv3").html(result);        
}


function btnYEsOnclick(){
    // $("#myModal").hide();
    $("#message_modal_dynamic").hide();
    if(borrow_var[step_count - 1]) {
        setTimeout(function(){ alertModal("Remember you borrowed 1 in the previous step."); }, 3000);
        
    }
    $(".inputCheck").focus();
}

function btnNOOnclick(){
    // $("#myModal").hide();
    $("#message_modal_dynamic").hide();
    setTimeout(function(){ btnNOBorrowModal(x_var[step_count - 1] + " is less than " + y_var[step_count - 1] + ", So you must borrow 1."); }, 2000);
    
    $(".inputCheck").focus();
}

function getDigitsCouunt(number){  
    
    digitsCount = 0;
    
    digitsCount = number.length + 1;

    return digitsCount;
}

function getDigitNum(checkNumber, digitPosition) {
    digitPosition--;
    checkNumber = checkNumber[checkNumber.length - digitPosition];
    return checkNumber;
}