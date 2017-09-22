/**
 * Code from client
 * 20170825
 */

var randomNumber1 = "";
var randomNumber2 = "";
var randomDigits = "";
var randomNumber = "";
var max_t = 0;
var min_t = 0;
var posDot = 0;

var step_count = 0;
var step_words = ["ones", "tens", "hundreds", "thousands", "ten thousands", "hundred thousands", "millions"];
var decimal_low_words = [ "tenths", "hundredths","thousandths", "ten thousandths",  "hundred thousandths", "millionths", "ten millionths", "hundred millionths"];
var max_digit = 0;
var numMax = 0;
var carry_over = false;
var carry_elem;
var carr_over_var = [];
var carr_over_var2 = [];
var lastCarr_over_var2 = [];
var arry_errTemp = [];

var retry_attempt = 0;
var str_total = "";
var answered = []; //ADDED

// start ADDED functions
//getter and setter
function setRandomDigits(digit){
    randomDigits = digit;
}

function getRandomNumber1(){
    return randomNumber1;
}

function getRandomNumber2(digit){
    return randomNumber2;
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

function carryOneModal(message){
    dynamicBlock();
    $("#message_text_modal").html(message);
    $("#message_modal_dynamic").show();
    $("#close_modal").hide();
    $("#yes_modal").show();
    $("#no_modal").show();
}

function closeModal(){
    $("#message_modal_dynamic").hide();
}

// end ADDED functions

function digits(digits){
    a = 1;      
    for (var i = 0; i < digits; i++) {
        a *= 10;        
    }
    return a;
}

function genRandomNumber( numMin, numMax, decimalDigits) {

    randomNumber = (Math.random() * (numMax - numMin) + numMin).toFixed(randomDigits);

    return randomNumber;
}

function randomDigitsOnclick(){

    max_t = 0;
    min_t = 0;
    posDot = 0;

    step_count = 0;
    max_digit = 0;
    numMax = 0;
    carry_over = false;
    carry_elem;
    carr_over_var = [];
    carr_over_var2 = [];
    lastCarr_over_var2 = [];

    retry_attempt = 0;
    str_total = "";
    randomNumber1 = "";
    randomNumber2 = "";
    randomDigits = "";
    randomNumber = "";
    max_t = 0;
    min_t = 0;
    posDot = 0;

    step_count = 0;
    max_digit = 0;
    numMax = 0;
    carry_over = false;
    carry_elem;
    carr_over_var = [];
    carr_over_var2 = [];
    lastCarr_over_var2 = [];
    arry_errTemp = [];

    retry_attempt = 0;
    str_total = "";
    carry_over = false;

    numMax = parseInt($(".input_num_max").prop("value"));    
    randomDigits = $("#randomDigits").prop("value");
    randomDigits = parseInt(randomDigits);
    if(isNaN(randomDigits)) randomDigits = 1;
    if(isNaN(numMax)) {
        numMax = 1;
        $(".input_num_max").prop("value", numMax);
    }
    if(numMax > 10) {
        numMax = 9;
        $(".input_num_max").prop("value", numMax);
    }
    if(randomDigits > 7) randomDigits = 7;
    $("#randomDigits").prop("value", randomDigits);
    max_t = digits(randomDigits);
    // console.log(max_t);

    randomNumber1 = genRandomNumber(0.05, numMax, randomDigits);
    randomNumber2 = genRandomNumber(0.05, numMax, randomDigits);
    // randomNumber1 = "6.1906";
    // randomNumber2 = "4.8297";
    
    posDot = randomNumber1.indexOf(".");
    $(".input_num_max").prop("value", numMax);
    $("#randomNumber1").prop("value", randomNumber1);
    $("#randomNumber2").prop("value", randomNumber2);
    $("#subject_number1_p").html(randomNumber1);
    $("#subject_number2_p").html(randomNumber2);
    $("#answerPane").html('<div id="lastDiv"></div>');
    $("#examPane").show();
    $("#lastDiv2").html("");
    $("#lastDiv3").html("");

    var large_num = randomNumber1 > randomNumber2 ? randomNumber1 : randomNumber2;
    max_digit = getDigitsCouunt(large_num);

    step_count = 0;
}

function getDigitNum(checkNumber, digitPosition) {
    digitPosition--;
    checkNumber = checkNumber[checkNumber.length - digitPosition];
    return checkNumber;
}

function checkAnswer(elem) {
    answer_val = parseInt(elem.prop("value"));
    if(isNaN(answer_val)) return false;
    elem.prop("value", answer_val);
    setAnswered(answer_val);    //added
    return true;
}

function checkAnswer2(elem) {
    answer_val = parseInt(elem.prop("value"));
    if((answer_val * 1 < 0) || (answer_val * 1 > 19)) {
        if (!arry_errTemp[step_count]) {
            arry_errTemp[step_count] = answer_val;
        }
        return false;
    }
    return true;
}

function checkAnswerValidation(elem) {
    answer_val = parseInt(elem.prop("value"));
    if (getDigitNum(randomNumber1, (step_count+1)) == ".") {
        correct_answer = getDigitNum(randomNumber1, (step_count+2)) * 1 + getDigitNum(randomNumber2, (step_count+2)) * 1;
        // console.log("correct_answer = " + correct_answer);
    }else{
        correct_answer = getDigitNum(randomNumber1, (step_count+1)) * 1 + getDigitNum(randomNumber2, (step_count+1)) * 1;
    }
    
    if(carry_over) correct_answer++;
    if (answer_val == correct_answer){
        carry_over = false;
        return correct_answer;  
    } 
    if(retry_attempt > 1){
        // alert("Correct Answer is " + correct_answer + ". Retry! ");
        alertModal("The correct answer is " + correct_answer + ". Please retry. ");
        retry_attempt = 0;
        return -3;
    }
    if (answer_val > correct_answer) {
        if (!arry_errTemp[step_count]) {
            // console.log("123");
            arry_errTemp[step_count] = answer_val;
        }
        return -1;
    }else{
        if (!arry_errTemp[step_count]) {
            arry_errTemp[step_count] = answer_val;
        }
        return -2;
    }
}

function gotoNextLevel() {
    carry_elem_value = parseInt(carry_elem.prop("value")) % 10;
    carry_elem.prop("value", carry_elem_value);
    generateAnswerStep();
}

function displayTotalFlow2(){
    total_result = "";
    diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
    result = "<p>Add</p>";
    result += "<p align=right style='width:58%;'>";

    for(i=getDigitsCouunt(randomNumber1); i > 1; i--){
        result += getDigitNum(randomNumber1, i) + " ";
    }
    result += "</p>";
    result += "<p align=right style='width:58%;margin-top:10px'> + ";
    if(diff_space > 0) result += "  ";

    for(i=getDigitsCouunt(randomNumber2); i > 1; i--){
        result += getDigitNum(randomNumber2, i) + " ";
    }

    result += "</p>";
    result += "<p align=right style='width:58%;margin-top:-20px'> __";
    for(i=getDigitsCouunt(randomNumber2); i > 1; i--)
        result += "__";
    result += "</p>";
    for(i=2; i<max_digit; i++){
        result += "<p align=left style='text-indent:10px;'>";
        if (i == max_digit-1) {
            result += "Step " + (i-1) + " : Add the " + step_words[0];
        }else{
            result += "Step " + (i-1) + " : Add the " + decimal_low_words[max_digit - i - 2];
        }
        result += "</p>";
        result += "<p align=left style='text-indent:20px;'>";
        if((getDigitsCouunt(randomNumber1) >= i)&&(getDigitsCouunt(randomNumber2) >= i)){
            if (i == max_digit-1) {
                result += getDigitNum(randomNumber1, (i+1)) + " + " + getDigitNum(randomNumber2, (i+1)) + " = " + (getDigitNum(randomNumber1, (i+1))*1 + getDigitNum(randomNumber2, (i+1))*1);
                max_sum = (getDigitNum(randomNumber1, (i+1))*1 + getDigitNum(randomNumber2, (i+1))*1);
            }else{
                result += getDigitNum(randomNumber1, i) + " + " + getDigitNum(randomNumber2, i) + " = " + (getDigitNum(randomNumber1, i)*1 + getDigitNum(randomNumber2, i)*1);
                max_sum = (getDigitNum(randomNumber1, i)*1 + getDigitNum(randomNumber2, i)*1);
            }
        }
        else if(getDigitsCouunt(randomNumber1) >= i) {
            result += getDigitNum(randomNumber1, i);
            max_sum = getDigitNum(randomNumber1, i);    
        }
        else {
            result += getDigitNum(randomNumber2, i);
            max_sum = getDigitNum(randomNumber2, i);    
        }
        result += "</p>";
        if((i>1)&&carr_over_var2[i-3]){
            if(carr_over_var2[i-3] != carr_over_var[i-3]){
                result += "<p align=left style='text-indent:20px;color:red;'>Add the carried 1</p>";
                result += "<p align=left style='text-indent:20px;color:red;'>" + max_sum + " + 1 = " + (max_sum + 1) + "</p>";
            } else {
                result += "<p align=left style='text-indent:20px;'>Add the carried 1</p>";
                result += "<p align=left style='text-indent:20px;'>" + max_sum + " + 1 = " + (max_sum + 1) + "</p>";
            }
            max_sum++;
        }
        result += "<p align=left style='text-indent:20px;'>Keep the " + (max_sum % 10) + "</p>";
        total_result = (max_sum % 10) + "" + total_result;
        // console.log("total_result1qqqq = " + total_result);
        if(carr_over_var2[i-2]){
            if(carr_over_var2[i-2] != carr_over_var[i-2]){
                result += "<p align=left style='text-indent:20px;color:red;'>Carry 1</p>";
            } else {
                result += "<p align=left style='text-indent:20px;'>Carry 1</p>";
            }
        }
    }
    if(carr_over_var2[max_digit-3]){
        // console.log("total_result1 = " + total_result);
        total_result = "1" + total_result;
        // console.log("total_result = " + total_result);
    }
    var total_result_to = ""
    if (carr_over_var2[max_digit-3]) {
        
        for (var i = 0; i < total_result.length; i++) {
            total_result_to += total_result.substring(i, i+1);
            if (i == 1) total_result_to += ".";
        }
    }else{
        for (var i = 0; i < total_result.length; i++) {
            total_result_to += total_result.substring(i, i+1);
            if (i == 0) total_result_to += ".";
        }    
    }

    result += "<p align=left style='text-indent:10px;'>Total:</p>";
    result += "<p align=left style='text-indent:20px;'>" + total_result_to + "</p>";

    $("#lastDiv3").html(result);
}

function displayTotalFlow(){
    diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
    result = "<p>Add</p>";
    result += "<p align=right style='width:58%;'>";

    for(i=getDigitsCouunt(randomNumber1); i > 1; i--){
        result += getDigitNum(randomNumber1, i) + " ";
    }
    result += "</p>";
    result += "<p align=right style='width:58%;margin-top:10px'> + ";
    if(diff_space > 0) result += "  ";

    for(i=getDigitsCouunt(randomNumber2); i > 1; i--){
        result += getDigitNum(randomNumber2, i) + " ";
    }

    result += "</p>";
    result += "<p align=right style='width:58%;margin-top:-20px'> __";
    for(i=getDigitsCouunt(randomNumber2); i > 1; i--)
        result += "__";
    result += "</p>";
    for(i=2; i< max_digit; i++){
        result += "<p align=left style='text-indent:10px;'>";
        if (i == max_digit-1) {
            result += "Step " + (i-1) + " : Add the " + step_words[0];
            if (arry_errTemp[i-1]) {
                result += "<p style='color:red;'> Error : "+ arry_errTemp[i-1] +"</p>";
            }
        }else{
            if (arry_errTemp[i-1]) {
                result += "<p style='color:red;'> Error : "+ arry_errTemp[i-1] +"</p>";
            }
            result += "Step " + (i-1) + " : Add the " + decimal_low_words[max_digit - i - 2];    
        }
        
        result += "</p>";
        result += "<p align=left style='text-indent:20px;'>";
        if((getDigitsCouunt(randomNumber1) >= i)&&(getDigitsCouunt(randomNumber2) >= i)){
            if (i == max_digit-1) {
                result += getDigitNum(randomNumber1, (i+1)) + " + " + getDigitNum(randomNumber2, (i+1)) + " = " + (getDigitNum(randomNumber1, (i+1))*1 + getDigitNum(randomNumber2, (i+1))*1);
                max_sum = (getDigitNum(randomNumber1, (i+1))*1 + getDigitNum(randomNumber2, (i+1))*1);
            }else{
                result += getDigitNum(randomNumber1, i) + " + " + getDigitNum(randomNumber2, i) + " = " + (getDigitNum(randomNumber1, i)*1 + getDigitNum(randomNumber2, i)*1);
                max_sum = (getDigitNum(randomNumber1, i)*1 + getDigitNum(randomNumber2, i)*1);
            }
        }
        else if(getDigitsCouunt(randomNumber1) >= i) {
            result += getDigitNum(randomNumber1, i);
            max_sum = getDigitNum(randomNumber1, i);    
        }
        else {
            result += getDigitNum(randomNumber2, i);
            max_sum = getDigitNum(randomNumber2, i);    
        }
        result += "</p>";
        if((i>1)&&carr_over_var[i-3]){
            result += "<p align=left style='text-indent:20px;'>Add the carried 1</p>";
            result += "<p align=left style='text-indent:20px;'>" + max_sum + " + 1 = " + (max_sum + 1) + "</p>";
            max_sum++;
        }
        result += "<p align=left style='text-indent:20px;'>Keep the " + (max_sum % 10) + "</p>";
        if(carr_over_var[i-2]){
            result += "<p align=left style='text-indent:20px;'>Carry 1</p>";
        }
    }

    result += "<p align=left style='text-indent:10px;'>Total:</p>";
    if (arry_errTemp[i-1]) {
        result += "<p style='color:red;'> Error : "+ arry_errTemp[i-1] +"</p>";
    }
    result += "<p align=left style='text-indent:20px;'>" + $(".inputCheck").prop("value") + "</p>";

    $("#lastDiv2").html(result);
}

function checkTotal() {
    $(".answer_value").unbind("keydown").removeClass("inputCheck").attr("readonly", true);
    $("<p>Total</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
    str_answer = "";
    for(i=0; i<$(".answer_value").length; i++)
        str_answer = $(".answer_value").eq(i).prop("value") + "" + str_answer;
    if(carry_over) str_answer = "1" + str_answer;
    if (carry_over == true) {
        
        for (var i = 0; i < str_answer.length; i++) {
            str_total += str_answer.substring(i, i+1);
            if (i == 1) str_total += ".";
        }
    }else{
        for (var i = 0; i < str_answer.length; i++) {
            str_total += str_answer.substring(i, i+1);
            if (i == 0) str_total += ".";
        }    
    }
    
    $(".inputCheck").prop("value", str_total);
    displayTotalFlow();
    displayTotalFlow2();
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
    result = "<p>Add</p>";
    result += "<p align=right style='width:110px;'>";

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
    result += "<p align=right style='width:110px;margin-top:10px;' class='answer_underline'> + ";
    if(diff_space > 0) result += "  ";

    for(i=getDigitsCouunt(randomNumber2); i > 1; i--){
        if (pos_i == i) {
            result += "<label style='color:blue'>" + getDigitNum(randomNumber2, i) + "&nbsp;" + "</label>";    
        }else{
            result += getDigitNum(randomNumber2, i) + " ";
        }
    }

    result += "</p>";

    carr_over_var[step_count] = false;
    carr_over_var2[step_count] = false;
    $(".answer_value").unbind("keydown").removeClass("inputCheck").attr("readonly", true);
    if (step_count > (randomNumber1.length- posDot - 2) ) {
        if (carry_over == true) {
            $("<p>Step " + (step_count + 1) + ": Add the " + step_words[(posDot + step_count+1) - randomNumber1.length] + " + 1 carried over.</p>" + result + "<input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv"); 
        }else{

         $("<p>Step " + (step_count + 1) + ": Add the " + step_words[(posDot + step_count+1) - randomNumber1.length] + "</p>" + result + "<input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");    
        }
    }else{
        if (carry_over == true) {
            $("<p>Step " + (step_count + 1) + ": Add the " + decimal_low_words[randomNumber1.length -posDot - step_count-2] + " + 1 carried over.</p>" + result + "<input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv"); 
        }else{ 
            $("<p>Step " + (step_count + 1) + ": Add the " + decimal_low_words[randomNumber1.length -posDot - step_count-2] + "</p>" + result + "<input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
        }
    }
    
    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                // alert("Answer can't be alphabet !");
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(checkAnswer2($(this)) == false){
                // alert("Answer can't be negative or more than 18 !");
                alertModal("That is incorrect. Answer cannot be less than 0 or more than 18. Please retry.");
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
            if(temp_answer < 10) generateAnswerStep();
            else {
                carry_elem = $(this);
                carry_elem.blur();
                // $("#myModal").show();
                carryOneModal("Do you carry one?");
            }
        }
    }).focus();
    step_count++;
}

function startAnswer() {
    if($(".answer_value").length == 0) generateAnswerStep();
}


function startOnclick(){
    // console.log(randomNumber1);
    // console.log(randomNumber2);

    var large_num = randomNumber1 > randomNumber2 ? randomNumber1 : randomNumber2;
    max_digit = getDigitsCouunt(large_num);
    // console.log("max_digit = "+ max_digit);

    for (var i = 0; i < max_digit; i++) {

        first_ones = randomNumber1 % 10;

        // console.log("randomNumber1 = "+ randomNumber1);
        // console.log("randomNumber2 = "+ randomNumber2);
        // console.log("first_ones = "+ first_ones);

        sec_ones = randomNumber2 % 10;

        // console.log("sec_ones = "+ sec_ones);

        randomNumber1 = parseInt((randomNumber1 - randomNumber1 % 10) / 10);
        randomNumber2 = parseInt((randomNumber2 - randomNumber2 % 10) / 10);
    }

    document.getElementById('message_modal_dynamic').style.display = "block";
}

function btnYEsOnclick(){
    carr_over_var[step_count - 1] = true;
    carr_over_var2[step_count - 1] = true;
    if (step_count == max_digit-2) {
        // console.log("111111111111111111111111111111111");
        lastCarr_over_var2[step_count] = true;
    }
    carry_over = true;
    // $("#myModal").hide();
    $("#message_modal_dynamic").hide();
    gotoNextLevel();
}

function btnNOOnclick(){
    carr_over_var2[step_count - 1] = true;
    carry_over = false;
    // $("#myModal").hide();
    $("#message_modal_dynamic").hide();
    gotoNextLevel();
}

function btnNOOnclose() {
    // $("#myModal").hide();
    $("#message_modal_dynamic").hide();
}


function getDigitsCouunt(number){  
    
    digitsCount = 0;
    
    digitsCount = number.length + 1;

    return digitsCount;
}