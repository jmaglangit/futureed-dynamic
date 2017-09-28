<?php namespace FutureEd\Http\Controllers\FutureLesson\Student;

use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


use Illuminate\Http\Request;

class ClassModuleController extends Controller {

	protected $dynamic_question = 'student.class.module.partials.questions.dynamic.';

	/**
	*Display Module Index Page
	*/
	public function index($id = null) {
		return view('student.class.module.index')->with('id', $id);
	}

	public function contents() {
		return view('student.class.module.partials.contents.list');
	}

	public function questions() {
		return view('student.class.module.partials.questions.list');
	}

	public function view_question_message() {
		return view('student.class.module.partials.questions.message');
	}

	public function coding_module() {
		return view('student.class.module.partials.questions.coding-module');
	}

	//For trial module
	public function trial_module()
	{
		return view('student.class.module.module-index-trial');
	}

	public function trial_module_question_list()
	{
		return view('student.class.module.partials.questions.trial-question-list');
	}

	public function notepad(){
		return view('student.class.module.partials.notepad');
	}

	public function fib(){
		return view($this->dynamic_question . 'fill-in-blanks');
	}

	public function steps($steps = 0){
		$steps = 3;
		return view($this->dynamic_question . 'answer-steps')->with('steps',$steps);
	}

	public function dynamic(){
		return view($this->dynamic_question . 'dynamic');
	}

	public function addition(){
		return view($this->dynamic_question . 'dynamic-addition');
	}

	public function additionAns(){
		return view($this->dynamic_question . 'dynamic-addition-ans');
	}

	public function subtraction(){
		return view($this->dynamic_question . 'dynamic-subtraction');
	}

	public function subtractionAns(){
		return view($this->dynamic_question . 'dynamic-subtraction-ans');
	}

	public function multiplication(){
		return view($this->dynamic_question . 'dynamic-multiplication');
	}

	public function multiplicationAns(){
		return view($this->dynamic_question . 'dynamic-multiplication-ans');
	}

	public function division(){
		return view($this->dynamic_question . 'dynamic-division');
	}

	public function divisionAns(){
		return view($this->dynamic_question . 'dynamic-division-ans');
	}

	public function fraction_division(){
		return view($this->dynamic_question . 'dynamic-fraction-division');
	}

	public function fraction_division_answer(){
		return view($this->dynamic_question . 'dynamic-fraction-division-ans');
	}

	public function fraction_addition(){
		return view($this->dynamic_question . 'dynamic-fraction-addition');
	}

	public function fraction_addition_answer(){
		return view($this->dynamic_question . 'dynamic-fraction-addition-ans');
	}

	public function fraction_subtraction(){
		return view($this->dynamic_question . 'dynamic-fraction-subtraction');
	}

	public function fraction_subtraction_answer(){
		return view($this->dynamic_question . 'dynamic-fraction-subtraction-ans');
	}

	public function fraction_addition_whole(){
		return view($this->dynamic_question . 'dynamic-fraction-addition-whole');
	}

	public function fraction_addition_whole_answer() {
		return view($this->dynamic_question . 'dynamic-fraction-addition-whole-ans');
	}

	public function fraction_multiplication(){
		return view($this->dynamic_question . 'dynamic-fraction-multiplication');
	}

	public function fraction_multiplication_answer(){
		return view($this->dynamic_question . 'dynamic-fraction-multiplication-ans');
	}

	public function fraction_subtraction_butterfly(){
		return view($this->dynamic_question . 'dynamic-fraction-subtraction-butterfly');
	}

	public function fraction_subtraction_butterfly_answer(){
		return view($this->dynamic_question . 'dynamic-fraction-subtraction-butterfly-ans');
	}

	public function fraction_addition_butterfly(){
		return view($this->dynamic_question . 'dynamic-fraction-addition-butterfly');
	}

	public function fraction_addition_butterfly_ans(){
		return view($this->dynamic_question . 'dynamic-fraction-addition-butterfly-ans');
	}
	public function fraction_subtraction_whole(){
		return view($this->dynamic_question . 'dynamic-fraction-subtraction-whole');
	}

	public function fraction_subtraction_whole_answer() {
		return view($this->dynamic_question . 'dynamic-fraction-subtraction-whole-ans');
	}

	public function integer_addition(){
		return view($this->dynamic_question . 'dynamic-integer-addition');
	}

	public function integer_convert_number(){
		return view($this->dynamic_question . 'dynamic-integer-convert-number');
	}

	public function integer_sort_small(){
		return view($this->dynamic_question . 'dynamic-integer-sort-small');
	}

	public function integer_sort_large(){
		return view($this->dynamic_question . 'dynamic-integer-sort-large');
	}

	public function integer_expanded_decimal(){
		return view($this->dynamic_question . 'dynamic-integer-expanded-decimal');
	}

	public function integer_decimal(){
		return view($this->dynamic_question.'dynamic-integer-decimal');
	}

	public function integer_extended(){
		return view($this->dynamic_question.'dynamic-integer-extended');
	}

	public function integer_identify(){
		return view($this->dynamic_question.'dynamic-integer-identify');
	}

	public function integer_rounding_number(){
		return view($this->dynamic_question.'dynamic-integer-rounding-number');
	}

	public function integer_regroup(){
		return view($this->dynamic_question.'dynamic-integer-regroup');
	}

	public function decimal_addition(){
		return view($this->dynamic_question.'dynamic-decimal-addition');
	}

	public function integer_counting(){
		return view($this->dynamic_question.'dynamic-integer-counting');
	}

	public function decimal_compare(){
		return view($this->dynamic_question.'dynamic-decimal-compare');
	}

	public function decimal_numeric() {
		return view($this->dynamic_question . 'dynamic-decimal-numeric');
	}

	public function decimal_understand(){
		return view($this->dynamic_question.'dynamic-decimal-understand');
	}

	public function fraction_decimal(){
		return view($this->dynamic_question.'dynamic-fraction-decimal');
	}

	public function decimal_fraction(){
		return view($this->dynamic_question . 'dynamic-decimal-fraction');
	}

	public function decimal_words(){
		return view($this->dynamic_question.'dynamic-decimal-words');
	}

	public function decimal_subtraction(){
		return view($this->dynamic_question.'dynamic-decimal-subtraction');
	}

	public function decimal_rational_number(){
		return view($this->dynamic_question.'dynamic-decimal-rational-number');
	}

}