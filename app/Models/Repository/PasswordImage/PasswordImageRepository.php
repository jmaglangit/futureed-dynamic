<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 3/17/15
 * Time: 10:35 AM
 */

namespace FutureEd\Models\Repository\PasswordImage;

use FutureEd\Models\Core\PasswordImage;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;


class PasswordImageRepository implements PasswordImageRepositoryInterface{

    use LoggerTrait;

	/**
     * @param $id
     * @return bool
     */
    public function getImage($id){

        DB::beginTransaction();

        try {

            $response = PasswordImage::select(
                'id',
                'name',
                'password_image_file as url'
            )->where('id', '=', $id)->get();

        } catch (\Exception $e) {

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
    public function getImages(){

        DB::beginTransaction();

        try {

            $response = PasswordImage::select(
                'id',
                'name',
                'password_image_file as url'
            )->get();

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * @param int $count
     * @param $id
     * @return bool
     */
    public function getRandomImageId($count = 1, $id){

        DB::beginTransaction();

        try {
            $response = PasswordImage::select(
                'id',
                'name',
                'password_image_file as url'
            )->where('id', '<>', $id)->get()->random($count);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }

	/**
     * @param int $count
     * @return bool
     */
    public function getRandomImage($count = 1){

        DB::beginTransaction();

        try {

            $response = PasswordImage::select(
                'id',
                'name',
                'password_image_file as url'
            )->get()->random($count);

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;

    }

	/**
     * @param $id
     * @return bool
     */
    public function checkPasswordExist($id){

        DB::beginTransaction();

        try {

            $response = PasswordImage::where('id', $id)->pluck('id');

        } catch (\Exception $e) {

            DB::rollback();

            $this->errorLog($e->getMessage());

            return false;
        }

        DB::commit();

        return $response;
    }


}