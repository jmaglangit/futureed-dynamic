<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/28/17
 * Time: 2:09 PM
 */

namespace FutureEd\Models\Repository\WordProblemDataMapping;


use FutureEd\Models\Core\WordProblemDataMapping;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class WordProblemDataMappingRepository implements WordProblemDataMappingRepositoryInterface{

	use LoggerTrait;

	/**
	 * @param $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getDatas($limit=0, $offset=0) {
		$data = new WordProblemDataMapping();

		$count = $data->count();

		if ($limit > 0 && $offset >= 0) {
			$data = $data->offset($offset)->limit($limit);;
		}

		return ['total' => $count, 'records' => $data->get()->toArray()];
	}

	/**
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getData($id) {

		return WordProblemDataMapping::find($id);
	}

	/**
	 * @param $data
	 * @return bool|static
	 */
	public function addData($data) {

		DB::beginTransaction();

		try{

			$response = WordProblemDataMapping::create($data);

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @param $data
	 * @return bool|string
	 */
	public function editData($id, $data) {

		DB::beginTransaction();

		try{
			$response='';
		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $id
	 * @return bool|null
	 */
	public function deleteData($id) {

		DB::beginTransaction();

		try{

			$response = WordProblemDataMapping::find($id)->delete();

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @return bool
	 */
	public function deleteAllData() {

		DB::beginTransaction();

		try{

			$response = WordProblemDataMapping::where('deleted_at',null)->delete();

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	/**
	 * @param $data
	 * @return bool
	 */
	public function insertDatas($data) {

		DB::beginTransaction();
		try{

			WordProblemDataMapping::insert($data);

		} catch(\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return true;
	}
}