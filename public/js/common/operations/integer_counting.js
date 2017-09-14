/**
 * Code from client
 * 20170808
 */
var arrAnswer = [];
var arrYourAnswer = [];
var clickStart = false;
var randomNumber = "";
var step_count = 0;
var answered = []; //ADDED

// start ADDED functions
//getter and setter
function setRandomDigits(digit){
    randomDigits = digit;
}

function getRandomNumber(){
   return '<div class="margin-top-10">' + generateMo(randomNumber, -1) + '</div>';
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


function generateMo(_num, _snum){
    strHTML = '<div class="mo_pre">'+((_snum != -1)?" ":"")+'</div>';
    for(i=0; i<_num-1; i++) strHTML += '<div class="mo_inner">'+((_snum != -1)?_snum+i+1:"")+'</div>';
    strHTML += '<div class="mo_last">'+((_snum != -1)?_snum+i+1:"")+'</div>';
    return strHTML;
}

function randomDigitsOnclick(){
    randomNumber = Math.round(Math.random() * 39) + 3;
    arrAnswer[0] = (randomNumber - randomNumber % 10) / 10;
    arrAnswer[1] = randomNumber % 10;
    arrAnswer[2] = arrAnswer[1];
    arrAnswer[3] = arrAnswer[0];
    arrAnswer[4] = randomNumber;
    arrYourAnswer = [];
    // $("#randomNumber").prop("value", randomNumber);
    clickStart = true;
}

function startAnswer(){
    if(randomNumber == "") return false;
    if(!clickStart) return false;
    clickStart = false;
    $("#subject_number").html(randomNumber);

    // $("#answerPane").html('<div>Count the squares and fill in the equation</div>' + generateMo(randomNumber, -1) + '<br><div>Write out answer as number</div><div id="lastDiv1"></div>');
    $("#answerPane").html('<div>Write out answer as number</div><div id="lastDiv1"></div>');
    $("#examPane").show();
    $("#lastDiv2").html("");
    $("#lastDiv3").html("");

    step_count = 0;

    playAnswer();
}

function generateAnswerFlow(){
    answerDone();   //added

    strMo = "";
    for(ii=0; ii<arrAnswer[0]; ii++){
        strMo += generateMo(10, 10*ii) + "<br><br>";
    }

    strMo += generateMo(arrAnswer[1], 10 * arrAnswer[0]) + "<br><br>";

    $("#lastDiv2").html(strMo);
    $("#lastDiv3").html(strMo);

    strHTML = "<br><br><span>Step 1: How many Tens?</span><span class='answerSpan'>"+arrAnswer[0]+"</span>";
    if(arrYourAnswer[0] != arrAnswer[0])
        strHTML += "<p style='color:red;'> Error : " + arrYourAnswer[0] + "</p>";
    strHTML += "<br><span>Count the blocks, if you get to 10, that means you have a tens.</span>";
    strHTML += "<br><span>In this case we have "+randomNumber+" blocks which is "+arrAnswer[0]+" tens</span>";
    strHTML += "<br><br><span>Step 2: How many Ones?</span><span class='answerSpan'>"+arrAnswer[1]+"</span>";
    if(arrYourAnswer[1] != arrAnswer[1])
                strHTML += "<p style='color:red;'> Error : " + arrYourAnswer[1] + "</p>";
    strHTML += "<br><span>There are "+arrAnswer[1]+" ones</span>";
    strHTML += "<br><br><span>Step 3:  Answer : </span><span class='answerSpan'>"+arrAnswer[2]+"</span> Ones + ";
    strHTML += "<span class='answerSpan'>"+arrAnswer[3]+"</span> Tens = ";
    strHTML += "<span class='answerSpan'>"+arrAnswer[4]+"</span>";
    if(arrYourAnswer[2] != arrAnswer[2])
                strHTML += "<p style='color:red;'> Error : " + arrYourAnswer[2] + "</p>";
    if(arrYourAnswer[3] != arrAnswer[3])
                strHTML += "<p style='color:red;'> Error : " + arrYourAnswer[3] + "</p>";
    if(arrYourAnswer[4] != arrAnswer[4])
                strHTML += "<p style='color:red;'> Error : " + arrYourAnswer[4] + "</p>";
    strHTML += "<br><span>Now add them together to get "+randomNumber+"</span>";
    

    $("#lastDiv2").html($("#lastDiv2").html() + strHTML);

    generateCorrectAnswerFlow();
}

function generateCorrectAnswerFlow(){
    strHTML = "<br><br><span>Step 1: How many Tens?</span><span class='answerSpan'>"+arrAnswer[0]+"</span>";
    strHTML += "<br><span>Count the blocks, if you get to 10, that means you have a tens.</span>";
    strHTML += "<br><span>In this case we have "+randomNumber+" blocks which is "+arrAnswer[0]+" tens</span>";
    strHTML += "<br><br><span>Step 2: How many Ones?</span><span class='answerSpan'>"+arrAnswer[1]+"</span>";
    strHTML += "<br><span>There are "+arrAnswer[1]+" ones</span>";
    strHTML += "<br><br><span>Step 3:  Answer : </span><span class='answerSpan'>"+arrAnswer[2]+"</span> Ones + ";
    strHTML += "<span class='answerSpan'>"+arrAnswer[3]+"</span> Tens = ";
    strHTML += "<span class='answerSpan'>"+arrAnswer[4]+"</span>";
    strHTML += "<br><span>Now add them together to get "+randomNumber+"</span>";

    $("#lastDiv3").html($("#lastDiv3").html() + strHTML);
}

function playAnswer()
{
    retry_attempt = 0;
    if(step_count == 0){
        $("<br><span>Step 1: How many Tens?</span><input type=text class='answerTxt'>").insertBefore("#lastDiv1");
        $(".answerTxt").keydown(function(e){
            if(e.keyCode == 13){
                if(arrYourAnswer.length == step_count) arrYourAnswer[step_count] = $(this).prop("value");
                else if(arrYourAnswer[step_count] == "") arrYourAnswer[step_count] = $(this).prop("value");
                chk_answer = validateAnswer4Sort($(this), arrAnswer[$(".answerTxt").index($(this))], 0, 9);
                if(chk_answer != 0) return false;
                $(this).attr("readonly", true);
                step_count++;
                retry_attempt = 0;
                playAnswer();
            }
        }).focus();
    } else if(step_count == 1){
        $("<br><br><span>Step 2: How many Ones?</span><input type=text class='answerTxt'>").insertBefore("#lastDiv1");
        $(".answerTxt").keydown(function(e){
            if(e.keyCode == 13){
                if(arrYourAnswer.length == step_count) arrYourAnswer[step_count] = $(this).prop("value");
                else if(arrYourAnswer[step_count] == "") arrYourAnswer[step_count] = $(this).prop("value");
                chk_answer = validateAnswer4Sort($(this), arrAnswer[$(".answerTxt").index($(this))], 0, 9);
                if(chk_answer != 0) return false;
                $(this).attr("readonly", true);
                step_count++;
                retry_attempt = 0;
                playAnswer();
            }
        }).focus();
    } else if(step_count == 2){
        $("<br><br><span>Step 3:  Answer <input type=text class='answerTxt'> Ones + <input type=text class='answerTxt'> Tens = <input type=text class='answerTxt'></span>").insertBefore("#lastDiv1");
        $(".answerTxt").keydown(function(e){
            if(e.keyCode == 13){
                if(arrYourAnswer.length == $(".answerTxt").index($(this))) arrYourAnswer[$(".answerTxt").index($(this))] = $(this).prop("value");
                else if(arrYourAnswer[$(".answerTxt").index($(this))] == "") arrYourAnswer[$(".answerTxt").index($(this))] = $(this).prop("value");
                chk_answer = validateAnswer4Sort($(this), arrAnswer[$(".answerTxt").index($(this))], 0, ($(".answerTxt").index($(this))==4?100:9));
                if(chk_answer != 0) return false;
                $(this).attr("readonly", true);
                retry_attempt = 0;
                if($(".answerTxt").index($(this)) < 4) $(".answerTxt").eq($(".answerTxt").index($(this))+1).focus();
                else generateAnswerFlow();
            }
        }).eq(2).focus();
    }
    
}

// Check Validate Answer for alphabet, number range, 0: correct, -1: alphabet, -2: not in number range, -3: less than correct_answer, -4: more than correct_answer
function validateAnswer4Sort(_elem, _correct_answer, __start_num, __end_num) {
    _correct_answer = _validateNum(_correct_answer, 0);

    if( retry_attempt > retry_attempt_limit ) {
        retry_attempt = 0;                                      return _errorHandler(_elem, -5, "The correct answer is " + _correct_answer + ". Please retry. ");
    }       

    _answer = parseInt(_elem.prop("value"));
    setAnswered(_answer);    //added
            
    if(isNaN(_answer))                                          return _errorHandler(_elem, -1, "That is incorrect. Answer cannot be blank and can only be numbers. Please retry.");

    _elem.prop("value", _answer);
    if((_answer * 1 < __start_num) || (_answer * 1 > __end_num))    {
        return _errorHandler(_elem, -2, "Answer can't less than " + __start_num + " or more than " + __end_num + " !");
    }
    if(_answer < _correct_answer) {
        return _errorHandler(_elem, -3, "Oops not enough, your answer needs to be larger.");
    }                               

    if(_answer > _correct_answer) {
        return _errorHandler(_elem, -4, "Your answer is larger than what we need.");
    }

    return 0;
}