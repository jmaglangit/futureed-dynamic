<?php namespace FutureEd\Http\Controllers\Api\Logs;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Http\Response;


class LogController extends Controller {

	/**
	 * Generate log report from the system.
	 * - User Logs
	 * - Admin Logs
	 * - Security Logs
	 */

	protected $header;

	protected $status = Response::HTTP_OK;

	protected $information;

	protected $column_header;

	protected $rows;

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
	 * Generate error response.
	 * @param $error_code
	 * @return Response
	 */
	public function respondErrorMessage($error_code){

		return $this->respond(
			[
				'status' => $this->getStatus(),
				'errors' => config('futureed-error.error_messages.'. $error_code)
			]
		);
	}

}
