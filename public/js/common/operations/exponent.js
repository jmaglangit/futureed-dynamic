/**
 * Code from client
 * 20170713
 */

var baseNumber = 0;
var exponentsNumber = 0;
var step_count = 0;
var total_result = 1;
var exponent_count = -1;
var val_ofexponent_count = 1;

var arry_correctval = [];
var arry_total = [];
var arry_err_temp = [];
var arry_err_temp3 = [];
var arr_orderNumber = ['st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];

var flagofequationdisplay = false;
var answered = []; //ADDED


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
    dynamicBlock();
    $("#message_text_modal").html(message);
    $("#message_modal_dynamic").show();
    $("#close_modal").show();
    $("#yes_modal").hide();
    $("#no_modal").hide();
}

function closeModal(){
    dynamicUnBlock();
    $("#message_modal_dynamic").hide();
}

// end ADDED functions
function randomDigitsOnclick(){

    baseNumber = 0;
    exponentsNumber = 0;
    step_count = 0;
    total_result = 1;
    exponent_count = -1;
    val_ofexponent_count = 1;

    arry_correctval = [];
    arry_total = [];

    arry_err_temp = [];
    arry_err_temp3 = [];
    randomDigits = parseInt($(".randomDigits").prop("value"));
    if(isNaN(randomDigits)) {
        randomDigits = 1;
        $(".randomDigits").prop("value", randomDigits);
    }
    max_t = randomDigits;

    baseNumber = Math.floor(Math.random() * max_t);
    exponentsNumber = Math.floor(Math.random() * max_t);

    baseNumber = baseNumber>1 ? baseNumber : baseNumber + 2;
    exponentsNumber = exponentsNumber>1 ? exponentsNumber : exponentsNumber + 2;
    
    $("#base_div").html("");
    $("#exponents_div").html("");
    $("#writeequation_div").html("");
    $("#answer").html("");
    $("#correct_flow").html("");
    $("#correct_flow_answer").html("");

    $("#baseNumber_l").html(baseNumber);
    $("#exponents_sup").html(exponentsNumber);
    $("#start_div").show();
}

function startBtnOnclick(){
    step_count++;
    retry_attempt = 0;
    $("#step_div").show();
    var result_str = "";
    if (step_count == 1) {
        result_str = "<div>";
        result_str += "<p>Step " + step_count +":  Which is the base?</p>";
        result_str += "<span>";
            result_str += "<label> " + baseNumber + " </label>";
            result_str += "<sup>" + exponentsNumber + " </sup>";
            result_str += " : <input type='text' class='inputCheck'>";
        result_str += "</span>";
        result_str += "</div>";
        $("#base_div").html(result_str);
    }

    $(".inputCheck").keydown(function(event){
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
            $(this).attr("readonly", true);
            nextsetp();                 
        }
    }).focus();
}

function nextsetp(){
    
    retry_attempt = 0;

    if (flagofequationdisplay == true) {
        step_count--;
    }

    step_count++;
                
    result_str = "";
    if (step_count == 2) {
        result_str = "<div>";
        result_str += "<p>Step " + step_count +":  Which is the exponential?</p>";
        result_str += "<span>";
            result_str += "<label> " + baseNumber + " </label>";
            result_str += "<sup>" + exponentsNumber + " </sup>";
            result_str += " : <input type='text' class='inputCheck'>";
        result_str += "</span>";
        result_str += "</div>";
        $("#exponents_div").html(result_str);
    }

    if (step_count == 3) {
        if (flagofequationdisplay == false) {
            result_str = "<div id='examPane'>";
            result_str += "<p> Step " + step_count + ": Write out in equation form. <br> (Example 1<sup>3</sup> = 1x1x1)</p>";
            result_str += "<span>";
                result_str += "<label> " + baseNumber + " </label>";
                result_str += "<sup>" + exponentsNumber + " </sup>";
                result_str += " : <input type='text' class='inputCheck'>";
            result_str += "</span>";
            result_str += "</div>";
            
            $("#writeequation_div").html(result_str);
        }
        // setTimeout(nextsetp, 2000);
    }

    if (step_count == 4) {
        result_str = "<div>";
        result_str += "<p> Step " + step_count + ": Answer.</p>";
        result_str += "<span>";
            result_str += "<label> " + baseNumber + " </label>";
            result_str += "<sup>" + exponentsNumber + " </sup>";
            result_str += " = <input type='text' class='inputCheck'>";
        result_str += "</span>";
        for (var i = 1; i <= exponentsNumber; i++) {
            total_result = total_result * baseNumber;
            arry_total[i] = total_result;
        }
        
        result_str += "</div>";
        $("#answer").html(result_str);
        // displayTotalFlow();
    }

    $(".inputCheck").unbind("keydown").keydown(function(event){
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

            if (step_count != 4) {
                $(this).attr("readonly", true);
                nextsetp();
            }
            
        }   
    }).focus();
}


function checkAnswerValidation(elem) {
    
    if (step_count == 3) {
        answer_val = elem.prop("value");
    }else{
        answer_val = parseInt(elem.prop("value"));
    }

    getbaseNumber = parseInt($("#baseNumber_l").text());
    getexponentsNumber = parseInt($("#exponents_sup").text());
    
    if (step_count == 1) {
        correct_answer = getbaseNumber;
        if (answer_val == correct_answer){
            arry_correctval[1] = correct_answer;
            return correct_answer;  
        }
    }

    if (step_count == 2) {

        correct_answer = getexponentsNumber;
        
        if (answer_val == correct_answer){
            arry_correctval[2] = correct_answer;
        
            return correct_answer;  
        }               
    }

    if (step_count == 3) {
        exponent_count++;
        if (exponent_count == 0) {
            current_str = "";
            for (var i = 0; i < exponentsNumber; i++) {
                if(i > 0) current_str += "x";
                current_str += baseNumber;
            }
            

            correct_answer = current_str;
            
            if (answer_val == correct_answer){
                flagofequationdisplay = true;
                arry_correctval[3] = correct_answer;
                displayFraction(true, "#examPane");
                return correct_answer;  
            }
        }
        

        if (exponent_count == val_ofexponent_count) {
            total_result = 1;
            for (var i = 0; i < exponentsNumber; i++) {
                total_result *= baseNumber;
                arry_total[i] = total_result;
            }
            correct_answer = arry_total[val_ofexponent_count-1];
            
            if (answer_val == correct_answer && exponent_count == arry_total.length) {
                flagofequationdisplay = false;
                nextsetp();
                return;
            }

            if (answer_val == correct_answer){
                $("#valuetoinput_l"+val_ofexponent_count).show();
                val_ofexponent_count++;
                return correct_answer;  
            }
            

        }

        if (answer_val > correct_answer) {
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry. ");
                retry_attempt = 0;
                exponent_count--;
                return -3;
            }else{
                if (!arry_err_temp3[exponent_count]) {
                    arry_err_temp3[exponent_count] = answer_val;
                }
                exponent_count--;
                return -1;
            }
        }else{
            if(retry_attempt > 1){
                alertModal("The correct answer is " + correct_answer + ". Please retry. ");
                retry_attempt = 0;
                exponent_count--;
                return -3;
            }else{
                if (!arry_err_temp3[exponent_count]) {
                    arry_err_temp3[exponent_count] = answer_val;
                }
                exponent_count--;
                return -2;  
            }
        }
        
    }

    if (step_count == 4) {
        correct_answer = Math.pow(baseNumber, exponentsNumber);
        
        if (answer_val == correct_answer){
            arry_correctval[4] = correct_answer;
            answerDone();   //added
            displayTotalFlow();
            displayTotalFlow1();
            return correct_answer;  
        }               
    }
    if (answer_val > correct_answer) {
        if(retry_attempt > 1){
            alertModal("The correct answer is " + correct_answer + ". Please retry. ");
            retry_attempt = 0;
            return -3;
        }else{
            if (!arry_err_temp[step_count]) {
                arry_err_temp[step_count] = answer_val;
            }
            return -1;
        }
    }else{
        if(retry_attempt > 1){
            alertModal("The correct answer is " + correct_answer + ". Please retry. ");
            retry_attempt = 0;
            return -3;
        }else{
            if (!arry_err_temp[step_count]) {
                arry_err_temp[step_count] = answer_val;
            }
            return -2;  
        }
    }   
}



function checkAnswer(elem) {
    if (step_count * 1 == 3) {
        answer_val = elem.prop("value");
        setAnswered(answer_val);    //added
        return true;            
    }else{
        answer_val = parseInt(elem.prop("value"));
        if(isNaN(answer_val)) return false;
        elem.prop("value", answer_val);
    }           
}

function displayTotalFlow(){
    result_str = "";
    // result_str += "<b style='color:blue'>Answered Flow</b>";
    // result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += "<span>Solve this exponents:";
            result_str += "<label id='baseNumber_l' style='color:blue'>" + baseNumber + "</label>";
            result_str += "<sup id='exponents_sup' style='color:blue'>" + exponentsNumber + "</sup>";
        result_str += "</span>";
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 1:  Which is the base?</p>";
    if (arry_err_temp[1]) {
        result_str += "<p style='color:red;'>Error : "+ arry_err_temp[1] +"</p>";
    }
    result_str += "<span>";
        result_str += "<label> " + baseNumber + " </label>";
        result_str += "<sup>" + exponentsNumber + " </sup>";
        result_str += " : <label style='color:blue'>" + arry_correctval[1] + "</label>";
    result_str += "</span>";
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 2:  Which is the exponential?</p>";
    if (arry_err_temp[2]) {
        result_str += "<p style='color:red;'>Error : "+ arry_err_temp[2] +"</p>";
    }
    result_str += "<span>";
        result_str += "<label> " + baseNumber + " </label>";
        result_str += "<sup>" + exponentsNumber + " </sup>";
        result_str += " : <label style='color:blue'>" + arry_correctval[2] + "</label>";
    result_str += "</span>";
    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p> Step 3: Count how many times, the base is repeated.</p>";
    for (var i = 0; i <= exponentsNumber; i++) {
        if (arry_err_temp3[i]) {
            result_str += "<p style='color:red;'>Error : "+ arry_err_temp3[i] +"</p>";
        }
    }
    for (var i = 0; i < exponentsNumber; i++) {
        if(i > 0) result_str += "<label><b id='x_b'> x </b></label>";
        result_str += "<label>" + baseNumber + "</label>";
    }
    result_str += "<label style='color:blue'> = " + Math.pow(baseNumber, exponentsNumber) + "</label>";
    result_str += "<br>";
    result_str += "<label style='color:red;'> - Whenever you see an exponent, the number that is smaller and appear higher up is called the exponent or the power of.</label>";
    result_str += "<br>";
    result_str += "<label style='color:red;'> - The number itself is called the base.</label>";
    result_str += "<br>";
    result_str += "<label style='color:red;'> - The exponent of a base tells you how many times it should be multiplied by itself. </label>";
    result_str += "<br>";
    result_str += "<label style='color:red;'> - In this case the base is <b style='color:blue'>" + baseNumber + "</b> to the power of <b style='color:blue'> " + exponentsNumber + "</b> so you would multiple the number <b style='color:blue'> " + Math.pow(baseNumber, exponentsNumber) + "</b> times. </label>";
    result_str += "<br>";
    result_str += "<label style='color:red;'> - The way you write this out is as follows:</label>";
    total_result = 1;

    for (var i = 1; i < exponentsNumber; i++) {
        total_result = total_result * baseNumber;
        arry_total[i] = total_result;
        arry_total[i + 1] = total_result * baseNumber;
        if (i == 1) result_str += "<p style='color:blue;'>" + baseNumber +" = " + baseNumber + " --- " + i + "<sup>" + arr_orderNumber[i - 1] + "</sup></p>"
        result_str += "<p style='color:blue;'> " + arry_total[i] + " x "+ baseNumber +" = "+ arry_total[i * 1 + 1] + " --- " + (i+1) + "<sup>" + arr_orderNumber[i] + "</sup></p>";
    }

    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p>Step 4: Answer</p>";
    if (arry_err_temp[4]) {
        result_str += "<p style='color:red;'>Error : "+ arry_err_temp[4] +"</p>";
    }
    result_str += "<label>" + Math.pow(baseNumber, exponentsNumber) + "</label>";
    $("#correct_flow").html(result_str);
}

function displayTotalFlow1(){
    result_str = "";
    // result_str += "<b style='color:blue'>Correct Answered Flow</b>";
    // result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += "<span>Solve this exponents:";
            result_str += "<label id='baseNumber_l' style='color:blue'>" + baseNumber + "</label>";
            result_str += "<sup id='exponents_sup' style='color:blue'>" + exponentsNumber + "</sup>";
        result_str += "</span>";
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 1:  Which is the base?</p>";
    result_str += "<span>";
        result_str += "<label> " + baseNumber + " </label>";
        result_str += "<sup>" + exponentsNumber + " </sup>";
        result_str += " : <label style='color:blue'>" + arry_correctval[1] + "</label>";
    result_str += "</span>";
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 2:  Which is the exponential?</p>";
    result_str += "<span>";
        result_str += "<label> " + baseNumber + " </label>";
        result_str += "<sup>" + exponentsNumber + " </sup>";
        result_str += " : <label style='color:blue'>" + arry_correctval[2] + "</label>";
    result_str += "</span>";
    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p> Step 3: Count how many times, the base is repeated.</p>";
    for (var i = 0; i < exponentsNumber; i++) {
        if(i > 0) result_str += "<label><b id='x_b'> x </b></label>";
        result_str += "<label>" + baseNumber + "</label>";
    }
    result_str += "<label style='color:blue'> = " + Math.pow(baseNumber, exponentsNumber) + "</label>";
    result_str += "<br>";
    result_str += "<label style='color:red;'> - Whenever you see an exponent, the number that is smaller and appear higher up is called the exponent or the power of.</label>";
    result_str += "<br>";
    result_str += "<label style='color:red;'> - The number itself is called the base.</label>";
    result_str += "<br>";
    result_str += "<label style='color:red;'> - The exponent of a base tells you how many times it should be multiplied by itself. </label>";
    result_str += "<br>";
    result_str += "<label style='color:red;'> - In this case the base is <b style='color:blue'>" + baseNumber + "</b> to the power of <b style='color:blue'> " + exponentsNumber + "</b> so you would multiple the number <b style='color:blue'> " + Math.pow(baseNumber, exponentsNumber) + "</b> times. </label>";
    result_str += "<br>";
    result_str += "<label style='color:red;'> - The way you write this out is as follows:</label>";
    total_result = 1;

    for (var i = 1; i < exponentsNumber; i++) {
        total_result = total_result * baseNumber;
        arry_total[i] = total_result;
        arry_total[i + 1] = total_result * baseNumber;
        if (i == 1) result_str += "<p style='color:blue;'>" + baseNumber +" = " + baseNumber + " --- " + i + "<sup>" + arr_orderNumber[i - 1] + "</sup></p>"
        result_str += "<p style='color:blue;'> " + arry_total[i] + " x "+ baseNumber +" = "+ arry_total[i * 1 + 1] + " --- " + (i+1) + "<sup>" + arr_orderNumber[i] + "</sup></p>";
    }

    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p>Step 4: Answer</p>";
    result_str += "<label>" + Math.pow(baseNumber, exponentsNumber) + "</label>";
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