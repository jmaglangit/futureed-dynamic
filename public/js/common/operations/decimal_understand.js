/**
 *  Code from client
 * 20170823.
 */

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
var decimal_ranIndex = 0;
var decimalNumber = 0;
var step2_count = 0;
var step4_count = 0;

var step2Flag = false;

var arry_correctval = [];
var real_string = "";
var arry_total = [];
var arry_randomNumber = [];
var arry_temp = [];
var arry_step4_temp = [];
var arry2_temp = [];
var arry_checkIdx = [];
var number_words = ["One", "Ten", "Hundred", "Thousand", "Ten Thousand", "Hundred Thousand", "Million", "Ten Million", "Hundred Million"];
var decimal_words = [ "Tenths", "Hundredths","Thousandths", "Ten Thousandths",  "Hundred Thousandths", "Millionths", "Ten Millionths", "Hundred Millionths"];

var ths_words = ["first", "second", "third", "fourth","fifth", "sixth", "seventh", "eighth", "nineth", "tenth"];

var number_words1 = ["one", "ten", "hundred", "thousand", "ten thousand", "hundred thousand", "tillion", "ten million", "hundred million"];
var decimal_words1 = [ "tenths", "hundredths","thousandths", "ten thousandths",  "hundred thousandths", "millionths", "ten millionths", "hundred millionths"];
var answered = []; //ADDED

// start ADDED functions
//getter and setter

function getDigitsNumber(){
    return decimalNumber;
}

function getFirstDecimalDigit(){
    return str_interger;
}

function getSecondDecimalDigit(){
    return underl;
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
}

function closeModal() {
    dynamicUnBlock();
    $("#message_modal_dynamic").modal('hide');
}

// end ADDED functions


function randomDigitsOnclick(){
    arr = [];
    str_randomNumber = "";
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
    decimal_ranIndex = 0;
    decimalNumber = 0;
    step2_count = 0;
    step4_count = 0;

    step2Flag = false;

    arry_correctval = [];
    real_string = "";
    arry_total = [];
    arry_randomNumber = [];
    arry_temp = [];
    arry_step4_temp = [];
    arry2_temp = [];
    arry_checkIdx = [];

    randomDigits1 = parseInt($(".randomDigits1").prop("value"));
    min = 0.05;
    randomDigits2 = parseInt($(".randomDigits2").prop("value"));

    if(isNaN(randomDigits1)) {
        randomDigits1 = 50;
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


    while(arr.length < randomDigits2){
        var randomnumber = Math.floor(Math.random()*9);
        if(arr.indexOf(randomnumber) > -1) continue;
        arr[arr.length] = randomnumber;
    }
    // document.write(arr)
    if (arr[0] == 0) return randomDigitsOnclick();
    for (var i = 0; i < arr.length; i++) {
        str_randomNumber += arr[i];
    }
    real_number = str_randomNumber;
    
    str_interger = Math.floor(Math.random()*randomDigits1);
    str_decimal = "." + real_number;
    decimal_ranIndex = Math.round(Math.random() * (str_decimal.length));
    if (decimal_ranIndex == 0) decimal_ranIndex = 1;
    if (decimal_ranIndex == str_decimal.length) decimal_ranIndex = 1;
    
    decimalNumber = str_decimal[decimal_ranIndex];

    real_string = str_interger + str_decimal;
    po1 = real_string.indexOf(".");
        underl = "";
    for (var i = 0; i < str_decimal.length; i++) {
        if (i == decimal_ranIndex) {
            underl += "<u style='color:red'>" + str_decimal[i] + "</u>";
        }else{
            underl += str_decimal[i];
        }
    }
    $("#step_div").html('<div id="step_div" style="width: 700px; float: left;"><br><div id="tableNumber_div"></div><div id="lastDiv"></div></div>');
    $("#correct_flow").html("");
    $("#correct_flow_answer").html("");
    
    $("#str_interger_b").html(str_interger);
    $("#str_decimal_b").html(underl);
    $("#randomDigits_b").html(decimalNumber);
    $("#start_div").show();

}

function startBtnOnclick(){
    step_count++;
    retry_attempt = 0;
    $("#step_div").show();
    var result_str = "";
    if (step_count == 1) {
        result_str = "<div>";
        result_str += "<p>Step " + step_count +":  Which digit are you being asked about? </p>";
        result_str += "<input class='inputCheck'>";
        result_str += "</div>";
        $("#tableNumber_div").html(result_str);
    }

    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer can’t be blank. Please retry.");
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
    result_str = "";
    step_count++;
    result_str += "<table class='border_table'>";
        result_str += "<tr>";
        
            for (var i = 0; i < real_string.length; i++) {
                if (i == po1) {
                    result_str += "<th class='border_table' id='color_th'>Decimal</th>";
                }else if (i > po1) {
                    result_str += "<th class='border_table' id='color_th'>" + decimal_words[i-po1-1] + "</th>"; 
                }else if (i < po1) {
                    result_str += "<th class='border_table' id='color_th'>" + number_words[po1 - i - 1] + "</th>";  
                }
                
            }
            
        result_str += "</tr>";
        result_str += "<tr>";
            for (var i = 0; i < real_string.length; i++) {
                if (i == po1) {
                    result_str += "<td class='border_table'>.</td>";    
                }else{
                    result_str += "<td class='border_table'><input type=text style='width:91px;' placeholder='answer' class='checkIndexs'></td>";
                }
                
                
            }
        result_str += "</tr>";
    result_str += "</table>";
    
    if (step_count == 2) {
        $("<p>Step " + step_count + " : Fill in the place table.</p>" + result_str).insertBefore("#lastDiv");
        return middleFunc();    
    }
        
    if (step_count == 3) {
        $("<p>Step " + step_count + " :  What is the value of the digit in Step 1?  Example Ones , Tenths. </p><input class='inputCheck'>").insertBefore("#lastDiv");
    }

    if (step_count == 4) {
        $("<p>Step " + step_count + " :  Convert into fraction form.</p>Digit Value <input class='inputCheck1'> x Place Value <input class='inputCheck2'>").insertBefore("#lastDiv");
        return step4Func();
    }

    if (step_count == 5) {
        $("<p>Step " + step_count + " : Answer.</p><input class='inputCheck'>").insertBefore("#lastDiv");
    }
    if (step_count > 5) {
        answerDone();   //added
        displayTotalFlow();
        displayTotalFlow1();
    }
    $(".inputCheck").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer can’t be blank. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            
            temp_answer = checkAnswerValidation($(this));
            if (step_count == 3) {
                if(temp_answer == -1){
                    alertModal('You forgot the word "number".');
                    $(this).prop("value", "").focus();
                    retry_attempt++;
                    return false;
                }
                if(temp_answer == -2){
                    alertModal('You forgot the word "number".');
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
            }else {
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

function step4Func() {
    $(".inputCheck1").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer can’t be blank. Please retry.");
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
            $(".inputCheck2").unbind("keydown").keydown(function(event){
                if(event.keyCode == 13){
                    if(checkAnswer($(this)) == false){
                        alertModal("That is incorrect. Answer can’t be blank. Please retry.");
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

function middleFunc() {
    // console.log("1");
    $(".checkIndexs").eq(0).focus();
    checkIndex = 0;
    $(".checkIndexs").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer can’t be blank. Please retry.");
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
            if (checkIndex == real_string.length) {
                nextsetp();
            }
            $(this).attr("readonly", true);
            if (checkIndex > po1) {
                $(".checkIndexs").eq(checkIndex-1).focus();
            }else{
                $(".checkIndexs").eq(checkIndex).focus();
            }                   
        }   
    });
}

function checkAnswerValidation(elem) {
    
    answer_val = elem.prop("value");

    if (step_count == 1) {
        correct_answer = str_decimal[decimal_ranIndex];
    
        if (answer_val == correct_answer){
            return correct_answer;  
        }                   
    }
    if (step_count == 2) {
        if (real_string[checkIndex] == ".") {
            checkIndex++;
            if (!arry_checkIdx[checkIndex]) {
                
                arry_checkIdx[checkIndex] = answer_val;
            }
            $(".checkIndexs").eq(checkIndex).focus();
        }
        correct_answer = real_string[checkIndex] * 1;


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

    if (step_count == 3) {
        correct_answer = decimal_words1[decimal_ranIndex - 1];
    
        if (answer_val.toLowerCase() == correct_answer){
            arry_correctval[1] = answer_val;
            return correct_answer;  
        }                   
    }

    if (step_count == 4) {
        
        
        step4_count++;
        if (step4_count == 1) {
            correct_answer = str_decimal[decimal_ranIndex];
            if (answer_val == correct_answer){
                return correct_answer;  
            }
        }
        if (step4_count == 2) {
            correct_answer = "1/" + digits(decimal_ranIndex);
            if (answer_val == correct_answer){
                return correct_answer;  
            }
        }
        if(retry_attempt > 1){
            alertModal("The correct answer is " + correct_answer + ". Please retry. ");
            retry_attempt = 0;
            step4_count--;
            return -3;
        }

        
        if (answer_val > correct_answer) {
            
            if (!arry_step4_temp[step4_count]) {
                step4_count--;
                arry_temp[step_count] = answer_val;
            }
            return -1;
        }else {

            if (!arry_step4_temp[step4_count]) {
                step4_count--;
                arry_temp[step_count] = answer_val;
            }
            return -2;          
        }
                            
    }
    if (step_count == 5) {
        correct_answer = str_decimal[decimal_ranIndex] + "/" + digits(decimal_ranIndex);
    
        if (answer_val.toLowerCase() == correct_answer){
            return correct_answer;  
        }                   
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
    result_str += "<b style='color:blue'>Answered Flow</b>";
    result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += '<label>What is the decimal place of ' + decimalNumber + ' in the number ' + str_interger + underl + ' and how would you represent it in a fraction form?</label>';
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 1: Which digit are you being asked about?  <font color=blue>" + decimalNumber + "</font> </p>";
        
        if (arry_temp[1]) {
            result_str += "<p style='color:red;'> Error : " + arry_temp[1] + "</p>";
        }
        
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 2:  Fill in the place table.</p>";
        for (var checkIndex in arry_checkIdx){
            // console.log(" checkIndex = " + checkIndex + "---------" + arry_checkIdx[checkIndex]);
            if (arry_checkIdx.hasOwnProperty(checkIndex)) {
                result_str += "<p style='color:red;'> Error : " + arry_checkIdx[checkIndex] + "</p>";
            }
        }
        
        result_str += "<table class='border_table'>";
            result_str += "<tr>";
            
                for (var i = 0; i < real_string.length; i++) {
                    if (i == po1) {
                        result_str += "<th class='border_table' id='color_th'>Decimal</th>";
                    }else if (i > po1) {
                        result_str += "<th class='border_table' id='color_th'>" + decimal_words[i-po1-1] + "</th>"; 
                    }else if (i < po1) {
                        result_str += "<th class='border_table' id='color_th'>" + number_words[po1 - i - 1] + "</th>";  
                    }
                    
                }
                
            result_str += "</tr>";
            result_str += "<tr>";
                for (var i = 0; i < real_string.length; i++) {
                    if (i == po1) {
                        result_str += "<td class='border_table'>.</td>";    
                    }else{
                        result_str += "<td class='border_table'>" + real_string[i] + "</td>";
                    }
                    
                    
                }
            result_str += "</tr>";
        result_str += "</table>";
        result_str += "<p style='color:blue'> - Using the place value table, we find that the digit <b>"+ decimalNumber +"</b> is in the <b>" + decimal_words[decimal_ranIndex-1] + "</b> place</p>";
        
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 3: What is the decimal value of the digit?  Example, Ones, Tenths.<br>  <font color=blue>" + arry_correctval[1] + "</font> </p>";
        if (arry_temp[3]) {
            result_str += "<p style='color:red;'> Error : " + arry_temp[3] + "</p>";
        }
    result_str += "</div>";
    result_str += "<div>";

        result_str += "<p>Step 4: Convert into fraction form.<br>Digit Value  <font color=blue>" + str_decimal[decimal_ranIndex] + "</font> x Place Value <font color=blue>"+"1/"+ digits(decimal_ranIndex) + "</font> </p>";
        if (arry_step4_temp[1]) {
            result_str += "<p style='color:red;'> Error : " + arry_step4_temp[1] + "</p>";
        }
        if (arry_step4_temp[2]) {
            result_str += "<p style='color:red;'> Error : " + arry_step4_temp[2] + "</p>";
        }
        result_str += "<p style='color:blue'> - Now convert the digit into fraction form.  Remember that </p>";
        for (var i = 0; i < decimal_ranIndex; i++) {
            if (decimal_ranIndex == 1) {
                result_str += '<table style="color:red; border: 0px solid black;">';
                    result_str += '<tr>';
                        
                        result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext">' + decimal_words[i] + '</td>';
                        result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"> = </td>';
                        result_str += '<td align="center" valign="middle" class="verybigtext"> 1 </td>';
                    result_str += '</tr>';
                    result_str += '<tr>';
                        result_str += '<td bgcolor="#000000" height="2"></td>';
                    result_str += '</tr>';
                    result_str += '<tr>';
                        result_str += '<td align="center" valign="middle" class="verybigtext">' + digits(i+1) + '</td>';
                        
                    result_str += '</tr>';              
                result_str += '</table>';
            }else{
                result_str += '<table style="color:red; border: 0px solid black;">';
                    result_str += '<tr>';
                        
                        result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext">' + decimal_words[i] + '</td>';
                        result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"> = </td>';
                        result_str += '<td align="center" valign="middle" class="verybigtext"> 1 </td>';
                    result_str += '</tr>';
                    result_str += '<tr>';
                        result_str += '<td bgcolor="#000000" height="2"></td>';
                    result_str += '</tr>';
                    result_str += '<tr>';
                        result_str += '<td align="center" valign="middle" class="verybigtext">' + digits(i+1) + '</td>';
                        
                    result_str += '</tr>';              
                result_str += '</table>';
            }

            if (i == decimal_ranIndex-1) {
                result_str += '<table style="color:red; border: 0px solid black;">';
                    result_str += '<tr>';
                        
                        result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext">Hence '+decimalNumber+' ' + decimal_words[i] + ' equals '+ decimalNumber +' x </td>';
                        result_str += '<td align="center" valign="middle" class="verybigtext"> 1 </td>';
                        result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"> = </td>';
                        result_str += '<td align="center" valign="middle" class="verybigtext"> '+decimalNumber+' </td>';
                    result_str += '</tr>';
                    result_str += '<tr>';
                        result_str += '<td bgcolor="#000000" height="2"></td>';
                        result_str += '<td bgcolor="#000000" height="2"></td>';
                    result_str += '</tr>';
                    result_str += '<tr>';
                        result_str += '<td align="center" valign="middle" class="verybigtext">' + digits(i+1) + '</td>';
                        result_str += '<td align="center" valign="middle" class="verybigtext">' + digits(i+1) + '</td>';
                        
                    result_str += '</tr>';              
                result_str += '</table>';
            }

        }
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 5: Answer. <font color=blue>" + str_decimal[decimal_ranIndex] + "/" + digits(decimal_ranIndex); + "</font> </p>";

        if (arry_temp[5]) {
            result_str += "<br><font color=red> Error : " + arry_temp[5] + "</font>";
        }
    result_str += "</div>";
        
    $("#correct_flow").html(result_str);

}

function displayTotalFlow1(){
    result_str = "";
    result_str += "<b style='color:blue'>Correct Answered Flow</b>";
    result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += '<label>What is the decimal place of ' + decimalNumber + ' in the number ' + str_interger + underl + ' and how would you represent it in a fraction form?</label>';
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 1: Which digit are you being asked about?  <font color=blue>" + decimalNumber + "</font> </p>";
        
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 2:  Fill in the place table.</p>";
        
        result_str += "<table class='border_table'>";
            result_str += "<tr>";
            
                for (var i = 0; i < real_string.length; i++) {
                    if (i == po1) {
                        result_str += "<th class='border_table' id='color_th'>Decimal</th>";
                    }else if (i > po1) {
                        result_str += "<th class='border_table' id='color_th'>" + decimal_words[i-po1-1] + "</th>"; 
                    }else if (i < po1) {
                        result_str += "<th class='border_table' id='color_th'>" + number_words[po1 - i - 1] + "</th>";  
                    }
                    
                }
                
            result_str += "</tr>";
            result_str += "<tr>";
                for (var i = 0; i < real_string.length; i++) {
                    if (i == po1) {
                        result_str += "<td class='border_table'>.</td>";    
                    }else{
                        result_str += "<td class='border_table'>" + real_string[i] + "</td>";
                    }
                    
                    
                }
            result_str += "</tr>";
        result_str += "</table>";
        result_str += "<p style='color:blue'> - Using the place value table, we find that the digit <b>"+ decimalNumber +"</b> is in the <b>" + decimal_words[decimal_ranIndex-1] + "</b> place</p>";
        
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 3: What is the decimal value of the digit?  Example, Ones, Tenths.<br>  <font color=blue>" + decimal_words[decimal_ranIndex - 1] + "</font> </p>";
    
    result_str += "</div>";
    result_str += "<div>";

        result_str += "<p>Step 4: Convert into fraction form.<br>Digit Value  <font color=blue>" + str_decimal[decimal_ranIndex] + "</font> x Place Value <font color=blue>"+"1/"+ digits(decimal_ranIndex) + "</font> </p>";

        result_str += "<p style='color:blue'> - Now convert the digit into fraction form.  Remember that </p>";
        for (var i = 0; i < decimal_ranIndex; i++) {
            if (decimal_ranIndex == 1) {
                result_str += '<table style="color:red; border: 0px solid black;">';
                    result_str += '<tr>';
                        
                        result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext">' + decimal_words[i] + '</td>';
                        result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"> = </td>';
                        result_str += '<td align="center" valign="middle" class="verybigtext"> 1 </td>';
                    result_str += '</tr>';
                    result_str += '<tr>';
                        result_str += '<td bgcolor="#000000" height="2"></td>';
                    result_str += '</tr>';
                    result_str += '<tr>';
                        result_str += '<td align="center" valign="middle" class="verybigtext">' + digits(i+1) + '</td>';
                        
                    result_str += '</tr>';              
                result_str += '</table>';
            }else{
                result_str += '<table style="color:red; border: 0px solid black;">';
                    result_str += '<tr>';
                        
                        result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext">' + decimal_words[i] + '</td>';
                        result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"> = </td>';
                        result_str += '<td align="center" valign="middle" class="verybigtext"> 1 </td>';
                    result_str += '</tr>';
                    result_str += '<tr>';
                        result_str += '<td bgcolor="#000000" height="2"></td>';
                    result_str += '</tr>';
                    result_str += '<tr>';
                        result_str += '<td align="center" valign="middle" class="verybigtext">' + digits(i+1) + '</td>';
                        
                    result_str += '</tr>';              
                result_str += '</table>';
            }

            if (i == decimal_ranIndex-1) {
                result_str += '<table style="color:red; border: 0px solid black;">';
                    result_str += '<tr>';
                        
                        result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext">Hence '+decimalNumber+' ' + decimal_words[i] + ' equals '+ decimalNumber +' x </td>';
                        result_str += '<td align="center" valign="middle" class="verybigtext"> 1 </td>';
                        result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"> = </td>';
                        result_str += '<td align="center" valign="middle" class="verybigtext"> '+decimalNumber+' </td>';
                    result_str += '</tr>';
                    result_str += '<tr>';
                        result_str += '<td bgcolor="#000000" height="2"></td>';
                        result_str += '<td bgcolor="#000000" height="2"></td>';
                    result_str += '</tr>';
                    result_str += '<tr>';
                        result_str += '<td align="center" valign="middle" class="verybigtext">' + digits(i+1) + '</td>';
                        result_str += '<td align="center" valign="middle" class="verybigtext">' + digits(i+1) + '</td>';
                        
                    result_str += '</tr>';              
                result_str += '</table>';
            }

        }
    result_str += "</div>";
    result_str += "<div>";

        result_str += "<p>Step 5: Answer.<br>  <font color=blue>" + str_decimal[decimal_ranIndex] + "/" + digits(decimal_ranIndex); + "</font> </p>";
    result_str += "</div>";
    $("#correct_flow_answer").html(result_str);

}
