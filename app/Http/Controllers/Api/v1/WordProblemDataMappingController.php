<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Requests\Api\WordProblemDataMappingRequest;
use FutureEd\Models\Repository\WordProblemDataMapping\WordProblemDataMappingRepositoryInterface;
use FutureEd\Services\ExcelServices;
use Illuminate\Support\Facades\Input;

class WordProblemDataMappingController extends ApiController {

	protected $data;

	protected $excel_services;

	public function __construct(
		WordProblemDataMappingRepositoryInterface $wordProblemDataMappingRepositoryInterface,
		ExcelServices $excelServices
	){
		$this->data = $wordProblemDataMappingRepositoryInterface;
		$this->excel_services = $excelServices;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$limit = 0;
		$offset = 0;

		if(Input::get('limit')) {
			$limit = intval(Input::get('limit'));
		}

		if(Input::get('offset')) {
			$offset = intval(Input::get('offset'));
		}

		return $this->respondWithData($this->data->getDatas($limit,$offset));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param WordProblemDataMappingRequest $request
	 * @return Response
	 */
	public function store(WordProblemDataMappingRequest $request)
	{
		return $this->respondWithData($this->data->addData($request->all()));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondWithData($this->data->getData($id));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @param WordProblemDataMappingRequest $request
	 * @return Response
	 */
	public function update($id, WordProblemDataMappingRequest $request)
	{
		return $this->respondWithData($this->data->editData($id,$request->all()));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return $this->respondWithData($this->data->deleteData($id));
	}

	/**
	 * @param WordProblemDataMappingRequest $request
	 * @return mixed
	 */
	public function wordProblemDataImport(WordProblemDataMappingRequest $request){


		$file = $request->file('file');

		//check csv file type
		if(!in_array($file->getClientMimeType(), config('futureed.accepted_csv'))){

			return $this->respondErrorMessage(2149);
		}

		$headers = [
			'data'
		];

		//start import
		$records = $this->excel_services->importCsv($file,$headers);

		$this->data->deleteAllData();

		return $this->respondWithData($this->data->insertDatas($records->toArray()));

	}
}
