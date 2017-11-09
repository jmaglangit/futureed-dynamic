<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/17
 * Time: 11:05 AM
 */

namespace FutureEd\Models\Repository\AnswerExplanationTemplate;


use FutureEd\Models\Core\AnswerExplanationTemplate;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class AnswerExplanationTemplateRepository implements AnswerExplanationTemplateRepositoryInterface{

	use LoggerTrait;

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getAnswerExplanationTemplates($criteria=[],$limit=0,$offset=0){

		$answer_explanation_template  = new AnswerExplanationTemplate();

		//template
		if(isset($criteria['template'])){
			$answer_explanation_template = $answer_explanation_template->template($criteria['template']);
		}

		//question_template_id
		if(isset($criteria['question_template_id'])){
			$answer_explanation_template = $answer_explanation_template->questionTemplateId($criteria['question_template_id']);
		}

		//status
		if(isset($criteria['status'])){
			$answer_explanation_template = $answer_explanation_template->status($criteria['status']);
		}

		$count = $answer_explanation_template->count();


		if ($offset >= 0 && $limit > 0) {

			$answer_explanation_template = $answer_explanation_template->skip($offset)->take($limit);
		}

		return [
			'total' => $count,
			'records' => $answer_explanation_template->get()
		];
	}

	/**
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getAnswerExplanationTemplate($id){

		return AnswerExplanationTemplate::find($id);
	}

	/**
	 * @param $data
	 * @return bool|static
	 */
	public function addAnswerExplanationTemplate($data){

		DB::beginTransaction();
		try{

			$response = AnswerExplanationTemplate::create($data);

		} catch(\Exception $e){

			DB::rollbacK();

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
	public function updateAnswerExplanationTemplate($id,$data){

		DB::beginTransaction();
		try{

			$response = AnswerExplanationTemplate::find($id)->update($data);

		} catch(\Exception $e){

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
	public function deleteAnswerExplanationTemplate($id){

		DB::beginTransaction();

		try{

			$response = AnswerExplanationTemplate::find($id)->delete();

		} catch(\Exception $e){

			DB::rolblack();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;

	}
}