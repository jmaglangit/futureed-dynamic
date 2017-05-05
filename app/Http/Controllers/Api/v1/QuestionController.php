<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\ModuleQuestionTemplate\ModuleQuestionTemplateRepositoryInterface;
use FutureEd\Models\Repository\QuestionCache\QuestionCacheRepositoryInterface;
use Illuminate\Http\Request;
use FutureEd\Http\Requests\Api\QuestionRequest;
use Illuminate\Support\Facades\Input;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use Carbon\Carbon;

class QuestionController extends ApiController {

	protected $question;

	protected $question_cache;

	protected $module_question_template;

	protected $module;

	public function __construct(
		QuestionRepositoryInterface $question,
		QuestionCacheRepositoryInterface $questionCacheRepositoryInterface,
		ModuleRepositoryInterface $moduleRepositoryInterface,
		ModuleQuestionTemplateRepositoryInterface $moduleQuestionTemplateRepositoryInterface
	) {

		$this->question = $question;
		$this->question_cache = $questionCacheRepositoryInterface;
		$this->module = $moduleRepositoryInterface;
		$this->module_question_template = $moduleQuestionTemplateRepositoryInterface;
	}

	/**
	 * @return Display all questions.
	 */
	public function index() {

		$criteria = [];
		$limit = 0;
		$offset = 0;

		//for module_id
		if (Input::get('module_id')) {

			$criteria['module_id'] = Input::get('module_id');

			//TODO get module
			$module = $this->module->getModule(Input::get('module_id'));
		}

		//for question_type
		if (Input::get('question_type')) {

			$criteria['question_type'] = Input::get('question_type');
		}

		//for questions_text
		if (Input::get('questions_text')) {

			$criteria['questions_text'] = Input::get('questions_text');
		}

		if (Input::get('questions_id')) {
			$criteria['questions_id'] = Input::get('questions_id');
		}

		if (Input::get('last_answered_question_id')) {
			$criteria['last_answered_question_id'] = Input::get('last_answered_question_id');
		}

		if (Input::get('difficulty')) {
			$criteria['difficulty'] = Input::get('difficulty');
		}

		$criteria['status'] = config('futureed.enabled');

		if (Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if (Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		//TODO if dynamic module output dynamic questions

		if(Input::get('module_id') && $module->is_dynamic){
			//get dynamic module
			return $this->respondWithData($this->question_cache->getQuestionCaches($criteria, $limit, $offset));
		} else {
			return $this->respondWithData($this->question->getQuestions($criteria, $limit, $offset));

		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function uploadQuestionImage(QuestionRequest $request) {

		$input = $request->only('file');

		$now = Carbon::now()->timestamp;
		$return = NULL;

		//check if has images uploaded
		if ($input['file']) {
			if ($_FILES['file']['type'] != 'image/jpeg' && $_FILES['file']['type'] != 'image/png') {

				return $this->respondErrorMessage(2142);

			}

			$image_type = explode('.', $_FILES['file']['name']);

			if (count($image_type) >= 3) {

				return $this->respondErrorMessage(2146);

			}


			if ($_FILES['file']['size'] > 2 * config('futureed.question_mb')) {

				return $this->respondErrorMessage(2143);

			}

			//get image_name
			$image = $_FILES['file']['name'];

			//uploads image file
			$input['file']->move(config('futureed.question_image_path') . '/' . $now, $image);

			//return the original name of the image
			$return['image_name'] = $now . '/' . $image;
		}

		return $this->respondWithData($return);

	}

}
