<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\User\UserRepositoryInterface;
use FutureEd\Http\Requests\Api\StudentBackgroundImageRequest;
use FutureEd\Services\ImageServices;

class StudentBackgroundImageController extends ApiController {

	protected $student;
	protected $user;
	protected $image_service;

	public function __construct(
		StudentRepositoryInterface $studentRepositoryInterface,
		UserRepositoryInterface $userRepositoryInterface,
		ImageServices $imageServices
	){
		$this->student = $studentRepositoryInterface;
		$this->user = $userRepositoryInterface;
		$this->image_service = $imageServices;
	}

	/**
	 * Get student background image settings.
	 * @param $id
	 * @return mixed
	 */
	public function show($id){

		//get student background image
		$student_background = $this->user->getBackgroundImage(config('futureed.student'),$id);

		$response = 0;

		//if student has background image.
		if($student_background->background_image){

			$response = $student_background->background_image;

			//get image service to get background image
			$response->url = $this->image_service->getBackgroundImage($response->filename);
		}

		return $this->respondWithData($response);
	}

	/**
	 * update student background image settings.
	 * @param $id
	 * @param StudentBackgroundImageRequest $request
	 * @return mixed
	 */
	public function update($id,StudentBackgroundImageRequest $request){

		$background_image_id = $request->get('background_image_id');

		$response = $this->user->updateBackgroundImage($id,$background_image_id);

		return $this->respondWithData($response);
	}

}
