<?php namespace FutureEd\Http\Controllers\Api\Logs;

use FutureEd\Http\Controllers\Api\Traits\ErrorMessageTrait;
use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Http\Response;


class LogController extends Controller {

	use ErrorMessageTrait;
	/**
	 * Generate log report from the system.
	 * - User Logs
	 * - Admin Logs
	 * - Security Logs
	 */

	protected $header;

	/**
	 * @var int
	 */
	protected $status = Response::HTTP_OK;

	/**
	 * @var
	 */
	protected $information;

	/**
	 * @var
	 */
	protected $column_header;

	/**
	 * @var
	 */
	protected $rows;

	/**
	 * @var array
	 */
	public $messageBag = [];

	/**
	 * @return mixed
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * @param mixed $status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

	/**
	 * @return mixed
	 */
	public function getInformation() {
		return $this->information;
	}

	/**
	 * @param mixed $information
	 */
	public function setInformation($information) {
		$this->information = $information;
	}

	/**
	 * @return mixed
	 */
	public function getColumnHeader() {
		return $this->column_header;
	}

	/**
	 * @param mixed $column_header
	 */
	public function setColumnHeader($column_header) {
		$this->column_header = $column_header;
	}

	/**
	 * @return mixed
	 */
	public function getRows() {
		return $this->rows;
	}

	/**
	 * @param mixed $rows
	 */
	public function setRows($rows) {
		$this->rows = (array) $rows;
	}

	/**
	 * @return mixed
	 */
	public function getHeader() {
		return (array) $this->header;
	}

	/**
	 * @param mixed $header
	 */
	public function setHeader($header) {
		$this->header = $header;
	}

	/**
	 * Main response.
	 * @param $data
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function respond($data){

		return Response()->json($data,$this->getStatus(),$this->getHeader());

	}

	/**
	 * Generate success response.
	 * @param $data
	 * @return Response
	 */
	public function respondLog($data){

		return $this->respond([
			'status' => $this->getStatus(),
			'data' => $data
		]);

	}

	/**
	 * Generate log data.
	 * @param $information
	 * @param $columns
	 * @param array $rows
	 * @return Response
	 */
	public function respondLogData($information, $columns, array $rows){

		$this->setInformation($information);
		$this->setColumnHeader($columns);
		$this->setRows($rows);

		return $this->respondLog([
			'additional_information' => $this->getInformation(),
			'column_header' => $this->getColumnHeader(),
			'rows' => $this->getRows()
		]);
	}


	/**
	 * @param $message
	 * @return $this
	 */
	public function setMessageBag($message){
		$this->messageBag = $message;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getMessageBag(){
		return $this->messageBag;
	}

	/**
	 * @param $message
	 */
	public function addMessageBag($message){

		if(empty($this->messageBag) && !empty($message)){
			$this->setMessageBag([$message]);
		} elseif(!empty($message) ) {
			$this->messageBag = array_merge(
				$this->getMessageBag(),
				[$message]
			);
		}
	}

	/**
	 * @param string $message
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function respondWithError($message = 'Not Found!'){

		return $this->respond(
			[
				'status' => $this->getStatus(),
				'errors' => $message
			]
		);

	}

	/**
	 * Generate error response.
	 * @param $error_code
	 * @return Response
	 */
	public function respondErrorMessage($error_code){


		if(!is_null($error_code)){

			$return = $this->setErrorCode($error_code)
				->setMessage(trans('errors.' . $error_code))
				->errorMessageCommon();


			$this->addMessageBag($return);

			return $this->respondWithError($this->getMessageBag());
		}
	}



}
