<?php
namespace FutureEd\Models\Repository\StudentLsAnswer;

use FutureEd\Models\Core\StudentLsAnswer;
use League\Flysystem\Exception;


class StudentLsAnswerRepository implements StudentLsAnswerRepositoryInterface {


	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addAnswer($data) {

		try {
			
			$existing_answer = StudentLsAnswer::student_id($data['student_id'])->test_id($data['ls_test_id'])->test_question_id($data['ls_test_question_id'])->first();

			if($existing_answer) {
				
				$existing_answer->student_id = $data['student_id'];
				$existing_answer->ls_test_id = $data['ls_test_id'];
				$existing_answer->ls_section_id = $data['ls_section_id'];
				$existing_answer->ls_seq_no = $data['ls_seq_no'];
				$existing_answer->ls_test_question_id = $data['ls_test_question_id'];
				$existing_answer->ls_question_code_id = $data['ls_question_code_id'];
				$existing_answer->ls_question_code_detail_id = $data['ls_question_code_detail_id'];
				$existing_answer->ls_question_answer_id = $data['ls_question_answer_id'];
				$existing_answer->ls_answer_text = $data['ls_answer_text'];
				$existing_answer->ls_raw_score = $data['ls_raw_score'];
				
				$existing_answer->save();
				
				$student_ls_answer = $existing_answer;
				
			} else {
				$student_ls_answer = StudentLsAnswer::create($data);
			}
		
		} catch(Exception $e) {

			return $e->getMessage();

		}

		return $student_ls_answer;

	}


}