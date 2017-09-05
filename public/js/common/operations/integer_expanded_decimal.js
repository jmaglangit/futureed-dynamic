
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
var str_compare = "";

var arry_correctval = [];
var arry_total = [];
var arry_randomNumber = [];
var arry_temp = [];
var arry_checkIdx = [];
var number_words = ["One", "Ten", "Hundred", "Thousand", "Ten Thousand", "Hundred Thousand", "Million", "Ten Million", "Hundred Million"];
var decimal_words = [ "Tenths", "Hundredths","Thousandths", "Ten Thousandths",  "Hundred Thousandths", "Millionths", "Ten Millionths", "Hundred Millionths"];

var ths_words = ["first", "second", "third", "fourth","fifth", "sixth", "seventh", "eighth", "nineth", "tenth"];
var answered = []; //ADDED


// start ADDED functions

//getter and setter

function getfirstNumber(){
    return firstNumber;
}

function getsecondNumber(){
    return secondNumber;
}

function getRealNumber(){
    return real_number;
}

function getfirsDigitsTonumber_words(){
    return number_words[firsDigitsTonumber_words];
}

function getsecondDigitsToNumber_words(){
    return number_words[secondDigitsToNumber_words];
}

function setfirstNumber(data){
    firstNumber = data;
}

function setsecondNumber(data){
    secondNumber = data;
}

function setfirsDigitsTonumber_words(data){
    firsDigitsTonumber_words = data;
}

function setsecondDigitsToNumber_words(data){
    secondDigitsToNumber_words = data;
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

    randomNumber = (Math.random() * (randomDigits1 - min) + min).toFixed(randomDigits2);
    real_number = randomNumber + "";

    po1 = randomNumber.indexOf(".");
    str_interger = randomNumber.substring(0, po1);
    str_decimal = randomNumber.substring(po1+1);
    console.log(str_interger + "---" + str_decimal);


    max_digit = real_number.length + 3;
    $("#randomNumber_b").html(real_number);
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
            if(checkAnswer($(this)) == false){
                alertModal("Answer can't be alphabet!");
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
                alertModal("opps not enough, your answer needs to be larger.");
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
    console.log("1");
    $(".checkIndexs").eq(0).focus();
    checkIndex = 0;
    $(".checkIndexs").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("Answer can't be alphabet!");
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
                alertModal("opps not enough, your answer needs to be larger.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(temp_answer == -3){

                $(this).prop("value", "").focus();
                return false;
            }
            if (checkIndex == real_number.length) {
                answerDone();
                displayTotalFlow();
                displayTotalFlow1();
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


function checkTotal() {
    result_str2 = "";
    result_str3 = "";
    for (var i = 0; i < str_interger.length; i++) {
        result_str2 += digits(str_interger.length - i- 1) + " x ";
        result_str2 += "<input type=text style='width:20px;' placeholder='answer' class='checkIndexs'> + ";
    }

    for (var i = 0; i < str_decimal.length; i++) {
        result_str3 += "1/" + digits(i+1) + " x ";
        if (i == str_decimal.length - 1) {
            result_str3 += "<input type=text style='width:20px;' placeholder='answer' class='checkIndexs'>";
        }else{
            result_str3 += "<input type=text style='width:20px;' placeholder='answer' class='checkIndexs'> + ";
        }
    }
    result_str2 = result_str2 + result_str3;

    $("<p>Step " + step_count + " : Now write out the answer.</p>" + result_str2).insertBefore("#lastDiv");
    return middleFunc();
}

function nextsetp(){

    retry_attempt = 0;
    result_str = "";
    step_count++;
    if(step_count >= max_digit) {
        checkTotal();
        return;
    }
    result_str = "";

    result_str += "<table>";
    result_str += "<tr>";

    for (var i = 0; i < real_number.length; i++) {
        if (i == po1) {
            result_str += "<th id='color_th'>Decimal</th>";
        }else if (i > po1) {
            result_str += "<th id='color_th'>" + decimal_words[i-po1-1] + "</th>";
        }else if (i < po1) {
            result_str += "<th id='color_th'>" + number_words[po1 - i - 1] + "</th>";
        }

    }

    result_str += "</tr>";
    result_str += "<tr>";
    for (var i = 0; i < real_number.length; i++) {
        result_str += "<td>" + real_number[i] + "</td>";

    }
    result_str += "</tr>";
    result_str += "</table>";
    if (step_count == 2) {
        $("<p>Step " + step_count + " : How many places after the decimal?</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
    }

    if (step_count == 3) {
        $("<p>Step " + step_count + " : Complete the table.</p>" + result_str).insertBefore("#lastDiv");
        return nextsetp();
    }

    if (step_count > 3) {
        if ((step_count - 3) <= po1) {
            $("<p>Step " + step_count + " : What is the value of the " + number_words[step_count -4] + " ? </p>" + digits(step_count - 4) + " x <input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
        }else if ((step_count - 3) > po1) {
            str_fraction = "";
            str_fraction += "<table style='float:left;'>";
            str_fraction += '<tr><td align="center">1</td></tr>';
            str_fraction += '<tr><td bgcolor="#000000" height="2"></td></tr>';
            str_fraction += '<tr><td align="center">' + digits(step_count-4-str_interger.length) + '</td></tr>';
            str_fraction += "</table>";
            $("<p>Step " + step_count + " : What is the value of the " + decimal_words[step_count -3 -str_interger.length - 1] + " ? </p>1/" + digits(step_count-3-str_interger.length) + " x <input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
        }

    }


    $(".inputCheck").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("Answer can't be alphabet!");
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
                alertModal("opps not enough, your answer needs to be larger.");
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

function checkAnswerValidation(elem) {

    answer_val = elem.prop("value");

    if (step_count == 1) {
        correct_answer = real_number.length - 1;

        if (answer_val == correct_answer){
            return correct_answer;
        }
    }
    if (step_count == 2) {
        correct_answer = randomDigits2;

        if (answer_val == correct_answer){
            return correct_answer;
        }
    }
    if(retry_attempt > 1){
        alertModal("Correct Answer is " + correct_answer + ". Retry! ");
        retry_attempt = 0;
        return -3;
    }
    if ((step_count - 3) <= po1) {
        correct_answer = str_interger[po1 - (step_count - 3)] * 1;
    }else if ((step_count-3) > po1) {
        correct_answer = str_decimal[(step_count - 3) - 1 - str_interger.length];
    }

    if (step_count >= max_digit) {


        if (real_number[checkIndex] == ".") {
            checkIndex++;
            $(".checkIndexs").eq(checkIndex).focus();
        }
        correct_answer = real_number[checkIndex] * 1;
        if (answer_val == correct_answer) {
            checkIndex++;
            return correct_answer;
        }
    }

    if (answer_val == correct_answer) {
        return correct_answer;
    }

    if (answer_val > correct_answer) {
        if (!arry_temp[step_count]) {
            arry_temp[step_count] = answer_val;
        }
        if (!arry_checkIdx[checkIndex]) {
            arry_checkIdx[checkIndex] = answer_val;
        }
        return -1;
    }else {
        if (!arry_temp[step_count]) {
            arry_temp[step_count] = answer_val;
        }
        if (!arry_checkIdx[checkIndex]) {
            arry_checkIdx[checkIndex] = answer_val;
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
        if(isNaN(answer_val)) return false;
        elem.prop("value", answer_val);
    }
}

function displayTotalFlow(){
    result_str = "";
    result_str += "<b style='color:blue'>Answered Flow</b>";
    result_str += "<br><br>";
    result_str += "<div id='start_div'>";
    result_str += '<label>Write out this number in extended form.  <br>Example:One hundred and Sixty-Two: ';
    result_str += '<b id="randomNumber_b">' + real_number + '</b>';
    result_str += '</label>';
    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 1: How many columns should the place value table have? <b> " + (real_number.length-1) + "</b></p>";
    if (arry_temp[1]) {
        result_str += "<p style='color:#17418d'> Error : " + arry_temp[1] + "</p>";
    }

    result_str += "<p style='color:red'> The number has a total of " + (real_number.length-1) + " digits, so it should have columns, this means there are " + (real_number.length-1) + " place values</p>";

    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 2: How many places after the decimal? <b> " + randomDigits2 + "</b></p>";
    if (arry_temp[2]) {
        result_str += "<p style='color:#17418d'> Error : " + arry_temp[2] + "</p>";
    }
    result_str += "<p style='color:red'> There are " + randomDigits2 + " digits after the decimal point.</p>";


    result_str += "</div>";

    stc = "";
    stc += "<table>";
    stc += "<tr>";

    for (var i = 0; i < real_number.length; i++) {
        if (i == po1) {
            stc += "<th id='color_th'>Decimal</th>";
        }else if (i > po1) {
            stc += "<th id='color_th'>" + decimal_words[i-po1-1] + "</th>";
        }else if (i < po1) {
            stc += "<th id='color_th'>" + number_words[po1 - i - 1] + "</th>";
        }

    }

    stc += "</tr>";
    stc += "<tr>";
    for (var i = 0; i < real_number.length; i++) {
        stc += "<td>" + real_number[i] + "</td>";

    }
    stc += "</tr>";
    stc += "</table>";

    result_str += "<div>";

    result_str += "<p>Step 3:  Complete the table.</p>" + stc;

    result_str += "</div>";

    for (var j = 0; j < real_number.length-1; j++) {


        if (((j + 4) - 3) <= po1) {
            result_str += "<p>Step " + (j + 4) + " : What is the value of the " + number_words[(j + 4) -4] + " ? <font color=blue>" + digits((j + 4) - 4) + " x " + str_interger[po1 - ((j + 4) - 3)] * 1+ "</font></p>" ;
        }else if (((j + 4) - 3) > po1) {
            result_str += "<p>Step " + (j + 4) + " : What is the value of the " + decimal_words[(j + 4) -3 -str_interger.length - 1]  + " ?<font color=blue> 1/" + digits((j + 4)-3-str_interger.length) + " x " + str_decimal[((j + 4) - 3) - 1 - str_interger.length] + "</font></p>";
        }
        if (arry_temp[j + 4]) {
            result_str += "<p style='color:#17418d'> Error : " + arry_temp[j + 4] + "</p>";
        }

        result_str += "<table>";
        result_str += "<tr>";

        for (var i = 0; i < real_number.length; i++) {
            if (i == po1) {
                result_str += "<th id='color_th'>Decimal</th>";
            } else {
                if(i > po1) {
                    if(i == j + 1)
                        result_str += "<th id='color_th'><font color=red>" + decimal_words[i-po1-1] + "</font></th>";
                    else
                        result_str += "<th id='color_th'>" + decimal_words[i-po1-1] + "</th>";
                } else {
                    if(i + j + 1== po1)
                        result_str += "<th id='color_th'><font color=red>" + number_words[po1 - i - 1] + "</font></th>";
                    else
                        result_str += "<th id='color_th'>" + number_words[po1 - i - 1] + "</th>";
                }
            }
        }

        result_str += "</tr>";
        result_str += "<tr>";
        for (var i = 0; i < real_number.length; i++) {
            if (i == po1) {
                result_str += "<td>.</td>";
            } else {
                if(i > po1) {
                    if(i == j + 1)
                        result_str += "<td id='color_th'><font color=red>" + real_number[i] + "</font></td>";
                    else
                        result_str += "<td id='color_th'>" + real_number[i] + "</td>";
                } else {
                    if(i + j + 1== po1)
                        result_str += "<td id='color_th'><font color=red>" + real_number[i] + "</font></td>";
                    else
                        result_str += "<td id='color_th'>" + real_number[i] + "</td>";
                }
            }
        }
        result_str += "</tr>";
        result_str += "</table>";
        if(j >= po1) {
            result_str += "<p style='color:red'>The " + ths_words[j-po1] + " value after the decimal point is called the " + decimal_words[j - po1] + " place. <br>It can also be represented as 1/" + digits(j + 1 -po1) + ".</p>";
            result_str += "<p>We have the value " + str_decimal[j-po1] + " after the decimal point.</p>";
            result_str += "<p> This means that 1/" + digits(j + 1 -po1) + "x" + str_decimal[j-po1] + " = " + str_decimal[j-po1] + "/" + digits(j + 1 -po1) + "</p>";
        } else {
            result_str += "<p>Looking at the table there is a " + str_interger[po1 - j - 1] + " in the " + number_words[ j + 2 - po1 ] + " place.</p>";
        }
    }
    strs = "";
    for (var i = real_number.length-1; i >= 0; i--) {
        strs += "<label style='color:blue;'>" + real_number[real_number.length-i-1] + "</label>";
        if (i == 0) {
            strs += "<span>" + number_words[i] + "</span>";
        }else{
            strs += number_words[i] + " + ";
        }

    }
    result_str1 = "";

    if (arry_temp[real_number.length+3]) {
        result_str1 += "<p style='color:#17418d'> Error : " + arry_temp[real_number.length+3] + "</p>";
    }
    str_compare1 = "";
    str_compare ="";
    for (var i = 0; i < str_interger.length; i++) {
        str_compare1 += digits(str_interger.length - i - 1) + " x ";
        str_compare1 += str_interger[i] + " + ";
    }

    for (var i = 0; i < str_decimal.length; i++) {
        str_compare += "1/" + digits(i + 1) + " x ";
        if (i == str_decimal.length-1) {
            str_compare += str_decimal[i];
        }else{
            str_compare += str_decimal[i] + " + ";
        }

    }
    str_compare = str_compare1 + str_compare;
    str_error = "";

    for (var k in arry_checkIdx){
        if (arry_checkIdx.hasOwnProperty(k)) {
            str_error += "<p style='color:#17418d'> Error : " + arry_checkIdx[k] + "</p>";
        }
    }
    // 		for (var i = 0; i < checkIndex; i++) {
    //  		if (checkIndex == i && typeof checkIndex != isNaN) {
    // 	str_error += "<p style='color:#17418d'> Error "+ i +": " + arry_checkIdx[i] + "</p>";
    // }
    //  	}
    result_str += "<p> Step " + (real_number.length+3) + " Now write out the answer. <br>" +str_error + "<br>"+ str_compare + "</p>";
    $("#correct_flow").html(result_str);

}

function displayTotalFlow1(){
    result_str = "";
    result_str += "<b style='color:blue'>Correct Answered Flow</b>";
    result_str += "<br><br>";
    result_str += "<div id='start_div'>";
    result_str += '<label>Write out this number in extended form.  <br>Example:One hundred and Sixty-Two: ';
    result_str += '<b id="randomNumber_b">' + real_number + '</b>';
    result_str += '</label>';
    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 1: How many columns should the place value table have? <b> " + (real_number.length-1) + "</b></p>";
    result_str += "<p style='color:red'> The number has a total of " + (real_number.length-1) + " digits, so it should have columns, this means there are " + (real_number.length-1) + " place values</p>";

    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 2: How many places after the decimal? <b> " + randomDigits2 + "</b></p>";
    result_str += "<p style='color:red'> There are " + randomDigits2 + " digits after the decimal point.</p>";

    result_str += "</div>";

    stc = "";
    stc += "<table>";
    stc += "<tr>";

    for (var i = 0; i < real_number.length; i++) {
        if (i == po1) {
            stc += "<th id='color_th'>Decimal</th>";
        }else if (i > po1) {
            stc += "<th id='color_th'>" + decimal_words[i-po1-1] + "</th>";
        }else if (i < po1) {
            stc += "<th id='color_th'>" + number_words[po1 - i - 1] + "</th>";
        }

    }

    stc += "</tr>";
    stc += "<tr>";
    for (var i = 0; i < real_number.length; i++) {
        stc += "<td>" + real_number[i] + "</td>";

    }
    stc += "</tr>";
    stc += "</table>";

    result_str += "<div>";

    result_str += "<p>Step 3:  Complete the table.</p>" + stc;

    result_str += "</div>";

    for (var j = 0; j < real_number.length-1; j++) {


        if (((j + 4) - 3) <= po1) {
            result_str += "<p>Step " + (j + 4) + " : What is the value of the " + number_words[(j + 4) -4] + " ? <font color=blue>" + digits((j + 4) - 4) + " x " + str_interger[po1 - ((j + 4) - 3)] * 1+ "</font></p>" ;
        }else if (((j + 4) - 3) > po1) {
            result_str += "<p>Step " + (j + 4) + " : What is the value of the " + decimal_words[(j + 4) -3 -str_interger.length - 1]  + " ?<font color=blue> 1/" + digits((j + 4)-3-str_interger.length) + " x " + str_decimal[((j + 4) - 3) - 1 - str_interger.length] + "</font></p>";
        }

        result_str += "<table>";
        result_str += "<tr>";

        for (var i = 0; i < real_number.length; i++) {
            if (i == po1) {
                result_str += "<th id='color_th'>Decimal</th>";
            } else {
                if(i > po1) {
                    if(i == j + 1)
                        result_str += "<th id='color_th'><font color=red>" + decimal_words[i-po1-1] + "</font></th>";
                    else
                        result_str += "<th id='color_th'>" + decimal_words[i-po1-1] + "</th>";
                } else {
                    if(i + j + 1== po1)
                        result_str += "<th id='color_th'><font color=red>" + number_words[po1 - i - 1] + "</font></th>";
                    else
                        result_str += "<th id='color_th'>" + number_words[po1 - i - 1] + "</th>";
                }
            }
        }

        result_str += "</tr>";
        result_str += "<tr>";
        for (var i = 0; i < real_number.length; i++) {
            if (i == po1) {
                result_str += "<td>.</td>";
            } else {
                if(i > po1) {
                    if(i == j + 1)
                        result_str += "<td id='color_th'><font color=red>" + real_number[i] + "</font></td>";
                    else
                        result_str += "<td id='color_th'>" + real_number[i] + "</td>";
                } else {
                    if(i + j + 1== po1)
                        result_str += "<td id='color_th'><font color=red>" + real_number[i] + "</font></td>";
                    else
                        result_str += "<td id='color_th'>" + real_number[i] + "</td>";
                }
            }
        }
        result_str += "</tr>";
        result_str += "</table>";
        if(j >= po1) {
            result_str += "<p style='color:red'>The " + ths_words[j-po1] + " value after the decimal point is called the " + decimal_words[j - po1] + " place. <br>It can also be represented as 1/" + digits(j + 1 -po1) + ".</p>";
            result_str += "<p>We have the value " + str_decimal[j-po1] + " after the decimal point.</p>";
            result_str += "<p> This means that 1/" + digits(j + 1 -po1) + "x" + str_decimal[j-po1] + " = " + str_decimal[j-po1] + "/" + digits(j + 1 -po1) + "</p>";
        } else {
            result_str += "<p>Looking at the table there is a " + str_interger[po1 - j - 1] + " in the " + number_words[ j + 2 - po1 ] + " place.</p>";
        }
    }
    strs = "";
    for (var i = real_number.length-1; i >= 0; i--) {
        strs += "<label style='color:blue;'>" + real_number[real_number.length-i-1] + "</label>";
        if (i == 0) {
            strs += "<span>" + number_words[i] + "</span>";
        }else{
            strs += number_words[i] + " + ";
        }

    }



    result_str += "<p> Step " + (real_number.length+3) + " Now write out the answer. <br><br>" + str_compare + "</p>";
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