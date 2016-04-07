<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;

use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use FutureEd\Services\ClientServices;
use FutureEd\Services\SubscriptionServices;
use Illuminate\Support\Facades\Input;

class ParentQuestionController extends ApiController {

	protected $question;
	protected $subscription_service;
	protected $module;
	protected $client_service;

	public function __construct(
		QuestionRepositoryInterface $questionRepositoryInterface,
		SubscriptionServices $subscriptionServices,
		ModuleRepositoryInterface $moduleRepositoryInterface,
		ClientServices $clientServices
	){
		$this->question = $questionRepositoryInterface;
		$this->subscription_service = $subscriptionServices;
		$this->module = $moduleRepositoryInterface;
		$this->client_service = $clientServices;
	}

	/**
	 * Get list of questions based on client purchase.
	 *
	 * @param $client_id
	 * @return Response
	 */
	public function getParentQuestions($client_id)
	{
		$criteria = [];
		$limit = 0;
		$offset = 0;
		$client_subscribed = 0;


		//for module_id
		if (Input::get('module_id')) {

			$criteria['module_id'] = Input::get('module_id');

			$client_subscribed = $this->client_service->checkParentModuleSubscription($client_id,Input::get('module_id'));

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


		return $this->respondWithData([
			'client_subscription' => $client_subscribed,
			'questions' => $this->question->getQuestions($criteria, $limit, $offset)
		]);
	}



}
