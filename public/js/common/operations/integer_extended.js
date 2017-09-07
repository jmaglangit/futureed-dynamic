var randomNumber = 0;
var randomdigitsNumber = 0;
var step_count = 0;
var countofrandomdigitsNumber = 0;
var real_number = "";
var str_randomNumber = "";
var max_digit = 0;
var checkIndex =0;

var arry_correctval = [];
var arry_total = [];
var arry_randomNumber = [];
var arry_temp = [];
var arry_checkIdx = [];
var number_words = ["One", "Ten", "Hundred", "Thousand", "Ten Thousand", "Hundred Thousand", "Million", "Ten Million", "Hundred Million"];

var arr = [];
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

    randomNumber = 0;
    randomdigitsNumber = 0;
    step_count = 0;
    countofrandomdigitsNumber = 0;
    real_number = "";
    str_randomNumber = "";
    max_digit = 0;
    checkIndex =0;

    arry_correctval = [];
    arry_total = [];
    arry_randomNumber = [];
    arry_temp = [];
    arry_checkIdx = [];

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
    max_digit = randomDigits + 2;

    $("#step_div").html('<div id="tableNumber_div"></div><div id="lastDiv"></div>');
    $("#correct_flow").html("");
    $("#correct_flow_answer").html("");

    $("#randomNumber_b").html(real_number);
    $("#toEnglish_b").html(numberToEnglish(real_number));
    $("#start_div").show();
}

function numberToEnglish(n, custom_join_character) {

    var string = n.toString(),
        units, tens, scales, start, end, chunks, chunksLen, chunk, ints, i, word, words;

    var and = custom_join_character || 'and';

    /* Is number zero? */
    if (parseInt(string) === 0) {
        return 'zero';
    }

    /* Array of units as words */
    units = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];

    /* Array of tens as words */
    tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

    /* Array of scales as words */
    scales = ['', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion', 'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quatttuor-decillion', 'quindecillion', 'sexdecillion', 'septen-decillion', 'octodecillion', 'novemdecillion', 'vigintillion', 'centillion'];

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
                words.push(word + ' hundred');
            }

        }

    }

    return words.reverse().join(' ');
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
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
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

function checkTotal() {
    strs = "";
    for (var i = real_number.length-1; i >= 0; i--) {
        strs += "<input type=text placeholder='answer' style='width:30px;' class='answer_value inputCheck checkIndexs'>";
        if (i == 0) {
            strs += "<span>" + number_words[i] + "</span>";
        }else{
            strs += number_words[i] + " + ";
        }

    }
    $("<p>Step " + step_count + " : Now write out the answer.</p>" + strs).insertBefore("#lastDiv");
    $(".checkIndexs").eq(0).focus();
    checkIndex = 0;
    $(".checkIndexs").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == "y"){
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
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

            temp_answer = checkAnswerValidation1($(this));
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
            if (checkIndex == real_number.length) {
                answerDone();
                displayTotalFlow();
                displayTotalFlow1();
            }
            $(this).attr("readonly", true);
            $(".checkIndexs").eq(checkIndex).focus();
        }
    });
}

function nextsetp(){

    retry_attempt = 0;
    result_str = "";
    step_count++;
    if(step_count >= max_digit) {
        checkTotal();
        return;
    }

    $("<p>Step " + step_count + " : What is the value of the " + number_words[step_count -2] + " ? </p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
    $(".inputCheck").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == "y"){
                alertModal("That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");
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

function checkAnswerValidation(elem) {

    answer_val = elem.prop("value");

    if (step_count == 1) {
        correct_answer = arr.length;
        if (answer_val == correct_answer){
            return correct_answer;
        }
        if(retry_attempt > 1){
            alertModal("The correct answer is " + correct_answer + ". Please retry.");
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

    correct_answer = real_number[max_digit - step_count - 1] * 1;
    if (answer_val == correct_answer) {
        return correct_answer;
    }
    if(retry_attempt > 1){
        alertModal("The correct answer is " + correct_answer + ". Please retry.");
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

function checkAnswerValidation1(elem) {

    answer_val = elem.prop("value");

    correct_answer = real_number[checkIndex] * 1;
    if (answer_val == correct_answer) {
        checkIndex++;
        retry_attempt = 0;
        return correct_answer;
    }
    if(retry_attempt > 1){
        alertModal("The correct answer is " + correct_answer + ". Please retry.");
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

function checkAnswer(elem) {
    answer_val = elem.prop("value");
    console.log("step_count = " + step_count);
    if (step_count == 5 || step_count == 4) {
        console.log("step_count45 = " + step_count);
        setAnswered(answer_val);    //added
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
    result_str = "";
    result_str += "<b style='color:blue'>Answered Flow</b>";
    result_str += "<br><br>";
    result_str += "<div id='start_div'>";
    result_str += '<label>Write out this number in extended form.  <br>Example:One hundred and Sixty-Two: ';
    result_str += '<b id="randomNumber_b">' + real_number + '</b>';
    result_str += '</label>';
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 1: How many columns should the place value table have? <b> " + real_number.length + "</b></p>";
    if (arry_temp[1]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[1] + "</p>";

    }
    result_str += "<table>";
    result_str += "<tr>";

    for (var i = real_number.length-1; i >= 0; i--) {
        result_str += "<th id='color_th'>" + number_words[i] + "</th>";
    }

    result_str += "</tr>";
    result_str += "<tr>";
    for (var i = 0; i < real_number.length; i++) {
        result_str += "<td>" + real_number[i] + "</td>";

    }
    result_str += "</tr>";
    result_str += "</table>";
    result_str += "</div>";
    result_str += "<div>";

    for (var j = 0; j < real_number.length; j++) {

        result_str += "<p> Step " + (j+2) + "What is the value of the "+ number_words[j] +" ?</p>";
        if (arry_temp[j+2]) {
            result_str += "<p style='color:red;'> Error : " + arry_temp[j+2] + "</p>";
            console.log("arry_temp["+ (j+2) + "] = " + arry_temp[j+2]);

        }
        result_str += "<table>";
        result_str += "<tr>";

        for (var i = real_number.length-1; i >= 0; i--) {
            if (i == j) {
                result_str += "<th style='color:red'>" + number_words[i] + "</th>";
            }else{
                result_str += "<th id='color_th'>" + number_words[i] + "</th>";
            }

        }

        result_str += "</tr>";
        result_str += "<tr>";
        for (var k = 0; k < real_number.length; k++) {
            if (k == real_number.length-j-1) {
                result_str += "<td style='color:red;'>" + real_number[k] + "</td>";
            }else{
                result_str += "<td>" + real_number[k] + "</td>";
            }


        }
        result_str += "</tr>";
        result_str += "</table>";
        result_str += "<p style='color:blue;'>" + number_words[j] + " equals " + real_number[real_number.length - j - 1] + ".</p>";
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



    result_str += "<p> Step " + (real_number.length+2) + " Now write out the answer. <br>" + strs + "</p>";
    for (var i = 0; i < real_number.length; i++) {
        if (arry_checkIdx[i]) {
            result_str += "<p style='color:red;'> Error : " + arry_checkIdx[i] + "</p>";
            console.log("arry_checkIdx[" + i + "] = " + arry_checkIdx[i]);
        }
    }


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

    result_str += "<p>Step 1: How many columns should the place value table have? <b> " + real_number.length + "</b></p>";
    result_str += "<table>";
    result_str += "<tr>";

    for (var i = real_number.length-1; i >= 0; i--) {
        result_str += "<th id='color_th'>" + number_words[i] + "</th>";
    }

    result_str += "</tr>";
    result_str += "<tr>";
    for (var i = 0; i < real_number.length; i++) {
        result_str += "<td>" + real_number[i] + "</td>";

    }
    result_str += "</tr>";
    result_str += "</table>";
    result_str += "</div>";
    result_str += "<div>";

    for (var j = 0; j < real_number.length; j++) {

        result_str += "<p> Step " + (j+2) + "What is the value of the "+ number_words[j] +" ?</p>";
        result_str += "<table>";
        result_str += "<tr>";

        for (var i = real_number.length-1; i >= 0; i--) {
            if (i == j) {
                result_str += "<th style='color:red'>" + number_words[i] + "</th>";
            }else{
                result_str += "<th id='color_th'>" + number_words[i] + "</th>";
            }

        }

        result_str += "</tr>";
        result_str += "<tr>";
        for (var k = 0; k < real_number.length; k++) {
            if (k == real_number.length-j-1) {
                result_str += "<td style='color:red;'>" + real_number[k] + "</td>";
            }else{
                result_str += "<td>" + real_number[k] + "</td>";
            }


        }
        result_str += "</tr>";
        result_str += "</table>";
        result_str += "<p style='color:blue;'>" + number_words[j] + " equals " + real_number[real_number.length - j - 1] + ".</p>";
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

    result_str += "<p> Step " + (real_number.length+2) + " Now write out the answer. <br>" + strs + "</p>";
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