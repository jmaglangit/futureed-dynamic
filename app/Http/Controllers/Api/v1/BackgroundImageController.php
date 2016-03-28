<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Models\Repository\BackgroundImage\BackgroundImageRepositoryInterface;
use FutureEd\Services\ImageServices;
use Illuminate\Support\Facades\Input;

class BackgroundImageController extends ApiController {

	protected $background_image;
	protected $image_service;

	public function __construct(
		BackgroundImageRepositoryInterface $backgroundImageRepositoryInterface,
		ImageServices $imageServices
	){
		$this->background_image = $backgroundImageRepositoryInterface;
		$this->image_service = $imageServices;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$criteria = [];

		if (Input::get('status')) {
			$criteria['status'] = Input::get('status');
		}

		$limit = (Input::get('limit')) ? Input::get('limit') : 0;

		$offset = (Input::get('offset')) ? Input::get('offset') : 0;

		$record = $this->background_image->getBackgroundImages($criteria, $limit, $offset);

		//update with url images
		foreach ($record['records'] as $background_image) {

			if ($background_image->filename) {
				$background_image->url = $this->image_service->getBackgroundImage($background_image->filename);
			}
		}

		return $this->respondWithData($record);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$record = $this->background_image->getBackgroundImage($id);

		//update with url images
		if($record->filename){
			$record->url = $this->image_service->getBackgroundImage($record->filename);
		}

		return $this->respondWithData($record);
	}
}
