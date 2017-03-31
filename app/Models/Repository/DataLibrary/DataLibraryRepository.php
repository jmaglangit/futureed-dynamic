<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/15/17
 * Time: 3:32 PM
 */

namespace FutureEd\Models\Repository\DataLibrary;


use FutureEd\Models\Core\DataLibrary;
use Illuminate\Support\Facades\DB;

class DataLibraryRepository implements DataLibraryRepositoryInterface {

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getDataLibraries($criteria=[],$limit=0,$offset=0){

		$data_library = new DataLibrary();

		if(isset($criteria['object_type'])){
			$data_library = $data_library->objectType($criteria['object_type']);
		}

		if(isset($criteria['object_name'])){
			$data_library = $data_library->objectName($criteria['object_name']);
		}

		if(isset($criteria['status'])){
			$data_library = $data_library->status($criteria['status']);
		}

		$count = $data_library->count();

		if ($offset >= 0 && $limit > 0) {

			$data_library = $data_library->skip($offset)->take($limit);
		}

		return ['total' => $count, 'records' => $data_library->get()->toArray()];
	}

	/**
	 * @param $id
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function getDataLibrary($id){

		return DataLibrary::find($id);
	}

	/**
	 * @param $data
	 * @return bool|static
	 */
	public function addDataLibrary($data){

		try{

			$response = DataLibrary::create($data);

		}catch (\Exception $e){

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
	 * @return bool|int
	 */
	public function updateDataLibrary($id,$data){

		try{

			$response = DataLibrary::find($id)->update($data);

		}catch (\Exception $e){

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
	public function deleteDataLibrary($id){

		DB::beginTransaction();

		try{

			$response = DataLibrary::find($id)->delete();

		}catch (\Exception $e){

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
	public function deleteAllDataLibrary(){

		DB::beginTransaction();

		try{

			$response = DataLibrary::whereNull('deleted_at')->delete();

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
	public function insertDataLibraryCollection($data){

		DB::beginTransaction();

		try{

			$response = DataLibrary::insert($data);

		} catch(\Exception $e){
			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return true;
	}
}