<?php namespace FutureEd\Models\Repository\HelpRequestAnswerRating;


use FutureEd\Models\Core\HelpRequestAnswerRating;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class HelpRequestAnswerRatingRepository implements HelpRequestAnswerRatingRepositoryInterface{
	use LoggerTrait;

	/**
	 * Check student rating if exists.
	 * @param $student_id
	 * @param $help_request_answer_id
	 * @return null|string
	 *
	 */
	public function checkStudentRating($student_id,$help_request_answer_id){
		DB::beginTransaction();

		try{
			$result = HelpRequestAnswerRating::StudentId($student_id)->HelpRequestAnswerId($help_request_answer_id)->first();
			$response = is_null($result) ? null : $result->toArray();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Add Help Request Answer Rating.
	 * @param $data
	 * @return string|static
	 */
	public function addRating($data){
		DB::beginTransaction();

		try{
			$response = HelpRequestAnswerRating::create($data);
		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * Get ratings by answer id
	 * @param $help_request_answer_id
	 * @return string
	 */
	public function getRatingsByAnswerId($help_request_answer_id){
		DB::beginTransaction();

		try{
			$response = HelpRequestAnswerRating::HelpRequestAnswerId($help_request_answer_id)->get();
		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}