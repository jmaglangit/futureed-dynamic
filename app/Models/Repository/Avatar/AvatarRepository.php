<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 3/6/15
 * Time: 11:30 AM
 */
namespace FutureEd\Models\Repository\Avatar;

use FutureEd\Models\Core\Avatar;
use FutureEd\Models\Core\User;
use FutureEd\Models\Traits\LoggerTrait;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\DB;

class AvatarRepository implements AvatarRepositoryInterface{

	use LoggerTrait;

	public function getAvatars($gender,$count){

		DB::beginTransaction();

		try{
			$response = Avatar::where('gender','=', $gender)->get();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function getAvatar($avatar_id){

		DB::beginTransaction();

		try{
			$response = Avatar::where('id','=',$avatar_id)->get()->first();

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

	public function checkAvatarExist($avatar_id){

		DB::beginTransaction();

		try{
			$response = Avatar::where('id','=',$avatar_id)->pluck('id');

		}catch (\Exception $e){

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
	}

}