<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/14/17
 * Time: 2:17 PM
 */

namespace FutureEd\Models\Repository\QuestionTemplate;


use FutureEd\Models\Core\QuestionTemplate;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class QuestionTemplateRepository implements QuestionTemplateRepositoryInterface{

	use LoggerTrait;

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getQuestionTemplates($criteria=[],$limit=0,$offset=0){

		$template = new QuestionTemplate();

		if(isset($criteria['equation_type'])){
			$template = $template->equationType($criteria['equation_type']);
		}

		if(isset($criteria['question_template_format'])){
			$template = $template->questionTemplateFormat($criteria['question_template_format']);
		}

		if(isset($criteria['question_equation'])){
			$template = $template->questionEquation($criteria['question_equation']);
		}

		if(isset($criteria['status'])){
			$template = $template->status($criteria['status']);
		}

		$count = $template->count();

		if ($limit > 0 && $offset >= 0) {
			$template = $template->offset($offset)->limit($limit);
		}

		$response = ['total' => $count, 'records' => $template->get()->toArray()];

		return $response;
	}

	/**
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getQuestionTemplate($id){

		return QuestionTemplate::find($id);
	}

	/**
	 * @param $data
	 * @return bool|static
	 */
	public function addQuestionTemplate($data){

		DB::beginTransaction();

		try{

			$response = QuestionTemplate::create($data);

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
	public function updateQuestionTemplate($id,$data){

		DB::beginTransaction();

		try{

			$response = QuestionTemplate::find($id)->update($data);

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
	public function deleteQuestionTemplate($id){

		DB::beginTransaction();

		try{

			$response = QuestionTemplate::find($id)->delete();

		} catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}
}