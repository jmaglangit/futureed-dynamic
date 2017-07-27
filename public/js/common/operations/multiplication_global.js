/**
 * Code from client
 * 20170727
 */

var retry_attempt = 0;
var retry_attempt_limit = 3;
var _start_num = 0;
var _end_num = 19;

var step_words = ["ones", "tens", "hundreds", "thousands", "ten thousands", "hundred thousands", "millions", "ten millions"];

// function for Get Digits Length
function getDigitsCouunt(_number){  
    if(_number == 0) return 1;
    _digitsCount = 0;

    while(_number >= 1){
        _number = _number / 10;
        _digitsCount ++;
    }

    return _digitsCount;
}

// function for validate number
function _validateNum(_num, _default_num) {
	_num = parseInt(_num);
	if(isNaN(_num)) _num = _default_num;
	return _num;
}

// function to get 10^_digits
function digits(_digits) {
	_digits = _validateNum(_digits, 4);
	_a = 1;
	for (_i = 0; _i < _digits; _i++) {
		_a *= 10;
	}
	return _a;
}

// get digit at position in number, _digitPosition is 1-index
function getDigitNum(_checkNumber, _digitPosition) {
	_checkNumber = _validateNum(_checkNumber, 1000);
	_digitPosition = _validateNum(_digitPosition, 0);
	_digitPosition--;

	_checkNumber = parseInt(((_checkNumber - _checkNumber % digits(_digitPosition)) / digits(_digitPosition)) % 10);
	return _checkNumber;
}

// error handler function
function _errorHandler(_elem, _err_num, _err_description) {
	alert( _err_description );
	if(_err_num != -5) retry_attempt++;
	_elem.prop("value", "").focus();
	return _err_num;
}

// Check Validate Answer for alphabet, number range, 0: correct, -1: alphabet, -2: not in number range, -3: less than correct_answer, -4: more than correct_answer
function validateAnswer(_elem, _correct_answer) {
	_correct_answer = _validateNum(_correct_answer, 0);

	if( retry_attempt > retry_attempt_limit ) {
		retry_attempt = 0;										return _errorHandler(_elem, -5, "Correct Answer is " + _correct_answer + ". Retry! ");
	}    	

	_answer = parseInt(_elem.prop("value"));

	console.log("Correct Answer: " + _correct_answer + ", Answered Answer: " + _elem.prop("value"));

	
	if(isNaN(_answer))											return _errorHandler(_elem, -1, "Answer can't be alphabet !");

	_elem.prop("value", _answer);
	if((_answer * 1 < _start_num) || (_answer * 1 > _end_num))	return _errorHandler(_elem, -2, "Answer can't less than " + _start_num + " or more than " + _end_num + " !");
	if(_answer < _correct_answer)								return _errorHandler(_elem, -3, "opps not enough, your answer needs to be larger.");
	if(_answer > _correct_answer)								return _errorHandler(_elem, -4, "Your answer is larger than what we need.");

	return 0;
}

// Check Validate Answer for alphabet, number range, 0: correct, -1: alphabet, -2: not in number range, -3: less than correct_answer, -4: more than correct_answer
function validateAnswer4Substraction(_elem, _correct_answer) {
	_correct_answer = _validateNum(_correct_answer, 0);

	if( retry_attempt > retry_attempt_limit ) {
		retry_attempt = 0;										return _errorHandler(_elem, -5, "Correct Answer is " + _correct_answer + ". Retry! ");
	}    	

	_answer = parseInt(_elem.prop("value"));

	console.log("Correct Answer: " + _correct_answer + ", Answered Answer: " + _elem.prop("value"));

	
	if(isNaN(_answer))											return _errorHandler(_elem, -1, "Answer can't be alphabet !");

	_elem.prop("value", _answer);
	if((_answer * 1 < _start_num) || (_answer * 1 > _end_num))	return _errorHandler(_elem, -2, "Answer can't less than " + _start_num + " or more than " + _end_num + " !");
	if(step_count > 1)
		if(borrow_var[step_count - 2]){
			if((_answer == _correct_answer + 1)||(_answer == _correct_answer - 9))
																return _errorHandler(_elem, -5, "Remember you borrowed 1 in the previous step.");
		}

	if(_answer < _correct_answer)								return _errorHandler(_elem, -3, "opps not enough, your answer needs to be larger.");    	
	if(_answer > _correct_answer)								return _errorHandler(_elem, -4, "Your answer is larger than what we need.");

	return 0;
}