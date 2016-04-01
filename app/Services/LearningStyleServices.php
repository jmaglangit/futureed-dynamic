<?php namespace FutureEd\Services;


use Carbon\Carbon;
use FutureEd\Models\Repository\ClassStudent\ClassStudentRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\Subscription\SubscriptionRepositoryInterface;

class LearningStyleServices {

	protected $class_student;
	protected $subscription;
	protected $student;

	public function __construct(
		ClassStudentRepositoryInterface $classStudentRepositoryInterface,
		SubscriptionRepositoryInterface $subscriptionRepositoryInterface,
		StudentRepositoryInterface $studentRepositoryInterface
	){
		$this->class_student = $classStudentRepositoryInterface;
		$this->subscription = $subscriptionRepositoryInterface;
		$this->student = $studentRepositoryInterface;
	}

	/**
	 * check current class with order subscription if needed to take lsp
	 * @param $id
	 * @return int
	 */
	public function checkRequiredLearningStyle($id){

		$learning_style = 0;
		$student_has_lsp = $this->student->getStudentLSP($id);
		$student_last_lsp = $this->student->getStudentLSPDate($id);

		//check current class with order subscription
		$classes = $this->class_student->getClassStudent($id);

		foreach ($classes as $class) {

			if ($class->classroom) {

				//get subscription
				$subscription = $this->subscription->getSubscription($class->classroom->order->subscription_id);

				if ($subscription->has_lsp > 0 && !($student_has_lsp > 0)) {

					$learning_style = $id;

				}elseif($subscription->has_lsp > 0
					&& Carbon::now()->diffInYears(Carbon::parse($student_last_lsp)) >= config('futureed.lsp_retake_year')){

					$learning_style = $id;
				}
			}
		}

		return $learning_style;
	}

}