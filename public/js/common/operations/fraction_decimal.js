/**
 *  Code from client
 * 20170823.
 */

var randomNumber = 0;
var m = 0;
var z = 0;
var step_count = 0;
var retry_attempt = 0;
var step2_count = 0;
    

var randomNumeratorDigits = 0;
var randomDenominatorDigits = 0;

var factorX = 1;
var An = 0;
var Ad = 0;

var factorY = 1;

var arry_temp = [];
var arry_correctval = [];
var arry_step2_temp = [];

var answered = []; //ADDED

// start ADDED functions
//getter and setter

function getDigitNumerator(){
    return An;
}

function getDigitDenominator(){
    return Ad;
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
    randomNumber = 0;
    m = 0;
    z = 0;
    step_count = 0;
    retry_attempt = 0;
    step2_count = 0;
    

    randomNumeratorDigits = 0;
    randomDenominatorDigits = 0;

    factorX = 1;
    An = 0;
    Ad = 0;

    factorY = 1;

    arry_temp = [];
    arry_correctval = [];
    arry_step2_temp = [];

    randomDenominatorDigits = parseInt($(".randomDigits_m").prop("value"));
    randomNumeratorDigits = parseInt($(".randomDigits_z").prop("value"));

    if(isNaN(randomDenominatorDigits)) {
        randomDenominatorDigits = 10;
        $(".randomDigits_m").prop("value", randomDenominatorDigits);
    }
    if(isNaN(randomNumeratorDigits)) {
        randomNumeratorDigits = 3;
        $(".randomDigits_z").prop("value", randomNumeratorDigits);
    }
    
    z = Math.floor(Math.random() * randomNumeratorDigits);
    randomNumber = Math.floor(Math.random() * randomDenominatorDigits); 

    m = Math.pow(2, randomNumber) * 5;
    if (m == 0) m = 2;
    if (z == 0) z = 3;
    if (m == z) z = m + 1;
    
    An = Math.abs( z );
    Ad = Math.abs( m );
    factorX = 1;
    //Find common factors of Numerator and Denominator
    for ( var x = 2; x <= Math.min( An, Ad ); x ++ ) {
        var check1 = An / x;
        if ( check1 == Math.round( check1 ) ) {
            var check2 = Ad / x;
            if ( check2 == Math.round( check2 ) ) {
                factorX = x;
            }
        }
    }

    An=(An/factorX);  //divide by highest common factor to reduce fraction then multiply by neg to make positive or negative
    Ad=Ad/factorX;

    $("#z_label").html(An);
    $("#m_label").html(Ad);
    $("#correct_flow_answer").html("");
    $("#correct_flow").html("");
    $("#tableNumber_div").html("");
    $("#lastDiv").html("");
    $("#start_div").show();
}

function startBtnOnclick(){
    step_count++;
    retry_attempt = 0;
    var result_str = "";
    if (step_count == 1) {
        result_str = "<div>";
        result_str += "<p>Step " + step_count +":   First figure out how to convert the denominator (bottom number) into multiples of 10.  <br>For example if the denominator is 5 , you need to multiply by 2 to get 10.<br>  Remember you need to get the denominator to multiples of 10.<br> eg. 10, 100, 1,000, 10,000.<br>What number do you multiple the denominator by?</p>";
        result_str += "<input class='inputCheck'>";
        result_str += "</div>";
        $("#tableNumber_div").html(result_str);
    }

    $(".inputCheck").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                // alert("Answer can't be alphabet !");
                alertModal("That is incorrect. Answer can’t be blank. Please retry.");
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
    result_str = "";
    step_count++;
    result_str += '<div>';
        result_str += '<table>';
            result_str += '<tr>';
                
                result_str += '<td align="center"><label>'+ An +'</label></td>';
                result_str += '<td rowspan="3" align="center" valign="middle"><b> * </b></td>';
                result_str += '<td align="center"><label style = "color:blue">'+ factorY +'</label></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
                result_str += '<td align="center" valign="middle" class="verybigtext"><input class="inputCheck1"></td>';
            result_str += '</tr>';
            result_str += '<tr>';
                result_str += '<td bgcolor="#000000" height="2"></td>';
                result_str += '<td bgcolor="#000000" height="2"></td>';
                result_str += '<td bgcolor="#000000" height="2"></td>';
            result_str += '</tr>';
            result_str += '<tr>';
                result_str += '<td align="center"><label>'+ Ad +'</label></td>';
                result_str += '<td align="center"><label style = "color:blue">'+ factorY +'</td>';
                result_str += '<td align="center" valign="middle" class="verybigtext"><input class="inputCheck2"></td>';
            result_str += '</tr>';              
        result_str += '</table>';

    result_str += '</div>';
    
    if (step_count == 2) {
        $("<p style = 'margin-top:20px'>Step " + step_count + " :  Multiple numerator and denominator by that number.</p><br>" + result_str).insertBefore("#lastDiv");
        return middleFunc();
    }
    result_str = "";
    result_str += '<div>';
        result_str += '<table>';
            result_str += '<tr>';
                
                result_str += '<td align="center"><label>'+ An*factorY +'</label></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><input class="inputCheck"></td>';
            result_str += '</tr>';
            result_str += '<tr>';
                result_str += '<td bgcolor="#000000" height="2"></td>';
            result_str += '</tr>';
            result_str += '<tr>';
                result_str += '<td align="center"><label>'+ Ad* factorY +'</label></td>';
            result_str += '</tr>';              
        result_str += '</table>';

    result_str += '</div>';
    if (step_count == 3) {
        $("<p style = 'margin-top:20px'>Step " + step_count + " :    To find the decimal now divide the numerator by denominator.</p><br>" + result_str).insertBefore("#lastDiv");
    }
    
    if (step_count > 3) {
        answerDone();   //added
        displayTotalFlow();
        displayTotalFlow1();
    }
    $(".inputCheck").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                // alert("Answer can't be alphabet !");
                alertModal("That is incorrect. Answer can’t be blank. Please retry.");
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

function middleFunc() {
    $(".inputCheck1").unbind("keydown").keydown(function(event){
        if(event.keyCode == 13){
            if(checkAnswer($(this)) == false){
                // alert("Answer can't be alphabet !");
                alertModal("That is incorrect. Answer can’t be blank. Please retry.");
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
            $(".inputCheck2").unbind("keydown").keydown(function(event){
                if(event.keyCode == 13){
                    if(checkAnswer($(this)) == false){
                        // alert("Answer can't be alphabet !");
                        alertModal("That is incorrect. Answer can’t be blank. Please retry.");
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
    }).focus();
}

function checkAnswerValidation(elem) {
    
    answer_val = elem.prop("value");

    if (step_count == 1) {
        var x = 1;

        
        while(1){
            x *= 10;
            if (x % Ad == 0) {
                factorY = x / Ad;
                break;
            }
        }
        correct_answer = factorY;
    
        if (answer_val == correct_answer){
            return correct_answer;  
        }   

        
    }
    if (step_count == 2) {
        step2_count++;
        
        if (step2_count == 1) {
            correct_answer = An * factorY;
            
            if (answer_val == correct_answer){
                
                return correct_answer;  
            }
        }

        if (step2_count == 2) {
            correct_answer = Ad * factorY;
    
            if (answer_val == correct_answer){
                
                return correct_answer;  
            }
        }
        if(retry_attempt > 1){
            // alert("Correct Answer is " + correct_answer + ". Retry! ");
            alertModal("The correct answer is " + correct_answer + "Please retry. ");
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
        correct_answer = (An * factorY) / (Ad * factorY);
    
        if (answer_val == correct_answer){
            return correct_answer;  
        }
    }
    if(retry_attempt > 1){
        // alert("Correct Answer is " + correct_answer + ". Retry! ");
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

    // result_str += "<b style='color:blue'>Answered Flow</b>";
    // result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += '<table>';
            result_str += '<tr>';
                result_str += '<td rowspan="3" align="center" valign="middle">What is the value of </td>';
                result_str += '<td align="center"><label>'+ An +'</label></td>';
                result_str += '<td rowspan="3" align="center" valign="middle"> in decimal points?</td>';
            result_str += '</tr>';
            result_str += '<tr><td bgcolor="#000000" height="2"></td></tr>';
            result_str += '<tr><td align="center"><label>'+ Ad +'</label></td></tr>     ';
        result_str += '</table>';
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 1: First figure out how to convert the denominator (bottom number) into multiples of 10.<br> - Example 10, 100, 1,000, 10,000.<br> - Any 1 followed only by 0s.  <br><font color=blue>" + factorY + "</font> </p>";
        
        if (arry_temp[1]) {
            result_str += "<p style='color:red;'> Error : " + arry_temp[1] + "</p>";
        }

        result_str += "<p>In this case, we need to find how to convert "+Ad+" into 100, 1,000 or 10,000 with no remainder.</p>";
        var x = 1;
        var y = 1;
        while(1){
            x *= 10;
            y = x / Ad;
            result_str += x + "/" + Ad + " = " + y+ ".  ";
            if (x % Ad == 0) {
                factorY = y;
                break;
            }
        }

        result_str += "<p> Let us use the "+ factorY +".</p>";
        
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p style = 'margin-top:20px'>Step 2: Multiple numerator and denominator by that number.</p>";
        if (arry_step2_temp[1]) {
            result_str += "<p style='color:red;'> Error : " + arry_step2_temp[1] + "</p>";
        }

        if (arry_step2_temp[2]) {
            result_str += "<p style='color:red;'> Error : " + arry_step2_temp[2] + "</p>";
        }

        result_str += '<table>';
            result_str += '<tr>';
                
                result_str += '<td align="center"><label>'+ An +'</label></td>';
                result_str += '<td rowspan="3" align="center" valign="middle"><b> * </b></td>';
                result_str += '<td align="center"><label style = "color:blue">'+ factorY +'</label></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
                result_str += '<td align="center" valign="middle" class="verybigtext">' + An*factorY + '</td>';
            result_str += '</tr>';
            result_str += '<tr>';
                result_str += '<td bgcolor="#000000" height="2"></td>';
                result_str += '<td bgcolor="#000000" height="2"></td>';
                result_str += '<td bgcolor="#000000" height="2"></td>';
            result_str += '</tr>';
            result_str += '<tr>';
                result_str += '<td align="center"><label>'+ Ad +'</label></td>';
                result_str += '<td align="center"><label style = "color:blue">'+ factorY +'</td>';
                result_str += '<td align="center" valign="middle" class="verybigtext">' + Ad*factorY + '</td>';
            result_str += '</tr>';              
        result_str += '</table>';
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 3: Write out the numerator (top number) in decimal form keeping in mind the principals of decimals.</p>";
        if (arry_temp[3]) {
            result_str += "<p style='color:red;'> Error : " + arry_temp[3] + "</p>";
        }
        result_str += '<table>';
            result_str += '<tr>';
                
                result_str += '<td align="center"><label>'+ An*factorY +'</label></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext">' + (An * factorY) / (Ad * factorY) + '</td>';
            result_str += '</tr>';
            result_str += '<tr>';
                result_str += '<td bgcolor="#000000" height="2"></td>';
            result_str += '</tr>';
            result_str += '<tr>';
                result_str += '<td align="center"><label>'+ Ad* factorY +'</label></td>';
            result_str += '</tr>';              
        result_str += '</table>';
        result_str += "<br>You go to the end of the number in this case " + An * factorY + ", and move back the number of times by the number of zeros in the denominator.";
        result_str += "<br>Since "+ Ad * factorY +" has " + Math.log10(Ad * factorY) + " zeros, you must move back " + Math.log10(Ad * factorY) + " times.";
        result_str += "<font color=red><br>Note the movement of the decimal point to the left (always to the left), depends on what you are dividing by. <br> If you are dividing by 100, move back 2 spaces, 1,000 3 spaces, 10,000 4 spaces and so on.</font><br><br>";

        var str = ((An * factorY) / (Ad * factorY)).toString();
        
        po1 = str.indexOf(".");
        str_interger = str.substring(0, po1);
        str_decimal = str.substring(po1+1);
        

        for (var i = 0; i < str.length; i++) {
            if (i == po1) {
                result_str += ".";
            }else if (i < po1) {
                result_str += str[i];
            }else if (i > po1) {
                result_str += "<b style='position:relative; top:-12px;left:7px;'>&#8630</b>";
                result_str += str[i];
            }
        }
    result_str += "</div>";
    $("#correct_flow").html(result_str);

}

function displayTotalFlow1(){
    result_str = "";

    // result_str += "<b style='color:blue'>Correct Answered Flow</b>";
    // result_str += "<br><br>";
    result_str += "<div id='start_div'>";
        result_str += '<table>';
            result_str += '<tr>';
                result_str += '<td rowspan="3" align="center" valign="middle">What is the value of </td>';
                result_str += '<td align="center"><label>'+ An +'</label></td>';
                result_str += '<td rowspan="3" align="center" valign="middle"> in decimal points?</td>';
            result_str += '</tr>';
            result_str += '<tr><td bgcolor="#000000" height="2"></td></tr>';
            result_str += '<tr><td align="center"><label>'+ Ad +'</label></td></tr>     ';
        result_str += '</table>';
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 1: First figure out how to convert the denominator (bottom number) into multiples of 10.<br> - Example 10, 100, 1,000, 10,000.<br> - Any 1 followed only by 0s.  <font color=blue>" + factorY + "</font> </p>";
        
        result_str += "<p>In this case, we need to find how to convert 8 into 100, 1,000 or 10,000 with no remainder. <br> 100/8=12.5. 1000/8=125.<br> Let us use the 125.</p>";
        
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p style = 'margin-top:20px'>Step 2: Multiple numerator and denominator by that number.</p>";
        
        result_str += '<table>';
            result_str += '<tr>';
                
                result_str += '<td align="center"><label>'+ An +'</label></td>';
                result_str += '<td rowspan="3" align="center" valign="middle"><b> * </b></td>';
                result_str += '<td align="center"><label style = "color:blue">'+ factorY +'</label></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
                result_str += '<td align="center" valign="middle" class="verybigtext">' + An*factorY + '</td>';
            result_str += '</tr>';
            result_str += '<tr>';
                result_str += '<td bgcolor="#000000" height="2"></td>';
                result_str += '<td bgcolor="#000000" height="2"></td>';
                result_str += '<td bgcolor="#000000" height="2"></td>';
            result_str += '</tr>';
            result_str += '<tr>';
                result_str += '<td align="center"><label>'+ Ad +'</label></td>';
                result_str += '<td align="center"><label style = "color:blue">'+ factorY +'</td>';
                result_str += '<td align="center" valign="middle" class="verybigtext">' + Ad*factorY + '</td>';
            result_str += '</tr>';              
        result_str += '</table>';
    result_str += "</div>";

    result_str += "<div>";

        result_str += "<p>Step 3: Write out the numerator (top number) in decimal form keeping in mind the principals of decimals.</p>";
        result_str += '<table>';
            result_str += '<tr>';
                
                result_str += '<td align="center"><label>'+ An*factorY +'</label></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext"><b>=</b></td>';
                result_str += '<td rowspan="3" align="center" valign="middle" class="verybigtext">' + (An * factorY) / (Ad * factorY) + '</td>';
            result_str += '</tr>';
            result_str += '<tr>';
                result_str += '<td bgcolor="#000000" height="2"></td>';
            result_str += '</tr>';
            result_str += '<tr>';
                result_str += '<td align="center"><label>'+ Ad* factorY +'</label></td>';
            result_str += '</tr>';              
        result_str += '</table>';
        result_str += "<br>You go to the end of the number in this case " + An * factorY + ", and move back the number of times by the number of zeros in the denominator.";
        result_str += "<br>Since "+ Ad * factorY +" has " + Math.log10(Ad * factorY) + " zeros, you must move back " + Math.log10(Ad * factorY) + " times.";
        result_str += "<font color=red><br>Note the movement of the decimal point to the left (always to the left), depends on what you are dividing by. <br> If you are dividing by 100, move back 2 spaces, 1,000 3 spaces, 10,000 4 spaces and so on.</font><br><br>";

        var str = ((An * factorY) / (Ad * factorY)).toString();
        
        po1 = str.indexOf(".");
        str_interger = str.substring(0, po1);
        str_decimal = str.substring(po1+1);
        

        for (var i = 0; i < str.length; i++) {
            if (i == po1) {
                result_str += ".";
            }else if (i < po1) {
                result_str += str[i];
            }else if (i > po1) {
                result_str += "<b style='position:relative; top:-12px;left:7px;'>&#8630</b>";
                result_str += str[i];
            }
        }
        
    result_str += "</div>";
    $("#correct_flow_answer").html(result_str);

}
