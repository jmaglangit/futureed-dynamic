/**
 * Code from client
 * 20170713
 */

var randomNumber1 = "";
var randomNumber2 = "";
var randomDigits = "";
var max_t = 0;
var min_t = 0;

var step_count = 0;
var step_words = ["ones", "tens", "hundreds", "thousands", "ten thousands", "hundred thousands", "millions"];
var max_digit = 0;
var carry_over = false;
var carry_elem;
var carr_over_var = [];
var carr_over_var2 = [];

var retry_attempt = 0;
var answered = []; //ADDED

function digits(digits){
    a = 1;
    for (var i = 0; i < digits; i++) {
        a *= 10;
    }
    return a;
}

// start ADDED functions
//getter and setter
function setRandomDigits(digit){
    randomDigits = digit;
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
    carry_over = false;
    // randomDigits = $("#randomDigits").prop("value"); //REMOVED
    randomDigits = parseInt(randomDigits);
    if(isNaN(randomDigits)) randomDigits = 1;
    if(randomDigits > 7) randomDigits = 7;
    $("#randomDigits").prop("value", randomDigits);
    max_t = digits(randomDigits);
    // console.log(max_t); //REMOVED

    randomNumber1 = Math.floor(Math.random() * max_t);
    randomNumber2 = Math.floor(Math.random() * max_t);
    //randomNumber1 = 35818;
    //randomNumber2 = 81842;
    $("#randomNumber1").prop("value", randomNumber1);
    $("#randomNumber2").prop("value", randomNumber2);
    $("#subject_number1_p").html(randomNumber1);
    $("#subject_number2_p").html(randomNumber2);
    $("#answerPane").html('<div id="lastDiv"></div>');
    $("#examPane").show();
    $("#lastDiv2").html("");

    var large_num = randomNumber1 > randomNumber2 ? randomNumber1 : randomNumber2;
    max_digit = getDigitsCouunt(large_num);

    step_count = 0;
}

function getDigitNum(checkNumber, digitPosition) {
    digitPosition--;
    checkNumber = parseInt(((checkNumber - checkNumber % digits(digitPosition)) / digits(digitPosition)) % 10);
    return checkNumber;
}

function checkAnswer(elem) {
    answer_val = parseInt(elem.prop("value"));
    if(isNaN(answer_val)) return false;
    elem.prop("value", answer_val);
    setAnswered(answer_val);
    return true;
}

function checkAnswer2(elem) {
    answer_val = parseInt(elem.prop("value"));
    if((answer_val * 1 < 0) || (answer_val * 1 > 19)) return false;
    return true;
}

function checkAnswerValidation(elem) {
    answer_val = parseInt(elem.prop("value"));
    correct_answer = getDigitNum(randomNumber1, step_count) * 1 + getDigitNum(randomNumber2, step_count) * 1;
    if(carry_over) correct_answer++;
    if (answer_val == correct_answer){
        carry_over = false;
        return correct_answer;
    }
    if(retry_attempt > 1){
        // alert("Correct Answer is " + correct_answer + ". Retry! ");
        alertModal("Correct Answer is " + correct_answer + ". Retry! ");
        retry_attempt = 0;
        return -3;
    }
    if (answer_val > correct_answer) return -1;
    return -2;
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
    result += "<p align=right style='width:100px;'>";

    for(i=getDigitsCouunt(randomNumber1); i >= 1; i--){
        result += getDigitNum(randomNumber1, i) + " ";
    }
    result += "</p>";
    result += "<p align=right style='width:100px;'> + ";
    if(diff_space > 0) result += "  ";

    for(i=getDigitsCouunt(randomNumber2); i >= 1; i--){
        result += getDigitNum(randomNumber2, i) + " ";
    }

    result += "</p>";
    result += "<p align=right style='width:100px;'> --";
    for(i=getDigitsCouunt(randomNumber2); i >= 1; i--)
        result += "--";
    result += "</p>";
    for(i=1; i<=max_digit; i++){
        result += "<p align=left style='text-indent:10px;'>";
        result += "Step " + i + " : Add the " + step_words[i - 1];
        result += "</p>";
        result += "<p align=left style='text-indent:20px;'>";
        if((getDigitsCouunt(randomNumber1) >= i)&&(getDigitsCouunt(randomNumber2) >= i)){
            result += getDigitNum(randomNumber1, i) + " + " + getDigitNum(randomNumber2, i) + " = " + (getDigitNum(randomNumber1, i) + getDigitNum(randomNumber2, i));
            max_sum = (getDigitNum(randomNumber1, i) + getDigitNum(randomNumber2, i));
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
        if((i>1)&&carr_over_var2[i-2]){
            if(carr_over_var2[i-2] != carr_over_var[i-2]){
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
        if(carr_over_var2[i-1]){
            if(carr_over_var2[i-1] != carr_over_var[i-1]){
                result += "<p align=left style='text-indent:20px;color:red;'>Carry 1</p>";
            } else {
                result += "<p align=left style='text-indent:20px;'>Carry 1</p>";
            }
        }
    }
    if(carr_over_var2[i-2])
        total_result = "1" + total_result;

    result += "<p align=left style='text-indent:10px;'>Total:</p>";
    result += "<p align=left style='text-indent:20px;'>" + total_result + "</p>";

    $("#lastDiv3").html(result);

}

function displayTotalFlow(){
    diff_space = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2);
    result = "<p>Add</p>";
    result += "<p align=right style='width:100px;'>";

    for(i=getDigitsCouunt(randomNumber1); i >= 1; i--){
        result += getDigitNum(randomNumber1, i) + " ";
    }
    result += "</p>";
    result += "<p align=right style='width:100px;'> + ";
    if(diff_space > 0) result += "  ";

    for(i=getDigitsCouunt(randomNumber2); i >= 1; i--){
        result += getDigitNum(randomNumber2, i) + " ";
    }

    result += "</p>";
    result += "<p align=right style='width:100px;'> --";
    for(i=getDigitsCouunt(randomNumber2); i >= 1; i--)
        result += "--";
    result += "</p>";
    for(i=1; i<=max_digit; i++){
        result += "<p align=left style='text-indent:10px;' class='h4'>"; // ADDED
        result += "Step " + i + " : Add the " + step_words[i - 1];
        result += "</p>";
        result += "<p align=left style='text-indent:20px;'>";
        if((getDigitsCouunt(randomNumber1) >= i)&&(getDigitsCouunt(randomNumber2) >= i)){
            result += getDigitNum(randomNumber1, i) + " + " + getDigitNum(randomNumber2, i) + " = " + (getDigitNum(randomNumber1, i) + getDigitNum(randomNumber2, i));
            max_sum = (getDigitNum(randomNumber1, i) + getDigitNum(randomNumber2, i));
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
        if((i>1)&&carr_over_var[i-2]){
            result += "<p align=left style='text-indent:20px;'>Add the carried 1</p>";
            result += "<p align=left style='text-indent:20px;'>" + max_sum + " + 1 = " + (max_sum + 1) + "</p>";
            max_sum++;
        }
        result += "<p align=left style='text-indent:20px;'>Keep the " + (max_sum % 10) + "</p>";
        if(carr_over_var[i-1]){
            result += "<p align=left style='text-indent:20px;'>Carry 1</p>";
        }
    }

    result += "<p align=left style='text-indent:10px;'>Total:</p>";
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
    $(".inputCheck").prop("value", str_answer);
    displayTotalFlow();
    displayTotalFlow2();
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
    result = "<p>Add</p>";
    result += "<p align=right style='width:100px;'>";

    for(i=getDigitsCouunt(randomNumber1); i >= 1; i--){

        if ((step_count+1) == i) {
            result += "<label style='color:blue'>" + getDigitNum(randomNumber1, i) + "&nbsp;" + "</label>";
        }else{
            result += getDigitNum(randomNumber1, i) + " ";
        }
    }
    result += "</p>";
    result += "<p align=right style='width:100px;'> + ";
    if(diff_space > 0) result += "  ";

    for(i=getDigitsCouunt(randomNumber2); i >= 1; i--){
        if ((step_count+1) == i) {
            result += "<label style='color:blue'>" + getDigitNum(randomNumber2, i) + "&nbsp;" + "</label>";
        }else{
            result += getDigitNum(randomNumber2, i) + " ";
        }
    }

    result += "</p>";

    carr_over_var[step_count] = false;
    carr_over_var2[step_count] = false;
    $(".answer_value").unbind("keydown").removeClass("inputCheck").attr("readonly", true);
    $("<p style='margin-top: 20px;'>Step " + (step_count + 1) + ": Add the " + step_words[step_count] + "</p>" + result + "<input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                // alert("That is incorrect. Answer cannot be blank and can only be numbers. Please retry. !");
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

                // $("#message_modal").show();
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
    carry_over = true;
    $("#message_modal_dynamic").hide();
    gotoNextLevel();
}

function btnNOOnclick(){
    carr_over_var2[step_count - 1] = true;
    carry_over = false;
    $("#message_modal_dynamic").hide();
    gotoNextLevel();
}

function btnNOOnclose() {
    $("#message_modal_dynamic").hide();
}


function getDigitsCouunt(number){

    digitsCount = 0;

    while(number >= 1){
        number = number / 10;
        digitsCount ++;
    }

    return digitsCount;
}
