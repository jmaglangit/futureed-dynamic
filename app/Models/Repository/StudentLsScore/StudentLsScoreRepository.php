<?php
namespace FutureEd\Models\Repository\StudentLsScore;

use FutureEd\Models\Core\StudentLsScore;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;
use League\Flysystem\Exception;


class StudentLsScoreRepository implements StudentLsScoreRepositoryInterface {

	use LoggerTrait;

	/**
	 * Add record in storage
	 * @param $data
	 * @return object
	 */
	public function addScore($data) {

		DB::beginTransaction();

		try {
			
			$existing_score = StudentLsScore::student_id($data['student_id'])->test_id($data['ls_test_id'])->name($data['ls_name'])->first();
						
			if($existing_score) {
				
				$existing_score->ls_group = $data['ls_group'];
				$existing_score->ls_seq_no = $data['ls_seq_no'];
				$existing_score->ls_std_score = $data['ls_std_score'];
				$existing_score->ls_percentile = $data['ls_percentile'];
				$existing_score->ls_banding = $data['ls_banding'];
				
				$existing_score->save();
				
				$student_ls_score = $existing_score;
				
			} else {
				$student_ls_score = StudentLsScore::create($data);
			}
		
		} catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $student_ls_score;
	}


}