
    function generateDivisionExpr(_num1, _num2, _num3)
    {
        strHTML = '<div class="divide_container"><div class="div_num1">' + _num1 + '</div><div class="div_num2">' + _num2 + '<span class="after_char">' + _num3 + '</span></div><div class="clr"></div></div>';
        return strHTML;
    }

    function randomDigitsOnclick(){
        randomDigits = _validateNum($("#randomDigits").prop("value"), 4);
        if(randomDigits > 5) randomDigits = 4;
        $("#randomDigits").prop("value", randomDigits);
        
        randomNumber1 = Math.floor(Math.random() * digits(randomDigits));
        
        if(randomNumber1 < _UPPER_LIMIT) randomNumber2 = Math.floor(Math.random() * randomNumber1);
        else randomNumber2 = Math.floor(Math.random() * _UPPER_LIMIT);
        if(randomNumber2 < 2) randomNumber2 = 7;
        if(randomNumber1 <= randomNumber2) randomNumber1 = 7 + Math.floor(Math.random() * randomNumber2);

        if(test_case){
            randomNumber1 = _TEST_NUM1;
            randomNumber2 = _TEST_NUM2;
            test_case = false;
        }

        $("#randomNumber1").prop("value", randomNumber1);
        $("#randomNumber2").prop("value", randomNumber2);

        $("#subject_number1_p").html(randomNumber1);
        $("#subject_number2_p").html(randomNumber2);

        $("#answerPane").html('<div id="lastDiv"></div>');
        $("#examPane").show();
        $("#lastDiv2").html("");
        $("#lastDiv3").html("");

        step_count = 0;
        real_step_count = 0;

        max_digit = getDigitsCouunt(randomNumber1) - getDigitsCouunt(randomNumber2) + 1;
        if(max_digit < 1) max_digit = 1;

        temp_val = 0;
        remainder_val = 0;
    }

    function startAnswer() {
        if($(".answer_value").length == 0) generateAnswerStep();
    }

    var retry_first_answer = 0;
    var retry_second_answer = 0;
    var retry_third_answer = 0;
    var arry_tempanswer = [];

    function generateAnswerStep() {
        retry_attempt = 0;
        if(step_count >= max_digit) { 
            generateAnswerEquation(real_step_count).insertBefore("#lastDiv");
            checkTotal();
            return;
        }

        if(step_count == 0) temp_val = (randomNumber1 + "").substring(0, getDigitsCouunt(randomNumber2));
        else temp_val = (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + step_count - 1, getDigitsCouunt(randomNumber2) + step_count);

        if(step_count > 0) 
            generateAnswerEquation(real_step_count).insertBefore("#lastDiv");

        temp_val = temp_val * 1 + remainder_val * 10;

        dropdown_var[step_count] = false;
        $(".answer_value").unbind("keydown").removeClass("inputCheck").attr("readonly", true);

        strHTML = "";
        // strHTML = generateDivisionExpr(randomNumber2, temp_val, (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + step_count));

        if(remainder_val > 0){
            $("<p>Step " + (real_step_count + 1) + ": " + "Bring down the " + step_words[max_digit - step_count - 1] + " digit</p>").insertBefore("#lastDiv");
            real_step_count++;
            generateAnswerEquation(real_step_count).insertBefore("#lastDiv");
        }

        remainder_val = 0;
        retry_first_answer = 0;
        retry_second_answer = 0;
        retry_third_answer = 0;

        $("<p>Step " + (real_step_count + 1) + ": " + ((step_count == 0)?" Begin on far left most part. ":"") + "Divide the " + step_words[max_digit - step_count - 1] + " digit</p>" + strHTML + "<p>What is the corresponding multiplication?  (Write it out, example "+randomNumber2+"x1)</p><input type=text placeholder='answer' class='first_answer inputCheck'>").insertBefore("#lastDiv");
        
        $(".inputCheck").keydown(function(event){
            if(event.keyCode == 13){
                if($(this).hasClass("first_answer")){

                    correct_answer = getCorrectAnswer();
                    console.log("correct_answer = "+ correct_answer);
                    if(retry_first_answer > 1){
                        retry_first_answer = 0;
                        if (!arry_step_count_temp[real_step_count]) {
                            console.log("2 = " + $(this).prop("value"));
                            arry_step_count_temp[real_step_count] = $(this).prop("value");
                            console.log("arry_step_count_temp[real_step_count] = " + arry_step_count_temp[real_step_count]);
                            
                        }
                        alert("Correct Answer is " + randomNumber2 + "x" + correct_answer);
                        $(this).prop("value", "" + randomNumber2 + "x" + correct_answer);
                    }
                    if(($(this).prop("value") != correct_answer + "x" + randomNumber2 + "") && ($(this).prop("value") != "" + randomNumber2 + "x" + correct_answer)) {
                        retry_first_answer++;
                        alert("That is incorrect. The correct format is " + randomNumber2 + "x4, please Retry !");
                        $(this).prop("value", "").focus();
                        return false;
                    }

                    $(this).unbind("keydown").removeClass("inputCheck").attr("readonly", true);
                    $("<p>What is the subtraction?  (Write it out, example "+temp_val+"-"+randomNumber2+")</p><input type=text placeholder='answer' class='second_answer inputCheck'>").insertBefore("#lastDiv");
                    
                    $(".inputCheck").unbind("keydown").keydown(function(event){

                        if(event.keyCode == 13){

                            if($(this).hasClass("second_answer")){
                                
                                if(retry_second_answer > 1){
                                    retry_second_answer = 0;
                                    if (!arry_sub_temp[real_step_count]) {
                                        console.log("arry_sub_temp[real_step_count] = " + $(this).prop("value"));
                                        arry_sub_temp[real_step_count] = $(this).prop("value");
                                        console.log("arry_sub_temp[real_step_count] = " + arry_sub_temp[real_step_count]);
                                        
                                    }
                                    alert("Correct Answer is " + temp_val + "-" + (randomNumber2 * correct_answer));
                                    $(this).prop("value", "" + temp_val + "-" + (randomNumber2 * correct_answer));
                                }
                                if($(this).prop("value") != "" + temp_val + "-" + (randomNumber2 * correct_answer)) {
                                    retry_second_answer++;
                                    alert("That is incorrect. The correct format is " + temp_val + "-" + randomNumber2 + ". Please Retry !");
                                    $(this).prop("value", "").focus();
                                    return false;
                                }

                                $(this).unbind("keydown").removeClass("inputCheck").attr("readonly", true);
                                $("<p>What is the difference?</p><input type=text placeholder='answer' class='third_answer inputCheck'>").insertBefore("#lastDiv");
                                
                                $(".inputCheck").unbind("keydown").keydown(function(event){

                                    if(event.keyCode == 13) {

                                        if(retry_third_answer > 1){
                                            retry_third_answer = 0;
                                            if (!arry_left_temp[real_step_count]) {
                                                console.log("arry_left_temp[real_step_count] = " + $(this).prop("value"));
                                                arry_left_temp[real_step_count] = $(this).prop("value");
                                                console.log("arry_left_temp[real_step_count] = " + arry_left_temp[real_step_count]);
                                                
                                            }
                                            alert("Correct Answer is " + (temp_val - randomNumber2 * correct_answer));
                                            $(this).prop("value", "" + (temp_val - randomNumber2 * correct_answer));
                                        }
                                        if($(this).prop("value") * 1 > (temp_val - randomNumber2 * correct_answer) * 1) {
                                            retry_third_answer++;
                                            alert("That is incorrect. Answer cannot be less than 0 or more than 18. Please retry..");
                                            $(this).prop("value", "").focus();
                                            return false;
                                        } else if($(this).prop("value") * 1 < (temp_val - randomNumber2 * correct_answer) * 1) {
                                            retry_third_answer++;
                                            alert("Oops not enough, your answer needs to be larger.");
                                            $(this).prop("value", "").focus();
                                            return false;
                                        }

                                        if($(this).hasClass("third_answer")){
                                            $(this).unbind("keydown").removeClass("inputCheck").attr("readonly", true);
                                            $("<p>What is the answer?</p><input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");

                                            $(".inputCheck").unbind("keydown").keydown(function(event){

                                                if(event.keyCode == 13) {

                                                    if($(this).hasClass("answer_value")){
                                                        correct_answer = getCorrectAnswer();
                                                        temp_answer = validateAnswer($(this), correct_answer);
                                                        
                                                        if(temp_answer == 0){
                                                            $(this).blur();
                                                            if(remainder_val * 1 > 0) $("#myModal").show();
                                                            else generateAnswerStep();
                                                        }
                                                    }
                                                }
                                            }).focus();
                                        }
                                    }
                                }).focus();
                            }
                        }
                    }).focus();
                }
            }
        }).focus();
        step_count++;
        real_step_count++;
    }

    function getCorrectAnswer() {
        correct_answer = parseInt((temp_val - (temp_val % randomNumber2)) / randomNumber2);
        remainder_val = temp_val % randomNumber2;
        return correct_answer;
    }

    function _getCorrectAnswer() {
        correct_answer = parseInt((_temp_val - (_temp_val % randomNumber2)) / randomNumber2);
        _remainder_val = _temp_val % randomNumber2;
        return correct_answer;
    }

    function dismissZero(_number) {
        _number = parseInt(_number);
        return _number;
    }

    function checkTotal() {
        $(".answer_value").unbind("keydown").removeClass("inputCheck").attr("readonly", true);
        $("<input type=text placeholder='answer' class='answer_value inputCheck'>").insertBefore("#lastDiv");
        str_answer = "";

        for(i=0; i<$(".answer_value").length; i++)
            str_answer += "" + $(".answer_value").eq(i).prop("value");

        str_answer = dismissZero(str_answer);

        _after_answer = str_answer;
        _after_remainer = "";
        if(remainder_val > 0) _after_remainer = remainder_val;

        if(remainder_val > 0) str_answer += " and remainder " + remainder_val;
        $(".inputCheck").prop("value", str_answer).attr("readonly", true).hide();

        $("<p>Answer : <input type=text class='under_line' placeholder='answer' value='" + _after_answer + "'>").insertBefore("#lastDiv");
        $("<p>Remainder : <input type=text class='under_line' placeholder='answer' value='" + _after_remainer + "'>").insertBefore("#lastDiv");

        displayTotalFlow();
        displayTotalFlow1();
    }

    function displayTotalFlow(){
        remainder_val = 0;
        real_step_count = 0;
        result = generateDivisionExpr(randomNumber2, randomNumber1, "");

        for(step_count=0; step_count<max_digit; step_count++){
            
            if(remainder_val > 0){
                result += "<p>Step " + (real_step_count + 1) + ": " + "Bring down the " + step_words[max_digit - step_count - 1] + " digit</p>";
                real_step_count++;
                result += generateAnswerEquationColor(real_step_count);
            }

            result += "<p>Step " + (real_step_count + 1) + ": " + ((step_count == 0)?" Begin on far left most part. ":"") + "Divide the " + step_words[max_digit - step_count - 1] + " digit</p>";
            if (arry_tempanswer[real_step_count + 1]) {
                result += "<label style='color:red;'> error : " + arry_tempanswer[real_step_count + 1] + "</label>";
            }
            if(remainder_val > 0){
                result += "<p class='detail_step notice'>Bring down remainder, add " + step_words[max_digit - step_count - 1] + " digit</p>";
            }

            if(step_count == 0) temp_val = (randomNumber1 + "").substring(0, getDigitsCouunt(randomNumber2));
            else temp_val = (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + step_count - 1, getDigitsCouunt(randomNumber2) + step_count);

            temp_val = temp_val * 1 + remainder_val * 10;

            remainder_val = 0;
            // strHTML = generateDivisionExpr(randomNumber2, temp_val, (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + step_count));
            // result += strHTML;
            result += "<p class='detail_step'>Divide " + temp_val + " by " + randomNumber2 + "</p>";

            result += generateAnswerEquationColor(real_step_count + 1);

            correct_answer = getCorrectAnswer();
            result += "<p class='detail_step'>Multiple " + correct_answer + " x " + randomNumber2 + " = " + (correct_answer * randomNumber2) + "</p>";
            console.log("real_step_count = " + real_step_count);
            console.log("arry_step_count_temp = "+ arry_step_count_temp[real_step_count + 1]);
            if (arry_step_count_temp[real_step_count + 1]) {
                result += "<p style='color:red'> error : " + arry_step_count_temp[real_step_count + 1] + "</p>";
            }
            result += "<p class='detail_step'>Subtract " + temp_val + " - " + (correct_answer * randomNumber2) + " = " + (temp_val - correct_answer * randomNumber2) + "</p>";
            if (arry_sub_temp[real_step_count + 1]) {
                result += "<p style='color:red'> error : " + arry_sub_temp[real_step_count + 1] + "</p>";
            }

            if (arry_left_temp[real_step_count + 1]) {
                result += "<p style='color:red'> What is the difference?</p>";
                result += "<p style='color:red'> error : " + arry_left_temp[real_step_count + 1] + "</p>";
            }
            if(remainder_val > 0) 
                result += "<p class='detail_step'>There is a remainder " + remainder_val + "</p>";

            real_step_count++;
        }

        result += "<p align=left style='text-indent:10px;'>Answer:</p>";
        result += "<p align=left style='text-indent:20px;'>" + $(".inputCheck").prop("value") + "</p>";

        $("#lastDiv2").html(result);        
    }
    function displayTotalFlow1(){
        remainder_val = 0;
        real_step_count = 0;
        result = generateDivisionExpr(randomNumber2, randomNumber1, "");

        for(step_count=0; step_count<max_digit; step_count++){
            
            if(remainder_val > 0){
                result += "<p>Step " + (real_step_count + 1) + ": " + "Bring down the " + step_words[max_digit - step_count - 1] + " digit</p>";
                real_step_count++;
                result += generateAnswerEquationColor(real_step_count);
            }

            result += "<p>Step " + (real_step_count + 1) + ": " + ((step_count == 0)?" Begin on far left most part. ":"") + "Divide the " + step_words[max_digit - step_count - 1] + " digit</p>";

            if(remainder_val > 0){
                result += "<p class='detail_step notice'>Bring down remainder, add " + step_words[max_digit - step_count - 1] + " digit</p>";
            }

            if(step_count == 0) temp_val = (randomNumber1 + "").substring(0, getDigitsCouunt(randomNumber2));
            else temp_val = (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + step_count - 1, getDigitsCouunt(randomNumber2) + step_count);

            temp_val = temp_val * 1 + remainder_val * 10;

            remainder_val = 0;
            // strHTML = generateDivisionExpr(randomNumber2, temp_val, (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + step_count));
            // result += strHTML;
            result += "<p class='detail_step'>Divide " + temp_val + " by " + randomNumber2 + "</p>";

            result += generateAnswerEquationColor(real_step_count + 1);

            correct_answer = getCorrectAnswer();
            result += "<p class='detail_step'>Multiple " + correct_answer + " x " + randomNumber2 + " = " + (correct_answer * randomNumber2) + "</p>";
            result += "<p class='detail_step'>Subtract " + temp_val + " - " + (correct_answer * randomNumber2) + " = " + (temp_val - correct_answer * randomNumber2) + "</p>";

            if(remainder_val > 0) 
                result += "<p class='detail_step'>There is a remainder " + remainder_val + "</p>";

            real_step_count++;
        }

        result += "<p align=left style='text-indent:10px;'>Answer:</p>";
        result += "<p align=left style='text-indent:20px;'>" + $(".inputCheck").prop("value") + "</p>";

        $("#lastDiv3").html(result);        
    }

    function _equation_remainder_(_min_digit, _min_value) {
        _min_digit = _min_digit + getDigitsCouunt(randomNumber2) - getDigitsCouunt(_min_value);
        _minus_html = '<div><div class="disp_pre"></div><div class="disp_post upper_line blue_text">';
        _minus_html += '<span class="space">-</span>';
        for(_min_t = 0; _min_t < _min_digit; _min_t++)
            _minus_html += '<span class="space">0</span>';
        _minus_html += _min_value + '</div></div>';
        return _minus_html;
    }

    function _equation_remainder(_min_digit, _min_value) {
        _min_digit = _min_digit + getDigitsCouunt(randomNumber2) - getDigitsCouunt(_min_value);
        _minus_html = '<div><div class="disp_pre"></div><div class="disp_post upper_line">';
        _minus_html += '<span class="space">-</span>';
        for(_min_t = 0; _min_t < _min_digit; _min_t++)
            _minus_html += '<span class="space">0</span>';
        _minus_html += _min_value + '</div></div>';
        return _minus_html;
    }

    function _equation_minus_(_min_digit, _min_value) {
        _min_digit = _min_digit + getDigitsCouunt(randomNumber2) - getDigitsCouunt(_min_value);
        _minus_html = '<div><div class="disp_pre"></div><div class="disp_post no_line blue_text">';
        for(_min_t = 0; _min_t < _min_digit; _min_t++)
            _minus_html += '<span class="space">0</span>';
        _minus_html += '-' + _min_value + '</div></div>';
        return _minus_html;
    }

    function _equation_minus(_min_digit, _min_value) {
        _min_digit = _min_digit + getDigitsCouunt(randomNumber2) - getDigitsCouunt(_min_value);
        _minus_html = '<div><div class="disp_pre"></div><div class="disp_post no_line">';
        for(_min_t = 0; _min_t < _min_digit; _min_t++)
            _minus_html += '<span class="space">0</span>';
        _minus_html += '-' + _min_value + '</div></div>';
        return _minus_html;
    }

    function _equation_question(_quest_1, _quest_2) {
        return '<div><div class="disp_pre">' + _quest_1 + '</div><div class="disp_post both_line"><span class="space">-</span>' + _quest_2 + '</div></div>';
    }

    function _equation_answer(_answer_val) {
        _minus_html = "";
        _min_digit = getDigitsCouunt(randomNumber2) - 1;
        for(_min_t = 0; _min_t < _min_digit; _min_t++)
            _minus_html += '<span class="space">0</span>';
        return '<div><div class="disp_pre"></div><div class="disp_post no_line"><span class="space">-</span>' + _minus_html + _answer_val + '</div></div>';
    }

    function generateAnswerEquation(_step_number) {
        console.log("Step Number" + _step_number);

        _strHTML = "";
        _answer_val = "";
        _real_step_count = 0;
        _remainder_val = 0;

        for(_step_count=0; _step_count < max_digit; _step_count++){
            if(_step_count == 0) _temp_val = (randomNumber1 + "").substring(0, getDigitsCouunt(randomNumber2));
            else _temp_val = (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + _step_count - 1, getDigitsCouunt(randomNumber2) + _step_count);

            if(_remainder_val > 0){                
                _real_step_count++;
                _strHTML += _equation_remainder(_step_count, _remainder_val + "" + _temp_val);
                if(_step_number <= _real_step_count) break;
            }

            _temp_val = _temp_val * 1 + _remainder_val * 10;
            _remainder_val = 0;
            
            correct_answer = _getCorrectAnswer();
            _strHTML += _equation_minus(_step_count, correct_answer * randomNumber2);

            _answer_val += correct_answer;

            _real_step_count++;
            if(_step_number <= _real_step_count){ 
                _strHTML += _equation_remainder(_step_count, _remainder_val);
                break;
            }
        }

        return $(_equation_answer(_answer_val) + _equation_question(randomNumber2, randomNumber1) + _strHTML);
    }

    function generateAnswerEquationColor(_step_number) {
        console.log("Step Number" + _step_number);

        _strHTML = "";
        _answer_val = "";
        _real_step_count = 0;
        _remainder_val = 0;

        for(_step_count=0; _step_count < max_digit; _step_count++){
            if(_step_count == 0) _temp_val = (randomNumber1 + "").substring(0, getDigitsCouunt(randomNumber2));
            else _temp_val = (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2) + _step_count - 1, getDigitsCouunt(randomNumber2) + _step_count);

            if(_remainder_val > 0){                
                _real_step_count++;

                if(_step_number <= _real_step_count){
                    _strHTML += _equation_remainder_(_step_count, _remainder_val + "" + _temp_val);
                    break;
                }

                console.log("Step :" + _step_number + ", " + _real_step_count);
                if(_step_number <= _real_step_count + 1)
                    _strHTML += _equation_remainder_(_step_count, _remainder_val + "" + _temp_val);
                else
                    _strHTML += _equation_remainder(_step_count, _remainder_val + "" + _temp_val);
            }

            _temp_val = _temp_val * 1 + _remainder_val * 10;
            _remainder_val = 0;
            
            correct_answer = _getCorrectAnswer();
            if(_step_number == _real_step_count + 1)
                _strHTML += _equation_minus_(_step_count, correct_answer * randomNumber2);
            else
                _strHTML += _equation_minus(_step_count, correct_answer * randomNumber2);

            _answer_val += correct_answer;

            _real_step_count++;
            if(_step_number <= _real_step_count){ 
                _strHTML += _equation_remainder_(_step_count, _remainder_val);
                break;
            }
        }

        if(_step_number == 1) return _equation_answer('<span style="color:red;">'+_answer_val+'</span>') + _equation_question('<span class="blue_text">'+randomNumber2+'</span>', '<span class="blue_text">'+_temp_val+'</span>' + (randomNumber1 + "").substring(getDigitsCouunt(randomNumber2))) + _strHTML;
        return _equation_answer('<span style="color:red;">'+_answer_val+'</span>') + _equation_question('<span class="blue_text">'+randomNumber2+'</span>', randomNumber1) + _strHTML;
    }

    function btnYEsOnclick(){
        $("#myModal").hide();
        if(dropdown_var[step_count - 2]) alert("Remember you drop down remainder in the previous step.");
        generateAnswerStep();
    }

    function btnNOOnclick(){
        $("#myModal").hide();
        alert("Remainder is not zero, So you must drop down remainder to the lower digits !");
        generateAnswerStep();
    }




























