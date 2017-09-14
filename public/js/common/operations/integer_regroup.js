var step_count = 0;
var firstNumber = 0;
var secondNumber = 0;
var firsDigitsTonumber_words = 0;
var secondDigitsToNumber_words = 0;
var arry_temp = [];
var correct_answer = 0;
var correct_answer1 = 0;
var correct_answer2 = 0;

var step1_error1 = "";
var step1_error2 = "";
var step2_error1 = "";
var step2_error2 = "";
var step3_error1 = "";
var step3_error2 = "";

var step1_count = 0;
var step2_count = 0;
var step3_count = 0;

var step1Flag = false;
var step2Flag = false;
var step3Flag = false;
var alpaFlag = false;

var arry_total = [];
var number_words = ["One", "Ten", "Hundred", "Thousand", "Ten Thousand", "Hundred Thousand", "Million", "Ten Million", "Hundred Million"];

var answered = []; //ADDED

// start ADDED functions

//getter and setter

function getFirstNumber(){
    return firstNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function getFirstNumberWords(){
    return number_words[firsDigitsTonumber_words];
}

function getSecondNumber(){
    return secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function getSecondNumberWords(){
    return number_words[secondDigitsToNumber_words];
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

    step_count = 0;
    firstNumber = 0;
    secondNumber = 0;
    firsDigitsTonumber_words = 0;
    secondDigitsToNumber_words = 0;
    arry_temp = [];
    correct_answer = 0;
    correct_answer1 = 0;
    correct_answer2 = 0;


    step1_error1 = "";
    step1_error2 = "";
    step2_error1 = "";
    step2_error2 = "";
    step3_error1 = "";
    step3_error2 = "";

    step1_count = 0;
    step2_count = 0;
    step3_count = 0;

    step1Flag = false;
    step2Flag = false;
    step3Flag = false;
    alpaFlag = true;

    arry_total = [];

    randomDigits1 = parseInt($(".randomNumberDigits1").prop("value"));
    randomDigits2 = parseInt($(".randomNumberDigits2").prop("value"));
    randomWordDigits1 = parseInt($(".randomWordsDigits1").prop("value"));
    randomWordDigits2 = parseInt($(".randomWordsDigits2").prop("value"));
    if(isNaN(randomDigits1)) {
        randomDigits1 = 4;
        $(".randomNumberDigits1").prop("value", randomDigits1);
    }

    if(isNaN(randomDigits2)) {
        randomDigits2 = 1;
        $(".randomNumberDigits2").prop("value", randomDigits2);
    }

    if (randomDigits1 > 10) {
        randomDigits1 = 9;
        $(".randomNumberDigits1").prop("value", randomDigits1);
    }
    if (randomDigits2 > 10) {
        randomDigits2 = 9;
        $(".randomNumberDigits2").prop("value", randomDigits2);
    }

    if(isNaN(randomWordDigits1)) {
        randomWordDigits1 = 4;
        $(".randomWordsDigits1").prop("value", randomWordDigits1);
    }

    if(isNaN(randomWordDigits2)) {
        randomWordDigits2 = 1;
        $(".randomWordsDigits2").prop("value", randomWordDigits2);
    }

    if (randomWordDigits1 > 10) {
        randomWordDigits1 = 9;
        $(".randomWordsDigits1").prop("value", randomWordDigits1);
    }
    if (randomWordDigits2 > 10) {
        randomWordDigits2 = 9;
        $(".randomWordsDigits2").prop("value", randomWordDigits2);
    }

    max_t1 = digits(randomDigits1);
    max_t2 = digits(randomDigits2);

    max_t3 = digits(randomWordDigits1);
    max_t4 = digits(randomWordDigits2);

    firsDigitsTonumber_words = Math.floor(Math.random()*randomWordDigits1);
    secondDigitsToNumber_words = Math.floor(Math.random()*randomWordDigits2);

    if (firsDigitsTonumber_words == secondDigitsToNumber_words) {
        firsDigitsTonumber_words += 1;
    }

    if(secondDigitsToNumber_words > firsDigitsTonumber_words)
    {
        var num_tmp = firsDigitsTonumber_words;
        firsDigitsTonumber_words = secondDigitsToNumber_words;
        secondDigitsToNumber_words = num_tmp;
    }


    firstNumber =  Math.floor(Math.random()*max_t1);
    secondNumber =  Math.floor(Math.random()*max_t2);
    if (firstNumber == 0 || secondNumber == 0) {
        randomDigitsOnclick();
    }
    $("#answer_div").html("");
    $("#add_div").html("");
    $("#second_div").html("");
    $("#first_div").html("");
    $("#correct_flow").html("");
    $("#correct_flow_answer").html("");

    // str_randomNumber = str_randomNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    $("#firstNumber_b").html(firstNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $("#secondNumber_b").html(secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","));
    $("#firstDigits_label").html(number_words[firsDigitsTonumber_words]);
    $("#secondDigits_label").html(number_words[secondDigitsToNumber_words]);
    $("#start_div").show();
}

function startBtnOnclick(){

    step_count++;
    retry_attempt = 0;
    $("#step_div").show();
    var result_str = "";
    if (step_count == 1) {
        result_str = "<div>";
        result_str += "<p> <label style='color:red;'>" + firstNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " "+ number_words[firsDigitsTonumber_words] +"</label> and "+ secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +" "+ number_words[secondDigitsToNumber_words]+ "</p>";
        result_str += "<p>Step " + step_count +":   Expand the number.<font> E.g. 10x1,000. </font> Begin with " + number_words[firsDigitsTonumber_words] + ":</p>";
        result_str += "<label> "+number_words[firsDigitsTonumber_words] +" x " + firstNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</label>";
        result_str += " = <input class='inputCheck' style='width:80px'>";
        result_str += "<label id='step1_l' style='display:none'> = <input class='inputCheck' style='width:80px'></label>";
        result_str += "</div>";
        $("#first_div").html(result_str);
    }

    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == "y"){
                alertModal("Answer can't be alphabet!");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(checkAnswer($(this)) == "z"){
                alertModal('Input the valid expression');
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }

            temp_answer = checkAnswerValidation($(this));

            if (step1_count == 0) {
                if(temp_answer == true){
                    console.log("temp_answer = " + temp_answer);
                    alertModal('Write it out as an equation, example: 456+10');
                    $(this).prop("value", "").focus();
                    retry_attempt++;
                    return false;
                }
                if (temp_answer == false) {
                    alertModal("Answer can't be alphabet!");
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
                if(temp_answer == -3){
                    $(this).prop("value", "").focus();
                    return false;
                }
                $(this).attr("readonly", true);
                nextsetp();
            }

        }
    }).focus();
}

function nextsetp(){
    if (step1Flag == true || step2Flag == true || step3Flag == true ) {
        step_count--;
    }

    retry_attempt = 0;
    step_count++;
    result_str = "";
    if (step_count == 2) {
        if (step2Flag == false) {
            result_str += "<div>";
            result_str += "<p>" + firstNumber + " "+ number_words[firsDigitsTonumber_words] +" and <label style='color:red;'>"+ secondNumber +" "+ number_words[secondDigitsToNumber_words] +"</label></p>";
            result_str += "<p>Step " + step_count +":   Expand the number. <font> E.g. 1x5. </font> Work on the " + number_words[secondDigitsToNumber_words] + ":</p>";
            result_str += "<label> "+number_words[secondDigitsToNumber_words] +" x " + secondNumber + "</label>";
            result_str += " = <input class='inputCheck' style='width:80px;'>";
            result_str += "<label id='step2_l' style='display:none'> = <input class='inputCheck' style='width:80px;'></label>";
            result_str += "</div>";
            $("#second_div").html(result_str);
        }

    }

    if (step_count == 3) {
        if (step3Flag == false) {
            result_str += "<div>";
            result_str += "<p>Step " + step_count +":   Add the equations together.<font> E,g, 1,000+10</font></p>";
            result_str += "<input class='inputCheck' style='width:80px;'>";
            result_str += "<label id='step3_l' style='display:none'> = <input class='inputCheck' style='width:80px;'></label>";
            result_str += "</div>";
            $("#add_div").html(result_str);
        }

    }

    if (step_count == 4) {
        result_str += "<div>";
        result_str += "<p>Step " + step_count +":   Answer.</p>";
        result_str += "<label>" + arry_total[3].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</label>";
        result_str += "</div>";
        $("#answer_div").html(result_str);
        answerDone() //ADDED
        displayTotalFlow();
        displayTotalFlow1();
    }

    $(".inputCheck").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == "y"){
                alertModal("Answer can't be alphabet!");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(checkAnswer($(this)) == "z"){
                alertModal('Input the valid expression');
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }

            temp_answer = checkAnswerValidation($(this));
            if (alpaFlag == true) {
                if(temp_answer == true){
                    console.log("temp_answer = " + temp_answer);
                    alertModal('Write it out as an equation, example: 456+10');
                    $(this).prop("value", "").focus();
                    retry_attempt++;
                    return false;
                }
                if (temp_answer == false) {
                    alertModal("Answer can't be alphabet!");
                    $(this).prop("value", "").focus();
                    retry_attempt++;
                    return false;
                }
                if(temp_answer == -3){
                    $(this).prop("value", "").focus();
                    return false;
                }

                if (step_count != 4) {
                    $(this).attr("readonly", true);
                    nextsetp();
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
                if(temp_answer == -3){
                    $(this).prop("value", "").focus();
                    return false;
                }

                if (step_count != 4) {
                    $(this).attr("readonly", true);
                    nextsetp();
                }
            }


        }
    }).focus();
}


function checkAnswerValidation(elem) {

    answer_val = elem.prop("value");

    if (step_count == 1) {
        step1_count++;
        console.log("step1_count+ = "+ step1_count);
        if (step1_count == 1) {
            alpaFlag = true;
            correct_answer1 = digits(firsDigitsTonumber_words) + "x" + firstNumber;
            correct_answer2 = firstNumber + "x" + digits(firsDigitsTonumber_words);
            if (answer_val == correct_answer1){
                step1Flag = true;
                alpaFlag = false;
                $("#step1_l").show();
                return correct_answer1;
            }else if (answer_val == correct_answer2) {
                step1Flag = true;
                alpaFlag = false;
                $("#step1_l").show();
                return correct_answer2;
            } else{
                step1_error1 = answer_val;
                if (isValidExpression(answer_val)) {
                    if(retry_attempt > 1){
                        alertModal("Correct Answer is " + correct_answer1 + " or " + correct_answer2 + ". Retry! ");
                        step1_count--;
                        retry_attempt = 0;
                        return -3;
                    }else{
                        step1_count--;
                        return true;
                    }
                }else {
                    if(retry_attempt > 1){
                        alertModal("Correct Answer is " + correct_answer1 + " or " + correct_answer2 + ". Retry! ");
                        step1_count--;
                        retry_attempt = 0;
                        return -3;
                    }else{
                        step1_count--;
                        return false;
                    }
                }
                step1_count--;
            }

        }
        if (step1_count == 2) {
            alpaFlag = false;
            correct_answer = digits(firsDigitsTonumber_words)*firstNumber;
            if (answer_val == correct_answer){
                step1Flag = false;
                alpaFlag = true;
                arry_total[1] = correct_answer;
                return correct_answer;
            }
            if (answer_val > correct_answer) {
                if(retry_attempt > 1){

                    if (step1_count == 2) {
                        alertModal("Correct Answer is " + correct_answer + ". Retry! ");
                        step1_count--;
                    }
                    retry_attempt = 0;
                    return -3;
                }else{
                    if (step1_count == 2) {
                        step1_count--;
                        step1_error2 = answer_val;
                    }
                    return -1;
                }

            }else {
                if(retry_attempt > 1){
                    if (step1_count == 2) {
                        alertModal("Correct Answer is " + correct_answer + ". Retry! ");
                        step1_count--;
                    }
                    retry_attempt = 0;
                    return -3;
                }else{
                    if (step1_count == 2) {
                        step1_count--;
                        step1_error2 = answer_val;
                    }
                    return -2;
                }
            }
        }
    }

    if (step_count == 2) {

        step2_count++;
        if (step2_count == 1) {
            alpaFlag = true;
            correct_answer1 = digits(secondDigitsToNumber_words) + "x" + secondNumber;
            correct_answer2 = secondNumber + "x" + digits(secondDigitsToNumber_words);
            if (answer_val == correct_answer1){
                step2Flag = true;
                alpaFlag = false;
                $("#step2_l").show();
                return correct_answer1;
            }else if (answer_val == correct_answer2) {
                step2Flag = true;
                alpaFlag = false;
                $("#step2_l").show();
                return correct_answer2;
            } else{
                step2_error1 = answer_val;
                if (isValidExpression(answer_val)) {
                    if(retry_attempt > 1){
                        alertModal("Correct Answer is " + correct_answer1 + " or " + correct_answer2 + ". Retry! ");
                        step2_count--;
                        retry_attempt = 0;
                        return -3;
                    }else{
                        step2_count--;
                        return true;
                    }
                }else {
                    if(retry_attempt > 1){
                        alertModal("Correct Answer is " + correct_answer1 + " or " + correct_answer2 + ". Retry! ");
                        step2_count--;
                        retry_attempt = 0;
                        return -3;
                    }else{
                        step2_count--;
                        return false;
                    }
                }
                step2_count--;
            }
        }
        if (step2_count == 2) {
            alpaFlag = false;
            correct_answer = digits(secondDigitsToNumber_words)*secondNumber;
            if (answer_val == correct_answer){
                step2Flag = false;
                alpaFlag = true;
                arry_total[2] = correct_answer;
                return correct_answer;
            }
            if (answer_val > correct_answer) {
                if(retry_attempt > 1){

                    if (step2_count == 2) {
                        alertModal("Correct Answer is " + correct_answer + ". Retry! ");
                        step2_count--;
                    }
                    retry_attempt = 0;
                    return -3;
                }else{
                    if (step2_count == 2) {
                        step2_count--;
                        step2_error2 = answer_val;
                    }
                    return -1;
                }

            }else {
                if(retry_attempt > 1){
                    if (step2_count == 2) {
                        alertModal("Correct Answer is " + correct_answer + ". Retry! ");
                        step2_count--;
                    }
                    retry_attempt = 0;
                    return -3;
                }else{
                    if (step2_count == 2) {
                        step2_count--;
                        step2_error2 = answer_val;
                    }
                    return -2;
                }
            }
        }
    }

    if (step_count == 3) {
        step3_count++;
        if (step3_count == 1) {
            alpaFlag = true;
            correct_answer1 = arry_total[1] + "+" + arry_total[2];
            correct_answer2 = arry_total[2] + "+" + arry_total[1];
            if (answer_val == correct_answer1){
                step3Flag = true;
                alpaFlag = false;
                $("#step3_l").show();
                return correct_answer1;
            }else if (answer_val == correct_answer2) {
                step3Flag = true;
                alpaFlag = false;
                $("#step3_l").show();
                return correct_answer2;
            } else{
                step3_error1 = answer_val;
                if (isValidExpression(answer_val)) {
                    if(retry_attempt > 1){
                        alertModal("Correct Answer is " + correct_answer1 + " or " + correct_answer2 + ". Retry! ");
                        step3_count--;
                        retry_attempt = 0;
                        return -3;
                    }else{
                        step3_count--;
                        return true;
                    }
                }else {
                    if(retry_attempt > 1){
                        alertModal("Correct Answer is " + correct_answer1 + " or " + correct_answer2 + ". Retry! ");
                        step3_count--;
                        retry_attempt = 0;
                        return -3;
                    }else{
                        step3_count--;
                        return false;
                    }
                }
                step3_count--;
            }
        }
        if (step3_count == 2) {
            alpaFlag = false;
            correct_answer = arry_total[1] + arry_total[2];
            if (answer_val == correct_answer){
                step3Flag = false;
                arry_total[3] = correct_answer;
                return correct_answer;
            }
            if (answer_val > correct_answer) {
                if(retry_attempt > 1){

                    if (step3_count == 2) {
                        alertModal("Correct Answer is " + correct_answer + ". Retry! ");
                        step3_count--;
                    }
                    retry_attempt = 0;
                    return -3;
                }else{
                    if (step3_count == 2) {
                        step3_count--;
                        step3_error2 = answer_val;
                    }
                    return -1;
                }

            }else {
                if(retry_attempt > 1){
                    if (step3_count == 2) {
                        alertModal("Correct Answer is " + correct_answer + ". Retry! ");
                        step3_count--;
                    }
                    retry_attempt = 0;
                    return -3;
                }else{
                    if (step3_count == 2) {
                        step3_count--;
                        step3_error2 = answer_val;
                    }
                    return -2;
                }
            }
        }
    }

    if (step_count == 4) {
        alpaFlag = false;

        correct_answer = 9;

        if (answer_val == correct_answer){
            arry_correctval[2] = correct_answer;
            answerDone() // ADDED
            displayTotalFlow();
            displayTotalFlow1();
            return correct_answer;
        }
        if (answer_val > correct_answer) {

            if(retry_attempt > 1){
                alertModal("Correct Answer is " + correct_answer + ". Retry! ");
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                return -1;
            }

        }else {
            if(retry_attempt > 1){
                alertModal("Correct Answer is " + correct_answer + ". Retry! ");
                retry_attempt = 0;
                return -3;
            }else{
                if (!arry_temp[step_count]) {
                    arry_temp[step_count] = answer_val;
                }
                return -2;
            }
        }
    }

}

function isValidExpression(__str_expr){
    var __temp_expr = __str_expr.match( /[1-9.+-/*=]*/ );
    return (__temp_expr == __str_expr);
}



function checkAnswer(elem) {
    answer_val = elem.prop("value");
    setAnswered(answer_val);	//added
    if (alpaFlag == false) {
        if(isNaN(answer_val)) {
            return "y";
        }
        if (answer_val == "") {
            return "z";
        }
    }else{
        console.log("alpaFlag = " + alpaFlag);
        if (answer_val == "") {
            return "z";
        }
    }
    elem.prop("value", answer_val);
}

function displayTotalFlow(){
    result_str = "";
    result_str += "<b style='color:blue'>Answered Flow</b>";
    result_str += "<br><br>";
    result_str += '<p>How would you represent <b>'+ firstNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +'</b> <label>' + number_words[firsDigitsTonumber_words] + '</label> and <b>' + secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</b> <label>' + number_words[secondDigitsToNumber_words] + '</label>, to make one number?</p>';
    result_str += "<div>";
    result_str += "<p> <label style='color:red;'>" + firstNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " "+ number_words[firsDigitsTonumber_words] +"</label> and "+ secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +" "+ number_words[secondDigitsToNumber_words]+ "</p>";
    result_str += "<p>Step 1:   Expand the number. Begin with " + number_words[firsDigitsTonumber_words] + ":</p>";

    if (step1_error1 != "") {
        result_str += "<p style='color:red;'> Error : " + step1_error1 + "</p>";
    }
    if (step1_error2 != "") {
        result_str += "<p style='color:red;'> Error : " + step1_error2 + "</p>";
    }
    result_str += "<label> "+number_words[firsDigitsTonumber_words] +" x " + firstNumber + "</label>";
    result_str += " = " + digits(firsDigitsTonumber_words).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " x " + firstNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    result_str += " = <label style='color:blue;'>" + arry_total[1].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</label>";
    result_str += "</div>";


    result_str += "<div>";
    result_str += "<p>" + firstNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " "+ number_words[firsDigitsTonumber_words] +" and <label style='color:red;'>"+ secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +" "+ number_words[secondDigitsToNumber_words] +"</label></p>";
    result_str += "<p>Step 2:   Expand the number. Work on the " + number_words[secondDigitsToNumber_words] + ":</p>";

    if (step2_error1 != "") {
        result_str += "<p style='color:red;'> Error : " + step2_error1 + "</p>";
    }
    if (step2_error2 != "") {
        result_str += "<p style='color:red;'> Error : " + step2_error2 + "</p>";
    }
    result_str += "<label> "+number_words[secondDigitsToNumber_words] +" x " + secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</label>";
    result_str += " = " + digits(secondDigitsToNumber_words).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " x " + secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    result_str += " = <label style='color:blue;'>" + arry_total[2].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</label>";
    result_str += "</div>";


    result_str += "<div>";
    result_str += "<p>Step 3:   Add the numbers together.</p>";
    if (step3_error1 != "") {
        result_str += "<p style='color:red;'> Error : " + step3_error1 + "</p>";
    }
    if (step3_error2 != "") {
        result_str += "<p style='color:red;'> Error : " + step3_error2 + "</p>";
    }
    result_str += arry_total[1].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " + " + arry_total[2].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    result_str += " = <label style='color:blue;'>" + arry_total[3].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</label>";
    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p>Step 4: What is the answer?</p>";
    // result_str += "<p style='color:red;'> Error : " + arry_temp[4] + "</p>";
    result_str += "<label style='color:blue;'>" + arry_total[3].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</label>";
    $("#correct_flow").html(result_str);

}

function displayTotalFlow1(){
    result_str = "";
    result_str += "<b style='color:blue'>Correct Answered Flow</b>";
    result_str += "<br><br>";
    result_str += '<p>How would you represent <b>'+ firstNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +'</b> <label>' + number_words[firsDigitsTonumber_words] + '</label> and <b>' + secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '</b> <label>' + number_words[secondDigitsToNumber_words] + '</label>, to make one number?</p>';
    result_str += "<div>";
    result_str += "<p> <label style='color:red;'>" + firstNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " "+ number_words[firsDigitsTonumber_words] +"</label> and "+ secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +" "+ number_words[secondDigitsToNumber_words]+ "</p>";
    result_str += "<p>Step 1:   Expand the number. Begin with " + number_words[firsDigitsTonumber_words] + ":</p>";
    result_str += "<label> "+number_words[firsDigitsTonumber_words] +" x " + firstNumber + "</label>";
    result_str += " = " + digits(firsDigitsTonumber_words).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " x " + firstNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    result_str += " = <label style='color:blue;'>" + arry_total[1].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</label>";
    result_str += "</div>";


    result_str += "<div>";
    result_str += "<p>" + firstNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " "+ number_words[firsDigitsTonumber_words] +" and <label style='color:red;'>"+ secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") +" "+ number_words[secondDigitsToNumber_words] +"</label></p>";
    result_str += "<p>Step 2:   Expand the number. Work on the " + number_words[secondDigitsToNumber_words] + ":</p>";
    result_str += "<label> "+number_words[secondDigitsToNumber_words] +" x " + secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</label>";
    result_str += " = " + digits(secondDigitsToNumber_words).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " x " + secondNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    result_str += " = <label style='color:blue;'>" + arry_total[2].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</label>";
    result_str += "</div>";


    result_str += "<div>";
    result_str += "<p>Step 3:   Add the numbers together.</p>";
    result_str += arry_total[1].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + " + " + arry_total[2].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    result_str += " = <label style='color:blue;'>" + arry_total[3].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</label>";
    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p>Step 4: What is the answer?</p>";
    result_str += "<label style='color:blue;'>" + arry_total[3].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + "</label>";
    $("#correct_flow_answer").html(result_str);

}

function displayFraction(IsAfter, elemAfter){

    current_str = "";
    for (var i = 0; i < exponentsNumber; i++) {
        if (i == 0) result_str = "<br><label id='valuetoinput_l" + i + "' style='color:blue;'> What is " + baseNumber + " = <input class='inputCheck' style='width:80px;'> --- " + (i+1) + "<sup>" + arr_orderNumber[i] + "</sup></label>"
        if(i > 0) current_str += "x";
        current_str += baseNumber;
        result_str += "<br><label id='valuetoinput_l" + (i+1) + "' style='color:blue;display:none'>What is " + current_str + " x "+ baseNumber +" = <input class='inputCheck' style='width:80px;'> --- " + (i+2) + "<sup>" + arr_orderNumber[i + 1] + "</sup></label>";
    }
    if(IsAfter)
        $(result_str).insertAfter(elemAfter);
    else
        $(result_str).insertBefore(elemAfter);
}