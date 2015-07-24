<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use FutureEd\Services\FileServices;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use League\Flysystem\Exception;
use League\Glide\ServerFactory;
use FutureEd\Http\Requests\Api\ImageRequest;
use PayPal\Api\Image;


class ImageController extends ApiController {

	/**
	 * @var Initialized.
	 */
	protected $file_services;

	/**
	 * @var Initialized.
	 */
	protected $file_system;

	/**
	 * Initialized.
	 * @param FileServices $fileServices
	 * @param Filesystem $filesystem
	 */
	public function __construct(
		FileServices $fileServices,
		Filesystem $filesystem
	){
		$this->file_services = $fileServices;

		$this->file_system = $filesystem;
	}


	/**
	 * Get path; Convert to stream.
	 * @return mixed
	 */
	public function getImage(){

		//type -- answer, question
		$data = Input::only('id', 'filename', 'type');

		$uploads = config('futureed.uploads');

		$return = '/' . $data['type'] . '/' . $data['id'] . '/' . $data['filename'];

		//convert local path to url path

		$server = ServerFactory::create([
			'source' => $uploads
		]);

		if(file_exists($uploads . $return)){

			$server->outputImage($return, $_GET);

		}

		return $this->respondErrorMessage(2052);
	}


	/**
	 * Delete Question Answer Image.
	 */
	public function deleteImage(ImageRequest $request){

		//get file to be deleted
		$delete_file = $request->get('delete_file');

		$delete_file = public_path() . $delete_file;

		$delete_file = $this->file_system->extension($delete_file);

		if(!(empty($delete_file))){
			$return = $this->file_services->deleteDirectory($delete_file);

			if ($return) {
				return $this->respondWithData($return);
			}
		}

		return $this->respondErrorMessage(2053);

	}

}
