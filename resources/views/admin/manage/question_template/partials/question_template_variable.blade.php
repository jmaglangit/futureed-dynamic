<div class="col-xs-8">
    <div class="admin-search-module" ng-if="template.record.operation == futureed.ADDITION">
        <div class="col-xs-4 admin-search-module">
            {!! Form::button(trans('messages.addends_one')
                ,array(
                     'class' => 'btn btn-blue'
                    , 'name' => 'btn_addends1'
                    , 'ng-click' => 'template.actionButtons(futureed.ADDENDS1)'
                )
            )!!}
        </div>
        <div class="col-xs-4 admin-search-module">
            {!! Form::button(trans('messages.addends_two')
                ,array(
                     'class' => 'btn btn-blue'
                    , 'name' => 'btn_addends2'
                    , 'ng-click' => 'template.actionButtons(futureed.ADDENDS2)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.SUBTRACTION">
        <div class="col-xs-4 admin-search-module">
            {!! Form::button(trans('messages.minuend')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_minuend'
                    , 'ng-click' => 'template.actionButtons(futureed.MINUEND)'
                )
            )!!}
        </div>
        <div class="col-xs-4 admin-search-module">
            {!! Form::button(trans('messages.subtrahend')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_subtrahend'
                    , 'ng-click' => 'template.actionButtons(futureed.SUBTRAHEND)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.MULTIPLICATION">
        <div class="col-xs-4 admin-search-module">
            {!! Form::button(trans('messages.multiplicand')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_multiplicand'
                    , 'ng-click' => 'template.actionButtons(futureed.MULTIPLICAND)'
                )
            )!!}
        </div>
        <div class="col-xs-4 admin-search-module">
            {!! Form::button(trans('messages.multiplier')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_multiplier'
                    , 'ng-click' => 'template.actionButtons(futureed.MULTIPLIER)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.DIVISION">
        <div class="col-xs-4 admin-search-module">
            {!! Form::button(trans('messages.dividend')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_dividend'
                    , 'ng-click' => 'template.actionButtons(futureed.DIVIDEND)'
                )
            )!!}
        </div>
        <div class="col-xs-4 admin-search-module">
            {!! Form::button(trans('messages.divisor')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_divisor'
                    , 'ng-click' => 'template.actionButtons(futureed.DIVISOR)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_ADDITION">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_fraction')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_fraction_addition'
                    , 'ng-click' => 'template.actionButtons(futureed.FRACTION_ADDITION)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_SUBTRACTION">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_fraction')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_fraction_subtraction'
                    , 'ng-click' => 'template.actionButtons(futureed.FRACTION_SUBTRACTION)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_MULTIPLICATION">
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_fraction')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_fraction_multiplication'
                    , 'ng-click' => 'template.actionButtons(futureed.FRACTION_MULTIPLICATION)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_DIVISION">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_fraction')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_fraction_division'
                    , 'ng-click' => 'template.actionButtons(futureed.FRACTION_DIVISION)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_ADDITION_BUTTERFLY">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_fraction')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_fraction_addition_butterfly'
                    , 'ng-click' => 'template.actionButtons(futureed.FRACTION_ADDITION_BUTTERFLY)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_SUBTRACTION_BUTTERFLY">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_fraction')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_fraction_subtraction_butterfly'
                    , 'ng-click' => 'template.actionButtons(futureed.FRACTION_SUBTRACTION_BUTTERFLY)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_ADDITION_WHOLE">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_fraction')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_fraction_addition_whole'
                    , 'ng-click' => 'template.actionButtons(futureed.FRACTION_ADDITION_WHOLE)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_SUBTRACTION_WHOLE">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_fraction')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_fraction_subtraction_whole'
                    , 'ng-click' => 'template.actionButtons(futureed.FRACTION_SUBTRACTION_WHOLE)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_SORT_SMALL">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_integer')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_integer_sort_small'
                    , 'ng-click' => 'template.actionButtons(futureed.INTEGER_SORT_SMALL)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_SORT_LARGE">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_integer')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_integer_sort_large'
                    , 'ng-click' => 'template.actionButtons(futureed.INTEGER_SORT_LARGE)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_ADDITION">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_integer')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_integer_addition'
                    , 'ng-click' => 'template.actionButtons(futureed.INTEGER_ADDITION)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_CONVERT_NUMBER">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_integer')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_integer_convert_number'
                    , 'ng-click' => 'template.actionButtons(futureed.INTEGER_CONVERT_NUMBER)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_DECIMAL">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_integer')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_integer_decimal'
                    , 'ng-click' => 'template.actionButtons(futureed.INTEGER_DECIMAL)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_EXPANDED_DECIMAL">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_integer')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_integer_expanded_decimal'
                    , 'ng-click' => 'template.actionButtons(futureed.INTEGER_EXPANDED_DECIMAL)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_EXTENDED">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_integer')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_integer_extended'
                    , 'ng-click' => 'template.actionButtons(futureed.INTEGER_EXTENDED)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_ROUNDING_NUMBER">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_word')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_integer_random_word'
                    , 'ng-click' => 'template.actionButtons(futureed.INTEGER_RANDOM_WORD)'
                )
            )!!}
        </div>
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_number')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_integer_random_number'
                    , 'ng-click' => 'template.actionButtons(futureed.INTEGER_RANDOM_NUMBER)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_REGROUP">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.number_one')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_number1'
                    , 'ng-click' => 'template.actionButtons(futureed.NUMBER1)'
                )
            )!!}
        </div>
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.number_two')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_number2'
                    , 'ng-click' => 'template.actionButtons(futureed.NUMBER2)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_COUNTING">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_integer')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_integer_counting'
                    , 'ng-click' => 'template.actionButtons(futureed.INTEGER_COUNTING)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_IDENTIFY">
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_integer_random_digit')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_integer_random_digit'
                    , 'ng-click' => 'template.actionButtons(futureed.INTEGER_RANDOM_DIGIT)'
                )
            )!!}
        </div>
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_integer_random_number')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_integer_random_number'
                    , 'ng-click' => 'template.actionButtons(futureed.INTEGER_RANDOM_NUMBER)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.DECIMAL_ADDITION">
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.addends_one')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_addends1'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_ADDENDS1)'
                )
            )!!}
        </div>
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.addends_two')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_addends2'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_ADDENDS2)'
                )
            )!!}
        </div>
    </div>

    <div class="admin-search-module" ng-if="template.record.operation == futureed.DECIMAL_COMPARE">
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_decimal1')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_random_number1'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_RANDOM_NUMBER1)'
                )
            )!!}
        </div>
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_decimal2')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_random_number2'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_RANDOM_NUMBER2)'
                )
            )!!}
        </div>
    </div>

    <div class="admin-search-module" ng-if="template.record.operation == futureed.DECIMAL_NUMERIC">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_word')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_random_word'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_RANDOM_WORD)'
                     )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.DECIMAL_UNDERSTAND">
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_integer_random_digit')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_random_digit'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_RANDOM_DIGIT)'
                )
            )!!}
        </div>
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_decimal')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_random_number'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_RANDOM_NUMBER)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_DECIMAL">
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_number')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_fraction_decimal_numerator'
                    , 'ng-click' => 'template.actionButtons(futureed.FRACTION_DECIMAL_NUMERATOR)'
                )
            )!!}
        </div>
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_decimal')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_fraction_decimal_denominator'
                    , 'ng-click' => 'template.actionButtons(futureed.FRACTION_DECIMAL_DENOMINATOR)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.DECIMAL_FRACTION">
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_add_number')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_fraction'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_FRACTION)'
                )
            )!!}
        </div>
    </div>

    <div class="admin-search-module" ng-if="template.record.operation == futureed.DECIMAL_WORDS">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_decimal')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_words'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_WORDS)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.DECIMAL_SUBTRACTION">
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_decimal_minuend')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_minuend'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_MINUEND)'
                )
            )!!}
        </div>
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_decimal_subtrahend')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_subtrahend'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_SUBTRAHEND)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.DECIMAL_RATIONAL_NUMBER">
        <div class="col-xs-5 admin-search-module">
            {!! Form::button(trans('messages.admin_template_decimal')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_rational_number'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_RATIONAL_NUMBER)'
                )
            )!!}
        </div>
    </div>
    <div class="admin-search-module" ng-if="template.record.operation == futureed.DECIMAL_MULTIPLICATION">
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_decimal_multiplicand')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_multiplicand'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_MULTIPLICAND)'
                )
            )!!}
        </div>
        <div class="col-xs-6 admin-search-module">
            {!! Form::button(trans('messages.admin_template_decimal_multiplier')
                ,array(
                    'class' => 'btn btn-blue'
                    , 'name' => 'btn_decimal_multiplier'
                    , 'ng-click' => 'template.actionButtons(futureed.DECIMAL_MULTIPLIER)'
                )
            )!!}
        </div>
    </div>
    <div class="col-xs-2"></div>
</div>