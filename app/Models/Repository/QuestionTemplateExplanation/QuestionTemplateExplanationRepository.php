<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 6/28/17
 * Time: 11:15 AM
 */

namespace FutureEd\Models\Repository\QuestionTemplateExplanation;

use FutureEd\Models\Core\QuestionTemplateExplanation;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class QuestionTemplateExplanationRepository implements QuestionTemplateExplanationRepositoryInterface {

	use LoggerTrait;

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getQuestionTemplateExplanations($criteria=[], $limit=0, $offset=0){

		//id, question_template_id, explanation,

		$explanation = new QuestionTemplateExplanation();

		if(isset($criteria['question_template_id'])){
			$explanation = $explanation->where('question_template_id',$criteria['question_template_id']);
		}

		if(isset($criteria['explanation'])){
			$explanation = $explanation->where('explanation',$criteria['explanation']);
		}

		$count = $explanation->count();

		if($limit > 0 && $offset >= 0){
			$explanation = $explanation->offset($offset)->limit($limit);
		}

		$response = ['total' => $count, 'records' => $explanation->get()->toArray()];

		return $response;
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function getQuestionTemplateExplanation($id){

		return QuestionTemplateExplanation::where('id',$id)->get();
	}

	public function getQuestionTemplateExplanationByTemplateId($template_id){

		return QuestionTemplateExplanation::where('question_template_id',$template_id)->get()->first();
	}

	/**
	 * @param $data
	 * @return bool|static
	 */
	public function addQuestionTemplateExplanation($data){

		DB::beginTransaction();

		try{

			$response = QuestionTemplateExplanation::create($data);

		} catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @param $data
	 * @return bool|int
	 */
	public function updateQuestionTemplateExplanation($id, $data){

		DB::beginTransaction();

		try{

			$response = QuestionTemplateExplanation::find($id)->update($data);

		} catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function updateQuestionTemplateExplanationByTemplateId($template_id,$data){
		//NOTE: question_template and question_template_explanation is 1:1

		DB::beginTransaction();

		try{

			$response = QuestionTemplateExplanation::where('question_template_id',$template_id)
				->update($data);

			if($response == 0){
				$response = $this->addQuestionTemplateExplanation([
					'question_template_id' => $template_id,
					'explanation' => $data['explanation']
				]);
			} else {
				$response = $this->getQuestionTemplateExplanationByTemplateId($template_id);
			}

		} catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();


		return $response;
	}

	/**
	 * @param $id
	 * @return bool|null
	 */
	public function deleteQuestionTemplateExplanation($id){

		DB::beginTransaction();

		try{

			$response = QuestionTemplateExplanation::find($id)->delete();

		} catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}
}