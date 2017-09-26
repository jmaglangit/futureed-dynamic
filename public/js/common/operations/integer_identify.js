var randomNumber = 0;
var randomdigitsNumber = 0;
var step_count = 0;
var countofrandomdigitsNumber = 0;
var real_number = "";
var str_randomNumber = "";

var arry_correctval = [];
var arry_total = [];
var arry_randomNumber = [];
var arry_temp = [];
var arry_correct_answer = [];
var number_words = ["One", "Ten", "Hundred", "Thousand", "Ten Thousand", "Hundred Thousand", "Million", "Ten Million", "Hundred Million"];
var number_words_small = ["one", "ten", "hundred", "thousand", "ten thousand", "hundred thousand", "million", "ten million", "hundred million"];
var arr = [];
var answered = []; //ADDED

// start ADDED functions
//getter and setter
function setRandomDigits(digit){
    randomDigits = digit;
}

function getDigitsNumber(){
    return randomdigitsNumber;
}

function getRandomNumber(){
    return str_randomNumber;
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

function closeModal(){
    $("#message_modal_dynamic").hide();
}

// end ADDED functions

function randomDigitsOnclick(){

    randomNumber = 0;
    randomdigitsNumber = 0;
    step_count = 0;
    countofrandomdigitsNumber = 0;
    real_number = "";
    str_randomNumber = "";

    arry_correctval = [];
    arry_total = [];
    arry_randomNumber = [];
    arry_temp = [];
    arry_correct_answer = [];
    
    arr = [];
    str_randomNumber = "";

    randomDigits = parseInt($(".randomDigits").prop("value"));
    if(isNaN(randomDigits)) {
        randomDigits = 4;
        $(".randomDigits").prop("value", randomDigits);
    }
    if (randomDigits > 10) {
        randomDigits = 9;
        $(".randomDigits").prop("value", randomDigits);
    }

    while(arr.length < randomDigits){
        var randomnumber = Math.floor(Math.random()*9)
        if(arr.indexOf(randomnumber) > -1) continue;
        arr[arr.length] = randomnumber;
    }
    // document.write(arr)
    if (arr[0] == 0) return randomDigitsOnclick();
    for (var i = 0; i < arr.length; i++) {
        str_randomNumber += arr[i];
    }
    real_number = str_randomNumber;
    
    str_randomNumber = str_randomNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");

    

    countofrandomdigitsNumber = Math.floor(Math.random() * randomDigits);
    randomdigitsNumber = str_randomNumber[countofrandomdigitsNumber];
    if (isNaN(randomdigitsNumber)) {
        randomdigitsNumber = str_randomNumber[countofrandomdigitsNumber - 1];
    }

    $("#tableNumber_div").html("");
    $("#position_div").html("");
    $("#map_table_div").html("");
    $("#answer").html("");
    $("#correct_flow").html("");
    $("#correct_flow_answer").html("");


    $("#randomNumber_b").html(str_randomNumber);
    $("#digits_b").html(randomdigitsNumber);
    $("#start_div").show();
}

function startBtnOnclick(){
    step_count++;
    retry_attempt = 0;
    $("#step_div").show();
    var result_str = "";
    if (step_count == 1) {
        result_str = "<div>";
        result_str += "<p>Step " + step_count +":  How many columns should the place value table have?</p>";
        result_str += "<input class='inputCheck'>";
        result_str += "</div>";
        $("#tableNumber_div").html(result_str);
    }

    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == "y"){
                // alert("Answer can't be alphabet !");
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(checkAnswer($(this)) == "z"){
                // alert('Input the valid expression');
                alertModal('That is incorrect. Answer can’t be blank. Please retry.');
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
            nextsetp();                 
        }
    }).focus();
}

function nextsetp(){
    
    retry_attempt = 0;
    step_count++;                       
    result_str = "";
    if (step_count == 2) {
        result_str = "<div>";
        result_str += "<p>Step " + step_count +":  Understand the place value of the digit.<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp What position is it from the right? <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp(Example: 1, 2, 3)</p>";
        result_str += "<input type='text' class='inputCheck'>";
        result_str += "</div>";
        $("#position_div").html(result_str);
    }

    if (step_count == 3) {
        result_str = "<div id='examPane'>";
        result_str += "<p> Step " + step_count + ": Map digit place to place value table below.</p>";
        result_str += "<table>";
            result_str += "<tr>";
            
                for (var i = arr.length-1; i >= 0; i--) {
                    if ((arry_correctval[1]-1) == i) {
                        result_str += "<th style='color:red;'>" + number_words[i] + "</th>";
                    }else{
                        result_str += "<th id='color_th'>" + number_words[i] + "</th>"; 
                    }
                    
                }
                
            result_str += "</tr>";
            result_str += "<tr>";
                for (var i = 0; i < arr.length; i++) {
                    if ((randomDigits - (arry_correctval[1])) == i) {
                        result_str += "<td style='color:red;'>" + real_number[i] + "</td>";
                    }else{
                        result_str += "<td>" + real_number[i] + "</td>";
                    }
                }
            result_str += "</tr>";
        result_str += "</table>";
        result_str += "</div>";
        
        $("#map_table_div").html(result_str);
        nextsetp();
    }

    if (step_count == 4) {
        result_str = "<div>";
        result_str += "<p> Step " + step_count + ": Please enter the place value. Example Hundred, Ten or One.  Write out the answer.   </p>";
        result_str += "<input type='text' class='inputCheck'>";
        result_str += "</div>";
        $("#answer").html(result_str);
        // displayTotalFlow();
    }

    $(".inputCheck").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == "y"){
                // alert("Answer can't be alphabet !");
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(checkAnswer($(this)) == "z"){
                // alert('Input the valid expression');
                alertModal('That is incorrect. Answer can’t be blank. Please retry.');
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            
            temp_answer = checkAnswerValidation($(this));
            if (step_count == 4) {
                if(temp_answer == -1){
                    // alert("Your answer is not accurate. Retry!");
                    alertModal("Your answer is either incorrect or must be in all capital letters. Please retry.");
                    $(this).prop("value", "").focus();
                    retry_attempt++;
                    return false;
                }
                if(temp_answer == -2){
                    // alert("Your answer is not accurate. Retry!");
                    alertModal("Your answer is either incorrect or must be in all capital letters. Please retry.");
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
        correct_answer = arr.length;
        if (answer_val == correct_answer){
            return correct_answer;  
        }
    }

    if (step_count == 2) {

        for (var i = 0; i < real_number.length; i++) {
            if (randomdigitsNumber == real_number[i]) {
                arry_correctval[1] = randomDigits - i;
            }
        }
        correct_answer = arry_correctval[1];
        
        if (answer_val == correct_answer){
            
            return correct_answer;  
        }               
    }

    if (step_count == 3) {
        
    }

    if (step_count == 4) {


        arry_correct_answer[1] = number_words[arry_correctval[1]-1];
        arry_correct_answer[2] = number_words_small[arry_correctval[1]-1];

        if (answer_val == arry_correct_answer[1]){
            arry_correctval[2] = arry_correct_answer[1];
            correct_answer = arry_correct_answer[1];
            answerDone();   //added
            displayTotalFlow();
            displayTotalFlow1();
            return correct_answer;  
        }

        if (answer_val == arry_correct_answer[2]){
            arry_correctval[2] = arry_correct_answer[2];
            correct_answer = arry_correct_answer[2];
            answerDone();   //added
            displayTotalFlow();
            displayTotalFlow1();
            return correct_answer;  
        }
                        
    }
    if(retry_attempt > 1){
        if (step_count == 4) {
            alertModal("The correct answer is " + arry_correct_answer[1] + " or "+ arry_correct_answer[2] +". Please retry. "); 
        }else{
            alertModal("The correct answer is " + correct_answer + ". Please retry. "); 
        }
        
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



function checkAnswer(elem) {
    answer_val = elem.prop("value");
    setAnswered(answer_val);    //added
    if (step_count == 4) {
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
    elem.prop("value", answer_val);     
}

function displayTotalFlow(){
    // console.log("1");
    result_str = "";
    // result_str += "<b style='color:blue'>Answered Flow</b>";
    // result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += '<label>What is the value of <b id="digits_b">'+ randomdigitsNumber +'</b> in this integer?  ';
            result_str += '<b id="randomNumber_b">' + str_randomNumber + '</b>';
        result_str += '</label>';
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 1: How many columns should the place value table have? </p>";
    if (arry_temp[1]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[1] + "</p>";    
    }
    
    result_str += "<br><label> - The table has <b style='color:red'>" + randomdigitsNumber + "</b> columns as the number has <b style='color:blue'>" + randomDigits + "</b> digits</label>";
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 2:   - Understand the place value of the digit.<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp - What position is it from the right? <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp (Example: 1, 2, 3)</p>";
    if (arry_temp[2]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[2] + "</p>";    
    }
    
    result_str += "<label> Number <b style='color:blue'>" + randomdigitsNumber + "</b> is <b style='color:red'>" + arry_correctval[1] + "</b> places from the right.</label>";
    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p> Step 3: Map digit place to place value table below by typing in value.<br> - Place the digits in value table</p>";
    result_str += "<table>";
            result_str += "<tr>";
            
                for (var i = arr.length-1; i >= 0; i--) {
                    if ((arry_correctval[1]-1) == i) {
                        result_str += "<th style='color:red;'>" + number_words[i] + "</th>";
                    }else{
                        result_str += "<th id='color_th'>" + number_words[i] + "</th>"; 
                    }
                    
                }
                
            result_str += "</tr>";
            result_str += "<tr>";
                for (var i = 0; i < arr.length; i++) {
                    if ((randomDigits - (arry_correctval[1])) == i) {
                        result_str += "<td style='color:red;'>" + real_number[i] + "</td>";
                    }else{
                        result_str += "<td>" + real_number[i] + "</td>";
                    }
                    
                }
            result_str += "</tr>";
        result_str += "</table>";

    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p>Step 4: Please enter the place value. Example Hundred, Ten or One. Write out the answer.</p>";
    if (arry_temp[4]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[4] + "</p>";    
    }
    
    result_str += "<label> - Answer: " + arry_correctval[2] + "</label>";
    $("#correct_flow").html(result_str);

}

function displayTotalFlow1(){
    // console.log("2");
    result_str = "";
    // result_str += "<b style='color:blue'>Correct Answered Flow</b>";
    // result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += '<label>What is the value of <b id="digits_b">'+ randomdigitsNumber +'</b> in this integer?  ';
            result_str += '<b id="randomNumber_b">' + str_randomNumber + '</b>';
        result_str += '</label>';
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 1: How many columns should the place value table have? </p>";
    result_str += "<br><label> - The table has <b style='color:red'>" + randomdigitsNumber + "</b> columns as the number has <b style='color:blue'>" + randomDigits + "</b> digits</label>";
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 2:   - Understand the place value of the digit.<br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp - What position is it from the right? <br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp (Example: 1, 2, 3)</p>";
    result_str += "<label> Number <b style='color:blue'>" + randomdigitsNumber + "</b> is <b style='color:red'>" + arry_correctval[1] + "</b> places from the right.</label>";
    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p> Step 3: Map digit place to place value table below by typing in value.<br> - Place the digits in value table</p>";
    result_str += "<table>";
            result_str += "<tr>";
            
                for (var i = arr.length-1; i >= 0; i--) {
                    if ((arry_correctval[1]-1) == i) {
                        result_str += "<th style='color:red;'>" + number_words[i] + "</th>";
                    }else{
                        result_str += "<th id='color_th'>" + number_words[i] + "</th>"; 
                    }
                    
                }
                
            result_str += "</tr>";
            result_str += "<tr>";
                for (var i = 0; i < arr.length; i++) {
                    if ((randomDigits - (arry_correctval[1])) == i) {
                        result_str += "<td style='color:red;'>" + real_number[i] + "</td>";
                    }else{
                        result_str += "<td>" + real_number[i] + "</td>";
                    }
                    
                }
            result_str += "</tr>";
        result_str += "</table>";

    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p>Step 4: Please enter the place value. Example Hundred, Ten or One. Write out the answer.</p>";
    result_str += "<label> - Answer: " + arry_correctval[2] + "</label>";
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