/**
 * Code from client
 * 20170825
 */

var randomNumber = 0;
var randomNumber3 = 0;
var step_count = 0;
var real_number = "";
var str_interger = "";
var str_decimal = "";
var posDot = 0;
var checkIndex = 0;
var checkIndex1 = 0;
var correct_answer = "";
var maxstepNumber = 0;
var compareNumber = 0;
var str_interger1 = 0;
var str_interger2 = 0;
var str_decimal1 = 0;
var str_decimal2 = 0;
var numCount1 = 1;
var numCount2 = 2;
var arry_finalIndex = [];
var finalIndex = 0;
var small_step_count = 0;

var erroEnd1 = 0;
var erroEnd2 = 0;
var erroEnd3 = 0;

var total_val2 = 0;
var total_val3 = 0;
var total_val6 = 0;

var nextFlag = false;
var integer_decimalFlag = false;

var arry_correctval = [];
var arry_checkIdx = [];
var arry_checkIdx1 = [];
var arry_total = [];
var arry_temp = [];
var arry_compnum_idx = [1, 2, 2, 3, 1, 3];
var comp_step = 0;
var arry_randomNumber = [];
var askcompnum_step = 11;
var cur_comnum_idx = 0;
var arry_comp_result = [];
var arry_randomDecimals = [];

var An = 0;
var Ad = 0;
var factorX = 1;
var randomNumber2 = 0;
var ret = 0;
var step2_count = 0;
var step3_count = 0;
var step5_count = 0;
var step6_count = 0;
var step7_count = 0;

var arry_err_step2 = [];
var arry_err_step3 = [];
var arry_err_step5 = [];
var arry_err_step6 = [];
var arry_err_step7 = [];

var number_up_words = ["Ones", "Tens", "Hundreds", "Thousands", "Ten Thousands", "Hundred Thousands", "Millions", "Ten Millions", "Hundred Millions"];
var decimal_up_words = [ "Tenths", "Hundredths","Thousandths", "Ten Thousandths",  "Hundred Thousandths", "Millionths", "Ten Millionths", "Hundred Millionths"];

var ths_words = ["first", "second", "third", "fourth","fifth", "sixth", "seventh", "eighth", "nineth", "tenth"];

var number_low_words = ["ones", "tens", "hundreds", "thousands", "ten thousands", "hundred thousands", "tillions", "ten millions", "hundred millions"];
var decimal_low_words_temp = ["ones", "tenths", "hundredths","thousandths", "ten thousandths",  "hundred thousandths", "millionths", "ten millionths", "hundred millionths"];

var decimal_low_words = ["tenths", "hundredths","thousandths", "ten thousandths",  "hundred thousandths", "millionths", "ten millionths", "hundred millionths"];
var answered = []; //ADDED

//START ADDED FUNCTIONS

function setRandomDigits(digit){
    randomDigits = digit;
}

function getRandomNumber(){
    return randomNumber;
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

function alertModal(message, modal){
    dynamicBlock();
    $("#message_text_modal").html(message);
    $("#message_modal_dynamic").show();
    $("#close_modal").show();
    $("#yes_modal").hide();
    $("#no_modal").hide();

    $("#close_modal").bind("click",{modal}, function(){
        switch(modal){
            case 0: digitsTheSameModal();break;
            default: closeModal();break;
            }
            return false;
    });
}

function digitsTheSameModal(){
    dynamicBlock();
    $("#message_text_modal").html("Are the digits the same?  If Yes move on, if No,");
    $("#message_modal_dynamic").show();
    $("#close_modal").hide();
    $("#yes_modal").show();
    $("#no_modal").show();
}

function closeModal() {
    dynamicUnBlock();
    $("#message_modal_dynamic").modal('hide');
}

// end ADDED functions

//END ADDED FUNCTION

function genRandomNumber( numMin, numMax, decimalDigits) {

    randomNumber = (Math.random() * (numMax - numMin) + numMin).toFixed(decimalDigits);

    return randomNumber;
 }

 function getStrInteger( number) {
    posDot = number.indexOf(".");
    str_interger = number.substring(0, posDot);
    return str_interger;
 }

 function getStrDecimal( number) {
    posDot = number.indexOf(".");
    str_decimal = number.substring(posDot + 1);
    return str_decimal;
 }


function randomDigitsOnclick(){
    nextFlag = false;
    integer_decimalFlag = false;
    numCount1 = 1;
    numCount2 = 2;
    erroEnd1 = 0;
    erroEnd2 = 0;
    erroEnd3 = 0;
    step2_count = 0
    step3_count = 0;
    step5_count = 0;
    step6_count = 0;
    step7_count = 0;
    
    randomNumber = 0;
    arry_finalIndex = [];
    arry_randomDecimals = [];
    arry_comp_result = [];
    finalIndex = 0;
    small_step_count = 0;

    arry_err_step2 = [];
    arry_err_step3 = [];
    arry_err_step5 = [];
    arry_err_step6 = [];
    arry_err_step7 = [];

    total_val2 = 0;
    total_val3 = 0;
    total_val6 = 0;
    
    ret = 0;

    step_count = 0;
    nIdx = 0;
    real_number = "";
    str_interger = "";
    str_decimal = "";
    posDot = 0;
    checkIndex = 0;
    checkIndex1 = 0;
    correct_answer = "";
    maxstepNumber = 0;
    compareNumber = 0;
    str_interger1 = 0;
    str_interger2 = 0;
    str_decimal1 = 0;
    str_decimal2 = 0;
    arry_correctval = [];
    arry_checkIdx = [];
    arry_checkIdx1 = [];
    arry_total = [];
    arry_temp = [];
    randomNumber2 = 0;
    randomNumber3 = 0;
    An = 0;
    Ad = 0;
    factorX = 1;

    numMax = parseInt($(".input_num_max").prop("value"));           
    decimalDigits = parseInt($(".input_decimal_digits").prop("value"));
    ranIdx = Math.floor(Math.random() * 5);
    if (ranIdx == 0) ranIdx = 1;

    if(isNaN(numMax)) {
        numMax = 9;
        $(".input_num_max").prop("value", numMax);
    }
    if(isNaN(decimalDigits)) {
        decimalDigits = 2;
        $(".input_decimal_digits").prop("value", decimalDigits);
    }
    if (decimalDigits > 7) {
        decimalDigits = 7;
        $(".input_decimal_digits").prop("value", decimalDigits);
    }           

    randomNumber = genRandomNumber(1.15, numMax, decimalDigits);
    maxstepNumber = randomNumber.length + 2;

    compareNumber = getStrInteger(randomNumber) + getStrDecimal(randomNumber);
    
    // console.log(getStrInteger(randomNumber) + "---" + getStrDecimal(randomNumber));

    An = Math.abs( (getStrDecimal(randomNumber)*1) + (ranIdx*1) );
    Ad = Math.abs(digits(getStrDecimal(randomNumber).length) );

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
    randomNumber2 = (An / Ad);
    randomNumber2 = randomNumber2.toString();
    randomNumber3 = Math.floor(Math.random()*9);
    if (randomNumber3 == 0) randomNumber3 = 1;
    if (randomNumber3 >= 10) randomNumber3 = 9;
    randomNumber3 += ".";
    for (var i = 0; i < getStrDecimal(randomNumber).length; i++) {
        randomNumber3 += "0";
    }
    str_interger1 = getStrInteger(randomNumber);
    str_decimal1 = getStrDecimal(randomNumber);
    str_interger2 = getStrInteger(randomNumber)*1 + getStrInteger(randomNumber2)*1;
    str_decimal2 = getStrDecimal(randomNumber2);
    str_interger3 = getStrInteger(randomNumber3);
    str_decimal3 = getStrDecimal(randomNumber3);
    randomNumber2 = randomNumber2*1 + str_interger2*1;
    randomNumber2 = randomNumber2.toString();
    if (randomNumber2.length != randomNumber.length) {
        for (var i = 0; i < randomNumber.length - randomNumber2.length; i++) {
            randomNumber2 += "0";
        }
    }
    randomNumber2 = randomNumber2*1;
    _i = getDigitsCouunt(Ad*factorX);
    randomNumber2 = randomNumber2.toFixed(2);
    arry_randomDecimals[0] = randomNumber;
    arry_randomDecimals[1] = randomNumber2;
    arry_randomDecimals[2] = randomNumber3;


    arry_randomNumber[0] = removeDot(randomNumber);
    arry_randomNumber[1] = removeDot(randomNumber2);
    arry_randomNumber[2] = removeDot(randomNumber3);

    $("#str_interger_td").html(getStrInteger(randomNumber));
    $("#An_td").html(An);
    $("#Ad_td").html(Ad);
    $("#str_interger_b").html(randomNumber3);
    $("#real_number_b").html(randomNumber);

    $("#step_div").html('<div id="step_div" style="width: 100%; float: left;"><div id="lastDiv"></div></div>');
    $("#correct_flow").html("");
    $("#correct_flow_answer").html("");
    $("#start_div").show();
}

function removeDot(number_parm){
    var s = "";
    for (var i = 0; i < number_parm.length; i++) {
        if (number_parm[i] == ".") 
            continue;
        s += number_parm[i];
    }
    return s;
}

function startStep() {
    step_count = 0;
    $("#step_div").show();
}

function finishStep() {
    $(".inputAnswerend1").keydown(function(event){

        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;

            }
            temp_answer = checkAnswerValidationend1($(this));

            if(temp_answer < 0)
            {
                retry_attempt++;
                if(retry_attempt >= 3){
                    alertModal("The correct answer is " + correct_answer + ". Please retry. ");
                    $(this).prop("value", "").focus();
                    retry_attempt = 0;
                    return;
                }

                if(temp_answer == -2){
                    alertModal("Your answer is larger than what we need.");
                    $(this).prop("value", "").focus();
                    return;
                }
                if(temp_answer == -3){
                    alertModal("Oops not enough, your answer needs to be larger.");
                    $(this).prop("value", "").focus();
                    return;
                }

                if(temp_answer == -1){
                    alertModal("Your answer is incorrect. Please retry.");
                    $(this).prop("value", "").focus();
                    return;
                }
            }
            else
            {
                $(this).attr("readonly", true);
                retry_attempt =  0;
                $(".inputAnswerend2").keydown(function(event){

                    if(event.keyCode == 13){
                        if(checkAnswer($(this)) == false){
                            alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                            $(this).prop("value", "").focus();
                            retry_attempt++;
                            return false;

                        }
                        temp_answer = checkAnswerValidationend2($(this));

                        if(temp_answer < 0)
                        {
                            retry_attempt++;
                            if(retry_attempt >= 3){
                                alertModal("The correct answer is " + correct_answer + ". Please retry. ");
                                $(this).prop("value", "").focus();
                                retry_attempt = 0;
                                return;
                            }

                            if(temp_answer == -2){
                                alertModal("Your answer is larger than what we need.");
                                $(this).prop("value", "").focus();
                                return;
                            }
                            if(temp_answer == -3){
                                alertModal("Oops not enough, your answer needs to be larger.");
                                $(this).prop("value", "").focus();
                                return;
                            }

                            if(temp_answer == -1){
                                alertModal("Your answer is incorrect. Please retry.");
                                $(this).prop("value", "").focus();
                                return;
                            }
                        }
                        else
                        {
                            $(this).attr("readonly", true);
                            retry_attempt =  0;
                            $(".inputAnswerend3").keydown(function(event){

                                if(event.keyCode == 13){
                                    if(checkAnswer($(this)) == false){
                                        alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                                        $(this).prop("value", "").focus();
                                        retry_attempt++;
                                        return false;

                                    }
                                    temp_answer = checkAnswerValidationend3($(this));

                                    if(temp_answer < 0)
                                    {
                                        retry_attempt++;
                                        if(retry_attempt >= 3){
                                            alertModal("The correct answer is " + correct_answer + ". Please retry. ");
                                            $(this).prop("value", "").focus();
                                            retry_attempt = 0;
                                            return;
                                        }

                                        if(temp_answer == -2){
                                            alertModal("Your answer is larger than what we need.");
                                            $(this).prop("value", "").focus();
                                            return;
                                        }
                                        if(temp_answer == -3){
                                            alertModal("Oops not enough, your answer needs to be larger.");
                                            $(this).prop("value", "").focus();
                                            return;
                                        }

                                        if(temp_answer == -1){
                                            alertModal("Your answer is incorrect. Please retry.");
                                            $(this).prop("value", "").focus();
                                            return;
                                        }
                                    }
                                    else
                                    {
                                        $(this).attr("readonly", true);
                                        retry_attempt =  0;
                                        answerDone();   //added
                                        displayTotalFlow();
                                        displayTotalFlow1();
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
function checkAnswerValidationend1(elem){
    answer_val = elem.prop("value");
    isNum = true;
    
    arry_randomDecimals.sort(function(a, b){return a - b});
    correct_answer = arry_randomDecimals[2];
    ret_val = correct_answer;
    if(isNum) {
         if (correct_answer > answer_val){
            if (!erroEnd1) {
                erroEnd1 = answer_val;
            }
            ret_val = -3;
         }else if (correct_answer < answer_val){
            if (!erroEnd1) {
                erroEnd1 = answer_val;
            }
            ret_val = -2;
         }
    }else {
        if (correct_answer != answer_val.toLowerCase()){
            if (!erroEnd1) {
                erroEnd1 = answer_val;
            }
            ret_val = -1;
        }
    }
    return ret_val;
}
function checkAnswerValidationend2(elem){
    answer_val = elem.prop("value");
    isNum = true;
    
    correct_answer = arry_randomDecimals[1];
    ret_val = correct_answer;
    if(isNum) {
         if (correct_answer > answer_val){
            if (!erroEnd2) {
                erroEnd2 = answer_val;
            }
            ret_val = -3;
         }else if (correct_answer < answer_val){
            if (!erroEnd2) {
                erroEnd2 = answer_val;
            }
            ret_val = -2;
         }
    }else {
        if (correct_answer != answer_val.toLowerCase()){
            if (!erroEnd2) {
                erroEnd2 = answer_val;
            }
            ret_val = -1;
        }
    }
    return ret_val;
}
function checkAnswerValidationend3(elem){
    answer_val = elem.prop("value");
    isNum = true;
    
    correct_answer = arry_randomDecimals[0];
    ret_val = correct_answer;
    if(isNum) {
         if (correct_answer > answer_val){
            if (!erroEnd3) {
                erroEnd3 = answer_val;
            }
            ret_val = -3;
         }else if (correct_answer < answer_val){
            if (!erroEnd3) {
                erroEnd3 = answer_val;
            }
            ret_val = -2;
         }
    }else {
        if (correct_answer != answer_val.toLowerCase()){
            if (!erroEnd3) {
                erroEnd3 = answer_val;
            }
            ret_val = -1;
        }
    }
    return ret_val;
}

function nextStep() {

    step_count++;
    retry_attempt = 0;

    questionBystep(step_count);

}

function startBtnOnclick(){

    startStep();

    nextStep();
}

function getTableStringForInput(number){
    numStr = number.toString();
    posDot = numStr.indexOf(".");
    result_str = "";
    result_str += "<table>";
        result_str += "<tr>";
        
            for (var i = 0; i < numStr.length; i++) {
                if (i == posDot) {
                    result_str += "<th id='color_th'>Decimal</th>";
                }else if (i > posDot) {
                    result_str += "<th id='color_th'>" + decimal_up_words[i-posDot-1] + "</th>";    
                }else if (i < posDot) {
                    result_str += "<th id='color_th'>" + number_up_words[posDot - i - 1] + "</th>"; 
                }
                
            }
        result_str += "</tr>";
        result_str += "<tr>";
            for (var i = 0; i < numStr.length; i++) {
                if (i == posDot) {
                    result_str += "<td>.</td>"; 
                }else{
                    result_str += "<td><input type=text style='width:91px;' placeholder='answer' class='checkIndexs'></td>";
                }
            }
        result_str += "</tr>";
    result_str += "</table>";

    return result_str;
}

function getTableStringForShow(number){
    numStr = number.toString();
    posDot = numStr.indexOf(".");
    result_str = "";
    result_str += "<table>";
        result_str += "<tr>";
        
            for (var i = 0; i < numStr.length; i++) {
                if (i == posDot) {
                    result_str += "<th id='color_th'>Decimal</th>";
                }else if (i > posDot) {
                    result_str += "<th id='color_th'>" + decimal_up_words[i-posDot-1] + "</th>";    
                }else if (i < posDot) {
                    result_str += "<th id='color_th'>" + number_up_words[posDot - i - 1] + "</th>"; 
                }
                
            }
        result_str += "</tr>";
        result_str += "<tr>";
            for (var i = 0; i < numStr.length; i++) {
                if (i == posDot) {
                    result_str += "<td>.</td>"; 
                }else{
                    result_str += "<td>"+ numStr[i] +"</td>";
                }
            }
        result_str += "</tr>";
    result_str += "</table>";

    return result_str;
}

function errorCheckIndexShow(){
    str_error = "";
    for (var k in arry_checkIdx){
        if (arry_checkIdx.hasOwnProperty(k)) {
            str_error += "<p style='color:red;'> Error : " + arry_checkIdx[k] + "</p>";
        }
    }
    return str_error;
}
function errorCheckIndexShow1(){
    str_error = "";
    for (var k in arry_checkIdx1){
        if (arry_checkIdx1.hasOwnProperty(k)) {
            str_error += "<p style='color:red;'> Error : " + arry_checkIdx1[k] + "</p>";
        }
    }
    return str_error;
}

function makeTable(number, an, ad){

    result_str = "";
    result_str += "<table style='display:inline-block'>";
    result_str += '<tr>';
                result_str += '<td rowspan="3" align="center" valign="middle"><b>Convert </b></td>';
                result_str += '<td rowspan="3" align="center" valign="middle"><b>'+number+'</b></td>';
                result_str += '<td align="center">'+ an +'</td>';
                result_str += '<td rowspan="3" align="center" valign="middle"><b> ,  into a decimal number. First convert the mixed </b></td>';
            result_str += '</tr>';
            result_str += '<tr><td bgcolor="#000000" height="2"></td></tr>';
            result_str += '<tr>';
                result_str += '<td align="center">'+ad+'</td>';
            result_str += '</tr>    ';
    result_str += "</table>";
    
    return result_str;
}

function makeTable1(number, an, ad){

    result_str = "";
    result_str += "<table style='display:inline-block'>";
    result_str += '<tr>';
                result_str += '<td rowspan="3" align="center" valign="middle" style="max-width:100%"><b> number into a fraction. </b></td>'; //ADDED
                result_str += '<td rowspan="3" align="center" valign="middle" style="color:red;"><b>'+number+'</b></td>';
                result_str += '<td align="center">'+ an +'</td>';
            result_str += '</tr>';
            result_str += '<tr><td bgcolor="#000000" height="2"></td></tr>';
            result_str += '<tr>';
                result_str += '<td align="center" style="color:red;">'+ad+'</td>';
            result_str += '</tr>    ';
    result_str += "</table>";
    
    return result_str;
}
function makeTable_ad_an(){

    result_str = "";
    result_str += "<table style='display:inline-block'>";
    result_str += '<tr>';
                result_str += "<td align='center'><input type=text placeholder='answer' class='inputAnswer1'></td>";
            result_str += '</tr>';
            result_str += '<tr><td bgcolor="#000000" height="2"></td></tr>';
            result_str += '<tr>';
                result_str += "<td align='center'><input type=text placeholder='answer' class='inputAnswer2'></td>";
            result_str += '</tr>    ';
    result_str += "</table>";
    
    return result_str;
}
function makeTable_ad_anshow(str1, str2){

    result_str = "";
    result_str += "<table style='display:inline-block'>";
    result_str += '<tr>';
                result_str += "<td align='center'><font color=blue>"+ str1 +"</font></td>";
            result_str += '</tr>';
            result_str += '<tr><td bgcolor="#000000" height="2"></td></tr>';
            result_str += '<tr>';
                result_str += "<td align='center'><font color=blue>"+ str2 +"</font></td>";
            result_str += '</tr>    ';
    result_str += "</table>";
    
    return result_str;
}
function lastBystep( number1, number2){
    result_str2 = "";
    result_str3 = "";
    for (var i = 0; i < number1.length; i++) {
        result_str2 += digits(number1.length - i- 1) + " x ";
        result_str2 += "<input type=text style='width:20px;' placeholder='answer' class='checkIndexs1'> + ";
    }

    for (var i = 0; i < number2.length; i++) {
        result_str3 += "1/" + digits(i+1) + " x ";
        if (i == number2.length - 1) {
            result_str3 += "<input type=text style='width:20px;' placeholder='answer' class='checkIndexs1'>";
        }else{
            result_str3 += "<input type=text style='width:20px;' placeholder='answer' class='checkIndexs1'> + ";
        }
    }
    result_str2 = result_str2 + result_str3;
    return result_str2;
}
function lastBystepShow( number1, number2){
    result_str2 = "";
    result_str3 = "";
    for (var i = 0; i < number1.length; i++) {
        result_str2 += digits(number1.length - i- 1) + " x ";
        result_str2 += str_interger[i] + " + ";
    }

    for (var i = 0; i < number2.length; i++) {
        result_str3 += "1/" + digits(i+1) + " x ";
        if (i == number2.length - 1) {
            result_str3 += str_decimal[i];
        }else{
            result_str3 += str_decimal[i] + " + ";
        }
    }
    result_str2 = result_str2 + result_str3;
    return result_str2;
}
function beforelastBystepShow( number1, number2){
    result_str2 = "";
    result_str3 = "";
    for (var i = 0; i < number1.length; i++) {
        result_str2 += number_up_words[number1.length - i- 1] + " x ";
        result_str2 += str_interger[i] + " + ";
    }

    for (var i = 0; i < number2.length; i++) {
        result_str3 += decimal_up_words[i] + " x ";
        if (i == number2.length - 1) {
            result_str3 += str_decimal[i];
        }else{
            result_str3 += str_decimal[i] + " + ";
        }
    }
    result_str2 = result_str2 + result_str3;
    return result_str2;
}

function makeTableChart(){
    result_str = "";
    result_str += "<table class='rank_no'>";
        result_str += "<tr>";
        
            for (var i = -1; i < randomNumber.length; i++) {
                if (i == posDot && i != -1) {
                    result_str += "<th id='color_th'>Decimal</th>";
                }else if (i > posDot && i != -1) {
                    result_str += "<th id='color_th'>" + decimal_up_words[i-posDot-1] + "</th>";    
                }else if (i < posDot && i != -1) {
                    result_str += "<th id='color_th'>" + number_up_words[posDot - i - 1] + "</th>";
                }if (i == -1) {
                    result_str += "<th></th>";  
                }
                
            }
            
        result_str += "</tr>";
        result_str += "<tr>";
            for (var i = -1; i < randomNumber.length; i++) {
                if (i == posDot && i != -1) {
                    result_str += "<td>.</td>"; 
                }else if (i != -1) {
                    result_str += "<td><input type=text style='width:91px;' placeholder='answer' class='checkIndexs'></td>";
                }
                if (i == -1) {
                    result_str += "<td>Number1</td>";   
                }
                
                
            }
        result_str += "</tr>";
        result_str += "<tr>";
            
            for (var i = -1; i < randomNumber.length; i++) {
                if (i == -1) {
                    result_str += "<td>Number2</td>";   
                }
                x=str_interger2.length;
                x=x*1;
                y=str_interger1.length;
                if (y > x && i < (y - x) && i != -1) {
                    // console.log("i="+i + "-------" + (y - x));
                    result_str += "<td>12</td>";
                }else{
                    if (i == posDot && i != -1) {
                        result_str += "<td>.</td>"; 
                    }else if (i != -1) {
                        result_str += "<td><input type=text style='width:91px;' placeholder='answer' class='checkIndexs'></td>";
                    }
                }
            }
        result_str += "</tr>";
        result_str += "<tr>";
            
            for (var i = -1; i < randomNumber.length; i++) {
                if (i == -1) {
                    result_str += "<td>Number3</td>";   
                }
                x=str_interger2.length;
                x=x*1;
                y=str_interger1.length;
                if (y > x && i < (y - x) && i != -1) {
                    // console.log("i="+i + "-------" + (y - x));
                    result_str += "<td>12</td>";
                }else{
                    if (i == posDot && i != -1) {
                        result_str += "<td>.</td>"; 
                    }else if (i != -1) {
                        result_str += "<td><input type=text style='width:91px;' placeholder='answer' class='checkIndexs'></td>";
                    }
                }
            }
        result_str += "</tr>";
    result_str += "</table>";
    return result_str;
}

function makeTableChartShow(){
    result_str = "";
    result_str += "<table class='rank_no'>";
        result_str += "<tr>";
        
            for (var i = -1; i < randomNumber.length; i++) {
                if (i == posDot && i != -1) {
                    result_str += "<th id='color_th'>Decimal</th>";
                }else if (i > posDot && i != -1) {
                    result_str += "<th id='color_th'>" + decimal_up_words[i-posDot-1] + "</th>";    
                }else if (i < posDot && i != -1) {
                    result_str += "<th id='color_th'>" + number_up_words[posDot - i - 1] + "</th>";
                }if (i == -1) {
                    result_str += "<th></th>";  
                }
                
            }
            
        result_str += "</tr>";
        result_str += "<tr>";
            for (var i = -1; i < randomNumber.length; i++) {
                if (i == posDot && i != -1) {
                    result_str += "<td>.</td>"; 
                }else if (i != -1) {
                    result_str += "<td>"+ randomNumber[i] +"</td>";
                }
                if (i == -1) {
                    result_str += "<td>Number1</td>";   
                }
                
                
            }
        result_str += "</tr>";
        result_str += "<tr>";
            
            for (var i = -1; i < randomNumber2.length; i++) {
                if (i == -1) {
                    result_str += "<td>Number2</td>";   
                }
                x=str_interger2.length;
                x=x*1;
                y=str_interger1.length;
                if (y > x && i < (y - x) && i != -1) {
                    // console.log("i="+i + "-------" + (y - x));
                    result_str += "<td>12</td>";
                }else{
                    if (i == posDot && i != -1) {
                        result_str += "<td>.</td>"; 
                    }else if (i != -1) {
                        result_str += "<td>"+ randomNumber2[i] +"</td>";
                    }
                }
            }
        result_str += "</tr>";
        result_str += "<tr>";
            
            for (var i = -1; i < randomNumber3.length; i++) {
                if (i == -1) {
                    result_str += "<td>Number3</td>";   
                }
                x=str_interger2.length;
                x=x*1;
                y=str_interger1.length;
                if (y > x && i < (y - x) && i != -1) {
                    // console.log("i="+i + "-------" + (y - x));
                    result_str += "<td>12</td>";
                }else{
                    if (i == posDot && i != -1) {
                        result_str += "<td>.</td>"; 
                    }else if (i != -1) {
                        result_str += "<td>"+ randomNumber3[i] +"</td>";
                    }
                }
            }
        result_str += "</tr>";
    result_str += "</table>";
    return result_str;
}
function twoCompareFunc(){
    $(".inputAnswer1").keydown(function(event){

        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;

            }

            if(($(this).prop("value") != (str_interger2 + "x" + Ad + "")) && ($(this).prop("value") != (Ad + "x" + str_interger2 + ""))) {
                
                if(retry_attempt >= 3){
                    alertModal("The correct answer is " + (str_interger2 + "x" + Ad + "") + " or "+ (Ad + "x" + str_interger2 + "") +". Please retry. ");
                    $(this).prop("value", "").focus();
                    retry_attempt = 0;
                    return;
                }else{
                    retry_attempt++;
                    if (!arry_err_step2[1]) {
                        arry_err_step2[1] = $(this).prop("value");
                    }
                    alertModal("Your answer is incorrect. Please retry.");
                    $(this).prop("value", "").focus();
                    return;
                }
            }
            else
            {
                total_val2 = $(this).prop("value");
                $(this).attr("readonly", true);
                retry_attempt =  0;
                $(".inputAnswer2").keydown(function(event){

                    if(event.keyCode == 13){
                        if(checkAnswer($(this)) == false){
                            alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                            $(this).prop("value", "").focus();
                            retry_attempt++;
                            return false;

                        }

                        temp_answer = checkAnswerValidation($(this));

                        if(temp_answer < 0)
                        {
                            retry_attempt++;
                            if(retry_attempt >= 3){
                                alertModal("The correct answer is " + correct_answer + ". Please retry. ");
                                $(this).prop("value", "").focus();
                                retry_attempt = 0;
                                return;
                            }

                            if(temp_answer == -2){
                                alertModal("Your answer is larger than what we need.");
                                $(this).prop("value", "").focus();
                                return;
                            }
                            if(temp_answer == -3){
                                alertModal("Oops not enough, your answer needs to be larger.");
                                $(this).prop("value", "").focus();
                                return;
                            }

                            if(temp_answer == -1){
                                alertModal("Your answer is incorrect. Please retry.");
                                $(this).prop("value", "").focus();
                                return;
                            }
                        }
                        else
                        {
                            $(this).attr("readonly", true);
                            retry_attempt =  0;
                            nextStep();
                        }               
                    }
                }).focus(); 
            }               
        }
    }).focus(); 
}
function threeCompareFunc(){
    $(".inputAnswer1").keydown(function(event){

        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;

            }

            if(($(this).prop("value") != (str_interger2 * Ad + "+" + An + "")) && ($(this).prop("value") != (An + "+" + str_interger2 * Ad + ""))) {
                
                if(retry_attempt >= 3){
                    alertModal("The correct answer is " + (str_interger2 * Ad + "+" + An + "") + " or "+ (An + "+" + str_interger2 * Ad + "") + ". Please retry. ");
                    $(this).prop("value", "").focus();
                    retry_attempt = 0;
                    return;
                }else{
                    retry_attempt++;
                    if (!arry_err_step3[1]) {
                        arry_err_step3[1] = $(this).prop("value");
                    }
                    alertModal("Your answer is incorrect. Please retry.");
                    $(this).prop("value", "").focus();
                    return;
                }
            }
            else
            {
                total_val3 = $(this).prop("value");
                $(this).attr("readonly", true);
                retry_attempt =  0;
                $(".inputAnswer2").keydown(function(event){

                    if(event.keyCode == 13){
                        if(checkAnswer($(this)) == false){
                            alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                            $(this).prop("value", "").focus();
                            retry_attempt++;
                            return false;

                        }

                        temp_answer = checkAnswerValidation($(this));

                        if(temp_answer < 0)
                        {
                            retry_attempt++;
                            if(retry_attempt >= 3){
                                alertModal("The correct answer is " + correct_answer + ". Please retry. ");
                                $(this).prop("value", "").focus();
                                retry_attempt = 0;
                                return;
                            }

                            if(temp_answer == -2){
                                alertModal("Your answer is larger than what we need.");
                                $(this).prop("value", "").focus();
                                return;
                            }
                            if(temp_answer == -3){
                                alertModal("Oops not enough, your answer needs to be larger.");
                                $(this).prop("value", "").focus();
                                return;
                            }

                            if(temp_answer == -1){
                                alertModal("Your answer is incorrect. Please retry.");
                                $(this).prop("value", "").focus();
                                return;
                            }
                        }
                        else
                        {
                            $(this).attr("readonly", true);
                            retry_attempt =  0;
                            nextStep();
                        }               
                    }
                }).focus(); 
            }               
        }
    }).focus(); 
}
function sixCompareFunc(){
    $(".inputAnswer1").keydown(function(event){

        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;

            }

            if(($(this).prop("value") != (Ad + "x" + factorX + "")) && ($(this).prop("value") != (factorX + "x" + Ad + ""))) {
                
                if(retry_attempt >= 3){
                    alertModal("The correct answer is " + (Ad + "x" + factorX + "") + " or "+ (factorX + "x" + Ad + "") +". Please retry. ");
                    $(this).prop("value", "").focus();
                    retry_attempt = 0;
                    return;
                }else{
                    retry_attempt++;
                    if (!arry_err_step6[1]) {
                        arry_err_step6[1] = $(this).prop("value");
                    }
                    alertModal("Your answer is incorrect. Please retry.");
                    $(this).prop("value", "").focus();
                    return;
                }
            }
            else
            {
                total_val6 = $(this).prop("value");
                $(this).attr("readonly", true);
                retry_attempt =  0;
                $(".inputAnswer2").keydown(function(event){

                    if(event.keyCode == 13){
                        if(checkAnswer($(this)) == false){
                            alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                            $(this).prop("value", "").focus();
                            retry_attempt++;
                            return false;

                        }

                        temp_answer = checkAnswerValidation($(this));

                        if(temp_answer < 0)
                        {
                            retry_attempt++;
                            if(retry_attempt >= 3){
                                alertModal("The correct answer is " + correct_answer + ". Please retry. ");
                                $(this).prop("value", "").focus();
                                retry_attempt = 0;
                                return;
                            }

                            if(temp_answer == -2){
                                alertModal("Your answer is larger than what we need.");
                                $(this).prop("value", "").focus();
                                return;
                            }
                            if(temp_answer == -3){
                                alertModal("Oops not enough, your answer needs to be larger.");
                                $(this).prop("value", "").focus();
                                return;
                            }

                            if(temp_answer == -1){
                                alertModal("Your answer is incorrect. Please retry.");
                                $(this).prop("value", "").focus();
                                return;
                            }
                        }
                        else
                        {
                            $(this).attr("readonly", true);
                            retry_attempt =  0;
                            nextStep();
                        }               
                    }
                }).focus(); 
            }               
        }
    }).focus(); 
}

function questionBystep( stepNumber) {

    if (stepNumber == 1) {
        $("<p>Step " + stepNumber + " : Convert numbers to the same form.  In this case let us make all number decimals.<br> "+makeTable(str_interger, An, Ad)+makeTable1(str_interger, An, Ad)+". </p>").insertBefore("#lastDiv");
        return nextStep();
    }
    if (stepNumber == 2) {
        $("<p>Step " + stepNumber + " : Start with the numerator.  Multiple the whole number by denominator.Write out the equation.</p><input type=text placeholder='answer' class='inputAnswer1'> = <input type=text placeholder='answer' class='inputAnswer2'>").insertBefore("#lastDiv");
        return twoCompareFunc();
    }
    if (stepNumber == 3) {
        $("<p>Step " + stepNumber + " : Now add the existing numerator to result in Step 2:Write out the equation.</p><input type=text placeholder='answer' class='inputAnswer1'> = <input type=text placeholder='answer' class='inputAnswer2'>").insertBefore("#lastDiv");
        return threeCompareFunc();
    }

    if (stepNumber == 4) {
        $("<p>Step " + stepNumber + " : What is the denominator.</p><input type=text placeholder='answer' class='inputAnswer'>").insertBefore("#lastDiv");
        return checkIndexMiddle();
    }
    if (stepNumber == 5) {
        $("<p>Step " + stepNumber + " :  What is the result.</p>" + makeTable_ad_an()).insertBefore("#lastDiv");
    }
    if (stepNumber == 6) {
        $("<p>Step " + stepNumber + " : Now that we have a fraction, let us convert it into a decimal. <br> First figure out how to convert the denominator (bottom number) into multiples of 10.<br>  example 10, 100, 1,000, 10,000.  Any 1 followed only by 0s.Write out the equation. </p><input type=text placeholder='answer' class='inputAnswer1'> = <input type=text placeholder='answer' class='inputAnswer2'>").insertBefore("#lastDiv");
        return sixCompareFunc();
    }
    if (stepNumber == 7) {
        $("<p>Step " + stepNumber + " : Multiple numerator and denominator by that number.</p>" + makeTable_ad_an()).insertBefore("#lastDiv");
    }
    if (stepNumber == 8) {
        $("<p>Step " + stepNumber + " : Write out the numerator (top number) in decimal form keeping in mind the principals of decimals. </p><input type=text placeholder='answer' class='inputAnswer'>").insertBefore("#lastDiv");
        return checkIndexMiddle();
    }
    if (stepNumber == 9) {
        $("<p>Step " + stepNumber + " : Now let us compare the numbers using the place value table.  How many columns does the table need?</p><input type=text placeholder='answer' class='inputAnswer'>").insertBefore("#lastDiv");
        return checkIndexMiddle();
    }
    if (stepNumber == 10) {
        $("<p>Step " + stepNumber + " :  Put the numbers in the chart.</p>" + makeTableChart()).insertBefore("#lastDiv");

         askcompnum_step = 11;
         cur_comnum_idx = 0;
        return middleFunc();
    }



    if (stepNumber == askcompnum_step) {

        var numidx1 = arry_compnum_idx[cur_comnum_idx*2];
        var numidx2 = arry_compnum_idx[cur_comnum_idx*2+1];

        var ss = "";
        if(cur_comnum_idx == 0)
            ss = "First ";
        else if (cur_comnum_idx == 2 || cur_comnum_idx == 1 && arry_comp_result[cur_comnum_idx] == arry_comp_result[cur_comnum_idx-1])
            ss = "Final ";

        $("<p>Step " + stepNumber + " : "+ ss +" compare Number "+ numidx1 +" and "+ numidx2 +":  What is the highest place value? Example type out Ones, or Tenths.</p><input type=text placeholder='answer' class='inputAnswer'>").insertBefore("#lastDiv");
        
        return checkIndexMiddle();
    }
    if (stepNumber > askcompnum_step) {
        var numidx1 = arry_compnum_idx[cur_comnum_idx*2];
        var numidx2 = arry_compnum_idx[cur_comnum_idx*2+1];

        $("<p>Step " + stepNumber + " Compare Number "+ numidx1 +" and "+ numidx2 +":Are the digits the same?<br> Yes. The digits are the same.</p>").insertBefore("#lastDiv");
        return step12Func();
    }
    $(".inputAnswer1").keydown(function(event){

        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;

            }

            temp_answer = checkAnswerValidation($(this));

            if(temp_answer < 0)
            {
                retry_attempt++;
                if(retry_attempt >= 3){
                    alertModal("The correct answer is " + correct_answer + ". Please retry. ");
                    $(this).prop("value", "").focus();
                    retry_attempt = 0;
                    return;
                }

                if(temp_answer == -2){
                    alertModal("Your answer is larger than what we need.");
                    $(this).prop("value", "").focus();
                    return;
                }
                if(temp_answer == -3){
                    alertModal("Oops not enough, your answer needs to be larger.");
                    $(this).prop("value", "").focus();
                    return;
                }

                if(temp_answer == -1){
                    alertModal("Your answer is incorrect. Please retry.");
                    $(this).prop("value", "").focus();
                    return;
                }
            }
            else
            {
                $(this).attr("readonly", true);
                retry_attempt =  0;
                $(".inputAnswer2").keydown(function(event){

                    if(event.keyCode == 13){
                        if(checkAnswer($(this)) == false){
                            alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                            $(this).prop("value", "").focus();
                            retry_attempt++;
                            return false;

                        }

                        temp_answer = checkAnswerValidation($(this));

                        if(temp_answer < 0)
                        {
                            retry_attempt++;
                            if(retry_attempt >= 3){
                                alertModal("The correct answer is " + correct_answer + ". Please retry. ");
                                $(this).prop("value", "").focus();
                                retry_attempt = 0;
                                return;
                            }

                            if(temp_answer == -2){
                                alertModal("Your answer is larger than what we need.");
                                $(this).prop("value", "").focus();
                                return;
                            }
                            if(temp_answer == -3){
                                alertModal("Oops not enough, your answer needs to be larger.");
                                $(this).prop("value", "").focus();
                                return;
                            }

                            if(temp_answer == -1){
                                alertModal("Your answer is incorrect. Please retry.");
                                $(this).prop("value", "").focus();
                                return;
                            }
                        }
                        else
                        {
                            $(this).attr("readonly", true);
                            retry_attempt =  0;
                            nextStep();
                        }               
                    }
                }).focus(); 
            }               
        }
    }).focus(); 
}

function step12Func(){
    step_count++;
    nIdx ++;

    var numidx1 = arry_compnum_idx[cur_comnum_idx*2];
    var numidx2 = arry_compnum_idx[cur_comnum_idx*2+1];

    // console.log("ths_words["+ step_count + " -11 - " + nIdx + "] = " + ths_words[step_count -11 - nIdx]);

    $("<p>Step " + step_count + ": Compare Number "+ numidx1 +" and "+ numidx2 +": What is the "+ ths_words[step_count -11 - nIdx] +" highest place value?  (Example, type in Tenths)  </p><input type=text placeholder='answer' class='inputAnswer'>").insertBefore("#lastDiv");
    return checkIndexMiddle();
}

function checkIndexMiddle(){
    $(".inputAnswer").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;

            }

            temp_answer = checkAnswerValidation($(this));

            if(temp_answer < 0){
                retry_attempt++;
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = $(this).prop("value");;
                }
                if(retry_attempt >= 3){
                    alertModal("The correct answer is " + correct_answer + ". Please retry. ");
                    $(this).prop("value", "").focus();
                    retry_attempt = 0;
                    return;
                }

                if(temp_answer == -2){
                    alertModal("Your answer is larger than what we need.");
                    $(this).prop("value", "").focus();
                    return;
                }
                if(temp_answer == -3){
                    alertModal("Oops not enough, your answer needs to be larger.");
                    $(this).prop("value", "").focus();
                    return;
                }

                if(temp_answer == -1){
                    alertModal("Your answer is incorrect. Please retry.");
                    $(this).prop("value", "").focus();
                    return;
                }
            }else{
                if (step_count >= askcompnum_step) {                        
                    $(this).attr("readonly", true);
                    // $("#myModal").show();
                    digitsTheSameModal();   //added
                    var numidx1 = arry_compnum_idx[cur_comnum_idx*2];
                    var numidx2 = arry_compnum_idx[cur_comnum_idx*2+1];

                    str_decimal1 = arry_randomNumber[numidx1-1];
                    str_decimal2 = arry_randomNumber[numidx2-1];

                    ret = compareNumberFunc(str_decimal1, str_decimal2, small_step_count);
                    small_step_count++;
                
                    
                }else{
                    $(this).attr("readonly", true);
                    retry_attempt =  0;
                    nextStep();
                }           
            }               
        }
    }).focus(); 
}

function compareNumberFunc(num1, num2, Idx){
    if (num1[Idx] > num2[Idx]) {
        return -9;
    }else if (num1[Idx] < num2[Idx]) {
        return -8;
    }
    return -7;
}


function btnYEsOnclick() {
    if (ret == -9) {
        alertModal("The digits is not same. Please retry.", 0);
    }else if (ret == -8) {
        alertModal("The digits is not same. Please retry.", 0);
    }else if (ret == -7) {
        nextStep();
        // $("#myModal").hide();
        closeModal();
    }
    
}

function btnNOOnclick(){
    if (ret == -9) {
        // $("#myModal").hide();
        closeModal();
        step_count++;
        finalFunc();
    }else if (ret == -8) {
        // $("#myModal").hide();
        closeModal();
        step_count++;
        finalFunc();
    }else if (ret == -7) {
        alertModal("The digits is same. Please retry.", 0);
    }
}

function finalFunc(){
    var numidx1 = arry_compnum_idx[cur_comnum_idx*2];
    var numidx2 = arry_compnum_idx[cur_comnum_idx*2+1];         
    $("<p>Step " + step_count + ": Compare Number "+ numidx1 +" and "+ numidx2 +" : Are the digits the same? No. <br>Which is largest? Number <input type=text placeholder='answer' class='inputAnswer'></p>").insertBefore("#lastDiv");

    $(".inputAnswer").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            
            temp_answer = checkAnswerValidation1($(this));
            if(temp_answer == -3){
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
            if(temp_answer == -1){
                $(this).prop("value", "").focus();
                return false;
            }
            $(this).attr("readonly", true);

            arry_comp_result[cur_comnum_idx] = ret;

            if(cur_comnum_idx == 2 || (cur_comnum_idx == 1 && arry_comp_result[cur_comnum_idx] == arry_comp_result[cur_comnum_idx-1]))
            {
                $("<p>Step " + (step_count+1) + ": Now stack rank them from smallest to largest<input type=text placeholder='answer' class='inputAnswerend1 retry_csl'>,<input type=text placeholder='answer' class='inputAnswerend2 retry_csl'>,<input type=text placeholder='answer' class='inputAnswerend3 retry_csl'></p>").insertBefore("#lastDiv");
                return finishStep();
            }else{
                cur_comnum_idx++;
                small_step_count = 0;
                askcompnum_step = step_count+1;
                nextStep();
            }               
        }
    }).focus();
}

function checkAnswerValidation1(elem){
    answer_val = elem.prop("value");
    isNum = true;
    
    if (ret == -9) {
        correct_answer = arry_compnum_idx[cur_comnum_idx*2];
        ret_val = correct_answer;
    }else if (ret == -8) {
        correct_answer = arry_compnum_idx[cur_comnum_idx*2+1];
        ret_val = correct_answer;
    }
    
    if(isNum) {
         if (correct_answer > answer_val){
            // console.log("-3");
            if (!arry_temp[step_count]) {
                arry_temp[step_count] = answer_val;
            }
            ret_val = -3;
         }else if (correct_answer < answer_val){
            // console.log("-2");
            if (!arry_temp[step_count]) {
                arry_temp[step_count] = answer_val;
            }
            ret_val = -2;
         }
    }else {
        if (correct_answer != answer_val.toLowerCase()){
            if (!arry_temp[step_count]) {
                arry_temp[step_count] = answer_val;
            }
            ret_val = -1;
        }
    }
    return ret_val;
}

function middleFunc() {
    $(".checkIndexs").eq(0).focus();
    checkIndex = 0;
    $(".checkIndexs").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
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
            if (checkIndex == randomNumber.length + randomNumber2.length + randomNumber3.length) {
                nextStep();
                integer_decimalFlag = true;
            }
            $(this).attr("readonly", true);
            __index = $(".checkIndexs").index($(this));
            if(__index < $(".checkIndexs").length - 1)
                $(".checkIndexs").eq(__index+1).focus();
        }   
    });
}

function checkAnswerValidation(elem) {
    
    answer_val = elem.prop("value");
    isNum = true;           
    if (step_count == 2) {
        step2_count= 2;
        // if (step2_count == 1) {
        //  isNum = false;
        //  correct_answer1 = str_interger2 + "x" + Ad;
        //  correct_answer2 = Ad + "x" + str_interger2;
        //  if (correct_answer1 == (str_interger2 + "x" + Ad) || correct_answer2 == (Ad + "x" + str_interger2)){
        //      ret_val = correct_answer1:correct_answer2;
        //  }
            
        // }
        if (step2_count == 2) {
            isNum = true;
            correct_answer = str_interger2 * Ad;
        }
        ret_val = correct_answer;

        if(isNum) {
             if (correct_answer > answer_val){
                if (!arry_err_step2[2]) {
                    arry_err_step2[2] = answer_val;
                }
                ret_val = -3;
             }else if (correct_answer < answer_val){
                if (!arry_err_step2[2]) {
                    arry_err_step2[2] = answer_val;
                }
                ret_val = -2;
             }
        }else {
            if (correct_answer != answer_val){
                if (!arry_err_step2[2]) {
                    arry_err_step2[2] = answer_val;
                }
                ret_val = -1;
            }
        }

        return ret_val;
    }

    if (step_count == 3) {
        step3_count = 2;
        // if (step3_count == 1) {
        //  isNum = false;
        //  correct_answer = str_interger2 * Ad + "+" + An; 
        // }
        if (step3_count == 2) {
            isNum = true;
            correct_answer = str_interger2 * Ad + An*1;
        }
        ret_val = correct_answer;

        if(isNum) {
             if (correct_answer > answer_val){
                if (!arry_err_step3[step3_count]) {
                    arry_err_step3[step3_count] = answer_val;
                }
                ret_val = -3;
             }else if (correct_answer < answer_val){
                if (!arry_err_step3[step3_count]) {
                    arry_err_step3[step3_count] = answer_val;
                }
                ret_val = -2;
             }
        }else {
            if (correct_answer != answer_val){
                if (!arry_err_step3[step3_count]) {
                    arry_err_step3[step3_count] = answer_val;
                }
                ret_val = -1;
            }
        }

        return ret_val;
    }

    if (step_count == 4) {
        correct_answer = Ad;
        ret_val = correct_answer;
        if(isNum) {
             if (correct_answer > answer_val){
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                ret_val = -3;
             }else if (correct_answer < answer_val){
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                ret_val = -2;
             }
        }else {
            if (correct_answer != answer_val){
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                ret_val = -1;
            }
        }
        return ret_val;
    }

    if (step_count == 5) {
        step5_count++;
        if (step5_count == 1) {
            isNum = true;
            correct_answer = str_interger2 * Ad + An;   
        }
        if (step5_count == 2) {
            isNum = true;
            correct_answer = Ad;
        }
        ret_val = correct_answer;

        if(isNum) {
             if (correct_answer > answer_val){
                if (!arry_err_step5[step5_count]) {
                    arry_err_step5[step5_count] = answer_val;
                }
                step5_count--;
                ret_val = -3;
             }else if (correct_answer < answer_val){
                if (!arry_err_step5[step5_count]) {
                    arry_err_step5[step5_count] = answer_val;
                }
                step5_count--;
                ret_val = -2;
             }
        }else {
            if (correct_answer != answer_val){
                if (!arry_err_step5[step5_count]) {
                    arry_err_step5[step5_count] = answer_val;
                }
                step5_count--;
                ret_val = -1;
            }
        }

        return ret_val;
    }

    if (step_count == 6) {
        step6_count = 2;
        // if (step6_count == 1) {
        //  isNum = false;
        //  correct_answer = Ad + "x" + factorX;    
        // }
        if (step6_count == 2) {
            isNum = true;
            correct_answer = Ad * factorX;
        }
        ret_val = correct_answer;

        if(isNum) {
             if (correct_answer > answer_val){
                if (!arry_err_step6[step6_count]) {
                    arry_err_step6[step6_count] = answer_val;
                }
                ret_val = -3;
             }else if (correct_answer < answer_val){
                if (!arry_err_step6[step6_count]) {
                    arry_err_step6[step6_count] = answer_val;
                }
                ret_val = -2;
             }
        }else {
            if (correct_answer != answer_val){
                if (!arry_err_step6[step6_count]) {
                    arry_err_step6[step6_count] = answer_val;
                }
                ret_val = -1;
            }
        }

        return ret_val;
    }

    if (step_count == 7) {
        step7_count++;
        if (step7_count == 1) {
            isNum = true;
            correct_answer = (str_interger2 * Ad + An)*factorX; 
        }
        if (step7_count == 2) {
            isNum = true;
            correct_answer = Ad * factorX;
        }
        ret_val = correct_answer;

        if(isNum) {
             if (correct_answer > answer_val){
                if (!arry_err_step7[step7_count]) {
                    arry_err_step7[step7_count] = answer_val;
                }
                step7_count--;
                ret_val = -3;
             }else if (correct_answer < answer_val){
                if (!arry_err_step7[step7_count]) {
                    arry_err_step7[step7_count] = answer_val;
                }
                step7_count--;
                ret_val = -2;
             }
        }else {
            if (correct_answer != answer_val){
                if (!arry_err_step7[step7_count]) {
                    arry_err_step7[step7_count] = answer_val;
                }
                step7_count--;
                ret_val = -1;
            }
        }

        return ret_val;
    }

    if (step_count == 8) {
        isNum = true;
        correct_answer = randomNumber2;
        ret_val = correct_answer;
        if(isNum) {
             if (correct_answer > answer_val){
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                ret_val = -3;
             }else if (correct_answer < answer_val){
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                ret_val = -2;
             }
        }else {
            if (correct_answer != answer_val){
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                ret_val = -1;
            }
        }
        return ret_val;
    }

    if (step_count == 9) {
        isNum = true;
        correct_answer = randomNumber.length-1;
        ret_val = correct_answer;
        if(isNum) {
             if (correct_answer > answer_val){
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                ret_val = -3;
             }else if (correct_answer < answer_val){
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                ret_val = -2;
             }
        }else {
            if (correct_answer != answer_val){
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                ret_val = -1;
            }
        }
        return ret_val;
    }

    if (step_count == 10) {
        var ll = "";
        ll = randomNumber + randomNumber2 + randomNumber3 +"";
        if (randomNumber[checkIndex] == ".") {
            checkIndex++;
            $(".checkIndexs").eq(checkIndex).focus();
        }
        if (ll[checkIndex] == ".") {
            checkIndex++;
            if (!arry_checkIdx[checkIndex]) {
                
                arry_checkIdx[checkIndex] = answer_val;
            }
            $(".checkIndexs").eq(checkIndex).focus();
        }
        correct_answer = ll[checkIndex] * 1;


        if (answer_val == correct_answer) {
            checkIndex++;
            return correct_answer;
        }
        
        if (answer_val > correct_answer) {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry. ");
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_checkIdx[checkIndex]) {
                
                    arry_checkIdx[checkIndex] = answer_val;
                }
                return -1;
            }       
        }else {
            if(retry_attempt > 1){
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
    if (step_count >= askcompnum_step) {
        isNum = false;
        
        correct_answer = decimal_low_words_temp[small_step_count];
        ret_val = correct_answer;
        
        if(isNum) {
             if (correct_answer > answer_val){
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                ret_val = -3;
             }else if (correct_answer < answer_val){
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                ret_val = -2;
             }
        }else {
            if (correct_answer != answer_val.toLowerCase()){
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                ret_val = -1;
            }
        }
        return ret_val;
    }
}

function checkAnswer(elem) {
    if (step_count * 1 == 4) {
        answer_val = elem.prop("value");
        setAnswered(answer_val);    //added
        return true;            
    }else{
        answer_val = elem.prop("value");
        if(answer_val == "") return false;
        elem.prop("value", answer_val);
    }           
}

function displayTotalFlow(){
    result_str = "";
    // result_str += "<b style='color:blue'>Answered Flow</b>";
    // result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += '<label>Rank these numbers from smallest to largest:<br>';
        result_str += '<table  style="display:inline-block;border: 0">';
            result_str += '<tr>';
                result_str += '<td rowspan="3" align="center" valign="middle" id="real_number_b">'+ randomNumber +'</td>';
                result_str += '<td rowspan="3" align="center" valign="middle"><b>,</b></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" id="str_interger_td">'+ getStrInteger(randomNumber) +'</td>';
                result_str += '<td align="center" id="An_td">'+ An +'</td>';
                result_str += '<td rowspan="3" align="center" valign="middle">,'+ randomNumber3 +'</td>';
                result_str += '<td rowspan="3" align="center" valign="middle" id="str_interger_b"><b>,</b></td>';
            result_str += '</tr>';
            result_str += '<tr><td bgcolor="#000000" height="2"></td></tr>';
            result_str += '<tr>';
                result_str += '<td align="center" id="Ad_td">'+ Ad +'</td>';
            result_str += '</tr>';
        result_str += '</table>';
        result_str += '</label>';

    result_str += "<div>";

        result_str += "<p>Step 1 :  Convert numbers to the same form.  In this case let us make all number decimals.<br> "+makeTable(str_interger, An, Ad)+makeTable1(str_interger, An, Ad)+". </p>";
    result_str += "</div>";

    result_str += "<div>";
        result_str += "<p>Step 2 : Start with the numerator.  Multiple the whole number by denominator.Write out the equation.</p><font color=blue>" + total_val2 +"</font> = <font color=blue>"+ (str_interger2 * Ad)+"</font>";
        if (arry_err_step2[1]) {
            result_str += "<p style='color:red;'> Error : "+ arry_err_step2[1] +"</p>";
        }
        if (arry_err_step2[2]) {
            result_str += "<p style='color:red;'> Error : "+ arry_err_step2[2] +"</p>";
        }
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 3 : Now add the existing numerator to result in Step 2:Write out the equation.</p><font color=blue>"+ total_val3 +"</font> = <font color=blue>"+ (str_interger2 * Ad + An*1)+"</font>";
        if (arry_err_step3[1]) {
            result_str += "<p style='color:red;'> Error : "+ arry_err_step3[1] +"</p>";
        }
        if (arry_err_step3[2]) {
            result_str += "<p style='color:red;'> Error : "+ arry_err_step3[2] +"</p>";
        }       
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 4 : What is the denominator.</p><font color=blue>" + Ad+"</font>";
        if (arry_temp[4]) {
            result_str += "<p style='color:red;'> Error : "+ arry_temp[4] +"</p>";
        }       
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 5 :  What is the result.</p><font color=blue>" + makeTable_ad_anshow((str_interger2 * Ad + An), Ad)+"</font>";
        if (arry_err_step5[1]) {
            result_str += "<p style='color:red;'> Error : "+ arry_err_step5[1] +"</p>";
        }
        if (arry_err_step5[2]) {
            result_str += "<p style='color:red;'> Error : "+ arry_err_step5[2] +"</p>";
        }
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 6 : Now that we have a fraction, let us convert it into a decimal. <br> First figure out how to convert the denominator (bottom number) into multiples of 10.<br>  example 10, 100, 1,000, 10,000.  Any 1 followed only by 0s.Write out the equation. </p><font color=blue>"+ total_val6 +"</font> = <font color=blue>" + Ad * factorX+"</font>";
        if (arry_err_step6[1]) {
            result_str += "<p style='color:red;'> Error : "+ arry_err_step6[1] +"</p>";
        }
        if (arry_err_step6[2]) {
            result_str += "<p style='color:red;'> Error : "+ arry_err_step6[2] +"</p>";
        }
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 7 : Multiple numerator and denominator by that number.</p><font color=blue>" + makeTable_ad_anshow(((str_interger2 * Ad + An)*factorX), Ad * factorX)+"</font>";
        if (arry_err_step7[1]) {
            result_str += "<p style='color:red;'> Error : "+ arry_err_step7[1] +"</p>";
        }
        if (arry_err_step7[2]) {
            result_str += "<p style='color:red;'> Error : "+ arry_err_step7[2] +"</p>";
        }
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 8 : Write out the numerator (top number) in decimal form keeping in mind the principals of decimals. </p><font color=blue>" + randomNumber2+"</font>";
        if (arry_temp[8]) {
            result_str += "<p style='color:red;'> Error : "+ arry_temp[8] +"</p>";
        }
    result_str += "</div>";

    result_str += "<div>";
        result_str += "<p> Step 9 : Now let us compare the numbers using the place value table.  How many columns does the table need? </p><font color=blue>" + (randomNumber.length-1)+"</font>";
        if (arry_temp[9]) {
            result_str += "<p style='color:red;'> Error : "+ arry_temp[9] +"</p>";
        }
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 10 : Put the numbers in the chart.</p>" + makeTableChartShow();
        result_str += errorCheckIndexShow();        
    result_str += "</div>";

    var isNeedStopAsk = false;
    

    var stepNumber = 11;
    cur_comnum_idx = 0;
        
    while(isNeedStopAsk == false) {

        var ret = 0;

        var numidx1 = arry_compnum_idx[cur_comnum_idx*2];
        var numidx2 = arry_compnum_idx[cur_comnum_idx*2+1];

        var num1 = arry_randomNumber[numidx1-1];
        var num2 = arry_randomNumber[numidx2-1];
        // console.log("num1 = " + num1+"--"+"num2 = " + num2);

        var ss = "";
        if(cur_comnum_idx == 0)
            ss = "First ";
        else if (cur_comnum_idx == 2 || cur_comnum_idx == 1 && arry_comp_result[cur_comnum_idx] == arry_comp_result[cur_comnum_idx-1])
            ss = "Final ";

        result_str += "<p>Step " + stepNumber + " : "+ ss +" compare Number "+ numidx1 +" and "+ numidx2 +":  What is the highest place value? Example type out Ones, or Tenths.</p><font color=blue>" + decimal_low_words_temp[0]+"</font>";
        if (arry_temp[stepNumber]) {
            result_str += "<p style='color:red;'> Error : "+ arry_temp[stepNumber] +"</p>";
        }
        stepNumber++;



        for(var small_step_count = 0; small_step_count < num1.length; small_step_count++) {

            ret = compareNumberFunc(num1, num2, small_step_count);
            arry_comp_result[cur_comnum_idx] = ret;

            // console.log("arry_randomNumber["+numidx1+"] = "+ num1 +"----"+ "arry_randomNumber["+numidx2+"] = " + num2 + "---" + "small_step_count = " + small_step_count);

            if(ret == -9) {
                // console.log("ret-9");
                result_str += "<p>Step " + stepNumber + ": Compare Number "+ numidx1 +" and "+ numidx2 +" : Are the digits the same? <font color=blue>No</font>. <br>Which is largest? Number <font color=blue>"+ arry_compnum_idx[cur_comnum_idx*2] +"</font></p>";
                stepNumber++;
                break;
                
            }else if (ret == -8) {
                // console.log("ret-8");
                result_str += "<p>Step " + stepNumber + ": Compare Number "+ numidx1 +" and "+ numidx2 +" : Are the digits the same? <font color=blue>No</font>. <br>Which is largest? Number <font color=blue>"+ arry_compnum_idx[cur_comnum_idx*2+1] +"</font></p>";
                stepNumber++;
                break;
            } else{
                // console.log("ret-7");
                result_str += "<p>Step " + stepNumber+" Compare Number "+ numidx1 +" and "+ numidx2 +":Are the digits the same?<br> <font color=blue>Yes</font>. The digits are the same.</p>";
                stepNumber++;
                result_str += "<p>Step " + stepNumber + ": Compare Number "+ numidx1 +" and "+ numidx2 +": What is the "+ ths_words[small_step_count+1] +" highest place value?  (Example, type in Tenths)  </p><font color=blue>"+decimal_low_words_temp[small_step_count+1]+"</font>";
                if (arry_temp[stepNumber]) {
                    result_str += "<p style='color:red;'> Error : "+ arry_temp[stepNumber] +"</p>";
                }
            }

            stepNumber++;
        }
        // console.log("cur_comnum_idx = " + cur_comnum_idx);

        

        if(cur_comnum_idx == 2 || (cur_comnum_idx == 1 && arry_comp_result[cur_comnum_idx] == arry_comp_result[cur_comnum_idx-1])){

            result_str += "<p>Step " + stepNumber + ": Now stack rank them from smallest to largest <font color=blue>"+ arry_randomDecimals[2] +","+ arry_randomDecimals[1] +","+ arry_randomDecimals[0] +"</font></p>";
            if (erroEnd1) {
                result_str += "<p style='color:red;'> Error : "+erroEnd1+"</p>";
            }
            if (erroEnd2) {
                result_str += "<p style='color:red;'> Error : "+erroEnd2+"</p>";
            }
            if (erroEnd3) {
                result_str += "<p style='color:red;'> Error : "+erroEnd3+"</p>";
            }
            isNeedStopAsk = true;
        }
        // console.log("cur_comnum_idx--= " + cur_comnum_idx);
        
        cur_comnum_idx++;
        // console.log("cur_comnum_idx ++= " + cur_comnum_idx);
        
    }
    $("#correct_flow").html(result_str);

}

function displayTotalFlow1(){
    result_str = "";
    // result_str += "<b style='color:blue'>Correct Answered Flow</b>";
    // result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += '<label>Rank these numbers from smallest to largest:<br>';
        result_str += '<table  style="display:inline-block;border: 0">';
            result_str += '<tr>';
                result_str += '<td rowspan="3" align="center" valign="middle" id="real_number_b">'+ randomNumber +'</td>';
                result_str += '<td rowspan="3" align="center" valign="middle"><b>,</b></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" id="str_interger_td">'+ getStrInteger(randomNumber) +'</td>';
                result_str += '<td align="center" id="An_td">'+ An +'</td>';
                result_str += '<td rowspan="3" align="center" valign="middle">,'+ randomNumber3 +'</td>';
                result_str += '<td rowspan="3" align="center" valign="middle" id="str_interger_b"><b>,</b></td>';
            result_str += '</tr>';
            result_str += '<tr><td bgcolor="#000000" height="2"></td></tr>';
            result_str += '<tr>';
                result_str += '<td align="center" id="Ad_td">'+ Ad +'</td>';
            result_str += '</tr>';
        result_str += '</table>';
        result_str += '</label>';

    result_str += "<div>";

        result_str += "<p>Step 1 :  Convert numbers to the same form.  In this case let us make all number decimals.<br> "+makeTable(str_interger, An, Ad)+makeTable1(str_interger, An, Ad)+". </p>";
    result_str += "</div>";

    result_str += "<div>";
        result_str += "<p>Step 2 : Start with the numerator.  Multiple the whole number by denominator.Write out the equation.</p><font color=blue>" + total_val2 +"</font> = <font color=blue>"+ (str_interger2 * Ad)+"</font>";       
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 3 : Now add the existing numerator to result in Step 2:Write out the equation.</p><font color=blue>"+ total_val3 +"</font> = <font color=blue>"+ (str_interger2 * Ad + An*1)+"</font>";       
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 4 : What is the denominator.</p><font color=blue>" + Ad+"</font>";        
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 5 :  What is the result.</p><font color=blue>" + makeTable_ad_anshow((str_interger2 * Ad + An), Ad)+"</font>";        
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 6 : Now that we have a fraction, let us convert it into a decimal. <br> First figure out how to convert the denominator (bottom number) into multiples of 10.<br>  example 10, 100, 1,000, 10,000.  Any 1 followed only by 0s.Write out the equation. </p><font color=blue>"+ total_val6 +"</font> = <font color=blue>" + Ad * factorX+"</font>";         
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 7 : Multiple numerator and denominator by that number.</p><font color=blue>" + makeTable_ad_anshow(((str_interger2 * Ad + An)*factorX), Ad * factorX)+"</font>";  
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 8 : Write out the numerator (top number) in decimal form keeping in mind the principals of decimals. </p><font color=blue>" + randomNumber2+"</font>";
    result_str += "</div>";

    result_str += "<div>";
        result_str += "<p> Step 9 : Now let us compare the numbers using the place value table.  How many columns does the table need? </p><font color=blue>" + (randomNumber.length-1)+"</font>";
    result_str += "</div>";

    result_str += "<div>";
        result_str +="<p>Step 10 : Put the numbers in the chart.</p>" + makeTableChartShow();       
    result_str += "</div>";

    var isNeedStopAsk = false;
    

    var stepNumber = 11;
    cur_comnum_idx = 0;
        
    while(isNeedStopAsk == false) {

        var ret = 0;

        var numidx1 = arry_compnum_idx[cur_comnum_idx*2];
        var numidx2 = arry_compnum_idx[cur_comnum_idx*2+1];

        var num1 = arry_randomNumber[numidx1-1];
        var num2 = arry_randomNumber[numidx2-1];
        // console.log("num1 = " + num1+"--"+"num2 = " + num2);

        var ss = "";
        if(cur_comnum_idx == 0)
            ss = "First ";
        else if (cur_comnum_idx == 2 || cur_comnum_idx == 1 && arry_comp_result[cur_comnum_idx] == arry_comp_result[cur_comnum_idx-1])
            ss = "Final ";

        result_str += "<p>Step " + stepNumber + " : "+ ss +" compare Number "+ numidx1 +" and "+ numidx2 +":  What is the highest place value? Example type out Ones, or Tenths.</p><font color=blue>" + decimal_low_words_temp[0]+"</font>";
        stepNumber++;



        for(var small_step_count = 0; small_step_count < num1.length; small_step_count++) {

            ret = compareNumberFunc(num1, num2, small_step_count);
            arry_comp_result[cur_comnum_idx] = ret;

            // console.log("arry_randomNumber["+numidx1+"] = "+ num1 +"----"+ "arry_randomNumber["+numidx2+"] = " + num2 + "---" + "small_step_count = " + small_step_count);

            if(ret == -9) {
                // console.log("ret-9");
                result_str += "<p>Step " + stepNumber + ": Compare Number "+ numidx1 +" and "+ numidx2 +" : Are the digits the same? <font color=blue>No</font>. <br>Which is largest? Number <font color=blue>"+ arry_compnum_idx[cur_comnum_idx*2] +"</font></p>";
                stepNumber++;
                break;
                
            }else if (ret == -8) {
                // console.log("ret-8");
                result_str += "<p>Step " + stepNumber + ": Compare Number "+ numidx1 +" and "+ numidx2 +" : Are the digits the same? <font color=blue>No</font>. <br>Which is largest? Number <font color=blue>"+ arry_compnum_idx[cur_comnum_idx*2+1] +"</font></p>";
                stepNumber++;
                break;
            } else{
                // console.log("ret-7");
                result_str += "<p>Step " + stepNumber+" Compare Number "+ numidx1 +" and "+ numidx2 +":Are the digits the same?<br> <font color=blue>Yes</font>. The digits are the same.</p>";
                stepNumber++;
                result_str += "<p>Step " + stepNumber + ": Compare Number "+ numidx1 +" and "+ numidx2 +": What is the "+ ths_words[small_step_count+1] +" highest place value?  (Example, type in Tenths)  </p><font color=blue>"+decimal_low_words_temp[small_step_count+1]+"</font>";    
            }

            stepNumber++;
        }
        // console.log("cur_comnum_idx = " + cur_comnum_idx);

        

        if(cur_comnum_idx == 2 || (cur_comnum_idx == 1 && arry_comp_result[cur_comnum_idx] == arry_comp_result[cur_comnum_idx-1])){

            result_str += "<p>Step " + stepNumber + ": Now stack rank them from smallest to largest <font color=blue>"+ arry_randomDecimals[2] +","+ arry_randomDecimals[1] +","+ arry_randomDecimals[0] +"</font></p>";

            isNeedStopAsk = true;
        }
        // console.log("cur_comnum_idx--= " + cur_comnum_idx);
        
        cur_comnum_idx++;
        // console.log("cur_comnum_idx ++= " + cur_comnum_idx);
        
    }
    $("#correct_flow_answer").html(result_str);

}