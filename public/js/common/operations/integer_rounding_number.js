var randomNumber = 0;
var randonWordsIndex = 0;
var step_count = 0;
var real_number = "";
var str_randomNumber = "";

var arry_correctval = [];
var arry_total = [];
var arry_randomNumber = [];
var arry_temp = [];
var arry_correct_answer = [];
var number_words = ["One", "Ten", "Hundred", "Thousand", "Ten Thousand", "Hundred Thousand", "Million", "Ten Million", "Hundred Million"];
var number_words_small = ["one", "ten", "hundred", "thousand", "ten thousand", "hundred thousand", "million", "ten million", "hundred million"];
var round_words = ["Up", "Down"];
var round_words_small = ["up", "down"];

var answered = []; //ADDED

// start ADDED functions

//getter and setter

function getRandomNumber(){
    return str_randomNumber;
}

function getRandomWords(){
    return number_words[randonWordsIndex];
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

function alertModal(message){
    dynamicBlock();
    $("#message_text_modal").html(message);
    $("#message_modal_dynamic").show();
    $("#close_modal").show();
}

function btnNOOnclose() {
    $("#message_modal_dynamic").hide();
    $("input").attr("readonly", false);
}

// end ADDED functions

function randomDigitsOnclick(){

    randomNumber = 0;
    randonWordsIndex = 0;
    step_count = 0;
    real_number = "";
    str_randomNumber = "";

    arry_correctval = [];
    arry_total = [];
    arry_randomNumber = [];
    arry_temp = [];
    arry_correct_answer = [];

    str_randomNumber = "";

    var text = "";
    var possible = "123456789";



    randomDigits = parseInt($(".randomDigits").prop("value"));
    if(isNaN(randomDigits)) {
        randomDigits = 4;
        $(".randomDigits").prop("value", randomDigits);
    }
    if (randomDigits > 10) {
        randomDigits = 9;
        $(".randomDigits").prop("value", randomDigits);
    }

    for (var i = 0; i < randomDigits; i++)
        str_randomNumber += possible.charAt(Math.floor(Math.random() * possible.length));

    real_number = str_randomNumber;

    str_randomNumber = str_randomNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    // str_randomNumber = "9999";
    randonWordsIndex = Math.floor(Math.random() * real_number.length);
    // randonWordsIndex = 3;
    if (randonWordsIndex == 0) randonWordsIndex = 1;
    $("#step_div").html('<div id="step_div" style="width: 700px; float: left;"><br><div id="tableNumber_div"></div><div id="lastDiv"></div></div>');
    $("#correct_flow").html("");
    $("#correct_flow_answer").html("");

    $("#randomNumber_b").html(str_randomNumber);
    $("#randomWords_b").html(number_words[randonWordsIndex]);
    $("#start_div").show();
}

function startBtnOnclick(){
    step_count++;
    retry_attempt = 0;
    $("#step_div").show();
    var result_str = "";
    if (step_count == 1) {
        result_str = "<div>";
        result_str += "<p>Step " + step_count +": What is being asked?  <br>Round to the nearest <input class='inputCheck'> place.</p>";
        result_str += "</div>";
        $("#tableNumber_div").html(result_str);
    }

    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){

            if(checkAnswer($(this)) == "z"){
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
            $(this).attr("readonly", true);
            nextsetp();
        }
    }).focus();
}

function nextsetp(){

    retry_attempt = 0;
    step_count++;
    result_str = "";
    if (step_count == 2) {
        $("<p>Step " + step_count + " :  Identify the number in the "+ number_words[randonWordsIndex] +" place. </p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
    }
    if (step_count == 3) {
        $("<p>Step " + step_count + " :  What is the number to the right of the digit in the "+ number_words[randonWordsIndex] +" place? </p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
    }
    if (step_count == 4) {
        $("<p>Step " + step_count + " :  Do you round up or down?</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
    }
    if (step_count == 5) {
        $("<p>Step " + step_count + " : Answer </p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
    }
    if (step_count == 6) {
        displayTotalFlow();
        CorrectdisplayTotalFlows();
    }

    $(".inputCheck").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == "y"){
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(checkAnswer($(this)) == "z"){
                alertModal('Input the answer.');
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }

            temp_answer = checkAnswerValidation($(this));
            if (step_count == 4) {
                if(temp_answer == -1){
                    alertModal("Your answer is larger than what we need.");
                    $(this).prop("value", "").focus();
                    retry_attempt++;
                    return false;
                }
                if(temp_answer == -2){
                    alertModal("That is incorrect, try again");
                    $(this).prop("value", "").focus();
                    retry_attempt++;
                    return false;
                }
            }else{
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


function checkAnswerValidation(elem) {

    answer_val = elem.prop("value");

    if (step_count == 1) {

        arry_correct_answer[1] = number_words[randonWordsIndex];
        arry_correct_answer[2] = number_words_small[randonWordsIndex];
        correct_answer = arry_correct_answer[1];
        if (answer_val == arry_correct_answer[1]){
            correct_answer = arry_correct_answer[1];
            arry_correctval[1] = correct_answer;
            return correct_answer;
        }

        if (answer_val == arry_correct_answer[2]){
            correct_answer = arry_correct_answer[2];
            arry_correctval[1] = correct_answer;
            return correct_answer;
        }
    }

    if (step_count == 2) {

        correct_answer = real_number[real_number.length - randonWordsIndex - 1];
        if (answer_val == correct_answer){
            return correct_answer;
        }
    }

    if (step_count == 3) {
        correct_answer = real_number[real_number.length - randonWordsIndex];
        if (answer_val == correct_answer){
            return correct_answer;
        }
    }

    if (step_count == 4) {
        console.log("step4");
        if (real_number[real_number.length - randonWordsIndex] >= 5) {
            arry_correct_answer[3] = round_words[0];
            arry_correct_answer[4] = round_words_small[0];
            if (answer_val == arry_correct_answer[3]){
                correct_answer = arry_correct_answer[3];
                arry_correctval[3] = correct_answer;
                return correct_answer;
            }
            if (answer_val == arry_correct_answer[4]){
                correct_answer = arry_correct_answer[4];
                arry_correctval[3] = correct_answer;
                return correct_answer;
            }
        }else{
            arry_correct_answer[3] = round_words[1];
            arry_correct_answer[4] = round_words_small[1];
            if (answer_val == arry_correct_answer[3]){
                correct_answer = arry_correct_answer[3];
                arry_correctval[4] = correct_answer;
                return correct_answer;
            }
            if (answer_val == arry_correct_answer[4]){
                correct_answer = arry_correct_answer[4];
                arry_correctval[4] = correct_answer;
                return correct_answer;
            }
        }
    }

    str_number = "";
    if (step_count == 5) {
        if (real_number[real_number.length - randonWordsIndex] < 5) {
            for (var i = real_number.length - 1; i >= 0; i--) {
                if (i >= randonWordsIndex) {
                    str_number += real_number[real_number.length - i - 1] * 1;
                }else{
                    str_number += "0";
                }
            }
            correct_answer = str_number;
        }else{
            for (var i = real_number.length - 1; i >= 0; i--) {
                if (i > randonWordsIndex) {
                    str_number += real_number[real_number.length - i - 1] * 1;
                }else if (i == randonWordsIndex) {
                    str_number += real_number[real_number.length - i - 1] * 1 + 1;
                }else{
                    str_number += "0";
                }
            }
            correct_answer = str_number;
        }
        if (answer_val == correct_answer){
            return correct_answer;
        }
    }

    if(retry_attempt > 1){
        if (step_count == 1) {
            alertModal("The correct answer is " + arry_correct_answer[1] + ". Please retry. ");
        }else if (step_count == 4) {
            alertModal("The correct answer is " + arry_correct_answer[3] + ". Please retry. ");
        } else{
            alertModal("The correct answer is " + correct_answer + ". Please retry. ");
        }
        retry_attempt = 0;
        return -3;
    }
    if (answer_val > correct_answer) {
        if (!arry_temp[step_count]) {
            arry_temp[step_count] = answer_val;
            console.log("1temp_answer = " + arry_temp[step_count]);
        }
        return -1;
    }else {
        if (!arry_temp[step_count]) {
            arry_temp[step_count] = answer_val;
            console.log("temp_answer = " + arry_temp[step_count]);
        }

        return -2;
    }
}


function checkAnswer(elem) {
    answer_val = elem.prop("value");
    if (step_count == 1 || step_count == 4) {
        if (answer_val == "") {
            return "z";
        }
    }else{

        if(isNaN(answer_val)) {
            return "y";
        }
        if (answer_val == "") {
            return "z";
        }
    }
}

function displayTotalFlow(){
    result_str = "";
    result_str += "<b style='color:blue'>Answered Flow</b>";
    result_str += "<br><br>";
    result_str += "<div id='start_div'>";
    result_str += "<label>Round <b>" + str_randomNumber + "</b> to the nearest " + number_words[randonWordsIndex] + " place</label>";
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 1:  What is being asked?  Round to the nearest <font color=blue>" + arry_correctval[1] + "</font> place</p>";
    if (arry_temp[1]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[1] + "</p>";
    }
    result_str += "<div>";

    result_str += "<p>Step 2:  Identify the number in the <font color=blue>" + arry_correctval[1] + "</font> place. <font color=blue>"+ real_number[real_number.length - randonWordsIndex - 1] +"</font></p>";
    if (arry_temp[2]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[2] + "</p>";
    }
    result_str += "<p>Place the numbers in a place table.  <br>Note there are "+ real_number.length +" digits hence we need "+ real_number.length +" columns</p>";
    result_str += "<table>";
    result_str += "<tr>";

    for (var i = real_number.length-1; i >= 0; i--) {
        result_str += "<th>" + number_words[i] + "</th>";
    }

    result_str += "</tr>";
    result_str += "<tr>";
    for (var i = 0; i < real_number.length; i++) {
        result_str += "<td>" + real_number[i] + "</td>";
    }
    result_str += "</tr>";
    result_str += "</table>";
    result_str += "<p>Now we can easily see the number "+ real_number[real_number.length - randonWordsIndex - 1] +" in the " + number_words[randonWordsIndex] + " place.</p>";
    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p> Step 3: What is the number to the right of the digit in the hundreds place? <font color=blue>" + real_number[real_number.length - randonWordsIndex] + "</font></p>";
    if (arry_temp[3]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[3] + "</p>";
    }
    result_str += "<p>Now look at the number to the right.  What is the value, it is " + real_number[real_number.length - randonWordsIndex] + ".</p>";
    result_str += "</div>";

    result_str += "<div>";
    s1 = "";
    s2 = "";
    if (real_number[real_number.length - randonWordsIndex] >= 5) {
        s1 += arry_correctval[3];
    }else{
        s1 += arry_correctval[4];
    }

    result_str += "<p> Step 4: Do you round up or down? <font color=blue>"+ s1 +"</font></p>";
    if (arry_temp[4]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[4] + "</p>";
    }
    result_str += "<p>Because the value to the left of the number we round "+ s1 +"</p>";
    result_str += "<p style='color:red;'>Remember, if the number to the right is 5 or higher, you round up.  <br>If less than 5 round down.</p>";
    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p>Step 5: What is the answer?</p>";
    if (arry_temp[5]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[5] + "</p>";
    }
    result_str += "<p style='color:red;'>Now round "+ s1 +".  <br>This means that the numbers to the right of the number in question turn to 0.<br>The number in question does not change.</p>";
    str_number = "";
    if (real_number[real_number.length - randonWordsIndex] < 5) {
        console.log("1");
        for (var i = real_number.length - 1; i >= 0; i--) {
            if (i >= randonWordsIndex) {
                str_number += real_number[real_number.length - i - 1] * 1;
            }else{
                str_number += "0";
            }
        }
        s2 += str_number;
    }else{
        console.log("21");
        for (var i = real_number.length - 1; i >= 0; i--) {
            if (i > randonWordsIndex) {
                str_number += real_number[real_number.length - i - 1] * 1;
            }else if (i == randonWordsIndex) {
                str_number += real_number[real_number.length - i - 1] * 1 + 1;
            }else{
                str_number += "0";
            }
        }
        s2 += str_number;
    }
    result_str += "<p>The anwer is <font color=blue>" + s2 + "</font></p>";

    $("#correct_flow").html(result_str);

}

function CorrectdisplayTotalFlows(){
    result_str = "";
    result_str += "<b style='color:blue'>Answered Flow</b>";
    result_str += "<br><br>";
    result_str += "<div id='start_div'>";
    result_str += "<label>Round <b>" + str_randomNumber + "</b> to the nearest " + number_words[randonWordsIndex] + " place</label>";
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 1:  What is being asked?  Round to the nearest <font color=blue>" + arry_correctval[1] + "</font> place</p>";
    result_str += "<div>";

    result_str += "<p>Step 2:  Identify the number in the <font color=blue>" + arry_correctval[1] + "</font> place. <font color=blue>"+ real_number[real_number.length - randonWordsIndex - 1] +"</font></p>";
    result_str += "<p>Place the numbers in a place table.  <br>Note there are "+ real_number.length +" digits hence we need "+ real_number.length +" columns</p>";
    result_str += "<table>";
    result_str += "<tr>";

    for (var i = real_number.length-1; i >= 0; i--) {
        result_str += "<th>" + number_words[i] + "</th>";
    }

    result_str += "</tr>";
    result_str += "<tr>";
    for (var i = 0; i < real_number.length; i++) {
        result_str += "<td>" + real_number[i] + "</td>";
    }
    result_str += "</tr>";
    result_str += "</table>";
    result_str += "<p>Now we can easily see the number "+ real_number[real_number.length - randonWordsIndex - 1] +" in the " + number_words[randonWordsIndex] + " place.</p>";
    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p> Step 3: What is the number to the right of the digit in the hundreds place? <font color=blue>" + real_number[real_number.length - randonWordsIndex] + "</font></p>";
    result_str += "<p>Now look at the number to the right.  What is the value, it is " + real_number[real_number.length - randonWordsIndex] + ".</p>";
    result_str += "</div>";

    result_str += "<div>";
    s1 = "";
    s2 = "";
    if (real_number[real_number.length - randonWordsIndex] < 5) {
        s1 += arry_correctval[3];
    }else{
        s1 += arry_correctval[4];
    }

    result_str += "<p> Step 4: Do you round up or down? <font color=blue>"+ s1 +"</font></p>";
    result_str += "<p>Because the value to the left of the number we round "+ s1 +"</p>";
    result_str += "<p style='color:red;'>Remember, if the number to the right is 5 or higher, you round up.  <br>If less than 5 round down.</p>";
    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p>Step 5: Answer</p>";
    result_str += "<p style='color:red;'>Now round "+ s1 +".  <br>This means that the numbers to the right of the number in question turn to 0.<br>The number in question does not change.</p>";
    str_number = "";
    if (real_number[real_number.length - randonWordsIndex] < 5) {
        console.log("1");
        for (var i = real_number.length - 1; i >= 0; i--) {
            if (i >= randonWordsIndex) {
                str_number += real_number[real_number.length - i - 1] * 1;
            }else{
                str_number += "0";
            }
        }
        s2 += str_number;
    }else{
        console.log("21");
        for (var i = real_number.length - 1; i >= 0; i--) {
            if (i > randonWordsIndex) {
                str_number += real_number[real_number.length - i - 1] * 1;
            }else if (i == randonWordsIndex) {
                str_number += real_number[real_number.length - i - 1] * 1 + 1;
            }else{
                str_number += "0";
            }
        }
        s2 += str_number;
    }
    result_str += "<p>The anwer is <font color=blue>" + s2 + "</font></p>";
    $("#correct_flow_answer").html(result_str);

}