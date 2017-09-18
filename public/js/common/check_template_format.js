/*check question template format if variable exist button is disable, if not enable button*/
function validateTemplateText(){
	var tempTextArea = document.getElementById('template_text');

	//enable/disable variables button
	tempTextArea.onkeyup = function(){
		var val = tempTextArea.value;

		//addition variables
		if((val.indexOf("{addends1}")) == Constants.NEGATIVE_1){
			$('button[name=btn_addends_one]').prop('disabled', false);
		}else{$('button[name=btn_addends_one]').prop('disabled', true);}

		if((val.indexOf("{addends2}")) == Constants.NEGATIVE_1){
			$('button[name=btn_addends_two]').prop('disabled', false);
		}else{$('button[name=btn_addends_two]').prop('disabled', true);}

		//subtraction variables
		if(val.indexOf("{minuend}") == Constants.NEGATIVE_1){
			$('button[name=btn_minuend]').prop('disabled', false);
		}else{ $('button[name=btn_minuend]').prop('disabled', true);}

		if(val.indexOf("{subtrahend}") == Constants.NEGATIVE_1){
			$('button[name=btn_subtrahend]').prop('disabled', false);
		}else{$('button[name=btn_subtrahend]').prop('disabled', true);}

		//multiplication variables
		if(val.indexOf("{multiplicand}") == Constants.NEGATIVE_1){
			$('button[name=btn_multiplicand]').prop('disabled', false);
		}else{$('button[name=btn_multiplicand]').prop('disabled', true);}

		if(val.indexOf("{multiplier}") == Constants.NEGATIVE_1){
			$('button[name=btn_multiplier]').prop('disabled', false);
		}else{$('button[name=btn_multiplier]').prop('disabled', true);}

		//division variables
		if(val.indexOf("{dividend}") == Constants.NEGATIVE_1){
			$('button[name=btn_dividend]').prop('disabled', false);
		}else{$('button[name=btn_dividend]').prop('disabled', true);}

		if(val.indexOf("{divisor}") == Constants.NEGATIVE_1){
			$('button[name=btn_divisor]').prop('disabled', false);
		}else{$('button[name=btn_divisor]').prop('disabled', true);}

		//fraction variables
		if(val.indexOf("{fraction_addition}") == Constants.NEGATIVE_1){
			$('button[name=btn_fraction_addition]').prop('disabled', false);
		}else{$('button[name=btn_fraction_addition]').prop('disabled', true);}

		if(val.indexOf("{fraction_subtraction}") == Constants.NEGATIVE_1){
			$('button[name=btn_fraction_subtraction]').prop('disabled', false);
		}else{$('button[name=btn_fraction_subtraction]').prop('disabled', true);}

		if(val.indexOf("{fraction_multiplication}") == Constants.NEGATIVE_1){
			$('button[name=btn_fraction_multiplication]').prop('disabled', false);
		}else{$('button[name=btn_fraction_multiplication]').prop('disabled', true);}

		if(val.indexOf("{fraction_division}") == Constants.NEGATIVE_1){
			$('button[name=btn_fraction_division]').prop('disabled', false);
		}else{$('button[name=btn_fraction_division]').prop('disabled', true);}

		if(val.indexOf("{fraction_addition_butterfly}") == Constants.NEGATIVE_1){
			$('button[name=btn_fraction_addition_butterfly]').prop('disabled', false);
		}else{$('button[name=btn_fraction_addition_butterfly]').prop('disabled', true);}

		if(val.indexOf("{fraction_subtraction_butterfly}") == Constants.NEGATIVE_1){
			$('button[name=btn_fraction_subtraction_butterfly]').prop('disabled', false);
		}else{$('button[name=btn_fraction_subtraction_butterfly]').prop('disabled', true);}

		if(val.indexOf("{fraction_addition_whole}") == Constants.NEGATIVE_1){
			$('button[name=btn_fraction_addition_whole]').prop('disabled', false);
		}else{$('button[name=btn_fraction_addition_whole]').prop('disabled', true);}

		if(val.indexOf("{fraction_subtraction_whole}") == Constants.NEGATIVE_1){
			$('button[name=btn_fraction_subtraction_whole]').prop('disabled', false);
		}else{$('button[name=btn_fraction_subtraction_whole]').prop('disabled', true);}

		//integer variables
        if(val.indexOf("{integer_sort_small}") == Constants.NEGATIVE_1){
            $('button[name=btn_integer_sort_small]').prop('disabled', false);
        }else{$('button[name=btn_integer_sort_small]').prop('disabled', true);}

        if(val.indexOf("{integer_sort_large}") == Constants.NEGATIVE_1){
            $('button[name=btn_integer_sort_large]').prop('disabled', false);
        }else{$('button[name=btn_integer_sort_large]').prop('disabled', true);}

        if(val.indexOf("{integer_addition}") == Constants.NEGATIVE_1){
            $('button[name=btn_integer_addition]').prop('disabled', false);
        }else{$('button[name=btn_integer_addition]').prop('disabled', true);}

        //btn_integer_convert_number
        if(val.indexOf("{integer_convert_number}") == Constants.NEGATIVE_1){
            $('button[name=btn_integer_convert_number]').prop('disabled', false);
        }else{$('button[name=btn_integer_convert_number]').prop('disabled', true);}

        if(val.indexOf("{integer_decimal}") == Constants.NEGATIVE_1){
            $('button[name=btn_integer_decimal]').prop('disabled', false);
        }else{$('button[name=btn_integer_decimal]').prop('disabled', true);}

        if(val.indexOf("{integer_expanded_decimal") == Constants.NEGATIVE_1){
            $('button[name=btn_integer_expanded_decimal]').prop('disabled', false);
        }else{$('button[name=btn_integer_expanded_decimal]').prop('disabled', true);}

        if(val.indexOf("{integer_extended}") == Constants.NEGATIVE_1){
            $('button[name=btn_integer_extended]').prop('disabled', false);
        }else{$('button[name=btn_integer_extended]').prop('disabled', true);}

        if(val.indexOf("{integer_counting}") == Constants.NEGATIVE_1){
            $('button[name=btn_integer_counting]').prop('disabled', false);
        }else{$('button[name=btn_integer_counting]').prop('disabled', true);}

        //integer identify variables
        if(val.indexOf("{integer_random_digit}") == Constants.NEGATIVE_1){
            $('button[name=btn_integer_random_digit]').prop('disabled', false);
        }else{$('button[name=btn_integer_random_digit]').prop('disabled', true);}

        if(val.indexOf("{integer_random_number}") == Constants.NEGATIVE_1){
            $('button[name=btn_integer_random_number]').prop('disabled', false);
        }else{$('button[name=btn_integer_random_number]').prop('disabled', true);}

        if(val.indexOf("{integer_random_number}") == Constants.NEGATIVE_1){
            $('button[name=btn_integer_random_number]').prop('disabled', false);
        }else{$('button[name=btn_integer_random_number]').prop('disabled', true);}

        if(val.indexOf("{integer_random_word}") == Constants.NEGATIVE_1){
            $('button[name=btn_integer_random_word]').prop('disabled', false);
        }else{$('button[name=btn_integer_random_word]').prop('disabled', true);}

        if((val.indexOf("{number1}")) == Constants.NEGATIVE_1){
            $('button[name=btn_number1]').prop('disabled', false);
        }else{$('button[name=btn_number1]').prop('disabled', true);}

        if((val.indexOf("{number2}")) == Constants.NEGATIVE_1){
            $('button[name=btn_number1]').prop('disabled', false);
        }else{$('button[name=btn_number1]').prop('disabled', true);}

        //integer decimal variables
        if((val.indexOf("{decimal_addends1}")) == Constants.NEGATIVE_1){
            $('button[name=btn_decimal_addends1]').prop('disabled', false);
        }else{$('button[name=btn_decimal_addends1]').prop('disabled', true);}

        if((val.indexOf("{decimal_addends2}")) == Constants.NEGATIVE_1){
            $('button[name=btn_decimal_addends2]').prop('disabled', false);
        }else{$('button[name=btn_decimal_addends2]').prop('disabled', true);}
	}
}
