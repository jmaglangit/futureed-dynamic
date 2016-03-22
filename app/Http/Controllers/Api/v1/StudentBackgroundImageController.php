<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Http\Requests\Api\StudentBackgroundImageRequest;

class StudentBackgroundImageController extends Controller {

	protected $student;
	protected $user;

	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		UserRepositoryInterface $userRepositoryInterface
	){
		$this->student = $studentRepositoryInterface;
		$this->user = $userRepositoryInterface;
	}

	//get student background image settings.
	public function show($id){

		//get student background image
		$student_background = $this->user->getBackgroundImage(config('futureed.student'),$id);

		dd($student_background);
		//translate the image

	}

	//update student background image settings.
	public function edit(StudentBackgroundImageRequest $request){


	}

}
