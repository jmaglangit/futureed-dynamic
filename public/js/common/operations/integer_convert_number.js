/**
 * Code from client
 * 20170817
 */

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
var number_words = ["One", "Ten", "Hundred", "Thousand", "Ten Thousand", "Hundred Thousand", "Million", "Ten Million", "Hundred Million"];
var digits_words = ["One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine"];
var change_words = ["Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", ""]
var answered = []; //ADDED

// start ADDED functions
//getter and setter
function setRandomDigits(digit){
    randomDigits = digit;
}

function getRandomNumber1(){
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
    
    text = "";
    possible = "123456789";
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

    

    // randomDigits = parseInt($(".randomDigits").prop("value"));
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

    
    countofrandomdigitsNumber = Math.floor(Math.random() * randomDigits);

    $("#tableNumber_div").html("");
    $("#position_div").html("");
    $("#map_table_div").html("");
    $("#answer").html("");
    $("#correct_flow").html("");
    $("#correct_flow_answer").html("");

    $("#randomNumber_b").html(str_randomNumber);
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

var a_caps = ['','ONE','TWO','THRE','FOUR', 'FIVE','SIX','SEVEN','EIGHt','NINE','TEN','ElEVEN','TWElVE','THIRTEN','FOURTEN','FIFTEN','SIXTEN','SEVENTEN','EIGHTEN','NINETEN'];
var b_caps = ['', '', 'TWENTY-','THIRTY-','FORTY-','FIFTY-', 'SIXTY-','SEVENTY-','EIGH TY-','NINETY-'];

function inWords (num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a_caps[Number(n[1])] || b_caps[n[1][0]] + ' ' + a_caps[n[1][1]]) + 'CRORE ' : '';
    str += (n[2] != 0) ? (a_caps[Number(n[2])] || b_caps[n[2][0]] + ' ' + a_caps[n[2][1]]) + 'MIllION ' : '';
    str += (n[3] != 0) ? (a_caps[Number(n[3])] || b_caps[n[3][0]] + ' ' + a_caps[n[3][1]]) + 'THOUSAND ' : '';
    str += (n[4] != 0) ? (a_caps[Number(n[4])] || b_caps[n[4][0]] + ' ' + a_caps[n[4][1]]) + 'HUNDRED ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'AND ' : '') + (a_caps[Number(n[5])] || b_caps[n[5][0]] + '' + a_caps[n[5][1]]): '';
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
    $("#step_div").show();
    var result_str = "";
    if (step_count == 1) {
        result_str = "<div>";
        result_str += "<p>Step " + step_count +":  Lets use the place table.  How many digits in the number?</p>";
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
                alertModal('Please input the valid expression.');
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
        result_str += "<p>Step " + step_count +":  How many columns should the place table have? </p>";
        result_str += "<input type='text' class='inputCheck'>";
        result_str += "</div>";
        $("#position_div").html(result_str);
    }

    if (step_count == 3) {
        result_str = "<div id='examPane'>";
        result_str += "<p> Step " + step_count + ": Using the place table write out the values.</p>";
        result_str += "<table>";
            result_str += "<tr>";
            
                for (var i = real_number.length-1; i >= 0; i--) {
                    if ((arry_correctval[1]-1) == i) {
                        result_str += "<th style='color:red;'>" + number_words[i] + "</th>";
                    }else{
                        result_str += "<th id='color_th'>" + number_words[i] + "</th>"; 
                    }
                    
                }
                
            result_str += "</tr>";
            result_str += "<tr>";
                for (var i = 0; i < real_number.length; i++) {
                    if ((randomDigits - (arry_correctval[1])) == i) {
                        result_str += "<td style='color:red;'>" + real_number[i] + "</td>";
                    }else{
                        result_str += "<td>" + real_number[i] + "</td>";
                    }
                }
            result_str += "</tr>";
        result_str += "</table>";
        str1 = "";
        for (var i = real_number.length-1; i >= 0; i--) {
            str1 += digits_words[real_number[real_number.length - i-1]-1] + " ";
            if (i == 0) {
                str1 += number_words[i];    
            }else{
                str1 += number_words[i] + " + ";
            }
            
        }
        result_str += "<p> This is written out as " + str1 + "</p>";
        result_str += "</div>";
        
        $("#map_table_div").html(result_str);
        nextsetp();
    }

    if (step_count == 4) {
        result_str = "<div>";
        result_str += "<p> Step " + step_count + ": Answer. (Write out in all CAPS)</p>";
        result_str += "<input style='width:300px' type='text' class='inputCheck'>";
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
                alertModal('Please input the valid expression.');
                $(this).prop("value", "").focus();
                retry_attempt++;
                return false;
            }
            
            temp_answer = checkAnswerValidation($(this));
            if (step_count == 4) {
                if(temp_answer == -1){
                    // alert("Your answer is not accurate. Retry!");
                    alertModal("Your answer is not accurate. Please retry.");
                    $(this).prop("value", "").focus();
                    retry_attempt++;
                    return false;
                }
                if(temp_answer == -2){
                    // alert("Your answer is not accurate. Retry!");
                    alertModal("Your answer is not accurate. Please retry.");
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
        correct_answer = real_number.length;
        if (answer_val == correct_answer){
            return correct_answer;  
        }
    }

    if (step_count == 2) {

        correct_answer = real_number.length;
        if (answer_val == correct_answer){
            return correct_answer;  
        }               
    }

    if (step_count == 3) {
        
    }

    if (step_count == 4) {
        if (randomDigits <= 2) {
            strqq = inWords(real_number);
            correct_answer = strqq.toUpperCase();
        }else{
            sttr = numberToEnglish(real_number);
            sttr = sttr.replace("- ", "-");
            correct_answer = sttr.toUpperCase();    
        }

        
         // inWords(real_number).replace(/\s*$/,"");
        
        if (answer_val == correct_answer){
            arry_correctval[2] = correct_answer;
            answerDone();   //added
            displayTotalFlow();
            displayTotalFlow1();
            return correct_answer;  
        }               
    }
    
    if (answer_val > correct_answer) {
        if(retry_attempt > 1){
            // alert("Correct Answer is " + correct_answer + ". Retry! ");
            alertModal("The correct answer is " + correct_answer + ". Please retry. ");
            retry_attempt = 0;
            return -3;
        }else{
            if (!arry_temp[step_count]) {
                arry_temp[step_count] = answer_val;
            }
        }
        return -1;
    }else {
        if(retry_attempt > 1){
            // alert("Correct Answer is " + correct_answer + ". Retry! ");
            alertModal("The correct answer is " + correct_answer + ". Please retry. ");
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



function checkAnswer(elem) {
    answer_val = elem.prop("value");
    setAnswered(answer_val);    //added
    if (step_count != 4) {
        if(isNaN(answer_val)) {
            return "y";
        }
        if (answer_val == "") {
            return "z";
        }
    }else{

        if (answer_val == "") {
            return "z";
        }
    }
    
    elem.prop("value", answer_val);         
}

function displayTotalFlow(){
    result_str = "";
    // result_str += "<b style='color:blue'>Answered Flow</b>";
    // result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += "<label>Rewrite the following number into words, <b>" + str_randomNumber + "</b></label>";
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 1:  Lets use the place table.  How many digits in the number?</p>";
    if (arry_temp[1]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[1] + "</p>";    
    }
    
        result_str += real_number.length;
    result_str += "<div>";

    result_str += "<p>Step 2:  How many columns should the place table have? </p>";
    if (arry_temp[2]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[2] + "</p>";    
    }result_str += real_number.length;
    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p> Step 3: Using the place table write out the values.</p>";
        result_str += "<table>";
            result_str += "<tr>";
            
                for (var i = real_number.length-1; i >= 0; i--) {
                    if ((arry_correctval[1]-1) == i) {
                        result_str += "<th style='color:red;'>" + number_words[i] + "</th>";
                    }else{
                        result_str += "<th id='color_th'>" + number_words[i] + "</th>"; 
                    }
                    
                }
                
            result_str += "</tr>";
            result_str += "<tr>";
                for (var i = 0; i < real_number.length; i++) {
                    if ((randomDigits - (arry_correctval[1])) == i) {
                        result_str += "<td style='color:red;'>" + real_number[i] + "</td>";
                    }else{
                        result_str += "<td>" + real_number[i] + "</td>";
                    }
                }
            result_str += "</tr>";
        result_str += "</table>";
        str1 = "";
        for (var i = real_number.length-1; i >= 0; i--) {
            str1 += digits_words[real_number[real_number.length - i-1]-1] + " ";
            if (i == 0) {
                str1 += number_words[i];    
            }else{
                str1 += number_words[i] + " + ";
            }
            
        }
        result_str += "<p> This is written out as " + str1 + "</p>";

    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p>Step 4: Answer</p>";
    if (arry_temp[4]) {
        result_str += "<p style='color:red;'> Error : " + arry_temp[4] + "</p>";    
    }
    if (randomDigits <= 2) {
        result_str += "<label style='color:blue;'> " + arry_correctval[2] + " </label>";
    }else{
        sttr = numberToEnglish(real_number);
            sttr = sttr.replace("- ", "-");
        result_str += "<label style='color:blue;'> " + arry_correctval[2] + " </label>"
    }
    
    $("#correct_flow").html(result_str);

}

function displayTotalFlow1(){
    result_str = "";
    // result_str += "<b style='color:blue'>Correct Answered Flow</b>";
    // result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += "<label>Rewrite the following number into words, <b>" + str_randomNumber + "</b></label>";
    result_str += "</div>";
    result_str += "<div>";

    result_str += "<p>Step 1:  Lets use the place table.  How many digits in the number?</p>";
        result_str += real_number.length;
    result_str += "<div>";

    result_str += "<p>Step 2:  How many columns should the place table have? </p>";
    result_str += real_number.length;
    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p> Step 3: Using the place table write out the values.</p>";
        result_str += "<table>";
            result_str += "<tr>";
            
                for (var i = real_number.length-1; i >= 0; i--) {
                    if ((arry_correctval[1]-1) == i) {
                        result_str += "<th style='color:red;'>" + number_words[i] + "</th>";
                    }else{
                        result_str += "<th id='color_th'>" + number_words[i] + "</th>"; 
                    }
                    
                }
                
            result_str += "</tr>";
            result_str += "<tr>";
                for (var i = 0; i < real_number.length; i++) {
                    if ((randomDigits - (arry_correctval[1])) == i) {
                        result_str += "<td style='color:red;'>" + real_number[i] + "</td>";
                    }else{
                        result_str += "<td>" + real_number[i] + "</td>";
                    }
                }
            result_str += "</tr>";
        result_str += "</table>";
        str1 = "";
        for (var i = real_number.length-1; i >= 0; i--) {
            str1 += digits_words[real_number[real_number.length - i-1]-1] + " ";
            if (i == 0) {
                str1 += number_words[i];    
            }else{
                str1 += number_words[i] + " + ";
            }
            
        }
        result_str += "<p> This is written out as " + str1 + "</p>";

    result_str += "</div>";

    result_str += "<div>";
    result_str += "<p>Step 4: Answer</p>";
    if (randomDigits <= 2) {
        result_str += "<label style='color:blue;'> " + arry_correctval[2] + " </label>";
    }else{
        sttr = numberToEnglish(real_number);
            sttr = sttr.replace("- ", "-");
        result_str += "<label style='color:blue;'> " + arry_correctval[2] + " </label>"
    }
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