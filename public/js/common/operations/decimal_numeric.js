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

var step2Flag = false;

var arry_correctval = [];
var real_string = "";
var arry_total = [];
var arry_randomNumber = [];
var arry_temp = [];
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
function getCorrectAnswer(){
    return correct_answer;
}

function getRandomNumber1(){
    return randomNumber1;
}

function getRandomNumber2(digit){
    return randomNumber2;
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
    max_digit = 0;
    checkIndex =0;
    str_interger = "";
    str_decimal = "";
    po1 = 0;
    randomIndex = 0;
    decimal_ranIndex = 0;
    decimalNumber = 0;
    step2_count = 0;

    step2Flag = false;

    arry_correctval = [];
    real_string = "";
    arry_total = [];
    arry_randomNumber = [];
    arry_temp = [];
    arry2_temp = [];
    arry_checkIdx = [];
    arr = [];
    str_randomNumber = "";

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

    str_interger = Math.floor(Math.random()*randomDigits1) + "";
    console.log("str_interger"+ str_interger);
    str_interger = str_interger.replace("0", "1");
    str_decimal = "." + real_number;
    decimal_ranIndex = Math.round(Math.random() * (str_decimal.length));
    if (decimal_ranIndex == 0) decimal_ranIndex = 1;
    if (decimal_ranIndex == str_decimal.length) decimal_ranIndex = 1;

    decimalNumber = str_decimal[decimal_ranIndex];

    real_string = str_interger + str_decimal;
    po1 = real_string.indexOf(".");

    correct_answer = "";
    if (str_interger.length <= 2 && real_number.length <= 2) {
        correct_answer += inWords(str_interger) + " And " + inWords(real_number) + " " + decimal_words[str_decimal.length - 2];
        $("#result_Number_words_b").html(correct_answer);
    }else if (str_interger.length <= 2 && real_number.length > 2) {
        correct_answer += inWords(str_interger) + " And " + numberToEnglish(real_number).replace("- ", "-") + " " + decimal_words[str_decimal.length - 2];
        $("#result_Number_words_b").html(correct_answer);
    }else if (str_interger.length > 2 && real_number.length > 2) {
        correct_answer += numberToEnglish(str_interger).replace("- ", "-") + " And " + numberToEnglish(real_number).replace("- ", "-") + " " + decimal_words[str_decimal.length - 2];
        $("#result_Number_words_b").html(correct_answer);
    }else if (str_interger.length > 2 && real_number.length <= 2) {
        correct_answer += numberToEnglish(str_interger).replace("- ", "-") + " And " + inWords(real_number) + " " + decimal_words[str_decimal.length - 2];
        $("#result_Number_words_b").html(correct_answer);
    }
    $("#correct_flow_answer").html("");
    $("#correct_flow").html("");
    $("#step_div").html('<div id="tableNumber_div"></div><div id="lastDiv"></div>');
    $("#start_div").show();

}

var a = ['','One','Two','Three','Four', 'Five','Six','Seven','Eight','Nine','Ten','Eleven','Twelve','Thirteen','Fourteen','Fifteen','Sixteen','Seventeen','Eighteen','Nineteen'];
var b = ['', '', 'Twenty-','Thirty-','Forty-','Fifty-', 'Sixty-','Seventy-','Eighty-','Ninety-'];

function inWords (num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'Crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'Million ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'Thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'Hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + '' + a[n[5][1]]): '';
    return str;
}

function numberToEnglish(n, custom_join_character) {

    var string = n.toString(),
        units, tens, scales, start, end, chunks, chunksLen, chunk, ints, i, word, words;

    var and = custom_join_character || 'And';

    /* Is number zero? */
    if (parseInt(string) === 0) {
        return 'zero';
    }

    /* Array of units as words */
    units = ['', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'];

    /* Array of tens as words */
    tens = ['', '', 'Twenty-', 'Thirty-', 'Forty-', 'Fifty-', 'Sixty-', 'Seventy-', 'Eighty-', 'Ninety-'];

    /* Array of scales as words */
    scales = ['', 'Thousand', 'Million', 'billion', 'Trillion', 'Quadrillion', 'Quintillion', 'Sextillion', 'Septillion', 'Octillion', 'Nonillion', 'Decillion', 'Undecillion', 'Duodecillion', 'Tredecillion', 'Quatttuor-decillion', 'Quindecillion', 'Sexdecillion', 'Septen-decillion', 'Octodecillion', 'Novemdecillion', 'Vigintillion', 'Centillion'];

    /* Split user arguemnt into 3 digit chunks from right to left */
    start = string.length;
    chunks = [];
    while (start > 0) {
        end = start;
        chunks.push(string.slice((start = Math.max(0, start - 3)), end));
    }

    /* Check if function has enough scale words to be able to stringify the user argument */
    chunksLen = chunks.length;
    if (chunksLen > scales.length) {
        return '';
    }

    /* Stringify each integer in each chunk */
    words = [];
    for (i = 0; i < chunksLen; i++) {

        chunk = parseInt(chunks[i]);

        if (chunk) {

            /* Split chunk into array of individual integers */
            ints = chunks[i].split('').reverse().map(parseFloat);

            /* If tens integer is 1, i.e. 10, then add 10 to units integer */
            if (ints[1] === 1) {
                ints[0] += 10;
            }

            /* Add scale word if chunk is not zero and array item exists */
            if ((word = scales[i])) {
                words.push(word);
            }

            /* Add unit word if array item exists */
            if ((word = units[ints[0]])) {

                words.push(word);
            }

            /* Add tens word if array item exists */
            if ((word = tens[ints[1]])) {
                words.push(word);
            }

            /* Add 'and' string after units or tens integer if: */
            if (ints[0] || ints[1]) {

                /* Chunk has a hundreds integer or chunk is the first of multiple chunks */
                if (ints[2] || !i && chunksLen) {
                    words.push(and);
                }

            }

            /* Add hundreds word if array item exists */
            if ((word = units[ints[2]])) {
                words.push(word + ' Hundred');
            }

        }

    }

    return words.reverse().join(' ');

}

function startBtnOnclick(){
    step_count++;
    retry_attempt = 0;
    var result_str = "";
    if (step_count == 1) {
        result_str = "<div>";
        result_str += "<p>Step " + step_count +":   What is the largest value that you see? Example, Ten, Ones, Hundred, Thousand.</p>";
        result_str += "<input class='inputCheck'>";
        result_str += "</div>";
        $("#tableNumber_div").html(result_str);
    }

    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer can't be blank. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }

            temp_answer = checkAnswerValidation($(this));
            if(temp_answer == -1){
                alertModal('Your answer is either incorrect or must be in all capital letters. Please retry.');
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            if(temp_answer == -2){
                alertModal('Your answer is either incorrect or must be in all capital letters. Please retry.');
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
        $("<p>Step " + step_count + " :  What is the lowest value?  Example, One Tenths, Hundredths?</p><br><input class='inputCheck'>").insertBefore("#lastDiv");
    }
    if (step_count == 3) {
        $("<p>Step " + step_count + " :  Let us put this number into the place table.  How many columns does it need?</p><br><input class='inputCheck'>").insertBefore("#lastDiv");
    }

    if (step_count == 4) {
        $("<p>Step " + step_count + " : Fill in the table below.</p>" + result_str).insertBefore("#lastDiv");
        return middleFunc();
    }
    if (step_count == 5) {
        $("<p>Step " + step_count + " :  Now rewrite in numeric form.</p><br><input class='inputCheck'>").insertBefore("#lastDiv");
    }

    if (step_count > 5) {
        answerDone();  //ADDED
        displayTotalFlow();
        displayTotalFlow1();
    }
    $(".inputCheck").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer can't be blank. Please retry.");
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }

            temp_answer = checkAnswerValidation($(this));
            if (step_count <= 2) {
                if(temp_answer == -1){
                    alertModal('Your answer is either incorrect or must be in all capital letters. Please retry.');
                    $(this).prop("value", "").focus();
                    retry_attempt++;
                    return false;
                }
                if(temp_answer == -2){
                    alertModal('Your answer is either incorrect or must be in all capital letters. Please retry.');
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

function middleFunc() {
    console.log("1");
    $(".checkIndexs").eq(0).focus();
    checkIndex = 0;
    $(".checkIndexs").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                alertModal("That is incorrect. Answer can't be blank. Please retry.");
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
        correct_answer = number_words1[str_interger.length-1];

        if (answer_val.toLowerCase() == correct_answer){
            arry_correctval[1] = answer_val;
            return correct_answer;
        }


    }
    if (step_count == 2) {
        correct_answer = decimal_words1[real_number.length- 1];

        if (answer_val.toLowerCase() == correct_answer){
            arry_correctval[2] = answer_val;
            return correct_answer;
        }
    }

    if (step_count == 3) {
        correct_answer = real_string.length - 1;

        if (answer_val == correct_answer){
            return correct_answer;
        }
    }

    if (step_count == 4) {
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

    if (step_count == 5) {
        correct_answer = str_interger + str_decimal;

        if (answer_val == correct_answer){
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
        setAnswered(answer_val);    //added
    }
}

function displayTotalFlow(){
    result_str = "";

    correct_answer = "";
    if (str_interger.length <= 2 && real_number.length <= 2) {
        correct_answer += inWords(str_interger) + " And " + inWords(real_number) + " " + decimal_words[str_decimal.length - 2];
    }else if (str_interger.length <= 2 && real_number.length > 2) {
        correct_answer += inWords(str_interger) + " And " + numberToEnglish(real_number).replace("- ", "-") + " " + decimal_words[str_decimal.length - 2];
    }else if (str_interger.length > 2 && real_number.length > 2) {
        correct_answer += numberToEnglish(str_interger).replace("- ", "-") + " And " + numberToEnglish(real_number).replace("- ", "-") + " " + decimal_words[str_decimal.length - 2];
    }else if (str_interger.length > 2 && real_number.length <= 2) {
        correct_answer += numberToEnglish(str_interger).replace("- ", "-") + " And " + inWords(real_number) + " " + decimal_words[str_decimal.length - 2];
    }

    result_str += "<b style='color:blue'>Answered Flow</b>";
    result_str += "<br><br>";
    result_str += "<div id='start_div'>";
    result_str += '<label>Write <b>' + correct_answer + '</b> in numerice from.</label>';
    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 1: What is the largest value that you see? Example, Ten, Ones, Hundred, Thousand?  <font color=blue>" + arry_correctval[1]+ "</font> </p>";

    if (arry_temp[1]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[1] + "</p>";
    }
    strss = "";
    if (str_interger.length <= 2) {
        strss += '<font color=red>' + inWords(str_interger) + '</font>';
        console.log("1 = " + strss);
    }else{
        strss += '<font color=red>' + numberToEnglish(str_interger) + '</font>';
        console.log("1 = " + strss);
    }
    sttrss = "";
    if (str_interger.length <= 2) {
        sttrss += inWords(str_interger);
    }else{
        sttrss +=numberToEnglish(str_interger);
    }

    // result_str += '<font color=blue>' + number_words[str_interger.length-1] + '</font>';
    result_str += "<font color=blue> I see the word <b>" + arry_correctval[1] + "</b> in this number one the far left.</font><br>";
    result_str += "<font color=blue>Remember that the largest number is always on the far left.</font><br>";
    result_str += correct_answer.replace(sttrss, strss);

    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 2: What is the lowest value?  Example, One Tenths, Hundredths? <font color=blue>" + arry_correctval[2] + "</font></p>";
    if (arry_temp[2]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[2] + "</p>";
    }
    strss1 = "";
    strss1 += '<font color=red>' + decimal_words[str_decimal.length - 2] + '</font>';
    console.log("1 = " + strss1);


    result_str += "<font color=blue> I see the word <b>" + arry_correctval[2] + "</b> on the far right.</font><br>";
    result_str += "<font color=blue>Remember the smallest number is always on the far right.</font><br>";

    result_str += correct_answer.replace(decimal_words[str_decimal.length - 2], strss1);

    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 3: Let us put this number into the place table.  How many columns does it need? <font color=blue>" + (real_string.length-1) + "</font></p>";
    if (arry_temp[3]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[3] + "</p>";
    }

    result_str += "<font color=blue> To figure out the number of columns, we need to know how many numbers go between "+ number_words[str_interger.length-1] +" and " + decimal_words[str_interger.length-1] + ".<br>  We know that the order is as follows.</font><br>";
    for (var i = 0; i < real_string.length - 1; i++) {
        if (i < po1) {
            result_str += number_words[po1 - i - 1] + "<br>";
        }else if (i >= po1) {
            result_str += decimal_words[i-po1] + "<br>";
        }
    }
    result_str += "Hence there are "+ (real_string.length - 1)+" columns";

    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 4: Fill in the table below.</p>";

    for (var checkIndex in arry_checkIdx){
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
    result_str += correct_answer;

    result_str += "</div>";



    result_str += "<div>";

    result_str += "<p>Step 5: Answer. <font color=blue>" + real_string + "</font></p>";
    if (arry_temp[5]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[5] + "</p>";
    }
    result_str += "</div>";
    $("#correct_flow").html(result_str);

}

function displayTotalFlow1(){
    result_str = "";

    correct_answer = "";
    if (str_interger.length <= 2 && real_number.length <= 2) {
        correct_answer += inWords(str_interger) + " And " + inWords(real_number) + " " + decimal_words[str_decimal.length - 2];
    }else if (str_interger.length <= 2 && real_number.length > 2) {
        correct_answer += inWords(str_interger) + " And " + numberToEnglish(real_number).replace("- ", "-") + " " + decimal_words[str_decimal.length - 2];
    }else if (str_interger.length > 2 && real_number.length > 2) {
        correct_answer += numberToEnglish(str_interger).replace("- ", "-") + " And " + numberToEnglish(real_number).replace("- ", "-") + " " + decimal_words[str_decimal.length - 2];
    }else if (str_interger.length > 2 && real_number.length <= 2) {
        correct_answer += numberToEnglish(str_interger).replace("- ", "-") + " And " + inWords(real_number) + " " + decimal_words[str_decimal.length - 2];
    }

    result_str += "<b style='color:blue'> Correct Answered Flow</b>";
    result_str += "<br><br>";
    result_str += "<div id='start_div'>";
    result_str += '<label>Write <b>' + correct_answer + '</b> in numerice from.</label>';
    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 1: What is the largest value that you see? Example, Ten, Ones, Hundred, Thousand?  <font color=blue>" + arry_correctval[1]+ "</font> </p>";

    strss = "";
    if (str_interger.length <= 2) {
        strss += '<font color=red>' + inWords(str_interger) + '</font>';
    }else{
        strss += '<font color=red>' + numberToEnglish(str_interger) + '</font>';
    }
    sttrss = "";
    if (str_interger.length <= 2) {
        sttrss += inWords(str_interger);
    }else{
        sttrss +=numberToEnglish(str_interger);
    }

    // result_str += '<font color=blue>' + number_words[str_interger.length-1] + '</font>';
    result_str += "<font color=blue> I see the word <b>" + arry_correctval[1] + "</b> in this number one the far left.</font><br>";
    result_str += "<font color=blue>Remember that the largest number is always on the far left.</font><br>";
    result_str += correct_answer.replace(sttrss, strss);

    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 2: What is the lowest value?  Example, One Tenths, Hundredths? <font color=blue>" + arry_correctval[2] + "</font></p>";
    strss1 = "";
    strss1 += '<font color=red>' + decimal_words[str_decimal.length - 2] + '</font>';


    result_str += "<font color=blue> I see the word <b>" + arry_correctval[2] + "</b> on the far right.</font><br>";
    result_str += "<font color=blue>Remember the smallest number is always on the far right.</font><br>";

    result_str += correct_answer.replace(decimal_words[str_decimal.length - 2], strss1);

    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 3: Let us put this number into the place table.  How many columns does it need? <font color=blue>" + (real_string.length-1) + "</font></p>";

    result_str += "<font color=blue> To figure out the number of columns, we need to know how many numbers go between "+ number_words[str_interger.length-1] +" and " + decimal_words[str_interger.length-1] + ".<br>  We know that the order is as follows.</font><br><br>";
    for (var i = 0; i < real_string.length - 1; i++) {
        if (i < po1) {
            result_str += number_words[po1 - i - 1] + "<br>";
        }else if (i >= po1) {
            result_str += decimal_words[i-po1] + "<br>";
        }
    }
    result_str += "Hence there are "+ (real_string.length - 1)+" columns";

    result_str += "</div>";

    result_str += "<div>";

    result_str += "<p>Step 4: Fill in the table below.</p>";

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
    result_str += correct_answer;

    result_str += "</div>";



    result_str += "<div>";

    result_str += "<p>Step 5: Answer. <font color=blue>" + real_string + "</font></p>";

    result_str += "</div>";
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