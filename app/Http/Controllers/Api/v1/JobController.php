<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Job\JobRepositoryInterface;
use Illuminate\Http\Request;

class JobController extends ApiController {

	protected $job;

	public function __construct(
		JobRepositoryInterface $jobRepositoryInterface
	){
		$this->job = $jobRepositoryInterface;
	}

	/**
	 * Get queued list.
	 * @return mixed
	 */
	public function getQueueList() {
		$jobs = $this->job->getQueueList();

		//TODO filter list out into readable information.
		$payloads = [];
		foreach($jobs as $job){
			$payload = json_decode($job->payload);

			$params = (array) $payload->data[1];



			$payload = [
				'artisan_command' => $payload->data[0],
				'artisan_params' => (array) $payload->data[1],
				'artisan_attempts' => $job->attempts,
				'message' => trans('messages.job_on_queue_message',[
					'command' => $payload->data[0],
					'table' => $params['--model'],
					'tagged' => ($params['--tagged']) ? trans_choice('messages.tag',2) : strtolower(trans('messages.all')),
					'language' => trans('messages.' . $params['--language']),
					'attempts' => (!$job->attempts) ? '' : trans('messages.job_on_queue_attempts',[
						'attempt' => $job->attempts
					])
				])
			];

			//form into sentence


			array_push($payloads,$payload);
		}

		return $this->respondWithData($payloads);
	}

}
