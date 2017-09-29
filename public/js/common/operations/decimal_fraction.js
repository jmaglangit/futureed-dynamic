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

var step1_count = 0;
var step2_count = 0;
var step3_count = 0;
var step6_count = 0;
var step4_count = 0;
var step5_count = 0;

var factorX = 1;
var An = 0;
var Ad = 0;

var step3Flag = false;
var step2Flag = false;

var arry_correctval = [];
var arry_total = [];
var arry_temp = [];
var arry_step1_temp = [];
var arry_step2_temp = [];
var arry_step4_temp = [];
var arry_step5_temp = [];

var decimal_count_words = ["", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten"];

var answered = []; //ADDED

// nerubia code
// start ADDED functions
//getter and setter

function getInteger(){
    return str_interger;
}

function getDecimal(){
    return str_decimal;
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

function alertModal(message, modal){
    dynamicBlock();
    $("#message_text_modal").html(message);
    $("#message_modal_dynamic").show();
    $("#close_modal").show();
    $("#close_back_modal").hide();
    $("#yes_modal").hide();
    $("#no_modal").hide();
    $("#can_modal").hide();

    $("#close_modal").bind("click",{modal}, function(){
        switch(modal){
            case 0: digitsTheSameModal();break;
            default: closeModal();break;
        }
        return false;
    });
}

function alertBackModal(message){
    dynamicBlock();
    $("#message_text_modal").html(message);
    $("#message_modal_dynamic").show();
    $("#close_back_modal").hide();
    $("#no_modal").hide();
    $("#close_modal").hide();
    $("#yes_modal").hide();
    $("#can_modal").show();
}

function digitsTheSameModal(){
    dynamicBlock();
    $("#message_text_modal").html("Are the digits the same?  If Yes move on, if No,");
    $("#message_modal_dynamic").show();
    $("#close_modal").hide();
    $("#close_back_modal").hide();
    $("#yes_modal").show();
    $("#no_modal").show();
}

function closeModal() {
    dynamicUnBlock();
    $("#message_modal_dynamic").modal('hide');
}

function simplifyPossible(){
    dynamicBlock();
    $("#message_text_modal").html('Can you simplify the fraction?');
    $("#message_modal_dynamic").show();
    $("#close_modal").hide();
    $("#close_back_modal").hide();
    $("#yes_modal").show();
    $("#no_modal").show();
    $("#can_modal").hide();
}

function cantSimplify(){
    dynamicBlock();
    $("#message_text_modal").html('Fraction is already in its simplest form.');
    $("#message_modal_dynamic").show();
    $("#close_modal").hide();
    $("#close_back_modal").hide();
    $("#yes_modal").hide();
    $("#no_modal").hide();
    $("#can_modal").show();
}

// end ADDED functions

var result_str1 = "";
var result_str = "";
var result_str_all = "";
result_str_all += '<table>';
result_str_all += '<tr>';
result_str_all += '<td align="center"><input type="text" class="inputCheck1"></td>';
result_str_all += '</tr>';
result_str_all += '<tr>';
result_str_all += '<td bgcolor="#000000" height="2"></td>';
result_str_all += '</tr>';
result_str_all += '<tr>';
result_str_all += '<td align="center"><input type="text" class="inputCheck2"></td>';
result_str_all += '</tr>';
result_str_all += '</table>';

var result_str_all_re = "";
result_str_all_re += '<table>';
result_str_all_re += '<tr>';
result_str_all_re += '<td rowspan="3" align="center"> = </td>';
result_str_all_re += '<td align="center"><input type="text" class="inputCheck1"></td>';
result_str_all_re += '</tr>';
result_str_all_re += '<tr>';
result_str_all_re += '<td bgcolor="#000000" height="2"></td>';
result_str_all_re += '</tr>';
result_str_all_re += '<tr>';
result_str_all_re += '<td align="center"><input type="text" class="inputCheck2"></td>';
result_str_all_re += '</tr>';
result_str_all_re += '</table>';

var result_str_answer = "";





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

    step1_count = 0;
    step2_count = 0;
    step3_count = 0;
    step6_count = 0;
    step4_count = 0;
    step5_count = 0;

    factorX = 1;
    An = 0;
    Ad = 0;

    step3Flag = false;
    step2Flag = false;

    arry_correctval = [];
    arry_total = [];
    arry_temp = [];
    arry_step1_temp = [];
    arry_step2_temp = [];
    arry_step3_temp = [];
    arry_step6_temp = [];
    arry_step4_temp = [];
    arry_step5_temp = [];


    result_str1 = "";
    result_str = "";
    result_str_answer = "";

    randomDigits1 = parseInt($(".randomDigits1").prop("value"));
    min = 0.05;
    randomDigits2 = parseInt($(".randomDigits2").prop("value"));

    if(isNaN(randomDigits1)) {
        randomDigits1 = 1;
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
    console.log(str_interger + "---" + str_decimal);
    randomIndex = Math.floor(Math.random() * str_decimal.length);

    max_digit = real_number.length + 3;

    An = Math.abs( randomNumber * digits(str_decimal.length) );
    Ad = Math.abs( digits(str_decimal.length));

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

    An=(An/factorX);
    Ad=Ad/factorX;
    result_str_answer += '<table style="display:inline-block">';
    result_str_answer += '<tr>';
    result_str_answer += '<td align="center">'+ (digits(str_decimal.length) * randomNumber) +'</td>';
    result_str_answer += '</tr>';
    result_str_answer += '<tr>';
    result_str_answer += '<td bgcolor="#000000" height="2"></td>';
    result_str_answer += '</tr>';
    result_str_answer += '<tr>';
    result_str_answer += '<td align="center">'+ digits(str_decimal.length) +'</td>';
    result_str_answer += '</tr>';
    result_str_answer += '</table>';

    $("#correct_flow_answer").html("");
    $("#correct_flow").html("");
    $("#lastDiv").html("");
    $("#step_div").html('<br><br><br><div id="tableNumber_div"></div><div id="lastDiv"></div>');
    $("#tableNumber_div").html("");

    $("#str_interger_b").html(str_interger);
    $("#str_decimal_b").html(str_decimal);
    $("#start_div").show();
}

function btnNOOnclick() {
    alertBackModal("That is incorrect. Fraction can be simplified. Please retry.");
}

function canbtnYEsOnclick(){
    // $("#myModal2").hide();
    closeModal();
    nextsetp();
}

function startBtnOnclick(){
    step_count++;
    retry_attempt = 0;
    $("#step_div").show();

    result_str1 += '<table>';

    result_str1 += '<tr>';
    result_str1 += '<td align="center"><input type="text" class="widthtable inputCheck1"></td>';
    result_str1 += '<td rowspan="3" align="center"> x </td>';
    result_str1 += '<td align="center"><input type="text" class="widthtable inputCheck3"></td>';
    result_str1 += '<td rowspan="3" align="center" style="display:none" class="hid_input"> = </td>';
    result_str1 += '<td align="center"><input type="text" style="display:none" class="hid_input widthtable inputCheck5"></td>';
    result_str1 += '</tr>';
    result_str1 += '<tr>';
    result_str1 += '<td bgcolor="#000000" height="2"></td>';
    result_str1 += '<td bgcolor="#000000" height="2"></td>';
    result_str1 += '<td bgcolor="#000000" height="2"></td>';
    result_str1 += '</tr>';
    result_str1 += '<tr>';
    result_str1 += '<td align="center"><input type="text" class="widthtable inputCheck2"></td>';
    result_str1 += '<td align="center"><input type="text" class="widthtable inputCheck4"></td>';
    result_str1 += '<td align="center"><input type="text" style="display:none" class="hid_input widthtable inputCheck6"></td>';
    result_str1 += '</tr>		';
    result_str1 += '</table>';
    if (step_count == 1) {
        result_str = "<div>";
        result_str += "<p>Step " + step_count +":  First write the decimal in fraction form.  Example (0.5/1) .</p>";
        result_str += result_str_all;
        result_str += "</div>";
        $("#tableNumber_div").html(result_str);
    }

    $(".inputCheck1").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer can’t be blank and can only be a numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }

            temp_answer = checkAnswerValidation($(this));
            if(temp_answer == -1){
                alertModal("Your answer is larger than what we need.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(temp_answer == -2){
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
            $(".inputCheck2").keydown(function(event){
                if(event.keyCode == 13){
                    if(checkAnswer($(this)) == false){
                        alertModal("That is incorrect. Answer can’t be blank and can only be a numbers. Please retry.");
                        $(this).prop("value", "").focus();
                        retry_attempt++;
                        return false;
                    }

                    temp_answer = checkAnswerValidation($(this));
                    if(temp_answer == -1){
                        alertModal("Your answer is larger than what we need.");
                        $(this).prop("value", "").focus();
                        retry_attempt++;
                        return false;
                    }
                    if(temp_answer == -2){
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
    }).focus();
}

function btnYEsOnclick(){
    // $("#hide_label").show();
    $("#hide_label").css("display", "inline-block");
    $(".inputCheck1").focus();
    $("#myModal").hide();
}

function nextsetp(){
    step2Str = "";
    step2Str += "<br>"; //ADDED
    step2Str += "<input type=text placeholder='answer' style='width:50px;' class='inputCheckstep2Str1'> x <input type=text style='width:50px;' placeholder='answer' class='inputCheckstep2Str2'> = <input type=text style='width:50px;' placeholder='answer' class='inputCheckstep2Str3'>"
    step2Str += "<br>";

    retry_attempt = 0;
    step_count++;
    if (step_count == 2) {
        $("<p>Step " + step_count + " :  Convert the decimal in the numerator into a whole number.</p>" + step2Str).insertBefore("#lastDiv");
        return step1Func();

    }

    if (step_count == 3) {
        $("<p>Step " + step_count + " : Multiply the denominator by the same number.</p>" + step2Str).insertBefore("#lastDiv");
        return step1Func();
    }
    if (step_count == 4) {
        $("<p>Step " + step_count + " : What is the new number .<br></p>" + result_str_all).insertBefore("#lastDiv");
    }

    if (step_count == 5) {
        $("<p>Step " + step_count + " : Simplify the fraction.<br><div>" + result_str_answer + "<label id='hide_label' style='display:none;'>" + result_str_all_re + "</label></div></p>").insertBefore("#lastDiv");
        if (factorX == 1) {
            // $("#myModal2").show();
            cantSimplify();
        }else{
            // $("#myModal").show();
            simplifyPossible();
        }
    }

    if (step_count == 6) {
        $("<p>Step " + step_count + " : Answer. <br>" + result_str_all).insertBefore("#lastDiv");
    }
    if (step_count > 6) {
        answerDone(); //ADDED
        displayTotalFlow();
        displayTotalFlow1();
    }

    $(".inputCheck1").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer can’t be blank and can only be a numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }

            temp_answer = checkAnswerValidation($(this));
            if(temp_answer == -1){
                alertModal("Your answer is larger than what we need.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(temp_answer == -2){
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
            $(".inputCheck2").keydown(function(event){
                if(event.keyCode == 13){
                    if(checkAnswer($(this)) == false){
                        alertModal("That is incorrect. Answer can’t be blank and can only be a numbers. Please retry.");
                        $(this).prop("value", "").focus();
                        retry_attempt++;
                        return false;
                    }

                    temp_answer = checkAnswerValidation($(this));
                    if(temp_answer == -1){
                        alertModal("Your answer is larger than what we need.");
                        $(this).prop("value", "").focus();
                        retry_attempt++;
                        return false;
                    }
                    if(temp_answer == -2){
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
    }).focus();
}

function step3Func() {
    // body...
    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer can’t be blank and can only be a numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }

            temp_answer = checkAnswerValidation($(this));
            if(temp_answer == -1){
                alertModal("Your answer is larger than what we need.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(temp_answer == -2){
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

function middleFunc() {
    $(".inputCheck").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer can’t be blank and can only be a numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }

            temp_answer = checkAnswerValidation($(this));
            if(temp_answer == -1){
                alertModal("Your answer is larger than what we need.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(temp_answer == -2){
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

function step1Func() {
    $(".inputCheckstep2Str1").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer can’t be blank and can only be a numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }

            temp_answer = checkAnswerValidation($(this));
            if(temp_answer == -1){
                alertModal("Your answer is larger than what we need.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(temp_answer == -2){
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
            $(".inputCheckstep2Str2").keydown(function(event){
                if(event.keyCode == 13){
                    if(checkAnswer($(this)) == false){
                        alertModal("That is incorrect. Answer can’t be blank and can only be a numbers. Please retry.");
                        $(this).prop("value", "").focus();
                        retry_attempt++;
                        return false;
                    }

                    temp_answer = checkAnswerValidation($(this));
                    if(temp_answer == -1){
                        alertModal("Your answer is larger than what we need.");
                        $(this).prop("value", "").focus();
                        retry_attempt++;
                        return false;
                    }
                    if(temp_answer == -2){
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
                    $(".inputCheckstep2Str3").keydown(function(event){
                        if(event.keyCode == 13){
                            if(checkAnswer($(this)) == false){
                                alertModal("That is incorrect. Answer can’t be blank and can only be a numbers. Please retry.");
                                $(this).prop("value", "").focus();
                                retry_attempt++;
                                return false;
                            }

                            temp_answer = checkAnswerValidation($(this));
                            if(temp_answer == -1){
                                alertModal("Your answer is larger than what we need.");
                                $(this).prop("value", "").focus();
                                retry_attempt++;
                                return false;
                            }
                            if(temp_answer == -2){
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
            }).focus();
        }
    }).focus();
}

function checkAnswerValidation(elem) {

    answer_val = elem.prop("value");

    if (step_count == 1) {
        step1_count++;

        if (step1_count == 1) {
            correct_answer = randomNumber;

            if (answer_val == correct_answer){
                retry_attempt = 0;
                return correct_answer;
            }
        }

        if (step1_count == 2) {
            correct_answer = 1;

            if (answer_val == correct_answer){

                return correct_answer;
            }
        }
        if (answer_val > correct_answer) {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Retry! ");
                step1_count--;
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_step1_temp[step1_count]) {
                    arry_step1_temp[step1_count] = answer_val;
                }
                step1_count--;

                return -1;
            }
        }else {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry.");
                step1_count--;
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_step1_temp[step1_count]) {
                    arry_step1_temp[step1_count] = answer_val;
                }
                step1_count--;

                return -2;
            }
        }
    }

    if (step_count == 2) {
        step2_count++;

        if (step2_count == 1) {
            correct_answer = randomNumber;

            if (answer_val == correct_answer){
                retry_attempt = 0;
                return correct_answer;
            }
        }

        if (step2_count == 2) {
            correct_answer = digits(str_decimal.length);
            retry_attempt = 0;
            if (answer_val == correct_answer){
                return correct_answer;
            }
        }
        if (step2_count == 3) {
            correct_answer = digits(str_decimal.length)*1 * randomNumber*1;

            if (answer_val == correct_answer){
                return correct_answer;
            }
        }


        if (answer_val > correct_answer) {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry.");
                step2_count--;
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_step2_temp[step2_count]) {
                    arry_step2_temp[step2_count] = answer_val;
                }
                step2_count--;

                return -1;
            }
        }else {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry.");
                step2_count--;
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_step2_temp[step2_count]) {
                    arry_step2_temp[step2_count] = answer_val;
                }
                step2_count--;

                return -2;
            }
        }
    }
    if (step_count == 3) {
        step3_count++;

        if (step3_count == 1) {
            correct_answer = 1;
            retry_attempt = 0;
            if (answer_val == correct_answer){

                return correct_answer;
            }
        }

        if (step2_count == 2) {
            correct_answer = digits(str_decimal.length);
            retry_attempt = 0;
            if (answer_val == correct_answer){
                return correct_answer;
            }
        }
        if (step2_count == 3) {
            correct_answer = digits(str_decimal.length)*1;

            if (answer_val == correct_answer){
                return correct_answer;
            }
        }


        if (answer_val > correct_answer) {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry.");
                step3_count--;
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_step3_temp[step3_count]) {
                    arry_step3_temp[step3_count] = answer_val;
                }
                step2_count--;

                return -1;
            }
        }else {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry.");
                step3_count--;
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_step3_temp[step3_count]) {
                    arry_step3_temp[step3_count] = answer_val;
                }
                step3_count--;

                return -2;
            }
        }
    }

    if (step_count == 4) {
        step4_count++;

        if (step4_count == 1) {
            correct_answer = randomNumber * digits(str_decimal.length);

            if (answer_val == correct_answer){
                retry_attempt = 0;
                return correct_answer;
            }
        }

        if (step4_count == 2) {
            correct_answer = digits(str_decimal.length);

            if (answer_val == correct_answer){
                return correct_answer;
            }
        }

        if (answer_val > correct_answer) {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry.");
                step4_count--;
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_step4_temp[step4_count]) {
                    arry_step4_temp[step4_count] = answer_val;
                }
                step2_count--;

                return -1;
            }
        }else {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry.");
                step4_count--;
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_step4_temp[step4_count]) {
                    arry_step4_temp[step4_count] = answer_val;
                }
                step4_count--;

                return -2;
            }
        }
    }
    if (step_count == 5) {
        An = Math.abs( randomNumber * digits(str_decimal.length) );
        Ad = Math.abs( digits(str_decimal.length));

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
        step5_count++;


        if (step5_count == 1) {
            correct_answer = An;

            if (answer_val == correct_answer){
                retry_attempt = 0;
                return correct_answer;
            }
        }

        if (step5_count == 2) {
            correct_answer = Ad;

            if (answer_val == correct_answer){
                return correct_answer;
            }
        }

        if (answer_val > correct_answer) {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry.");
                step5_count--;
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_step5_temp[step5_count]) {
                    arry_step5_temp[step5_count] = answer_val;
                }
                step5_count--;

                return -1;
            }
        }else {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry.");
                step5_count--;
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_step5_temp[step5_count]) {
                    arry_step5_temp[step5_count] = answer_val;
                }
                step5_count--;

                return -2;
            }
        }
    }
    if (step_count == 6) {
        An = Math.abs( randomNumber * digits(str_decimal.length) );
        Ad = Math.abs( digits(str_decimal.length));

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

        step6_count++;


        if (step6_count == 1) {
            correct_answer = An;

            if (answer_val == correct_answer){

                return correct_answer;
            }
        }

        if (step6_count == 2) {
            correct_answer = Ad;
            retry_attempt = 0;
            if (answer_val == correct_answer){
                return correct_answer;
            }
        }

        if (answer_val > correct_answer) {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry.");
                step6_count--;
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_step6_temp[step6_count]) {
                    arry_step6_temp[step6_count] = answer_val;
                }
                step6_count--;

                return -1;
            }
        }else {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry.");
                step6_count--;
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_step6_temp[step6_count]) {
                    arry_step6_temp[step6_count] = answer_val;
                }
                step6_count--;

                return -2;
            }
        }
    }
}

function checkAnswer(elem) {
    if (step_count * 1 == 4) {
        answer_val = elem.prop("value");
        return true;
    }else{
        answer_val = elem.prop("value");
        if(answer_val == "") return false;
        elem.prop("value", answer_val);
    }
}

function displayTotalFlow(){
    result_str = "";
    result_str += "<b style='color:blue'>Answered Flow</b>";
    result_str += "<br><br>";
    result_str += "<div id='start_div'>";
    result_str += '<label>Convert <b>'+ real_number + '</b> into a fraction.</label>';
    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 1: First write the decimal in fraction form.  Example (0.5/1)</p>";
    if (arry_step1_temp[1]) {
        result_str += "<p style='color:red;'> Error : " + arry_step1_temp[1] + "</p>";
    }
    if (arry_step1_temp[2]) {
        result_str += "<p style='color:red;'> Error : " + arry_step1_temp[2] + "</p>";
    }
    result_str += '<table>';

    result_str += '<tr>';
    result_str += '<td align="center"><font color=blue>'+ real_number +'</font></td>';
    result_str += '</tr>';
    result_str += '<tr>';
    result_str += '<td bgcolor="#000000" height="2"></td>';
    result_str += '</tr>';
    result_str += '<tr>';
    result_str += '<td align="center"><font color=blue>1</font></td>';
    result_str += '</tr>';
    result_str += '</table>';
    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 2: Convert the decimal in the numerator into a whole number.</p>";

    if (arry_step2_temp[1]) {
        result_str += "<p style='color:red;'> Error : " + arry_step2_temp[1] + "</p>";
    }
    if (arry_step2_temp[2]) {
        result_str += "<p style='color:red;'> Error : " + arry_step2_temp[2] + "</p>";
    }
    if (arry_step2_temp[3]) {
        result_str += "<p style='color:red;'> Error : " + arry_step2_temp[3] + "</p>";
    }
    result_str += "<p>"+ randomNumber +" x "+ digits(str_decimal.length) +" = " + digits(str_decimal.length)*randomNumber + "</p>";

    result_str += "<p>Note the conversion depends on how many decimal points there are.</p>";
    for (var i = 1; i <= str_decimal.length; i++) {
        result_str += "<p>"+ decimal_count_words[i] +" decimal point you multiply by "+ digits(i) +"</p>";
    }

    result_str += "<p>Step 3: Multiply the denominator by the same number.</p>";
    if (arry_step3_temp[1]) {
        result_str += "<p style='color:red;'> Error : " + arry_step3_temp[1] + "</p>";
    }
    if (arry_step3_temp[2]) {
        result_str += "<p style='color:red;'> Error : " + arry_step3_temp[2] + "</p>";
    }
    if (arry_step3_temp[3]) {
        result_str += "<p style='color:red;'> Error : " + arry_step3_temp[3] + "</p>";
    }

    result_str += "<p> 1 x "+ digits(str_decimal.length) +" = " + digits(str_decimal.length) + "</p>";
    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 4: What is the new number.</p>";
    if (arry_step4_temp[1]) {
        result_str += "<p style='color:red;'> Error : " + arry_step4_temp[1] + "</p>";
    }
    if (arry_step4_temp[2]) {
        result_str += "<p style='color:red;'> Error : " + arry_step4_temp[2] + "</p>";
    }
    result_str += '<table>';
    result_str += '<tr>';
    result_str += '<td rowspan="3" align="center">The new number is </td>';
    result_str += '<td align="center"><font color=blue>'+ randomNumber*digits(str_decimal.length) +'</font></td>';
    result_str += '</tr>';
    result_str += '<tr>';
    result_str += '<td bgcolor="#000000" height="2"></td>';
    result_str += '</tr>';
    result_str += '<tr>';
    result_str += '<td align="center"><font color=blue>'+ digits(str_decimal.length) + '</font></td>';
    result_str += '</tr>';
    result_str += '</table>';


    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 5: Simplify the fraction.</p>";
    if (arry_step5_temp[1]) {
        result_str += "<p style='color:red;'> Error : " + arry_step5_temp[1] + "</p>";
    }
    if (arry_step5_temp[2]) {
        result_str += "<p style='color:red;'> Error : " + arry_step5_temp[2] + "</p>";
    }
    if (factorX == 1) {
        result_str += '<table>';
        result_str += '<tr>';
        result_str += '<td rowspan="3" align="center">We can simplify </td>';
        result_str += '<td align="center"><font color=blue>'+ randomNumber*digits(str_decimal.length) +'</font></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td bgcolor="#000000" height="2"></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td align="center"><font color=blue>'+ digits(str_decimal.length) + '</font></td>';
        result_str += '</tr>';
        result_str += '</table>';
    }else{
        result_str += '<table>';
        result_str += '<tr>';
        result_str += '<td rowspan="3" align="center">We can simplify </td>';
        result_str += '<td align="center"><font color=blue>'+ randomNumber*digits(str_decimal.length) +'</font></td>';
        result_str += '<td rowspan="3" align="center"> into </td>';
        result_str += '<td align="center"><font color=blue>'+ An +'</font></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td bgcolor="#000000" height="2"></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td align="center"><font color=blue>'+ digits(str_decimal.length) + '</font></td>';
        result_str += '<td align="center"><font color=blue>'+ Ad + '</font></td>';
        result_str += '</tr>';
        result_str += '</table>';
    }
    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step : Answer.</p>";
    if (arry_step6_temp[1]) {
        result_str += "<p style='color:red;'> Error : " + arry_step6_temp[1] + "</p>";
    }
    if (arry_step6_temp[2]) {
        result_str += "<p style='color:red;'> Error : " + arry_step6_temp[2] + "</p>";
    }
    if (factorX == 1) {
        result_str += '<table>';
        result_str += '<tr>';
        result_str += '<td rowspan="3" align="center">The answer is </td>';
        result_str += '<td align="center"><font color=blue>'+ randomNumber*digits(str_decimal.length) +'</font></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td bgcolor="#000000" height="2"></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td align="center"><font color=blue>'+ digits(str_decimal.length) + '</font></td>';
        result_str += '</tr>';
        result_str += '</table>';
    }else{
        result_str += '<table>';
        result_str += '<tr>';
        result_str += '<td rowspan="3" align="center">The answer is </td>';
        result_str += '<td align="center"><font color=blue>'+ An +'</font></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td bgcolor="#000000" height="2"></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td align="center"><font color=blue>'+ Ad + '</font></td>';
        result_str += '</tr>';
        result_str += '</table>';
    }
    result_str += "</div>";
    $("#correct_flow").html(result_str);

}

function displayTotalFlow1(){
    result_str = "";
    result_str += "<b style='color:blue'>Correct Answered Flow</b>";
    result_str += "<br><br>";
    result_str += "<div id='start_div'>";
    result_str += '<label>Convert <b>'+ real_number + '</b> into a fraction.</label>';
    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 1: First write the decimal in fraction form.  Example (0.5/1)</p>";
    result_str += '<table>';
    result_str += '<tr>';
    result_str += '<td align="center"><font color=blue>'+ real_number +'</font></td>';
    result_str += '</tr>';
    result_str += '<tr>';
    result_str += '<td bgcolor="#000000" height="2"></td>';
    result_str += '</tr>';
    result_str += '<tr>';
    result_str += '<td align="center"><font color=blue>1</font></td>';
    result_str += '</tr>';
    result_str += '</table>';
    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 2: Convert the decimal in the numerator into a whole number.</p>";

    result_str += "<p>"+ randomNumber +" x "+ digits(str_decimal.length) +" = " + digits(str_decimal.length)*randomNumber + "</p>";

    result_str += "<p>Note the conversion depends on how many decimal points there are.</p>";
    for (var i = 1; i <= str_decimal.length; i++) {
        result_str += "<p>"+ decimal_count_words[i] +" decimal point you multiply by "+ digits(i) +"</p>";
    }

    result_str += "<p>Step 3: Multiply the denominator by the same number.</p>";

    result_str += "<p> 1 x "+ digits(str_decimal.length) +" = " + digits(str_decimal.length) + "</p>";
    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 4: What is the new number.</p>";

    result_str += '<table>';
    result_str += '<tr>';
    result_str += '<td rowspan="3" align="center">The new number is </td>';
    result_str += '<td align="center"><font color=blue>'+ randomNumber*digits(str_decimal.length) +'</font></td>';
    result_str += '</tr>';
    result_str += '<tr>';
    result_str += '<td bgcolor="#000000" height="2"></td>';
    result_str += '</tr>';
    result_str += '<tr>';
    result_str += '<td align="center"><font color=blue>'+ digits(str_decimal.length) + '</font></td>';
    result_str += '</tr>';
    result_str += '</table>';


    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 5: Simplify the fraction.</p>";

    if (factorX == 1) {
        result_str += '<table>';
        result_str += '<tr>';
        result_str += '<td rowspan="3" align="center">We can simplify </td>';
        result_str += '<td align="center"><font color=blue>'+ randomNumber*digits(str_decimal.length) +'</font></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td bgcolor="#000000" height="2"></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td align="center"><font color=blue>'+ digits(str_decimal.length) + '</font></td>';
        result_str += '</tr>';
        result_str += '</table>';
    }else{
        result_str += '<table>';
        result_str += '<tr>';
        result_str += '<td rowspan="3" align="center">We can simplify </td>';
        result_str += '<td align="center"><font color=blue>'+ randomNumber*digits(str_decimal.length) +'</font></td>';
        result_str += '<td rowspan="3" align="center"> into </td>';
        result_str += '<td align="center"><font color=blue>'+ An +'</font></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td bgcolor="#000000" height="2"></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td align="center"><font color=blue>'+ digits(str_decimal.length) + '</font></td>';
        result_str += '<td align="center"><font color=blue>'+ Ad + '</font></td>';
        result_str += '</tr>';
        result_str += '</table>';
    }
    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step : Answer.</p>";
    if (factorX == 1) {
        result_str += '<table>';
        result_str += '<tr>';
        result_str += '<td rowspan="3" align="center">The answer is </td>';
        result_str += '<td align="center"><font color=blue>'+ randomNumber*digits(str_decimal.length) +'</font></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td bgcolor="#000000" height="2"></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td align="center"><font color=blue>'+ digits(str_decimal.length) + '</font></td>';
        result_str += '</tr>';
        result_str += '</table>';
    }else{
        result_str += '<table>';
        result_str += '<tr>';
        result_str += '<td rowspan="3" align="center">The answer is </td>';
        result_str += '<td align="center"><font color=blue>'+ An +'</font></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td bgcolor="#000000" height="2"></td>';
        result_str += '</tr>';
        result_str += '<tr>';
        result_str += '<td align="center"><font color=blue>'+ Ad + '</font></td>';
        result_str += '</tr>';
        result_str += '</table>';
    }
    result_str += "</div>";
    $("#correct_flow_answer").html(result_str);

}