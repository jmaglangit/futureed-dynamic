/**
 *  Code from client
 * 20170823.
 */

var randomNumber1 = 0;
var randomNumber2 = 0;
var randomdigitsNumber = 0;
var step_count = 0;
var checkIndex =0;
var str_interger1 = "";
var str_decimal1 = "";
var str_interger2 = "";
var str_decimal2 = "";
var po1 = 0;
var po2 = 0;
var randomIndex = 0;
var finalIndex = 0;
var nCount = 0;
var nIdx = 0;

var step2_count = 0;
var step1Flag = false;
var step2Flag = false;
var step6Flag = false;
var integer_decimalFlag = false;
var decimalFlag = false;

var arry_correctval = [];
var arry_total = [];
var arry_temp = [];
var arry_checkIdx = [];
var arry_finalIndex = [];

var arry_step2_temp = [];
var x=0;
var y = 0;

var number_words = ["one", "ten", "hundred", "thousand", "ten thousand", "hundred thousand", "million", "ten Million", "hundred million"];
var decimal_words = [ "tenths", "hundredths","thousandths", "ten thousandths",  "hundred thousandths", "millionths", "ten millionths", "hundred millionths"];
var ths_words = ["first", "second", "third", "fourth","fifth", "sixth", "seventh", "eighth", "nineth", "tenth"];
var answered = []; //ADDED

// nerubia code
// start ADDED functions
//getter and setter

function getFirstNumber(){
    return str_interger1;
}

function getFirstDecimalDigit(){
    return str_decimal1;
}

function getSecondNumber(){
    return str_interger2;
}

function getSecondDecimalDigit(){
    return str_decimal2;
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

function randomDigitsOnclick(){
    randomNumber1 = 0;
    randomNumber2 = 0;
    randomdigitsNumber = 0;
    step_count = 0;
    checkIndex =0;
    str_interger1 = "";
    str_decimal1 = "";
    str_interger2 = "";
    str_decimal2 = "";
    po1 = 0;
    po2 = 0;
    randomIndex = 0;
    finalIndex = 0;
    nCount = 0;
    nIdx = 0;

    step2_count = 0;
    step1Flag = false;
    step2Flag = false;
    step6Flag = false;
    integer_decimalFlag = false;
    decimalFlag = false;

    arry_correctval = [];
    arry_total = [];
    arry_temp = [];
    arry_checkIdx = [];
    arry_finalIndex = [];

    arry_step2_temp = [];
    x=0;
    y = 0;
    
    randomDigits1 = parseInt($(".randomDigits1").prop("value"));
    min = 0.05;
    randomDigits2 = parseInt($(".randomDigits2").prop("value"));

    if(isNaN(randomDigits1)) {
        randomDigits1 = 1;
        $(".randomDigits1").prop("value", randomDigits1);
    }
    if (randomDigits1 > 10) {
        randomDigits1 = 9;
        $(".randomDigits2").prop("value", randomDigits1);
    }
    if(isNaN(randomDigits2)) {
        randomDigits2 = 3;
        $(".randomDigits2").prop("value", randomDigits2);
    }
    if (randomDigits2 > 7) {
        randomDigits2 = 7;
        $(".randomDigits2").prop("value", randomDigits2);
    }

    randomNumber1 = (Math.random() * (randomDigits1 - min) + min).toFixed(randomDigits2) + "";
    randomNumber2 = (Math.random() * (randomDigits1 - min) + min).toFixed(randomDigits2) + "";
    // randomNumber1 = "0.0009";
    // randomNumber2 = "0.0009";
    if (randomNumber1.length < randomNumber2.length) {
        var temp = "";
        temp = randomNumber1;
        randomNumber1 = randomNumber2;
        randomNumber2 = temp;
    }
    
    po1 = randomNumber1.indexOf(".");
    str_interger1 = randomNumber1.substring(0, po1);
    str_decimal1 = randomNumber1.substring(po1+1);
    
    po2 = randomNumber2.indexOf(".");
    str_interger2 = randomNumber2.substring(0, po2);
    str_decimal2 = randomNumber2.substring(po2+1);
    $("#step_div").html('<div id="step_div" style="width: 700px; float: left;"><br><div id="tableNumber_div"></div><div id="lastDiv"></div></div>');
    $("#correct_flow").html("");
    $("#correct_flow_answer").html("");

    $("#str_interger1_b").html(str_interger1);
    $("#str_decimal1_b").html(str_decimal1);
    $("#str_interger2_b").html(str_interger2);
    $("#str_decimal2_b").html(str_decimal2);
    $("#start_div").show();
}

function startBtnOnclick(){
    step_count++;
    retry_attempt = 0;
    $("#step_div").show();
    if (step_count == 1) {
        if (step1Flag == false) {
            result_str = "<div>";
            result_str += "<p>Step " + step_count +":  First, look what is being asked. </p>";
            result_str += "</div>";
            $("#tableNumber_div").html(result_str);
            return eventMouseOnclick();
        }
        
    }
}

function btnYEsOnclick() {
    if (str_interger1 != str_interger2) {
        // alert("The digits is not same. Retry!");
        alertModal("The digits is not same. Please retry.", 0);
        
    }else{
        decimalFlag = true;
        if (str_decimal1[step_count - 7-nIdx] != str_decimal2[step_count - 7-nIdx] ) {
            // alert("The digits is not same. Retry!");
            alertModal("The digits is not same. Please retry.", 0);
            
        }else{
            var last_step = 0;
            if(step_count  == 9 + str_decimal1.length) {
                last_step  =1;
            }

            // $("#message_modal_dynamic").hide();
            closeModal();
            step6Flag = true;

            if(last_step == 1) {
                $("<p>Step " + (step_count+1) + " : Answer. <br><b>"+ randomNumber1 +" </b><font color=blue>  =  </font><b> "+ randomNumber2 +"</b></p>").insertBefore("#lastDiv");
                answerDone();   //added
                displayTotalFlow();
                displayTotalFlow1();
            }else{
                nextsetp();
            }
        }
    }
}
function btnNOOnclick(){
    if (str_interger1 == str_interger2 && decimalFlag == false) {
        // alert("The digits is same. Retry!");
        alertModal("The digits is same. Please retry.", 0);
    }else{
        if (str_decimal1[step_count - 7-nIdx] == str_decimal2[step_count - 7-nIdx] && str_interger1 == str_interger2) {
            // alert("The digits is same. Retry!");
            alertModal("The digits is same. Please retry.", 0);
        }else{
            // $("#message_modal_dynamic").hide();
            closeModal();
            step_count++;
            finalFunc();    
        }
    }
    
}

function finalFunc(){
    $("<p>Step " + step_count + " :Are the digits the same? No. <br>Which is largest? Number <input type=text placeholder='answer' class='inputCheck'></p>").insertBefore("#lastDiv");
    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                // alert("Answer can't be alphabet !");
                alertModal("That is incorrect. Answer can't be blank. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            
            temp_answer = checkAnswerValidation1($(this));
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
            $(this).attr("readonly", true);
            $("<p>Step " + (step_count+1) + " : Answer.<br>"+ randomNumber1 + "<input type=text placeholder='answer' style='width:32px;margin: 5px;' class='inputCheck9'>"+ randomNumber2 + "</p>").insertBefore("#lastDiv");
            $(".inputCheck9").keydown(function(event){
                if(event.keyCode == 13){
                    if(checkAnswer($(this)) == false){
                        // alert("Answer can't be alphabet !");
                        alertModal("That is incorrect. Answer can't be blank. Please retry.");
                        $(this).prop("value", "").focus();
                        retry_attempt++;
                        return false;
                    }
                    
                    temp_answer = checkAnswerValidation1($(this));
                    if(temp_answer == -1){
                        // alert("Your answer incorrect. Retey!");
                        alertModal("Your answer is incorrect. Please retry.");
                        $(this).prop("value", "").focus();
                        retry_attempt++;
                        return false;
                    }
                    if(temp_answer == -2){
                        // alert("Your answer incorrect. Retey!");
                        alertModal("Your answer is incorrect. Please retry.");
                        $(this).prop("value", "").focus();
                        retry_attempt++;
                        return false;
                    }
                    if(temp_answer == -3){
                        $(this).prop("value", "").focus();
                        return false;
                    }
                    $(this).attr("readonly", true);
                    answerDone();   //added
                    displayTotalFlow();
                    displayTotalFlow1();
                }
            }).focus();
            
        }
    }).focus();
}
function nextsetp(){
    step1Flag = true;
    result_str = "";
    result_str += "<table>";
        result_str += "<tr>";
        
            for (var i = -1; i < randomNumber1.length; i++) {
                if (i == po1 && i != -1) {
                    result_str += "<th id='color_th'>Decimal</th>";
                }else if (i > po1 && i != -1) {
                    result_str += "<th id='color_th'>" + decimal_words[i-po1-1] + "</th>";  
                }else if (i < po1 && i != -1) {
                    result_str += "<th id='color_th'>" + number_words[po1 - i - 1] + "</th>";
                }if (i == -1) {
                    result_str += "<th></th>";  
                }
                
            }
            
        result_str += "</tr>";
        result_str += "<tr>";
            for (var i = -1; i < randomNumber1.length; i++) {
                if (i == po1 && i != -1) {
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
            
            for (var i = -1; i < randomNumber1.length; i++) {
                // console.log("iiii="+i + "-------" + (y - x));
                // // if (i == po1 && i != -1) {
                //  result_str += "<td>.</td>"; 
                // }else if (i != -1) {
                //  result_str += "<td><input type=text style='width:91px;' placeholder='answer' class='checkIndexs'></td>";
                // }
                // if (i == -1) {
                //  result_str += "<td>Number2</td>";   
                // }
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
                    if (i == po1 && i != -1) {
                        result_str += "<td>.</td>"; 
                    }else if (i != -1) {
                        result_str += "<td><input type=text style='width:91px;' placeholder='answer' class='checkIndexs'></td>";
                    }
                }
            }
        result_str += "</tr>";
    result_str += "</table>";
    
    retry_attempt = 0;
    step_count++;
    
    if (step_count == 2) {
        if (step2Flag == false) {
            $("<p>Step " + step_count + " : We have to compare with the signs >, <, =.</p>").insertBefore("#lastDiv");
            return eventMouseOnclick1();
        }
        
    }

    if (step_count == 3) {
        $("<p>Step " + step_count + " : Use the place value chart.  How many columns does the chart need?</p><input type=text placeholder='answer' class='inputCheck'>").insertBefore("#lastDiv");
    }
    
    if (step_count == 4) {
        $("<p>Step " + step_count + " : Put the numbers in the chart.<br>" + result_str).insertBefore("#lastDiv");
        return middleFunc();
    }

    if (step_count == 5) {
        $("<p>Step " + step_count + " : What is the highest place value?  (Example, type in Tenths)  </p><input type=text placeholder='answer' class='inputCheck'>").insertBefore("#lastDiv");
    }
    if (step_count >= 6) {
        $("<p>Step " + step_count + " :Are the digits the same?<br> Yes. The digits are the same.</p>").insertBefore("#lastDiv");
        step_count++
        step6Func();

    }

    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                // alert("Answer can't be alphabet !");
                alertModal("That is incorrect. Answer can't be blank. Please retry.");
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
            $(this).attr("readonly", true);
            if (step_count >= 5) {
                // $("#myModal").show();
                digitsTheSameModal();
            }else{
                nextsetp(); 
            }
            
        }
    }).focus();
}

function middleFunc() {
    $(".checkIndexs").eq(0).focus();
    checkIndex = 0;
    $(".checkIndexs").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                // alert("Answer can't be alphabet !");
                alertModal("That is incorrect. Answer can't be blank. Please retry.");
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
            if (checkIndex == randomNumber1.length + randomNumber2.length) {
                nextsetp();
            }
            $(this).attr("readonly", true);
            if (checkIndex > po1) {
                if (checkIndex >= (randomNumber1.length*1+po2*1+po1*1)) {
                    $(".checkIndexs").eq(checkIndex-2).focus();
                }else{
                    $(".checkIndexs").eq(checkIndex-1).focus(); 
                }
            }else{
                $(".checkIndexs").eq(checkIndex).focus();
            }                   
        }   
    });
}

function eventMouseOnclick(){
    if (step_count == 1) {
        nextsetp();
    }
}
function eventMouseOnclick1(){
    if (step_count == 2 && step2Flag == false) {
        step2Func();
    }

}

function step2Func() {
    step2Flag = true;
    $("<p> Which sign shows less than?  <input style='width:20px; margin-left: 22px;text-align:center;' class='inputCheck'></p>").insertBefore("#lastDiv");
    $("<p id='less_p' style='display:none;'> Which sign shows greater than?  <input style='width:20px;text-align:center;' class='inputCheck1'></p>").insertBefore("#lastDiv");
    $("<p id='equals_p' style='display:none;'> Which sign shows equals to?   <input style='width:20px; margin-left: 18px;text-align:center;' class='inputCheck2'></p>").insertBefore("#lastDiv");
    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                // alert("Answer can't be alphabet !");
                alertModal("That is incorrect. Answer can't be blank. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            
            temp_answer = checkAnswerValidation($(this));
            if(temp_answer == -1){
                alertModal("Your answer is incorrect. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(temp_answer == -2){
                alertModal("Your answer is incorrect. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(temp_answer == -3){
                $(this).prop("value", "").focus();
                return false;
            }
            $(this).attr("readonly", true);
            $(".inputCheck1").keydown(function(event){
                if(event.keyCode == 13){
                    if(checkAnswer($(this)) == false){
                        // alert("Answer can't be alphabet !");
                        alertModal("That is incorrect. Answer can't be blank. Please retry.");
                        $(this).prop("value", "").focus();
                        retry_attempt++;
                        return false;
                    }
                    
                    temp_answer = checkAnswerValidation($(this));
                    if(temp_answer == -1){
                        alertModal("Your answer is incorrect. Please retry.");
                        $(this).prop("value", "").focus();
                        retry_attempt++;
                        return false;
                    }
                    if(temp_answer == -2){
                        alertModal("Your answer is incorrect. Please retry.");
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
                                // alert("Answer can't be alphabet !");
                                alertModal("That is incorrect. Answer can't be blank. Please retry.");
                                $(this).prop("value", "").focus();
                                retry_attempt++;
                                return false;
                            }
                            
                            temp_answer = checkAnswerValidation($(this));
                            if(temp_answer == -1){
                                alertModal("Your answer is incorrect. Please retry.");
                                $(this).prop("value", "").focus();
                                retry_attempt++;
                                return false;
                            }
                            if(temp_answer == -2){
                                alertModal("Your answer is incorrect. Please retry.");
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
function step6Func(){
    if (step_count-6 == 1) {
        nCount = 0;
    }else{
        nCount++;
    }
    if (step_count >= 9) {
        nIdx++;
    }
    $("<p>Step " + step_count + " : What is the "+ ths_words[step_count-6- nCount] +" highest place value?  (Example, type in Tenths)  </p><input type=text placeholder='answer' class='inputCheck'>").insertBefore("#lastDiv");
}

function checkAnswerValidation1(elem){
    answer_val = elem.prop("value");
    finalIndex++;

    if (finalIndex == 1) {
        if (integer_decimalFlag == true) {

            if (((randomNumber1*1) < (randomNumber2*1))) {
                correct_answer = "2";
            }else{
                correct_answer = "1";
            }
        }else{
            if (step_count >= 9) {
                if (str_decimal1[step_count - 8 - nIdx] < str_decimal2[step_count - 8 - nIdx]) {
                    correct_answer = "2";
                }else{
                    correct_answer = "1";
                }
            }else{
                if (str_decimal1[step_count - 8] < str_decimal2[step_count - 8]) {
                    correct_answer = "2";
                }else{
                    correct_answer = "1";
                }
            }
            
        }
        
    
        if (answer_val == correct_answer){
            return correct_answer;  
        }
    }

    if (finalIndex == 2) {
        if (integer_decimalFlag == true) {
            if (((randomNumber1*1) < (randomNumber2*1))) {
                correct_answer = "<";
            }else{
                correct_answer = ">";
            }
        }else{
            if (step_count >= 9) {
                if (str_decimal1[step_count - 8 - nIdx] < str_decimal2[step_count - 8 - nIdx]) {
                    correct_answer = "<";
                }else{
                    correct_answer = ">";
                }
            }else{
                if (str_decimal1[step_count - 8] < str_decimal2[step_count - 8]) {
                    correct_answer = "<";
                }else{
                    correct_answer = ">";
                }
            }
        }
        
    
        if (answer_val == correct_answer){
            return correct_answer;  
        }
    }

    if(retry_attempt > 1){
        alertModal("The correct answer is " + correct_answer + ". Please retry. ");
        finalIndex--;
        retry_attempt = 0;
        return -3;
    }
    
    if (answer_val > correct_answer) {
        if (!arry_finalIndex[finalIndex]) {
            finalIndex--;
            arry_finalIndex[finalIndex] = answer_val;
        }
        return -1;
    }else {
        if (!arry_finalIndex[finalIndex]) {
            finalIndex--;
            arry_finalIndex[finalIndex] = answer_val;
        }
        return -2;          
    }
}

function checkAnswerValidation(elem) {
    
    answer_val = elem.prop("value");

    if (step_count == 2) {
        step2_count++;
        
        if (step2_count == 1) {
            correct_answer = "<";
            
            if (answer_val == correct_answer){
                $("#less_p").show();

                return correct_answer;  
            }
        }

        if (step2_count == 2) {
            correct_answer = ">";
    
            if (answer_val == correct_answer){
                $("#equals_p").show();
                return correct_answer;  
            }
        }
        if (step2_count == 3) {
            correct_answer = "=";
    
            if (answer_val == correct_answer){
                return correct_answer;  
            }
        }
        
        if(retry_attempt > 1){
            alertModal("The correct answer is " + correct_answer + ". Please retry. ");
            step2_count--;
            retry_attempt = 0;
            return -3;
        }
        
        if (answer_val > correct_answer) {
            step2_count--;
            if (!arry_step2_temp[step2_count]) {
                arry_step2_temp[step2_count] = answer_val;
            }
            return -1;
        }else {
            step2_count--;
            if (!arry_step2_temp[step2_count]) {
                arry_step2_temp[step2_count] = answer_val;
            }
            return -2;          
        }
    }

    if (step_count == 3) {

        correct_answer = randomNumber1.length - 1;
    
        if (answer_val == correct_answer){
            return correct_answer;  
        }
        if(retry_attempt > 1){
            alertModal("The correct answer is " + correct_answer + ". Please retry. ");
            retry_attempt = 0;
            return -3;
        }
        
        if (answer_val > correct_answer) {
            if (!arry_temp[step_count]) {
                arry_temp[step_count] = answer_val;
            }
            return -1;
        }else {
            if (!arry_temp[step_count]) {
                arry_temp[step_count] = answer_val;
            }
            return -2;          
        }
    }

    if (step_count == 4) {
        var ll = "";
        ll = randomNumber1 + randomNumber2 + "";
        if (randomNumber1[checkIndex] == ".") {
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
        if(retry_attempt > 1){
            alertModal("The correct answer is " + correct_answer + ". Please retry. ");
            retry_attempt = 0;
            return -3;
        }


        if (answer_val > correct_answer) {
        
            if (!arry_checkIdx[checkIndex]) {
                
                arry_checkIdx[checkIndex] = answer_val;
            }
            return -1;
        }else {

            if (!arry_checkIdx[checkIndex]) {
                arry_checkIdx[checkIndex] = answer_val;
            }
            return -2;          
        }
    }
    if (step_count == 5) {
        
        correct_answer = number_words[randomNumber1.length - randomNumber2.length];
            
        if (answer_val.toLowerCase() == correct_answer){
            arry_correctval[step_count - 8] = answer_val;
            integer_decimalFlag = true;
            return correct_answer;  
        }
        if(retry_attempt > 1){
            alertModal("The correct answer is " + correct_answer + ". Please retry. ");
            retry_attempt = 0;
            return -3;
        }
        
        if (answer_val > correct_answer) {
            if (!arry_temp[step_count]) {
                arry_temp[step_count] = answer_val;
            }
            return -1;
        }else {
            if (!arry_temp[step_count]) {
                arry_temp[step_count] = answer_val;
            }
            return -2;          
        }
    }
    if (step_count >= 7) {
        correct_answer = decimal_words[step_count - 7 - nCount];                    
        if (answer_val.toLowerCase() == correct_answer){
            arry_correctval[step_count - 7] = answer_val;
            integer_decimalFlag = false;
            return correct_answer;  
        }
        if(retry_attempt > 1){
            alertModal("The correct answer is " + correct_answer + ". Please retry. ");
            retry_attempt = 0;
            return -3;
        }
        
        if (answer_val > correct_answer) {
            if (!arry_temp[step_count]) {
                arry_temp[step_count] = answer_val;
            }
            return -1;
        }else {
            if (!arry_temp[step_count]) {
                arry_temp[step_count] = answer_val;
            }
            return -2;          
        }
    }

}

function checkAnswer(elem) {
    if (step_count * 1 == 4) {
        answer_val = elem.prop("value");
        setAnswered(answer_val);
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
        result_str += '<label>Compare the decimals below by using >, < , or = <br><b>'+ randomNumber1 + '</b> And <b>'+ randomNumber2 + '</b></label>';
    result_str += "</div>";

    result_str += "<div>";
        result_str += "<p>Step 1: First, look what is being asked.</p>";
    result_str += "</div>";
    
    result_str += "<div>";
        result_str += "<p> Step 2. We have to compare with the signs >, <, =.</p>";
        result_str += "<p> Which sign shows less than? <font color=blue> < </font></p>";
        result_str += "<p> Which sign shows greater than? <font color=blue> > </font></p>";
        result_str += "<p> Which sign shows equals to? <font color=blue> = </font></p>";
            
            if (arry_step2_temp[1]) {
                result_str += "<p style='color:red;'> Error : " + arry_step2_temp[1] + "</p>";
            }
            if (arry_step2_temp[2]) {
                result_str += "<p style='color:red;'> Error : " + arry_step2_temp[2] + "</p>";
            }

            if (arry_step2_temp[0]) {
                result_str += "<p style='color:red;'> Error : " + arry_step2_temp[0] + "</p>";
            }
    result_str += "</div>";


    result_str += "<div>";
        result_str += "<p>Step 3: Use the place value chart.  How many columns does the chart need? <font color=blue>"+ randomNumber1.length +"</font></p>";
        result_str += "<font color=blue>Remember the number of columns in the place value chart equals the number of digits in the number.</font>";
        if (arry_temp[3]) {
            result_str += "<p style='color:red;'> Error : " + arry_temp[3] + "</p>";
        }
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 4: Put the numbers in the chart.</p>";

        result_str += "<table>";
            result_str += "<tr>";
            
                for (var i = -1; i < randomNumber1.length; i++) {
                    if (i == po1 && i != -1) {
                        result_str += "<th id='color_th'>Decimal</th>";
                    }else if (i > po1 && i != -1) {
                        result_str += "<th id='color_th'>" + decimal_words[i-po1-1] + "</th>";  
                    }else if (i < po1 && i != -1) {
                        result_str += "<th id='color_th'>" + number_words[po1 - i - 1] + "</th>";
                    }if (i == -1) {
                        result_str += "<th></th>";  
                    }
                    
                }
                
            result_str += "</tr>";
            result_str += "<tr>";
                for (var i = -1; i < randomNumber1.length; i++) {
                    if (i == po1 && i != -1) {
                        result_str += "<td>.</td>"; 
                    }else if (i != -1) {
                        result_str += "<td>"+ randomNumber1[i] +"</td>";
                    }
                    if (i == -1) {
                        result_str += "<td>Number1</td>";   
                    }
                    
                    
                }
            result_str += "</tr>";
            result_str += "<tr>";
                for (var i = -1; i < randomNumber2.length; i++) {
                    if (i == po1 && i != -1) {
                        result_str += "<td>.</td>"; 
                    }else if (i != -1) {
                        result_str += "<td>"+ randomNumber2[i] +"</td>";
                    }
                    if (i == -1) {
                        result_str += "<td>Number2</td>";   
                    }
                }
            result_str += "</tr>";
        result_str += "</table>";

    for (var k in arry_checkIdx){
        // console.log("k = " + k + "------" + "arry_checkIdx["+k+"] = " + arry_checkIdx[k])
        if (arry_checkIdx.hasOwnProperty(k)) {
            result_str += "<p style='color:red;'> Error : " + arry_checkIdx[k] + "</p>";
        }
    }
        
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 5: What is the highest place value?  (Example, type in Tenths).<font color=blue>"+ number_words[randomNumber1.length - randomNumber2.length] +"</font></p>";
        if (arry_temp[5]) {
            result_str += "<p style='color:red;'> Error : " + arry_temp[5] + "</p>";
        }
    result_str += "</div>";

    if (str_interger2 == str_interger1) {
        result_str += "<p>Step 6: Are the digits the same?  <br>Yes. The digits are the same.</p>";
        result_str += "<p>Step 7: What is the "+ ths_words[1] +" highest place value?<font color=blue>"+ decimal_words[0] +"</font></p>";
        if (arry_temp[7]) {
            result_str += "<p style='color:red;'> Error : " + arry_temp[7] + "</p>";
        }
        
        
        for (var i = 0; i < str_decimal1.length; i++) {
            correct_answer = "";
            if (str_decimal1[i] < str_decimal2[i]) {
                correct_answer = "2";
            }else{
                correct_answer = "1";
            }
            correct_answer1="";

            if (str_decimal1[i] < str_decimal2[i]) {
                correct_answer1 = "<";
            }else{
                correct_answer1 = ">";
            }
            if (str_decimal1[i] != str_decimal2[i]) {
                if ((str_decimal1.length-1) == i) {
                    if (arry_finalIndex[1]) {
                        result_str += "<p style='color:red;'> Error : " + arry_finalIndex[1] + "</p>";
                    }
                    if (arry_finalIndex[2]) {
                        result_str += "<p style='color:red;'> Error : " + arry_finalIndex[2] + "</p>";
                    }
                    result_str += "<p>Step "+ (i+8+i) +": Are the digits the same? No.<br> Which is largest?<font color=blue>"+ correct_answer +"</font></p>";
                    result_str += "<p>Step "+ (i+9+i) +": Answer.<br><b>"+ randomNumber1 +"</b><font color=blue>"+ correct_answer1 +"</font><b>"+ randomNumber2 +"</b></p>";
                    break;
                }
                if (i >= 1) {
                    if (arry_finalIndex[1]) {
                        result_str += "<p style='color:red;'> Error : " + arry_finalIndex[1] + "</p>";
                    }
                    if (arry_finalIndex[2]) {
                        result_str += "<p style='color:red;'> Error : " + arry_finalIndex[2] + "</p>";
                    }
                    result_str += "<p>Step "+ (i+8+i) +": Are the digits the same? No.<br> Which is largest?<font color=blue>"+ correct_answer +"</font></p>";
                    result_str += "<p>Step "+ (i+9+i) +": Answer.<br><b>"+ randomNumber1 +"</b><font color=blue>"+ correct_answer1 +"</font><b>"+ randomNumber2 +"</b></p>";
                    break;
                }else{
                    if (arry_finalIndex[1]) {
                        result_str += "<p style='color:red;'> Error : " + arry_finalIndex[1] + "</p>";
                    }
                    if (arry_finalIndex[2]) {
                        result_str += "<p style='color:red;'> Error : " + arry_finalIndex[2] + "</p>";
                    }
                    result_str += "<p>Step "+ (i+8) +": Are the digits the same? No.<br> Which is largest?<font color=blue>"+ correct_answer +"</font></p>";
                    result_str += "<p>Step "+ (i+9) +": Answer.<br><b>"+ randomNumber1 +"</b><font color=blue>"+ correct_answer1 +"</font><b>"+ randomNumber2 +"</b></p>";
                    break;
                }
                
            }else{
                if ((str_decimal1.length-1) == i) {
                    if (arry_finalIndex[2]) {
                        result_str += "<p style='color:red;'> Error : " + arry_finalIndex[2] + "</p>";
                    }
                    result_str += "<p>Step "+ (i+8+i) +": Answer.<br><b>"+ randomNumber1 +"</b><font color=blue> = </font><b>"+ randomNumber2 +"</b></p>";
                    break;
                }
                if (i >= 1) {
                    result_str += "<p>Step "+ (i+8+i) +": Are the digits the same?  Yes. <br>The digits are the same.</p>";
                    result_str += "<p>Step "+(i+9+i)+": What is the "+ ths_words[i+2] +" highest place value?<font color=blue>"+ decimal_words[i+1] +"</font></p>";
                    if (arry_temp[i+9+i]) {
                        result_str += "<p style='color:red;'> Error : " + arry_temp[i+9+i] + "</p>";
                    }
                }else{
                    result_str += "<p>Step "+ (i+8) +": Are the digits the same?  Yes. <br>The digits are the same.</p>";
                    result_str += "<p>Step "+(i+9)+": What is the "+ ths_words[i+2] +" highest place value?<font color=blue>"+ decimal_words[i+1] +"</font></p>";
                    if (arry_temp[i+9]) {
                        result_str += "<p style='color:red;'> Error : " + arry_temp[i+9] + "</p>";
                    }
                }

                
                
            }
        }
    }else{
        correct_answer = "";
        if (str_interger1 < str_interger2) {
            correct_answer = "2";
        }else{
            correct_answer = "1";
        }
        correct_answer1="";

        if (str_interger1 < str_interger2) {
            correct_answer1 = "<";
        }else{
            correct_answer1 = ">";
        }
        if (arry_finalIndex[1]) {
            result_str += "<p style='color:red;'> Error : " + arry_finalIndex[1] + "</p>";
        }
        if (arry_finalIndex[2]) {
            result_str += "<p style='color:red;'> Error : " + arry_finalIndex[2] + "</p>";
        }
        result_str += "<p>Step 6: Are the digits the same? No.<br>  Which is largest?<font color=blue>"+ correct_answer +"</font></p>";
        result_str += "<p>Step 7: Answer.<br><b>"+ randomNumber1 +"</b> <font color=blue>"+ correct_answer1 +"</font> <b>"+ randomNumber2 +"</b></p>";
    }
    result_str += "</div>";

    $("#correct_flow").html(result_str);

}

function displayTotalFlow1(){
    result_str = "";
    // result_str += "<b style='color:blue'>Correct Answered Flow</b>";
    // result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += '<label>Compare the decimals below by using >, < , or = <br><b>'+ randomNumber1 + '</b> And <b>'+ randomNumber2 + '</b></label>';
    result_str += "</div>";

    result_str += "<div>";
        result_str += "<p>Step 1: First, look what is being asked.</p>";
    result_str += "</div>";
    
    result_str += "<div>";
        result_str += "<p> Step 2. We have to compare with the signs >, <, =.</p>";
        result_str += "<p> Which sign shows less than? <font color=blue> < </font></p>";
        result_str += "<p> Which sign shows greater than? <font color=blue> > </font></p>";
        result_str += "<p> Which sign shows equals to? <font color=blue> = </font></p>";
    result_str += "</div>";


    result_str += "<div>";
        result_str += "<p>Step 3: Use the place value chart.  How many columns does the chart need? <font color=blue>"+ randomNumber1.length +"</font></p>";
        result_str += "<font color=blue>Remember the number of columns in the place value chart equals the number of digits in the number.</font>";
    
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 4: Put the numbers in the chart.</p>";

        result_str += "<table>";
            result_str += "<tr>";
            
                for (var i = -1; i < randomNumber1.length; i++) {
                    if (i == po1 && i != -1) {
                        result_str += "<th id='color_th'>Decimal</th>";
                    }else if (i > po1 && i != -1) {
                        result_str += "<th id='color_th'>" + decimal_words[i-po1-1] + "</th>";  
                    }else if (i < po1 && i != -1) {
                        result_str += "<th id='color_th'>" + number_words[po1 - i - 1] + "</th>";
                    }if (i == -1) {
                        result_str += "<th></th>";  
                    }
                    
                }
                
            result_str += "</tr>";
            result_str += "<tr>";
                for (var i = -1; i < randomNumber1.length; i++) {
                    if (i == po1 && i != -1) {
                        result_str += "<td>.</td>"; 
                    }else if (i != -1) {
                        result_str += "<td>"+ randomNumber1[i] +"</td>";
                    }
                    if (i == -1) {
                        result_str += "<td>Number1</td>";   
                    }
                    
                    
                }
            result_str += "</tr>";
            result_str += "<tr>";
                for (var i = -1; i < randomNumber2.length; i++) {
                    if (i == po1 && i != -1) {
                        result_str += "<td>.</td>"; 
                    }else if (i != -1) {
                        result_str += "<td>"+ randomNumber2[i] +"</td>";
                    }
                    if (i == -1) {
                        result_str += "<td>Number2</td>";   
                    }
                }
            result_str += "</tr>";
        result_str += "</table>";
        
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 5: What is the highest place value?  (Example, type in Tenths).<font color=blue>"+ number_words[randomNumber1.length - randomNumber2.length] +"</font></p>";
        
    result_str += "</div>";

    if (str_interger2 == str_interger1) {
        result_str += "<p>Step 6: Are the digits the same?  <br>Yes. The digits are the same.</p>";
        result_str += "<p>Step 7: What is the "+ ths_words[1] +" highest place value?<font color=blue>"+ decimal_words[0] +"</font></p>";
        
        for (var i = 0; i < str_decimal1.length; i++) {
            correct_answer = "";
            if (str_decimal1[i] < str_decimal2[i]) {
                correct_answer = "2";
            }else{
                correct_answer = "1";
            }
            correct_answer1="";

            if (str_decimal1[i] < str_decimal2[i]) {
                correct_answer1 = "<";
            }else{
                correct_answer1 = ">";
            }
            if (str_decimal1[i] != str_decimal2[i]) {
                if ((str_decimal1.length-1) == i) {
                    result_str += "<p>Step "+ (i+8+i) +": Are the digits the same? No.<br> Which is largest?<font color=blue>"+ correct_answer +"</font></p>";
                    result_str += "<p>Step "+ (i+9+i) +": Answer.<br><b>"+ randomNumber1 +"</b><font color=blue>"+ correct_answer1 +"</font><b>"+ randomNumber2 +"</b></p>";
                    break;
                }
                if (i >= 1) {
                    result_str += "<p>Step "+ (i+8+i) +": Are the digits the same? No.<br> Which is largest?<font color=blue>"+ correct_answer +"</font></p>";
                    result_str += "<p>Step "+ (i+9+i) +": Answer.<br><b>"+ randomNumber1 +"</b><font color=blue>"+ correct_answer1 +"</font><b>"+ randomNumber2 +"</b></p>";
                    break;
                }else{
                    result_str += "<p>Step "+ (i+8) +": Are the digits the same? No.<br> Which is largest?<font color=blue>"+ correct_answer +"</font></p>";
                    result_str += "<p>Step "+ (i+9) +": Answer.<br><b>"+ randomNumber1 +"</b><font color=blue>"+ correct_answer1 +"</font><b>"+ randomNumber2 +"</b></p>";
                    break;
                }
                
            }else{
                if ((str_decimal1.length-1) == i) {
                    result_str += "<p>Step "+ (i+8+i) +": Answer.<br><b>"+ randomNumber1 +"</b><font color=blue> = </font><b>"+ randomNumber2 +"</b></p>";
                    break;
                }
                if (i >= 1) {
                    result_str += "<p>Step "+ (i+8+i) +": Are the digits the same?  Yes. <br>The digits are the same.</p>";
                    result_str += "<p>Step "+(i+9+i)+": What is the "+ ths_words[i+2] +" highest place value?<font color=blue>"+ decimal_words[i+1] +"</font></p>"; 
                }else{
                    result_str += "<p>Step "+ (i+8) +": Are the digits the same?  Yes. <br>The digits are the same.</p>";
                    result_str += "<p>Step "+(i+9)+": What is the "+ ths_words[i+2] +" highest place value?<font color=blue>"+ decimal_words[i+1] +"</font></p>";
                }

                
                
            }
        }
    }else{
        correct_answer = "";
        if (str_interger1 < str_interger2) {
            correct_answer = "2";
        }else{
            correct_answer = "1";
        }
        correct_answer1="";

        if (str_interger1 < str_interger2) {
            correct_answer1 = "<";
        }else{
            correct_answer1 = ">";
        }
        result_str += "<p>Step 6: Are the digits the same? No.<br>  Which is largest?<font color=blue>"+ correct_answer +"</font></p>";
        result_str += "<p>Step 7: Answer.<br><b>"+ randomNumber1 +"</b> <font color=blue>"+ correct_answer1 +"</font> <b>"+ randomNumber2 +"</b></p>";
    }
    result_str += "</div>";
    $("#correct_flow_answer").html(result_str);
}